<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
	}
	function index() {
	  
	    $this->events_model->init_events_with_condition('live',true);
		$live_events = $this->events_model->return_events_with_condition();
	    $this->events_model->init_events_with_condition('upcoming',true);
		$upcoming_events = $this->events_model->return_events_with_condition();
		
	  	$this->load->library('googlemaps');
		$config['center'] = '44.8206, 20.4622';
		$config['zoom'] = '12';
       
		$this->googlemaps->initialize($config);
	    $k = 0;

	    if($upcoming_events){

			foreach($upcoming_events as $upcoming_event) {
				$marker = array();
				$marker['position'] = $upcoming_event->country .','. $upcoming_event->city .','. $upcoming_event->address;
				
	
				$marker['icon'] = base_url().'assets/img/map-icon-upcoming.png';
				$marker['zIndex'] ='50';
				$desc = ($upcoming_event->description_events != '')?removeTokens($upcoming_event->description_events):'No description';
				$data['windows'][$k] = '<div id="popup'.$k.'" class="popup" data-num="'.$k.'"><article> <header> <a href="'.base_url().$upcoming_event->url_title.'" ><h2>'.$upcoming_event->title_events.'</h2></a> </header><p>'.
				$desc
				
				.'</p> <p></p> <footer></footer> <a href="#" class="next">next</a> | <a href="#" class="prev">previous</a>  <a href="#" class="close">close</a> </article></div>';
				$marker['onclick'] = 'eventOnClick('.$k.',popup'.$k.');';
				$data['hwindows'][$k] = '<div id="hover'.$k.'" class="hover" >  '.$upcoming_event->title_events.'</div>';
				$marker['magicBox'] = '<p>'.$upcoming_event->title_events .'</p>';
				$k++;


				$this->googlemaps->add_marker($marker);  
			}
	    }	
		
	    if($live_events){
		 
			foreach($live_events as $live_event) {
				$marker = array();
				$marker['position'] = $live_event->country .','. $live_event->city .','. $live_event->address;
				
	
				$marker['icon'] = base_url().'assets/img/map-icon-live.png';
				$marker['zIndex'] ='50';
//				$desc = ($live_event->description_events != '')?str_replace('"','', (json_encode(word_limiter($live_event->description_events,50)))):'No description';
//                $desc = ($live_event->description_events != '')?superSpecCharRemove($live_event->description_events):'No description';
				$desc = ($live_event->description_events != '')?removeTokens($live_event->description_events):'No description';
				$average_grade = $this->grade_model->event_grade('events_grade',$live_event->id_events,false,true,$live_event->start_date,$live_event->end_date);
				$data['windows'][$k] = trim( '<div id="popup'.$k.'" class="popup" data-num="'.$k.'"><article> <header> <a href="'.base_url().$live_event->url_title.'" ><h2>'.$live_event->title_events.'</h2></a><br/>Event Rate: '.$average_grade.' </header><p>'.
				$desc .'</p><footer></footer> <a href="#" class="next">next</a> | <a href="#" class="prev">previous</a>  <a href="#" class="close">close</a> </article></div>');
				$marker['onclick'] = 'eventOnClick('.$k.',popup'.$k.');';
				$marker['magicBox'] = '<p>'.$live_event->title_events .'</p><p class="rate" >Event Rate:'.$average_grade.'</p>';
				
				
				
				$k++;
				$this->googlemaps->add_marker($marker);  
			}
	    }		
			

	    $data['is_center'] = $config['center'];
	    $data['map'] = $this->googlemaps->create_map();
		$data['we_recommends'] = $this->get_model->get_all('weRecommend');
		$data['youtube'] = $this->get_model->get_all_where_single('homeyoutube', 'id', 1)->url;
		$data['banners'] = $this->get_model->get_all_where_single('homeyoutube', 'id', 1)->banners;
		$data['background'] = $this->get_model->get_all_where_single('homeyoutube', 'id', 1)->background_image;
		$data['what_is_news'] = $this->home_model->get_what_is_new();
		$data['last_posts'] = $this->home_model->get_last_posts();
		$data['bad_words'] = $this->comments_model->get_b_words();
	    $this->wall2all->front_view('central_view', $data);
	 
	 }
	 
    function login() {
		
			if($this->wall2all->login($this->input->post('usernameLog'), $this->input->post('passwordLog'))){
				
				if (($this->session->userdata('previous_url') !== FALSE)&&(strpos($this->session->userdata('previous_url'), 'reset-account')==FALSE)) {
					$redirect_url = $this->session->userdata('previous_url');
				}else{
					$redirect_url = base_url();
				}
            redirect($redirect_url, 'refresh');
            
			}else{
				
				$this->session->set_userdata('error_loggin', true);
				redirect(base_url().'register/', 'refresh');
				
			}
	}
	function reset_account () {
		$data = false;
		if(isset($_POST['submit_recover_email'])) {
			
			$this->form_validation->set_rules('recover_email', 'Email', 'trim|required|is_unique[users.email]');
			if ($this->form_validation->run()==FALSE){
                 $this->users_model->reset_user_password($this->input->post('recover_email'));
				 $data['successfully_sent'] = TRUE;
			}else {
				 $data['no_email'] = TRUE;
		   } 
		}
		$this->wall2all->front_view('reset_account', $data);
		
	}
	function logout() {
       $this->wall2all->logout();
	   redirect(base_url(), 'refresh');	
	}
	
	function register($next = false) {
		if($next == 'next'){
			if($this->session->userdata('registration_data') != 0){
				$data['next'] = true;
				$data['categories']= $this->get_model->get_all('categories');
				if(isset($_POST['sub_selected_cat'])){
					$data = $this->session->userdata('registration_data');
					$data['password']= md5($this->input->post('password'));
					$last_id = $this->users_model->insert_user_front($data,true);
						$post_data = $this->input->post();
						if(!empty($post_data['selected_cat'])){
							$data['selected_cat'] = $post_data['selected_cat'];
							$this->categories_model->insert_UserPreferredEvents($data['selected_cat'], $last_id);
						}
					$this->session->unset_userdata('registration_data');
					redirect(base_url(), 'refresh');	
				}
				$this->wall2all->front_view('registar_view', $data);
			}else{
				redirect(base_url(), 'refresh');
			}
		}else{
			if($this->common_logged_in == FALSE){
			
				 if(isset($_POST['submit_register_form'])){
					 
						   $this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[users.username]');
						   $this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[users.email]');
						   $this->form_validation->set_rules('first_name', 'First name', 'required');
						   $this->form_validation->set_rules('last_name', 'Last name', 'required');
						   $this->form_validation->set_rules('town', 'Town', 'required');	
						   $this->form_validation->set_rules('country', 'Country', 'required');	
						   $this->form_validation->set_rules('birthday', 'Birthday', 'required');	
						   $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|max_length[12]|matches[confirm_password]');
						   $this->form_validation->set_rules('confirm_password', 'Confirm password', 'trim|required');
						   $this->form_validation->set_rules('sex','Sex','required|callback_check_default');
						
					  if ($this->form_validation->run() == FALSE){
						  $this->wall2all->front_view('registar_view');
					  }else{
						  $this->session->set_userdata('registration_data', $this->input->post());
						  redirect(base_url().'register/next', 'refresh');
					  }
					  
				 }else{
					 
					  $this->session->unset_userdata('previous_url');
					  if(isset($_SERVER['HTTP_REFERER'])){
						  $prev_url =  $_SERVER['HTTP_REFERER'];
					  }else{
						  $prev_url = base_url();
					  }
					  $this->session->set_userdata('previous_url', $prev_url);
					  $this->wall2all->front_view('registar_view');
				 
				}	
				
			}else{
				redirect(base_url(), 'refresh');
			}
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
	function TermsAndPrivacy(){
	   $this->wall2all->front_view('termsAndPrivacy');
	}
}