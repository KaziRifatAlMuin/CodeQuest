<?php

namespace App\Helpers;

class DifficultyHelper
{
    /**
     * Get difficulty class based on problem difficulty
     * 
     * @param string $difficulty Problem difficulty (Easy/Medium/Hard)
     * @return string CSS class name
     */
    public static function getDifficultyClass($difficulty)
    {
        return match(strtolower($difficulty)) {
            'easy' => 'difficulty-easy',
            'medium' => 'difficulty-medium',
            'hard' => 'difficulty-hard',
            default => 'difficulty-medium'
        };
    }

    /**
     * Get difficulty color hex code
     * 
     * @param string $difficulty Problem difficulty
     * @return string Hex color code
     */
    public static function getDifficultyColor($difficulty)
    {
        return match(strtolower($difficulty)) {
            'easy' => '#10b981',
            'medium' => '#f59e0b',
            'hard' => '#ef4444',
            default => '#6b7280'
        };
    }

    /**
     * Get lighter version of difficulty color for backgrounds
     * 
     * @param string $difficulty Problem difficulty
     * @return string RGBA color code
     */
    public static function getDifficultyLightBg($difficulty)
    {
        return match(strtolower($difficulty)) {
            'easy' => 'rgba(16, 185, 129, 0.1)',
            'medium' => 'rgba(245, 158, 11, 0.1)',
            'hard' => 'rgba(239, 68, 68, 0.1)',
            default => 'rgba(107, 114, 128, 0.1)'
        };
    }
}
