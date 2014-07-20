<?php

define('DB_TABLE_NAME', 'users');

class Users_model extends CI_Model {
	
	private $q_reg_users;
	private $face_users;
	private $twit_users;
	
	function __construct()
	{
		parent::__construct();
	}
	function init_reg_users(){
		$q = "SELECT * FROM users WHERE twitter_id = 0 AND facebook_id = 0 ";
		$this->q_reg_users = $q ;
		
	}

	function reg_users_with_condition($limit = false, $offset = false){
		
            if($offset == '') {
				$offset = 0;
			}
			$q_limit_offset = $this->q_reg_users;
			$q_limit_offset  .= " LIMIT $offset, $limit "; 
			$query = $this->db->query($q_limit_offset);	
			
			if($query->num_rows()>0){
			  return $query->result();
			}else{
			  return 0;
			}	
	
	}
	function get_num_reg_users() {
		$query = $this->db->query($this->q_reg_users);
	    return $query->num_rows();	
	}
	function init_face_users(){
		$q = "SELECT * FROM users WHERE facebook_id != 0 ";
		$this->face_users = $q ;
		
	}
	function face_users_with_condition($limit = false, $offset = false){
		
            if($offset == '') {
				$offset = 0;
			}
			$q_limit_offset = $this->face_users;
			$q_limit_offset  .= " LIMIT $offset, $limit "; 
			$query = $this->db->query($q_limit_offset);	
			
			if($query->num_rows()>0){
			  return $query->result();
			}else{
			  return 0;
			}	
	
	}
	function get_num_face_users() {
		$query = $this->db->query($this->face_users);
	    return $query->num_rows();	
	}
	function init_twit_users(){
		$q = "SELECT * FROM users WHERE twitter_id != 0 ";
		$this->twit_users = $q ;
		
	}
	function twit_users_with_condition($limit = false, $offset = false){
		
            if($offset == '') {
				$offset = 0;
			}
			$q_limit_offset = $this->twit_users;
			$q_limit_offset  .= " LIMIT $offset, $limit "; 
			$query = $this->db->query($q_limit_offset);	
			
			if($query->num_rows()>0){
			  return $query->result();
			}else{
			  return 0;
			}	
	
	}
	function get_num_twit_users() {
		$query = $this->db->query($this->twit_users);
	    return $query->num_rows();	
	}		
		
	function get_users_limit($limit, $offset){
		if($offset == '') {
			$offset = 0;
		}	  
	  $q = "SELECT * FROM users LIMIT $offset, $limit";
	  $query = $this->db->query($q);
	  return $query->result(); 
	
	}
	function blocking_social_users($id,$val){
		$update_data = array(
               'block_users' => ($val==1)?0:1,
            );
		$this->db->where('id', $id);
        if($this->db->update('users', $update_data)){
			return true;
		}else{
			return false;
		}
	}

	
	function update_users($data){

		$update_data = array(
					'first_name'=> $data['first_name'],
					'last_name'=> $data['last_name'],
		          'birthday'=> $data['birthday'],
					'username'=> $data['username'],
					'email'=> $data['email'],
					'mobile' => $data['mobile'],
					'town' => $data['town'],
					'country'=> $data['country'],	
					'block_users'=>(isset($data['block_users']))?0:1,	
					'venue_id'=>(isset($data['venue_id']))?$data['venue_id']:'',					
					'is_admin'=> $data['is_admin'],
				);
		if(isset($data['password'])){
			$update_data['password'] = $data['password'];
		}

		$this->db->where('id', $data['id']);
		$this->db->update(DB_TABLE_NAME, $update_data); 
//		$this->session->set_userdata($update_data);
  }
  function insert_user($data){
			$insert_data = array(
					'first_name'=> $data['first_name'],
					'last_name'=> $data['last_name'],
					'username'=> $data['username'],
					'email'=> $data['email'],
					'img'=> 'admin.jpg',
					'town' => $data['town'],
					'country'=> $data['country'],							
					'password'=> $data['password'],
					'is_admin'=> $data['is_admin'],
				);	
		if(isset($data['birthday'])){
			$insert_data['birthday'] = $data['birthday'];
		}
		if(isset($data['mobile'])){
			$insert_data['mobile'] = $data['mobile'];
		}
		if(isset($data['address2'])){
			$insert_data['address2'] = $data['address2'];
		}

		if($this->db->insert('users', $insert_data)){
			return true;
		}else{
			return false;
		}
		
  }
	function update_users_front($data){

		$update_data = array(
					'first_name'=> $data['first_name'],
					'last_name'=> $data['last_name'],
		            'birthday'=> $data['birthday'],
					'username'=> $data['username'],
					'email'=> $data['email'],
					'mobile' => $data['mobile'],
					'town' => $data['town'],
					'country'=> $data['country'],
					'timezones' => $data['timezones'],
					'sex'=> $data['sex']
				);
		if(isset($data['password'])){
			$update_data['password'] = $data['password'];
		}

		$this->db->where('id', $data['id']);
		$this->db->update('users', $update_data); 
		$this->session->set_userdata($update_data);
  }
  
  function insert_user_front($data, $return_id = false){
	  	$insert_data = array(
					'first_name'=> $data['first_name'],
					'last_name'=> $data['last_name'],
					'username'=> $data['username'],
					'email'=> $data['email'],
					'img'=> 'admin.jpg',					
					'town' => $data['town'],
					'country'=> $data['country'],							
					'password'=> $data['password'],
					'birthday'=> $data['birthday'],					
					'timezones' => $data['timezones'],
					'is_admin' => 1,
					'sex'=> $data['sex'],							
				);	
		if($this->db->insert('users', $insert_data)){
			$insert_data['id'] = $this->db->insert_id();
			$this->session->set_userdata($insert_data);
			if($return_id){
				return $insert_data['id'];
			}else{
			   return true;
			}
		}else{
			return false;
		}
  }
  function insert_facebook_user($data){
			$insert_data = array(
			      'facebook_id' => $data['id'],
					'first_name'=> isset($data['first_name'])?$data['first_name']:0,
					'last_name'=> isset($data['last_name'])?$data['last_name']:0,
					'username'=> isset($data['username'])?$data['username']:0,
					'country'=> isset($data['location'])?$data['location']['name']:0,
					'email'=> $data['email'],
					'birthday'=> isset($data['birthday'])?$data['birthday']:0,
					'sex'=> isset($data['gender'])?$data['gender']:0,	
                    'timezones'=> isset($data['timezone'])?$data['timezone']:0,
					'is_admin'=> 1
				);
		if($this->db->insert('users', $insert_data)){
			

			$this->session->sess_destroy();			
			$face_data['id'] = $this->db->insert_id();
			$face_data['facebook_id'] = $data['id'];
			$face_data['facebook_username'] = $data['username'];
			$face_data['facebook_Fname'] = $data['first_name'];
			$face_data['facebook_Lname'] = $data['last_name'];
			$face_data['is_admin'] = 1;
			$this->session->set_userdata($face_data);
			return true;
		}else{
			return false;
		}
  }
  function update_facebook_user($data, $id){
			$update_data = array(
					'first_name'=> isset($data['first_name'])?$data['first_name']:0,
					'last_name'=> isset($data['last_name'])?$data['last_name']:0,
					'username'=> isset($data['username'])?$data['username']:0,
					'country'=> isset($data['location'])?$data['location']['name']:0,
					'email'=> $data['email'],
					'birthday'=> isset($data['birthday'])?$data['birthday']:0,
					'sex'=> isset($data['gender'])?$data['gender']:0,	
                    'timezones'=> isset($data['timezone'])?$data['timezone']:0
					
				);
		$this->db->where('facebook_id', $data['id']);	
		if($this->db->update('users', $update_data)){
			

			$this->session->sess_destroy();
			$face_data['id'] = $id;
			$face_data['facebook_id'] = $data['id'];
			$face_data['facebook_username'] = $data['username'];
			$face_data['facebook_Fname'] = $data['first_name'];
			$face_data['facebook_Lname'] = $data['last_name'];	
			$face_data['is_admin'] = $this->get_model->get_all_where_single('users', 'id', $id)->is_admin;
			$this->session->set_userdata($face_data);
			return true;
		}else{
			return false;
		}
  }
  function reset_user_password($email){
	  $new_pass = random_string('alnum', 8);
	  $update_data = array(
	      'password' => md5($new_pass)
	  );
	  $this->db->where('email', $email);
	  $this->db->update('users', $update_data);
	  $body = '
	  Your new password is '. $new_pass .'
	  ';
	  $this->wall2all->send_email($body, 'Wall2all forgotten password', $email);
	  
  }
  function insert_twitter_user($data){
			$insert_data = array(
			        'twitter_id' => isset($data->id)?$data->id:0,
					'username'=> isset($data->name)?$data->name:0,
					'country'=> isset($data->location)?$data->location:0,
					'img'=> isset($data->profile_image_url)?$data->profile_image_url:0,
                    'timezones'=> isset($data->time_zone)?$data->time_zone:0,
					'is_admin'=> 1,
				);
		if($this->db->insert('users', $insert_data)){
			
			$this->session->sess_destroy();			
			
			$twit_data['id'] = $this->db->insert_id();
			$twit_data['twitter_id'] = $data->id;
			$twit_data['twitter_img'] = $data->profile_image_url;
			$twit_data['twitter_username'] = $data->name;
			$twit_data['is_admin'] = 1;
			$this->session->set_userdata($twit_data);
			return true;
		}else{
			return false;
		}
  }
  function update_twitter_user($data, $id){
			$update_data = array(
					'username'=> isset($data->name)?$data->name:0,
					'country'=> isset($data->location)?$data->location:0,
					'img'=> isset($data->profile_image_url)?$data->profile_image_url:0,
                    'timezones'=> isset($data->time_zone)?$data->time_zone:0
				);
		$this->db->where('twitter_id', $data->id);	
		if($this->db->update('users', $update_data)){
			
			$this->session->sess_destroy();		
						
			$twit_data['id'] = $id;
			$twit_data['twitter_id'] = $data->id;
			$twit_data['twitter_img'] = $data->profile_image_url;
			$twit_data['twitter_username'] = $data->name;
			$twit_data['is_admin'] = $this->get_model->get_all_where_single('users', 'id', $id)->is_admin;
			$this->session->set_userdata($twit_data);
			return true;
		}else{
			return false;
		}
  }
  function return_twitter_user_id($twitter_id){
	  	$this->db->from('users');
		$this->db->where('twitter_id', $twitter_id);
		$query = $this->db->get(); 
		if($query->num_rows()>0){
		 return $query->row()->id;
		}else{
		  return false;
		}
  }
  function check_twitter_user($twitter_id){
	  
	    $this->db->from('users');
		$this->db->where('twitter_id', $twitter_id);
		$query = $this->db->get(); 
		if($query->num_rows()>0){
			return true;
		}else{
			return false;
		}
  }
  function check_facebook_user($facebook_id){
	  
	    $this->db->from('users');
		$this->db->where('facebook_id', $facebook_id);
		$query = $this->db->get(); 
		if($query->num_rows()>0){
			return true;
		}else{
			return false;
		}
  }
  function return_facebook_user_id($facebook_id){
	  	$this->db->from('users');
		$this->db->where('facebook_id', $facebook_id);
		$query = $this->db->get(); 
		if($query->num_rows()>0){
		 return $query->row()->id;
		}else{
		  return false;
		}
  }
  function delete_user($id){
	  $this->db->delete('comments', array('users_id' => $id));
	  $this->db->delete('events', array('users_id' => $id));
	  return $this->db->delete('users', array('id' => $id));
	
	}
  function all_users(){
	  return $this->db->count_all(DB_TABLE_NAME);
  }
  
  function is_blocked($column, $id){
    	$this->db->from('users');
		$this->db->where($column, $id);
		$query = $this->db->get(); 
		if($query->num_rows()>0){
			if($query->row()->block_users == 1){
			  return true;
			}else{
			  return false;
			}
		}else{
			return false;
		}
  
  }
}