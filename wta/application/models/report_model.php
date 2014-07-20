<?php
class Report_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	function insert_report($user_id,$comment_id,$events_id){
	
		if($this->check_report($user_id,$comment_id)){		
				$insert_data = array(
					'users_id'=> $user_id,
					'comments_id'=> $comment_id,
					'events_id'=> $events_id,
				);
	
		  return $this->db->insert('abused_comments', $insert_data);
		}else{
		  return false;
		}

  }
  function check_report($user_id,$comment_id){
	  	$this->db->from('abused_comments');
		$this->db->where('users_id', $user_id);
        $this->db->where('comments_id', $comment_id);
		$query = $this->db->get(); 
		if($query->num_rows()>0){
			return false;
		}else{
			return true;
		}
  }
}