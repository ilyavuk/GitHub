<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Events extends MY_Controller { 
	
	function __construct()
	{
		parent::__construct();
	}
	function index() {
  
	}
   function admin_events($var = false, $var2 = false, $var3 = false, $var4 = false, $var5 = false ) {	
   
		
	  if($this->venue_admin){
		  
		 if(($var !=  'edit')&&($var !=  'insert')&&($var !=  'select')&&($var !=  'reports')){
			 
			 $data['events_s']= TRUE;
			 $data['events_all']= TRUE;
			 	
				if($this->session->userdata('successfully')){
				   $data['successfully'] = TRUE;
				   $this->session->unset_userdata('successfully');
			    }	
			 
		  		$this->load->library('pagination');
				$config['base_url'] = base_url().'admin/events/';
				if($this->master_admin){
					$config['total_rows'] = $this->events_model->all_events();
				}else{
					$event_user = $this->get_model->get_all_where_single('venues', 'users_id', $this->session->userdata('id'));
					if($event_user){
					  $config['total_rows'] = $this->events_model->all_events($this->session->userdata('id'), $event_user->id);
					}else{
					  $config['total_rows'] = 0;
					}
				}
				$config['per_page'] = 10;
				$config['num_links'] = 2;
				$config['uri_segment'] = 3;
				$this->pagination->initialize($config);
		
		    if($this->master_admin){
				$data['events_num'] = $this->events_model->all_events();
				$data['events'] = $this->events_model->get_evts_users(false,$config['per_page'],$this->uri->segment(3));
			}else{
				if($event_user){
					$data['events_num'] = $this->events_model->all_events($this->session->userdata('id'), $event_user->id);
					$data['events'] = $this->events_model->get_evts_users($this->session->userdata('id'),$config['per_page'],$this->uri->segment(3),false,false,$event_user->id);
				}else{
					$data['events_num'] = 0;
					$data['events'] = 0;
				}
				                                                     
			}
			$data['users'] = $this->get_model->get_all('users');
			$this->wall2all->a_view('events_panel', $data); 
//	 Reports
		 }elseif($var ==  'reports'){
			 
			if($var2 == 'poll'){
				
				if($var3=='rate-event'){
					
                   $this->Poll($var3,$var4,$var5);
				
				}elseif($var3=='poll1'){
					
					$this->Poll($var3,$var4,$var5);
					
				}elseif($var3=='poll2'){
					
					$this->Poll($var3,$var4,$var5);
					
				}
				
			}elseif($var2 == 'attending'){
				
				if($var3 == 'age'){
					$data['num_att'] = 0;
					$data['unknown_age'] = 0;
					$data['sel_age'] = $var5;
					
					$data['event'] = $this->get_model->get_all_where_single('events','id',$var4);
					$data['att_users'] = $this->attending_model->return_attending_data($var4,false,false);
					
					
					if($var5 == 18){
						
							$cur_year = date("Y",time());
							$past_year = $cur_year - $var5;
							$ageBarrier = strtotime($past_year);
		
							foreach($data['att_users'] as $att_user){
							
									if(($att_user['birthday']==0)||($att_user['birthday']=='')){
										$data['unknown_age']++;
									}else{
										if($ageBarrier < strtotime($att_user['birthday'])){
										   $data['num_att']++;
										}
									}
							}
							
					}elseif($var5 == 25){
						
							$cur_year = date("Y",time());
							$past_year_max = $cur_year - $var5;
							$ageBarrier_max= strtotime($past_year_max);
							$past_year_min = $cur_year - 18;
							$ageBarrier_min= strtotime($past_year_min);
							
							foreach($data['att_users'] as $att_user){
							
									if(($att_user['birthday']==0)||($att_user['birthday']=='')){
										$data['unknown_age']++;
									}else{
										if(($ageBarrier_max < strtotime($att_user['birthday']))&&($ageBarrier_min > strtotime($att_user['birthday']))){
										   $data['num_att']++;
										}
									}
							}
													
					}elseif($var5 == 35){	
					
							$cur_year = date("Y",time());
							$past_year_max = $cur_year - $var5;
							$ageBarrier_max= strtotime($past_year_max);
							$past_year_min = $cur_year - 25;
							$ageBarrier_min= strtotime($past_year_min);
							
							foreach($data['att_users'] as $att_user){
							
									if(($att_user['birthday']==0)||($att_user['birthday']=='')){
										$data['unknown_age']++;
									}else{
										if(($ageBarrier_max < strtotime($att_user['birthday']))&&($ageBarrier_min > strtotime($att_user['birthday']))){
										   $data['num_att']++;
										}
									}
							}
					}elseif($var5 == 40){
							
							$cur_year = date("Y",time());
							$past_year = $cur_year - 35;
							$ageBarrier = strtotime($past_year);
		
							foreach($data['att_users'] as $att_user){
							
									if(($att_user['birthday']==0)||($att_user['birthday']=='')){
										$data['unknown_age']++;
									}else{
										if($ageBarrier > strtotime($att_user['birthday'])){
										   $data['num_att']++;
										}
									}
							}					
					
					}else{
						
						 redirect(base_url().'admin/events/edit/attending/'.$data['event']->id, 'refresh');
						
					}
					
				  $this->wall2all->a_view('attending', $data);
				
				}elseif($var3 == 'excel'){
				
					$data['att_users']= $this->attending_model->return_attending_data($var4,false,false);
					$event = $this->get_model->get_all_where_single('events','id',$var4);
					
					$line = '';
					$headers = '';
					$headers .= 'Username' . "\t";
					$headers .= 'Birthday' . "\t";
					$headers .= 'Country' . "\t";
					
					foreach($data['att_users'] as $att_user){
						
						$line .='"'.str_replace('"', '""', $att_user['username']).'"'. "\t";
					    $line .='"'.str_replace('"', '""', $att_user['birthday']).'"'. "\t";
					    $line .='"'.str_replace('"', '""', $att_user['country']).'"'. "\t" ."\n";
						
					}
					$line = str_replace("\r","",$line);
					header("Content-type: application/x-msexcel; charset=utf-8");
					header("Content-Disposition: attachment; filename=".$event->title.".xls");
					echo "$headers\n$line";
					
					

				
				}else{
					$data['sel_age']= '';
					$data['num_att']= $this->attending_model->return_attending_data($var3,false,true);
					$data['att_users']= $this->attending_model->return_attending_data($var3,false,false);
					$data['event'] = $this->get_model->get_all_where_single('events','id',$var3);
					
					/*print_r($data['att_users']);*/
					$this->wall2all->a_view('attending', $data);
				}
				
			
			//edit
			}else{
			
			 $data['event'] = $this->get_model->get_all_where_single('events','id',$var2);
			 $this->wall2all->a_view('event_reports', $data); 
			 
		    }
			 
			 
//	 End Reports			 	
		 }elseif($var ==  'edit'){
			 
			if($var2 == 'poll'){
				
				if($var3=='rate-event'){
					
                   $this->Poll($var3,$var4,$var5);
				
				}elseif($var3=='poll1'){
					
					$this->Poll($var3,$var4,$var5);
					
				}elseif($var3=='poll2'){
					
					$this->Poll($var3,$var4,$var5);
					
				}
				
			}elseif($var2 == 'attending'){
				
				if($var3 == 'age'){
					$data['num_att'] = 0;
					$data['unknown_age'] = 0;
					$data['sel_age'] = $var5;
					
					$data['event'] = $this->get_model->get_all_where_single('events','id',$var4);
					$data['att_users'] = $this->attending_model->return_attending_data($var4,false,false);
					
					
					if($var5 == 18){
						
							$cur_year = date("Y",time());
							$past_year = $cur_year - $var5;
							$ageBarrier = strtotime($past_year);
		
							foreach($data['att_users'] as $att_user){
							
									if(($att_user['birthday']==0)||($att_user['birthday']=='')){
										$data['unknown_age']++;
									}else{
										if($ageBarrier < strtotime($att_user['birthday'])){
										   $data['num_att']++;
										}
									}
							}
							
					}elseif($var5 == 25){
						
							$cur_year = date("Y",time());
							$past_year_max = $cur_year - $var5;
							$ageBarrier_max= strtotime($past_year_max);
							$past_year_min = $cur_year - 18;
							$ageBarrier_min= strtotime($past_year_min);
							
							foreach($data['att_users'] as $att_user){
							
									if(($att_user['birthday']==0)||($att_user['birthday']=='')){
										$data['unknown_age']++;
									}else{
										if(($ageBarrier_max < strtotime($att_user['birthday']))&&($ageBarrier_min > strtotime($att_user['birthday']))){
										   $data['num_att']++;
										}
									}
							}
													
					}elseif($var5 == 35){	
					
							$cur_year = date("Y",time());
							$past_year_max = $cur_year - $var5;
							$ageBarrier_max= strtotime($past_year_max);
							$past_year_min = $cur_year - 25;
							$ageBarrier_min= strtotime($past_year_min);
							
							foreach($data['att_users'] as $att_user){
							
									if(($att_user['birthday']==0)||($att_user['birthday']=='')){
										$data['unknown_age']++;
									}else{
										if(($ageBarrier_max < strtotime($att_user['birthday']))&&($ageBarrier_min > strtotime($att_user['birthday']))){
										   $data['num_att']++;
										}
									}
							}
					}elseif($var5 == 40){
							
							$cur_year = date("Y",time());
							$past_year = $cur_year - 35;
							$ageBarrier = strtotime($past_year);
		
							foreach($data['att_users'] as $att_user){
							
									if(($att_user['birthday']==0)||($att_user['birthday']=='')){
										$data['unknown_age']++;
									}else{
										if($ageBarrier > strtotime($att_user['birthday'])){
										   $data['num_att']++;
										}
									}
							}					
					
					}else{
						
						 redirect(base_url().'admin/events/edit/attending/'.$data['event']->id, 'refresh');
						
					}
					
				  $this->wall2all->a_view('attending', $data);
				
				}elseif($var3 == 'excel'){
				
					$data['att_users']= $this->attending_model->return_attending_data($var4,false,false);
					$event = $this->get_model->get_all_where_single('events','id',$var4);
					
					$line = '';
					$headers = '';
					$headers .= 'Username' . "\t";
					$headers .= 'Birthday' . "\t";
					$headers .= 'Country' . "\t";
					
					foreach($data['att_users'] as $att_user){
						
						$line .='"'.str_replace('"', '""', $att_user['username']).'"'. "\t";
					    $line .='"'.str_replace('"', '""', $att_user['birthday']).'"'. "\t";
					    $line .='"'.str_replace('"', '""', $att_user['country']).'"'. "\t" ."\n";
						
					}
					$line = str_replace("\r","",$line);
					header("Content-type: application/x-msexcel; charset=utf-8");
					header("Content-Disposition: attachment; filename=".$event->title.".xls");
					echo "$headers\n$line";
					
					

				
				}else{
					$data['sel_age']= '';
					$data['num_att']= $this->attending_model->return_attending_data($var3,false,true);
					$data['att_users']= $this->attending_model->return_attending_data($var3,false,false);
					$data['event'] = $this->get_model->get_all_where_single('events','id',$var3);
					
					/*print_r($data['att_users']);*/
					$this->wall2all->a_view('attending', $data);
				}
				
			
			//edit
			}else{
			
			
			
			 $data['events_s']= TRUE;
			 $data['events_all']= TRUE;
			 
				if(isset($_POST['submit_event_form'])){
					
					$this->form_validation->set_rules('title', 'Title', 'required');
					$this->form_validation->set_rules('url_title', 'Url title', 'required');
					$this->form_validation->set_rules('description', 'Description');
					$this->form_validation->set_rules('start_date', 'Date and Time event starts', 'required');
					$this->form_validation->set_rules('category', 'Category', 'required');
					$this->form_validation->set_rules('end_date', 'Date and Time event ends', 'required');
					$this->form_validation->set_rules('youtube', 'Youtube');
					$this->form_validation->set_rules('vimeo', 'Vimeo');
					$this->form_validation->set_rules('theme', 'Theme');
					$this->form_validation->set_rules('live_video', 'Live Video');					
					
					if ($this->form_validation->run() == FALSE){
					 $data['num_att']= $this->attending_model->return_attending_data($var2,false,true);
					 $data['categories']= $this->get_model->get_all('categories');	
						if($this->master_admin){
							$data['venues'] = $this->get_model->get_all('venues',false,true);
						}else{
							$data['venues'] = $this->venues_model->get_venue_for_venue_user();
//							$data['venues'] = $this->get_model->get_all('venues',false,true,$this->session->userdata('id'));
						}			
					 $data['event_imgs'] = $this->get_model->get_all_where('events_img','events_id',$var2);
					 $data['event'] = $this->get_model->get_all_where_single('events','id',$var2);
					 $this->wall2all->a_view('event_edit', $data); 			
					
					}else{
						$data = $this->input->post();
						$data['is_active'] = (isset($data['is_active']))?$data['is_active']:0;
						if($this->events_model->update_event($data)){
						  $data['num_att']= $this->attending_model->return_attending_data($var2,false,true);
						  $data['categories']= $this->get_model->get_all('categories');
							if($this->master_admin){
								$data['venues'] = $this->get_model->get_all('venues',false,true);
							}else{
								$data['venues'] = $this->venues_model->get_venue_for_venue_user();
//								$data['venues'] = $this->get_model->get_all('venues',false,true,$this->session->userdata('id'));
							}
						  $data['event_imgs'] = $this->get_model->get_all_where('events_img','events_id',$var2);
						  $data['event'] = $this->get_model->get_all_where_single('events','id',$var2);
						  
						  
						  $this->wall2all->a_view('event_edit', $data);
						}
					}
				
				
				
				
				}else{
					 $data['num_att']= $this->attending_model->return_attending_data($var2,false,true);
					 $data['categories']= $this->get_model->get_all('categories');
						if($this->master_admin){
							$data['venues'] = $this->get_model->get_all('venues',false,true);
						}else{
							$data['venues'] = $this->venues_model->get_venue_for_venue_user();
//							$data['venues'] = $this->get_model->get_all('venues',false,true,$this->session->userdata('id'));
						}	
					 $data['event_imgs'] = $this->get_model->get_all_where('events_img','events_id',$var2);
					 $data['event'] = $this->get_model->get_all_where_single('events','id',$var2);
					 $this->wall2all->a_view('event_edit', $data); 
				}
			 
		  }
		 
		 
		 }elseif($var ==  'insert'){
			    
				$data['events_s']= TRUE; 
				$data['events_new']= TRUE;

				
			   if(isset($_POST['insert_event_form'])){
				    $this->form_validation->set_rules('venues_id', 'Venue', 'required');
					$this->form_validation->set_rules('title', 'Title', 'required');
					$this->form_validation->set_rules('url_title', 'Url title', 'required');
					$this->form_validation->set_rules('description', 'Description');
					$this->form_validation->set_rules('start_date', 'Date and Time event starts', 'required');
					$this->form_validation->set_rules('category', 'Category', 'required');
					$this->form_validation->set_rules('end_date', 'Date and Time event ends', 'required');
					$this->form_validation->set_rules('youtube', 'Youtube');
					$this->form_validation->set_rules('vimeo', 'Vimeo');
					$this->form_validation->set_rules('theme', 'Theme');
					$this->form_validation->set_rules('live_video', 'Live Video');	
					if ($this->form_validation->run() == FALSE){
					   $data['categories']= $this->get_model->get_all('categories');
						if($this->master_admin){
							$data['venues'] = $this->get_model->get_all('venues',false,true);
						}else{
							$data['venues'] = $this->venues_model->get_venue_for_venue_user();
//							$data['venues'] = $this->get_model->get_all('venues',false,true,$this->session->userdata('id'));
						}	
					   $id_event = $this->session->userdata('temporary_id');
					   $data['event'] = $this->get_model->get_all_where_single('events','id',$id_event);
					   $data['event_imgs'] = $this->get_model->get_all_where('events_img','events_id',$id_event);
					   $this->wall2all->a_view('event_add', $data); 
						
					}else{
					   $data = $this->input->post();
					   $data['id'] = $this->session->userdata('temporary_id');
					   $this->session->unset_userdata('temporary_id');
					   $data['is_active'] = (isset($data['is_active']))?$data['is_active']:0;
					   if($this->events_model->update_event($data)){
						  redirect(base_url().'admin/events/edit/'.$data['id'], 'refresh');
					   }
					}
			   
			   }else{
				   
				$this->session->unset_userdata('temporary_id');
				$id_event = $this->events_model->perform_start_up();
				$this->session->set_userdata('temporary_id', $id_event);
				$data['event'] = $this->get_model->get_all_where_single('events','id',$id_event);
				$data['event_imgs'] = $this->get_model->get_all_where('events_img','events_id',$id_event); 
		        $data['categories']= $this->get_model->get_all('categories');
				if($this->master_admin){
					$data['venues'] = $this->get_model->get_all('venues',false,true);
				}else{
					$data['venues'] = $this->venues_model->get_venue_for_venue_user();
//				    $data['venues'] = $this->get_model->get_all('venues',false,true,$this->session->userdata('id'));
				}
				$this->wall2all->a_view('event_add', $data); 
				
			   }
		 
		 
		 
		 
		 
		 }elseif($var ==  'select'){
			  	
				
				
				$this->load->library('pagination');
				$config['base_url'] = base_url().'admin/events/select/'.$var2;
				$config['total_rows'] = $this->events_model->all_events_where_user($var2);
				$config['per_page'] = 5;
				$config['num_links'] = 2;
				$config['uri_segment'] = 5;
				$this->pagination->initialize($config);		 
		   
		   
		   
		   	 $data['s_events']= TRUE;
			 $data['all_events']= TRUE;
		   
		   
		    $data['selected_user']= $var2;
		   	$data['events_num'] = $this->events_model->all_events_where_user($var2);
			$data['events'] = $this->events_model->get_evts_users($var2,$config['per_page'],$this->uri->segment(5));
			$data['users'] = $this->get_model->get_all('users');
			$this->wall2all->a_view('events_panel', $data); 
		
		
		
		 }
	 
	  
	 
	  }else{
		  redirect(base_url().'admin/', 'refresh');
	  }	
		
	}
	function add_event(){
		if($this->venue_admin){
			    $data['next_id'] = $this->events_model->get_auto_increment_val();
				if(isset($_POST['add_event_form'])){	
                    $this->form_validation->set_rules('title', 'Title', 'required');
					$this->form_validation->set_rules('description', 'Description');
					$this->form_validation->set_rules('start_date', 'Date and Time event starts', 'required');
					$this->form_validation->set_rules('end_date', 'Date and Time event ends', 'required');
					$this->form_validation->set_rules('youtube', 'Youtube');
					$this->form_validation->set_rules('vimeo', 'Vimeo');
					$this->form_validation->set_rules('theme', 'Theme');					
					
					if ($this->form_validation->run() == FALSE){
                      $data['venues'] = $this->get_model->get_all('venues');
					  $data['event_imgs'] = $this->get_model->get_all_where('events_img','events_id',$data['next_id']);					 
					  $this->wall2all->front_view('add-event_view',$data);	
										
					}else{
					
					   $data = $this->input->post();
					   $data['is_active'] = 1;
					   $id = $this->events_model->insert_event($data);
						  redirect(base_url().'control-panel/my-events/edit/'.$id, 'refresh');
					   				
					
					}
				
				
				
				}else{
					
				   $data['venues'] = $this->get_model->get_all('venues');
				   $this->wall2all->front_view('add-event_view',$data); 
				   
				}
		   
		}else{
		  redirect(base_url(), 'refresh');
		}	
	}
	
	function personal_events($var1 = false, $var2 = false) {
		if($this->venue_admin){
			
			if($var1 ==  false){
				
				$data['events'] = $this->events_model->get_evts_users($this->session->userdata('id'));
				$this->wall2all->front_view('user_events_view', $data); 
			
			
			}else{
			
					if(isset($_POST['edit_event_form'])){	
					
						$this->form_validation->set_rules('title', 'Title', 'required');
						$this->form_validation->set_rules('description', 'Description');
						$this->form_validation->set_rules('start_date', 'Date and Time event starts', 'required');
						$this->form_validation->set_rules('end_date', 'Date and Time event ends', 'required');
						$this->form_validation->set_rules('youtube', 'Youtube');
						$this->form_validation->set_rules('vimeo', 'Vimeo');
						$this->form_validation->set_rules('theme', 'Theme');
					
					if ($this->form_validation->run() == FALSE){
					    $data['venues'] = $this->get_model->get_all('venues');
						$data['event_imgs'] = $this->get_model->get_all_where('events_img','events_id',$var2);
						$data['event'] = $this->get_model->get_all_where_single('events','id',$var2);	
						$this->wall2all->front_view('edit-event_view', $data); 	
									
					}else{
						
					    $data = $this->input->post();
					    $data['is_active'] = 1;
					    if($this->events_model->update_event($data)){
							    
							    $data['updated'] = 'Successfully updated';
								$data['events'] = $this->events_model->get_evts_users($this->session->userdata('id'));
								$this->wall2all->front_view('user_events_view', $data); 
					    
						}
						
					}
					
					
					}else{
		                $data['venues'] = $this->get_model->get_all('venues');
						$data['event_imgs'] = $this->get_model->get_all_where('events_img','events_id',$var2);
						$data['event'] = $this->get_model->get_all_where_single('events','id',$var2);	
						$this->wall2all->front_view('edit-event_view', $data); 
					
					}
		   }
		
		
		}else{
		  redirect(base_url(), 'refresh');
		}
	}
	
	function all_events($var1 = 'default', $var2 = 'default', $var3 = false) {
	
	if($var1 == 'upcoming-events'){

		$data['selected_time_event']= $var1;
		$this->events_model->init_events_with_condition('upcoming');
		$this->load->library('pagination');
		$config['base_url'] = base_url().'events/upcoming-events/';
		$config['total_rows'] = $this->events_model->get_num_events_with_condition();
		$config['per_page'] = 9;
		$config['num_links'] = 2;
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
		
	
	  $data['num_events'] = $this->events_model->get_num_events_with_condition();
	  $data['images'] = $this->get_model->get_all('events_img');
	  $data['events'] = $this->events_model->return_events_with_condition($config['per_page'], $this->uri->segment(3));
	  $this->wall2all->front_view('all_events_view',$data);
	
	//end upcoming-events
	//start past-events
	}elseif($var1 == 'past-events'){
	    $data['selected_time_event']= $var1;
		$this->events_model->init_events_with_condition();
		$this->load->library('pagination');
		$config['base_url'] = base_url().'events/past-events/';
		$config['total_rows'] = $this->events_model->get_num_events_with_condition();
		$config['per_page'] = 9;
		$config['num_links'] = 2;
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
		
	
	  $data['num_events'] = $this->events_model->get_num_events_with_condition();
	  $data['images'] = $this->get_model->get_all('events_img');
	  $data['events'] = $this->events_model->return_events_with_condition($config['per_page'], $this->uri->segment(3));
	  $this->wall2all->front_view('all_events_view',$data);
	//end past-events
	}elseif($var1 == 'live-events'){
		$data['selected_time_event']= $var1;
		$this->events_model->init_events_with_condition('live');
		$this->load->library('pagination');
		$config['base_url'] = base_url().'events/live/';
		$config['total_rows'] = $this->events_model->get_num_events_with_condition();
		$config['per_page'] = 9;
		$config['num_links'] = 2;
		$config['uri_segment'] = 2;
		$this->pagination->initialize($config);
		
	
	  $data['num_events'] = $this->events_model->get_num_events_with_condition();
	  $data['images'] = $this->get_model->get_all('events_img');
	  $data['events'] = $this->events_model->return_events_with_condition($config['per_page'], $this->uri->segment(3));
	  $this->wall2all->front_view('all_events_view',$data);
	  
	}else{
		
		$data['selected_time_event']= '';
		$this->events_model->init_events_with_condition('another');
		$this->load->library('pagination');
		$config['base_url'] = base_url().'events/';
		$config['total_rows'] = $this->events_model->get_num_events_with_condition();
		$config['per_page'] = 9;
		$config['num_links'] = 2;
		$config['uri_segment'] = 2;
		$this->pagination->initialize($config);
		
	
	  $data['num_events'] = $this->events_model->get_num_events_with_condition();
	  $data['images'] = $this->get_model->get_all('events_img');
	  $data['events'] = $this->events_model->return_events_with_condition($config['per_page'], $this->uri->segment(2));
	  $this->wall2all->front_view('all_events_view',$data);
	}
	}
	
	
 	function event_delete($id, $redirect_front = false) {
	  
		if($this->venue_admin){
			
    		  if($this->events_model->delete_event($id)){
				  if($redirect_front){
					 redirect(base_url().'control-panel/my-events/', 'refresh');
				  }else{
                     redirect(base_url().'admin/events/', 'refresh');
				  }
				}       
				 
				 
		}else{
		  redirect(base_url().'admin/', 'refresh');
		}	
	}  
   private function Poll($var3,$var4,$var5){
	   				
			 $data['pollType'] = $var3;
			  if($data['pollType'] == 'rate-event'){
				  $table = 'events_grade';
			  }else{
				  $table = $data['pollType'];
			  }
			
			if($var4 == 'excel'){
				
				$edata['event'] = $this->get_model->get_all_where_single('events','id',$var5);
                $table_excels = $this->return_table($table,$var5,$edata['event']->start_date, $edata['event']->end_date);
				
				$data = '';
				$headers = '';
				
				$headers .= 'Start Date' . "\t";
				$headers .= 'End Date' . "\t";
				$headers .= 'Number Of Votes' . "\t";
				
				$headers .= 'Average Grade' . "\t";
				foreach ($table_excels as $table_excel) {
				$line = '';
				foreach($table_excel as $value) {                                            
					if ((!isset($value)) OR ($value == "")) {
						$value = "\t";
					} else {
						$value = str_replace('"', '""', $value);
						$value = '"' . $value . '"' . "\t";
					}
					$line .= $value;
				}
				$data .= trim($line)."\n";
			   }			
			$data = str_replace("\r","",$data);
			header("Content-type: application/x-msexcel; charset=utf-8");
            header("Content-Disposition: attachment; filename=".$edata['event']->title."_".$table.".xls");
            echo "$headers\n$data";
				
				
			}else{
					  

					  
					  if(isset($_POST['submit_poll_form'])){
						  
						  $start_time = strtotime($this->input->post('start_time'));
						  $end_time = strtotime($this->input->post('end_time'));
						  $data['start_time'] = $this->input->post('start_time');
						  $data['end_time'] = $this->input->post('end_time');
						  $data['event'] = $this->get_model->get_all_where_single('events','id',$var4);
						  $data['table_votes'] = $this->return_table($table,$var4,$data['event']->start_date, $data['event']->end_date);
						  $data['num_votes']= $this->grade_model->event_grade($table,$var4,true,false,$start_time,$end_time);
						  $data['average_grade']= $this->grade_model->event_grade($table,$var4,false,true,$start_time,$end_time);				  
						  
						  $this->wall2all->a_view('poll', $data); 
					  
					  }else{
						  
						  $data['event'] = $this->get_model->get_all_where_single('events','id',$var4);
						  $data['table_votes'] = $this->return_table($table,$var4,$data['event']->start_date, $data['event']->end_date);
						  $data['num_votes']= $this->grade_model->event_grade($table,$var4,true,false,$data['event']->start_date,$data['event']->end_date);
						  $data['average_grade']= $this->grade_model->event_grade($table,$var4,false,true,$data['event']->start_date,$data['event']->end_date);
						  $this->wall2all->a_view('poll', $data); 
					  }	  

 
			}
 
 
   }
   function event_details($var = 'here'){
		
		$var2 = $this->get_model->get_all_where_single('events', 'url_title', $var, true);
		if($var2){
		$var2 = $var2->id;
		if($this->common_logged_in){
				$user_id_following = $this->session->userdata('id');
				$data['rel'] = $this->attending_model->check_user_att($this->session->userdata('id'),$var2);
		}else{
			$user_id_following = 0;
			$data['rel'] = 3;
		}
		
		if(($this->input->post('upload'))&&($this->common_logged_in)){
		  
			  $config = array(
			  'allowed_types' => 'jpg|jpeg|gif|png',
			  'file_name' => 'img__'.time(),
			  'upload_path' => realpath(APPPATH . '../assets/comments_img/').'/',
			  'max_size' => '10000'
			  );
			  
			 $this->load->library('upload',$config);
			 if($this->upload->do_upload()){
						 $image_data = $this->upload->data();
			
						 $id_of_user = $this->input->post('id_of_user');
						 $id_of_event = $this->input->post('id_of_event');
						 $comment = $this->input->post('comment_val') ;
						 
						 
						 if($image_data['file_name']){
							 
							 $comment .= '<div class="imgInc">
							 <a class="groupComment" href="'.base_url().'assets/comments_img/'.$image_data['file_name'].'" >
							 <img src="'.base_url().'phpThumb/phpThumb.php?src=/assets/comments_img/'.$image_data['file_name'].'&w=485&aoe=1" />																
							 </a></div>
							 ';
						 }
			
						 $this->session->set_userdata('post_comments', TRUE);
						 $this->session->set_userdata('user_imagename', $image_data['file_name']);
						 $this->session->set_userdata('user_comment', addslashes($this->input->post('comment_val')));
						 redirect($_SERVER['REQUEST_URI'], 'refresh');
			 }else{
				 
				         $this->session->set_userdata('something_went_wrong', TRUE);
						 redirect($_SERVER['REQUEST_URI'], 'refresh');
			 }
			
			
		}			
		if($this->session->userdata('post_comments')){
			  
			  $data['post_comments']= TRUE;
			  $data['user_comment'] = $this->session->userdata('user_comment');
			  $data['user_imagename'] = $this->session->userdata('user_imagename');
			  
			  $this->session->unset_userdata('post_comments');
			  $this->session->unset_userdata('user_comment');
			  $this->session->unset_userdata('user_imagename');
		 }	
		if($this->session->userdata('something_went_wrong')){
			  $data['something_went_wrong'] = TRUE;
			  $this->session->unset_userdata('something_went_wrong');
		}
				

        
		$data['badWords'] = $this->comments_model->get_b_words();
		$data['initial_comments_id'] =  $this->comments_model->get_next_num() - 1;
		$data['attendings'] = $this->attending_model->return_attending_data($var2);
		$data['num_attendings'] = $this->attending_model->all_att($var2);
		$data['event_imgs'] = $this->get_model->get_all_where('events_img', 'events_id', $var2);
		$data['event'] = $this->events_model->event_detail($var2);
		$data['average'] = $this->grade_model->event_grade('events_grade',$var2,false,true,$data['event']->start_date,$data['event']->end_date);
		$data['poll1'] = $this->grade_model->event_grade('poll1',$var2,false,true,$data['event']->start_date,$data['event']->end_date);
		$data['poll2'] = $this->grade_model->event_grade('poll2',$var2,false,true,$data['event']->start_date,$data['event']->end_date);

		if($data['event']->is_active_events != 1){
		  redirect(base_url().'events/', 'refresh');
		}
		$data['following'] = ($this->grade_model->check_user_grade($user_id_following, $data['event']->id_events, 'following'))?false:true;
		$data['comments'] = $this->comments_model->return_comment_data($var2,15,0);

		$this->load->library('googlemaps');
		$config['center'] = $data['event']->country .','. $data['event']->city .','. $data['event']->address;
		$config['zoom'] = "16";
		$config['map_width'] = '600px';
		$config['map_height'] = '500px';	
        $config['map_name'] = 'map';

			
		$this->googlemaps->initialize($config);

		
	   
			$marker = array();
			$marker['position'] = $data['event']->country .','. $data['event']->city .','. $data['event']->address;
//            $marker['infowindow_content'] = '<strong>'.$data['event']->title_events.'</strong><br><br><strong>Mood rating:</strong> '.$data['average'].'<br/><strong>Attending:</strong> '.$data['num_attendings'].'<br/>'.word_limiter($data['event']->description_events, 5).' ';
			$marker['icon'] = base_url().'phpThumb/phpThumb.php?src=/assets/evt_logo_img/'.$data['event']->logo_events.'&w=60&h=65&zc=1&aoe=1';
            $marker['visible'] = TRUE;
			$this->googlemaps->add_marker($marker);  
				
        $data['map'] = $this->googlemaps->create_map();	
		$this->wall2all->front_view('event-detail_ajax_ret',$data);
		//$this->wall2all->front_view('event-detail_view',$data);
		}else{
			show_404();
		}
	   
   }
   function test_event_details($var = 'here'){
		
		$var2 = $this->get_model->get_all_where_single('events', 'url_title', $var, true);
		if($var2){
		$var2 = $var2->id;
		if($this->common_logged_in){
				$user_id_following = $this->session->userdata('id');
				$data['rel'] = $this->attending_model->check_user_att($this->session->userdata('id'),$var2);
		}else{
			$user_id_following = 0;
			$data['rel'] = 3;
		}
		
		if(($this->input->post('upload'))&&($this->common_logged_in)){
		  
			  $config = array(
			  'allowed_types' => 'jpg|jpeg|gif|png',
			  'file_name' => 'img__'.time(),
			  'upload_path' => realpath(APPPATH . '../assets/comments_img/').'/',
			  'max_size' => '10000'
			  );
			  
			 $this->load->library('upload',$config);
			 if($this->upload->do_upload()){
						 $image_data = $this->upload->data();
			
						 $id_of_user = $this->input->post('id_of_user');
						 $id_of_event = $this->input->post('id_of_event');
						 $comment = $this->input->post('comment_val') ;
						 
						 
						 if($image_data['file_name']){
							 
							 $comment .= '<div class="imgInc">
							 <a class="groupComment" href="'.base_url().'assets/comments_img/'.$image_data['file_name'].'" >
							 <img src="'.base_url().'phpThumb/phpThumb.php?src=/assets/comments_img/'.$image_data['file_name'].'&w=485&aoe=1" />																
							 </a></div>
							 ';
						 }
			
						 $this->session->set_userdata('post_comments', TRUE);
						 $this->session->set_userdata('user_imagename', $image_data['file_name']);
						 $this->session->set_userdata('user_comment', addslashes($this->input->post('comment_val')));
						 redirect($_SERVER['REQUEST_URI'], 'refresh');
			 }else{
				 
				         $this->session->set_userdata('something_went_wrong', TRUE);
						 redirect($_SERVER['REQUEST_URI'], 'refresh');
			 }
			
			
		}			
		if($this->session->userdata('post_comments')){
			  
			  $data['post_comments']= TRUE;
			  $data['user_comment'] = $this->session->userdata('user_comment');
			  $data['user_imagename'] = $this->session->userdata('user_imagename');
			  
			  $this->session->unset_userdata('post_comments');
			  $this->session->unset_userdata('user_comment');
			  $this->session->unset_userdata('user_imagename');
		 }	
		if($this->session->userdata('something_went_wrong')){
			  $data['something_went_wrong'] = TRUE;
			  $this->session->unset_userdata('something_went_wrong');
		}
				

        
		$data['badWords'] = $this->comments_model->get_b_words();
		$data['initial_comments_id'] =  $this->comments_model->get_next_num() - 1;
		$data['attendings'] = $this->attending_model->return_attending_data($var2);
		$data['num_attendings'] = $this->attending_model->all_att($var2);
		$data['event_imgs'] = $this->get_model->get_all_where('events_img', 'events_id', $var2);
		$data['event'] = $this->events_model->event_detail($var2);
		$data['average'] = $this->grade_model->event_grade('events_grade',$var2,false,true,$data['event']->start_date,$data['event']->end_date);
		$data['poll1'] = $this->grade_model->event_grade('poll1',$var2,false,true,$data['event']->start_date,$data['event']->end_date);
		$data['poll2'] = $this->grade_model->event_grade('poll2',$var2,false,true,$data['event']->start_date,$data['event']->end_date);

		if($data['event']->is_active_events != 1){
		  redirect(base_url().'events/', 'refresh');
		}
		$data['following'] = ($this->grade_model->check_user_grade($user_id_following, $data['event']->id_events, 'following'))?false:true;
		$data['comments'] = $this->comments_model->return_comment_data($var2,15,0);

		$this->load->library('googlemaps');
		$config['center'] = $data['event']->country .','. $data['event']->city .','. $data['event']->address;
		$config['zoom'] = "16";
		$config['map_width'] = '600px';
		$config['map_height'] = '500px';	
        $config['map_name'] = 'map';

			
		$this->googlemaps->initialize($config);

		
	   
			$marker = array();
			$marker['position'] = $data['event']->country .','. $data['event']->city .','. $data['event']->address;
//            $marker['infowindow_content'] = '<strong>'.$data['event']->title_events.'</strong><br><br><strong>Mood rating:</strong> '.$data['average'].'<br/><strong>Attending:</strong> '.$data['num_attendings'].'<br/>'.word_limiter($data['event']->description_events, 5).' ';
			$marker['icon'] = base_url().'phpThumb/phpThumb.php?src=/assets/evt_logo_img/'.$data['event']->logo_events.'&w=60&h=65&zc=1&aoe=1';
            $marker['visible'] = TRUE;
			$this->googlemaps->add_marker($marker);  
				
        $data['map'] = $this->googlemaps->create_map();	
		$this->wall2all->front_view('event-detail_live-posts',$data);
		//$this->wall2all->front_view('event-detail_view',$data);
		}else{
			show_404();
		}
	   
   }
	
	/**
		Implemented Node.js 
	*/
	function events_with_node($var = 'default'){
		
		$var2 = $this->get_model->get_all_where_single('events', 'url_title', $var, true);
		if($var2){
		$var2 = $var2->id;
		if($this->common_logged_in){
				$user_id_following = $this->session->userdata('id');
				$data['rel'] = $this->attending_model->check_user_att($this->session->userdata('id'),$var2);
		}else{
			$user_id_following = 0;
			$data['rel'] = 3;
		}
		
		if(($this->input->post('upload'))&&($this->common_logged_in)){
		  
			  $config = array(
			  'allowed_types' => 'jpg|jpeg|gif|png',
			  'file_name' => 'img__'.time(),
			  'upload_path' => realpath(APPPATH . '../assets/comments_img/').'/',
			  'max_size' => '10000'
			  );
			  
			 $this->load->library('upload',$config);
			 if($this->upload->do_upload()){
						 $image_data = $this->upload->data();
			
						 $id_of_user = $this->input->post('id_of_user');
						 $id_of_event = $this->input->post('id_of_event');
						 $comment = $this->input->post('comment_val') ;
						 
						 
						 if($image_data['file_name']){
							 
							 $comment .= '<div class="imgInc">
							 <a class="groupComment" href="'.base_url().'assets/comments_img/'.$image_data['file_name'].'" >
							 <img src="'.base_url().'phpThumb/phpThumb.php?src=/assets/comments_img/'.$image_data['file_name'].'&w=485&aoe=1" />																
							 </a></div>
							 ';
						 }
			
						 $this->session->set_userdata('post_comments', TRUE);
						 $this->session->set_userdata('user_imagename', $image_data['file_name']);
						 $this->session->set_userdata('user_comment', addslashes($this->input->post('comment_val')));
						 redirect($_SERVER['REQUEST_URI'], 'refresh');
			 }else{
				 
				         $this->session->set_userdata('something_went_wrong', TRUE);
						 redirect($_SERVER['REQUEST_URI'], 'refresh');
			 }
			
			
		}			
		if($this->session->userdata('post_comments')){
			  
			  $data['post_comments']= TRUE;
			  $data['user_comment'] = preg_replace('/\n/', ' ', $this->session->userdata('user_comment')) ;
			  $data['user_imagename'] = $this->session->userdata('user_imagename');
			  
			  $this->session->unset_userdata('post_comments');
			  $this->session->unset_userdata('user_comment');
			  $this->session->unset_userdata('user_imagename');
		 }	
		if($this->session->userdata('something_went_wrong')){
			  $data['something_went_wrong'] = TRUE;
			  $this->session->unset_userdata('something_went_wrong');
		}
				

        
		$data['badWords'] = $this->comments_model->get_b_words();
		$data['initial_comments_id'] =  $this->comments_model->get_next_num() - 1;
		$data['attendings'] = $this->attending_model->return_attending_data($var2);
		$data['num_attendings'] = $this->attending_model->all_att($var2);
		$data['event_imgs'] = $this->get_model->get_all_where('events_img', 'events_id', $var2);
		$data['event'] = $this->events_model->event_detail($var2);
		$data['average'] = $this->grade_model->event_grade('events_grade',$var2,false,true,$data['event']->start_date,$data['event']->end_date);
		$data['poll1'] = $this->grade_model->event_grade('poll1',$var2,false,true,$data['event']->start_date,$data['event']->end_date);
		$data['poll2'] = $this->grade_model->event_grade('poll2',$var2,false,true,$data['event']->start_date,$data['event']->end_date);

		if($data['event']->is_active_events != 1){
		  redirect(base_url().'events/', 'refresh');
		}
		$data['following'] = ($this->grade_model->check_user_grade($user_id_following, $data['event']->id_events, 'following'))?false:true;
		$data['comments'] = $this->comments_model->return_comment_data($var2,15,0);

		$this->load->library('googlemaps');
		$config['center'] = $data['event']->country .','. $data['event']->city .','. $data['event']->address;
		$config['zoom'] = "16";
		$config['map_width'] = '600px';
		$config['map_height'] = '500px';	
        $config['map_name'] = 'map';

			
		$this->googlemaps->initialize($config);

		
	   
			$marker = array();
			$marker['position'] = $data['event']->country .','. $data['event']->city .','. $data['event']->address;
//            $marker['infowindow_content'] = '<strong>'.$data['event']->title_events.'</strong><br><br><strong>Mood rating:</strong> '.$data['average'].'<br/><strong>Attending:</strong> '.$data['num_attendings'].'<br/>'.word_limiter($data['event']->description_events, 5).' ';
			$marker['icon'] = base_url().'phpThumb/phpThumb.php?src=/assets/evt_logo_img/'.$data['event']->logo_events.'&w=60&h=65&zc=1&aoe=1';
            $marker['visible'] = TRUE;
			$this->googlemaps->add_marker($marker);  
				
        $data['map'] = $this->googlemaps->create_map();	
		$this->wall2all->front_view('_event_with_node.php',$data);
		//$this->wall2all->front_view('event-detail_view',$data);
		}else{
			show_404();
		}
	   
   }
 
  private function return_table($table,$var4,$S, $E){
	   					  
						  $startArray = array();
						  $R = $E - $S;
						  $i = 0;
						  while($R>0){
							  if($R>=1800){
								 $startArray[$i]['start_date']= date('m/d/Y H:i',$E-$R);
								 $s_time = $E-$R;
							     $R = $R-1800;
								 /*$startArray[$i]['index']= $R;*/
								 $startArray[$i]['end_date']= date('m/d/Y H:i',$E-$R);
								 $e_time = $E-$R;
								 $startArray[$i]['num_votes'] = $this->grade_model->event_grade($table,$var4,true,false,$s_time,$e_time);
								 $startArray[$i]['average_grade']= $this->grade_model->event_grade($table,$var4,false,true,$s_time,$e_time);								 
							  }elseif(($R<1800)&&($R>0)){
								 $startArray[$i]['start_date']= date('m/d/Y H:i',$E-$R);
								 $s_time = $E-$R;
								 $R = 0;
								 /*$startArray[$i]['index']= $R;*/
								 $startArray[$i]['end_date']= date('m/d/Y H:i',$E-$R);
								 $e_time = $E-$R;
								 $startArray[$i]['num_votes'] = $this->grade_model->event_grade($table,$var4,true,false,$s_time,$e_time);
								 $startArray[$i]['average_grade']= $this->grade_model->event_grade($table,$var4,false,true,$s_time,$e_time);
							  }
							$i++;
						  }
						  return $startArray;

   }
}