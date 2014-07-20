<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Venues extends MY_Controller { 
	
	function __construct()
	{
		parent::__construct();
	}
	function index() {
	}
	function admin_venues($var = false, $var2 = false, $var3 = false) {
	  if($this->venue_admin){
		if(($var !=  'edit')&&($var !=  'insert')&&($var !=  'select')&&($var !=  'categories')&&($var !=  'cities')){
				if($this->session->userdata('successfully')){
				   $data['successfully'] = TRUE;
				   $this->session->unset_userdata('successfully');
			    }
		  		$this->load->library('pagination');
				$config['base_url'] = base_url().'admin/venues/';
				if($this->master_admin){
					$config['total_rows'] = $this->venues_model->all_venues();
				}else{
					/*$event_user = $this->get_model->get_all_where_single('users', 'id', $this->session->userdata('id'));*/
					$config['total_rows'] = $this->venues_model->all_venues($this->session->userdata('id'));
				}
				$config['per_page'] = 15;
				$config['num_links'] = 2;
				$config['uri_segment'] = 3;
				$this->pagination->initialize($config);
		
			
			$data['s_venues'] = TRUE;
			$data['venues_all'] = TRUE;
			
			if($this->master_admin){
               $data['venues_num'] = $this->venues_model->all_venues();
			   $data['venues'] = $this->venues_model->get_venues_users(false,$config['per_page'],$this->uri->segment(3));
			}else{
               $data['venues_num'] = $this->venues_model->all_venues($this->session->userdata('id'));
			   $data['venues'] = $this->venues_model->get_venues_users($this->session->userdata('id'),$config['per_page'],$this->uri->segment(3));
			}			
			
			$data['users'] = $this->get_model->get_all('users');
			$this->wall2all->a_view('venues_panel', $data); 
			
			
		}elseif($var ==  'edit'){
			   
			   
			$data['s_venues'] = TRUE;
			$data['venues_all'] = TRUE;
			   
			   if(isset($_POST['edit_venue_form'])){
				   
			        $this->form_validation->set_rules('place', 'Place', 'required');
                    $this->form_validation->set_rules('title', 'Title', 'required');
					$this->form_validation->set_rules('description', 'Description');
					$this->form_validation->set_rules('country', 'Country', 'required');
					$this->form_validation->set_rules('city', 'City', 'required');
					$this->form_validation->set_rules('address', 'Address', 'required');
					$this->form_validation->set_rules('youtube', 'Youtube');
					$this->form_validation->set_rules('vimeo', 'Vimeo');
					$this->form_validation->set_rules('theme', 'Theme');			
				
				
				if ($this->form_validation->run() == FALSE){
					 $data['cities']= $this->get_model->get_all('cities');
					 $data['venue_imgs'] = $this->get_model->get_all_where('venues_img','venues_id',$var2);
					 $data['venue'] = $this->get_model->get_all_where_single('venues','id',$var2);
					 $this->wall2all->a_view('venue_edit', $data); 
					
				}else{
					$data = $this->input->post();
					$data['is_active'] = 1;	  
					if($this->venues_model->update_venue($data)){
					 $data['cities']= $this->get_model->get_all('cities');
					 $data['updated'] = '->Successfully updated';
					 $data['venue_imgs'] = $this->get_model->get_all_where('venues_img','venues_id',$var2);
					 $data['venue'] = $this->get_model->get_all_where_single('venues','id',$var2);
					 $this->wall2all->a_view('venue_edit', $data); 					
					}
				}
			   
			   }else{
			     $data['cities']= $this->get_model->get_all('cities');
				 $data['venue_imgs'] = $this->get_model->get_all_where('venues_img','venues_id',$var2);
				 $data['venue'] = $this->get_model->get_all_where_single('venues','id',$var2);
				 $this->wall2all->a_view('venue_edit', $data); 				   
			   
			   
			   }
		   }elseif($var ==  'categories') {
				
			  if($this->master_admin){
			   
				   $data['s_venues'] = TRUE;
				   $data['venues_categories'] = TRUE;
					
			  	  if($var2 ==  'delete'){ 
			  
						if($var3 ==  'multi'){
							 
							$data = $this->input->post();
							foreach($data as $key => $id){
								if(stristr($key,'spec_checkbox_')){
								  $this->categories_model->delete_category($id);
								}
							}
							$this->session->set_userdata('successfully', TRUE);
							redirect(base_url().'admin/venues/categories/', 'refresh');
						 
						 }else{
							 $this->categories_model->delete_category($var3);
							 redirect(base_url().'admin/venues/categories/', 'refresh');
						 }
			
				  }else{
						   if(isset($_POST['submit_category_form'])){	
						   
							
							if($this->categories_model->insert_category($this->input->post())){
								
							   $data['successfullyinserted'] = TRUE;
							   $data['categories']= $this->get_model->get_all('categories');
							   $data['num']= $this->get_model->get_all('categories',true);
							   $this->wall2all->a_view('categories_panel',$data);
								
							}
		
						   }else{
							   
								if($this->session->userdata('successfully')){
								   $data['successfully'] = TRUE;
								   $this->session->unset_userdata('successfully');
								}
							   
							   $data['categories']= $this->get_model->get_all('categories');
							   $data['num']= $this->get_model->get_all('categories',true);
							   $this->wall2all->a_view('categories_panel',$data);
							   
						   }
				   }
			  
			  }else{
				 redirect(base_url().'admin/', 'refresh');
			  }	
			  
			  
		   }elseif($var ==  'cities') {
			   
			     if($this->master_admin){
			   
				      $data['s_venues'] = TRUE;
			          $data['venues_cities'] = TRUE;		           
		   
					  if($var2 ==  'delete'){ 
					  
					  
								 if($var3 ==  'multi'){
									 
									$data = $this->input->post();
									foreach($data as $key => $id){
										if(stristr($key,'spec_checkbox_')){
										  $this->categories_model->delete_city($id);
										}
									}
									$this->session->set_userdata('successfully', TRUE);
									redirect(base_url().'admin/venues/cities/', 'refresh');
								 
								 }else{
									 $this->categories_model->delete_city($var3);
									 redirect(base_url().'admin/venues/cities/', 'refresh');
								 }					  
					  
					  
					  
					  
						 $this->categories_model->delete_city($var3);
						 redirect(base_url().'admin/venues/cities/', 'refresh');
					   
					  }else{
						  
						  
						   if(isset($_POST['submit_city_form'])){	
							if($this->categories_model->insert_city($this->input->post())){
							   
							   $data['successfullyinserted'] = TRUE;
							   $data['cities']= $this->get_model->get_all('cities');
							   $data['num']= $this->get_model->get_all('cities',true);
							   $this->wall2all->a_view('cities_panel',$data);

							}
		
						   }else{
							   
								if($this->session->userdata('successfully')){
								   $data['successfully'] = TRUE;
								   $this->session->unset_userdata('successfully');
								}
							   
							   $data['cities']= $this->get_model->get_all('cities');
							   $data['num']= $this->get_model->get_all('cities',true);
							   $this->wall2all->a_view('cities_panel',$data);
							   
						   }
					  }	
					  
				}else{
		           redirect(base_url().'admin/', 'refresh');
	            }		     
		   
		   
		   }elseif($var ==  'insert') {
			   
				$data['s_venues'] = TRUE;
			    $data['venues_new'] = TRUE;
				
				if($this->master_admin){
                   $data['venues_limit'] = 0;
				}else{
                   $data['venues_limit'] = $this->venues_model->all_venues($this->session->userdata('id'));
				}
				
				if(isset($_POST['insert_venue_form'])){	
				
		            $this->form_validation->set_rules('place', 'Place', 'required');
                    $this->form_validation->set_rules('title', 'Title', 'required');
					$this->form_validation->set_rules('description', 'Description');
					$this->form_validation->set_rules('country', 'Country', 'required');
					$this->form_validation->set_rules('city', 'City', 'required');
					$this->form_validation->set_rules('address', 'Address', 'required');
					$this->form_validation->set_rules('youtube', 'Youtube');
					$this->form_validation->set_rules('vimeo', 'Vimeo');
					$this->form_validation->set_rules('theme', 'Theme');
                    
					
					
					if ($this->form_validation->run() == FALSE){
						
					   $id_venue = $this->session->userdata('temporary_venues_id');
					   $data['cities']= $this->get_model->get_all('cities');
					   $data['venue'] = $this->get_model->get_all_where_single('venues','id',$id_venue);
					   $data['venue_imgs'] = $this->get_model->get_all_where('venues_img','venues_id',$id_venue);
					   $this->wall2all->a_view('venue_add', $data);
						
					}else{
					   $data = $this->input->post();
					   $data['is_active'] = 1;
					   $data['id'] = $this->session->userdata('temporary_venues_id');
					   $this->session->unset_userdata('temporary_venues_id');
						if($this->venues_model->update_venue($data)){
						  redirect(base_url().'admin/venues/edit/'.$data['id'], 'refresh');
						}
					}			    
				
				
				}else{
					
					   $this->session->unset_userdata('temporary_venues_id');
					   $id_venue = $this->venues_model->perform_start_up();
					   $this->session->set_userdata('temporary_venues_id', $id_venue);
					   
					   $data['venue'] = $this->get_model->get_all_where_single('venues','id',$id_venue);
					   $data['venue_imgs'] = $this->get_model->get_all_where('venues_img','venues_id',$id_venue);
				       $data['cities']= $this->get_model->get_all('cities');
					   $this->wall2all->a_view('venue_add', $data);
				
				}
			
		   }elseif($var ==  'select'){
			  	
				if($var2 == 'all'){
					redirect(base_url().'admin/venues/', 'refresh');
				}
				
				$this->load->library('pagination');
				$config['base_url'] = 'http://wall2all.cp-dev.com/admin/venues/select/'.$var2;
				$config['total_rows'] = $this->venues_model->all_venues_where_user($var2);
				$config['per_page'] = 15;
				$config['num_links'] = 2;
				$config['uri_segment'] = 5;
				$this->pagination->initialize($config);		 
		   
		   
			$data['s_venues'] = TRUE;
			$data['venues_all'] = TRUE;
					   
		    $data['selected_user']= $var2;
		   	$data['venues_num'] = $this->venues_model->all_venues_where_user($var2);
			$data['venues'] = $this->venues_model->get_venues_users($var2,$config['per_page'],$this->uri->segment(5));
			$data['users'] = $this->get_model->get_all('users');
			$this->wall2all->a_view('venues_panel', $data); 
		
		 }
		
	  }else{
		 redirect(base_url().'admin/', 'refresh');
	  }		
	}
	function add_venue() {
	  if($this->venue_admin){
		  
		$data['next_id'] = $this->venues_model->get_auto_increment_val();
		   if(isset($_POST['add_venue_form'])){	
		            $this->form_validation->set_rules('place', 'Place', 'required');
                    $this->form_validation->set_rules('title', 'Title', 'required');
					$this->form_validation->set_rules('description', 'Description');
					$this->form_validation->set_rules('country', 'Country', 'required');
					$this->form_validation->set_rules('city', 'City', 'required');
					$this->form_validation->set_rules('address', 'Address', 'required');
					$this->form_validation->set_rules('youtube', 'Youtube');
					$this->form_validation->set_rules('vimeo', 'Vimeo');
					$this->form_validation->set_rules('theme', 'Theme');	
					if ($this->form_validation->run() == FALSE){
						$data['venue_imgs'] = $this->get_model->get_all_where('venues_img','venues_id',$data['next_id']);
						$this->wall2all->front_view('add-venue_view',$data);
					}else{
					   $data = $this->input->post();
					   $data['is_active'] = 1;
						$id = $this->venues_model->insert_venue($data);
						  redirect(base_url().'control-panel/my-venues/edit/'.$id, 'refresh');
					}
		
		
			}else{
							
				$this->wall2all->front_view('add-venue_view',$data);
			}
	
	
	
	
	
	  }else{
		  redirect(base_url(), 'refresh');
	  }
	
	
	}
	function personal_venues($var1 = false, $var2 = false) {
		if($this->venue_admin){
			
			if($var1 ==  false){
				
				$data['venues'] = $this->venues_model->get_venues_users($this->session->userdata('id'));
				$this->wall2all->front_view('user_venues_view', $data); 
				
				
			}else{
			
			if(isset($_POST['edit_venue_form'])){	
			
			        $this->form_validation->set_rules('place', 'Place', 'required');
                    $this->form_validation->set_rules('title', 'Title', 'required');
					$this->form_validation->set_rules('description', 'Description');
					$this->form_validation->set_rules('country', 'Country', 'required');
					$this->form_validation->set_rules('city', 'City', 'required');
					$this->form_validation->set_rules('address', 'Address', 'required');
					$this->form_validation->set_rules('youtube', 'Youtube');
					$this->form_validation->set_rules('vimeo', 'Vimeo');
					$this->form_validation->set_rules('theme', 'Theme');	
					
					if ($this->form_validation->run() == FALSE){
						$data['venue_imgs'] = $this->get_model->get_all_where('venues_img','venues_id',$var2);
						$data['venue'] = $this->get_model->get_all_where_single('venues','id',$var2);	
						$this->wall2all->front_view('edit-venue_view', $data); 
					}else{
						$data = $this->input->post();
					    $data['is_active'] = 1;
					    if($this->venues_model->update_venue($data)){
							
							    $data['updated'] = 'Successfully updated';
								$data['venues'] = $this->venues_model->get_venues_users($this->session->userdata('id'));
								$this->wall2all->front_view('user_venues_view', $data); 
					    
						}
					}
							
			
			}else{
					    $data['venue_imgs'] = $this->get_model->get_all_where('venues_img','venues_id',$var2);
						$data['venue'] = $this->get_model->get_all_where_single('venues','id',$var2);	
						$this->wall2all->front_view('edit-venue_view', $data); 
			}
			
			}
		}else{
		  redirect(base_url(), 'refresh');
		}	
	}
	function all_venues($var1 = 'default', $var2 = false, $var3 = false) {
		
		if($var1 != 'detail'){
			
			
			$this->venues_model->init_venues_with_events();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'venues/';
			$config['total_rows'] = $this->venues_model->num_venues_with_events();
			$config['per_page'] = 9;
			$config['num_links'] = 2;
			$config['uri_segment'] = 2;
			$this->pagination->initialize($config);
			
		  
		  $data['num_venues'] = $this->venues_model->num_venues_with_events();
		  $data['images'] = $this->get_model->get_all('venues_img');
		  $data['events'] = $this->get_model->get_all('events');
		  $data['venues'] = $this->venues_model->venues_with_events($config['per_page'], $this->uri->segment(2));
		  $this->wall2all->front_view('all_venues_view',$data);			

			
			
		}else if($var1 == 'detail') {
			$data['venue'] = $this->get_model->get_all_where_single('venues','id',$var2);
			
			$this->load->library('googlemaps');
			$config['center'] = $data['venue']->country .','. $data['venue']->city .','. $data['venue']->address;


			$config['zoom'] = "16";
			$config['map_width'] = '600px';
			$config['map_height'] = '500px';	
			$config['map_name'] = 'map';		
			$this->googlemaps->initialize($config);
			
			$marker = array();
			$marker['position'] = $data['venue']->country .','. $data['venue']->city .','. $data['venue']->address;
/*          $marker['infowindow_content'] = '<strong>'.$data['event']->title.'</strong><br><br><strong>Mood rating:</strong> '.$data['average'].'%<br/><strong>Attending:</strong> '.$data['num_attendings'].'<br/>'.word_limiter($data['event']->description, 10).'';*/
			$marker['icon'] = base_url().'phpThumb/phpThumb.php?src=/assets/venues_img/'.$data['venue']->logo.'&w=60&h=65&zc=1&aoe=1';
            $marker['visible'] = TRUE;
			$this->googlemaps->add_marker($marker);  			
			
			
			
			
			$data['map'] = $this->googlemaps->create_map();
			$data['venue_imgs'] = $this->get_model->get_all_where('venues_img', 'venues_id', $var2);
			$data['upcoming_events'] = $this->events_model->venue_upcoming_events($var2);
			$this->wall2all->front_view('venue-detail_view',$data);
		}
		
		
		
	}
 	function venue_delete($id, $redirect_front = false) {
	  
		if($this->venue_admin){
			
    		  if($this->venues_model->delete_venue($id)){
				  if($redirect_front){
					 redirect(base_url().'control-panel/my-venues/', 'refresh');
				  }else{
                     redirect(base_url().'admin/venues/', 'refresh');
				  }
				}       
				 
				 
		}else{
		  redirect(base_url().'admin/', 'refresh');
		}	
	}
}