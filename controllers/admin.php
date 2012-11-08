<?php

class Admin extends CI_Controller {

	public function __construct()
	{
            parent::__construct();
            $this->load->model('admin_model'); // load admin model
        }

	public function index()
	{
		$this->_isAdmin();
		$this->load->view('admin/links');
	}
	
	public function types()
	{
		$this->_isAdmin();
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$data['title'] = "Manage Types";
		$data['types'] = $this->admin_model->get_types();
		
		$this->form_validation->set_rules('typeTitle', 'typeTitle', 'trim|required|xss_clean');
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('admin/types', $data);
		}
		else
		{
			$this->admin_model->insert_type();
			$this->load->view('admin/success');
		}

	}

	private function _isAdmin()
	{
		if($this->session->userdata('role') != 9)
		{
			redirect('/posts', 'refresh');	
		}
	}

}
/* End of file admin.php */
/* Location: ./application/controllers/admin.php */