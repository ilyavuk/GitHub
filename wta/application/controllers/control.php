<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Control extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
	}
	function index() {
	  
	  
	  if($this->logged_in){
			
		 $this->wall2all->front_view('control_view');
			
	  }else{
		  redirect(base_url(), 'refresh');
	  }	

	}
	function account_settings() {
		
	   if($this->common_logged_in){
		   
		   $data['selected_cat']= $this->categories_model->UserPreferredEvents($this->session->userdata('id'));
		   
		  if($this->facebook_admin){
			  
			if(isset($_POST['submit_faccount_form'])){
				
			   $dataf = $this->input->post();
			   if(!empty($dataf['selected_cat'])){
					$this->categories_model->update_UserPreferredEvents($this->session->userdata('id'), $dataf['selected_cat']);
			   }
				$data['selected_cat']= $this->categories_model->UserPreferredEvents($this->session->userdata('id'));
				$this->wall2all->front_view('account-settings_view', $data);
				
			}else{
				
				$this->wall2all->front_view('account-settings_view', $data);
				
			}
			 
		  }elseif($this->twitter_admin){ 
		  
		  
			if(isset($_POST['submit_taccount_form'])){
				
			   $datat = $this->input->post();
			   if(!empty($datat['selected_cat'])){
					$this->categories_model->update_UserPreferredEvents($this->session->userdata('id'), $datat['selected_cat']);
			   }
				$data['selected_cat']= $this->categories_model->UserPreferredEvents($this->session->userdata('id'));
				$this->wall2all->front_view('account-settings_view', $data);
				
			}else{
				
				$this->wall2all->front_view('account-settings_view', $data);
				
			}

		  }else{
			  
				  if(isset($_POST['submit_account_form'])){ 
					   $data = $this->input->post();
					   $data2['user_data'] = $this->get_model->get_all_where_single('users' ,'id', $this->session->userdata('id'));
					   $this->form_validation->set_rules('username', 'Username', 'required');
					   $this->form_validation->set_rules('first_name', 'First name', 'required');
					   $this->form_validation->set_rules('last_name', 'Last name', 'required');
					   $this->form_validation->set_rules('town', 'Town', 'required');	
					   $this->form_validation->set_rules('country', 'Country', 'required');	
					   $this->form_validation->set_rules('birthday', 'Birthday', 'required');
					   $this->form_validation->set_rules('sex','Sex','required|callback_check_default');
					   
					   if($this->input->post('new_password')!='') {
						$this->form_validation->set_rules('new_password', 'New password', 'trim|required|min_length[5]|max_length[12]|matches[confirm_password]');
						   $this->form_validation->set_rules('confirm_password', 'Confirm password', 'trim|required');	
						   $data['password']= md5($this->input->post('new_password'));			   
					   }
					   if($this->input->post('email') != $data2['user_data']->email) {
						  $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
					   }		  
				  
						if ($this->form_validation->run() == FALSE){
						   $this->wall2all->front_view('account-settings_view', $data2); 	
					   }else{
						   $this->users_model->update_users_front($data);
						   $data2['user_data'] = $this->get_model->get_all_where_single('users' ,'id', $this->session->userdata('id'));
						   if(!empty($data['selected_cat'])){
								$this->categories_model->update_UserPreferredEvents($this->session->userdata('id'), $data['selected_cat']);
						   }
						   $data2['selected_cat']= $this->categories_model->UserPreferredEvents($this->session->userdata('id'));
						   $this->wall2all->front_view('account-settings_view', $data2); 	
					   }
				  
				   
		
				  }else{
					 $data['user_data'] = $this->get_model->get_all_where_single('users' ,'id', $this->session->userdata('id'));		
					 $this->wall2all->front_view('account-settings_view',$data);		  
				  }
				
				 
				 
	     }
					
	  }else{
		  redirect(base_url(), 'refresh');
	  }	
		
	}
	
	
	function check_default($str)
	{

		if($str == '0')
		{ 
		$this->form_validation->set_message('check_default', 'You need to select something other than the default');
		 return FALSE;
		}
	
	 return TRUE;
	}	
	
	function test() {
		echo 'Here';
	}
}