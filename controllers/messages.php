<?php

class Messages extends CI_Controller {

	public function __construct()
	{
            parent::__construct();
            $this->load->model('message_model'); // load user model
        }

	public function index()
	{
            if($this->session->userdata('logged_in') != TRUE)
            {
                // display post form
                redirect('/posts', 'refresh');
            }

            $data['title'] = 'Messages';
            $data['myAlias'] = $this->session->userdata('alias');

             // set layout variables
            $data['indent'] = TRUE;
            $data['offset'] = 3;
            $data['span'] = 6;            
            
            $this->load->view('templates/header', $data);
            $this->load->view('templates/row-open', $data);
            // get all posts
            $data['threads'] = $this->message_model->get_threads($this->session->userdata('humanoid'));
            
            if($data['threads'])
            {
                foreach ($data['threads'] as $thread)
                {
                    $data['users'.$thread['threadID']] = $this->message_model->get_thread_users($thread['threadID']);
                    $data['message'.$thread['threadID']] = $this->message_model->get_thread_message($thread['threadID']);
                }
                
                $this->load->view('messages/message-list', $data);
            }
            else
            {
                $this->load->view('messages/no-messages', $data);
            }
            
            $this->load->view('templates/close-div');

            $this->load->view('templates/footer');
	}
		
	public function new_message($user = FALSE)
	{	
            if($this->input->post('userAlias'))
            {
                    $user = $this->input->post('userAlias');
            }
            
            if($this->session->userdata('logged_in') == TRUE && $this->message_model->user_exists($user))
            {
                $data['title'] = 'New Message';
                
                // getting valid user info
                $data['userID'] = $this->message_model->get_user_info($user); 
                $data['userAlias'] = $user;
                $data['myID'] = $this->session->userdata('humanoid');
                $data['myAlias'] = $this->session->userdata('alias');
                
                $this->load->library('form_validation');
                $this->form_validation->set_rules('message', 'Message', 'trim|xss_clean|callback_logged_in');

                if ($this->form_validation->run() === FALSE)
                {
                    $data['create'] = TRUE;
                    
                    // validation has failed or has not yet run, load form
                    
                    // set layout variables
                    $data['indent'] = TRUE;
                    $data['offset'] = 3;
                    $data['span'] = 6;
                    
                    $this->load->view('templates/header', $data);
                    $this->load->view('templates/row-open', $data);
                    $this->load->view('forms/message', $data);
                    $this->load->view('templates/close-div');
                    $this->load->view('templates/footer');
                }
                else
                {
                    // make the thread
                    $this->message_model->make_thread();
                    // get the new thread id
                    $threadID = $this->db->insert_id();
                    // put message in db
                    $this->message_model->send_message($threadID, $data['myID']);
                    // link the valid users
                    $this->message_model->link_user($threadID, $data['myID']);
                    $this->message_model->link_user($threadID, $data['userID']);
                    
                     // mark threads unread
                    $this->message_model->mark_unread($threadID, $data['myID']);
                    
                    // show the new messages
                    redirect('/messages/view/'.$threadID, 'refresh');	
                }
            }
            else
            {
                // user not logged in
                redirect('/messages', 'refresh');	
            }
	}
        
        public function view($threadID = FALSE)
	{	            
            if($this->input->post('threadID'))
            {
                    $threadID = $this->input->post('threadID');
            }
            $data['threadID'] = $threadID;
            $data['myID'] = $this->session->userdata('humanoid');
            $data['myAlias'] = $this->session->userdata('alias');
            
            if($this->session->userdata('logged_in') == TRUE && $threadID != FALSE && $this->message_model->valid_user($threadID, $data['myID']))
            {
                $this->message_model->mark_read($threadID, $data['myID']);
                // getting valid user info
                $data['users'] = $this->message_model->get_thread_users($threadID);
                $data['message'] = $this->message_model->get_messages($threadID);
                
                $data['title'] = 'New Message';
                
                $this->load->view('templates/header', $data);
                             
                $data['span'] = 8;
                $this->load->view('templates/row-open', $data);
                $this->load->view('messages/display', $data);
                
                $this->load->library('form_validation');
                $this->form_validation->set_rules('message', 'Message', 'trim|xss_clean|callback_logged_in');

                if ($this->form_validation->run() === FALSE)
                {                    
                    // validation has failed or has not yet run, load form
                    $this->load->view('forms/message', $data);
                }
                else
                {
                    // put message in db
                    $this->message_model->send_message($threadID, $data['myID']);
                    // mark threads unread
                    $this->message_model->mark_unread($threadID, $data['myID']);
                    
                    // show the new messages
                    redirect('/messages/view/'.$threadID, 'refresh');	
                }
                
                $this->load->view('templates/close-div');
                
                // get all posts
                $data['threads'] = $this->message_model->get_threads($this->session->userdata('humanoid'));

                if($data['threads'])
                {
                    foreach ($data['threads'] as $thread)
                    {
                        $data['users'.$thread['threadID']] = $this->message_model->get_thread_users($thread['threadID']);
                        $data['message'.$thread['threadID']] = $this->message_model->get_thread_message($thread['threadID']);
                    }
                    
                    // set layout variables
                    $data['span'] = 4;
                    $this->load->view('templates/row-open', $data);
                    $this->load->view('messages/message-list', $data);
                }
                
                $this->load->view('templates/close-div');
                $this->load->view('templates/footer');
            }
            else
            {
                // user not logged in
                redirect('/posts', 'refresh');	
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
	
}
/* End of file messages.php */
/* Location: ./application/controllers/messages.php */