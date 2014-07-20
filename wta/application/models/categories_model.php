<?php
class Categories_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

    function insert_category($data){
		
		$insert_data = array(
			'category'=> $data['category'],
			'post_time'=> time()
		);

       return $this->db->insert('categories', $insert_data);
	    /*$this->db->insert_id();*/
	}
	
	function delete_category($id){
		
		 return $this->db->delete('categories', array('id' => $id));
		
	}
	 function insert_city($data){
		
		$insert_data = array(
			'city'=> $data['city'],
			'post_time'=> time()
		);

       return $this->db->insert('cities', $insert_data);
	    /*$this->db->insert_id();*/
	}
	function delete_city($id){
		
		 return $this->db->delete('cities', array('id' => $id));
		
	}
	function UserPreferredEvents($user_id){
		$selected_categories = array();
		$categories = $this->get_model->get_all('categories');
	    $query = $this->db->get_where('UserPreferredEvents', array('users_id' => $user_id));
		$prep_query  = $query->result_array();
		foreach($prep_query as $unit){
			$selected_categories[] = $unit['categories_id'];
		}
		$i = 0;
		foreach($categories as $category){
			
			if(in_array($category->id, $selected_categories)){
				$categories[$i++]->is_selected = 1;
			}else{
			    $categories[$i++]->is_selected = 0;
			}
		}
		return $categories;
	}
	
	function update_UserPreferredEvents($user_id, $categories){
		$selected_categories = array();
	    $query = $this->db->get_where('UserPreferredEvents', array('users_id' => $user_id));
		$prep_query  = $query->result_array();
		foreach($prep_query as $unit){
			$selected_categories[] = $unit['categories_id'];
		}
		foreach($selected_categories as $scategory){
			if(!in_array($scategory, $categories)){
				$this->db->where('users_id', $user_id);
				$this->db->where('categories_id', $scategory);
				$this->db->delete('UserPreferredEvents'); 
			}
		}
		foreach($categories as $category){
			if(!in_array($category, $selected_categories)){
				$insert_obj = array(
			      'users_id' => $user_id,
				  'categories_id' => $category,
				  'date_added' => time()
				);
				$this->db->insert('UserPreferredEvents', $insert_obj);
			}
		}
	}
	
	function insert_UserPreferredEvents($data, $last_id){
		$insert_data = array();
		foreach($data as $d){
			$insert_data[] = array(
			      'users_id' => $last_id,
				  'categories_id' => $d,
				  'date_added' => time()
			);
		}
		$this->db->insert_batch('UserPreferredEvents', $insert_data);
	}
   
}

