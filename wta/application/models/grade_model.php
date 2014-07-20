<?php
class Grade_model extends CI_Model {
	
	private $event_comments;
	
	function __construct()
	{
		parent::__construct();
	}
	function check_user_grade($user_id, $events_id, $table) {
		
//		$query = $this->db->get_where('events_grade', array('users_id' => $user_id));
		
		
		$this->db->from($table);
		$this->db->where('users_id', $user_id);
        $this->db->where('events_id', $events_id);
		$query = $this->db->get(); 
		if($query->num_rows()>0){
			return false;
		}else{
			return true;
		}
	}
	function insert_grade($user_id,$events_id,$grade,$table){
		
				$insert_data = array(
				    'users_id'=> $user_id,
					'events_id'=> $events_id,
					'grade'=> $grade,
					'timePost'=> time(),
				
				);

	   return $this->db->insert($table, $insert_data);

	}
	function insert_following($user_id,$events_id,$table){
		
				$insert_data = array(
				    'users_id'=> $user_id,
					'events_id'=> $events_id,
					'following'=> 1,
				
				);

	   return $this->db->insert($table, $insert_data);

	}
	function calculate_average_grade($events_id, $table) {
		$sum = 0;
		$num = 0;
		$query = $this->db->get_where($table, array('events_id' => $events_id));
		if($query->num_rows()>0){
			foreach ($query->result() as $row)
			{
			   $sum += $row->grade;
	           $num++;
			}
			return round($sum/$query->num_rows(),1);
			
		}else{
			return 'No';
		}
	}
	function event_grade($table,$id,$num = false,$average = false, $start_time = false, $end_time = false){
		$sum = 0;
		$q = "SELECT * FROM ". $table ." WHERE events_id = ".$id;
		if(($start_time)&&($end_time)){
			$q .= " AND timePost >=". $start_time ." AND timePost <=". $end_time;
		}elseif(($start_time)&&($end_time == false)) {
			$q .= " AND timePost >=". $start_time;
		}elseif(($start_time == false)&&($end_time)){
			$q .= " AND timePost <=". $end_time;
		}
		
		$query = $this->db->query($q);
		if($num){
		   return $query->num_rows();
		}elseif($average){
		 
			  if($query->num_rows()>0){
				foreach ($query->result() as $row)
				{
				   $sum += $row->grade;
				   $num++;
				}
				return round($sum/$query->num_rows(),1);
				
			   }else{
				   return 0;
			   }

		}
		
	}
}