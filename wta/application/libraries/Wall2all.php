<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wall2all
{
	private $CI;
	
	function __construct()
    {
		/*parse_str( $_SERVER['QUERY_STRING'], $_REQUEST );*/
        $this->CI =& get_instance();
		
		/*$this->CI->config->load("facebook",TRUE);
        $config = $this->CI->config->item('facebook');
        $this->CI->load->library('Facebook', $config);*/
	}
	
	function admin_view($page, $data = NULL)
	{
//	  $data['user_data'] = $this->CI->get_model->get_all_where_single('users' ,'id', $this->CI->session->userdata('id'));
	  $data['username'] = $this->CI->session->userdata('username');
	  $this->CI->load->view('admin/admin_nav_view', $data); 
      $this->CI->load->view('admin/'.$page, $data); 
	}
	
	
	function a_view($page, $data = NULL)
	{
	  $data['username'] = $this->CI->session->userdata('username');
	  $this->CI->load->view('admin/_common/html-top_view', $data); 
	  $this->CI->load->view('admin/_common/nav_view', $data);
      $this->CI->load->view('admin/'.$page, $data); 
	  $this->CI->load->view('admin/_common/footer_view', $data);
	}
	
	
	
	function front_view($page, $data = NULL)
	{

	  	$data['selected_city']= (isset($data['selected_city']))?$data['selected_city']:'';
		$data['selected_category']= (isset($data['selected_category']))?$data['selected_category']:'';
		$data['selected_event']= (isset($data['selected_event']))?$data['selected_event']:'';
		$data['selected_venue']= (isset($data['selected_venue']))?$data['selected_venue']:'';
		$data['selected_dateFrom']= (isset($data['selected_dateFrom']))?$data['selected_dateFrom']:'';
		$data['selected_dateTo']= (isset($data['selected_dateTo']))?$data['selected_dateTo']:'';	
		
	  /*$data['cities']= $this->CI->home_model->VenuesWhereEvents();*/
	  $data['categories']= $this->CI->get_model->get_all('categories');
	  $data['cities']= $this->CI->events_model->city_with_events();
	  $data['logged_in'] = ($this->CI->session->userdata('id'))?TRUE:FALSE;
	  $data['face_logged_in'] = ($this->CI->session->userdata('facebook_id'))?TRUE:FALSE;
	  $data['twit_logged_in'] = ($this->CI->session->userdata('twitter_id'))?TRUE:FALSE;
      $data['ava_img']= $this->CI->session->userdata('img');
	  $data['username'] = $this->CI->session->userdata('username');
	  if($this->CI->session->userdata('id')){
	  	 $data['user_id'] = $this->CI->session->userdata('id');
	  /*}elseif(($data['logged_in'] == false)&&($data['face_logged_in'])){
		  $data['user_id'] = $this->CI->session->userdata('id');
	  }elseif(($data['logged_in'] == false)&&($data['twit_logged_in'])){
		  $data['user_id'] = $this->CI->session->userdata('id_twitter_user');*/	  
	  }else{
		  $data['user_id'] = 0;
	  }
	  $data['user_level'] = $this->CI->session->userdata('is_admin');
	  
	  $this->CI->load->view('front/_common/html_top_view', $data);
	  $this->CI->load->view('front/_common/top_nav_view', $data);
      $this->CI->load->view('front/'.$page, $data); 
	  $this->CI->load->view('front/_common/footer_view', $data);
	  
	}
	
	function central_view($page, $data = NULL)
	{

	}
	
	function left_side($data)
	{
	}
	
	
	function current_nav() {
//		$this->CI->load->helper('url');
		return $this->CI->uri->segment(1);
	}
	
	
	
	function login($email = '', $password = '')
	{
		// Load password hash library


		if(empty($email) OR empty($password))
		{
			return FALSE;
		}

		//Check if already logged in
		if($this->CI->session->userdata('email') == $email)
		{
			return TRUE;
		}


        $this->CI->db->where('email', $email);
		$this->CI->db->where('block_users', 1);
		$query = $this->CI->db->get_where('users');

		if ($query->num_rows() > 0)
		{
			$user_data = $query->row();

			if(md5($password) != $user_data->password)
			{
				return FALSE;
			}
			
			
			if ($this->CI->session->userdata('previous_url') !== FALSE) {
				$redirect_url = $this->CI->session->userdata('previous_url');
			}else{
				$redirect_url = base_url();
			}	

			//Destroy old session
			$this->CI->session->sess_destroy();

			//Create a fresh, brand new session
			$this->CI->session->sess_create();

			$this->CI->db->simple_query('UPDATE users SET last_login = '.time().' WHERE id = ' . $user_data->id);

			//Set session data
			unset($user_data->password);

			$this->CI->session->set_userdata($user_data);
            $this->CI->session->set_userdata('previous_url', $redirect_url);
			return TRUE;
			
		}
		else
		{
			return FALSE;
		}

	}	
	function login_front($email = '', $password = '')
	{
		// Load password hash library


		if(empty($email) OR empty($password))
		{
			return 0;
		}

        $this->CI->db->where('email', $email);
		$query = $this->CI->db->get_where('users');

		if ($query->num_rows() > 0)
		{
			$user_data = $query->row();

			if(md5($password) != $user_data->password)
			{
				return 0;
			}
			if($query->row()->block_users != 1){
				return 2;
			}
			$this->CI->session->sess_destroy();

			$this->CI->session->sess_create();

			$this->CI->db->simple_query('UPDATE users SET last_login = NOW() WHERE id = ' . $user_data->id);

			unset($user_data->password);

			$this->CI->session->set_userdata($user_data);

			return 1;
			
		}
		else
		{
			return 0;
		}

	}	
	
	function logout() {

		$this->CI->session->sess_destroy();
	}	
	function deliver_json($data = NULL)
    {
		$this->CI->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
    }	
	function send_email($body, $subject, $to, $bcc = FALSE)
	{
		// Send Email
		$this->CI->load->library('email');
		$this->CI->email->clear(TRUE); // Set email vars to NULL and clear attachments.
		$this->CI->email->initialize(array('charset' => 'UTF-8', 'mailtype' => 'html'));
		$this->CI->email->from('admin@wall2all.com', 'Wall');
		$this->CI->email->reply_to('hmisko@hotmail.com', 'Wall');
		$this->CI->email->to($to);

		if ($bcc)
		{
			$this->CI->email->bcc($bcc);
		}

		$this->CI->email->subject($subject);
		$this->CI->email->message($body);
		$this->CI->email->send();
	}	
	
}