<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['create_event'] = 'Pages/create_event';
$route['about'] = 'Pages/about';
$route['how'] = 'Pages/how';
$route['blog'] = 'Pages/blog';
$route['login'] = 'users/login';
$route['register_as'] = 'users/register_as';
$route['users/choose_mode'] = 'users/choose_mode';
$route['vendors/choose_mode'] = 'users/register_sub_vendor';
$route['dashboard'] = 'udash/index';
$route['users/user_reg'] = 'users/user_reg';
$route['users/vendor_reg'] = 'users/vendor_reg';
$route['forgot_password'] = 'users/forgot_password';
$route['users/reg_success'] = 'users/reg_success';
$route['posts/(:any)'] = 'posts/view/$1';
$route['posts'] = 'posts/index';

$route['default_controller'] = 'Pages/index';

// $route['categories'] = 'categories/index';
// $route['categories/create'] = 'categories/create';
// $route['categories/posts/(:any)'] = 'categories/posts/$1';

$route['(:any)'] = 'Dashboard/index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
