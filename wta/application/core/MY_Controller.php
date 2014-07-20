<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    var $common_logged_in = FALSE; 
	var $logged_in = FALSE; 
	var $twitter_admin = FALSE;
	var $facebook_admin = FALSE;
	var $registered_admin = FALSE;
	var $venue_admin = FALSE;
	var $master_admin = FALSE;
	
	var $user_icon = FALSE;

	function __construct()
	{
		parent::__construct();
		
		$this->form_validation->set_error_delimiters('', '');
		
		
		
		if(($this->session->userdata('facebook_id') == 0)&&($this->session->userdata('twitter_id') == 0)&&($this->session->userdata('id') != 0)){
			$this->logged_in = TRUE;
			$this->common_logged_in = TRUE;
		}
		if(($this->logged_in)&&($this->users_model->is_blocked('id',$this->session->userdata('id')))){
			if($this->session->userdata('is_admin')==1){
				
				$this->registered_admin = TRUE;
				$this->user_icon = 'R';
				
			}elseif($this->session->userdata('is_admin')==2){
				
				$this->registered_admin = TRUE;
				$this->venue_admin = TRUE;
				$this->user_icon = 'E';
				
			}elseif($this->session->userdata('is_admin')==3){
				
				$this->registered_admin = TRUE;
				$this->venue_admin = TRUE;
				$this->master_admin = TRUE;
				$this->user_icon = 'M';
			}
		}elseif(($this->logged_in)&&($this->users_model->is_blocked('id',$this->session->userdata('id'))== false)){
			
			$this->session->sess_destroy();
			$this->logged_in = FALSE;	
			$this->registered_admin = FALSE;
			$this->venue_admin = FALSE;
			$this->master_admin = FALSE;
			// added 18.10.2012
			$this->common_logged_in = FALSE;
			
		}
		if($this->session->userdata('facebook_id')){
           if($this->users_model->is_blocked('facebook_id',$this->session->userdata('facebook_id'))){
              $this->facebook_admin = TRUE;
			  $this->common_logged_in = TRUE;
			  if($this->session->userdata('is_admin')==2){
				  $this->venue_admin = TRUE;
			  }
		   }else{
			  $this->session->sess_destroy();
			  $this->facebook_admin = FALSE;
			  $this->common_logged_in = FALSE;
		   }
		
		}
		if($this->session->userdata('twitter_id')){
		   if($this->users_model->is_blocked('twitter_id',$this->session->userdata('twitter_id'))){
			 $this->twitter_admin = TRUE;
			 $this->common_logged_in = TRUE;
			 if($this->session->userdata('is_admin')==2){
				 $this->venue_admin = TRUE;
			 }
		   }else{
			  $this->session->sess_destroy();
			  $this->twitter_admin = FALSE;	
			  $this->common_logged_in = FALSE;	   
		   }
		}

	}
}

