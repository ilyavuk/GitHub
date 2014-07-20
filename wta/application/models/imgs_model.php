<?php
class Imgs_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function delete_event_img($id) {
		$q = $this->db->get_where('events_img', array('id' => $id));
		$image_name = $q->row()->img_name;
		@unlink('/home/wall2all/www/assets/evt_logo_img/'.$image_name);
		if($this->db->delete('events_img', array('id' => $id))){
			
			return 1;
		}else{
			return 0;
		}
		
	}
	function change_event_img_title($id, $title) {
		
				$update_data = array(
					'img_title'=> $title,
	                 );

		$this->db->where('id', $id);
		$this->db->update('events_img', $update_data);
	
		
	}
	function change_event_img_textarea($id, $textarea) {
		
				$update_data = array(
					'img_description'=> $textarea,
	                 );

		$this->db->where('id', $id);
		$this->db->update('events_img', $update_data);
	
		
	}
}