<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

 public function __construct()
 {
  parent::__construct();
  $this->load->library("cors");
  $this->load->model('auth_model');
  // var_dump($this->data);exit;
 }

 public function login()
 {

  $this->cors->accept();

  $json     = file_get_contents('php://input');
  $obj      = json_decode($json);
  $key      = strip_tags($obj->key);
  $email    = strip_tags($obj->email);
  $password = strip_tags($obj->password);

  if ($email == "" || $password == "") {
   $res = array(
    'status' => 'error',
    'code'   => 1,
   );
   $this->view->render($res);
  }

  $user_id = $this->auth_model->login($email, $password);
  if ($user_id) {
   $user_data = array(
    'user_id'   => $user_id[0]->account_id,
    'email'     => $email,
    'logged_in' => true,
   );

   $this->session->set_userdata($user_data);

   $res = array(
    'status' => 'success',
    'code'   => 0,
    'type'   => $user_id[0]->account_type,
   );
   $this->view->render($res);
  } else {
   $res = array(
    'status' => 'success',
    'code'   => 1,
   );
   $this->view->render($res);
  }

 }

 public function getUserBio($accountHash)
 {
  $user_info = $this->auth_model->login($accountHash);

 }

 public function forgot_password()
 {

  $data['title'] = 'Forgot Password';

  $page            = 'forgot_password';
  $data['btc_usd'] = $this->btc;
  $data['eth_usd'] = $this->eth;
  $data['bch_usd'] = $this->bch;

  $this->form_validation->set_rules('email', 'Email', 'required');

  if ($this->form_validation->run() === false) {
   $this->load->view('flash');
   $this->load->view('templates/dash_header', $data);
   $this->load->view('pages/' . $page, $data);
   $this->load->view('templates/dash_footer');
  } else {

   // Set message
   $msg = $this->flash->success('Your change password request was successful');
   redirect('');
  }
 }
}
