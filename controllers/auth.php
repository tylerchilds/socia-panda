<?php

class Auth extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('auth_model'); // load auth model
		$this->load->model('user_model'); // load user model
        }

	/*public function register()
	{
		if($this->session->userdata('logged_in') == TRUE)
		{
			redirect('/posts', 'refresh');	
		}
		else
		{
			// load helpers for form creation and validation
			$this->load->library('form_validation');
			
			$data['title'] = 'Register';
			
			// do some validation checks for user registration. Simple commands are piped together.
			$this->form_validation->set_rules('alias', 'Alias', 'trim|required|min_length[5]|max_length[20]|xss_clean|is_unique[User.userAlias]');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[User.userEmail]');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|matches[passconf]|md5');
			$this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|xss_clean');		
			
			// validation failed, redo the form.
			if ($this->form_validation->run() === FALSE)
			{
                            // set layout variables
                            $data['indent'] = TRUE;
                            $data['offset'] = 4;
                            $data['span'] = 4;
                            
                            $this->load->view('templates/header', $data);
                            $this->load->view('templates/row-open', $data);
                            $this->load->view('forms/register');
                            $this->load->view('templates/close-div');
                            $this->load->view('templates/footer');
			}
			else
			{
				$this->auth_model->register(); // call the register function in the user model.
				$id = $this->db->insert_id(); // get the last id from the insert
				
				$this->user_model->make_profile($id); 
				
				$sess_array = array(
					'humanoid' => $id, // user ID
					'alias' => $this->input->post('alias'),
					'role' => 0,
                                        'photo' => '/img/profile/newuser.jpg',
					'logged_in' => TRUE
	            );
	            	
				$this->session->set_userdata($sess_array); // sets custom session data
				
				// load the view files to display awesomeness
				redirect('/posts/index/new', 'refresh');	
			}
		}		
	}*/
	
	/*public function login()
	{
		if($this->session->userdata('logged_in') == TRUE)
		{
			redirect('/posts', 'refresh');	
		}

		//This method will have the credentials validation
		$this->load->library('form_validation');
		$this->form_validation->set_rules('alias', 'Alias', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_password');

		if($this->form_validation->run() === FALSE)
		{
			//Field validation failed.  User redirected to login page
			$data['title'] = 'Login';
			
                        // set layout variables
                        $data['indent'] = TRUE;
                        $data['offset'] = 4;
                        $data['span'] = 4;
                        
			$this->load->view('templates/header', $data);
                        $this->load->view('templates/row-open', $data);
			$this->load->view('forms/login', $data);
                        $this->load->view('templates/close-div');
			$this->load->view('templates/footer');
		}
		else
		{
			//Go to private area
			redirect('/posts', 'refresh');
		}

	}*/
	
	public function logout()
	{
		// delete session data
		$this->session->unset_userdata('humanoid');
		$this->session->unset_userdata('alias');
                $this->session->unset_userdata('photo');
		$this->session->unset_userdata('user_role');
		$this->session->unset_userdata('logged_in');
		redirect('/', 'refresh');
	}
	
	/*function check_password($password)
	{
		//Field validation succeeded.  Validate against database
		$alias = $this->input->post('alias');
		
		//query the database
		$result = $this->auth_model->login($alias, $password);
		
		if($result)
		{
			//$sess_array = array();
			foreach($result as $row)
			{
				$sess_array = array(
                                        'humanoid' => $row->userID, // user ID
					'alias' => $row->userAlias,
					'role' => $row->profileRole,
                                        'photo' => $row->profilePhoto,
                                        'logged_in' => TRUE
				);
				$this->session->set_userdata($sess_array);
			}
			
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('check_password', 'Invalid username or password');
			return FALSE;
		}
	}*/
        
        function open_id()
        {
            if($this->session->userdata('logged_in') == TRUE)
            {
                    redirect('/posts', 'refresh');	
            }
            
            // Check for token
            if(!$this->input->post('token')){
                // set layout variables
                $data['indent'] = TRUE;
                $data['offset'] = 4;
                $data['span'] = 4;
                
                $data['title'] = 'login';
                $this->load->view('templates/header', $data);
                $this->load->view('templates/row-open', $data);
                $this->load->view('forms/open-login', $data);
                $this->load->view('templates/close-div');
                $this->load->view('templates/footer');
            }
            else
            {
                // Send token to RPX Library
                $this->engage->token($this->input->post('token'));
                // auth_info API Call
                $response = $this->engage->authinfo();

                // Print out user info (just as an example)
               //print_r($response);

                $url = $response['profile']['identifier'];
                //$email = $response['profile']['email'];

                $result = $this->auth_model->open_login($url);
                
                if($result)
                {
                    //$sess_array = array();
                    foreach($result as $row)
                    {
                        $sess_array = array(
                            'humanoid' => $row->userID, // user ID
                            'alias' => $row->userAlias,
                            'role' => $row->profileRole,
                            'photo' => $row->profilePhoto,
                            'logged_in' => TRUE
                        );
                        $this->session->set_userdata($sess_array);
                    }
                    redirect('/posts', 'refresh');
                }
                else
                {
                    $this->auth_model->open_register($url/*, $email*/); // call the register function in the user model.
                    $id = $this->db->insert_id(); // get the last id from the insert
                    $alias = $this->auth_model->generate_alias($id);

                    $this->user_model->make_profile($id); 
                    
                    $sess_array = array(
                        'humanoid' => $id, // user ID
                        'alias' => $alias,
                        'role' => 0,
                        'photo' => '/img/profile/newuser.jpg',
                        'logged_in' => TRUE
                    );
                    $this->session->set_userdata($sess_array); 
                    
                    redirect('/user/account', 'refresh');
                }
            }  
	}

}
/* End of file auth.php */
/* Location: ./application/controllers/auth.php */