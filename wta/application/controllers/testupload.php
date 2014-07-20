<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Testupload extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();

	}
	function index(){
	
	
	if($this->input->post('upload')){

		  $config = array(
		  'allowed_types' => 'jpg|jpeg|gif|png',
		  'file_name' => 'com__'.time(),
		  'upload_path' => realpath(APPPATH . '../assets/testupload/').'/',
		  'max_size' => '10000'
		  );
		  
		 $this->load->library('upload',$config);
		 $this->upload->do_upload();
	     $image_data = $this->upload->data();
	    
		
		$this->load->view('for_test',$image_data);
	
	}else{
	
	     $this->load->view('for_test');
		
	}
	
	}
}





