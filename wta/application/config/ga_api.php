<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['profile_id']  = 'ga:';
$config['profile_id']	= '62207355'; // GA profile id
$config['email']		= 'wall2all.api@gmail.com '; // GA Account mail
$config['password']		= 'siget1200'; // GA Account password

$config['cache_data']	= false; // request will be cached
$config['cache_folder']	= '/cache'; // read/write
$config['clear_cache']	= array('date', '1 day ago'); // keep files 1 day
	
$config['debug']		= false; // print request url if true