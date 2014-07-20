<?php
class Home_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function update($Up_data, $key){
	
	  $update_data = array(
		            'events_id'=> $Up_data->id_events,
		            'title'=> $Up_data->title_events,
					'url_title'=> $Up_data->url_title,
					'logo'=> $Up_data->logo_events,
					'start_date'=> $Up_data->start_date,
					'end_date'=> $Up_data->end_date,
					'description'=> $Up_data->description_events,
					'venuePlace'=> $Up_data->place,
					'venueID'=> $Up_data->id_venues
				);


		$this->db->where('id', $key);
		return $this->db->update('weRecommend', $update_data); 
	
	}
	
	function update_youtube(){
	
	  $update_data = array(
		            'url'=> $this->input->post('youtube'),
		            'banners'=> $this->input->post('banners'),
					'posted'=> time()
				);


		$this->db->where('id', 1);
		return $this->db->update('homeyoutube', $update_data); 
	
	}
	function get_what_is_new($city = false){
		$q = "SELECT *,
		 events.id AS  id_events, events.users_id as users_id_events, events.user_name as user_name_events, events.title as title_events,
		 events.description AS  description_events, events.logo as logo_events, events.youtube as youtube_events, events.vimeo as vimeo_events,
		 
		 venues.id AS  id_venues, venues.users_id as users_id_venues, venues.user_name as user_name_venues, venues.title as title_venues,
		 venues.description AS  description_venues, venues.logo as logo_venues, venues.youtube as youtube_venues, venues.vimeo as vimeo_venues	
		
		 FROM events LEFT JOIN venues ON events.venues_id = venues.id
		 WHERE events.start_date > ".time()."
		 AND events.is_submitted = 1
		 ";
		if($city){
			$q .= " AND LOWER(city) = '". $city . "' ";
		}
		$q .= " ORDER BY events.start_date ASC LIMIT 4";
		
		
		$query = $this->db->query($q);
		if($query->num_rows()>0){
			return $query->result(); 
		}else{
			return 0;
		}
	}
	function get_last_posts(){
		$q = "SELECT *,
		     comments.id AS  comments_id,
             events.id AS  id_events
		     FROM comments
		     LEFT JOIN events ON comments.events_id = events.id
			 LEFT JOIN users ON comments.users_id = users.id
			 WHERE events.is_submitted = 1
			 ORDER BY comments.id DESC LIMIT 5
			 ";
		$query = $this->db->query($q);
		if($query->num_rows()>0){
			return $query->result(); 
		}else{
			return 0;
		}
	}
	function VenuesWhereEvents(){
		$q = "SELECT *,
		      events.id as id_events, events.venues_id as events_venues_id,
			  venues.id as id_venues
		      FROM events
			  LEFT JOIN venues ON events.venues_id  =  venues.id
			  WHERE events.is_submitted = 1
			  GROUP BY venues.city
			 ";
	   $query = $this->db->query($q);
	   return $query->result();
	}
	function getEwithV($id){
		$q = "SELECT *,
			  events.id AS  id_events, events.users_id as users_id_events, events.user_name as user_name_events, events.title as title_events,
			  events.description AS  description_events, events.logo as logo_events, events.youtube as youtube_events, events.vimeo as vimeo_events,
			 
			  venues.id AS  id_venues, venues.users_id as users_id_venues, venues.user_name as user_name_venues, venues.title as title_venues,
			  venues.description AS  description_venues, venues.logo as logo_venues, venues.youtube as youtube_venues, venues.vimeo as vimeo_venues	
		      FROM events
			  LEFT JOIN venues ON events.venues_id  =  venues.id
			  WHERE events.id = ". $id. "
			  AND events.is_submitted = 1
			 ";
	   $query = $this->db->query($q);
	   return $query->row(); 
	}
}

