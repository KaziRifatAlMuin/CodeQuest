<?php

namespace App\Helpers;

class RatingHelper
{
    /**
     * Get rating class based on Codeforces-style rating system
     * 
     * @param int $rating User rating
     * @return string CSS class name
     */
    public static function getRatingClass($rating)
    {
        if ($rating >= 3000) {
            return 'rating-legendary';
        } elseif ($rating >= 2400) {
            return 'rating-grandmaster';
        } elseif ($rating >= 2100) {
            return 'rating-master';
        } elseif ($rating >= 1900) {
            return 'rating-candidate';
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
     * Get rating rank/title name
     * 
     * @param int $rating User rating
     * @return string Rank title
     */
    public static function getRatingTitle($rating)
    {
        if ($rating >= 3000) {
            return 'Legendary Grandmaster';
        } elseif ($rating >= 2400) {
            return 'International Grandmaster';
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
     * Get rating color hex code
     * 
     * @param int $rating User rating
     * @return string Hex color code
     */
    public static function getRatingColor($rating)
    {
        if ($rating >= 3000) {
            return '#ff0000';
        } elseif ($rating >= 2400) {
            return '#ff3333';
        } elseif ($rating >= 2100) {
            return '#ff8c00';
        } elseif ($rating >= 1900) {
            return '#aa00aa';
        } elseif ($rating >= 1600) {
            return '#0000ff';
        } elseif ($rating >= 1400) {
            return '#03a89e';
        } elseif ($rating >= 1200) {
            return '#008000';
        } else {
            return '#808080';
        }
    }

    /**
     * Get rating light background class (for strong tags in tables)
     * 
     * @param int $rating User rating
     * @return string CSS class name for light background
     */
    public static function getRatingBgClass($rating)
    {
        if ($rating >= 3000) {
            return 'rating-bg-legendary';
        } elseif ($rating >= 2400) {
            return 'rating-bg-grandmaster';
        } elseif ($rating >= 2100) {
            return 'rating-bg-master';
        } elseif ($rating >= 1900) {
            return 'rating-bg-candidate';
        } elseif ($rating >= 1600) {
            return 'rating-bg-expert';
        } elseif ($rating >= 1400) {
            return 'rating-bg-specialist';
        } elseif ($rating >= 1200) {
            return 'rating-bg-pupil';
        } else {
            return 'rating-bg-newbie';
        }
    }
}
