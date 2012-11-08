<?php
class Auth_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	public function register()
	{
		// follows the format 'column_name' => 'value'
		$data = array(
			'userAlias' => $this->input->post('alias'),
			'userEmail' => $this->input->post('email'),
			'userPassword' => $this->input->post('password')
		);
	
		// format as insert('table_name', values);
		return $this->db->insert('User', $data);
	}
		
	function login($alias, $password)
	{
		$this->db->select('User.userID, User.userAlias, User.userPassword, Profile.profilePhoto, Profile.profileRole');
		$this->db->from('User');
		$this->db->join('Profile', 'Profile.userID = User.userID');
		$this->db->where('userAlias',$alias);
		$this->db->where('userPassword',MD5($password));
		$this->db->limit(1);
		
		$query = $this->db->get();
		
		if($query->num_rows() == 1)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}
        
        public function open_register($url/*, $email*/)
        {
            // follows the format 'column_name' => 'value'
            $data = array(
                'userURL' => $url,
                //'userEmail' => $email
            );

            // format as insert('table_name', values);
            return $this->db->insert('User', $data);
        }
        
        public function generate_alias($id)
        {
            $data = array(
                'userAlias' => 'panda'.$id,
            );
            
            $this->db->where('userID', $id);
            $this->db->update('User', $data);
            
            return 'panda'.$id;
        }
        
        public function open_login($url)
        {
            $this->db->select('User.userID, User.userAlias, Profile.profilePhoto, Profile.profileRole');
            $this->db->from('User');
            $this->db->join('Profile', 'Profile.userID = User.userID');
            $this->db->where('userURL',$url);
            $this->db->limit(1);

            $query = $this->db->get();

            if($query->num_rows() == 1)
            {
                return $query->result();
            }
            else
            {
                return FALSE;
            }
        }
        
        
}

/* End of file auth_model.php */
/* Location: ./application/models/auth_model.php */