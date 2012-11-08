<?php
class Message_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
        public function make_thread()
	{
            $data = array(
                'threadID' => 0,
            );
            return $this->db->insert('Thread', $data);
        }
        
        public function get_thread_users($threadID)
	{     
            $this->db->select('User.userID, User.userAlias');
            $this->db->from('User');
            $this->db->join('ThreadUser', 'ThreadUser.userID = User.userID');
            $this->db->where('ThreadUser.threadID', $threadID);
            
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
        
        public function get_thread_message($threadID)
	{     
            $this->db->select('messageBody, messageDate');
            $this->db->from('Message');
            $this->db->where('threadID', $threadID);
            $this->db->order_by("messageID", "desc"); 
            $this->db->limit(1);
            
            $query = $this->db->get();

            if($query->num_rows() == 1)
            {
                return $query->result_array();
            }
            else
            {
                return FALSE;
            }	
        }
        
        public function get_threads($id)
	{        
            $this->db->select('ThreadUser.threadID, ThreadUser.threadUnread');
            $this->db->distinct();
            $this->db->from('ThreadUser');
            $this->db->join('Message', 'Message.ThreadID = ThreadUser.ThreadID');
            $this->db->where('ThreadUser.userID', $id);
            $this->db->order_by("messageID", "desc");
            
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
        
        public function send_message($threadID, $uid)
	{
            // follows the format 'column_name' => 'value'
            $data = array(
                    'userID' => $uid,
                    'threadID' => $threadID,
                    'messageBody' => $this->input->post('message')
            );

            // format as insert('table_name', values);
            return $this->db->insert('Message', $data);
            
        }
	
        public function link_user($threadID, $uid)
        {
            // follows the format 'column_name' => 'value'
            $data = array(
                    'userID' => $uid,
                    'threadID' => $threadID
            );

            // format as insert('table_name', values);
            return $this->db->insert('ThreadUser', $data);
        }
        
	public function get_user_info($alias)
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
        
        public function user_exists($alias)
	{
            $this->db->select('userID');
            $this->db->from('User');
            $this->db->where('userAlias',$alias);
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
        
        public function get_messages($threadID)
	{
            $this->db->select('Message.messageBody, Message.messageDate, User.userID, User.userAlias, Profile.profilePhoto');
            $this->db->from('Message');
            $this->db->join('User', 'User.userID = Message.userID');
            $this->db->join('Profile', 'Profile.userID = Message.userID');
            $this->db->where('Message.threadID', $threadID);

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
        
        public function mark_unread($threadID, $id)
	{
            $data = array(
                'threadUnread' => 1,
            );
		
            $this->db->where('threadID', $threadID);
            $this->db->where_not_in('userID', $id);
            
            // format as insert('table_name', values);
            return $this->db->update('ThreadUser', $data); 
	}
        
        public function mark_read($threadID, $id)
	{
            $data = array(
                'threadUnread' => 0,
            );
		
            $this->db->where('threadID', $threadID);
            $this->db->where('userID', $id);
            
            // format as insert('table_name', values);
            return $this->db->update('ThreadUser', $data); 
	}
        
        public function valid_user($threadID, $myID)
        {
            $this->db->from('ThreadUser');
            $this->db->where('threadID',$threadID);
            $this->db->where('userID',$myID);
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

/* End of file message_model.php */
/* Location: ./application/models/message_model.php */