<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Flash {

      protected $CI;
  /**
    * Manage __construct
    *
    * @return Response
   */
   public function __construct() { 
      $this->CI =& get_instance();
      $this->CI->load->library('session');
   }


/**
    * Get All Data from this method.
    *
    * @return Response
   */
public function success($msg)
{
      $this->CI->session->set_flashdata('success', $msg);
      // return $this->CI->load->view('myPages.php');
      return true;
}


  /**
    * Get All Data from this method.
    *
    * @return Response
   */
  public function error($msg)
  {
      $this->CI->session->set_flashdata('error', $msg);
      // return $this->CI->load->view('myPages');
      return true;
  }

  public function ehy()
  {
    return 'Hello';
  }


  /**
    * Get All Data from this method.
    *
    * @return Response
   */
  public function warning($message)
  {
      $this->CI->session->set_flashdata('warning', $message);
      // return $this->CI->load->view('myPages.php');
      return true;
  }


  /**
    * Get All Data from this method.
    *
    * @return Response
   */
  public function info()
  {
      $this->session->set_flashdata('info', 'User listed bellow');
      // return $this->CI->load->view('myPages');
      return true;
  }


}