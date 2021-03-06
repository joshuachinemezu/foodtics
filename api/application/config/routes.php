<?php
defined('BASEPATH') or exit('No direct script access allowed');

// General Routes
$route['home']            = 'Pages/index';
$route['login']           = 'Auth/login';
$route['register']        = 'Auth/register';
$route['getUserinfo']     = 'Auth/getUserinfo';
$route['forgot_password'] = 'Pages/forgot_password';
$route['logout']          = 'Pages/logout';
$route['blog']            = 'Pages/blog';

// User Routes

$route['default_controller'] = 'Pages/index';

// $route['categories'] = 'categories/index';
// $route['categories/create'] = 'categories/create';
// $route['categories/posts/(:any)'] = 'categories/posts/$1';

$route['(:any)']               = 'Pages/index';
$route['404_override']         = '';
$route['translate_uri_dashes'] = false;
