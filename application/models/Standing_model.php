<?php

class Standing_model extends CI_Model {

    /**
     * Get Alumni Standing Score
     * 
     * Calculates total karma/standing points based on forum activity:
     * - Forum post created: +5 points
     * - Like received on post: +2 points
     * - Dislike received on post: -1 point
     * - Comment posted: +1 point
     * - Like received on comment: +1 point
     * - Dislike received on comment: -0.5 point
     * - Post reported: -10 points per report
     * - Toxic content (slurs/hate speech): -50 points per post
     * 
     * @param int $alumni_id The alumni ID
     * @return int Total standing score
     */
    public function get_standing_score($alumni_id)
    {
        if (!$alumni_id) {
            return 0;
        }

        $score = 0;

        // 1. Calculate points from posts created (+5 per post)
        $this->db->reset_query();
        $query = $this->db->where('alumni_id', $alumni_id)->get('forum_posts');
        $posts = $query->result();
        $post_count = count($posts);
        $score += ($post_count * 5);

        if ($post_count == 0) {
            return 0; // No posts means no points
        }

        // 2. Calculate points from likes received (+2 per like on posts)
        $this->db->reset_query();
        $this->db->select('COUNT(*) as like_total');
        $this->db->from('forum_likes');
        $this->db->join('forum_posts', 'forum_likes.post_id = forum_posts.id', 'inner');
        $this->db->where('forum_posts.alumni_id', $alumni_id);
        $like_result = $this->db->get()->row();
        $like_count = (isset($like_result->like_total) && $like_result->like_total) ? intval($like_result->like_total) : 0;
        $score += ($like_count * 2);

        // 3. Calculate points from dislikes received (-1 per dislike on posts)
        $this->db->reset_query();
        $this->db->select('COUNT(*) as dislike_total');
        $this->db->from('forum_dislike');
        $this->db->join('forum_posts', 'forum_dislike.post_id = forum_posts.id', 'inner');
        $this->db->where('forum_posts.alumni_id', $alumni_id);
        $dislike_result = $this->db->get()->row();
        $dislike_count = (isset($dislike_result->dislike_total) && $dislike_result->dislike_total) ? intval($dislike_result->dislike_total) : 0;
        $score -= $dislike_count;

        // 4. Calculate points from comments created (+1 per comment)
        $this->db->reset_query();
        $comment_count = $this->db->where('alumni_id', $alumni_id)->count_all_results('forum_comments');
        $score += ($comment_count * 1);

        // 5. Calculate points from likes received on comments (+1 per like)
        $this->db->reset_query();
        $this->db->select('COUNT(*) as comment_like_total');
        $this->db->from('forum_comment_likes');
        $this->db->join('forum_comments', 'forum_comment_likes.comment_id = forum_comments.id', 'inner');
        $this->db->where('forum_comments.alumni_id', $alumni_id);
        $comment_like_result = $this->db->get()->row();
        $comment_like_count = (isset($comment_like_result->comment_like_total) && $comment_like_result->comment_like_total) ? intval($comment_like_result->comment_like_total) : 0;
        $score += ($comment_like_count * 1);

        // 6. Calculate points from dislikes received on comments (-0.5 per dislike)
        $this->db->reset_query();
        $this->db->select('COUNT(*) as comment_dislike_total');
        $this->db->from('forum_comment_dislikes');
        $this->db->join('forum_comments', 'forum_comment_dislikes.comment_id = forum_comments.id', 'inner');
        $this->db->where('forum_comments.alumni_id', $alumni_id);
        $comment_dislike_result = $this->db->get()->row();
        $comment_dislike_count = (isset($comment_dislike_result->comment_dislike_total) && $comment_dislike_result->comment_dislike_total) ? intval($comment_dislike_result->comment_dislike_total) : 0;
        $score -= ($comment_dislike_count * 0.5);

        // 7. Calculate penalty from report count (-10 per report on posts)
        $this->db->reset_query();
        $this->db->select('COUNT(*) as report_total');
        $this->db->from('forum_reports');
        $this->db->join('forum_posts', 'forum_reports.post_id = forum_posts.id', 'inner');
        $this->db->where('forum_posts.alumni_id', $alumni_id);
        $report_result = $this->db->get()->row();
        $report_count = (isset($report_result->report_total) && $report_result->report_total) ? intval($report_result->report_total) : 0;
        $score -= ($report_count * 10);

        // 8. Content penalty for toxic keywords (-50 per post with toxicity)
        // Check only if profanity function exists
        if (function_exists('_get_simple_profanity_list')) {
            try {
                $profanity_list = _get_simple_profanity_list();
                $toxic_penalty = 0;

                foreach ($posts as $post) {
                    if ($this->_check_post_toxicity($post->content, $profanity_list)) {
                        $toxic_penalty += 50;
                    }
                }
                $score -= $toxic_penalty;
            } catch (Exception $e) {
                // If profanity check fails, just continue without penalty
            }
        }

        return $score;
    }

    /**
     * Get Standing Score with Debug Info (for troubleshooting)
     * 
     * @param int $alumni_id The alumni ID
     * @return array Array with 'score' and 'breakdown' details
     */
    public function get_standing_score_debug($alumni_id)
    {
        if (!$alumni_id) {
            return [
                'score' => 0,
                'breakdown' => []
            ];
        }

        $breakdown = [];
        $score = 0;

        // 1. Posts created
        $this->db->reset_query();
        $query = $this->db->where('alumni_id', $alumni_id)->get('forum_posts');
        $posts = $query->result();
        $post_count = count($posts);
        $post_points = $post_count * 5;
        $score += $post_points;
        $breakdown['posts_created'] = [
            'count' => $post_count,
            'points_per' => 5,
            'total' => $post_points
        ];

        if ($post_count == 0) {
            return [
                'score' => 0,
                'breakdown' => $breakdown
            ];
        }

        // 2. Likes received
        $this->db->reset_query();
        $this->db->select('COUNT(*) as like_total');
        $this->db->from('forum_likes');
        $this->db->join('forum_posts', 'forum_likes.post_id = forum_posts.id', 'inner');
        $this->db->where('forum_posts.alumni_id', $alumni_id);
        $like_result = $this->db->get()->row();
        $like_count = (isset($like_result->like_total) && $like_result->like_total) ? intval($like_result->like_total) : 0;
        $like_points = $like_count * 2;
        $score += $like_points;
        $breakdown['likes_received'] = [
            'count' => $like_count,
            'points_per' => 2,
            'total' => $like_points
        ];

        // 3. Dislikes received
        $this->db->reset_query();
        $this->db->select('COUNT(*) as dislike_total');
        $this->db->from('forum_dislike');
        $this->db->join('forum_posts', 'forum_dislike.post_id = forum_posts.id', 'inner');
        $this->db->where('forum_posts.alumni_id', $alumni_id);
        $dislike_result = $this->db->get()->row();
        $dislike_count = (isset($dislike_result->dislike_total) && $dislike_result->dislike_total) ? intval($dislike_result->dislike_total) : 0;
        $dislike_penalty = $dislike_count * 1;
        $score -= $dislike_penalty;
        $breakdown['dislikes_received'] = [
            'count' => $dislike_count,
            'penalty_per' => -1,
            'total' => -$dislike_penalty
        ];

        // 4. Comments created
        $this->db->reset_query();
        $comment_count = $this->db->where('alumni_id', $alumni_id)->count_all_results('forum_comments');
        $comment_points = $comment_count * 1;
        $score += $comment_points;
        $breakdown['comments_created'] = [
            'count' => $comment_count,
            'points_per' => 1,
            'total' => $comment_points
        ];

        // 5. Likes received on comments
        $this->db->reset_query();
        $this->db->select('COUNT(*) as comment_like_total');
        $this->db->from('forum_comment_likes');
        $this->db->join('forum_comments', 'forum_comment_likes.comment_id = forum_comments.id', 'inner');
        $this->db->where('forum_comments.alumni_id', $alumni_id);
        $comment_like_result = $this->db->get()->row();
        $comment_like_count = (isset($comment_like_result->comment_like_total) && $comment_like_result->comment_like_total) ? intval($comment_like_result->comment_like_total) : 0;
        $comment_like_points = $comment_like_count * 1;
        $score += $comment_like_points;
        $breakdown['comment_likes_received'] = [
            'count' => $comment_like_count,
            'points_per' => 1,
            'total' => $comment_like_points
        ];

        // 6. Dislikes received on comments
        $this->db->reset_query();
        $this->db->select('COUNT(*) as comment_dislike_total');
        $this->db->from('forum_comment_dislikes');
        $this->db->join('forum_comments', 'forum_comment_dislikes.comment_id = forum_comments.id', 'inner');
        $this->db->where('forum_comments.alumni_id', $alumni_id);
        $comment_dislike_result = $this->db->get()->row();
        $comment_dislike_count = (isset($comment_dislike_result->comment_dislike_total) && $comment_dislike_result->comment_dislike_total) ? intval($comment_dislike_result->comment_dislike_total) : 0;
        $comment_dislike_penalty = $comment_dislike_count * 0.5;
        $score -= $comment_dislike_penalty;
        $breakdown['comment_dislikes_received'] = [
            'count' => $comment_dislike_count,
            'penalty_per' => -0.5,
            'total' => -$comment_dislike_penalty
        ];

        // 7. Reports
        $this->db->reset_query();
        $this->db->select('COUNT(*) as report_total');
        $this->db->from('forum_reports');
        $this->db->join('forum_posts', 'forum_reports.post_id = forum_posts.id', 'inner');
        $this->db->where('forum_posts.alumni_id', $alumni_id);
        $report_result = $this->db->get()->row();
        $report_count = (isset($report_result->report_total) && $report_result->report_total) ? intval($report_result->report_total) : 0;
        $report_penalty = $report_count * 10;
        $score -= $report_penalty;
        $breakdown['reports'] = [
            'count' => $report_count,
            'penalty_per' => -10,
            'total' => -$report_penalty
        ];

        // 8. Toxic content
        $toxic_count = 0;
        $toxic_penalty = 0;
        
        if (function_exists('_get_simple_profanity_list')) {
            try {
                $profanity_list = _get_simple_profanity_list();
                
                foreach ($posts as $post) {
                    if ($this->_check_post_toxicity($post->content, $profanity_list)) {
                        $toxic_count++;
                        $toxic_penalty += 50;
                    }
                }
                $score -= $toxic_penalty;
            } catch (Exception $e) {
                // If profanity check fails, continue without it
            }
        }
        
        $breakdown['toxic_content'] = [
            'count' => $toxic_count,
            'penalty_per' => -50,
            'total' => -$toxic_penalty
        ];

        return [
            'score' => intval($score),
            'breakdown' => $breakdown
        ];
    }

    /**
     * Get Weighted Karma Score (Time-Decay Formula)
     * 
     * Implements Reddit-like karma with temporal weighting where:
     * - Votes in first 24 hours: 100% weight
     * - Votes after 7 days: 70% weight  
     * - Votes after 30 days: 40% weight
     * - Votes after 90 days: 10% weight
     * 
     * This makes early engagement more valuable and encourages consistent contribution.
     * Posts themselves don't decay (static +5 each).
     * Score is floored at -100 to prevent abuse.
     * 
     * @param int $alumni_id The alumni ID
     * @return array ['score' => int, 'floating_score' => float, 'breakdown' => array]
     */
    public function get_weighted_karma_score($alumni_id)
    {
        if (!$alumni_id) {
            return [
                'score' => 0,
                'floating_score' => 0.0,
                'breakdown' => []
            ];
        }

        $breakdown = [];
        $score = 0.0;

        // ── 1. POSTS (Fixed points, no decay) ──
        $this->db->reset_query();
        $query = $this->db->where('alumni_id', $alumni_id)->get('forum_posts');
        $posts = $query->result();
        $post_count = count($posts);
        
        if ($post_count == 0) {
            return [
                'score' => 0,
                'floating_score' => 0.0,
                'breakdown' => []
            ];
        }

        $post_points = $post_count * 5;
        $score += $post_points;
        $breakdown['posts'] = [
            'count' => $post_count,
            'points_per' => 5,
            'total' => $post_points,
            'note' => 'No time decay—fixed points'
        ];

        // ── 2. LIKES (Time-decay weighted) ──
        $this->db->reset_query();
        $this->db->select(
            'forum_likes.id,
             forum_likes.created_at,
             (CASE 
                WHEN forum_likes.created_at > DATE_SUB(NOW(), INTERVAL 1 DAY)
                    THEN 1.0
                WHEN forum_likes.created_at > DATE_SUB(NOW(), INTERVAL 7 DAY)
                    THEN 0.7
                WHEN forum_likes.created_at > DATE_SUB(NOW(), INTERVAL 30 DAY)
                    THEN 0.4
                ELSE 0.1
             END) as weight'
        );
        $this->db->from('forum_likes');
        $this->db->join('forum_posts', 'forum_likes.post_id = forum_posts.id', 'inner');
        $this->db->where('forum_posts.alumni_id', $alumni_id);
        
        $like_results = $this->db->get()->result();
        $like_score = 0.0;
        $like_count = count($like_results);
        
        foreach ($like_results as $like) {
            $like_score += (2.0 * floatval($like->weight));
        }
        
        $score += $like_score;
        $avg_like_weight = $like_count > 0 ? round($like_score / ($like_count * 2), 3) : 0;
        
        $breakdown['likes_received'] = [
            'count' => $like_count,
            'weighted_score' => round($like_score, 2),
            'base_value' => 2,
            'avg_weight' => $avg_like_weight,
            'note' => 'Early votes worth more (100% → 10% over time)'
        ];

        // ── 3. DISLIKES (Time-decay weighted) ──
        $this->db->reset_query();
        $this->db->select(
            'forum_dislike.id,
             forum_dislike.created_at,
             (CASE 
                WHEN forum_dislike.created_at > DATE_SUB(NOW(), INTERVAL 1 DAY)
                    THEN 1.0
                WHEN forum_dislike.created_at > DATE_SUB(NOW(), INTERVAL 7 DAY)
                    THEN 0.7
                WHEN forum_dislike.created_at > DATE_SUB(NOW(), INTERVAL 30 DAY)
                    THEN 0.4
                ELSE 0.1
             END) as weight'
        );
        $this->db->from('forum_dislike');
        $this->db->join('forum_posts', 'forum_dislike.post_id = forum_posts.id', 'inner');
        $this->db->where('forum_posts.alumni_id', $alumni_id);
        
        $dislike_results = $this->db->get()->result();
        $dislike_score = 0.0;
        $dislike_count = count($dislike_results);
        
        foreach ($dislike_results as $dislike) {
            $dislike_score -= (1.0 * floatval($dislike->weight));
        }
        
        $score += $dislike_score;
        $avg_dislike_weight = $dislike_count > 0 ? round(abs($dislike_score) / $dislike_count, 3) : 0;
        
        $breakdown['dislikes_received'] = [
            'count' => $dislike_count,
            'weighted_score' => round($dislike_score, 2),
            'base_penalty' => -1,
            'avg_weight' => $avg_dislike_weight,
            'note' => 'Fresh dislikes penalize more'
        ];

        // ── 4. REPORTS (Fixed penalty, no decay) ──
        $this->db->reset_query();
        $this->db->select('COUNT(*) as report_total');
        $this->db->from('forum_reports');
        $this->db->join('forum_posts', 'forum_reports.post_id = forum_posts.id', 'inner');
        $this->db->where('forum_posts.alumni_id', $alumni_id);
        $report_result = $this->db->get()->row();
        $report_count = intval($report_result->report_total ?? 0);
        $report_penalty = $report_count * 10;
        $score -= $report_penalty;
        
        $breakdown['reports'] = [
            'count' => $report_count,
            'penalty_per' => -10,
            'total' => -$report_penalty,
            'note' => 'No decay—static penalty'
        ];

        // ── 5. TOXICITY PENALTY (Fixed penalty, no decay) ──
        $toxic_count = 0;
        $toxic_penalty = 0;
        
        if (function_exists('_get_simple_profanity_list')) {
            try {
                $profanity_list = _get_simple_profanity_list();
                foreach ($posts as $post) {
                    if ($this->_check_post_toxicity($post->content, $profanity_list)) {
                        $toxic_count++;
                        $toxic_penalty += 50;
                    }
                }
                $score -= $toxic_penalty;
            } catch (Exception $e) {
                // Fail gracefully
            }
        }
        
        $breakdown['toxicity'] = [
            'count' => $toxic_count,
            'penalty_per' => -50,
            'total' => -$toxic_penalty,
            'note' => 'Flagged posts penalized once'
        ];

        // ── Apply minimum floor (prevents abuse) ──
        $final_score = max($score, -100);
        $was_floored = $final_score !== floor($score);
        
        $breakdown['scoring_summary'] = [
            'raw_score' => round($score, 2),
            'floor_applied' => -100,
            'was_floored' => $was_floored,
            'formula' => '(posts × 5) + (likes × 2 × weight) - (dislikes × 1 × weight) - (reports × 10) - toxicity'
        ];

        return [
            'score' => intval($final_score),
            'floating_score' => round($score, 2),
            'breakdown' => $breakdown
        ];
    }

    /**
     * Check if post content contains toxic/profane keywords
     * 
     * @param string $content The post content to check
     * @param array $profanity_list List of profane words
     * @return bool True if toxic content detected
     */
    private function _check_post_toxicity($content, $profanity_list)
    {
        if (empty($content)) {
            return false;
        }

        // Convert content to lowercase for case-insensitive matching
        $content_lower = mb_strtolower($content, 'UTF-8');

        foreach ($profanity_list as $word) {
            if (empty($word)) continue;
            
            $word_lower = mb_strtolower($word, 'UTF-8');
            
            // Check if word is CJK (Chinese, Japanese, Korean)
            $has_cjk = preg_match('/[\x{4E00}-\x{9FFF}]/u', $word) === 1;
            
            if ($has_cjk) {
                // For CJK: use simple substring matching (no word boundaries)
                if (mb_strpos($content_lower, $word_lower) !== false) {
                    return true;
                }
            } else {
                // For Latin: use word boundary regex (case-insensitive)
                $pattern = '/\b' . preg_quote($word_lower, '/') . '\b/ui';
                if (preg_match($pattern, $content_lower)) {
                    return true;
                }
            }
        }

        return false;
    }
}
