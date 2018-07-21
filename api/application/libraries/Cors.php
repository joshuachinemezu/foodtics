<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cors
{

 protected $CI;
 /**
  * Manage __construct
  *
  * @return Response
  */
 public function __construct()
 {
  $this->CI = &get_instance();
  $this->CI->load->helper('url');

//   $this->CI->load->library('session');
 }

/**
 * Get All Data from this method.
 *
 * @return Response
 */
 public function accept($method)
 {
  if ($_SERVER['REQUEST_METHOD'] != $method) {
   return false;
  }
  //http://stackoverflow.com/questions/18382740/cors-not-working-php
  if (isset($_SERVER['HTTP_ORIGIN'])) {
   header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
   header('Access-Control-Allow-Credentials: true');
   header('Access-Control-Max-Age: 86400'); // cache for 1 day
  }

  // Access-Control headers are received during OPTIONS requests
  // if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

  if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
   header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
  }

  if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
   header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
  }

  exit(0);

 }

}
