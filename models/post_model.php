<?php
class Post_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
		
	public function make_post($uid)
	{
		// follows the format 'column_name' => 'value'
		$data = array(
                    'userID' => $uid,
                    'postText' => $this->input->post('postText')
		);
	
		// format as insert('table_name', values);
		return $this->db->insert('Post', $data);
	}
	
	public function make_comment($uid)
	{
		// follows the format 'column_name' => 'value'
		$data = array(
			'userID' => $uid,
			'postID' => $this->input->post('postID'),
			'commentText' => $this->input->post('commentText')
		);
	
		// format as insert('table_name', values);
		return $this->db->insert('Comment', $data);
	}
		
	public function single_post($id)
	{
		$this->db->select('Post.postID, Post.postText, Post.postCreated, User.userID, User.userAlias, Profile.profilePhoto');
		$this->db->from('Post');
		$this->db->join('Profile', 'Profile.userID = Post.userID');
		$this->db->join('User', 'User.userID = Post.userID');
		$this->db->where('postID',$id);
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
        
        public function count_posts()
	{
		$this->db->select('Post.postID');
		$this->db->from('Post');
		
		return $this->db->count_all_results();
	}
	
	public function get_posts($limit = 20, $start = 0)
	{
		$this->db->select('Post.postID, Post.postText, Post.postCreated, User.userID, User.userAlias, Profile.profilePhoto');
		$this->db->from('Post');
		$this->db->join('Profile', 'Profile.userID = Post.userID');
		$this->db->join('User', 'User.userID = Post.userID');
                $this->db->order_by("Post.postID", "desc"); 
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
        
         public function count_posts_type($type)
	{
            $this->db->select('Post.postID');
            $this->db->from('Post');
            $this->db->join('PostType', 'PostType.postID = Post.postID');
            $this->db->join('Type', 'Type.typeID = PostType.typeID');
            $this->db->where('Type.typeTitle',$type);

            return $this->db->count_all_results();
	}
        
        public function get_posts_type($type, $limit = 20, $start = 0)
	{
            $this->db->select('Post.postID, Post.postText, Post.postCreated, User.userID, User.userAlias, Profile.profilePhoto');
            $this->db->from('Post');
            $this->db->join('Profile', 'Profile.userID = Post.userID');
            $this->db->join('User', 'User.userID = Post.userID');
            $this->db->join('PostType', 'PostType.postID = Post.postID');
            $this->db->join('Type', 'Type.typeID = PostType.typeID');
            $this->db->where('Type.typeTitle',$type);
            $this->db->order_by("Post.postID", "desc"); 
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
        
        public function count_comments($id)
	{
            $this->db->select('Comment.commentID');
            $this->db->from('Comment');
            $this->db->join('Post', 'Post.postID = Comment.postID');
            $this->db->join('Profile', 'Profile.userID = Comment.userID');
            $this->db->join('User', 'User.userID = Comment.userID');
            $this->db->where('Comment.postID',$id);
            
            return $this->db->count_all_results();
        }
	
	public function get_comments($id, $limit = 50, $start = 0, $order = "desc")
	{
		$this->db->select('Post.postID, Comment.commentID, Comment.commentText, Comment.commentDate, User.userID, User.userAlias, Profile.profilePhoto');
		$this->db->from('Comment');
		$this->db->join('Post', 'Post.postID = Comment.postID');
		$this->db->join('Profile', 'Profile.userID = Comment.userID');
		$this->db->join('User', 'User.userID = Comment.userID');
		$this->db->where('Comment.postID',$id);
                $this->db->order_by("commentID", $order); 
                $this->db->limit($limit, $start);
		
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
		
	public function get_types()
	{
		$query = $this->db->get('Type');
		return $query->result_array();	
	}
	
	public function link_type($postID)
	{
		// follows the format 'column_name' => 'value'
		$data = array(
			'postID' => $postID,
			'typeID' => $this->input->post('postType')
		);
	
		// format as insert('table_name', values);
		return $this->db->insert('PostType', $data);
	}
	public function get_type_title($typeID)
        {
            $this->db->select('typeTitle');
            $this->db->from('Type');
            $this->db->where('typeID',$typeID);
            $this->db->limit(1);
		
            $query = $this->db->get();
            
            if ($query)
            {
               return $query->result_array();
            }
            else
            {
                return FALSE;
            }
        }
        
        public function get_following($myID)
	{
            $this->db->select('User.userID');
            $this->db->from('Friend');
            $this->db->join('User', 'User.userID = Friend.userID2');
            $this->db->join('Profile', 'Profile.userID = Friend.userID2');
            $this->db->where('userID1', $myID);
            
            $query = $this->db->get();
            
            if ($query->num_rows() > 0)
            {
                return $query->result_array();
            }
            else
            {
                return FALSE;
            }
	}
        
        public function get_followers($myID)
	{
            $this->db->select('User.userID');
            $this->db->from('Friend');
            $this->db->join('User', 'User.userID = Friend.userID1');
            $this->db->join('Profile', 'Profile.userID = Friend.userID1');
            $this->db->where('userID2', $myID);
            
            $query = $this->db->get();
            
            if ($query->num_rows() > 0)
            {
                return $query->result_array();
            }
            else
            {
                return FALSE;
            }
	}
        
        public function count_posts_friends($str)
	{
            $this->db->select('Post.postID');
            $this->db->from('Post');
            foreach($str as $i)
                $this->db->or_where_in('Post.userID',$i['userID']);

            return $this->db->count_all_results();
	}
        
        public function get_posts_friends($str, $limit = 20, $start = 0)
	{
            $this->db->select('Post.postID, Post.postText, Post.postCreated, User.userID, User.userAlias, Profile.profilePhoto');
            $this->db->from('Post');
            $this->db->join('Profile', 'Profile.userID = Post.userID');
            $this->db->join('User', 'User.userID = Post.userID');
            foreach($str as $i)
                $this->db->or_where_in('Post.userID',$i['userID']);
            $this->db->order_by("Post.postID", "desc"); 
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
        
}

/* End of file post_model.php */
/* Location: ./application/models/post_model.php */