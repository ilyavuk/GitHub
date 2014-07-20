<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
	}
	function index() {
		$city = strtolower($this->input->get('searchCity'));
		$category = strtolower($this->input->get('searchCategory'));
		$event = strtolower($this->input->get('searchEvent'));
		$venue =($this->input->get('searchVenue'))?strtolower($this->input->get('searchVenue')):'';
		$dateFrom =($this->input->get('dateFrom'))?strtotime($this->input->get('dateFrom')):'';
		$dateTo =($this->input->get('dateTo'))?strtotime($this->input->get('dateTo')):'';

        $this->search_model->init_search($city,$category,$event,$venue, $dateFrom, $dateTo);	
		
		$events = $this->search_model->search_limit();
		
		$cityRec = $city;
		if($city == ''){
		   $cityRec = false;
		   $city = 'Beograd';
		}
		$data['selected_city']= $this->input->get('searchCity');
		$data['selected_category']= $this->input->get('searchCategory');
		$data['selected_event']= $this->input->get('searchEvent');
		$data['selected_venue']= $this->input->get('searchVenue');
		$data['selected_dateFrom']= $this->input->get('dateFrom');
		$data['selected_dateTo']= $this->input->get('dateTo');
		
		$this->load->library('googlemaps');
		$config['center'] = $city;
		$config['zoom'] = '12';
		/*$config['map_width'] = '940px';
		$config['map_height'] = '500px';*/
		$this->googlemaps->initialize($config);
	    $k = 0;
	    if($events){
		 
			foreach($events as $event) {
				$marker = array();
				$marker['position'] = $event->country .','. $event->city .','. $event->address;
				$marker['icon'] = base_url().'assets/img/map-icon-default.png';
				$desc = ($event->description_events != '')?removeTokens($event->description_events):'No description';
				$average_grade = $this->grade_model->event_grade('events_grade',$event->id_events,false,true,$event->start_date,$event->end_date);
				$data['windows'][$k] = '<div id="popup'.$k.'" class="popup" data-num="'.$k.'"><article> <header> <a href="'.base_url().$event->url_title.'" ><h2>'.$event->title_events.'</h2></a><br/>Event Rate: '.$average_grade.' </header><p>'.
				$desc
				
				.'</p> <p></p> <footer></footer> <a href="#" class="next">next</a> | <a href="#" class="prev">previous</a>  <a href="#" class="close">close</a> </article></div>';
				$marker['onclick'] = '
				
				eventOnClick('.$k.',popup'.$k.');
				';
				$marker['magicBox'] = '<p>'.$event->title_events .'</p><p class="rate" >Event Rate:'.$average_grade.'</p>';
				$k++;

				$marker['animation'] = 'DROP';
				$this->googlemaps->add_marker($marker);  
			}
	    }
		$data['is_center'] = $config['center'];
	    $data['map'] = $this->googlemaps->create_map();
		$data['we_recommends'] = $this->get_model->get_all('weRecommend');
		$data['youtube'] = $this->get_model->get_all_where_single('homeyoutube', 'id', 1)->url;
		$data['banners'] = $this->get_model->get_all_where_single('homeyoutube', 'id', 1)->banners;
		$data['background'] = $this->get_model->get_all_where_single('homeyoutube', 'id', 1)->background_image;
		$data['what_is_news'] = $this->home_model->get_what_is_new($cityRec);
		$data['last_posts'] = $this->home_model->get_last_posts();
		$data['bad_words'] = $this->comments_model->get_b_words();
	    $this->wall2all->front_view('central_view', $data);
		
	}
}