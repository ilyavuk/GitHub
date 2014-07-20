<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Twitter extends CI_Controller {
	
	function __construct()
	{
		    parent::__construct();
			
			$this->load->library('tweet');
			$this->tweet->enable_debug(TRUE);

			
	}
	function index(){
		
			if ( !$this->tweet->logged_in() )
			{
				
				$this->tweet->set_callback(site_url('twitter/auth'));
				$this->tweet->login();
				
/*			    redirect(base_url(), 'refresh');
*/		       
			}
			else
			{
                  /*$tokens = $this->tweet->get_tokens(); 
				  $user = $this->tweet->call('get', 'account/verify_credentials');
				    if($user){
					  if($this->users_model->check_twitter_user($user->id)){
						 if($this->users_model->is_blocked('twitter_id',$user->id)){
							  $id_twitter_user = $this->users_model->return_twitter_user_id($user->id);
							  $this->users_model->update_twitter_user($user, $id_twitter_user);
						 }else{
					          $this->session->set_userdata('social_blocked', '<script>alert("Sorry! Twitter user is blocked");</script>');
					     }					  
					  }else{
						  $this->users_model->insert_twitter_user($user);
					  }
					}
				  redirect(base_url(), 'refresh');*/
			}
			
	}
	function auth()
	{

		if ($this->session->userdata('previous_url') !== FALSE) {
			$redirect_url = $this->session->userdata('previous_url');
		}else{
			$redirect_url = base_url();
		}
	   
	    if ( !$this->tweet->logged_in()){
		  die('somehow you are not logged in');
		 }
			

	    $tokens = $this->tweet->get_tokens();
		$user = $this->tweet->call('get', 'account/verify_credentials');

              if($user){

				  if($this->users_model->check_twitter_user($user->id)){
					 if($this->users_model->is_blocked('twitter_id',$user->id)){
						 $id_twitter_user = $this->users_model->return_twitter_user_id($user->id);
						 $this->users_model->update_twitter_user($user, $id_twitter_user);
					 }else{
					     $this->session->set_userdata('social_blocked', '<script>alert("Sorry! Twitter user is blocked");</script>');
					 }
				  }else{
					  $this->users_model->insert_twitter_user($user);
				  }
	          
			  
			  
			   }
			  
	     redirect($redirect_url, 'refresh');
	
	
	}
	function t_logout() {
		$this->session->sess_destroy();
		redirect(base_url(), 'refresh');
	}
	
}