<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();

	}
	
	function upload_admin_image(){
		
		$property_id = $this->input->get('property_id');
		$g = $this->input->get();
		$this->load->library('ajax_uploader');

		$result = $this->ajax_uploader->handleUpload(realpath(APPPATH . '../assets/users_img/').'/','img_'.$property_id, TRUE);
		
		if($result['success'])
		{

			$data = array(
               'img' => $result['filename'].'.'.$result['ext'],
               'img_ext' => $result['ext'],
            );
			$this->db->where('id', $property_id);
            $this->db->update('users', $data); 
		}
		
		$this->output
			->set_content_type('text/html')
			->set_output(htmlspecialchars(json_encode($result), ENT_NOQUOTES));
	}
	
	function upload_eventBanner_image(){
		
		$property_id = $this->input->get('property_id');
		$g = $this->input->get();
		$this->load->library('ajax_uploader');

		$result = $this->ajax_uploader->handleUpload(realpath(APPPATH . '../assets/banners/').'/','ebanner_'.$property_id, TRUE);
		
		if($result['success'])
		{

			$data = array(
               'banner_img' => $result['filename'].'.'.$result['ext']
            );
			$this->db->where('id', $property_id);
            $this->db->update('events', $data); 
		}
		$result['img'] = $result['filename'].'.'.$result['ext'];
		$this->output
			->set_content_type('text/html')
			->set_output(htmlspecialchars(json_encode($result), ENT_NOQUOTES));
	}
	
	function upload_background_image(){
		
		$property_id = $this->input->get('property_id');
		$descType = $this->input->get('descType');
		$g = $this->input->get();
		$this->load->library('ajax_uploader');
		

		$result = $this->ajax_uploader->handleUpload(realpath(APPPATH . '../assets/background/').'/','background_'.$descType.$property_id, TRUE);
		
		if($result['success'])
		{

			$data = array(
               'background_image'=> $result['filename'].'.'.$result['ext']
            );
			$this->db->where('id', $property_id);
            $this->db->update($descType, $data); 
		}
		$result['img'] = $result['filename'].'.'.$result['ext'];
		$this->output
			->set_content_type('text/html')
			->set_output(htmlspecialchars(json_encode($result), ENT_NOQUOTES)); 
	
	
	}
	
	function upload_venueBanner_image(){
		
		$property_id = $this->input->get('property_id');
		$img_id = $this->input->get('img_id');
		$g = $this->input->get();
		$this->load->library('ajax_uploader');

		$result = $this->ajax_uploader->handleUpload(realpath(APPPATH . '../assets/banners/').'/','vbanner_'.$img_id.'-'.$property_id, TRUE);
		
		if($result['success'])
		{

			$data = array(
               'banner_img'.$img_id => $result['filename'].'.'.$result['ext']
            );
			$this->db->where('id', $property_id);
            $this->db->update('venues', $data); 
		}
		$result['img'] = $result['filename'].'.'.$result['ext'];
		$this->output
			->set_content_type('text/html')
			->set_output(htmlspecialchars(json_encode($result), ENT_NOQUOTES));
	}	

	function upload_event_image(){
		
		$property_id = $this->input->get('property_id');
		$g = $this->input->get();
		$this->load->library('ajax_uploader');

		$result = $this->ajax_uploader->handleUpload(realpath(APPPATH . '../assets/evt_logo_img/').'/','logo_'.$this->get_model->img_next_id());
		
		if($result['success'])
		{

			$data = array(
			   'events_id' => $property_id,
               'img_name' => $result['filename'].'.'.$result['ext'],

            );
			$this->db->insert('events_img', $data);

		}
		
		$this->output
			->set_content_type('text/html')
			->set_output(htmlspecialchars(json_encode($result), ENT_NOQUOTES));
	}
	function upload_venue_image(){
		
		$property_id = $this->input->get('property_id');
		$g = $this->input->get();
		$this->load->library('ajax_uploader');

		$result = $this->ajax_uploader->handleUpload(realpath(APPPATH . '../assets/venues_img/').'/','img_'.time());
		
		if($result['success'])
		{

			$data = array(
			   'venues_id' => $property_id,
               'img_name' => $result['filename'].'.'.$result['ext'],

            );
			$this->db->insert('venues_img', $data);

		}
		
		$this->output
			->set_content_type('text/html')
			->set_output(htmlspecialchars(json_encode($result), ENT_NOQUOTES));
		
	}
	function upload_comment_image() {
		
		if($this->input->get('param')==1){
		  echo '<html><head><script type="text/javascript">document.domain = "wall2allnew.cp-dev.com";</script></head><body></body></html> ';
		}
		$g = $this->input->get();
		$this->load->library('ajax_uploader');

		$result = $this->ajax_uploader->handleUpload(realpath(APPPATH . '../assets/comments_img/').'/','img_'.time());

		$this->output
			->set_content_type('text/html')
			->set_output(htmlspecialchars(json_encode($result), ENT_NOQUOTES));
			
	}
	function get_personal_image(){
		$property_id = $this->input->post('property_id');
		$data['image'] = $this->get_model->return_image($property_id );
		/*$this->wall2all->deliver_json($data);*/
		$this->output
			->set_content_type('text/html')
			->set_output(htmlspecialchars(json_encode($data), ENT_NOQUOTES));
	}
	function get_images(){
		$property_id = $this->input->post('property_id');
		$images = $this->get_model->return_images($property_id );
		$this->wall2all->deliver_json($images);
	}
	function get_venues_images(){
		$property_id = $this->input->post('property_id');
		$images = $this->venues_model->return_venues_imgs($property_id );
		$this->wall2all->deliver_json($images);
	}
	function insert_comments() {
		$comment = urldecode($this->input->post('comment'));
		$events_id = $this->input->post('events_id');
		$user_id = $this->input->post('user_id');
		/*if($this->comments_model->insert_comment($user_id,$events_id, $comment)){
			$data['result']= 1;
		}else{
			$data['result']= 0;
		}*/
		$data['inserted_id'] = $this->comments_model->insert_comment($user_id,$events_id, $comment);
		/*$data['comments'] = $this->comments_model->return_comment_data($events_id,3,0);
		$data['pag_links'] = $this->get_page_links($events_id,0);*/
		$this->wall2all->deliver_json($data);
	}
	function delete_background(){
		$id = $this->input->post('id');
		$type = $this->input->post('type');
		$data = array(
               'background_image' => ''
            );
		$this->db->where('id', $id);
		if($this->db->update($type, $data)){
			$data = 1;
		}
		$this->wall2all->deliver_json($data);
	}
	function delete_events_banner(){
		$id = $this->input->post('id');
		$data = array(
               'banner_img'=> '',
			   'url_bannerE' => ''
            );
		$this->db->where('id', $id);
		if($this->db->update('events', $data)){
			$data = 1;
		}
		$this->wall2all->deliver_json($data);
	}
	function delete_venues_banner(){
		$id = $this->input->post('id');
		$Bid = $this->input->post('Bid');
		$data = array(
               'banner_img'.$Bid => '',
			   'url_banner'.$Bid => ''
            );
		$this->db->where('id', $id);
		if($this->db->update('venues', $data)){
			$data = 1;
		}
		$this->wall2all->deliver_json($data);
	}
	function delete_images() {
		$img_id = $this->input->post('img_id');
		$data['result']=$this->imgs_model->delete_event_img($img_id);
		$this->wall2all->deliver_json($data);
		
	}
	function delete_venues_images() {
		$img_id = $this->input->post('img_id');
		$data['result']=$this->venues_model->delete_venue_img($img_id);
		$this->wall2all->deliver_json($data);
		
	}
	function change_title() {
		$img_id = $this->input->post('id');
		$title = $this->input->post('title');
		$data['result'] = $this->imgs_model->change_event_img_title($img_id, $title);
		$this->wall2all->deliver_json($data);
	}
	function change_venue_title() {
		$img_id = $this->input->post('id');
		$title = $this->input->post('title');
		$data['result'] = $this->venues_model->change_venue_img_title($img_id, $title);
		$this->wall2all->deliver_json($data);
	}
	function change_textarea() {
		$img_id = $this->input->post('id');
		$textarea = $this->input->post('textarea');
		$data['result'] = $this->imgs_model->change_event_img_textarea($img_id, $textarea);
		$this->wall2all->deliver_json($data);
	}
	function change_venue_textarea() {
		$img_id = $this->input->post('id');
		$textarea = $this->input->post('textarea');
		$data['result'] = $this->venues_model->change_venue_img_textarea($img_id, $textarea);
		$this->wall2all->deliver_json($data);
	}
	function add_logo() {
		$logo = $this->input->post('logo');
		$data['result'] = $this->imgs_model->change_event_img_textarea($img_id, $textarea);
		$this->wall2all->deliver_json($data);
	}
	 
	function log_in() {
		
		$status_log = $this->wall2all->login_front($this->input->post('username'), $this->input->post('password'));
		
		if($status_log == 1){
			 $data['result'] = 1;
		}elseif($status_log == 2){
			 $data['result'] = 2;
		}else{
			 $data['result'] = 0;
		}	
		$this->wall2all->deliver_json($data);			
	}
	function rate_event() {
		$grade = $this->input->post('grade');
		$events_id = $this->input->post('events_id');
		$user_id = $this->input->post('user_id');
		if($this->grade_model->check_user_grade($user_id, $events_id, 'events_grade')){
			
		   if($this->grade_model->insert_grade($user_id,$events_id,$grade,'events_grade')){
			   $data['result'] = 1;
			   $data['average'] = $this->grade_model->calculate_average_grade($events_id, 'events_grade');
		   }
		   
		}else{
			$data['result'] = 3;
		}
		$this->wall2all->deliver_json($data);
	}
	function following() {
		$events_id = $this->input->post('events_id');
		$user_id = $this->input->post('user_id');
		if($this->grade_model->check_user_grade($user_id, $events_id, 'following')){
			if($this->grade_model->insert_following($user_id,$events_id,'following')){
			   $data['result'] = 1;
		   }else{
			   $data['result'] = 0;
		   }
		}else{
			   $data['result'] = 0;
		}
		$this->wall2all->deliver_json($data);
	}
	function poll() {
		$grade = $this->input->post('grade');
		$events_id = $this->input->post('events_id');
		$user_id = $this->input->post('user_id');
        $distinguish = $this->input->post('distinguish');
			
		   if($distinguish == 1){
			   if($this->grade_model->insert_grade($user_id,$events_id,$grade,'poll1')){
				   $data['result'] = 1;
				   /*$data['average'] = $this->grade_model->calculate_average_grade($events_id,'poll1');*/
				   $data['event'] = $this->events_model->event_detail($events_id);
				   $data['average'] = $this->grade_model->event_grade('poll1',$events_id,false,true,$data['event']->start_date,$data['event']->end_date);
				   
			   }else{
				   $data['result'] = 0;
			   }
		   }elseif($distinguish == 2){
			   if($this->grade_model->insert_grade($user_id,$events_id,$grade,'poll2')){
				   $data['result'] = 1;
				   $data['event'] = $this->events_model->event_detail($events_id);
				   $data['average'] = $this->grade_model->event_grade('poll2',$events_id,false,true,$data['event']->start_date,$data['event']->end_date);

			   }else{
				   $data['result'] = 0;
			   }			   
		   }else{
			   if($this->grade_model->insert_grade($user_id,$events_id,$grade,'events_grade')){
				   $data['result'] = 1;
				   $data['event'] = $this->events_model->event_detail($events_id);
				   $data['average'] = $this->grade_model->event_grade('events_grade',$events_id,false,true,$data['event']->start_date,$data['event']->end_date);

			   }else{
				   $data['result'] = 0;
			   }			   
		   }

		$this->wall2all->deliver_json($data);
	}
	function attending_insert() {
		$att = $this->input->post('att');
		$events_id = $this->input->post('events_id');
		$user_id = $this->input->post('user_id');
		if($this->attending_model->insert_att($user_id,$events_id,$att)){
			   $data['result'] = 1;
			   $data['atts'] = $this->attending_model->return_attending_data($events_id);
			   $data['att'] = 1;
			   $data['num_atts'] = $this->attending_model->all_att($events_id);
		}
		$this->wall2all->deliver_json($data);
	}
	function attending_update() {
		$att = $this->input->post('att');
		$events_id = $this->input->post('events_id');
		$user_id = $this->input->post('user_id');
		if($this->attending_model->update_att($user_id,$att)){
			if($att == 0) {
			   $data['result'] = 2;
			   $data['atts'] = $this->attending_model->return_attending_data($events_id);
			   $data['att'] = 2;
			   $data['num_atts'] = $this->attending_model->all_att($events_id);
			}else{
			   $data['result'] = 3;
			   $data['atts'] = $this->attending_model->return_attending_data($events_id);
			   $data['att'] = 1;
			   $data['num_atts'] = $this->attending_model->all_att($events_id);
			}
		}
		$this->wall2all->deliver_json($data);
	}
	function like(){
		$comment_id = $this->input->post('comment_id');
		$user_id = $this->input->post('user_id');
		$events_id = $this->input->post('events_id');
		if($like = $this->like_model->insert_like($user_id,$comment_id, $events_id)){
			$data['result'] = 1;
			$data['like'] = $like;
		}else{
			$data['result'] = 0;
		}
	  $this->wall2all->deliver_json($data);
	}
	function report(){
		$comment_id = $this->input->post('comment_id');
		$user_id = $this->input->post('user_id');
		$events_id = $this->input->post('events_id');
		if($this->report_model->insert_report($user_id,$comment_id, $events_id)){
			$data['result'] = 1;
		}else{
			$data['result'] = 0;
		}
	  $this->wall2all->deliver_json($data);
	}
	function delete_comment() {
		$comment_id = $this->input->post('comment_id');
		$user_id = $this->input->post('user_id');
		$events_id = $this->input->post('events_id');
		if($this->comments_model->delete_comment($comment_id)){
			 $data['result'] = 1;  	
		}else{
			$data['result'] = 0;
		}
	  $this->wall2all->deliver_json($data);
	}
	function ajax_comments_pagination() {
		$events_id = $this->input->post('events_id');
		$lastID = $this->input->post('lastID');
		if($lastID == 'false'){
			$lastID = FALSE;
		}
		
				/*$this->load->library('pagination');
				$config['base_url'] = base_url().'events/detail/'.$events_id;
				$config['total_rows'] = $this->comments_model->all_comments_where_event($events_id);
				$config['per_page'] = 3;
				$config['num_links'] = 2;
				$config['uri_segment'] = 4;
				$config['page_query_string'] = FALSE;
				$this->pagination->set_cur_page($offset);
				$this->pagination->initialize($config);
				$data['pag_links'] = $this->pagination->create_links();*/
				
				/*$data['pag_links'] = $this->get_page_links($events_id,$offset);*/
       if($this->input->post('imparity') == 1){
  				$data['comments'] = $this->comments_model->return_comments($events_id, $lastID, true);
				if($data['comments']){
					$data['result'] = 1;
				}else{
					$data['result'] = 0;
				} 
	   }else{
				$data['comments'] = $this->comments_model->return_comments($events_id, $lastID);
				if($data['comments']){
					$data['result'] = 1;
				}else{
					$data['result'] = 0;
				}
	   }
		$this->wall2all->deliver_json($data);
	}
	function init_id() {
		$data = $this->comments_model->get_next_num() - 1;
		$this->wall2all->deliver_json($data);
	}
	function update_social_user_privileges(){
		$value = $this->input->post('value');
		$id = $this->input->post('id');
		$update_data = array(
		               'is_admin'=> $value
					   );
		$this->db->where('id', $id);
		$this->db->update('users', $update_data); 
		$data['result'] = 1;
		$this->wall2all->deliver_json($data);
	}
	function ajax_blocking(){
		$status = $this->input->post('status');
		$user_id = $this->input->post('user_id');
		if($this->users_model->blocking_social_users($user_id,$status)){
			$data['result'] = 1;
		}else{
			$data['result'] = 0;
		}
		$this->wall2all->deliver_json($data);
	}
	private function get_page_links($events_id,$offset) {
	  			
				$this->load->library('pagination');
				$config['base_url'] = base_url().'events/detail/'.$events_id;
				$config['total_rows'] = $this->comments_model->all_comments_where_event($events_id);
				$config['per_page'] = 3;
				$config['num_links'] = 2;
				$config['uri_segment'] = 4;
				$config['page_query_string'] = FALSE;
				$this->pagination->set_cur_page($offset);
				$this->pagination->initialize($config);
				$pag_links = $this->pagination->create_links();
				return $pag_links;
	
	}
	function blockUser(){
		$user_id = $this->input->post('user_id');
		if($this->users_model->is_blocked('id', $user_id)){
			$data['result'] = 1;
		}else{
			$data['result'] = 0;
		}
		$this->wall2all->deliver_json($data);
	}
	function ajax_map(){
		
		
		$this->events_model->init_events_with_condition('live');
		$live_events = $this->events_model->return_events_with_condition();
	    $this->events_model->init_events_with_condition('upcoming');
		$upcoming_events = $this->events_model->return_events_with_condition();
		
	  	$this->load->library('googlemaps');
		$config['center'] = 'auto';
		$config['zoom'] = '12';
		$config['map_width'] = '940px';
		$config['map_height'] = '500px';

		$this->googlemaps->initialize($config);
	    
	    if($live_events){
		  $k = 0;
			foreach($live_events as $live_event) {
				$marker = array();
				$marker['position'] = $live_event->country .','. $live_event->city .','. $live_event->address;
				
	
				$marker['icon'] = base_url().'phpThumb/phpThumb.php?src=/assets/evt_logo_img/'.$live_event->logo_events.'&w=60&h=65&zc=1&aoe=1&fltr[]=wmt|Live|5|C|FFFFFF|arial.ttf|80|100||000000|100|x';
				
				$marker['title'] = 'Live';
			  
				$desc = ($live_event->description_events != '')?$live_event->description_events:'No description';
				$data['windows'][$k] = '<div id="popup'.$k.'" class="popup" data-num="'.$k.'"><article> <header> <a href="'.base_url().'events/detail/'.$live_event->id_events.'" ><h2>'.$live_event->title_events.'</h2></a> </header><p>'.
				$desc
				
				.'</p> <p></p> <footer></footer>  <a href="#" class="close">close</a> </article></div>';
				$marker['onclick'] = '
				
				
				eventOnClick('.$k.',popup'.$k.');
				';
				$k++;

				$marker['animation'] = 'DROP';
				$this->googlemaps->add_marker($marker);  
			}
	    }
	    if($upcoming_events){

			foreach($upcoming_events as $upcoming_event) {
				$marker = array();
				$marker['position'] = $upcoming_event->country .','. $upcoming_event->city .','. $upcoming_event->address;
				
	
				$marker['icon'] = base_url().'phpThumb/phpThumb.php?src=/assets/evt_logo_img/'.$upcoming_event->logo_events.'&w=60&h=65&zc=1&aoe=1&fltr[]=wmt|Upcoming|3|C|FFFFFF|arial.ttf|80|100||000000|100|x';
				
				$marker['title'] = 'Upcoming';
			  
				$desc = ($upcoming_event->description_events != '')?$upcoming_event->description_events:'No description';
				$data['windows'][$k] = '<div id="popup'.$k.'" class="popup" data-num="'.$k.'"><article> <header> <a href="'.base_url().'events/detail/'.$live_event->id_events.'" ><h2>'.$upcoming_event->title_events.'</h2></a> </header><p>'.
				$desc
				
				.'</p> <p></p> <footer></footer> <a href="#" class="close">close</a> </article></div>';
				$marker['onclick'] = '
				
				
				eventOnClick('.$k.',popup'.$k.');
				';
				$k++;

				$marker['animation'] = 'DROP';
				$this->googlemaps->add_marker($marker);  
			}
	    }		

	  
	    $data['map'] = $this->googlemaps->create_map();
	    $this->load->view('front/mapShell_view',$data);
	
	
	}
	function testape(){
		$data['another'] = false;
		$this->wall2all->front_view('test/test.ape.php',$data);
		
	}
    function testapeusers(){
		$data = null ;
		$this->wall2all->front_view('test/test.ape_users.php',$data);
		
	}
	function supertest(){
		$data['another'] = true;
		$this->wall2all->front_view('test/test.ape.php',$data);
	}
	function test(){

//    echo $this->venues_model->all_venues();
	/*$this->load->library('tweet');
	$this->tweet->enable_debug(TRUE);
	$tokens = $this->tweet->get_tokens();		
	$tweetOb = $this->tweet->call('get', 'statuses/mentions_timeline');
	print_r($tweetOb);*/	
	
	/*$str = 'Sucks, fucks, tits, asshole, kurac, govno, pička, jebanje, jebi, materina, siso, sisa, kurva, pičketina, ';
	
	$bad_words_array = explode(",",walltoall_strip_bad_words($str));
	echo str_ireplace($bad_words_array,'...','She has a big Tits');*/
		
		
	}
  function test2(){

	/*$this->session->set_userdata('one', 'good');*/
	echo 'Hi';
	var_dump($this->logged_in);
		/*$this->wall2all->logout();*/
	/*print_r ($this->session->all_userdata());
	echo '<br/>';
	var_dump($this->facebook_admin);*/
   /* var_dump($this->session->userdata('facebook_id'));*/
   /*$this->users_model->init_face_users();
   var_dump($this->users_model->get_num_face_users());*/
   
//   print_r($this->comments_model->get_comments_evts_users());
  }
  
  function post_to_facebook() {
	  
	  $postToFace = $this->input->post('postToFace');
	  
	  
	  $this->load->library('Facebook');
	  $facebook = new Facebook(array('appId'=>'326283710790999','secret'=>'98e110a0222dcd1399d0107a5513ffe5'));
	  $user_id = $facebook->getUser();
      if($user_id) {


      try {
        $ret_obj = $facebook->api('/me/feed', 'POST',
                                    array(
                                      'link' => 'http://wall2allnew.cp-dev.com',
                                      'message' => $postToFace,
                                 ));
        $data['result'] = 1;
             
      } catch(FacebookApiException $e) {

        $data['result'] = 0;
		   
      }   
    

    } else {

        $data['result'] = 0;
		
    } 	  
	  
	  
	 $this->wall2all->deliver_json($data); 
  }
}





