<?php

class Pages extends CI_Controller {

        public function __construct()
	{
            parent::__construct();
            $this->load->model('post_model'); // load post model
        }
        
	public function view($page = 'home')
	{
		if ( ! file_exists('application/views/pages/'.$page.'.php'))
		{
			// Whoops, we don't have a page for that!
			show_404();
		}
		
                if($page == 'home')
                {
                    if($this->session->userdata('logged_in') == TRUE)
                    {
                        redirect('/posts', 'refresh');
                    }
                    $data['title'] = 'SociaPanda | Networking for All'; // Capitalize the first letter

                     // get all posts
                    $data['post'] = $this->post_model->get_posts(5);
                    
                    $this->load->view('templates/header', $data);
                    $this->load->view('pages/'.$page, $data);
                    
                    // set layout variables
                    $data['permalink'] = TRUE;
                    $data['span'] = 6;    
                    $this->load->view('templates/row-open', $data);
                    
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
                    $this->load->view('templates/footer', $data);
                }
                else
                {
                    $data['title'] = ucfirst($page); // Capitalize the first letter

                    $this->load->view('templates/header', $data);
                    $this->load->view('pages/'.$page, $data);
                    $this->load->view('templates/footer', $data);
                }
		
		
	}
}
/* End of file pages.php */
/* Location: ./application/controllers/pages.php */