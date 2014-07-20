<?php
class Comments_model extends CI_Model {
	
	private $q_abused;
	private $q_liked;
	
	function __construct()
	{
		parent::__construct();
	}
	function get_comments_evts_users($user = false, $event = false,$limit= false, $offset = false){
		if($offset == '') {
			$offset = 0;
		}		
		$q = "SELECT *,
		     comments.id AS  comments_id

		     FROM comments
		     LEFT JOIN events ON comments.events_id = events.id
			 LEFT JOIN users ON comments.users_id = users.id";
		if(($user)&&($user != 'all')){
			$q .= ' AND comments.users_id = '.$user.'';
		}
		if(($event)&&($event != 'all')){
			$q .= ' AND comments.events_id = '.$event.'';
		}
		$q .= " ORDER BY comments.id DESC ";
		if($limit){		
		   $q .= " LIMIT $offset, $limit "; 
		}	
		$q = str_replace('users.id AND', 'users.id WHERE', $q);
		$query = $this->db->query($q);
		return $query->result(); 
//        return $query->num_rows();
		
	}
	function init_abused_comments($user = false, $event = false) {
		$q = "SELECT *,
		     abused_comments.id AS id_abused_comments,
		     comments.id AS id_comments

		     FROM abused_comments
		     LEFT JOIN events ON abused_comments.events_id = events.id
			 LEFT JOIN users ON abused_comments.users_id = users.id
			 LEFT JOIN comments ON abused_comments.comments_id = comments.id";
	    
	   if(($user)&&($user != 'all')){
			$q .= ' AND abused_comments.users_id = '.$user.'';
		}
		if(($event)&&($event != 'all')){
			$q .= ' AND abused_comments.events_id = '.$event.'';
		}
		$q = str_replace('comments.id AND', 'comments.id WHERE', $q);
        $this->q_abused = $q ;
		
	}
	function init_liked_comments($user = false, $event = false) {
		$q = "SELECT *,
		     liked_comments.id AS id_liked_comments,
		     comments.id AS id_comments

		     FROM liked_comments
		     LEFT JOIN events ON liked_comments.events_id = events.id
			 LEFT JOIN users ON liked_comments.users_id = users.id
			 LEFT JOIN comments ON liked_comments.comments_id = comments.id";
	    
	   if(($user)&&($user != 'all')){
			$q .= ' AND liked_comments.users_id = '.$user.'';
		}
		if(($event)&&($event != 'all')){
			$q .= ' AND liked_comments.events_id = '.$event.'';
		}
		$q = str_replace('comments.id AND', 'comments.id WHERE', $q);
        $this->q_liked= $q ;
		
	}	
	function spec_comments_limit($limit= false, $offset = false, $liked = false) {
		if($liked) {
			$q_limit_offset = $this->q_liked;
		}else{
			$q_limit_offset = $this->q_abused;
		}
		if($offset == '') {
			$offset = 0;
		}
//		$q_limit_offset = $this->q_abused;
		$q_limit_offset  .= " LIMIT $offset, $limit "; 
		$query = $this->db->query($q_limit_offset);
		if($query->num_rows()>0){
		  return $query->result();
		}else{
		  return 0;
		}	
		
	}
	function num_spec_comments($liked = false){
		if($liked) {
			$var = $this->q_liked;
		}else{
			$var  = $this->q_abused;
		}
		$query = $this->db->query($var);
	    return $query->num_rows();	
	}
	function update_comment($data){

		$update_data = array(
		            'comment'=> $data['comment'],
					'comment_is_active'=> $data['is_active'],						
				);


		$this->db->where('id', $data['id']);
		return $this->db->update('comments', $update_data); 

    }
	function insert_comment($user_id,$events_id, $comment){
		
				$insert_data = array(
		         'users_id'=> $user_id,
					'events_id'=> $events_id,	
		         'comment'=> $comment,
					'comment_date_post'=> time(),	
					'comment_is_active'	=> 1,				
				);
				
			    $this->db->insert('comments', $insert_data);
				 return $this->db->insert_id();
	}
	function return_comment_data($id, $lastID){
		
			$q = "SELECT *,
				 users.id AS id_users,
				 comments.id AS id_comments,
				 comments.users_id AS comments_users_id ";
			if($this->session->userdata('id')){	 
			$q .= ",liked_comments.id AS id_liked_comments,
				 liked_comments.users_id AS users_id_liked_comments, 
				 abused_comments.id AS id_abused_comments
				 ";
			}
			$q .="FROM comments
				 LEFT JOIN users ON comments.users_id = users.id ";
				 if($this->session->userdata('id')){
				 $q .="LEFT JOIN liked_comments ON comments.id = liked_comments.comments_id AND liked_comments.users_id = ". $this->session->userdata('id') ."              
					   LEFT JOIN abused_comments ON comments.id = abused_comments.comments_id AND abused_comments.users_id = ". $this->session->userdata('id') ."  
				 ";
				 }
				 
			$q .= " WHERE comments.events_id = ".$id ;
						 
			if($lastID){
				$q .= " AND comments.id < ". $lastID;
			}
	
			$q .= " AND comments.comment_is_active = 1
					ORDER BY comments.id DESC ";
			 
		   $q .= " LIMIT 10 "; 
	
			 
		 $query = $this->db->query($q);
		 $resultss = $query->result_array();
		
		foreach($resultss as $i=>$results){
			foreach($results as $j=>$result) {
//				$resultss[$i]['comment'] = str_ireplace(explode(",",$this->get_b_words()),'...',$results['comment']) ;
				$resultss[$i]['comment_date_post'] = $this->convert_date($results['comment_date_post']);
				$qlike = "SELECT * FROM liked_comments WHERE events_id = ".$id." AND comments_id = ".$resultss[$i]['id_comments'];
				$query2 = $this->db->query($qlike);
				$likeRs = $query2->result();
				$k = 0;
				foreach($likeRs as $likeR){
					$k++;
				}
                $resultss[$i]['like'] = $k;
			}
		}
		//return $query->result_array(); 
		return $resultss;
	}
	
	function return_comments($id, $lastID, $imparity = FALSE){
		
			$q = "SELECT *,
				 users.id AS id_users,
				 comments.id AS id_comments,
				 comments.users_id AS comments_users_id ";
			/**
			  Display that user is already reported the comment 
			*/
			if($this->session->userdata('id')){	 
			$q .= ", abused_comments.id AS id_abused_comments ";
			}
			
			$q .="FROM comments
				 LEFT JOIN users ON comments.users_id = users.id ";
				/**
				  Display that user is already reported the comment 
				*/				 
				 if($this->session->userdata('id')){
				 $q .="LEFT JOIN abused_comments ON comments.id = abused_comments.comments_id AND abused_comments.users_id = ". $this->session->userdata('id') ." ";
				 }
		$q .= " WHERE comments.events_id = ".$id ;

		 if($imparity){
			 $q .= " AND comments.id > ".$lastID." ORDER BY comments.id DESC " ;
		 }else{
			if($lastID){
				$q .= " AND comments.id < ". $lastID;
			}
	
			$q .= " AND comments.comment_is_active = 1
					ORDER BY comments.id DESC ";
			 
		    $q .= " LIMIT 10 "; 
		 }
			 
		 $query = $this->db->query($q);
		 $resultss = $query->result_array();
		
		foreach($resultss as $i=>$results){
			foreach($results as $j=>$result) {
				/*$bad_words_array = array();
				$bad_words_array = explode(",",walltoall_strip_bad_words($this->get_b_words()));
				$resultss[$i]['comment'] = str_ireplace($bad_words_array,'...',$results['comment']);*/
				$resultss[$i]['comment'] = walltoall_strip_bad_words($results['comment'],$this->get_b_words());
				$resultss[$i]['comment_date_post'] = $this->convert_date($results['comment_date_post']);
				$qlike = "SELECT * FROM liked_comments WHERE events_id = ".$id." AND comments_id = ".$resultss[$i]['id_comments'];
				$query2 = $this->db->query($qlike);
				$likeRs = $query2->result();
				$k = 0;
				foreach($likeRs as $likeR){
					$k++;
				}
                $resultss[$i]['like'] = $k;
			}
		}
		//return $query->result_array(); 
		return $resultss;
	}
	
	
	
	
	function insert_event($data){

		$insert_data = array(
				    'users_id'=> $data['user_id'],
					'user_name'=> $data['username'],
					'theme'=> $data['theme'],
		            'title'=> $data['title'],
					'description'=> $data['description'],
					'posted_time'=> date( 'Y-m-d H:i:s'),
					'date'=> $data['date'],
					'time'=> $data['time'],
					'address'=> $data['address'],
					'youtube' => $data['youtube'],
					'vimeo'=> $data['vimeo'],					
					'country'=> $data['country'],
					'city' => $data['city'],
					'club'=> $data['club'],	
					'is_active'=> $data['is_active'],						
				);

	   return $this->db->insert('events', $insert_data);

    }	
	function delete_comment($id){
	  $this->db->delete('abused_comments', array('comments_id' => $id));
      $this->db->delete('liked_comments', array('comments_id' => $id));
      return $this->db->delete('comments', array('id' => $id));

    }
	function get_auto_increment_val(){
		$q = "SHOW TABLE STATUS LIKE 'events' ";
		$query = $this->db->query($q);
		return $query->row()->Auto_increment;
	}
	
	function check_events_img_id($id) {
		
		$query = $this->db->query("SELECT * FROM events_img WHERE events_id =". $id ." ");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
		
	}
	
	function delete_unused_imgs($id) {
		
		
		$query = $this->db->get_where('events_img', array('events_id' => $id));
		foreach ($query->result() as $row)
			{
				@unlink('/home/wall2all/www/assets/evt_logo_img/'.$row->img_name);

			}
		
		$this->db->delete('events_img', array('events_id' => $id)); 
	}
	function update_b_words($words) {
		$update_data= array(
				    'words'=> $words
					);
		$this->db->where('id', 1);
        return $this->db->update('bad_words', $update_data); 
	}
	function get_b_words() {
        $query = $this->db->get_where('bad_words',array('id' => 1));
		return $query->row()->words;
	}
	function all_comments_where_user($id){
		$this->db->from('comments');
		$this->db->where('users_id', $id);
        return $this->db->count_all_results();
	}
	function all_comments_where_event($id){
		$this->db->from('comments');
		$this->db->where('events_id', $id);
		$this->db->where('comment_is_active', 1);
        return $this->db->count_all_results();
	}
	function all_comments_where_user_event($user, $event){
		$this->db->from('comments');
		$this->db->where('users_id', $user);
		$this->db->where('events_id', $event);
        return $this->db->count_all_results();
	}
	function all_comments(){
		return $this->db->count_all('comments');
	}
	function remove_bad_words($var = false){
		return explode(",",$this->get_b_words());
	}
	function get_next_num(){
		$q = "SHOW TABLE STATUS LIKE 'comments' ";
		$query = $this->db->query($q);
		return $query->row()->Auto_increment;
	}
	private function convert_date($var){
		
			$ago_sec = time() - $var;                             
			if($ago_sec > 24*60*60){
				$period_ago = date("H:i, j F ",$var );
			}else{
				$period_ago = date("H:i",$var);
			}
	    return $period_ago;
	
	}
}