<?php
class Attending_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	function insert_att($user_id,$events_id,$att){
		
				$insert_data = array(
				    'users_id'=> $user_id,
					'events_id'=> $events_id,
					'attending'=> $att,
				
				);

	   return $this->db->insert('attendings', $insert_data);

	}
	function update_att($user_id, $att){
		
				$update_data = array(

					'attending'=> $att,
				
				);
       $this->db->where('users_id', $user_id);
	   return $this->db->update('attendings', $update_data);

	}
   	function return_attending_data($id,$not_all = true,$num = false){
		$q = "SELECT *
		     FROM attendings
		     LEFT JOIN users ON attendings.users_id = users.id
			 WHERE attendings.events_id = ".$id;
		if($not_all){	 
		   $q .= " AND attending = 1";
		}
		if($num){
			$query = $this->db->query($q);
			return $query->num_rows(); 
		}else{
			$query = $this->db->query($q);
			return $query->result_array(); 
		}
	}
	function check_user_att($user_id, $events_id){
		$this->db->from('attendings');
		$this->db->where('users_id', $user_id);
        $this->db->where('events_id', $events_id);
		$query = $this->db->get(); 
		if($query->num_rows()>0){
			if($query->row()->attending == 0){
				return 2;
			}else{
				return 1;
			}
		}else{
			return 0;
		}
	}
	
	function all_att($id) {
		$this->db->from('attendings');
		$this->db->where('attending', 1);
		$this->db->where('events_id', $id);
		$query = $this->db->get(); 
        return $query->num_rows();
	}
}