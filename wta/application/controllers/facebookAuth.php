<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class FacebookAuth extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		parse_str( $_SERVER['QUERY_STRING'], $_REQUEST );
		$CI = & get_instance();
        $CI->config->load("facebook",TRUE);
        $config = $CI->config->item('facebook');
        $this->load->library('Facebook', $config);
	}
	function index() {
		
		
		$userId = $this->facebook->getUser();

		if($userId == 0){
			
			$params = array(
							  'scope' => 'email, publish_stream, create_event, user_birthday',
							  'redirect_uri' => base_url().'facebookAuth'
							);
			
			
			$data['url'] = $this->facebook->getLoginUrl($params); 
		    redirect($data['url'], 'refresh');
		
		} else {
			
				$user = $this->facebook->api('/me');
				
				if ($this->session->userdata('previous_url') !== FALSE) {
					$redirect_url = $this->session->userdata('previous_url');
				}else{
					$redirect_url = base_url();
				}
				
				
				if($this->users_model->check_facebook_user($userId)){
					  if($this->users_model->is_blocked('facebook_id',$userId)){
						  
						  
						 $data['facebook_user_id'] = $this->users_model->return_facebook_user_id($userId);
						 $this->users_model->update_facebook_user($user, $data['facebook_user_id']);
						 redirect($redirect_url, 'refresh');						  
						  
						  
					  }else{
						  
						 $this->session->set_userdata('social_blocked', '<script>alert("Sorry! Facebook user is blocked");</script>');
                         redirect($redirect_url, 'refresh');
					  }
					 
				}else{
					
					/*print_r($user);
					print_r($this->facebook->getAccessToken());
					die();*/
					$this->users_model->insert_facebook_user($user);
					redirect($redirect_url, 'refresh');
				}			

			
			
		}
	}
	
	function f_logout() {
		
		$this->session->sess_destroy();	
		redirect(base_url(), 'refresh');
		
	}
	
	function get_token(){
		
		$access_token = $this->facebook->getAccessToken();
		print_r($access_token);
	}

}