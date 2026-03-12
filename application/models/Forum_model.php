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
            AND parent_id = 0) as comment_count,
            (SELECT COUNT(*) FROM forum_likes WHERE post_id=forum_posts.id) as like_count
        ");

        $this->db->from('forum_posts');
        $this->db->join('alumni','alumni.id=forum_posts.alumni_id','left');

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

        $this->db->select('forum_comments.*, alumni.first_name, alumni.last_name');
        $this->db->from('forum_comments');
        $this->db->join('alumni','alumni.id=forum_comments.alumni_id','left');
        $this->db->where('post_id',$post_id);

        return $this->db->get()->result();
    }

    public function insert_comment($data){
        return $this->db->insert('forum_comments',$data);
    }

    public function toggle_like($post_id,$alumni_id){

        $this->db->where('post_id',$post_id);
        $this->db->where('alumni_id',$alumni_id);
        $like = $this->db->get('forum_likes')->row();

        if($like){
            $this->db->delete('forum_likes',['id'=>$like->id]);
        }else{
            $this->db->insert('forum_likes',[
                'post_id'=>$post_id,
                'alumni_id'=>$alumni_id
            ]);
        }
    }

    public function count_likes($post_id){
        return $this->db->where('post_id',$post_id)->count_all_results('forum_likes');
    }

    public function user_liked($post_id,$alumni_id){
        return $this->db->where('post_id',$post_id)->where('alumni_id',$alumni_id)->get('forum_likes')->row();
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

            // delete related data
            $this->db->delete('forum_likes', ['post_id'=>$post_id]);
            $this->db->delete('forum_comments', ['post_id'=>$post_id]);
            $this->db->delete('forum_reports', ['post_id'=>$post_id]);

            // delete post
            $this->db->delete('forum_posts', ['id'=>$post_id]);

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
            AND parent_id = 0) as comment_count,
            (SELECT COUNT(*) FROM forum_likes WHERE post_id=forum_posts.id) as like_count
        ");

        $this->db->from('forum_posts');
        $this->db->join('alumni','alumni.id = forum_posts.alumni_id','left');
        $this->db->where('forum_posts.id',$id);

        return $this->db->get()->row();
    }


}