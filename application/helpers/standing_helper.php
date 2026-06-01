<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Alumni Standing Helper
 * Determines standing title and badge styling based on alumni score
 */

/**
 * Get Standing Title and Badge Information
 * 
 * Returns title, badge class, and styling based on alumni standing score
 * 
 * Points Ranges:
 * - < 0: 'Restricted' (danger/dark)
 * - 0-99: 'Junior Alum' (warning)
 * - 100-499: 'Active Alum' (info)
 * - 500-999: 'Senior Contributor' (success)
 * - 1000+: 'Distinguished Alum' (primary/gold)
 * 
 * @param int $score The alumni standing score
 * @return array Array with keys: 'title', 'badge_class', 'icon'
 */
function get_standing_badge($score)
{
    if ($score < 0) {
        return [
            'title' => 'Restricted',
            'badge_class' => 'badge badge-danger',
            'icon' => 'fas fa-ban',
            'description' => 'Account restricted due to violations'
        ];
    } elseif ($score < 100) {
        return [
            'title' => 'Junior Alum',
            'badge_class' => 'badge badge-warning',
            'icon' => 'fas fa-seedling',
            'description' => 'New to the community'
        ];
    } elseif ($score < 500) {
        return [
            'title' => 'Active Alum',
            'badge_class' => 'badge badge-info',
            'icon' => 'fas fa-star',
            'description' => 'Regular community contributor'
        ];
    } elseif ($score < 1000) {
        return [
            'title' => 'Senior Contributor',
            'badge_class' => 'badge badge-success',
            'icon' => 'fas fa-trophy',
            'description' => 'Highly valued contributor'
        ];
    } else {
        return [
            'title' => 'Distinguished Alum',
            'badge_class' => 'badge badge-primary',
            'icon' => 'fas fa-crown',
            'description' => 'Most respected community member'
        ];
    }
}

/**
 * Get Bootstrap Badge Color Class for a Score
 * Alias for backward compatibility
 * 
 * @param int $score The alumni standing score
 * @return string Bootstrap badge class
 */
function get_standing_badge_class($score)
{
    $badge = get_standing_badge($score);
    return $badge['badge_class'];
}

/**
 * Get Standing Title for a Score
 * 
 * @param int $score The alumni standing score
 * @return string Standing title
 */
function get_standing_title($score)
{
    $badge = get_standing_badge($score);
    return $badge['title'];
}
