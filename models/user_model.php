<?php
class User_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function make_profile($id)
	{
            // follows the format 'column_name' => 'value'
            $data = array(
                'userID' => $id,
                'profileGender' => "none",
                'profileStatus' => "none",
                'profileInfo' => "Newbie",
                'profilePhoto' => "/img/profile/newuser.jpg"
            );

            // format as insert('table_name', values);
            return $this->db->insert('Profile', $data);
	}
	
	public function update_profile($id)
	{		
            if($_FILES['photo']['name'] == "")
            {
                $data = array(
                    'profileGender' => $this->input->post('gender'),
                    'profileStatus' => $this->input->post('status'),
                    'profileInfo' => $this->input->post('info'),
                );
            }
            else
            {
                $data = array(
                    'profileGender' => $this->input->post('gender'),
                    'profileStatus' => $this->input->post('status'),
                    'profileInfo' => $this->input->post('info'),
                    'profilePhoto' => '/img/profile/'.$id.'.jpg'
                );
            }
		
            $this->db->where('userID', $id);	
            // format as insert('table_name', values);
            $this->db->update('Profile', $data); 
            
            $data = array(
                'userAlias' => $this->input->post('alias'),
            );
		
            $this->db->where('userID', $id);	
            // format as insert('table_name', values);
            
            return $this->db->update('User', $data); 
            
	}
	
	// function to get all columns for profile
	public function profile_info($id)
	{
		$this->db->from('Profile');
		$this->db->where('userID',$id);
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
	
	public function get_alias($id)
	{
		$this->db->select('userAlias');
		$this->db->from('User');
		$this->db->where('userID',$id);
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
	
	public function get_id($alias)
	{
		$this->db->select('userID');
		$this->db->from('User');
		$this->db->where('userAlias',$alias);
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
        
        public function get_userid($alias)
	{
		$this->db->select('userID');
		$this->db->from('User');
		$this->db->where('userAlias',$alias);
		$this->db->limit(1);
		
		$query = $this->db->get();
		
		if($query->num_rows() == 1)
		{
                    foreach ($query->result() as $row)
                    {
                       return $row->userID;
                    }
		}
		else
		{
                    return FALSE;
		}
	}
        
        public function count_posts_user($uid)
	{
            $this->db->select('Post.postID');
            $this->db->from('Post');
            $this->db->where('Post.userID',$uid);

            return $this->db->count_all_results();
	}
        
        public function get_posts_user($uid, $limit = 20, $start = 0)
	{
            $this->db->select('Post.postID, Post.postText, Post.postCreated, User.userID, User.userAlias, Profile.profilePhoto');
            $this->db->from('Post');
            $this->db->join('Profile', 'Profile.userID = Post.userID');
            $this->db->join('User', 'User.userID = Post.userID');
            $this->db->order_by("Post.postID", "desc"); 
            $this->db->where('Post.userID',$uid);
            $this->db->limit($limit, $start);

            $query = $this->db->get();

            if($query)
            {
                    return $query->result_array();
            }
            else
            {
                    return FALSE;		
            }	
	}
        
        public function user_exists($alias)
	{
		$this->db->select('userID');
		$this->db->from('User');
		$this->db->where('userAlias',$alias);
		$this->db->limit(1);
		
		$query = $this->db->get();

                return $query;
	}
        
        public function set_follow($myID, $uid)
	{
            // follows the format 'column_name' => 'value'
            $data = array(
                'userID1' => $myID,
                'userID2' => $uid,
            );

            // format as insert('table_name', values);
            return $this->db->insert('Friend', $data); 
	}
        
        public function not_follow($myID, $uid)
	{
            $this->db->where('userID1', $myID);
            $this->db->where('userID2', $uid);
            
            return $this->db->delete('Friend');
	}
        
        public function following($myID)
	{
            $this->db->select('User.userID, User.userAlias, Profile.profilePhoto');
            $this->db->from('Friend');
            $this->db->join('User', 'User.userID = Friend.userID2');
            $this->db->join('Profile', 'Profile.userID = Friend.userID2');
            $this->db->where('userID1', $myID);
            $this->db->order_by("User.userID", "random"); 
            $this->db->limit(24);
            
            $query = $this->db->get();
            
            if($query->num_rows() > 0)
            {
                return $query->result_array();
            }
            else
            {
                return FALSE;		
            }	
	}
        
        public function followers($myID)
	{
            $this->db->select('User.userID, User.userAlias, Profile.profilePhoto');
            $this->db->from('Friend');
            $this->db->join('User', 'User.userID = Friend.userID1');
            $this->db->join('Profile', 'Profile.userID = Friend.userID1');
            $this->db->where('userID2', $myID);
            $this->db->order_by("User.userID", "random"); 
            $this->db->limit(24);
            $query = $this->db->get();
            
            if($query->num_rows() > 0)
            {
                return $query->result_array();
            }
            else
            {
                return FALSE;		
            }
	}
        
        public function is_following($myID, $uid)
	{
            $this->db->from('Friend');
            $this->db->where('userID1', $myID);
            $this->db->where('userID2', $uid);
            $this->db->limit(1);
            $query = $this->db->get();
            
            if($query->num_rows() == 1)
            {
                return TRUE;
            }
            else
            {
                return FALSE;		
            }
        }

        public function check_alias($alias, $id)
	{
		$this->db->select('userAlias');
		$this->db->from('User');
		$this->db->where('userAlias',$alias);
                $this->db->where_not_in('userID', $id);
		$this->db->limit(1);
		
		$query = $this->db->get();
		
		if($query->num_rows() == 1)
		{
                    return TRUE;
		}
		else
		{
                    return FALSE;
		}
	}
	
}

/* End of file user_model.php */
/* Location: ./application/models/user_model.php */