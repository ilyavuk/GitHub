<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Live_events extends MY_Controller { 
	
	function __construct()
	{
		parent::__construct();
	}
	function index() {
  
	}
    function admin_live_events($var = false, $var2 = false) {
		
	      $data['events_live'] = TRUE;
		  
		  if($var ==  'select'){
			  
			  	$this->load->library('pagination');
				$config['base_url'] = base_url().'admin/live-events/select/';
				$config['total_rows'] = $this->events_model->get_evts_users($var2,false,false,true,true);
				$config['per_page'] = 5;
				$config['num_links'] = 2;
				$config['uri_segment'] = 5;
				$this->pagination->initialize($config);
				
			
			  $data['selected_user']= $var2;
			  $data['events_num'] = $this->events_model->get_evts_users($var2,false,false,true,true);
			  $data['events'] = $this->events_model->get_evts_users($var2,$config['per_page'],$this->uri->segment(5),true);
			  $data['users'] = $this->get_model->get_all('users');
			 
			  $this->wall2all->a_view('live-events_panel',$data); 
			  
		  }elseif($var ==  'play'){
			 $data['initial_comments_id'] =  $this->comments_model->get_next_num() - 1;
			 $data['average'] = $this->grade_model->calculate_average_grade($var2,'events_grade');
			 $data['poll1'] = $this->grade_model->calculate_average_grade($var2,'poll1');
			 $data['poll2'] = $this->grade_model->calculate_average_grade($var2,'poll2');
			 $data['num_attendings'] = $this->attending_model->all_att($var2);
			 $data['attendings'] = $this->attending_model->return_attending_data($var2);		  
		     $data['event'] = $this->events_model->event_detail($var2);
			 $data['comments'] = $this->comments_model->return_comment_data($var2,15,0);
		     $this->load->view('front/_common/html_top_view');
			 $this->load->view('front/live-event_view',$data); 
		  
		  }else{
		
				$this->load->library('pagination');
				$config['base_url'] = base_url().'admin/live-events/';
				$config['total_rows'] = $this->events_model->get_evts_users(false,false,false,true,true);
				$config['per_page'] = 5;
				$config['num_links'] = 2;
				$config['uri_segment'] = 3;
				$this->pagination->initialize($config);
				
			
			  $data['events_num'] = $this->events_model->get_evts_users(false,false,false,true,true);
			  $data['events'] = $this->events_model->get_evts_users(false,$config['per_page'],$this->uri->segment(3),true);
			  $data['users'] = $this->get_model->get_all('users');
			 
			  $this->wall2all->a_view('live-events_panel',$data); 
		  }
	 
	  }
	
	 function live($var='go-go'){
		 	
			 $var2 = $this->get_model->get_all_where_single('events', 'url_title', $var, true);
			 if($var2){
				 $var2 = $var2->id;
				 $data['initial_comments_id'] =  $this->comments_model->get_next_num() - 1;
				 $data['num_attendings'] = $this->attending_model->all_att($var2);
				 $data['attendings'] = $this->attending_model->return_attending_data($var2);		  
				 $data['event'] = $this->events_model->event_detail($var2);
				 $data['average'] = $this->grade_model->event_grade('events_grade',$var2,false,true,$data['event']->start_date,$data['event']->end_date);
				 $data['poll1'] = $this->grade_model->event_grade('poll1',$var2,false,true,$data['event']->start_date,$data['event']->end_date);
				 $data['poll2'] = $this->grade_model->event_grade('poll2',$var2,false,true,$data['event']->start_date,$data['event']->end_date);				 
				 $data['comments'] = $this->comments_model->return_comment_data($var2,15,0);
				 $this->load->view('front/_common/html_top_view');
				 $this->load->view('front/live-event_view',$data); 
				 
			 }else{
				 
				 show_404();
				 
			 }
	 }
	
	
}