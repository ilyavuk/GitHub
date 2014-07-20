<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comments extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
	}
	function index() {
  
	}
	
	function admin_comments($var = false, $var2 = false, $var3 = false, $var4 = false) {
		
	  if($this->master_admin){
		  
		if($var == 'edit'){
			

			if(isset($_POST['submit_comment_form'])){
				
				$data = $this->input->post();
				$data['is_active'] = (isset($data['is_active']))?$data['is_active']:0;
				
				if($this->comments_model->update_comment($data)){
					$data['comment'] = $this->get_model->get_all_where_single('comments','id',$var2);
					$this->wall2all->admin_view('edit_comments_view', $data);
				}
				
			}else{
			  
			  $data['comment'] = $this->get_model->get_all_where_single('comments','id',$var2);
			  $this->wall2all->admin_view('edit_comments_view', $data);
			} 		
		
		
		}elseif($var == 'select'){
			
			
			$data['comments_s'] = TRUE;
			$data['comments_all'] = TRUE;
		    $data['selected_event']= $var3;
			$this->load->library('pagination');
			 if($var2 == 'all'){
				if(($var3 == 'all')||($var3 == false)){
				
						$config['base_url'] = base_url().'admin/comments/select/'.$var2.'/'.$var3;
						$config['total_rows'] = $this->comments_model->all_comments();
						$config['per_page'] = 15;
						$config['num_links'] = 2;
						$config['uri_segment'] = 6;
						$this->pagination->initialize($config);	
					
					
					 $data['comments_num'] = $this->comments_model->all_comments();
					 $data['comments'] = $this->comments_model->get_comments_evts_users(false,false,$config['per_page'], $this->uri->segment(6));
					 $data['selected_user']='';
				}else{
					
					
					    $config['base_url'] = base_url().'admin/comments/select/'.$var2.'/'.$var3;
						$config['total_rows'] = $this->comments_model->all_comments_where_event($var3);
						$config['per_page'] = 100;
						$config['num_links'] = 2;
						$config['uri_segment'] = 6;
						$this->pagination->initialize($config);					
					
					$data['comments_num'] = $this->comments_model->all_comments_where_event($var3);
					$data['comments'] = $this->comments_model->get_comments_evts_users(false, $var3,$config['per_page'], $this->uri->segment(6));
					$data['selected_event'] = $var3;
				}
			 
			 }else{
				if(($var3 == 'all')||($var3 == false)){
					
					    $config['base_url'] = base_url().'admin/comments/select/'.$var2.'/'.$var3;
						$config['total_rows'] = $this->comments_model->all_comments_where_user($var2);
						$config['per_page'] = 15;
						$config['num_links'] = 2;
						$config['uri_segment'] = 6;
						$this->pagination->initialize($config);						
					
					
					$data['comments_num'] = $this->comments_model->all_comments_where_user($var2);
					$data['comments'] = $this->comments_model->get_comments_evts_users($var2, false,$config['per_page'], $this->uri->segment(6));
					$data['selected_user']= $var2;
				}else{
					
					    $config['base_url'] = base_url().'admin/comments/select/'.$var2.'/'.$var3;
						$config['total_rows'] = $this->comments_model->all_comments_where_user_event($var2, $var3);
						$config['per_page'] = 15;
						$config['num_links'] = 2;
						$config['uri_segment'] = 6;
						$this->pagination->initialize($config);						
					
					$data['comments_num'] = $this->comments_model->all_comments_where_user_event($var2, $var3);
					$data['comments'] = $this->comments_model->get_comments_evts_users($var2, $var3,$config['per_page'], $this->uri->segment(6));
					$data['selected_user']= $var2;
					$data['selected_event'] = $var3;
				}
			 }
			 
			$data['users'] = $this->get_model->get_all('users');
			$data['events'] = $this->get_model->get_all('events',false,true); 
			$this->wall2all->a_view('all_comments', $data); 
		
		}elseif($var == 'reported-comments'){
			
				$data['comments_s'] = TRUE;
				$data['comments_reported'] = TRUE;			
			
			if($var2 == 'select'){
				$data['selected_user']= $var3;
				$data['selected_event']= $var4;
				$this->load->library('pagination');
				$this->comments_model->init_abused_comments($var3, $var4);
							$config['base_url'] = base_url().'admin/comments/reported-comments/select/'.$var3.'/'.$var4;;
							$config['total_rows'] = $this->comments_model->num_spec_comments();
							$config['per_page'] = 15;
							$config['num_links'] = 2;
							$config['uri_segment'] = 7;
							$this->pagination->initialize($config);	
				$data['comments_num'] = $this->comments_model->num_spec_comments();
				$data['users'] = $this->get_model->get_all('users');
				$data['events'] = $this->get_model->get_all('events',false,true);
				$data['comments'] = $this->comments_model->spec_comments_limit($config['per_page'], $this->uri->segment(7));
				$this->wall2all->a_view('reported_comments', $data);

				
			}else{
				
				if($this->session->userdata('successfully')){
				   $data['successfully'] = TRUE;
				   $this->session->unset_userdata('successfully');
			    }
				
			$this->load->library('pagination');
			$this->comments_model->init_abused_comments();
					    $config['base_url'] = base_url().'admin/comments/reported-comments/';
						$config['total_rows'] = $this->comments_model->num_spec_comments();
						$config['per_page'] = 15;
						$config['num_links'] = 2;
						$config['uri_segment'] = 4;
						$this->pagination->initialize($config);	
			$data['comments_num'] = $this->comments_model->num_spec_comments();
			$data['users'] = $this->get_model->get_all('users');
			$data['events'] = $this->get_model->get_all('events',false,true); 
			$data['comments'] = $this->comments_model->spec_comments_limit($config['per_page'], $this->uri->segment(4));
			$this->wall2all->a_view('reported_comments', $data);
			}
		
		}elseif($var == 'block-bad-words'){
			
			$data['update_message'] = '';
			$data['comments_s'] = TRUE;
			$data['comments_badwords'] = TRUE;
			
			if(isset($_POST['bad_words_form'])){
				if($this->comments_model->update_b_words($this->input->post('bad_words'))){
					$data['successfully'] = TRUE;
					$data['bad_words'] = $this->comments_model->get_b_words();
			        $this->wall2all->a_view('bad_words', $data);
				}else{
					$data['update_message'] = '->Something went wrong, please try again!';
					$data['bad_words'] = $this->comments_model->get_b_words();
			   		$this->wall2all->a_view('bad_words', $data);
				}
				
				
			}else{
			   $data['bad_words'] = $this->comments_model->get_b_words();
			   $this->wall2all->a_view('bad_words', $data);
			}
		
		}elseif($var == 'liked-comments'){
			
				$data['comments_s'] = TRUE;
				$data['comments_liked'] = TRUE;
				
			if($var2 == 'select'){
				$data['selected_user']= $var3;
				$data['selected_event']= $var4;
				$this->load->library('pagination');
				$this->comments_model->init_liked_comments($var3, $var4,true);
							$config['base_url'] = base_url().'admin/comments/liked-comments/select/'.$var3.'/'.$var4;;
							$config['total_rows'] = $this->comments_model->num_spec_comments(true);
							$config['per_page'] = 15;
							$config['num_links'] = 2;
							$config['uri_segment'] = 7;
							$this->pagination->initialize($config);	
				$data['comments_num'] = $this->comments_model->num_spec_comments(true);
				$data['users'] = $this->get_model->get_all('users');
				$data['events'] = $this->get_model->get_all('events',false,true); 
				$data['comments'] = $this->comments_model->spec_comments_limit($config['per_page'], $this->uri->segment(7),true);
				$this->wall2all->a_view('liked_comments', $data);

				
			}else{
				
				$this->load->library('pagination');
				$this->comments_model->init_liked_comments(false,false,true);
							$config['base_url'] = base_url().'admin/comments/liked-comments/';
							$config['total_rows'] = $this->comments_model->num_spec_comments(true);
							$config['per_page'] = 15;
							$config['num_links'] = 2;
							$config['uri_segment'] = 4;
							$this->pagination->initialize($config);	
				
				if($this->session->userdata('successfully')){
				   $data['successfully'] = TRUE;
				   $this->session->unset_userdata('successfully');
			    }			
				$data['comments_num'] = $this->comments_model->num_spec_comments(true);
				$data['users'] = $this->get_model->get_all('users');
				$data['events'] = $this->get_model->get_all('events',false,true); 
				$data['comments'] = $this->comments_model->spec_comments_limit($config['per_page'], $this->uri->segment(4),true);
				$this->wall2all->a_view('liked_comments', $data);
				
			}
		
		}else{
		
				$data['comments_s'] = TRUE;
				$data['comments_all'] = TRUE;
		
		  		$this->load->library('pagination');
				$config['base_url'] = base_url().'admin/comments/';
				$config['total_rows'] = $this->comments_model->all_comments();
				$config['per_page'] = 15;
				$config['num_links'] = 2;
				$config['uri_segment'] = 3;
				$this->pagination->initialize($config);		
				
				if($this->session->userdata('successfully')){
				   $data['successfully'] = TRUE;
				   $this->session->unset_userdata('successfully');
			    }		
		
		    $data['comments_num'] = $this->comments_model->all_comments();
			$data['comments'] = $this->comments_model->get_comments_evts_users(false,false,$config['per_page'], $this->uri->segment(3));
			$data['users'] = $this->get_model->get_all('users');
			$data['events'] = $this->get_model->get_all('events',false,true);
			$this->wall2all->a_view('all_comments', $data);   
		  
		
		}
		
		
		
		
		
		
		
		
	  }else{
		  redirect(base_url().'admin/', 'refresh');
	  }	
		
	}
	function admin_comments_edit($id) {
	  
		if($this->master_admin){
			
			
			if(isset($_POST['submit_comment_form'])){
				
				$data = $this->input->post();
				$data['is_active'] = (isset($data['is_active']))?$data['is_active']:0;
				
				if($this->comments_model->update_comment($data)){
					$data['comment'] = $this->get_model->get_all_where_single('comments','id',$id);
					$this->wall2all->admin_view('edit_comments_view', $data);
				}
				
			}else{
			  
			  $data['comment'] = $this->get_model->get_all_where_single('comments','id',$id);
			  $this->wall2all->admin_view('edit_comments_view', $data);
			}
				 
				 
		}else{
		  redirect(base_url().'admin/', 'refresh');
		}	
		
	}
	
	function admin_comments_delete($id, $reported = false, $segment = false) {
	 
		if($this->master_admin){
			
    		  if($this->comments_model->delete_comment($id)){
				  if($reported == 1){
					redirect(base_url().'admin/comments/reported-comments/'.$segment, 'refresh');
				  }elseif($reported == 2){
					redirect(base_url().'admin/comments/liked-comments/'.$segment, 'refresh');
				  }else{
                    redirect(base_url().'admin/comments/', 'refresh');
				  }
				}       
				 
				 
		}else{
		  redirect(base_url().'admin/', 'refresh');
		}	
	}
	private function filter_abused_comments($var3, $var4) {

	}
	function test() {
		echo $data['comments_num'] = $this->comments_model->all_comments_where_event(1);;
	}
}