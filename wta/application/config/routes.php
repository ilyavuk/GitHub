<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "index";
$route['logout'] = "index/logout";
$route['login'] = "index/login";
$route['register'] = "index/register";
$route['register/(:any)'] = "index/register/$1";
$route['reset-account'] = "index/reset_account";
$route['terms-and-privacy'] = "index/TermsAndPrivacy";
$route['control-panel'] = "control/index";
$route['account-settings'] = "control/account_settings";
$route['control-panel/add-event'] = "events/add_event";
$route['control-panel/add-venue'] = "venues/add_venue";
$route['control-panel/my-events'] = "events/personal_events";
$route['control-panel/my-venues'] = "venues/personal_venues";
$route['control-panel/my-events/(:any)'] = "events/personal_events/$1";
$route['control-panel/my-venues/(:any)'] = "venues/personal_venues/$1";
$route['events'] = "events/all_events";
$route['events/(:any)'] = "events/all_events/$1";
$route['venues'] = "venues/all_venues";
$route['venues/(:any)'] = "venues/all_venues/$1";
$route['admin'] = "admin/index";

$route['testape2'] = "ajax/supertest";
$route['testape'] = "ajax/testape";
$route['testapeusers'] = "ajax/testapeusers";

$route['ajax/upload_admin_image'] = "ajax/upload_admin_image";
$route['ajax/upload_eventBanner_image'] = "ajax/upload_eventBanner_image";
$route['ajax/upload_venueBanner_image'] = "ajax/upload_venueBanner_image";
$route['ajax/upload_event_image'] = "ajax/upload_event_image";
$route['ajax/upload_admin_image'] = "ajax/upload_admin_image";
$route['ajax/upload_background_image'] = "ajax/upload_background_image";
$route['ajax/upload_venue_image'] = "ajax/upload_venue_image";
$route['ajax/get_venues_images'] = "ajax/get_venues_images";
$route['ajax/delete_images'] = "ajax/delete_images";
$route['ajax/upload_comment_image'] = "ajax/upload_comment_image";
$route['ajax/get_personal_image'] = "ajax/get_personal_image";
$route['ajax/get_images'] = "ajax/get_images";
$route['ajax/insert_comments'] = "ajax/insert_comments";
$route['ajax/delete_venues_banner'] = "ajax/delete_venues_banner";
$route['ajax/delete_events_banner'] = "ajax/delete_events_banner";
$route['ajax/delete_background'] = "ajax/delete_background";
$route['ajax/get_personal_image'] = "ajax/delete_images";
$route['ajax/delete_venues_images'] = "ajax/delete_venues_images";
$route['ajax/change_title'] = "ajax/change_title";
$route['ajax/change_venue_title'] = "ajax/change_venue_title";
$route['ajax/change_textarea'] = "ajax/change_textarea";
$route['ajax/change_venue_textarea'] = "ajax/change_venue_textarea";
$route['ajax/add_logo'] = "ajax/add_logo";
$route['ajax/log_in'] = "ajax/log_in";
$route['ajax/rate_event'] = "ajax/rate_event";
$route['ajax/following'] = "ajax/following";
$route['ajax/poll'] = "ajax/poll";
$route['ajax/attending_insert'] = "ajax/attending_insert";
$route['ajax/attending_update'] = "ajax/attending_update";
$route['ajax/like'] = "ajax/like";
$route['ajax/report'] = "ajax/report";
$route['ajax/delete_comment'] = "ajax/delete_comment";
$route['ajax/ajax_blocking'] = "ajax/ajax_blocking";
$route['ajax/blockUser'] = "ajax/blockUser";
$route['ajax/ajax_comments_pagination'] = "ajax/ajax_comments_pagination";
$route['ajax/test'] = "ajax/test";
$route['ajax/test2'] = "ajax/test2";
$route['ajax/init_id'] = "ajax/init_id";
$route['ajax/update_social_user_privileges'] = "ajax/update_social_user_privileges";

$route['facebookAuth'] = "facebookAuth/index";
$route['facebookAuth/f_logout'] = "facebookAuth/f_logout";

$route['facebookAuth/get_token'] = "facebookAuth/get_token";

$route['twit'] = "tweet_test/index";
$route['twitter'] = "twitter/index";
$route['twitter/auth'] = "twitter/auth";
$route['twitter/t_logout'] = "twitter/t_logout";
$route['search'] = "search/index";
$route['search/(:any)'] = "search/index/$1";
$route['admin/logout'] = "admin/logout";
$route['admin/users'] = "admin/users";
$route['admin/users/(:any)'] = "admin/users/$1";
$route['admin/home'] = "admin/home";
$route['admin/home/(:any)'] = "admin/home/$1";
$route['admin/comments'] = "comments/admin_comments";
$route['admin/comments/(:any)'] = "comments/admin_comments/$1";
$route['admin/comments/edit/(:any)'] = "comments/admin_comments_edit/$1";
$route['admin/admin_comments_delete/(:any)'] = "comments/admin_comments_delete/$1";
$route['admin/events'] = "events/admin_events";
$route['admin/events/(:any)'] = "events/admin_events/$1";
$route['admin/live-events'] = "live_events/admin_live_events";
$route['admin/live-events/(:any)'] = "live_events/admin_live_events/$1";
$route['admin/venues'] = "venues/admin_venues";
$route['admin/venues/(:any)'] = "venues/admin_venues/$1";
$route['admin/comment_mdelete'] = "admin/comment_mdelete";
$route['admin/comment_mdelete/(:any)'] = "admin/comment_mdelete/$1";
$route['admin/event_mdelete'] = "admin/event_mdelete";
$route['admin/event_mdelete/(:any)'] = "admin/event_mdelete/$1";
$route['admin/venue_mdelete'] = "admin/venue_mdelete";
$route['admin/venue_mdelete/(:any)'] = "admin/venue_mdelete/$1";
$route['admin/multy_users_delete'] = "admin/multy_users_delete";
$route['admin/multy_users_delete/(:any)'] = "admin/multy_users_delete/$1";
$route['admin/admin_users_delete'] = "admin/admin_users_delete";
$route['admin/admin_users_delete/(:any)'] = "admin/admin_users_delete/$1";



/*$route['admin/events/insert'] = "events/admin_events_insert";
$route['admin/events/delete/(:any)'] = "events/admin_events_delete/$1";
$route['admin/events/edit/(:any)'] = "events/admin_events_edit/$1"*/;
$route['delete/event_delete/(:any)'] = "events/event_delete/$1";
$route['delete/venue_delete/(:any)'] = "venues/venue_delete/$1";
$route['admin/users/delete/(:any)'] = "admin/admin_users_delete/$1";
$route['live/(:any)'] = "live_events/live/$1";
$route['test/(:any)'] = "events/test_event_details/$1";
$route['node.js/(:any)'] = "events/events_with_node/$1";
$route['(:any)'] = "events/event_details/$1";
$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */