<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Pacific/Auckland');
/*
|--------------------------------------------------------------------------
| Base Site URL
|--------------------------------------------------------------------------
|
| URL to your CodeIgniter root. Typically this will be your base URL,
| WITH a trailing slash:
|
|	http://example.com/
|
| WARNING: You MUST set this value!
|
| If it is not set, then CodeIgniter will try guess the protocol and path
| your installation, but due to security concerns the hostname will be set
| to $_SERVER['SERVER_ADDR'] if available, or localhost otherwise.
| The auto-detection mechanism exists only for convenience during
| development and MUST NOT be used in production!
|
| If you need to allow multiple domains, remember that this file is still
| a PHP script and you can easily do that on your own.
|
*/

$config['base_url'] = 'http://local.ticketing_system.com/';

$config['admin_css_path'] = $config['base_url'].'assets/backend/css/';
$config['admin_js_path']  = $config['base_url'].'assets/backend/js/';
$config['admin_image_path']  = $config['base_url'].'assets/backend/images/';
$config['fe_image_path']  = $config['base_url'].'assets/frontend/images/';

$config['email_template_image_path']  =  $config['base_url'].'assets/email_images/';

$config['organisation_logo']  = $config['base_url'].'assets/image_uploads/organisation_logo/';
$config['fe_assets_url']  = $config['base_url'].'assets/';
$config['organisation_statement']  = $config['base_url'].'assets/image_uploads/bank_statement/';
$config['organisation_signature']  = $config['base_url'].'assets/image_uploads/signature/';
$config['event_image']  = $config['base_url'].'assets/image_uploads/event_image/';
$config['sponsor_image_url']  = $config['base_url'].'assets/image_uploads/sponsor_image/';
$config['default_image_url']  = $config['base_url'].'assets/image_uploads/default_images/';
$config['fundraising_image_url']  = $config['base_url'].'assets/image_uploads/fundraising_image/';

$config['fe_logo_image_url']  = $config['fe_image_path'].'TicketSuitLogo1_transparent.png';

$config['frontend_profileimage_path']  = $config['base_url'].'assets/image_uploads/profile_images/';
// frontend assets urls
$config['frontend_css_path'] = $config['base_url'].'assets/frontend/css/';
$config['frontend_js_path']  = $config['base_url'].'assets/frontend/js/';
$config['frontend_image_path']  = $config['base_url'].'assets/frontend/';

// cms url
$config['frontend_cms']  = $config['base_url'].'frontend/cms/';




// backend url management
$config['login_url'] =  $config['base_url'].'backend/login';
$config['login_check_url'] =  $config['base_url'].'backend/login/check_login';
$config['logout_url'] = $config['base_url'].'backend/login/logout';

// admin user mgmt
$config['admin_dashboard'] = $config['base_url'].'backend/dashboard';
$config['admin_users'] = $config['base_url'].'backend/users';

// admin events mgmt
$config['admin_events'] = $config['base_url'].'backend/events/index';
// admin manage organisers
$config['admin_organiser'] = $config['base_url'].'backend/organiser';
$config['admin_profile'] = $config['base_url'].'backend/login/my_profile';
$config['admin_save_profile'] = $config['base_url'].'backend/login/save_profile';
$config['admin_change_password'] = $config['base_url'].'backend/login/change_password';
$config['admin_save_change_password'] = $config['base_url'].'backend/login/save_change_password';
$config['admin_manage_cms'] = $config['base_url'].'backend/cms';
$config['admin_add_cms'] = $config['base_url'].'backend/cms/add_cms';
$config['admin_save_cms'] = $config['base_url'].'backend/cms/save_cms';
$config['admin_edit_cms'] = $config['base_url'].'backend/cms/edit_cms';

$config['update_organiser_status'] = $config['base_url'].'backend/organiser/update_organiser_status';
$config['view_organiser_profile'] = $config['base_url'].'backend/organiser/view_organisation';
$config['edit_organiser_profile'] = $config['base_url'].'backend/organiser/edit_organisation';
// test frontent url's
$config['add_organiser'] = $config['base_url'].'frontend/organiser/add_new_organiser';
$config['save_organiser'] = $config['base_url'].'frontend/registration/save_organiser';
$config['save_admin_organiser'] = $config['base_url'].'backend/organiser/save_organiser';
//check and validate login
$config['check_login'] = $config['base_url'].'frontend/login/check_login';
$config['forgot_password'] = $config['base_url'].'frontend/login/forgot_password';

$config['forgot_password_send'] = $config['base_url'].'frontend/login/forgot_password_send';
$config['frontend_logout'] = $config['base_url'].'frontend/login/logout';


$config['view_organiser_frontned_profile'] = $config['base_url'].'frontend/organiser/view_profile';
$config['edit_fe_profile'] = $config['base_url'].'frontend/organiser/edit_profile';

$config['update_fe_organization_details']  = $config['base_url'].'frontend/organiser/update_organization_details';

// frontend events
$config['add_event'] = $config['base_url'].'frontend/events/add_event';
$config['save_fe_event'] = $config['base_url'].'frontend/events/save';
$config['fe_view_event'] = $config['base_url'].'frontend/events/event_details';

// fb login
$config['fb_login'] = $config['base_url'].'frontend/login/facebook_login';
$config['fb_fe_logout'] = $config['base_url'].'frontend/login/logout';

// event save page
$config['fb_fe_logout'] = $config['base_url'].'frontend/event/event_save';
// event details link
$config['event_details'] = $config['base_url'].'frontend/events/event_details';
$config['event_save_message'] = $config['base_url'].'frontend/events/save_event_message';
$config['set_event_as_popular']  = $config['base_url'].'backend/events/set_event_as_popular';

// manage event backend links
$config['admin_view_events'] = $config['base_url'].'backend/events/view_event_details';
$config['set_event_as_popular']  = $config['base_url'].'backend/events/set_event_as_popular';
$config['disable_event_as_popular']  = $config['base_url'].'backend/events/disable_event_as_popular';
$config['set_event_as_active']  = $config['base_url'].'backend/events/set_event_as_active';
$config['set_event_as_inActive']  = $config['base_url'].'backend/events/set_event_as_inActive';
$config['save_popular_events']  = $config['base_url'].'backend/events/save_popular_events';
$config['get_popular_events']  = $config['base_url'].'backend/events/popular_events';
$config['get_popular_champions']  = $config['base_url'].'backend/champions/popular_champions';
$config['save_popular_champions']  = $config['base_url'].'backend/champions/save_popular_champions';
// home page search
$config['search_events']  = $config['base_url'].'frontend/home/search_events';

$config['frontend_user_sign_up'] = $config['base_url'].'frontend/users/check_unique_email';

// champion page urls
$config['add_champion_page']  = $config['base_url'].'frontend/champion/add_new_champion';
$config['on_load_event_by_organization']  = $config['base_url'].'frontend/champion/on_load_event_by_organization';
$config['load_sub_event_by_event_id']  = $config['base_url'].'frontend/champion/load_sub_event_by_event_id';

// save fundraising
$config['save_fundraising']  = $config['base_url'].'frontend/champion/save_fundraising';

// backend champion section
$config['be_champion_listing']  = $config['base_url'].'backend/champions/index';

$config['fe_champions_view']  = $config['base_url'].'frontend/champion/view_fundraising';
$config['fe_champion_listing']  = $config['base_url'].'frontend/champion/champion_listing';
$config['fe_champion_search']  = $config['base_url'].'frontend/champion/search';

$config['stopActivateMyPage'] = $config['base_url'].'frontend/champion/stopActivateMyPage';

// handle fundraising status
$config['update_fundraising_status'] = $config['base_url'].'frontend/champion/update_fundraising_status';

//
$config['frontend_donation'] = $config['base_url'].'frontend/donation';
$config['save_donation']  = $config['base_url'].'frontend/donation/save_donation';
$config['update_fundraising']  = $config['base_url'].'frontend/champion/update_fundraising';

// admin urls
$config['admin_user'] = $config['base_url'].'backend/admin_user';
$config['add_admin_user'] = $config['base_url'].'backend/admin_user/add_user_form';
$config['insert_admin'] = $config['base_url'].'backend/admin_user/insert_admin_user/';

// my donation pages
$config['view_donation_details'] = $config['base_url'].'frontend/my_donation/view_donation_details';

// admin payment set up
$config['admin_payment_set_up']  = $config['base_url'].'backend/payment';

// Banner Mgmt
$config['add_banner'] = $config['base_url'].'backend/banners/add_banners';
$config['edit_banner'] = $config['base_url'].'backend/banners/edit_banner';
$config['admin_banners'] = $config['base_url'].'backend/banners';
$config['save_banner'] = $config['base_url'].'backend/banners/save_banner';


// Set up orgazations
$config['set_up_organizations'] = $config['base_url'].'index.php/backend/set_organizations/index';
$config['add_agent_organization'] =  $config['base_url'].'index.php/backend/set_organizations/add_new_organizations';
$config['save_set_organizations'] = $config['base_url'].'index.php/backend/set_organizations/save_organization';
$config['update_organiser_through_url'] = $config['base_url'].'index.php/frontend/set_organizations/update_organiser_through_url';
$config['organizer_set_up'] = $config['base_url'].'index.php/frontend/set_organizations/set_up';

$config['save_admin_organiser_submission'] = $config['base_url'].'backend/set_organizations/save_organiser_submission';

$config['organizer_save_change_password'] = $config['base_url'].'index.php/frontend/organiser/organiser_save_change_password';
$config['user_save_change_password'] = $config['base_url'].'index.php/frontend/users/user_save_change_password';

$config['load_sub_event_by_event_id_with_subevents']  = $config['base_url'].'frontend/donation_reports/load_sub_event_by_event_id_with_subevents';

/*
|--------------------------------------------------------------------------
| Index File
|--------------------------------------------------------------------------
|
| Typically this will be your index.php file, unless you've renamed it to
| something else. If you are using mod_rewrite to remove the page set this
| variable so that it is blank.
|
*/
$config['index_page'] = '';

/*
|--------------------------------------------------------------------------
| URI PROTOCOL
|--------------------------------------------------------------------------
|
| This item determines which server global should be used to retrieve the
| URI string.  The default setting of 'AUTO' works for most servers.
| If your links do not seem to work, try one of the other delicious flavors:
|
| 'AUTO'			Default - auto detects
| 'PATH_INFO'		Uses the PATH_INFO
| 'QUERY_STRING'	Uses the QUERY_STRING
| 'REQUEST_URI'		Uses the REQUEST_URI
| 'ORIG_PATH_INFO'	Uses the ORIG_PATH_INFO
|
*/
$config['uri_protocol']	= 'AUTO';

/*
|--------------------------------------------------------------------------
| URL suffix
|--------------------------------------------------------------------------
|
| This option allows you to add a suffix to all URLs generated by CodeIgniter.
| For more information please see the user guide:
|
| http://codeigniter.com/user_guide/general/urls.html
*/

$config['url_suffix'] = '';

/*
|--------------------------------------------------------------------------
| Default Language
|--------------------------------------------------------------------------
|
| This determines which set of language files should be used. Make sure
| there is an available translation if you intend to use something other
| than english.
|
*/
$config['language']	= 'english';

/*
|--------------------------------------------------------------------------
| Default Character Set
|--------------------------------------------------------------------------
|
| This determines which character set is used by default in various methods
| that require a character set to be provided.
|
*/
$config['charset'] = 'UTF-8';

/*
|--------------------------------------------------------------------------
| Enable/Disable System Hooks
|--------------------------------------------------------------------------
|
| If you would like to use the 'hooks' feature you must enable it by
| setting this variable to TRUE (boolean).  See the user guide for details.
|
*/
$config['enable_hooks'] = FALSE;


/*
|--------------------------------------------------------------------------
| Class Extension Prefix
|--------------------------------------------------------------------------
|
| This item allows you to set the filename/classname prefix when extending
| native libraries.  For more information please see the user guide:
|
| http://codeigniter.com/user_guide/general/core_classes.html
| http://codeigniter.com/user_guide/general/creating_libraries.html
|
*/
$config['subclass_prefix'] = 'MY_';


/*
|--------------------------------------------------------------------------
| Allowed URL Characters
|--------------------------------------------------------------------------
|
| This lets you specify with a regular expression which characters are permitted
| within your URLs.  When someone tries to submit a URL with disallowed
| characters they will get a warning message.
|
| As a security measure you are STRONGLY encouraged to restrict URLs to
| as few characters as possible.  By default only these are allowed: a-z 0-9~%.:_-
|
| Leave blank to allow all characters -- but only if you are insane.
|
| DO NOT CHANGE THIS UNLESS YOU FULLY UNDERSTAND THE REPERCUSSIONS!!
|
*/
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';


/*
|--------------------------------------------------------------------------
| Enable Query Strings
|--------------------------------------------------------------------------
|
| By default CodeIgniter uses search-engine friendly segment based URLs:
| example.com/who/what/where/
|
| By default CodeIgniter enables access to the $_GET array.  If for some
| reason you would like to disable it, set 'allow_get_array' to FALSE.
|
| You can optionally enable standard query string based URLs:
| example.com?who=me&what=something&where=here
|
| Options are: TRUE or FALSE (boolean)
|
| The other items let you set the query string 'words' that will
| invoke your controllers and its functions:
| example.com/index.php?c=controller&m=function
|
| Please note that some of the helpers won't work as expected when
| this feature is enabled, since CodeIgniter is designed primarily to
| use segment based URLs.
|
*/
$config['allow_get_array']		= TRUE;
$config['enable_query_strings'] = FALSE;
$config['controller_trigger']	= 'c';
$config['function_trigger']		= 'm';
$config['directory_trigger']	= 'd'; // experimental not currently in use

/*
|--------------------------------------------------------------------------
| Error Logging Threshold
|--------------------------------------------------------------------------
|
| If you have enabled error logging, you can set an error threshold to
| determine what gets logged. Threshold options are:
| You can enable error logging by setting a threshold over zero. The
| threshold determines what gets logged. Threshold options are:
|
|	0 = Disables logging, Error logging TURNED OFF
|	1 = Error Messages (including PHP errors)
|	2 = Debug Messages
|	3 = Informational Messages
|	4 = All Messages
|
| For a live site you'll usually only enable Errors (1) to be logged otherwise
| your log files will fill up very fast.
|
*/
$config['log_threshold'] = 1;

/*
|--------------------------------------------------------------------------
| Error Logging Directory Path
|--------------------------------------------------------------------------
|
| Leave this BLANK unless you would like to set something other than the default
| application/logs/ folder. Use a full server path with trailing slash.
|
*/
$config['log_path'] = '';

/*
|--------------------------------------------------------------------------
| Date Format for Logs
|--------------------------------------------------------------------------
|
| Each item that is logged has an associated date. You can use PHP date
| codes to set your own date formatting
|
*/
$config['log_date_format'] = 'Y-m-d H:i:s';

/*
|--------------------------------------------------------------------------
| Cache Directory Path
|--------------------------------------------------------------------------
|
| Leave this BLANK unless you would like to set something other than the default
| system/cache/ folder.  Use a full server path with trailing slash.
|
*/
$config['cache_path'] = '';

/*
|--------------------------------------------------------------------------
| Encryption Key
|--------------------------------------------------------------------------
|
| If you use the Encryption class or the Session class you
| MUST set an encryption key.  See the user guide for info.
|
*/
$config['encryption_key'] = 'i2nfdskjnf98@#$%^&U*&^%@#$%^&*&^%$';

/*
|--------------------------------------------------------------------------
| Session Variables
|--------------------------------------------------------------------------
|
| 'sess_cookie_name'		= the name you want for the cookie
| 'sess_expiration'			= the number of SECONDS you want the session to last.
|   by default sessions last 7200 seconds (two hours).  Set to zero for no expiration.
| 'sess_expire_on_close'	= Whether to cause the session to expire automatically
|   when the browser window is closed
| 'sess_encrypt_cookie'		= Whether to encrypt the cookie
| 'sess_use_database'		= Whether to save the session data to a database
| 'sess_table_name'			= The name of the session database table
| 'sess_match_ip'			= Whether to match the user's IP address when reading the session data
| 'sess_match_useragent'	= Whether to match the User Agent when reading the session data
| 'sess_time_to_update'		= how many seconds between CI refreshing Session Information
|
*/
$config['sess_cookie_name']		= 'ci_session';
$config['sess_expiration']		= 7200;
$config['sess_expire_on_close']	= FALSE;
$config['sess_encrypt_cookie']	= FALSE;
$config['sess_use_database']	= TRUE;
$config['sess_table_name']		= 'ci_sessions';
$config['sess_match_ip']		= FALSE;
$config['sess_match_useragent']	= TRUE;
$config['sess_time_to_update']	= 300;

/*
|--------------------------------------------------------------------------
| Cookie Related Variables
|--------------------------------------------------------------------------
|
| 'cookie_prefix' = Set a prefix if you need to avoid collisions
| 'cookie_domain' = Set to .your-domain.com for site-wide cookies
| 'cookie_path'   =  Typically will be a forward slash
| 'cookie_secure' =  Cookies will only be set if a secure HTTPS connection exists.
|
*/
$config['cookie_prefix']	= "";
$config['cookie_domain']	= "";
$config['cookie_path']		= "/";
$config['cookie_secure']	= FALSE;

/*
|--------------------------------------------------------------------------
| Global XSS Filtering
|--------------------------------------------------------------------------
|
| Determines whether the XSS filter is always active when GET, POST or
| COOKIE data is encountered
|
*/
$config['global_xss_filtering'] = FALSE;

/*
|--------------------------------------------------------------------------
| Cross Site Request Forgery
|--------------------------------------------------------------------------
| Enables a CSRF cookie token to be set. When set to TRUE, token will be
| checked on a submitted form. If you are accepting user data, it is strongly
| recommended CSRF protection be enabled.
|
| 'csrf_token_name' = The token name
| 'csrf_cookie_name' = The cookie name
| 'csrf_expire' = The number in seconds the token should expire.
*/
$config['csrf_protection'] = FALSE;
$config['csrf_token_name'] = 'csrf_test_name';
$config['csrf_cookie_name'] = 'csrf_cookie_name';
$config['csrf_expire'] = 7200;

/*
|--------------------------------------------------------------------------
| Output Compression
|--------------------------------------------------------------------------
|
| Enables Gzip output compression for faster page loads.  When enabled,
| the output class will test whether your server supports Gzip.
| Even if it does, however, not all browsers support compression
| so enable only if you are reasonably sure your visitors can handle it.
|
| VERY IMPORTANT:  If you are getting a blank page when compression is enabled it
| means you are prematurely outputting something to your browser. It could
| even be a line of whitespace at the end of one of your scripts.  For
| compression to work, nothing can be sent before the output buffer is called
| by the output class.  Do not 'echo' any values with compression enabled.
|
*/
$config['compress_output'] = FALSE;

/*
|--------------------------------------------------------------------------
| Master Time Reference
|--------------------------------------------------------------------------
|
| Options are 'local' or 'gmt'.  This pref tells the system whether to use
| your server's local time as the master 'now' reference, or convert it to
| GMT.  See the 'date helper' page of the user guide for information
| regarding date handling.
|
*/
$config['time_reference'] = 'local';


/*
|--------------------------------------------------------------------------
| Rewrite PHP Short Tags
|--------------------------------------------------------------------------
|
| If your PHP installation does not have short tag support enabled CI
| can rewrite the tags on-the-fly, enabling you to utilize that syntax
| in your view files.  Options are TRUE or FALSE (boolean)
|
*/
$config['rewrite_short_tags'] = FALSE;


/*
|--------------------------------------------------------------------------
| Reverse Proxy IPs
|--------------------------------------------------------------------------
|
| If your server is behind a reverse proxy, you must whitelist the proxy IP
| addresses from which CodeIgniter should trust the HTTP_X_FORWARDED_FOR
| header in order to properly identify the visitor's IP address.
| Comma-delimited, e.g. '10.0.1.200,10.0.1.201'
|
*/
$config['proxy_ips'] = '';


/* End of file config.php */
/* Location: ./application/config/config.php */
