<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

 public function __construct()
 {
  parent::__construct();
  $this->load->library("cors");
  $this->load->model('auth_model');
  // var_dump($this->data);exit;
 }

 public function getUserBio($accountHash)
 {
  $user_info = $this->auth_model->login($accountHash);

 }
}
