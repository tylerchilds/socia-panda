<?php
class Admin_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function insert_type()
	{
		// follows the format 'column_name' => 'value'
		$data = array(
			'typeTitle' => $this->input->post('typeTitle'),
		);
	
		// format as insert('table_name', values);
		return $this->db->insert('Type', $data);
	}	
	
	public function get_types()
	{
		$query = $this->db->get('Type');
		return $query->result_array();	
	}	

}

/* End of file admin_model.php */
/* Location: ./application/models/admin_model.php */