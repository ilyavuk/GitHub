<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
	}
	function index() {
		if(isset($_POST['submit'])){
			if($this->wall2all->login($this->input->post('username'), $this->input->post('password'))){
                 redirect(base_url().'admin/events/', 'refresh');
			}else{
				$data['error_loggin'] = true;
				$this->wall2all->a_view('login_panel', $data);
			}
		}else{
		  if($this->venue_admin){
		    redirect(base_url().'admin/events/', 'refresh');
		  }else{
		    $this->wall2all->a_view('login_panel');
	      }
		}
	}

   function users($edit = '', $id = '') {
	  if($this->master_admin){
		  if($edit == 'edit') {
			  if(isset($_POST['submit_user_form'])){
               $data = $this->input->post();
//			   $data['is_admin'] = (isset($data['is_admin']))?$data['is_admin']:0;
			   $data2['s_users'] = TRUE;
			   $data2['common_users'] = TRUE;
			   $data2['venues'] = $this->get_model->get_all('venues',false,true);
			   $data2['user_data'] = $this->get_model->get_all_where_single('users' ,'id', $id);
			   $this->form_validation->set_rules('username', 'Username', 'required');
			   $this->form_validation->set_rules('first_name', 'First name', 'required');
			   $this->form_validation->set_rules('last_name', 'Last name', 'required');
//               $this->users_model->update_users($data);
			   if($this->input->post('new_password')!='') {
				   $this->form_validation->set_rules('new_password', 'New password', 'trim|required|min_length[5]|max_length[12]|matches[confirm_password]');
				   $this->form_validation->set_rules('confirm_password', 'Confirm password', 'trim|required');	
				   $data['password']= md5($this->input->post('new_password'));			   
			   }
			   if($this->input->post('email') != $data2['user_data']->email) {
				  $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
			   }
			   if ($this->form_validation->run() == FALSE){
				   $data2['errornotification'] = TRUE;
				   $this->wall2all->a_view('user-edit_view', $data2); 
			   }else{
				   $data2['successfully'] = TRUE;
				   $this->users_model->update_users($data);
				   $data['venues'] = $this->get_model->get_all('venues',false,true);
				   $data2['user_data'] = $this->get_model->get_all_where_single('users' ,'id', $id);
				   $this->wall2all->a_view('user-edit_view', $data2); 
			   }
			  }else{
				  $data['s_users'] = TRUE;
			      $data['common_users'] = TRUE;
				  $data['venues'] = $this->get_model->get_all('venues',false,true);
				  $data['user_data'] = $this->get_model->get_all_where_single('users' ,'id', $id);
				  $this->wall2all->a_view('user-edit_view', $data); 				 
			  }
		  }elseif($edit == 'insert'){ 
		    $data['s_users'] = TRUE;
			$data['add_users'] = TRUE;
		    if(isset($_POST['submit_user_form'])){
			   $this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[users.username]');
			   $this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[users.email]');
			   $this->form_validation->set_rules('first_name', 'First name', 'required');
			   $this->form_validation->set_rules('last_name', 'Last name', 'required');
			   $this->form_validation->set_rules('town', 'Town', 'required');	
			   $this->form_validation->set_rules('mobile', 'Mobile', '');	
			   $this->form_validation->set_rules('country', 'Country', 'required');	
			   $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|max_length[12]|matches[confirm_password]');
               $this->form_validation->set_rules('confirm_password', 'Confirm password', 'trim|required');
			   if ($this->form_validation->run() == FALSE){
				   $data['adding_user_error']= TRUE;
				   $this->wall2all->a_view('user-add_view', $data); 
			   }else{
				   $data = $this->input->post();
				   $data['password']= md5($this->input->post('password'));
				   if($this->users_model->insert_user($data)){
					   redirect(base_url().'admin/users/', 'refresh');
				   }
			   }
			}else{
				 $data['user_data'] = $this->get_model->get_all_where_single('users' ,'id', $this->session->userdata('id'));			                  		                
				 $this->wall2all->a_view('user-add_view', $data); 
			}
          }elseif($edit == 'facebook-users'){
			  	if($this->session->userdata('successfully')){
				   $data['successfully'] = TRUE;
				   $this->session->unset_userdata('successfully');
			    }
				$this->users_model->init_face_users();
			  	$this->load->library('pagination');
				$config['base_url'] = base_url().'admin/users/facebook-users/';
				$config['total_rows'] = $this->users_model->get_num_face_users();
				$config['per_page'] = 15;
				$config['num_links'] = 2;
				$config['uri_segment'] = 4;
				$this->pagination->initialize($config);
			  
			  $data['s_users'] = TRUE;
			  $data['face_users'] = TRUE;
			  
			  $data['users_num'] = $this->users_model->get_num_face_users();
			  $data['users_data'] = $this->users_model->face_users_with_condition($config['per_page'],$this->uri->segment(4));
			  $this->wall2all->a_view('users_panel_facebook', $data); 	
		  }elseif($edit == 'twitter-users'){
			  	if($this->session->userdata('successfully')){
				   $data['successfully'] = TRUE;
				   $this->session->unset_userdata('successfully');
			    }
                $this->users_model->init_twit_users();
			  	$this->load->library('pagination');
				$config['base_url'] = base_url().'admin/users/twitter-users/';
				$config['total_rows'] = $this->users_model->get_num_twit_users();
				$config['per_page'] = 15;
				$config['num_links'] = 2;
				$config['uri_segment'] = 4;
				$this->pagination->initialize($config);
			  $data['s_users'] = TRUE;
			  $data['twit_users'] = TRUE;
			  $data['users_num'] = $this->users_model->get_num_twit_users();
			  $data['users_data'] = $this->users_model->twit_users_with_condition($config['per_page'],$this->uri->segment(4));
			  $this->wall2all->a_view('users_panel_twit', $data); 			  
			    
		  }else{
			  
				if($this->session->userdata('successfully')){
				   $data['successfully'] = TRUE;
				   $this->session->unset_userdata('successfully');
			    }
			    $this->users_model->init_reg_users();
			  	$this->load->library('pagination');
				$config['base_url'] = base_url().'admin/users/';
				$config['total_rows'] = $this->users_model->get_num_reg_users();
				$config['per_page'] = 15;
				$config['num_links'] = 2;
				$config['uri_segment'] = 3;
				$this->pagination->initialize($config);
			  
			  $data['users_num'] = $this->users_model->get_num_reg_users();
			  $data['users_data'] = $this->users_model->reg_users_with_condition($config['per_page'],$this->uri->segment(3));
			  $data['s_users'] = TRUE;
			  $data['common_users'] = TRUE;
			  $this->wall2all->a_view('users_panel_all', $data); 
		  }
		  
		  
	  }else{
		  redirect(base_url().'admin/', 'refresh');
	  }
   }
   function home(){
	   
	   $data['home'] = TRUE;
	   
	   if(isset($_POST['submit_home_form'])){
		   
		   $dataa = $this->input->post();
		   $i = 0;
		   foreach($dataa as $key=>$d){
			   if(($key === 'recommend1')||($key === 'recommend2')||($key === 'recommend3')||($key === 'recommend4')){
				  
				    if($Up_data = $this->home_model->getEwithV($d)){
					    $this->home_model->update($Up_data,++$i);
					}
					
				  
			   }
		   }
		  
		   if($this->home_model->update_youtube()){
			   $data['youtube'] = $this->get_model->get_all_where_single('homeyoutube','id',1)->url;
			   $data['banners'] = $this->get_model->get_all_where_single('homeyoutube', 'id', 1)->banners;
			   $data['background'] = $this->get_model->get_all_where_single('homeyoutube', 'id', 1)->background_image;
		   }
		   
		   $data['succ_home'] = TRUE;
		   $data['recommend1'] = $this->get_model->get_all_where_single('weRecommend','id',1);
		   $data['recommend2'] = $this->get_model->get_all_where_single('weRecommend','id',2);
		   $data['recommend3'] = $this->get_model->get_all_where_single('weRecommend','id',3);
		   $data['recommend4'] = $this->get_model->get_all_where_single('weRecommend','id',4);
		   $data['all_events']= $this->get_model-> get_all('events',FALSE,TRUE);
		   $this->wall2all->a_view('home_view', $data); 
		   
	   }else{
		   $data['youtube'] = $this->get_model->get_all_where_single('homeyoutube','id',1)->url;
		   $data['banners'] = $this->get_model->get_all_where_single('homeyoutube', 'id', 1)->banners;
		   $data['background'] = $this->get_model->get_all_where_single('homeyoutube', 'id', 1)->background_image;
		   $data['recommend1'] = $this->get_model->get_all_where_single('weRecommend','id',1);
		   $data['recommend2'] = $this->get_model->get_all_where_single('weRecommend','id',2);
		   $data['recommend3'] = $this->get_model->get_all_where_single('weRecommend','id',3);
		   $data['recommend4'] = $this->get_model->get_all_where_single('weRecommend','id',4);
		   $data['all_events']= $this->get_model-> get_all('events',FALSE,TRUE);
		   $this->wall2all->a_view('home_view', $data); 
	   }
	  
   }
   	function logout() {
       $this->wall2all->logout();
	   redirect(base_url().'admin/', 'refresh');
	}
	
	 function comment_mdelete() {
	  
		if($this->venue_admin){
			
			$data = $this->input->post();
			foreach($data as $key => $id){
				if(stristr($key,'spec_checkbox_')){
				  $this->comments_model->delete_comment($id);
				}
			}
			
			$this->session->set_userdata('successfully', TRUE);
			
			if($this->uri->segment(3) == 'l'){
				redirect(base_url().'admin/comments//liked-comments/', 'refresh');
			}elseif($this->uri->segment(3) == 'r'){
				redirect(base_url().'admin/comments/reported-comments/', 'refresh');
			}else{
				redirect(base_url().'admin/comments/', 'refresh');
			}
		
		}else{
		  redirect(base_url().'admin/', 'refresh');
		}	
	 }	
	
	 function event_mdelete() {
	  
		if($this->venue_admin){
			
			$data = $this->input->post();
			foreach($data as $key => $id){
				if(stristr($key,'spec_checkbox_')){
				  $this->events_model->delete_event($id);
				}
			}
			$this->session->set_userdata('successfully', TRUE);
			redirect(base_url().'admin/events/', 'refresh');
		
		}else{
		  redirect(base_url().'admin/', 'refresh');
		}	
	}	
	
	 function venue_mdelete() {
	  
		if($this->venue_admin){
			
			$data = $this->input->post();
			foreach($data as $key => $id){
				if(stristr($key,'spec_checkbox_')){
				  $this->venues_model->delete_venue($id);
				}
			}
			$this->session->set_userdata('successfully', TRUE);
			redirect(base_url().'admin/venues/', 'refresh');
		
		}else{
		  redirect(base_url().'admin/', 'refresh');
		}	
	}
	
	function multy_users_delete(){
		$data = $this->input->post();
		foreach($data as $key => $id){
			if(stristr($key,'spec_checkbox_')){
			  $this->users_model->delete_user($id);
			}
		}
		$this->session->set_userdata('successfully', TRUE);
		if($this->uri->segment(3) == 'f'){
			redirect(base_url().'admin/users/facebook-users/', 'refresh');
		}elseif($this->uri->segment(3) == 't'){
			redirect(base_url().'admin/users/twitter-users/', 'refresh');
		}else{
			redirect(base_url().'admin/users/', 'refresh');
		}
	}
	function admin_users_delete($id, $facebook = false, $twitter = false) {
	  
		if($this->master_admin){
			
    		  if($this->users_model->delete_user($id)){
				  if($facebook){
                     redirect(base_url().'admin/users/facebook-users/', 'refresh');
				  }elseif($twitter){
					 redirect(base_url().'admin/users/twitter-users/', 'refresh');
				  }else{
					 redirect(base_url().'admin/users/', 'refresh');
				  }
				}       
				 
				 
		}else{
		  redirect(base_url().'admin/', 'refresh');
		}	
	}
}