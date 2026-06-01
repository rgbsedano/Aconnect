<?php

class Forum_model extends CI_Model {

    public function get_posts($limit,$offset,$search,$sort)
    {
        $this->db->select("
            forum_posts.*,
            alumni.first_name,
            alumni.last_name,
            alumni.profile_image,
            (SELECT COUNT(*) 
            FROM forum_comments 
            WHERE post_id = forum_posts.id 
            AND parent_id = 0
            AND valid = 1) as comment_count,
            (SELECT COUNT(*) FROM forum_likes WHERE post_id=forum_posts.id) as like_count,
            (SELECT COUNT(*) FROM forum_dislike WHERE post_id=forum_posts.id) as dislike_count
        ");

        $this->db->from('forum_posts');
        $this->db->join('alumni','alumni.id=forum_posts.alumni_id','left');

        // Allow viewing deleted posts if user is the owner, otherwise only show valid posts
        $alumni_id = $this->session->userdata('alumni_id');
        $this->db->group_start();
        $this->db->where('forum_posts.valid', 1);  // Public can see valid posts
        if($alumni_id) {
            $this->db->or_where('forum_posts.alumni_id', $alumni_id);  // Owner can see their deleted posts
        }
        $this->db->group_end();

        if($search){
            $this->db->group_start();
            $this->db->like('title',$search);
            $this->db->or_like('content',$search);
            $this->db->group_end();
        }

        if($sort == 'likes'){
            $this->db->order_by('like_count','DESC');
        }
        elseif($sort == 'comments'){
            $this->db->order_by('comment_count','DESC');
        }
        elseif($sort == 'myposts'){
            $this->db->where('forum_posts.alumni_id',$this->session->userdata('alumni_id'));
            $this->db->order_by('created_at','DESC');
        }
        else{
            $this->db->order_by('created_at','DESC');
        }

        $this->db->limit($limit,$offset);

        return $this->db->get()->result();
    }

    public function insert_post($data){
        return $this->db->insert('forum_posts',$data);
    }

    public function get_comments($post_id){

        $this->db->select('
            forum_comments.*,
            alumni.first_name,
            alumni.last_name,
            alumni.profile_image,
            (SELECT COUNT(*) FROM forum_comment_likes WHERE comment_id = forum_comments.id) as like_count,
            (SELECT COUNT(*) FROM forum_comment_dislikes WHERE comment_id = forum_comments.id) as dislike_count
        ');
        $this->db->from('forum_comments');
        $this->db->join('alumni','alumni.id=forum_comments.alumni_id','left');
        $this->db->where('post_id',$post_id);
        $this->db->where('forum_comments.valid', 1);

        return $this->db->get()->result();
    }

    /**
     * Fetch comments for a post with sorting options
     *
     * @param int $post_id The ID of the post
     * @param string $sort The sorting method: 'most_relevant' (by likes), 'newest', or 'oldest'
     * @return object[] Array of comment records
     * 
     * @example
     * // Get most relevant comments (sorted by likes)
     * $comments = $this->Forum_model->get_comments_sorted(42, 'most_relevant');
     * 
     * // Get newest comments first
     * $comments = $this->Forum_model->get_comments_sorted(42, 'newest');
     * 
     * // Get oldest comments first
     * $comments = $this->Forum_model->get_comments_sorted(42, 'oldest');
     */
    public function get_comments_sorted(int $post_id, string $sort = 'newest'): array
    {
        $this->db->select('
            forum_comments.*,
            alumni.first_name,
            alumni.last_name,
            alumni.profile_image,
            (SELECT COUNT(*) FROM forum_comment_likes WHERE comment_id = forum_comments.id) as like_count,
            (SELECT COUNT(*) FROM forum_comment_dislikes WHERE comment_id = forum_comments.id) as dislike_count
        ');
        $this->db->from('forum_comments');
        $this->db->join('alumni', 'alumni.id = forum_comments.alumni_id', 'left');
        $this->db->where('forum_comments.post_id', $post_id);
        $this->db->where('forum_comments.valid', 1);

        // Apply sorting based on the sort parameter
        switch ($sort) {
            case 'most_relevant':
                // Sort by like count (descending), then by newest first as tiebreaker
                $this->db
                    ->order_by('like_count', 'DESC')
                    ->order_by('forum_comments.created_at', 'DESC');
                break;

            case 'oldest':
                // Sort by creation timestamp (ascending)
                $this->db->order_by('forum_comments.created_at', 'ASC');
                break;

            case 'newest':
            default:
                // Sort by creation timestamp (descending) - newest first
                $this->db->order_by('forum_comments.created_at', 'DESC');
                break;
        }

        $query_result = $this->db->get()->result();
        
        return is_array($query_result) ? $query_result : [];
    }

    public function insert_comment($data){
        $inserted = $this->db->insert('forum_comments', $data);
        if($inserted) {
            return $this->db->insert_id();
        }
        return false;
    }

    public function toggle_like($post_id,$alumni_id){

        $this->db->where('post_id',$post_id);
        $this->db->where('alumni_id',$alumni_id);
        $like = $this->db->get('forum_likes')->row();

        if($like){
            // Remove like if already liked (hard delete for reactions)
            $this->db->delete('forum_likes', ['id'=>$like->id]);
        }else{
            // Keep reactions mutually exclusive - remove any dislike
            $this->db->delete('forum_dislike',
                ['post_id'=>$post_id, 'alumni_id'=>$alumni_id]
            );
            // Add like
            $this->db->insert('forum_likes',[
                'post_id'=>$post_id,
                'alumni_id'=>$alumni_id
            ]);
        }
    }

    public function toggle_dislike($post_id,$alumni_id){

        $this->db->where('post_id',$post_id);
        $this->db->where('alumni_id',$alumni_id);
        $dislike = $this->db->get('forum_dislike')->row();

        if($dislike){
            // Remove dislike if already disliked (hard delete for reactions)
            $this->db->delete('forum_dislike', ['id'=>$dislike->id]);
        }else{
            // Keep reactions mutually exclusive - remove any like
            $this->db->delete('forum_likes',
                ['post_id'=>$post_id, 'alumni_id'=>$alumni_id]
            );
            // Add dislike
            $this->db->insert('forum_dislike',[
                'post_id'=>$post_id,
                'alumni_id'=>$alumni_id
            ]);
        }
    }

    public function count_likes($post_id){
        $this->db->where('post_id',$post_id);
        return $this->db->count_all_results('forum_likes');
    }

    public function user_liked($post_id,$alumni_id){
        return $this->db->where('post_id',$post_id)->where('alumni_id',$alumni_id)->get('forum_likes')->row();
    }

    /**
     * Toggle like on a comment (mutually exclusive with dislike)
     * 
     * @param int $comment_id
     * @param int $alumni_id
     */
    public function toggle_comment_like($comment_id, $alumni_id)
    {
        $this->db->where('comment_id', $comment_id);
        $this->db->where('alumni_id', $alumni_id);
        $like = $this->db->get('forum_comment_likes')->row();

        if($like){
            // Remove like if already liked (hard delete for reactions)
            $this->db->delete('forum_comment_likes', ['id' => $like->id]);
        } else {
            // Remove dislike first (mutually exclusive)
            $this->db->delete('forum_comment_dislikes',
                ['comment_id' => $comment_id, 'alumni_id' => $alumni_id]
            );
            // Add like
            $this->db->insert('forum_comment_likes', [
                'comment_id' => $comment_id,
                'alumni_id' => $alumni_id
            ]);
        }
    }

    /**
     * Toggle dislike on a comment (mutually exclusive with like)
     * 
     * @param int $comment_id
     * @param int $alumni_id
     */
    public function toggle_comment_dislike($comment_id, $alumni_id)
    {
        $this->db->where('comment_id', $comment_id);
        $this->db->where('alumni_id', $alumni_id);
        $dislike = $this->db->get('forum_comment_dislikes')->row();

        if($dislike){
            // Remove dislike if already disliked (hard delete for reactions)
            $this->db->delete('forum_comment_dislikes', ['id' => $dislike->id]);
        } else {
            // Remove like first (mutually exclusive)
            $this->db->delete('forum_comment_likes',
                ['comment_id' => $comment_id, 'alumni_id' => $alumni_id]
            );
            // Add dislike
            $this->db->insert('forum_comment_dislikes', [
                'comment_id' => $comment_id,
                'alumni_id' => $alumni_id
            ]);
        }
    }

    /**
     * Check if user liked a comment
     */
    public function user_liked_comment($comment_id, $alumni_id)
    {
        return $this->db->where('comment_id', $comment_id)
                       ->where('alumni_id', $alumni_id)
                       ->get('forum_comment_likes')
                       ->row();
    }

    /**
     * Check if user disliked a comment
     */
    public function user_disliked_comment($comment_id, $alumni_id)
    {
        return $this->db->where('comment_id', $comment_id)
                       ->where('alumni_id', $alumni_id)
                       ->get('forum_comment_dislikes')
                       ->row();
    }

    public function delete_post($post_id, $alumni_id)
    {
        $this->db->where('id', $post_id);
        $this->db->where('alumni_id', $alumni_id);
        $post = $this->db->get('forum_posts')->row();

        if ($post) {

            // delete image file
            if ($post->image && file_exists('./assets/uploads/forum/'.$post->image)) {
                unlink('./assets/uploads/forum/'.$post->image);
            }

            // hard delete reactions (likes/dislikes) - they have no valid column
            $this->db->delete('forum_likes', ['post_id' => $post_id]);
            $this->db->delete('forum_dislike', ['post_id' => $post_id]);

            // soft delete related content
            $this->db->where('post_id', $post_id)->update('forum_comments', ['valid' => 0]);
            $this->db->where('post_id', $post_id)->update('forum_reports', ['valid' => 0]);

            // soft delete post
            $this->db->where('id', $post_id)->update('forum_posts', ['valid' => 0]);

            return true;
        }

        return false;
    }

    public function report_post($data){
        return $this->db->insert('forum_reports',$data);
    }

    public function count_posts($search = null, $sort = null)
    {
        $this->db->from('forum_posts');

        // Allow viewing deleted posts if user is the owner, otherwise only show valid posts
        $alumni_id = $this->session->userdata('alumni_id');
        $this->db->group_start();
        $this->db->where('forum_posts.valid', 1);  // Public can see valid posts
        if($alumni_id) {
            $this->db->or_where('forum_posts.alumni_id', $alumni_id);  // Owner can see their deleted posts
        }
        $this->db->group_end();

        if($search){
            $this->db->group_start();
            $this->db->like('title',$search);
            $this->db->or_like('content',$search);
            $this->db->group_end();
        }

        if($sort == 'myposts'){
            $this->db->where('alumni_id',$this->session->userdata('alumni_id'));
        }

        return $this->db->count_all_results();
    }
    public function get_post($id)
    {
        $this->db->select("
            forum_posts.*,
            alumni.first_name,
            alumni.last_name,
            alumni.profile_image,
            (SELECT COUNT(*) 
            FROM forum_comments 
            WHERE post_id = forum_posts.id 
            AND parent_id = 0
            AND valid = 1) as comment_count,
            (SELECT COUNT(*) FROM forum_likes WHERE post_id=forum_posts.id) as like_count,
            (SELECT COUNT(*) FROM forum_dislike WHERE post_id=forum_posts.id) as dislike_count
        ");

        $this->db->from('forum_posts');
        $this->db->join('alumni','alumni.id = forum_posts.alumni_id','left');
        $this->db->where('forum_posts.id',$id);
        
        // Allow viewing deleted posts if user is the owner, otherwise only show valid posts
        $alumni_id = $this->session->userdata('alumni_id');
        $this->db->group_start();
        $this->db->where('forum_posts.valid', 1);
        if($alumni_id) {
            $this->db->or_where('forum_posts.alumni_id', $alumni_id);
        }
        $this->db->group_end();

        return $this->db->get()->row();
    }

    /**
     * Calculate Alumni Standing (Karma-like system)
     * 
     * Scoring:
     * - Forum post created: +5 points
     * - Like received on post: +2 points
     * - Dislike received on post: -1 point
     * - Post reported: -10 points per report
     * - Toxic content (slurs/hate speech): -50 points per post
     * 
     * @param int $alumni_id The alumni ID
     * @return int Total standing score
     */
    public function get_alumni_standing($alumni_id)
    {
        $score = 0;

        // 1. Calculate points from posts created (+5 per post)
        $post_count = $this->db->where('alumni_id', $alumni_id)->count_all_results('forum_posts');
        $score += ($post_count * 5);

        // 2. Calculate points from likes received (+2 per like)
        $this->db->select('COUNT(forum_likes.id) as like_total');
        $this->db->from('forum_likes');
        $this->db->join('forum_posts', 'forum_likes.post_id = forum_posts.id', 'inner');
        $this->db->where('forum_posts.alumni_id', $alumni_id);
        $like_result = $this->db->get()->row();
        $like_count = $like_result ? $like_result->like_total : 0;
        $score += ($like_count * 2);

        // 3. Calculate points from dislikes received (-1 per dislike)
        $this->db->select('COUNT(forum_dislike.id) as dislike_total');
        $this->db->from('forum_dislike');
        $this->db->join('forum_posts', 'forum_dislike.post_id = forum_posts.id', 'inner');
        $this->db->where('forum_posts.alumni_id', $alumni_id);
        $dislike_result = $this->db->get()->row();
        $dislike_count = $dislike_result ? $dislike_result->dislike_total : 0;
        $score -= $dislike_count;

        // 4. Calculate penalty from report count (-10 per report)
        $this->db->select('COUNT(forum_reports.id) as report_total');
        $this->db->from('forum_reports');
        $this->db->join('forum_posts', 'forum_reports.post_id = forum_posts.id', 'inner');
        $this->db->where('forum_posts.alumni_id', $alumni_id);
        $report_result = $this->db->get()->row();
        $report_count = $report_result ? $report_result->report_total : 0;
        $score -= ($report_count * 10);

        // 5. Content penalty for toxic keywords (-50 per post with toxicity)
        $this->load->helper('profanity_filter');
        $toxic_posts = $this->db->where('alumni_id', $alumni_id)->get('forum_posts')->result();
        $profanity_list = _get_simple_profanity_list();
        $toxic_penalty = 0;

        foreach ($toxic_posts as $post) {
            $has_toxicity = $this->_check_post_toxicity($post->content, $profanity_list);
            if ($has_toxicity) {
                $toxic_penalty += 50;
            }
        }
        $score -= $toxic_penalty;

        return max(0, $score);
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

        foreach ($profanity_list as $word) {
            // Handle CJK characters (Chinese, Japanese, etc.) - no word boundaries
            $has_cjk = preg_match('/[\x{4E00}-\x{9FFF}]/u', $word) === 1;
            $pattern = $has_cjk
                ? '/' . preg_quote($word, '/') . '/u'
                : '/\b' . preg_quote($word, '/') . '\b/i';
            
            if (preg_match($pattern, $content)) {
                return true;
            }
        }

        return false;
    }


}