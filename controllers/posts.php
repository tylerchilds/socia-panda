<?php

class Posts extends CI_Controller {

	public function __construct()
	{
            parent::__construct();
            $this->load->model('post_model'); // load post model
            $this->load->library("pagination");
        }

	public function index()
	{
            // pagination junk
            $config['base_url'] = "/posts/index";
            $config['total_rows'] = $this->post_model->count_posts();
            $config['per_page'] = 20;
            $config['uri_segment'] = 3;
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
            $this->pagination->initialize($config);
            
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            
            $data['title'] = 'All Posts';

            $this->load->view('templates/header', $data);

            $data['type'] = $this->post_model->get_types();

            // get all posts
            $data['post'] = $this->post_model->get_posts($config["per_page"], $page);
            $data['pagination'] = $this->pagination->create_links();

            $this->load->view('filters', $data);

            // set layout variables
            $data['permalink'] = TRUE;
            $data['span'] = 9;    
            $this->load->view('templates/row-open', $data);

            $this->load->view('page-title', $data);
            $this->load->view('templates/pagination', $data);

            // check logged in
            if($this->session->userdata('logged_in') == TRUE)
            {                  
                // display post form
                $this->load->view('forms/post', $data);
            }



            // check to see if query was empty
            if($data['post'])
            {
                    foreach ($data['post'] as $postarr)
                    {
                            $data['count'.$postarr['postID']] = $this->post_model->count_comments($postarr['postID']);
                            $data['comment'.$postarr['postID']] = $this->post_model->get_comments($postarr['postID'], 3);
                    }
                    $this->load->view('post-list', $data);
            }

            $this->load->view('templates/close-div');
            $this->load->view('templates/footer');
	}
        
        public function view($cat = FALSE)
	{
            if($cat == FALSE)
            {
                redirect('/posts', 'refresh');
            }
            
            $data['title'] = $cat;
                
            // pagination junk
            $config['base_url'] = "/posts/view/".$cat;
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
		
            $this->load->view('templates/header', $data);

            if($cat == "following")
            {
                $str = $this->post_model->get_following($this->session->userdata('humanoid'));
                if($str)
                {
                    $config['total_rows'] = $this->post_model->count_posts_friends($str);
                    $data['post'] = $this->post_model->get_posts_friends($str, $config["per_page"], $page);
                }
            }
            elseif($cat == "followers")
            {
                $str = $this->post_model->get_followers($this->session->userdata('humanoid'));
                if($str)
                {
                    $config['total_rows'] = $this->post_model->count_posts_friends($str);
                    $data['post'] = $this->post_model->get_posts_friends($str, $config["per_page"], $page);
                }
            }
            else
            {
                // get all posts
                $data['category'] = $cat;
                $config['total_rows'] = $this->post_model->count_posts_type($cat);
                $data['post'] = $this->post_model->get_posts_type($cat, $config["per_page"], $page);
            }
                
            $this->pagination->initialize($config);

            $data['pagination'] = $this->pagination->create_links();
            $data['type'] = $this->post_model->get_types();

            $this->load->view('filters', $data);

            // set layout variables
            $data['permalink'] = TRUE;
            $data['span'] = 9;    
            $this->load->view('templates/row-open', $data);

            $this->load->view('page-title', $data);
            $this->load->view('templates/pagination', $data);
            // check logged in
            if($this->session->userdata('logged_in') == TRUE)
            {                  
                // display post form
                $this->load->view('forms/post', $data);
            }             

            // check to see if query was empty
            if(isset($data['post']))
            {
                    foreach ($data['post'] as $postarr)
                    {
                        $data['count'.$postarr['postID']] = $this->post_model->count_comments($postarr['postID']);
                        $data['comment'.$postarr['postID']] = $this->post_model->get_comments($postarr['postID'], 3);
                    }
                    $this->load->view('post-list', $data);
            }
            else
            {
                $data['output'] = 'Sorry, no results to display.';
                $this->load->view('templates/output', $data);
            }

            $this->load->view('templates/close-div');
            $this->load->view('templates/footer');
	}
		
	public function create()
	{	
		$data['title'] = 'Create Post';
		// check logged in
		if($this->session->userdata('logged_in') == TRUE)
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('postText', 'Post', 'trim|xss_clean|htmlspecialchars|callback_logged_in|callback_hyperlink');
			
			if ($this->form_validation->run() === FALSE)
			{
				$this->load->view('templates/header', $data);
				
				// get the post types
				$data['type'] = $this->post_model->get_types();

				$this->load->view('forms/post', $data);
				$this->load->view('templates/footer');
			}
			else
			{
				$this->post_model->make_post($this->session->userdata('humanoid'));
                                if($this->input->post('postType') != "all")
                                {
                                    $this->post_model->link_type($this->db->insert_id());
                                    $result = $this->post_model->get_type_title($this->input->post('postType'));
                                    foreach ($result as $row)
                                    {
                                       $typeTitle = $row['typeTitle'];
                                    }
                                    redirect('/posts/view/'.$typeTitle, 'refresh');	
                                }
				
				redirect('/posts', 'refresh');	
			}
		}
		else
		{
			redirect('/posts', 'refresh');	
		}
	}
	
	public function thread($postID = 0)
    {
            if($this->input->post('postID'))
            {
                $postID = $this->input->post('postID');
            }
            
            $data['post'] = $this->post_model->single_post($postID);
            
            if(empty($data['post']))
            {
                show_404();			
            }

            $data['postID'] = $postID;

            $data['post'] = $this->post_model->single_post($postID);
            // pagination junk
            $config['base_url'] = "/posts/thread/".$postID;
            $config['total_rows'] = $this->post_model->count_comments($postID);
            $config['per_page'] = 50;
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
            
            $data['title'] = 'Single Post';

            $data['comment'.$postID] = $this->post_model->get_comments($postID, $config["per_page"], $page, "desc");

            $this->pagination->initialize($config);
            
            $data['pagination'] = $this->pagination->create_links();
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('commentText', 'Comment', 'trim|xss_clean|htmlspecialchars|callback_logged_in|callback_hyperlink');

            if ($this->form_validation->run() === FALSE)
            {
                    $this->load->view('templates/header', $data);

                    $data['type'] = $this->post_model->get_types();

                    $this->load->view('filters', $data);

                    // set layout variables
                    $data['span'] = 9;    
                    $this->load->view('templates/row-open', $data);
                    $this->load->view('templates/pagination', $data);

                    $this->load->view('single-post', $data);

                    // check logged in
                    if($this->session->userdata('logged_in') == TRUE)
                    {
                            $this->load->view('forms/comment', $data);
                    }
                    $this->load->view('templates/close-div');
                    $this->load->view('templates/footer');
            }
            else
            {
                    $result = $this->post_model->make_comment($this->session->userdata('humanoid'));
                    redirect('/posts/thread/'.$postID, 'refresh');	
            }
	}
	
	function logged_in()
	{
		if($this->session->userdata('logged_in') == TRUE)
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('logged_in', 'You are not logged in, cheater.');
			return FALSE;
		}
	}
        
        function hyperlink($text)
	{
            $text = preg_replace("/(https?:\/\/)?([a-zA-Z0-9\-.]+\.[a-zA-Z0-9\-]+([\/]([a-zA-Z0-9_\/\-.?&%=+])*)*)/", '<a href="http://$2" target="_blank">$2</a>', $text);
            return $text;
        }
	
}
/* End of file posts.php */
/* Location: ./application/controllers/posts.php */