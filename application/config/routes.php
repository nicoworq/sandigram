<?php

defined('BASEPATH') OR exit('No direct script access allowed');

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
  |	https://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There are three reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router which controller/method to use if those
  | provided in the URL cannot be matched to a valid route.
  |
  |	$route['translate_uri_dashes'] = FALSE;
  |
  | This is not exactly a route, but allows you to automatically route
  | controller and method names that contain dashes. '-' isn't a valid
  | class or method name character, so it requires translation.
  | When you set this option to TRUE, it will replace ALL dashes in the
  | controller and method URI segments.
  |
  | Examples:	my-controller/index	-> my_controller/index
  |		my-controller/my-method	-> my_controller/my_method
 */
$route['default_controller'] = 'posts';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


// Listado rutas FRONTEND

$route['login'] = 'login';
$route['login-action'] = 'login/login_action';

//CUENTAS
$route['accounts'] = 'accounts';
$route['accounts/select-account/(:num)'] = 'accounts/select_account/$1';
$route['accounts/new-account'] = 'accounts/new_account';
$route['accounts/new-account-action'] = 'accounts/new_account_action';


//DASHBOARD
$route['dashboard'] = 'dashboard';


//POSTS
$route['posts'] = "posts";
$route['posts/(:num)'] = "posts/edit_post/$1";
$route['posts/edit-post-action'] = "posts/edit_post_action";

$route['posts/new-post'] = "posts/new_post";
$route['posts/new-post-action'] = "posts/new_post_action";
$route['posts/delete-post/(:num)'] = "posts/delete_post_action/$1";

//USERS

$route['users'] = "users";
$route['users/(:num)'] = "users/edit_user/$1";
$route['users/new'] = "users/new_user";
$route['users/new-user-action'] = "users/new_user_action";
$route['users/edit-user-action'] = "users/edit_user_action";




//LOGOUT
$route['logout'] = 'logout';


//MEDIA
$route['media'] = "media";

// AJAX
$route['media/upload_file'] = "media/upload_file";

//AJAX SERVICIO LAST SEEN
$route['service/last_seen'] = "service/is_service_active";


