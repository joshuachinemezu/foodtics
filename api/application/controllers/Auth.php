<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

 public function __construct()
 {
  parent::__construct();
  $this->load->library("cors");
  $this->load->model('auth_model');
  $this->load->helper('url');
  // var_dump($this->data);exit;
 }

 public function register()
 {
  $method = $this->cors->accept('POST');

  if (!$method) {
   $res = array(
    'status' => 'error',
    'msg'    => "Method should be post",
   );
   $this->view->render($res);
  }

  $json         = file_get_contents('php://input');
  $obj          = json_decode($json);
  $category     = strip_tags($obj->category);
  $key          = strip_tags($obj->key);
  $fullName     = strip_tags($obj->fullName);
  $mobileNumber = strip_tags($obj->mobileNumber);
  $email        = strip_tags($obj->email);
  $password     = strip_tags($obj->password);

  if ($key == "create" && $category == "sreq") {

   if ($fullName == "" || $email == "" || $mobileNumber == "" || $password == "") {
    $res = array(
     'status' => 'error',
     'code'   => 1,
    );
    $this->view->render($res);
   }

   $email_exist = $this->sreq_model->check_email_exists($email);
   if (!$email_exist) {
    $res = array(
     'status' => 'error',
     'code'   => 2,
    );
    $this->view->render($res);
   }

   $user_hash   = strtoupper(substr(md5(rand()), 0, 10));
   $status_hash = strtoupper(substr(md5(rand()), 0, 5));
   $register    = $this->sreq_model->register($fullName, $email, $mobileNumber, $password, $user_hash, $status_hash);
   if ($register) {
    // Send email to user
    // $this->load->library('email');

    // $this->email->from('support@solarshopnigeria.com', 'Admin');
    // $this->email->to($email);
    // $this->email->cc('admin@solarshopnigeria.com');
    // $this->email->bcc('postman@solarshopnigeria.com');

    // $this->email->subject('Verification Link');
    // $this->email->message('Hello your account has been successfully created on Solarpor \n Click the link below to verify your account \n ' . base_url() . '/' . $user_hash . '/' . $status_hash);

    // $this->email->send();

    $res = array(
     'status' => 'success',
     'code'   => 0,
    );
    $this->view->render($res);
   }

  }
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
