<?php

namespace App\Services;

/**
 * Service to log all SQL queries executed during a request.
 * 
 * This service captures queries via DB::listen() and stores them
 * with metadata (SQL, bindings, execution time, and a human-readable description).
 * Duplicate queries are merged and their execution count is tracked.
 */
class QueryLoggerService
{
    /**
     * Array of unique logged queries for the current request.
     * Key is the SQL statement, value contains: sql, bindings, time, description, count
     */
    protected array $queries = [];

    /**
     * Add a query to the log. If the same SQL already exists, increment count and add time.
     *
     * @param string $sql
     * @param array $bindings
     * @param float $time
     * @return void
     */
    public function logQuery(string $sql, array $bindings, float $time): void
    {
        // Use SQL as key to detect duplicates
        $key = $sql;
        
        if (isset($this->queries[$key])) {
            // Query already exists - increment count and add to total time
            $this->queries[$key]['count']++;
            $this->queries[$key]['total_time'] += $time;
            $this->queries[$key]['avg_time'] = $this->queries[$key]['total_time'] / $this->queries[$key]['count'];
            
            // Keep track of all bindings if they differ
            if ($bindings !== $this->queries[$key]['bindings']) {
                if (!isset($this->queries[$key]['all_bindings'])) {
                    $this->queries[$key]['all_bindings'] = [$this->queries[$key]['bindings']];
                }
                $this->queries[$key]['all_bindings'][] = $bindings;
            }
        } else {
            // New unique query
            $this->queries[$key] = [
                'sql' => $sql,
                'bindings' => $bindings,
                'time' => $time,
                'total_time' => $time,
                'avg_time' => $time,
                'count' => 1,
                'description' => $this->generateDescription($sql),
            ];
        }
    }

    /**
     * Get all unique logged queries.
     *
     * @return array
     */
    public function getQueries(): array
    {
        // Return values only (remove keys which are SQL statements)
        return array_values($this->queries);
    }

    /**
     * Store queries in session to persist across redirects.
     * This allows action queries (POST requests) to be visible after redirect (GET request).
     *
     * @return void
     */
    public function storeInSession(): void
    {
        if (count($this->queries) > 0) {
            // Use regular session put instead of flash to ensure persistence
            session()->put('_sql_queries', $this->queries);
        }
    }

    /**
     * Load queries from previous request (if available in session) and merge with current queries.
     *
     * @return void
     */
    public function loadFromSession(): void
    {
        if (session()->has('_sql_queries')) {
            $previousQueries = session()->get('_sql_queries', []);
            
            // Clear the session data immediately to prevent showing old queries
            session()->forget('_sql_queries');
            
            // Merge previous queries with current ones
            foreach ($previousQueries as $sql => $queryData) {
                if (isset($this->queries[$sql])) {
                    // Query exists in both - merge counts and times
                    $this->queries[$sql]['count'] += $queryData['count'];
                    $this->queries[$sql]['total_time'] += $queryData['total_time'];
                    $this->queries[$sql]['avg_time'] = $this->queries[$sql]['total_time'] / $this->queries[$sql]['count'];
                } else {
                    // Add previous query to current list
                    $this->queries[$sql] = $queryData;
                }
            }
        }
    }

    /**
     * Generate a human-readable description for a SQL query.
     * This analyzes the SQL statement and provides context about what it does.
     *
     * @param string $sql
     * @return string
     */
    protected function generateDescription(string $sql): string
    {
        $sql = trim($sql);
        $upperSql = strtoupper($sql);

        // SELECT queries
        if (strpos($upperSql, 'SELECT') === 0) {
            if (stripos($sql, 'FROM users') !== false) {
                if (stripos($sql, 'WHERE') !== false) {
                    return 'Fetching specific user(s) from the database';
                }
                if (stripos($sql, 'ORDER BY') !== false) {
                    return 'Fetching and ordering users (e.g., for leaderboard or listing)';
                }
                return 'Fetching users from the database';
            }

            if (stripos($sql, 'FROM problems') !== false) {
                if (stripos($sql, 'WHERE') !== false) {
                    return 'Fetching specific problem(s) from the database';
                }
                if (stripos($sql, 'ORDER BY') !== false) {
                    return 'Fetching and ordering problems (e.g., for problem list)';
                }
                return 'Fetching problems from the database';
            }

            if (stripos($sql, 'FROM userproblems') !== false) {
                return 'Fetching user problem progress/status data';
            }

            if (stripos($sql, 'FROM editorials') !== false) {
                return 'Fetching editorial(s) for problems';
            }

            if (stripos($sql, 'FROM tags') !== false) {
                return 'Fetching problem tags/categories';
            }

            if (stripos($sql, 'FROM problemtags') !== false) {
                return 'Fetching problem-tag relationships';
            }

            if (stripos($sql, 'FROM friends') !== false) {
                return 'Fetching friend relationships between users';
            }

            if (stripos($sql, 'COUNT(*)') !== false) {
                return 'Counting records for aggregation or pagination';
            }

            if (stripos($sql, 'AVG(') !== false || stripos($sql, 'SUM(') !== false) {
                return 'Calculating aggregate statistics (average, sum, etc.)';
            }

            if (stripos($sql, 'JOIN') !== false) {
                return 'Fetching data from multiple related tables';
            }

            return 'Fetching data from the database';
        }

        // INSERT queries
        if (strpos($upperSql, 'INSERT') === 0) {
            if (stripos($sql, 'INTO users') !== false) {
                return 'Creating a new user account';
            }
            if (stripos($sql, 'INTO problems') !== false) {
                return 'Adding a new problem to the database';
            }
            if (stripos($sql, 'INTO userproblems') !== false) {
                return 'Recording user progress on a problem';
            }
            if (stripos($sql, 'INTO editorials') !== false) {
                return 'Creating a new editorial for a problem';
            }
            if (stripos($sql, 'INTO tags') !== false) {
                return 'Creating a new tag/category';
            }
            if (stripos($sql, 'INTO friends') !== false) {
                return 'Creating a friend relationship between users';
            }
            return 'Inserting new data into the database';
        }

        // UPDATE queries
        if (strpos($upperSql, 'UPDATE') === 0) {
            if (stripos($sql, 'users') !== false) {
                if (stripos($sql, 'cf_max_rating') !== false) {
                    return 'Updating user Codeforces rating data';
                }
                if (stripos($sql, 'handle_verified_at') !== false) {
                    return 'Marking user Codeforces handle as verified';
                }
                if (stripos($sql, 'role') !== false) {
                    return 'Updating user role/permissions';
                }
                if (stripos($sql, 'profile_picture') !== false || stripos($sql, 'bio') !== false) {
                    return 'Updating user profile information';
                }
                return 'Updating user information';
            }
            if (stripos($sql, 'problems') !== false) {
                return 'Updating problem information';
            }
            if (stripos($sql, 'userproblems') !== false) {
                return 'Updating user problem status/progress';
            }
            if (stripos($sql, 'editorials') !== false) {
                return 'Updating editorial content';
            }
            if (stripos($sql, 'tags') !== false) {
                return 'Updating tag/category information';
            }
            return 'Updating data in the database';
        }

        // DELETE queries
        if (strpos($upperSql, 'DELETE') === 0) {
            if (stripos($sql, 'FROM users') !== false) {
                return 'Deleting a user account (possibly due to invalid Codeforces handle)';
            }
            if (stripos($sql, 'FROM problems') !== false) {
                return 'Deleting a problem from the database';
            }
            if (stripos($sql, 'FROM userproblems') !== false) {
                return 'Removing user problem progress data';
            }
            if (stripos($sql, 'FROM editorials') !== false) {
                return 'Deleting an editorial';
            }
            if (stripos($sql, 'FROM tags') !== false) {
                return 'Deleting a tag/category';
            }
            if (stripos($sql, 'FROM friends') !== false) {
                return 'Removing a friend relationship';
            }
            return 'Deleting data from the database';
        }

        return 'Executing a database operation';
    }

    /**
     * Clear all logged queries (useful for testing or resetting between requests).
     *
     * @return void
     */
    public function clear(): void
    {
        $this->queries = [];
    }
}
