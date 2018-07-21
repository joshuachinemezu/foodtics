<?php
defined('BASEPATH') or exit('No direct script access allowed');

class View
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
 }

/**
 * Get All Data from this method.
 *
 * @return Response
 */

 public function render($array, $exit = '1', $header = '200', $http_header = '')
 {

  http_response_code($header);

  if ($http_header != '') {
   header($http_header);
  }

  echo json_encode($array);
  if ($exit != '0') {
   exit;
  }
 }

}
