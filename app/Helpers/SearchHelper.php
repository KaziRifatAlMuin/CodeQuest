<?php

namespace App\Helpers;

class SearchHelper
{
    /**
     * Highlight search terms in text
     * 
     * @param string $text The text to search in
     * @param string $search The search term
     * @return string HTML with highlighted matches
     */
    public static function highlight($text, $search)
    {
        if (empty($search) || empty($text)) {
            return $text;
        }

        $search = trim($search);
        if (strlen($search) === 0) {
            return $text;
        }

        // Escape special regex characters
        $pattern = '/' . preg_quote($search, '/') . '/i';
        
        // Replace with highlighted version
        return preg_replace($pattern, '<mark class="search-highlight">$0</mark>', $text);
    }

    /**
     * Build search query conditions
     * 
     * @param string $search The search term
     * @param array $fields Fields to search in
     * @return array [conditions, params]
     */
    public static function buildSearchConditions($search, $fields)
    {
        if (empty($search) || empty($fields)) {
            return ['', []];
        }

        $conditions = [];
        $params = [];
        
        foreach ($fields as $field) {
            $conditions[] = "$field LIKE ?";
            $params[] = "%{$search}%";
        }

        $whereClause = '(' . implode(' OR ', $conditions) . ')';
        
        return [$whereClause, $params];
    }

    /**
     * Get pagination options
     * 
     * @return array Available per-page options
     */
    public static function getPaginationOptions()
    {
        return [10, 25, 50, 100];
    }

    /**
     * Get validated per-page value
     * 
     * @param mixed $value User requested value
     * @param int $default Default value
     * @return int Valid per-page value
     */
    public static function getPerPage($value, $default = 25)
    {
        $options = self::getPaginationOptions();
        $value = (int) $value;
        
        return in_array($value, $options) ? $value : $default;
    }

    /**
     * Generate SQL LIKE pattern for full-text search
     * 
     * @param string $search The search term
     * @return string The LIKE pattern
     */
    public static function getLikePattern($search)
    {
        return '%' . str_replace(['%', '_'], ['\%', '\_'], $search) . '%';
    }

    /**
     * Split search query into words for multi-word search
     * 
     * @param string $search The search term
     * @return array Array of search words
     */
    public static function splitSearchTerms($search)
    {
        return array_filter(array_map('trim', explode(' ', $search)));
    }
}
