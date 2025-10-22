<?php

namespace App\Helpers;

class RatingHelper
{
    /**
     * Get rating class based on official Codeforces rating system
     * 
     * @param int $rating User rating
     * @return string CSS class name
     */
    public static function getRatingClass($rating)
    {
        if ($rating >= 3000) {
            return 'rating-legendary';
        } elseif ($rating >= 2600) {
            return 'rating-international-grandmaster';
        } elseif ($rating >= 2400) {
            return 'rating-grandmaster';
        } elseif ($rating >= 2300) {
            return 'rating-international-master';
        } elseif ($rating >= 2100) {
            return 'rating-master';
        } elseif ($rating >= 1900) {
            return 'rating-candidate-master';
        } elseif ($rating >= 1600) {
            return 'rating-expert';
        } elseif ($rating >= 1400) {
            return 'rating-specialist';
        } elseif ($rating >= 1200) {
            return 'rating-pupil';
        } else {
            return 'rating-newbie';
        }
    }

    /**
     * Get rating text color class
     * 
     * @param int $rating User rating
     * @return string CSS class name for text color
     */
    public static function getRatingTextClass($rating)
    {
        if ($rating >= 3000) {
            return 'rating-text-legendary';
        } elseif ($rating >= 2400) {
            return 'rating-text-grandmaster';
        } elseif ($rating >= 2100) {
            return 'rating-text-master';
        } elseif ($rating >= 1900) {
            return 'rating-text-candidate';
        } elseif ($rating >= 1600) {
            return 'rating-text-expert';
        } elseif ($rating >= 1400) {
            return 'rating-text-specialist';
        } elseif ($rating >= 1200) {
            return 'rating-text-pupil';
        } else {
            return 'rating-text-newbie';
        }
    }

    /**
     * Get rating dot class for indicators
     * 
     * @param int $rating User rating
     * @return string CSS class name for dot
     */
    public static function getRatingDotClass($rating)
    {
        if ($rating >= 3000) {
            return 'rating-dot-legendary';
        } elseif ($rating >= 2400) {
            return 'rating-dot-grandmaster';
        } elseif ($rating >= 2100) {
            return 'rating-dot-master';
        } elseif ($rating >= 1900) {
            return 'rating-dot-candidate';
        } elseif ($rating >= 1600) {
            return 'rating-dot-expert';
        } elseif ($rating >= 1400) {
            return 'rating-dot-specialist';
        } elseif ($rating >= 1200) {
            return 'rating-dot-pupil';
        } else {
            return 'rating-dot-newbie';
        }
    }

    /**
     * Get rating rank/title name (Official Codeforces)
     * 
     * @param int $rating User rating
     * @return string Rank title
     */
    public static function getRatingTitle($rating)
    {
        if ($rating >= 3000) {
            return 'Legendary Grandmaster';
        } elseif ($rating >= 2600) {
            return 'International Grandmaster';
        } elseif ($rating >= 2400) {
            return 'Grandmaster';
        } elseif ($rating >= 2300) {
            return 'International Master';
        } elseif ($rating >= 2100) {
            return 'Master';
        } elseif ($rating >= 1900) {
            return 'Candidate Master';
        } elseif ($rating >= 1600) {
            return 'Expert';
        } elseif ($rating >= 1400) {
            return 'Specialist';
        } elseif ($rating >= 1200) {
            return 'Pupil';
        } else {
            return 'Newbie';
        }
    }

    /**
     * Get rating color hex code (Official Codeforces Colors)
     * 
     * @param int $rating User rating
     * @return string Hex color code
     */
    public static function getRatingColor($rating)
    {
        if ($rating >= 3000) {
            return '#FF0000'; // Red - Legendary Grandmaster
        } elseif ($rating >= 2600) {
            return '#FF0000'; // Red - International Grandmaster
        } elseif ($rating >= 2400) {
            return '#FF0000'; // Red - Grandmaster
        } elseif ($rating >= 2300) {
            return '#FF8C00'; // Orange - International Master
        } elseif ($rating >= 2100) {
            return '#FF8C00'; // Orange - Master
        } elseif ($rating >= 1900) {
            return '#AA00AA'; // Violet - Candidate Master
        } elseif ($rating >= 1600) {
            return '#0000FF'; // Blue - Expert
        } elseif ($rating >= 1400) {
            return '#03A89E'; // Cyan - Specialist
        } elseif ($rating >= 1200) {
            return '#008000'; // Green - Pupil
        } else {
            return '#808080'; // Gray - Newbie
        }
    }

    /**
     * Get rating background color with opacity
     * 
     * @param int $rating User rating
     * @return string RGBA color code
     */
    public static function getRatingBgColor($rating)
    {
        if ($rating >= 3000) {
            return 'rgba(255, 0, 0, 0.1)';
        } elseif ($rating >= 2600) {
            return 'rgba(255, 0, 0, 0.1)';
        } elseif ($rating >= 2400) {
            return 'rgba(255, 0, 0, 0.1)';
        } elseif ($rating >= 2300) {
            return 'rgba(255, 140, 0, 0.1)';
        } elseif ($rating >= 2100) {
            return 'rgba(255, 140, 0, 0.1)';
        } elseif ($rating >= 1900) {
            return 'rgba(170, 0, 170, 0.1)';
        } elseif ($rating >= 1600) {
            return 'rgba(0, 0, 255, 0.1)';
        } elseif ($rating >= 1400) {
            return 'rgba(3, 168, 158, 0.1)';
        } elseif ($rating >= 1200) {
            return 'rgba(0, 128, 0, 0.1)';
        } else {
            return 'rgba(128, 128, 128, 0.1)';
        }
    }

    /**
     * Get Bootstrap badge class for rating
     * 
     * @param int $rating User rating
     * @return string Bootstrap badge class
     */
    public static function getRatingBadgeClass($rating)
    {
        // Return inline style instead since we're using custom colors
        $color = self::getRatingColor($rating);
        return "style='background: $color; color: white;'";
    }
}
