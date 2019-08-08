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
$this->set_directory( "frontend" );
$route['default_controller'] = "frontend/home";
$route['404_override'] = '';
$route['search-listing'] = 'frontend/search';
$route['contact-us'] = 'frontend/cms/contact_us';
$route['sign-up'] = 'frontend/login/set_sign_up';
$route['events'] = 'frontend/events/index';
$route['fund-raise'] = 'frontend/champion/fund_raising';
$route['donate'] = 'frontend/champion/champion_listing';
$route['learn-more'] = 'frontend/cms/learn';
$route['login'] = 'frontend/login';
$route['view-event/(:any)'] = 'frontend/events/event_details/$1';
$route['event-listing'] = 'frontend/home/search_events';
$route['book-event/(:any)'] = 'frontend/events/book_sub_events/$1';
$route['shopping-cart'] = 'frontend/events/save_ticket_details';
$route['view-champion/(:any)'] = 'frontend/champion/view_fundraising/$1';
$route['view-profile'] = 'frontend/users/view_user_profile';
$route['edit-profile'] = 'frontend/users/edit_user_profile';
$route['view-org-profile'] = 'frontend/organiser/view_profile';
$route['edit-org-profile'] = 'frontend/organiser/edit_profile';
$route['how-to-videos'] = 'frontend/video_cms/index';
$route['terms-and-conditions'] = 'frontend/cms/terms';
$route['faqs'] = 'frontend/cms/faq';
$route['about-us'] = 'frontend/cms/about_us';
$route['contact-us'] = 'frontend/cms/contact_us';

$route['events/music'] = 'frontend/home/search_events/music';
$route['events/games'] = 'frontend/home/search_events/games';
$route['events/entertainment'] = 'frontend/home/search_events/entertainment';
$route['events/sport'] = 'frontend/home/search_events/sport';

/* End of file routes.php */
/* Location: ./application/config/routes.php */