<?php
class Like_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	function insert_like($user_id,$comment_id,$events_id){
	
	if($this->check_like_comment($user_id,$comment_id)){		
			$insert_data = array(
				'users_id'=> $user_id,
				'comments_id'=> $comment_id,
				'events_id'=> $events_id,
			);

      if($this->db->insert('liked_comments', $insert_data)){
		  
		        $qlike = "SELECT * FROM liked_comments WHERE events_id = ".$events_id." AND comments_id = ".$comment_id;
				$query = $this->db->query($qlike);
				$likeRs = $query->result();
				$k = 0;
				foreach($likeRs as $likeR){
					$k++;
				}
		      return $k;
	  }
	}else{
	  return false;
	}

  }
  function check_like_comment($user_id,$comment_id){
	  	$this->db->from('liked_comments');
		$this->db->where('users_id', $user_id);
        $this->db->where('comments_id', $comment_id);
		$query = $this->db->get(); 
		if($query->num_rows()>0){
			return false;
		}else{
			return true;
		}
  }
  function user_liked_comments($id) {
	  $query = $this->db->get_where('liked_comments', array('users_id' => $id));
	  return $query->result();
  }
}