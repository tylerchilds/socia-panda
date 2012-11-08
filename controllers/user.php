<?php

class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model'); // load user model
                $this->load->model('post_model'); // load user model
                $this->load->library("pagination");
        }

	public function index()
	{
		$this->load->view('success');
	}
	
	public function account()
	{
            // check to make sure user is a logged in user
            if($this->session->userdata('logged_in') != TRUE)
            {
                redirect('/posts', 'refresh');	
            }
            else
            {
                // load helpers for form validation
                $this->load->library('form_validation');

                $data['title'] = 'Edit Profile';
                $data['id'] = $this->session->userdata('humanoid');

                // get profile information based on the user id in the cookie
                $result = $this->user_model->profile_info($this->session->userdata('humanoid'));

                if($result)
                {
                    // get profile information and pass them into the data array
                    foreach($result as $row)
                    {
                        $data['gender'] = $row->profileGender;
                        $data['status'] = $row->profileStatus;
                        $data['info'] = html_entity_decode($row->profileInfo);
                        $data['photo'] = $row->profilePhoto;
                    }				
                }

                // validation to be run
                $this->form_validation->set_rules('alias', 'Alias', 'trim|required|min_length[5]|max_length[20]|xss_clean|callback_check_alias');
                $this->form_validation->set_rules('gender', 'Gender', 'xss_clean');
                $this->form_validation->set_rules('status', 'Relationship Status', 'xss_clean');
                $this->form_validation->set_rules('info', 'Information', 'trim|xss_clean|htmlspecialchars');
                $this->form_validation->set_rules('photo', 'Profile Picture', 'callback_profile_photo');


                // if the validation has not yet passed
                if ($this->form_validation->run() === FALSE)
                {
                    $this->load->view('templates/header', $data);
                    $this->load->view('forms/edit-profile', $data);
                    $this->load->view('templates/footer');
                }
                else
                {
                    $result = $this->user_model->update_profile($this->session->userdata('humanoid'));

                    $data['gender'] = $this->input->post('gender');
                    $data['status'] = $this->input->post('status');
                    $data['info'] = $this->input->post('info');
                    if($_FILES['photo']['name'] != "")
                    {
                        $data['photo'] = '/img/profile/'.$this->session->userdata('humanoid').'.jpg';
                    }
                                
                    $this->session->unset_userdata('alias');
                    $this->session->set_userdata('alias', $this->input->post('alias')); 

                    $data['success'] = TRUE;
                    // successfully updated profile
                    $this->load->view('templates/header', $data);
                    $this->load->view('forms/edit-profile', $data);
                    $this->load->view('templates/footer');			
                }
            }
	}
		
	public function profile($profile = 0)
	{				
            $data['alias'] = $profile;
            $result = $this->user_model->get_id($profile);

            if($result)
            {
                // get profile information and pass them into the data array
                foreach($result as $row)
                {
                        $data['id'] = $row->userID;
                }
            }
            else
            {
                show_404();
            }

            // pagination junk
            $config['base_url'] = "/user/profile/".$data['alias'];
            $config['per_page'] = 20;
            $config['uri_segment'] = 4;
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';
            $config['next_tag_open'] = '<li class="next-link">';
            $config['next_tag_close'] = '</li>';
            $config['prev_tag_open'] = '<li class="prev-link">';
            $config['prev_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li class="active"><a href="#">';
            $config['cur_tag_close'] = '</a></li>';
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            
            $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
            
            // get profile information based on the user id in the cookie
            $result = $this->user_model->profile_info($data['id']);

            if($result)
            {
                    // get profile information and pass them into the data array
                    foreach($result as $row)
                    {
                        $data['userID'] = $row->userID;
                        $data['gender'] = $row->profileGender;
                        $data['status'] = $row->profileStatus;
                        $data['info'] = $row->profileInfo;
                        $data['photo'] = $row->profilePhoto;
                    }				
            }
            
            // get all posts for user
            $config['total_rows'] = $this->user_model->count_posts_user($data['userID']);
            $data['post'] = $this->user_model->get_posts_user($data['userID'], $config["per_page"], $page);

            $this->pagination->initialize($config);

            $data['pagination'] = $this->pagination->create_links();
            
            // check to see if query was empty
            if($data['post'])
            {
                    foreach ($data['post'] as $postarr)
                    {
                        $data['count'.$postarr['postID']] = $this->post_model->count_comments($postarr['postID']);
                        $data['comment'.$postarr['postID']] = $this->post_model->get_comments($postarr['postID'], 3);
                    }
            }

            $data['title'] = 'Profile for '.$data['alias'];
            
            $data['is_following'] = $this->user_model->is_following($this->session->userdata('humanoid'), $data['id']);
            $data['following'] = $this->user_model->following($data['id']);
            $data['followers'] = $this->user_model->followers($data['id']);

            // set layout variables
            $data['permalink'] = TRUE;
            $data['span'] = 6;    
            
            $this->load->view('templates/header', $data);
            $this->load->view('profile/user-info', $data);
            $this->load->view('templates/row-open', $data);
            $this->load->view('templates/pagination', $data);
            $this->load->view('post-list', $data);
            $this->load->view('templates/close-div');
            $this->load->view('profile/friends', $data);
            $this->load->view('templates/footer');
	}
        
        public function follow($user = FALSE)
        {
            if($this->session->userdata('logged_in') == TRUE && $this->user_model->user_exists($user))
            {
                $myID = $this->session->userdata('humanoid');
                $userID = $this->user_model->get_userID($user);
                
                if($myID != $userID)
                {
                    $this->user_model->set_follow($myID, $userID);
                }
                redirect('/user/profile/'.$user, 'refresh');	
            }
            else
            {
                // user not logged in
                redirect('/posts', 'refresh');	
            }
        }
        
        public function unfollow($user = FALSE)
        {
            if($this->session->userdata('logged_in') == TRUE && $this->user_model->user_exists($user))
            {
                $myID = $this->session->userdata('humanoid');
                $userID = $this->user_model->get_userID($user);
                
                if($myID != $userID)
                {
                    $this->user_model->not_follow($myID, $userID);
                }
                redirect('/user/profile/'.$user, 'refresh');	
            }
            else
            {
                // user not logged in
                redirect('/posts', 'refresh');	
            }
        }
	
	function profile_photo()
	{
            if($_FILES['photo']['name'] == "")
            {
                return TRUE;
            }
            // upload restrictions
            $config['upload_path'] = './img/profile/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['file_name'] = $this->session->userdata('humanoid').'.jpg';
            $config['max_size']	= '4096';
            $config['max_width']  = '3072';
            $config['max_height']  = '3072';
            $config['overwrite']  = TRUE;

            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('photo'))
            {
                // validation 
                $this->form_validation->set_message('profile_photo', $this->upload->display_errors());
                return FALSE;
            }
            else
            {
                return TRUE;
            }
	}
        
        function check_alias($alias)
	{
            $uid = $this->user_model->get_userid($alias);
            
            if($uid == $this->session->userdata('humanoid'))
            {
                return TRUE;
            }
            elseif($this->user_model->check_alias($alias, $uid))
            {
                $this->form_validation->set_message('check_alias', 'Alias already exists');
                return FALSE; 
            }
            elseif(preg_match('/^panda[0-9]/', $alias))
            {
               $this->form_validation->set_message('check_alias', 'Alias can not be Panda and a number');
               return FALSE; 
            }
            elseif( ! preg_match('/^[a-zA-Z0-9_]+$/', $alias))
            {
               $this->form_validation->set_message('check_alias', 'Alias may only be alpha numeric or underscores');
               return FALSE; 
            }   
            else
            {
                return TRUE;
            }    
        }
        
}
/* End of file user.php */
/* Location: ./application/controllers/user.php */