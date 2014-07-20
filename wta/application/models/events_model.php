<?php
class Events_model extends CI_Model {
	private $q_final;
	function __construct()
	{
		parent::__construct();
	}
	function get_evts_users($user = false, $limit= false, $offset = false, $live = false, $num = false, $venues_id = false){
		if($offset == '') {
			$offset = 0;
		}		
		
		$q = "SELECT *,
		      events.id AS id_events
		     FROM events
		     LEFT JOIN  users ON users.id = events.users_id";
		if(($user)&&($user != 'all')){
			$q .= ' AND users.id = '.$user.'';
		}
		if($venues_id){
			$q .= ' AND events.venues_id = '.$venues_id.'';
		}
		if($live){
			$q .= " AND events.end_date >=". time() ." AND  events.start_date <=". time() ." ";
		}
		
		   $q .= " AND events.is_submitted = 1 ";
		
		if($limit){		
		   $q .= " LIMIT $offset, $limit "; 
		}
		$q = str_replace('events.users_id AND', 'events.users_id WHERE', $q);
		$query = $this->db->query($q);
		if($num){
		  return $query->num_rows(); 
		}else{
		  return $query->result(); 
		}
	}
	function get_events_limit($limit, $offset){
		$query = $this->db->get('events', $limit, $offset);
		return $query->result();
		
	}
	function init_events_with_condition($condition = 'past',$location = false){
		$q = "SELECT *,
		 events.id AS  id_events, events.users_id as users_id_events, events.user_name as user_name_events, events.title as title_events,
		 events.description AS  description_events, events.logo as logo_events, events.youtube as youtube_events, events.vimeo as vimeo_events,
		 
		 venues.id AS  id_venues, venues.users_id as users_id_venues, venues.user_name as user_name_venues, venues.title as title_venues,
		 venues.description AS  description_venues, venues.logo as logo_venues, venues.youtube as youtube_venues, venues.vimeo as vimeo_venues	 
		 
		 
		 FROM events
		 LEFT JOIN venues ON events.venues_id = venues.id";
		if($condition == 'upcoming'){
		 $q .=" WHERE start_date >". time() ."";
		}elseif($condition == 'live'){
			$q .=" WHERE events.end_date >=". time() ." AND  events.start_date <=". time() ." ";
		}elseif($condition == 'past'){
			$q .=" WHERE end_date <". time() ."";
		}
		if($location){
		   $q .= " AND city = 'Beograd' OR city = 'Belgrade'";
		}
		  $q .=" AND events.is_active = 1 AND events.is_submitted = 1 ORDER BY events.start_date DESC ";
			$q = str_replace('venues.id AND', 'venues.id WHERE', $q);
        $this->q_final = $q ;
	}
	function return_events_with_condition($limit = false, $offset = false) {
		
		if($limit){
			if($offset == '') {
				$offset = 0;
			}
			$q_limit_offset = $this->q_final;
			$q_limit_offset  .= " LIMIT $offset, $limit "; 
			$query = $this->db->query($q_limit_offset);
		}else{
			$query = $this->db->query($this->q_final);
		}
		
		
		
		if($query->num_rows()>0){
		  return $query->result();
		}else{
		  return 0;
		}
	}
	function get_num_events_with_condition() {
		$query = $this->db->query($this->q_final);
	    return $query->num_rows();	
	}
	function events_with_images() {
		
	  $q = "SELECT *,
	        events.id AS  id_event
	        FROM events
		    LEFT JOIN events_img ON events.id = events_img.events_id 
			WHERE events.is_submitted = 1 AND venues.is_submitted = 1 ";
	  $query = $this->db->query($q);
	  return $query->result(); 
	  
	}
	function update_event($data){

		$update_data = array(
				    'users_id'=> $data['user_id'],
					'venues_id'=> $data['venues_id'],
					'user_name'=> $data['username'],
		            'title'=> $data['title'],
					'description'=> $data['description'],
					'category'=> $data['category'],
					'posted_time'=> time(),
					'start_date'=> strtotime($data['start_date']),
					'end_date'=> strtotime($data['end_date']),
					'youtube' => $data['youtube'],
					'vimeo'=> $data['vimeo'],					
					'logo'=> $data['logo_event'],
					'poll1'=> isset($data['poll1'])?$data['poll1']:NULL,
					'poll2'=> isset($data['poll2'])?$data['poll2']:NULL,
					'url_bannerE'=> isset($data['url_bannerE'])?$data['url_bannerE']:'',
					'is_active'=> $data['is_active'],
					'url_title'=> $data['url_title'],
					'live_video'=> $data['live_video'],
					'is_submitted'=>  1						
				);


		$this->db->where('id', $data['id']);
		return $this->db->update('events', $update_data); 

    }
	function perform_start_up(){
		
		$this->db->where('posted_time <',time()-60*60);
		$this->db->where('is_submitted',0);
		$this->db->delete('events'); 
	    $this->db->insert('events', array('is_submitted'=> 0, 'posted_time'=> time()));
		return $this->db->insert_id();
	   
	}
	function insert_event($data){

		$insert_data = array(
				    'users_id'=> $data['user_id'],
					'venues_id'=> $data['venues_id'],
					'user_name'=> $data['username'],
		            'title'=> $data['title'],
					'description'=> $data['description'],
					'category'=> $data['category'],
					'posted_time'=> time(),
					'start_date'=> strtotime($data['start_date']),
					'end_date'=> strtotime($data['end_date']),
					'youtube' => $data['youtube'],
					'vimeo'=> $data['vimeo'],					
					'logo'=> 'logo.jpg',
					'poll1'=> isset($data['poll1'])?$data['poll1']:NULL,
					'poll2'=> isset($data['poll2'])?$data['poll2']:NULL,
					'is_active'=> $data['is_active'],
					'url_title'=> $data['url_title'],
					'live_video'=> $data['live_video'],
					'is_submitted'=>  1					
				);

       $this->db->insert('events', $insert_data);
	   return $this->db->insert_id();

    }	
	function delete_event($id){
		$query = $this->db->get_where('events_img', array('events_id' => $id));
		foreach ($query->result() as $row)
			{
				@unlink('/home/wall2all/www/assets/evt_logo_img/'.$row->img_name);

			}
		
		$this->db->delete('events_img', array('events_id' => $id)); 
		$this->db->delete('abused_comments', array('events_id' => $id));
		$this->db->delete('liked_comments', array('events_id' => $id));
        $this->db->delete('comments', array('events_id' => $id));
      return $this->db->delete('events', array('id' => $id));

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
	function all_events_where_user($id){
		$this->db->from('events');
		$this->db->where('users_id', $id);
		$this->db->where('is_submitted', 1);
        return $this->db->count_all_results();
	}
	function all_events($user_id = false, $venues_id = false){
		$this->db->where('is_submitted', 1);
		if($user_id){
		  $this->db->where('users_id', $user_id );
		}
		if($venues_id){
		  $this->db->where('venues_id', $venues_id );
		}

		return $this->db->count_all_results('events');
	}
	function event_detail($id){
		$q = "SELECT *,
			 events.id AS  id_events, events.users_id as users_id_events, events.user_name as user_name_events, events.title as title_events, events.banner as banner_events,
			 events.description AS  description_events, events.logo as logo_events, events.youtube as youtube_events, events.vimeo as vimeo_events, events.is_active as is_active_events,
			 events.background_image as event_background_image, events.banner_img as banner_imgE,
			 
			 venues.id AS  id_venues, venues.users_id as users_id_venues, venues.user_name as user_name_venues, venues.title as title_venues,
			 venues.description AS  description_venues, venues.logo as logo_venues, venues.youtube as youtube_venues, venues.vimeo as vimeo_venues	 
			 
			 
			 FROM events
			 LEFT JOIN venues ON events.venues_id = venues.id
			 WHERE events.id = ". $id ."
			 AND events.is_submitted = 1
			 
			 ";
		$query = $this->db->query($q);
		return $query->row(); 
	}
	function venue_upcoming_events($id) {
		$q = "SELECT * FROM events
		      WHERE start_date >". time() ."
			  AND events.is_submitted = 1
			  AND venues_id =". $id ."
			  ORDER BY start_date+0 ASC
		     ";
		$query = $this->db->query($q);
		if($query->num_rows() > 0){
		    return $query->result(); 
		}else{
			return 0;
		}
	}
	function city_with_events(){
		
		$q = "SELECT *,
		      events.id AS id_events
		      FROM events
              LEFT JOIN venues ON events.venues_id = venues.id
			  WHERE events.is_submitted = 1
			  GROUP BY venues.city;
		     ";
		$query = $this->db->query($q);
		if($query->num_rows() > 0){
		    return $query->result(); 
		}else{
			return 0;
		}
	}
}