<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestController extends Controller
{
    /**
     * Show the SQL Query Builder interface
     */
    public function index()
    {
        $tables = $this->getTablesWithAliases();
        
        return view('navigation.quest', compact('tables'));
    }

    /**
     * Get columns for selected tables (AJAX endpoint)
     */
    public function getColumnsForTables(Request $request)
    {
        $validated = $request->validate([
            'tables' => 'required|array|min:1',
            'tables.*' => 'required|string',
        ]);

        $allTables = $this->getTablesWithAliases();
        $selectedTableNames = $validated['tables'];
        
        // Filter to only selected tables
        $selectedTables = array_filter($allTables, function($alias, $table) use ($selectedTableNames) {
            return in_array($table, $selectedTableNames);
        }, ARRAY_FILTER_USE_BOTH);
        
        $columns = $this->getAllColumns($selectedTables);
        
        return response()->json([
            'columns' => $columns,
            'tables' => $selectedTables,
        ]);
    }

    /**
     * Derive a friendly column label for display from the selected column expression
     */
    private function getColumnLabel($col)
    {
        $colLower = strtolower($col);
        // if user provided an alias using ' as '
        if (stripos($colLower, ' as ') !== false) {
            $parts = preg_split('/\s+as\s+/i', $col);
            return trim(end($parts));
        }

        // if column contains a dot (alias.column)
        if (strpos($col, '.') !== false) {
            $parts = explode('.', $col);
            return end($parts);
        }

        // if it's a function like COUNT(...)
        if (preg_match('/([A-Z]+)\(/i', $col, $m)) {
            return trim($col);
        }

        return $col;
    }

    /**
     * Execute the SQL SELECT query
     */
    public function executeQuery(Request $request)
    {
        $validated = $request->validate([
            'tables' => 'required|string', // JSON string now
            'columns' => 'required|string', // JSON string now
            'where_clause' => 'nullable|string|max:1000',
            'order_by' => 'nullable|string|max:500',
            'order_direction' => 'nullable|string|in:ASC,DESC',
        ]);

        try {
            // Parse JSON inputs
            $selectedTableNames = json_decode($validated['tables'], true);
            $selectedColumns = json_decode($validated['columns'], true);
            
            if (!is_array($selectedTableNames) || !is_array($selectedColumns)) {
                throw new \Exception('Invalid table or column selection');
            }
            
            // Validate column count (limit to 5 now)
            if (count($selectedColumns) > 5) {
                throw new \Exception('Maximum 5 columns allowed');
            }
            
            // Get table mappings
            $allTables = $this->getTablesWithAliases();
            $selectedTables = array_filter($allTables, function($alias, $table) use ($selectedTableNames) {
                return in_array($table, $selectedTableNames);
            }, ARRAY_FILTER_USE_BOTH);
            
            if (empty($selectedTables)) {
                throw new \Exception('No valid tables selected');
            }
            
            // Build the FROM clause with selected tables
            $fromClause = $this->buildFromClause($selectedTables);
            
            // Build SELECT clause
            $selectFragments = [];
            foreach ($selectedColumns as $i => $col) {
                $san = $this->sanitizeColumnName($col);
                $selectFragments[] = $san;
            }
            $columnsStr = implode(', ', $selectFragments);
            
            // Build the complete query
            $query = "SELECT {$columnsStr} FROM {$fromClause}";
            
            // Add WHERE clause
            if (!empty($validated['where_clause'])) {
                $query .= " WHERE " . $validated['where_clause'];
            }
            
            // Add ORDER BY clause
            if (!empty($validated['order_by'])) {
                $direction = $validated['order_direction'] ?? 'ASC';
                $orderColumn = $this->sanitizeColumnName($validated['order_by']);
                $query .= " ORDER BY {$orderColumn} {$direction}";
            }
            
            // Add LIMIT for performance (we'll handle pagination on frontend)
            $query .= " LIMIT 1000";
            
            // Execute the query using raw SQL
            $results = DB::select($query);
            
            // Convert to array for JSON response
            $resultsArray = array_map(function($item) {
                return (array) $item;
            }, $results);
            
            // Return JSON response for AJAX
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'results' => $resultsArray,
                    'query' => $query,
                    'count' => count($resultsArray)
                ]);
            }
            
            // For non-AJAX requests, return view with results
            $tables = $this->getTablesWithAliases();
            return view('navigation.quest', compact('tables', 'results', 'query'))
                ->with('success', 'Query executed successfully!');
            
        } catch (\Exception $e) {
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'error' => $e->getMessage()
                ], 400);
            }
            
            $tables = $this->getTablesWithAliases();
            return view('navigation.quest', compact('tables'))
                ->withErrors(['query_error' => 'SQL Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Get all database tables with their 1-2 letter aliases
     */
    private function getTablesWithAliases()
    {
        $tables = [
            'users' => 'U',
            'problems' => 'P',
            'tags' => 'T',
            'problemtags' => 'PT',
            'userproblems' => 'UP',
            'editorials' => 'E',
        ];
        
        return $tables;
    }

    /**
     * Get all columns from all tables with their aliases using raw SQL
     */
    private function getAllColumns($tables)
    {
        $columns = [];
        $database = env('DB_DATABASE', 'codequest');
        
        foreach ($tables as $tableName => $alias) {
            // Use raw SQL to get column information
            $tableColumns = DB::select("
                SELECT COLUMN_NAME 
                FROM INFORMATION_SCHEMA.COLUMNS 
                WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?
                ORDER BY ORDINAL_POSITION
            ", [$database, $tableName]);
            
            foreach ($tableColumns as $colInfo) {
                $column = $colInfo->COLUMN_NAME;
                $columns[] = [
                    'full' => "{$alias}.{$column}",
                    'display' => "{$alias}.{$column} ({$tableName}.{$column})",
                    'table' => $tableName,
                    'column' => $column,
                    'alias' => $alias,
                ];
            }
        }
        
        return $columns;
    }

    /**
     * Build the FROM clause with selected table joins
     */
    private function buildFromClause($selectedTables)
    {
        if (empty($selectedTables)) {
            return "users u";
        }
        
        $tableNames = array_keys($selectedTables);
        
        // Start with the first selected table as base
        $baseTable = $tableNames[0];
        $baseAlias = $selectedTables[$baseTable];
        $from = "{$baseTable} {$baseAlias}";
        
        // Join remaining tables intelligently
        for ($i = 1; $i < count($tableNames); $i++) {
            $table = $tableNames[$i];
            $alias = $selectedTables[$table];
            
            // Determine join conditions based on table relationships
            $joinCondition = $this->getJoinCondition($table, $alias, $selectedTables);
            $from .= " LEFT JOIN {$table} {$alias} ON {$joinCondition}";
        }
        
        return $from;
    }

    /**
     * Get appropriate join condition for a table
     */
    private function getJoinCondition($table, $alias, $selectedTables)
    {
        // Define relationships between tables
        $relationships = [
            'problems' => '1=1', // Cartesian if standalone
            'tags' => '1=1',
            'problemtags' => 'pt.problem_id = p.problem_id AND pt.tag_id = t.tag_id',
            'userproblems' => 'up.user_id = u.user_id AND up.problem_id = p.problem_id',
            'editorials' => 'e.problem_id = p.problem_id AND e.author_id = u.user_id',
            'friends' => '(f.user_id = u.user_id OR f.friend_id = u.user_id)',
        ];
        
        // Check if required tables for the join are selected
        switch ($table) {
            case 'problemtags':
                if (isset($selectedTables['problems']) && isset($selectedTables['tags'])) {
                    return $relationships[$table];
                }
                return '1=1';
                
            case 'userproblems':
                if (isset($selectedTables['users']) && isset($selectedTables['problems'])) {
                    return $relationships[$table];
                }
                if (isset($selectedTables['users'])) {
                    return 'up.user_id = u.user_id';
                }
                if (isset($selectedTables['problems'])) {
                    return 'up.problem_id = p.problem_id';
                }
                return '1=1';
                
            case 'editorials':
                if (isset($selectedTables['problems']) && isset($selectedTables['users'])) {
                    return $relationships[$table];
                }
                if (isset($selectedTables['problems'])) {
                    return 'e.problem_id = p.problem_id';
                }
                if (isset($selectedTables['users'])) {
                    return 'e.author_id = u.user_id';
                }
                return '1=1';
                
            case 'friends':
                if (isset($selectedTables['users'])) {
                    return $relationships[$table];
                }
                return '1=1';
                
            default:
                return isset($relationships[$table]) ? $relationships[$table] : '1=1';
        }
    }    /**
     * Sanitize column names to prevent SQL injection
     */
    private function sanitizeColumnName($column)
    {
        // Only allow alphanumeric, dots, underscores, and common SQL functions
        if (preg_match('/^[a-zA-Z0-9_\.]+(\([a-zA-Z0-9_\.\*\,\s]+\))?( as [a-zA-Z0-9_]+)?$/i', $column)) {
            return $column;
        }
        
        throw new \Exception("Invalid column name: {$column}");
    }
}
