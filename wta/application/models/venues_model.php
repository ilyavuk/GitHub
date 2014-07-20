<?php
class Venues_model extends CI_Model {
	private $q_final;
	private $qve;
	function __construct()
	{
		parent::__construct();
	}
			/**
				Added 21.03.2013
			*/
	
	function get_venue_for_venue_user(){
		$this->db->from('venues');
		$this->db->where('id', $this->get_model->magic_id('users',$this->session->userdata('id'),'venue_id'));
		$query = $this->db->get();
		return $query->result();
	}
	function get_venues_users($user = false, $limit= false, $offset = false){
		if($offset == '') {
			$offset = 0;
		}		
		
		$q = "SELECT * FROM users
		     INNER JOIN venues ON users.id = venues.users_id ";
		if(($user)&&($user != 'all')){
			/**
				Changed 21.03.2013
			*/
//			$q .= 'WHERE users.id = '.$user.' ';
			$q .= 'WHERE venues.id = '.$this->get_model->magic_id('users',$this->session->userdata('id'),'venue_id').' ';
		}
		   $q .= 'AND venues.is_submitted = 1 ';
		
		if($limit){		
		   $q .= " LIMIT $offset, $limit "; 
		}
		$q = str_replace('venues.users_id AND', 'venues.users_id WHERE', $q);
		$query = $this->db->query($q);
		return $query->result(); 
		
	}	
	function init_venues_with_condition(){
		$q = "SELECT * FROM venues WHERE venues.is_submitted = 1";
		
        $this->q_final = $q ;
	}
	function return_venues_with_condition($limit, $offset) {
		if($offset == '') {
			$offset = 0;
		}
		$q_limit_offset = $this->q_final;
        $q_limit_offset  .= " LIMIT $offset, $limit "; 
		$query = $this->db->query($q_limit_offset);
		if($query->num_rows()>0){
		  return $query->result();
		}else{
		  return 0;
		}
	}
	function get_num_venues_with_condition() {
		$query = $this->db->query($this->q_final);
	    return $query->num_rows();	
	}	
	function insert_venue($data){

		$insert_data = array(
		            'place'=> $data['place'],
				    'users_id'=> $data['user_id'],
					'user_name'=> $data['username'],
		            'title'=> $data['title'],
					'description'=> $data['description'],
					'posted_time'=> time(),
					'address'=> $data['address'],
					'youtube' => $data['youtube'],
					'vimeo'=> $data['vimeo'],					
					'country'=> $data['country'],
					'site_url'=> $data['site_url'],
					'city' => $data['city'],
					'logo'=> 'logo.jpg',
					'banner'=> isset($data['banner'])?$data['banner']:'',
					'is_active'=> $data['is_active'],
																													
				);

	    $this->db->insert('venues', $insert_data);
		return $this->db->insert_id();

    }	
	function perform_start_up(){
		
		$this->db->where('posted_time <',time()-60*60);
		$this->db->where('is_submitted',0);
		$this->db->delete('venues'); 
	    $this->db->insert('venues', array('is_submitted'=> 0, 'posted_time'=> time()));
		return $this->db->insert_id();
	   
	}
	
	function update_venue($data){

		$update_data = array(
		            'place'=> $data['place'],
					'users_id'=> $data['user_id'],
					'user_name'=> $data['username'],
		            'title'=> $data['title'],
					'description'=> $data['description'],
					'posted_time'=> time(),
					'address'=> $data['address'],
					'youtube' => $data['youtube'],
					'vimeo'=> $data['vimeo'],					
					'country'=> $data['country'],
					'site_url'=> $data['site_url'],
					'city' => $data['city'],
					'logo'=> $data['logo_venue'],
					'url_banner1'=> isset($data['url_banner1'])?$data['url_banner1']:'',
					'url_banner2'=> isset($data['url_banner2'])?$data['url_banner2']:'',
					'url_banner3'=> isset($data['url_banner3'])?$data['url_banner3']:'',
					'url_banner4'=> isset($data['url_banner4'])?$data['url_banner4']:'',
					'url_banner5'=> isset($data['url_banner5'])?$data['url_banner5']:'',
					'url_banner6'=> isset($data['url_banner6'])?$data['url_banner6']:'',
					'banner'=> isset($data['banner'])?$data['banner']:'',
					'is_active'=> $data['is_active'],	
					'is_submitted'=> 1,					
				);


		$this->db->where('id', $data['id']);
		return $this->db->update('venues', $update_data); 

    }
	function get_auto_increment_val(){
		$q = "SHOW TABLE STATUS LIKE 'venues' ";
		$query = $this->db->query($q);
		return $query->row()->Auto_increment;
	}
	function return_venues_imgs($id) {

     $this->db->select('id, venues_id, img_name, img_title, img_description', FALSE);
	 $this->db->from('venues_img');
	 $this->db->where('venues_id', $id);
	 $r = $this->db->get();
	 return ($r->num_rows() > 0) ? $r->result_array() : FALSE;
	}
	function delete_venue_img($id) {
		$q = $this->db->get_where('venues_img', array('id' => $id));
		$image_name = $q->row()->img_name;
		@unlink('/home/wall2all/www/assets/venues_img/'.$image_name);
		if($this->db->delete('venues_img', array('id' => $id))){
			
			return 1;
		}else{
			return 0;
		}
		
	}
	function change_venue_img_title($id, $title) {
		
				$update_data = array(
					'img_title'=> $title,
	                 );

		$this->db->where('id', $id);
		$this->db->update('venues_img', $update_data);
	
		
	}
	function change_venue_img_textarea($id, $textarea) {
		
				$update_data = array(
					'img_description'=> $textarea,
	                 );

		$this->db->where('id', $id);
		$this->db->update('venues_img', $update_data);
	}
	
	function check_venues_img_id($id) {
		
		$query = $this->db->query("SELECT * FROM venues_img WHERE venues_id =". $id ." ");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
		
	}
	function delete_unused_imgs($id) {
		
		
		$query = $this->db->get_where('venues_img', array('venues_id' => $id));
		foreach ($query->result() as $row)
			{
				@unlink('/home/wall2all/www/assets/venues_img/'.$row->img_name);

			}
		
		$this->db->delete('venues_img', array('venues_id' => $id)); 
	}
	
	function delete_venue($id){
		
		$query = $this->db->get_where('venues_img', array('venues_id' => $id));
		foreach ($query->result() as $row)
			{
				@unlink('/home/wall2all/www/assets/venues_img/'.$row->img_name);

			}
		
		$this->db->delete('venues_img', array('venues_id' => $id)); 

      return $this->db->delete('venues', array('id' => $id));

    }
	function all_venues_where_user($id){
		$this->db->from('venues');
		$this->db->where('users_id', $id);
        return $this->db->count_all_results();
	}	
	function all_venues($user_id = false){
		
		$this->db->where('is_submitted', 1);
		if($user_id){
		  $this->db->where('users_id', $user_id );
		}
		return $this->db->count_all_results('venues');
	}
	function get_average_venue_grade($venue_id) {
		$sum = 0;
		$i = 0;
		$q = "SELECT *,
		     events_grade.id AS id_events_grade
			 FROM venues
		     LEFT JOIN events ON venues.id = events.venues_id
			 LEFT JOIN events_grade ON events.id = events_grade.events_id
			 WHERE venues.id =".$venue_id."

			 ";
	   $query = $this->db->query($q);
	   if($query->num_rows()>0){
		   
		   foreach($query->result() as $result){
			   $sum = $sum + $result->grade;
			   $i++;
		   }
		   $finish = intval(($sum/(5 * $i ))* 100);
		   return $finish;
		   
	   }else{
           return false;
	   }
	}
	function init_venues_with_events(){
		$q = "SELECT *,
		venues.id AS id_venues, venues.logo AS logo_venues, venues.description AS description_venues, 
		events.id AS id_events,
		GROUP_CONCAT(events.id) AS id_events,
		GROUP_CONCAT(events.title) AS title_events,
		GROUP_CONCAT(events.start_date) AS start_date_events
		FROM venues 
		LEFT JOIN events ON venues.id = events.venues_id 
		WHERE venues.is_submitted = 1
		GROUP BY venues.id
		";
		
		$this->qve = $q ;

	}
	function num_venues_with_events(){
		$query = $this->db->query($this->qve);
	    return $query->num_rows();
	}
	function venues_with_events($limit, $offset){
		if($offset == '') {
			$offset = 0;
		}
		$q_limit_offset = $this->qve;
        $q_limit_offset  .= " LIMIT $offset, $limit "; 
		$query = $this->db->query($q_limit_offset);
		if($query->num_rows()>0){
		  return $query->result();
		}else{
		  return 0;
		}

	}
}



