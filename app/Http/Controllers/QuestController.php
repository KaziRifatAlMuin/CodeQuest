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
        $columns = $this->getAllColumns($tables);
        
        return view('navigation.quest', compact('tables', 'columns'));
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
            'columns' => 'required|array|max:6',
            'columns.*' => 'required|string',
            'where_clause' => 'nullable|string|max:1000',
            'group_by' => 'nullable|string|max:500',
            'having_clause' => 'nullable|string|max:500',
            'order_by' => 'nullable|string|max:500',
            'limit' => 'nullable|integer|min:1|max:1000',
            'distinct' => 'nullable|boolean',
        ]);

        try {
            // Get table aliases
            $tables = $this->getTablesWithAliases();
            
            // Build the FROM clause with all joins
            $fromClause = $this->buildFromClause($tables);
            
            // Sanitize and prepare column selections
            $selectedColumns = array_slice($validated['columns'], 0, 6);
            $selectFragments = [];
            $selectedAliases = []; // e.g. c1, c2 ... to map result object properties
            $selectedColumnLabels = [];
            foreach ($selectedColumns as $i => $col) {
                $san = $this->sanitizeColumnName($col);
                $alias = 'c' . ($i + 1);
                $selectFragments[] = "{$san} AS `{$alias}`";
                $selectedAliases[] = $alias;
                $selectedColumnLabels[] = $this->getColumnLabel($col);
            }
            $columnsStr = implode(', ', $selectFragments);
            
            // Build the complete query (support DISTINCT)
            $selectPrefix = !empty($validated['distinct']) ? 'SELECT DISTINCT' : 'SELECT';
            $query = "{$selectPrefix} {$columnsStr} FROM {$fromClause}";
            
            // Add WHERE clause
            if (!empty($validated['where_clause'])) {
                $query .= " WHERE " . $validated['where_clause'];
            }
            
            // Add GROUP BY clause
            if (!empty($validated['group_by'])) {
                $query .= " GROUP BY " . $validated['group_by'];
            }
            
            // Add HAVING clause
            if (!empty($validated['having_clause'])) {
                $query .= " HAVING " . $validated['having_clause'];
            }
            
            // Add ORDER BY clause
            if (!empty($validated['order_by'])) {
                $query .= " ORDER BY " . $validated['order_by'];
            }
            
            // Add LIMIT
            $limit = $validated['limit'] ?? 100;
            $query .= " LIMIT {$limit}";
            
            // Execute the query using raw SQL
            $results = DB::select($query);
            
            $tables = $this->getTablesWithAliases();
            $columns = $this->getAllColumns($tables);
            
            $distinctFlag = !empty($validated['distinct']);
            return view('navigation.quest', compact('tables', 'columns', 'results', 'query', 'selectedColumns', 'selectedAliases', 'selectedColumnLabels', 'distinctFlag'));
            
        } catch (\Exception $e) {
            $tables = $this->getTablesWithAliases();
            $columns = $this->getAllColumns($tables);
            
            return view('navigation.quest', compact('tables', 'columns'))
                ->withErrors(['query_error' => 'SQL Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Get all database tables with their 1-2 letter aliases
     */
    private function getTablesWithAliases()
    {
        $tables = [
            'users' => 'u',
            'problems' => 'p',
            'tags' => 't',
            'problemtags' => 'pt',
            'userproblems' => 'up',
            'editorials' => 'e',
            'friends' => 'f',
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
     * Build the FROM clause with all table joins
     */
    private function buildFromClause($tables)
    {
        // Start with users as the base table
        $from = "users u";
        
        // Left join all other tables
        $from .= " LEFT JOIN problems p ON 1=1";
        $from .= " LEFT JOIN tags t ON 1=1";
        $from .= " LEFT JOIN problemtags pt ON pt.problem_id = p.problem_id AND pt.tag_id = t.tag_id";
        $from .= " LEFT JOIN userproblems up ON up.user_id = u.user_id AND up.problem_id = p.problem_id";
    // editorials table uses author_id to reference users
    $from .= " LEFT JOIN editorials e ON e.problem_id = p.problem_id AND e.author_id = u.user_id";
        $from .= " LEFT JOIN friends f ON (f.user_id = u.user_id OR f.friend_id = u.user_id)";
        
        return $from;
    }

    /**
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
