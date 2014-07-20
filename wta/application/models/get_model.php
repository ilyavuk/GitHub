<?php
class Get_model extends CI_Model {
	
	function get_all($table,$num = false, $condition = false, $addCondition = false) {
		
		$this->db->from($table);
		if($condition){
			$this->db->where('is_submitted', 1); 
		}
		if($addCondition){
			$this->db->where('users_id', $addCondition); 
		}		
		$query = $this->db->get();

		if($num){
		    return $query->num_rows();
		}else{
			return $query->result();
		}
		
	}
	
	function get_all_where($table, $id, $where) {
	  
		$query = $this->db->query("SELECT * FROM ". $table ." WHERE " . $id ." = " .$where ." ");
		if($query->result() >0 ) {
			return $query->result();
		}else{
			return false;
		}
	}
	function get_all_where_single($table, $id, $where,$string = false) {
	  
	    if($string){
		   $query = $this->db->query("SELECT * FROM ". $table ." WHERE " . $id ." = '" .$where ."' ");
		}else{
		   $query = $this->db->query("SELECT * FROM ". $table ." WHERE " . $id ." = " .$where ." ");
		}
		if($query->result() >0 ) {
			return $query->row();
		}else{
			return false;
		}
	}	
	
	function get_user_id($where){
	  $query = $this->db->query("SELECT * FROM events WHERE id = '" .$where ."'");
	  if($query->num_rows()>0) {
		  return $query->row()->users_id; 
	  }else{
		  return 0;
	  }
	}
	function get_single_id($table, $where) {
	  
	   $query = $this->db->query("SELECT * FROM ". $table ." WHERE users_id = '" .$where ."'");
	   		switch ($table) {
			case 'events':
                return $query->row()->users_id;  
				break;
			case 'towns':
                return $query->row()->town_id;  
				break;
			case 'property_types':
                return $query->row()->type_id;
				break;
			}
	   
	}
	function magic_id($table,$id,$column){
		$query = $this->db->query("SELECT * FROM ". $table ." WHERE id = " .$id );
		return $query->row()->$column;
	}
	function return_image($id) {
		$query = $this->db->query("SELECT * FROM users WHERE id = '" .$id ."'");
		return $query->row()->img; 
	}
	function return_images($id) {
//		$query = $this->db->get_where('events_img', array('events_id' => $id));
//		return $query->result();
     $this->db->select('id, events_id, img_name, img_title, img_description', FALSE);
	 $this->db->from('events_img');
	 $this->db->where('events_id', $id);
	 $r = $this->db->get();
	 return ($r->num_rows() > 0) ? $r->result_array() : FALSE;
	}
	function img_next_id() {
		$this->db->select_max('id');
         $query = $this->db->get('events_img');
		 return $query->row()->id + 1;
	}
	function venue_img_next_id() {
		$this->db->select_max('id');
         $query = $this->db->get('venues_img');
		 return $query->row()->id + 1;
	}
}