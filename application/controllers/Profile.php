<?php 
 
class Profile extends CI_Controller{
 
	function __construct(){
		parent::__construct();
		$this->load->model('user/Alumni_model');
        $this->load->model('Employment_model');
        $this->load->model('Standing_model');
        $this->load->helper('text');
        $this->load->helper('standing');
        $this->load->helper('profanity_filter');

		if($this->session->userdata('login_status') != "AezakmiHesoyamWhosyourdaddy"){
			redirect(base_url("Login"));
		}
	}
 
	function index(){
		$alumni_id = $this->session->userdata('alumni_id');
        if (!$alumni_id) {
            redirect('login');
        }
            $this->load->helper('text');

        $alumni = $this->Alumni_model->get_alumni_by_id($alumni_id);
        $employment = $this->Employment_model->get_by_alumni($alumni_id);
        $certifications = $this->Alumni_model->get_certifications($alumni_id);
        
        // Get alumni standing score and badge information
        $standing_result = $this->Standing_model->get_standing_score_debug($alumni_id);
        $standing_score = $standing_result['score'];
        $standing_breakdown = $standing_result['breakdown'];
        $standing_badge = get_standing_badge($standing_score);

          $data = [
            'alumni'             => $alumni,
            'employment'         => $employment,
            'certifications'     => $certifications,
            'standing_score'     => $standing_score,
            'standing_breakdown' => $standing_breakdown,
            'standing_badge'     => $standing_badge
        ];

        $this->load->view('__header', $data);
		$this->load->view('user/profile', $data);
		$this->load->view('__footer');
	}

public function update($id) {
    $this->load->model('user/Alumni_model');

    // Get inputs
    $graduation_year = $this->input->post('graduation_year');
    $email           = $this->input->post('email');
    $alt_email       = $this->input->post('alternative_email');
    $phone           = $this->input->post('phone');
    $alt_phone       = $this->input->post('alternative_phone');

    // Basic validation
    if (empty($graduation_year) || !is_numeric($graduation_year)) {
        $this->session->set_flashdata('edit_error', 'Graduation Year is required and must be a number.');
        $this->session->set_flashdata('show_edit_modal', true);
        redirect('profile');
        return;
    }

    // Check: Primary email and alternate email should not be the same
    if ($email === $alt_email) {
        $this->session->set_flashdata('edit_error', 'Alternate email must be different from your primary email.');
        $this->session->set_flashdata('show_edit_modal', true);
        redirect('profile');
        return;
    }

     if ($phone === $alt_phone) {
        $this->session->set_flashdata('edit_error', 'Alternate phone must be different from your primary phone.');
        $this->session->set_flashdata('show_edit_modal', true);
        redirect('profile');
        return;
    }

    // Prepare update data (NO alumni_number, NO student_number)
    $data = array(
        'first_name'        => $this->input->post('first_name'),
        'last_name'         => $this->input->post('last_name'),
        'phone'             => $phone,
        'alternative_phone' => $alt_phone,
        'email'             => $email,
        'alternative_email' => $alt_email,
        'graduation_year'   => $graduation_year,
        'degree'            => $this->input->post('degree'),
    );

    // Handle profile image upload
    if (!empty($_FILES['profile_image']['name'])) {
        $config['upload_path']   = './assets/uploads/alumni/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size']      = 7048;
        $config['file_name']     = uniqid() . '_' . $_FILES['profile_image']['name'];

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('profile_image')) {
            $uploadData = $this->upload->data();
            $data['profile_image'] = $uploadData['file_name'];
        }
    }

    // Perform update
    $this->Alumni_model->update_alumni($id, $data);

    // Log activity
    $this->load->model('Activity_log_model');
    $this->Activity_log_model->log_activity($id, 'Updated his/her Profile');

    // Success message
    $this->session->set_flashdata('edit_success', 'Profile updated successfully.');
    $this->session->set_flashdata('show_edit_modal', true);
    redirect('profile');
}



public function update_job_info($id)
{
    $this->load->model('user/Alumni_model');
    $data = [
        'current_job' => $this->input->post('current_job'),
        'current_job_organization' => $this->input->post('current_job_organization'),
        'current_job_length' => $this->input->post('current_job_length')
    ];

    $this->Alumni_model->update_alumni($id, $data);

    $this->session->set_flashdata('success', 'Job information updated successfully.');
    redirect('profile'); // Adjust this as per your route
}
public function update_skill_info($id)
{
    $this->load->model('user/Alumni_model');

    // Retrieve multi-select inputs (arrays or strings)
    $soft = $this->input->post('soft_skills');
    $tech = $this->input->post('technical_skills');

    // Convert arrays to comma-separated strings
    if (is_array($soft)) {
        $soft = implode(", ", $soft);
    }

    if (is_array($tech)) {
        $tech = implode(", ", $tech);
    }

    $data = [
        'soft_skills'      => $soft,
        'technical_skills' => $tech
    ];

    // Update database
    $this->Alumni_model->update_alumni($id, $data);

    // Success message
    $this->session->set_flashdata('success', 'Skills updated successfully.');
    redirect('profile');
    }

    // Certification Management
    public function add_certification($id) {
        $alumni_id = $this->session->userdata('alumni_id');
        if ($alumni_id != $id) redirect('profile');

        $data = [
            'alumni_id' => $alumni_id,
            'title' => $this->input->post('title'),
            'issuer' => $this->input->post('issuer'),
            'date_issued' => $this->input->post('date_issued')
        ];

        if (!empty($_FILES['certificate_image']['name'])) {
            $config['upload_path']   = './assets/uploads/alumni/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['file_name']     = uniqid() . '_cert_' . $_FILES['certificate_image']['name'];

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('certificate_image')) {
                $uploadData = $this->upload->data();
                $data['certificate_image'] = $uploadData['file_name'];
            }
        }

        $this->Alumni_model->add_certification($data);
        $this->session->set_flashdata('success', 'Certification added successfully.');
        redirect('profile');
    }

    public function delete_certification($cert_id) {
        $alumni_id = $this->session->userdata('alumni_id');
        $this->Alumni_model->delete_certification($cert_id, $alumni_id);
        $this->session->set_flashdata('success', 'Certification removed.');
        redirect('profile');
    }

    public function update_cover_photo($id) {
        $alumni_id = $this->session->userdata('alumni_id');
        if ($alumni_id != $id) redirect('profile');

        if (!empty($_FILES['cover_photo']['name'])) {
            $config['upload_path']   = './assets/uploads/alumni/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['file_name']     = uniqid() . '_cover_' . $_FILES['cover_photo']['name'];

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('cover_photo')) {
                $uploadData = $this->upload->data();
                $this->Alumni_model->update_alumni($id, ['cover_photo' => $uploadData['file_name']]);
                $this->session->set_flashdata('success', 'Cover photo updated.');
            }
        }
        redirect('profile');
    }

    /**
     * Ultra simple test
     */
    public function test()
    {
        $alumni_id = $this->session->userdata('alumni_id');
        echo "Alumni ID: " . $alumni_id;
    }

    /**
     * Simple standing check - just show the score
     */
    public function check_standing()
    {
        $alumni_id = $this->session->userdata('alumni_id');
        if (!$alumni_id) {
            echo "Not logged in";
            return;
        }

        $this->load->model('Standing_model');
        $score = $this->Standing_model->get_standing_score($alumni_id);
        
        echo "Alumni ID: " . $alumni_id . "<br>";
        echo "Standing Score: " . $score . " points<br>";
        
        // Get posts count
        $posts = $this->db->where('alumni_id', $alumni_id)->get('forum_posts')->result();
        echo "Posts: " . count($posts) . "<br><br>";
        
        echo "Expected: " . (count($posts) * 5) . " points (from posts alone)<br>";
    }

    /**
     * Debug endpoint to check standing score calculation
     * Accessible at: /profile/debug_standing
     */
    public function debug_standing()
    {
        $alumni_id = $this->session->userdata('alumni_id');
        if (!$alumni_id) {
            redirect('login');
        }

        $result = $this->Standing_model->get_standing_score_debug($alumni_id);
        $score = $result['score'];
        $breakdown = $result['breakdown'];

        // Get actual posts
        $posts = $this->db->where('alumni_id', $alumni_id)->get('forum_posts')->result();
        $post_count = count($posts);

        echo "<!DOCTYPE html>
        <html>
        <head>
            <title>Standing Points Debug</title>
            <style>
                body { font-family: Arial; margin: 20px; background: #f5f5f5; }
                .container { max-width: 1200px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; }
                h2 { color: #333; border-bottom: 2px solid #a12124; padding-bottom: 10px; }
                h3 { color: #666; }
                table { width: 100%; border-collapse: collapse; margin: 10px 0; }
                table, th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
                th { background: #a12124; color: white; }
                .total { font-size: 24px; color: #a12124; font-weight: bold; background: #fffbeb; padding: 20px; border-radius: 8px; border-left: 4px solid #a12124; }
                .error { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; }
                .success { background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; }
            </style>
        </head>
        <body>
        <div class='container'>
            <h2>🔍 Standing Points Debug Report</h2>
            <p><strong>Alumni ID:</strong> $alumni_id</p>
            
            <h3>1. Posts in Database</h3>";
            
            if ($post_count == 0) {
                echo "<div class='error'><strong>⚠️ No posts found!</strong> You need to create posts first.</div>";
            } else {
                echo "<div class='success'><strong>✓ Found $post_count post(s)</strong></div>";
                echo "<table>";
                echo "<tr><th>Post ID</th><th>Title</th><th>Created At</th></tr>";
                foreach ($posts as $p) {
                    echo "<tr>";
                    echo "<td>#{$p->id}</td>";
                    echo "<td>" . htmlspecialchars(substr($p->title, 0, 50)) . "</td>";
                    echo "<td>{$p->created_at}</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
            
            echo "<h3>2. Points Calculation Breakdown</h3>";
            echo "<table>";
            echo "<tr><th>Category</th><th>Count</th><th>Points/Penalty Per</th><th>Total</th></tr>";
            
            foreach ($breakdown as $key => $data) {
                $label = ucfirst(str_replace('_', ' ', $key));
                $pointType = isset($data['points_per']) ? $data['points_per'] : (isset($data['penalty_per']) ? $data['penalty_per'] : 'N/A');
                echo "<tr>";
                echo "<td>$label</td>";
                echo "<td>{$data['count']}</td>";
                echo "<td>$pointType</td>";
                echo "<td><strong>" . $data['total'] . "</strong></td>";
                echo "</tr>";
            }
            echo "</table>";
            
            echo "<div class='total'>Total Standing: <strong>$score points</strong></div>";
            
            if ($post_count > 0 && $score == 0) {
                echo "<div class='error'><strong>🚨 Problem Detected:</strong> You have $post_count posts but 0 points! This suggests a calculation error. Please report this to admin.</div>";
            } elseif ($score > 0) {
                echo "<div class='success'><strong>✓ Correct!</strong> Your standing is being calculated.</div>";
            }
            
            echo "</div></body></html>";
    }
}