<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forum extends CI_Controller {

    public function __construct(){
    parent::__construct();
    $this->load->model('Forum_model');
    $this->load->model('Standing_model');
    $this->load->helper('text'); 
    $this->load->helper('time');
    $this->load->helper('profanity_filter');
    $this->load->helper('standing');
    $this->load->helper('ai');
}

    public function index()
    {
        $this->load->view('__header');
        $this->load->library('pagination');

        $limit = 6;
        $page = $this->input->get('page');
        $offset = ($page) ? $page : 0;

        $search = $this->input->get('search');
        $sort = $this->input->get('sort');

        $total = $this->Forum_model->count_posts($search,$sort);

        $config['base_url'] = base_url('forum');
        $config['total_rows'] = $total;
        $config['per_page'] = $limit;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string'] = TRUE;

        $config['full_tag_open'] = '';
        $config['full_tag_close'] = '';

        $config['num_tag_open'] = '';
        $config['num_tag_close'] = '';

        $config['cur_tag_open'] = '<span class="current">';
        $config['cur_tag_close'] = '</span>';

        $config['next_tag_open'] = '';
        $config['next_tag_close'] = '';
        $config['next_link'] = '&raquo;';

        $config['prev_tag_open'] = '';
        $config['prev_tag_close'] = '';
        $config['prev_link'] = '&laquo;';

        $config['first_tag_open'] = '';
        $config['first_tag_close'] = '';

        $config['last_tag_open'] = '';
        $config['last_tag_close'] = '';

        $this->pagination->initialize($config);

        $data['posts'] = $this->Forum_model->get_posts($limit,$offset,$search,$sort);
        
        // Apply profanity censoring to posts
        $data['posts'] = censor_forum_posts($data['posts']);
        
        // Add standing scores for each post author
        foreach ($data['posts'] as &$post) {
            $post->author_standing = $this->Standing_model->get_standing_score($post->alumni_id);
            $post->standing_badge = get_standing_badge($post->author_standing);
        }
        
        $data['pagination'] = $this->pagination->create_links();
        $data['total_posts'] = $total;

        
        $this->load->view('user/forum_list',$data);
        $this->load->view('__footer');
    }

    public function create_post(){
        // ===== SPAM PREVENTION: Cooldown Check =====
        // Prevent users from posting more than once every 30 seconds
        $alumni_id = $this->session->userdata('alumni_id');
        if (!$alumni_id) {
            $this->session->set_flashdata('error', 'You must be logged in to create a post.');
            redirect('forum');
            return;
        }

        // Check if user has posted recently (cooldown: 30 seconds)
        $this->load->driver('cache', ['adapter' => 'file', 'backup' => 'file']);
        $last_post_cache_key = 'forum_post_cooldown_' . $alumni_id;
        $last_post_time = $this->cache->get($last_post_cache_key);

        if ($last_post_time !== FALSE) {
            // User has posted recently, reject request
            $this->session->set_flashdata('error', 'Please wait 30 seconds between posts. No spam allowed!');
            redirect('forum');
            log_message('error', "SPAM PREVENTION: Alumni {$alumni_id} attempted rapid post creation");
            return;
        }

        // ===== PROCEED WITH POST CREATION =====
        $image = '';

        if(!empty($_FILES['image']['name'])){
            $config['upload_path'] = './assets/uploads/forum/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload',$config);

            if($this->upload->do_upload('image')){
                $image = $this->upload->data('file_name');
            }
        }

        $data = [
            'alumni_id' => $alumni_id,
            'title' => $this->input->post('title'),
            'content' => $this->input->post('content'),
            'image' => $image,
            'is_anonymous' => $this->input->post('anonymous') ? 1 : 0,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->Forum_model->insert_post($data);

        // ===== SET COOLDOWN TIMER =====
        // Store cooldown timestamp (30 seconds from now)
        $this->cache->save($last_post_cache_key, time(), 30);
        
        log_message('info', "Forum post created by alumni {$alumni_id} - Cooldown active for 30 seconds");

        redirect('forum');
    }

    /**
     * Add comment from forum_list.php modal
     * Handles comment submission from the comment modal in forum_list
     */
    public function add_comment(){
        // ===== AUTHENTICATION CHECK =====
        $alumni_id = $this->session->userdata('alumni_id');
        if (!$alumni_id) {
            $response = [
                'success' => false,
                'message' => 'You must be logged in to comment.'
            ];
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
            return;
        }

        // ===== GET FORM DATA =====
        $post_id = $this->input->post('post_id');
        $comment_text = $this->input->post('comment_text');
        $is_anonymous = $this->input->post('is_anonymous');
        $is_anonymous = ($is_anonymous === '1') ? 1 : 0;

        // ===== VALIDATION =====
        if (!$post_id || !$comment_text || empty(trim($comment_text))) {
            $response = [
                'success' => false,
                'message' => 'Comment cannot be empty.'
            ];
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
            return;
        }

        // ===== VERIFY POST ACCESS =====
        $post = $this->Forum_model->get_post($post_id);
        if (!$post) {
            $response = [
                'success' => false,
                'message' => 'Post not found.'
            ];
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
            return;
        }

        // Allow commenting if post is public or user is the owner
        if ($post->valid == 0 && $post->alumni_id != $alumni_id) {
            $response = [
                'success' => false,
                'message' => 'Cannot comment on deleted posts.'
            ];
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
            return;
        }

        // ===== SPAM PREVENTION: Comment Cooldown (10 seconds) =====
        $this->load->driver('cache', ['adapter' => 'file', 'backup' => 'file']);
        $comment_cooldown_key = 'forum_comment_cooldown_' . $alumni_id;
        $last_comment_time = $this->cache->get($comment_cooldown_key);

        if ($last_comment_time !== FALSE) {
            $response = [
                'success' => false,
                'message' => 'Please wait 10 seconds between comments.'
            ];
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
            return;
        }

        // ===== PROFANITY CHECK & CLEAN TEXT =====
        $filter_result = censor_profanities($comment_text, $alumni_id, $post_id);
        $cleaned_comment = $filter_result['censored_text'];

        // ===== INSERT COMMENT =====
        $data = [
            'post_id' => $post_id,
            'parent_id' => 0,
            'alumni_id' => $alumni_id,
            'comment' => $cleaned_comment,
            'is_anonymous' => $is_anonymous,
            'created_at' => date('Y-m-d H:i:s'),
            'valid' => 1
        ];

        $comment_id = $this->Forum_model->insert_comment($data);

        // ===== SET COMMENT COOLDOWN =====
        $this->cache->save($comment_cooldown_key, time(), 10);
        
        log_message('info', "Forum comment created by alumni {$alumni_id} on post {$post_id}");

        // ===== RETURN JSON RESPONSE =====
        $response = [
            'success' => true,
            'message' => 'Comment posted successfully!',
            'comment_id' => $comment_id
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    /**
     * Get comments for a post (AJAX endpoint)
     * Returns comments in JSON format for the modal
     */
    public function get_comments($post_id, $sort = 'newest') {
        if (!$this->input->is_ajax_request()) {
            http_response_code(400);
            return;
        }

        // Verify post exists and user has permission to access it
        $post = $this->Forum_model->get_post($post_id);
        if (!$post) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => false,
                    'comments' => [],
                    'count' => 0
                ]));
            return;
        }

        // Check if user is post owner or post is public
        $alumni_id = $this->session->userdata('alumni_id');
        if ($post->valid == 0 && (!$alumni_id || $post->alumni_id != $alumni_id)) {
            // Post is deleted and user is not the owner
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => false,
                    'comments' => [],
                    'count' => 0
                ]));
            return;
        }

        $comments = $this->Forum_model->get_comments_sorted($post_id, $sort);
        
        $alumni_id = $this->session->userdata('alumni_id');
        
        // Format comments for JSON response
        $formatted_comments = [];
        foreach ($comments as $comment) {
            // Explicitly cast is_anonymous to integer (0 or 1)
            $is_anon = (int)$comment->is_anonymous;
            
            // Count likes and dislikes from junction tables
            $like_count = $this->db->where('comment_id', $comment->id)->count_all_results('forum_comment_likes');
            $dislike_count = $this->db->where('comment_id', $comment->id)->count_all_results('forum_comment_dislikes');
            
            // Check if current user has liked/disliked this comment
            $user_liked = false;
            $user_disliked = false;
            if ($alumni_id) {
                $userLike = $this->db->where('comment_id', $comment->id)
                                     ->where('alumni_id', $alumni_id)
                                     ->get('forum_comment_likes')
                                     ->row();
                $userDislike = $this->db->where('comment_id', $comment->id)
                                        ->where('alumni_id', $alumni_id)
                                        ->get('forum_comment_dislikes')
                                        ->row();
                $user_liked = !empty($userLike);
                $user_disliked = !empty($userDislike);
            }
            
            $formatted_comments[] = [
                'id' => $comment->id,
                'parent_id' => (int)($comment->parent_id ?: 0),
                'comment' => htmlspecialchars($comment->comment),
                'is_anonymous' => $is_anon,
                'first_name' => $comment->first_name ?: 'User',
                'last_name' => $comment->last_name ?: '',
                'profile_image' => $comment->profile_image,
                'time_ago' => time_ago($comment->created_at),
                'created_at' => $comment->created_at,
                'like_count' => (int)$like_count,
                'dislike_count' => (int)$dislike_count,
                'user_liked' => $user_liked,
                'user_disliked' => $user_disliked
            ];
        }

        // Return JSON response
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'success' => true,
                'comments' => $formatted_comments,
                'count' => count($formatted_comments)
            ]));
    }

    public function comment(){
        // === CRITICAL: Clear all output buffering for AJAX ===
        while (ob_get_level()) {
            ob_end_clean();
        }
        
        // Check if this is actually an AJAX request
        $is_ajax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
        
        // Write debug to file immediately
        $debug_file = APPPATH . 'logs/comment_debug.log';
        file_put_contents($debug_file, "\n=== NEW REQUEST at " . date('Y-m-d H:i:s') . " ===\n", FILE_APPEND);
        file_put_contents($debug_file, "Is AJAX (header check): " . ($is_ajax ? 'YES' : 'NO') . "\n", FILE_APPEND);
        file_put_contents($debug_file, "Is AJAX (CI method): " . ($this->input->is_ajax_request() ? 'YES' : 'NO') . "\n", FILE_APPEND);
        file_put_contents($debug_file, "X-Requested-With header: " . ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? 'NOT SET') . "\n", FILE_APPEND);
        
        // Suppress ALL errors for AJAX  
        if ($is_ajax) {
            error_reporting(E_ALL);
            ini_set('display_errors', '0');
        }
        
        try {
            // Get POST data EARLY before any processing
            $post_id = $this->input->post('post_id');
            $parent_id = $this->input->post('parent_id', '0');
            $comment_text = $this->input->post('comment');
            $is_anonymous = $this->input->post('anonymous') ? 1 : 0;
            
            file_put_contents($debug_file, "POST data - post_id: {$post_id}, parent_id: {$parent_id}, comment_length: " . strlen($comment_text) . ", anonymous: {$is_anonymous}\n", FILE_APPEND);
            file_put_contents($debug_file, "Comment text: " . $comment_text . "\n", FILE_APPEND);
            
            log_message('debug', "POST received - post_id: {$post_id}, parent_id: {$parent_id}, comment_length: " . strlen($comment_text) . ", anonymous: {$is_anonymous}");
            log_message('debug', "Comment text: " . $comment_text);
            
            // ===== VALIDATION =====
            $alumni_id = $this->session->userdata('alumni_id');
            if (!$alumni_id) {
                file_put_contents($debug_file, "ERROR: No alumni_id in session\n", FILE_APPEND);
                if ($is_ajax) {
                    header('Content-Type: application/json; charset=utf-8');
                    exit(json_encode(['success' => false, 'message' => 'You must be logged in to comment.']));
                }
                $this->session->set_flashdata('error', 'You must be logged in');
                redirect($_SERVER['HTTP_REFERER'] ?? 'forum');
            }

            // ===== SPAM PREVENTION =====
            $cooldown_key = 'comment_cooldown_' . $alumni_id;
            $last_comment_time = $this->session->userdata($cooldown_key);
            
            if ($last_comment_time && (time() - $last_comment_time) < 10) {
                $remaining = 10 - (time() - $last_comment_time);
                file_put_contents($debug_file, "SPAM CHECK: User on cooldown, remaining: {$remaining}s\n", FILE_APPEND);
                if ($is_ajax) {
                    header('Content-Type: application/json; charset=utf-8');
                    exit(json_encode(['success' => false, 'message' => 'Please wait ' . $remaining . ' seconds between comments.']));
                }
                $this->session->set_flashdata('error', 'Please wait ' . $remaining . ' seconds');
                redirect($_SERVER['HTTP_REFERER'] ?? 'forum');
            }

            // ===== VALIDATE FIELDS =====
            if (empty($post_id) || empty($comment_text)) {
                file_put_contents($debug_file, "ERROR: Missing required fields - post_id empty: " . empty($post_id) . ", comment_text empty: " . empty($comment_text) . "\n", FILE_APPEND);
                if ($is_ajax) {
                    header('Content-Type: application/json; charset=utf-8');
                    exit(json_encode(['success' => false, 'message' => 'Post ID and comment are required.']));
                }
                $this->session->set_flashdata('error', 'All fields required');
                redirect($_SERVER['HTTP_REFERER'] ?? 'forum');
            }

            // ===== INSERT COMMENT =====
            $data = [
                'post_id' => $post_id,
                'parent_id' => $parent_id ?: 0,
                'alumni_id' => $alumni_id,
                'comment' => $comment_text,
                'is_anonymous' => $is_anonymous
            ];

            file_put_contents($debug_file, "About to insert: " . json_encode($data) . "\n", FILE_APPEND);
            log_message('debug', "About to insert comment: " . json_encode($data));
            
            $comment_id = $this->Forum_model->insert_comment($data);
            
            if (!$comment_id) {
                $db_error = $this->db->error();
                file_put_contents($debug_file, "DB insert FAILED: " . json_encode($db_error) . "\n", FILE_APPEND);
                log_message('error', "DB insert failed: " . json_encode($db_error));
                if ($is_ajax) {
                    header('Content-Type: application/json; charset=utf-8');
                    exit(json_encode(['success' => false, 'message' => 'Failed to save comment']));
                }
                $this->session->set_flashdata('error', 'Failed to save comment');
                redirect($_SERVER['HTTP_REFERER'] ?? 'forum');
            }

            // ===== SUCCESS =====
            file_put_contents($debug_file, "SUCCESS: Comment ID {$comment_id} inserted. Alumni: {$alumni_id}, Text: {$comment_text}\n", FILE_APPEND);
            log_message('info', "Comment created - ID: {$comment_id}, Alumni: {$alumni_id}, Text: {$comment_text}");
            
            // Set cooldown
            $this->session->set_userdata($cooldown_key, time());
            
            if ($is_ajax) {
                file_put_contents($debug_file, "Sending JSON response: success=true\n", FILE_APPEND);
                header('Content-Type: application/json; charset=utf-8');
                exit(json_encode(['success' => true, 'message' => 'Comment posted', 'comment_id' => $comment_id]));
            }
            
            redirect('forum/view/' . $post_id);
            
        } catch (Exception $e) {
            file_put_contents($debug_file, "EXCEPTION: " . $e->getMessage() . " at " . $e->getFile() . ':' . $e->getLine() . "\n", FILE_APPEND);
            log_message('error', 'Comment exception: ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
            
            if ($is_ajax) {
                header('Content-Type: application/json; charset=utf-8');
                exit(json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]));
            }
            
            $this->session->set_flashdata('error', 'Error: ' . $e->getMessage());
            redirect($_SERVER['HTTP_REFERER'] ?? 'forum');
        }
    }

    public function like($post_id){
        $alumni_id = $this->session->userdata('alumni_id');
        
        if ($alumni_id && $post_id) {
            $this->Forum_model->toggle_like($post_id, $alumni_id);
        }
        
        if ($this->input->is_ajax_request()) {
            $like_count = $this->db->query("SELECT COUNT(*) as cnt FROM forum_likes WHERE post_id = ?", [$post_id])->row()->cnt;
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => true, 'new_count' => $like_count]));
        } else {
            redirect('forum/view/'.$post_id);
        }
    }

    public function dislike($post_id){
        $alumni_id = $this->session->userdata('alumni_id');
        
        if ($alumni_id && $post_id) {
            $this->Forum_model->toggle_dislike($post_id, $alumni_id);
        }
        
        if ($this->input->is_ajax_request()) {
            $dislike_count = $this->db->query("SELECT COUNT(*) as cnt FROM forum_dislike WHERE post_id = ?", [$post_id])->row()->cnt;
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => true, 'new_count' => $dislike_count]));
        } else {
            redirect('forum/view/'.$post_id);
        }
    }

    /**
     * Like a comment
     */
    public function like_comment($comment_id, $post_id = null) {
        if (!$this->session->userdata('alumni_id')) {
            if ($this->input->is_ajax_request()) {
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode(['success' => false, 'message' => 'Not authenticated']));
            } else {
                redirect('login');
            }
            return;
        }
        
        $this->Forum_model->toggle_comment_like($comment_id, $this->session->userdata('alumni_id'));
        
        // Return JSON for AJAX requests
        if ($this->input->is_ajax_request()) {
            // Get like count from junction table
            $like_count = $this->db->where('comment_id', $comment_id)->count_all_results('forum_comment_likes');
            // Get dislike count from junction table
            $dislike_count = $this->db->where('comment_id', $comment_id)->count_all_results('forum_comment_dislikes');
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => true, 
                    'like_count' => (int)$like_count,
                    'dislike_count' => (int)$dislike_count
                ]));
        } else {
            redirect('forum/view/'.$post_id);
        }
    }

    /**
     * Dislike a comment
     */
    public function dislike_comment($comment_id, $post_id = null) {
        if (!$this->session->userdata('alumni_id')) {
            if ($this->input->is_ajax_request()) {
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode(['success' => false, 'message' => 'Not authenticated']));
            } else {
                redirect('login');
            }
            return;
        }
        
        $this->Forum_model->toggle_comment_dislike($comment_id, $this->session->userdata('alumni_id'));
        
        // Return JSON for AJAX requests
        if ($this->input->is_ajax_request()) {
            // Get dislike count from junction table
            $dislike_count = $this->db->where('comment_id', $comment_id)->count_all_results('forum_comment_dislikes');
            // Get like count from junction table
            $like_count = $this->db->where('comment_id', $comment_id)->count_all_results('forum_comment_likes');
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => true, 
                    'like_count' => (int)$like_count,
                    'dislike_count' => (int)$dislike_count
                ]));
        } else {
            redirect('forum/view/'.$post_id);
        }
    }

    public function delete($post_id)
    {
        $alumni_id = $this->session->userdata('alumni_id');

        $this->Forum_model->delete_post($post_id, $alumni_id);

         redirect('forum');
    }

    public function report()
    {
        $post_id = $this->input->post('post_id');
        $reason = $this->input->post('reason');

        if($reason == "Other"){
            $reason = $this->input->post('other_reason');
        }

        $data = [
        'post_id'=>$post_id,
        'alumni_id'=>$this->session->userdata('alumni_id'),
        'reason'=>$reason
        ];

        $this->Forum_model->report_post($data);

        redirect('forum/view/'.$post_id);
    }

    public function view($id = null)
    {
        if(!$id){
            redirect('forum');
        }

        $data['post'] = $this->Forum_model->get_post($id);
        $data['comments'] = $this->Forum_model->get_comments($id);

        // Apply profanity censoring to post
        if($data['post']){
            $post_result = censor_profanities($data['post']->title, $data['post']->alumni_id, $data['post']->id);
            $content_result = censor_profanities($data['post']->content, $data['post']->alumni_id, $data['post']->id);
            $data['post']->censored_title = $post_result['censored_text'];
            $data['post']->censored_content = $content_result['censored_text'];
            $data['post']->has_profanity = $post_result['is_profane'] || $content_result['is_profane'];
        }

        // Apply optimized profanity censoring to comments (once per alumni user)
        if($data['comments']){
            // Group comments by alumni_id
            $comments_by_alumni = [];
            foreach($data['comments'] as $comment){
                $alumni_id = $comment->alumni_id ?? 'anonymous';
                if (!isset($comments_by_alumni[$alumni_id])) {
                    $comments_by_alumni[$alumni_id] = [];
                }
                $comments_by_alumni[$alumni_id][] = $comment;
            }

            // Cache for censored results per alumni_id
            $alumni_comment_cache = [];
            
            foreach($data['comments'] as &$comment){
                $alumni_id = $comment->alumni_id ?? 'anonymous';
                
                // If we haven't censored this alumni's comments yet, do it now
                if (!isset($alumni_comment_cache[$alumni_id])) {
                    $sample_comment = reset($comments_by_alumni[$alumni_id]);
                    $comment_result = censor_profanities(
                        $sample_comment->comment, 
                        $alumni_id !== 'anonymous' ? $alumni_id : null, 
                        $data['post']->id ?? null
                    );
                    
                    // Cache this alumni's censoring result
                    $alumni_comment_cache[$alumni_id] = $comment_result;
                }
                
                // Apply cached result to this comment
                $cached_result = $alumni_comment_cache[$alumni_id];
                $comment->censored_comment = $cached_result['censored_text'];
                $comment->has_profanity = $cached_result['is_profane'];
            }
            unset($comment); // Break reference
        }

        // Add vote status to comments
        $alumni_id = $this->session->userdata('alumni_id');
        if($data['comments'] && $alumni_id){
            foreach($data['comments'] as &$comment){
                $comment->user_liked = $this->Forum_model->user_liked_comment($comment->id, $alumni_id);
                $comment->user_disliked = $this->Forum_model->user_disliked_comment($comment->id, $alumni_id);
                
                // Add vote status to nested replies if they exist
                if(isset($comment->replies) && is_array($comment->replies)){
                    foreach($comment->replies as &$reply){
                        $reply->user_liked = $this->Forum_model->user_liked_comment($reply->id, $alumni_id);
                        $reply->user_disliked = $this->Forum_model->user_disliked_comment($reply->id, $alumni_id);
                    }
                    unset($reply);
                }
            }
            unset($comment);
        }

        $this->load->view('__header');
        $this->load->view('user/forum_view',$data);
        $this->load->view('__footer');
    }

   public function live_search()
    {
        $search = $this->input->get('search');
        $sort   = $this->input->get('sort');
        $page   = (int) $this->input->get('page');

        $limit = 6; // same as your normal pagination
        $offset = $page ? $page : 0;

        $posts = $this->Forum_model->get_posts($limit,$offset,$search,$sort);
        $total = $this->Forum_model->count_posts($search,$sort);

        echo json_encode([
            "posts" => $posts,
            "total" => $total
        ]);
    }


   public function delete_comment($comment_id, $post_id = null)
    {
        $alumni_id = $this->session->userdata('alumni_id');

        // get comment
        $comment = $this->db->where('id',$comment_id)->get('forum_comments')->row();

        if (!$comment) {
            if ($this->input->is_ajax_request()) {
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode(['success' => false, 'message' => 'Comment not found']));
            } else {
                show_404();
            }
            return;
        }

        if($comment->alumni_id != $alumni_id) {
            if ($this->input->is_ajax_request()) {
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode(['success' => false, 'message' => 'Unauthorized']));
            } else {
                show_404();
            }
            return;
        }

        // soft delete replies
        $this->db->where('parent_id',$comment_id);
        $this->db->update('forum_comments', ['valid' => 0]);

        // soft delete comment
        $this->db->where('id',$comment_id);
        $this->db->update('forum_comments', ['valid' => 0]);

        // Return JSON for AJAX requests
        if ($this->input->is_ajax_request()) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => true, 'message' => 'Comment deleted']));
        } else {
            redirect('forum/view/'.$post_id);
        }
    }

    /**
     * Edit a comment
     */
    public function edit_comment()
    {
        // Always set JSON output first
        $this->output->set_content_type('application/json');
        
        try {
            // Log request details
            error_log('edit_comment called');
            error_log('Is AJAX: ' . ($this->input->is_ajax_request() ? 'yes' : 'no'));
            
            // Check authentication
            $alumni_id = $this->session->userdata('alumni_id');
            if (!$alumni_id) {
                throw new Exception('Not authenticated - please log in');
            }

            // Get input data
            $comment_id = trim($this->input->post('comment_id'));
            $comment_text = trim($this->input->post('comment_text'));

            error_log('Comment ID: ' . $comment_id);
            error_log('Comment text length: ' . strlen($comment_text));

            // Validate input
            if (empty($comment_id)) {
                throw new Exception('Missing comment ID');
            }
            
            if (empty($comment_text)) {
                throw new Exception('Comment text cannot be empty');
            }

            // Verify comment exists and get it
            $query = $this->db->get_where('forum_comments', array('id' => $comment_id));
            if ($query->num_rows() == 0) {
                throw new Exception('Comment not found');
            }
            
            $comment = $query->row();

            // Verify ownership
            if ($comment->alumni_id != $alumni_id) {
                throw new Exception('You can only edit your own comments');
            }

            // Clean/filter the text
            $filtered_text = $comment_text;
            
            // Try to apply profanity filter if available
            if (function_exists('censor_profanities')) {
                try {
                    $filter_result = censor_profanities($comment_text, $alumni_id);
                    if (is_array($filter_result) && isset($filter_result['censored_text'])) {
                        $filtered_text = $filter_result['censored_text'];
                    } else if (is_string($filter_result)) {
                        $filtered_text = $filter_result;
                    }
                } catch (Exception $e) {
                    error_log('Profanity filter error: ' . $e->getMessage());
                    // Continue without filtering if there's an error
                }
            }

            // Update the comment
            $this->db->where('id', $comment_id);
            $this->db->update('forum_comments', array('comment' => $filtered_text));

            if ($this->db->affected_rows() >= 0) {
                return $this->output->set_output(json_encode(array(
                    'success' => true,
                    'message' => 'Comment updated successfully'
                )));
            } else {
                throw new Exception('Update failed');
            }

        } catch (Exception $e) {
            error_log('Edit comment exception: ' . $e->getMessage());
            return $this->output->set_output(json_encode(array(
                'success' => false,
                'message' => $e->getMessage()
            )));
        } catch (Throwable $e) {
            error_log('Edit comment error: ' . $e->getMessage());
            return $this->output->set_output(json_encode(array(
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            )));
        }
    }

    public function update_post()
    {
        $post_id = $this->input->post('post_id');
        $alumni_id = $this->session->userdata('alumni_id');

        // Get current post
        $post = $this->db->where('id', $post_id)->get('forum_posts')->row();

        if(!$post || $post->alumni_id != $alumni_id) {
            if($this->input->is_ajax_request()) {
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode(['success' => false, 'message' => 'Unauthorized']));
            } else {
                show_404();
            }
            return;
        }

        $update_data = [
            'title' => $this->input->post('title'),
            'content' => $this->input->post('content')
        ];

        // Handle image upload
        if(!empty($_FILES['image']['name'])) {
            $config['upload_path'] = './assets/uploads/forum/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = 5000;

            $this->load->library('upload', $config);

            if($this->upload->do_upload('image')) {
                $upload_data = $this->upload->data();
                
                // Delete old image if exists
                if($post->image && file_exists('./assets/uploads/forum/'.$post->image)) {
                    unlink('./assets/uploads/forum/'.$post->image);
                }
                
                $update_data['image'] = $upload_data['file_name'];
            } else {
                // Upload failed
                if($this->input->is_ajax_request()) {
                    $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode(['success' => false, 'message' => $this->upload->display_errors()]));
                    return;
                }
            }
        }

        // Update post
        $this->db->where('id', $post_id);
        $success = $this->db->update('forum_posts', $update_data);

        // Check if AJAX request
        if($this->input->is_ajax_request()) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => $success,
                    'message' => $success ? 'Post updated successfully' : 'Error updating post'
                ]));
        } else {
            redirect('forum/view/'.$post_id);
        }
    }

    public function update_comment()
    {
        $id = $this->input->post('comment_id');

        $this->db->where('id',$id);
        $this->db->where('alumni_id',$this->session->userdata('alumni_id'));
        $this->db->update('forum_comments',[
            'comment'=>$this->input->post('comment')
        ]);

        redirect('forum/view/'.$this->input->post('post_id'));
    }

    public function generate_ai_content() {
        try {
            // Load Ollama config for AI processing
            $this->config->load('ollama', TRUE);
            
            $debug_file = APPPATH . 'logs/forum_ai_debug.log';
            file_put_contents($debug_file, "\n[" . date('Y-m-d H:i:s') . "] === Starting generate_ai_content ===\n", FILE_APPEND);

            // Set response as JSON
            $this->output->set_content_type('application/json');

            // Get parameters from query string
            $mode = $this->input->get('mode') ?? 'alumni';
            $title = $this->input->get('title') ?? '';
            $content = $this->input->get('content') ?? '';
            $topic = trim($title . ' ' . $content);
            if ($topic === '') {
                $topic = $this->fetch_college_topic();
            }
            $tone = 'helpful';

            file_put_contents($debug_file, "[" . date('Y-m-d H:i:s') . "] Mode: $mode, Title: $title, Content: $content\n", FILE_APPEND);

            // Build prompt based on mode
            switch ($mode) {
                case 'both':
                    $prompt = "You are a structured content generator for a forum. Return ONLY valid JSON, nothing else. No explanations, no markdown, just JSON.\n\n"
                             . "Topic: \"" . $topic . "\"\n"
                             . "Tone: \"" . $tone . "\"\n\n"
                             . "Rewrite and improve the post so it is clear, engaging, and relevant to alumni. Use the topic as the basis, but do not mention that the prompt was given.\n"
                             . "Return a catchy title, a forum category, a body using \\n for line breaks, a small list of tags, and an estimated reading time in minutes.\n"
                             . "Make the body suitable for a forum post and keep it concise but useful.\n\n"
                             . "Return this exact JSON structure:\n"
                             . "{\n"
                             . "\"title\": \"string (the catchy forum title)\",\n"
                             . "\"category\": \"string (the forum section)\",\n"
                             . "\"body\": \"string (the main post content, use \\n for line breaks)\",\n"
                             . "\"tags\": [\"string\", \"string\"],\n"
                             . "\"estimated_reading_time_minutes\": \"integer\"\n"
                             . "}";
                    break;
                    
                case 'title_only':
                    $prompt = "You are a structured content generator for a forum. Return ONLY valid JSON, nothing else. No explanations, no markdown, just JSON.\n\n"
                             . "Topic: \"" . $topic . "\"\n"
                             . "Tone: \"" . $tone . "\"\n\n"
                             . "Create a full forum post based on the topic. If the title is already good, keep it or lightly refine it.\n"
                             . "Return a category that fits the topic, a body with useful discussion points, 2 to 5 tags, and an estimated reading time in minutes.\n"
                             . "Use \\n for line breaks inside the body text.\n\n"
                             . "Return this exact JSON structure:\n"
                             . "{\n"
                             . "\"title\": \"string (the catchy forum title)\",\n"
                             . "\"category\": \"string (the forum section)\",\n"
                             . "\"body\": \"string (the main post content, use \\n for line breaks)\",\n"
                             . "\"tags\": [\"string\", \"string\"],\n"
                             . "\"estimated_reading_time_minutes\": \"integer\"\n"
                             . "}";
                    break;
                    
                case 'content_only':
                    $prompt = "You are a structured content generator for a forum. Return ONLY valid JSON, nothing else. No explanations, no markdown, just JSON.\n\n"
                             . "Topic: \"" . $topic . "\"\n"
                             . "Tone: \"" . $tone . "\"\n\n"
                             . "Use the provided content as the topic basis and expand it into a complete forum post.\n"
                             . "Return a catchy title, a category, a body with \\n line breaks, 2 to 5 tags, and an estimated reading time in minutes.\n\n"
                             . "Return this exact JSON structure:\n"
                             . "{\n"
                             . "\"title\": \"string (the catchy forum title)\",\n"
                             . "\"category\": \"string (the forum section)\",\n"
                             . "\"body\": \"string (the main post content, use \\n for line breaks)\",\n"
                             . "\"tags\": [\"string\", \"string\"],\n"
                             . "\"estimated_reading_time_minutes\": \"integer\"\n"
                             . "}";
                    break;
                    
                case 'alumni':
                default:
                    $random_topic = $this->fetch_college_topic();
                    $prompt = "You are a structured content generator for a forum. Return ONLY valid JSON, nothing else. No explanations, no markdown, just JSON.\n\n"
                             . "Topic: \"" . $random_topic . "\"\n"
                             . "Tone: \"" . $tone . "\"\n\n"
                             . "Generate a thoughtful alumni forum post that is relevant, practical, and discussion-friendly.\n"
                             . "Return a catchy title, a fitting category, a body with \\n line breaks, 2 to 5 tags, and an estimated reading time in minutes.\n\n"
                             . "Return this exact JSON structure:\n"
                             . "{\n"
                             . "\"title\": \"string (the catchy forum title)\",\n"
                             . "\"category\": \"string (the forum section)\",\n"
                             . "\"body\": \"string (the main post content, use \\n for line breaks)\",\n"
                             . "\"tags\": [\"string\", \"string\"],\n"
                             . "\"estimated_reading_time_minutes\": \"integer\"\n"
                             . "}";
                    break;
            }

            file_put_contents($debug_file, "[" . date('Y-m-d H:i:s') . "] Calling Ollama API...\n", FILE_APPEND);

            // Call Ollama API
            $result = call_ollama_api($prompt, [
                'temperature' => 1.0,
                'format' => 'json',
                'max_tokens' => 500,
                'system' => 'You are a helpful assistant that only outputs JSON. Do not include markdown code blocks. Return only the raw object with title, category, body, tags, and estimated_reading_time_minutes fields.'
            ]);

            if (!$result) {
                file_put_contents($debug_file, "[" . date('Y-m-d H:i:s') . "] ERROR: call_ollama_api returned false/null\n", FILE_APPEND);
                log_message('error', 'Ollama API Error: empty response');
                $this->output->set_output(json_encode(['error' => 'API Connection Failed', 'details' => 'No response from Ollama']));
                return;
            }

            file_put_contents($debug_file, "[" . date('Y-m-d H:i:s') . "] Ollama returned: " . json_encode($result) . "\n", FILE_APPEND);

            // Extract the text from response
            $raw_json_string = ai_extract_candidate_text($result);

            file_put_contents($debug_file, "[" . date('Y-m-d H:i:s') . "] Extracted text: $raw_json_string\n", FILE_APPEND);

            if ($raw_json_string === '') {
                file_put_contents($debug_file, "[" . date('Y-m-d H:i:s') . "] ERROR: ai_extract_candidate_text returned empty\n", FILE_APPEND);
                log_message('error', 'Ollama API Invalid Response Format: ' . print_r($result, true));
                $this->output->set_output(json_encode(['error' => 'Invalid API Response', 'details' => 'Could not extract text from response']));
                return;
            }

            // Validate that it's valid JSON
            $json_test = json_decode($raw_json_string, true);
            if (!$json_test) {
                file_put_contents($debug_file, "[" . date('Y-m-d H:i:s') . "] ERROR: Response is not valid JSON: $raw_json_string\n", FILE_APPEND);
                log_message('error', 'Response is not valid JSON: ' . $raw_json_string);
                $this->output->set_output(json_encode(['error' => 'Invalid JSON Response', 'raw' => substr($raw_json_string, 0, 200)]));
                return;
            }

            file_put_contents($debug_file, "[" . date('Y-m-d H:i:s') . "] SUCCESS: Valid JSON response\n", FILE_APPEND);

            // Pass the raw JSON directly back to the AJAX caller
            $this->output->set_output($raw_json_string);

        } catch (Exception $e) {
            file_put_contents(APPPATH . 'logs/forum_ai_debug.log', "[" . date('Y-m-d H:i:s') . "] EXCEPTION: " . $e->getMessage() . "\n", FILE_APPEND);
            log_message('error', 'Forum AI Exception: ' . $e->getMessage());
            $this->output->set_output(json_encode(['error' => 'Exception: ' . $e->getMessage()]));
        }
    }

    public function get_post_details($post_id = NULL) {
        $this->output->set_content_type('application/json');
        
        if (!$post_id) {
            $this->output->set_output(json_encode(['success' => false, 'message' => 'Post ID required']));
            return;
        }

        try {
            // Fetch post with user info
            $query = $this->db->query("
                SELECT 
                    fp.id, fp.title, fp.content, fp.like_count, fp.dislike_count, 
                    fp.comment_count, fp.created_at, fp.is_anonymous,
                    a.first_name, a.last_name, a.profile_image
                FROM forum_posts fp
                LEFT JOIN alumni a ON fp.alumni_id = a.id
                WHERE fp.id = ?
                LIMIT 1
            ", [$post_id]);

            if (!$query->num_rows()) {
                $this->output->set_output(json_encode(['success' => false, 'message' => 'Post not found']));
                return;
            }

            $post = $query->row();
            
            // Prepare post data
            $postData = [
                'id' => (int)$post->id,
                'title' => htmlspecialchars_decode($post->title),
                'content' => htmlspecialchars_decode($post->content),
                'like_count' => (int)$post->like_count,
                'dislike_count' => (int)$post->dislike_count,
                'created_at' => $post->created_at,
                'is_anonymous' => (bool)$post->is_anonymous,
                'author_name' => $post->is_anonymous ? 'Anonymous' : trim($post->first_name . ' ' . $post->last_name),
                'author_first' => $post->is_anonymous ? '?' : substr(strtoupper($post->first_name), 0, 1),
                'profile_image' => $post->profile_image ? $post->profile_image : null
            ];

            // Fetch comments with like/dislike counts
            $commentQuery = $this->db->query("
                SELECT 
                    fc.id, fc.comment, fc.created_at, fc.is_anonymous,
                    fc.like_count, fc.dislike_count,
                    a.first_name, a.last_name, a.profile_image
                FROM forum_comments fc
                LEFT JOIN alumni a ON fc.alumni_id = a.id
                WHERE fc.post_id = ?
                ORDER BY fc.created_at DESC
            ", [$post_id]);

            $comments = [];
            if ($commentQuery->num_rows()) {
                foreach ($commentQuery->result() as $comment) {
                    $comments[] = [
                        'id' => (int)$comment->id,
                        'comment' => htmlspecialchars_decode($comment->comment),
                        'created_at' => $comment->created_at,
                        'is_anonymous' => (bool)$comment->is_anonymous,
                        'author_name' => $comment->is_anonymous ? 'Anonymous' : trim($comment->first_name . ' ' . $comment->last_name),
                        'author_first' => $comment->is_anonymous ? '?' : substr(strtoupper($comment->first_name), 0, 1),
                        'like_count' => (int)$comment->like_count,
                        'dislike_count' => (int)$comment->dislike_count,
                        'profile_image' => $comment->profile_image ? $comment->profile_image : null
                    ];
                }
            }

            $this->output->set_output(json_encode([
                'success' => true,
                'post' => $postData,
                'comments' => $comments
            ]));
        } catch (Exception $e) {
            log_message('error', 'get_post_details error: ' . $e->getMessage());
            $this->output->set_output(json_encode([
                'success' => false, 
                'message' => 'An error occurred while loading the post'
            ]));
        }
    }

    // Fetch a random topic from St. Dominic College website
    private function fetch_college_topic() {
        $topics = [
            'SDCA Medical Laboratory Science Students Prepare for Taiwan Research Immersion',
            'SDCA and UNIMUS Renew Academic Partnership Through MOU Signing',
            'SIHTM Students Set Sail for International Cruise Immersion',
            'SDCA Hosts 6th Research, Extension, and Linkages Week',
            'SDCA Expands Global English Assessment Through TOEIC Testing',
            'St. Dominic College sustainability initiatives and innovations',
            'Alumni achievements and career success stories',
            'International partnerships and global opportunities for alumni',
            'Campus life and student experiences at St. Dominic College',
            'Alumni mentorship and professional development programs'
        ];
        
        // Return a random topic
        return $topics[array_rand($topics)];
    }

}