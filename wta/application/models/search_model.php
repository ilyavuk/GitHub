<?php
class Search_model extends CI_Model {
	
	private $q_final;
	
	function __construct()
	{
		parent::__construct();
	}
	function init_search($city, $category, $event, $venue, $dateFrom, $dateTo) {
		
	$q = "SELECT *,
		 events.id AS  id_events, events.users_id as users_id_events, events.user_name as user_name_events, events.title as title_events,
		 events.description AS  description_events, events.logo as logo_events, events.youtube as youtube_events, events.vimeo as vimeo_events,
		 
		 venues.id AS  id_venues, venues.users_id as users_id_venues, venues.user_name as user_name_venues, venues.title as title_venues,
		 venues.description AS  description_venues, venues.logo as logo_venues, venues.youtube as youtube_venues, venues.vimeo as vimeo_venues	 
		 
		 
		 FROM events
		 LEFT JOIN venues ON events.venues_id = venues.id
		 WHERE events.is_active = 1
		 ";
	if($city != '') {
		$q .= " AND LOWER(city) = '". $city . "' ";
	}
	if($category != '') {
		$q .= " AND LOWER(category) LIKE '%". $category . "%' ";
	}
	if($event != '') {
		$q .= " AND LOWER(events.title) LIKE '%". $event . "%' ";
	}
	if($venue != '') {
		$q .= " AND LOWER(venues.place) LIKE '%". $venue . "%' ";
	}
	if(($dateFrom != '')&&($dateTo != '')){
		$q .=" AND end_date >=". $dateTo ." AND  start_date >=". $dateFrom ." ";
	}
	if(($dateFrom != '')&&($dateTo == '')){
		$q .=" AND start_date >=". $dateFrom ."";
	}
	if(($dateFrom == '')&&($dateTo != '')){
		$q .=" AND end_date <=". $dateTo ."";
	}
	    $q .=" ORDER BY events.start_date DESC ";
	    
		$this->q_final = $q ;
	 
	}
	
	
	function search_limit($limit = false, $offset = false){
		
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
	function num_searched_rows() {
		$query = $this->db->query($this->q_final);
	    return $query->num_rows();	
	}
}


