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
  $method = $this->cors->accept();

//   if (!$method) {
  //    $res = array(
  //     'status' => 'error',
  //     'msg'    => "Method should be post",
  //    );
  //    $this->view->render($res);
  //   }

  if (isset($_POST) && !empty($_POST)) {
   if (!isset($_POST['fullname']) || !isset($_POST['email']) || !isset($_POST['purpose']) || !isset($_POST['password'])) {
    $res = array(
     'status' => 'error',
     'code'   => 0,
    );
    $this->view->render($res);
   }

   $fullname = $_POST['fullname'];
   $email    = $_POST['email'];
   $purpose  = $_POST['purpose'];
   $password = $_POST['password'];
//    echo json_encode($_SERVER['REQUEST_METHOD']);exit;

   $email_exist = $this->auth_model->check_email_exists($email);
   if (!$email_exist) {
    $res = array(
     'status' => 'error',
     'code'   => 2,
    );
    $this->view->render($res);
   }

   $user_hash   = strtoupper(substr(md5(rand()), 0, 10));
   $status_hash = strtoupper(substr(md5(rand()), 0, 5));
   $register    = $this->auth_model->register($fullname, $email, $purpose, $password, $user_hash);

   if ($register) {

    $res = array(
     'status' => 'success',
     'code'   => 0,
    );
    $this->view->render($res);
   }

  }
 }

 public function login($page = 'login')
 {

//   if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
  //    show_404();
  //   }

  $method = $this->cors->accept();

  if (isset($_POST) && !empty($_POST)) {
   if (!isset($_POST['email']) || !isset($_POST['password'])) {
    $res = array(
     'status' => 'error',
     'code'   => 0,
    );
    echo json_encode($res);exit;
   }

   $email    = $_POST['email'];
   $password = $_POST['password'];

   if ($email == "" || $password == "") {
    $res = array(
     'status' => 'error',
     'code'   => 1,
    );
    echo json_encode($res);exit;
   }

   $user_id = $this->auth_model->login($email, $password);
   if ($user_id) {
    // $user_data = array(
    //     'user_id' => $user_id[0]->user_id,
    //     'email' => $email,
    //     'logged_in' => true
    // );

    // $this->session->set_userdata($user_data);

    $res = array(
     'user_hash' => $user_id[0]->account_hash,
     'fullname'  => $user_info[0]->account_name,
     'email'     => $user_info[0]->account_email,
     'status'    => 'success',
     'code'      => 0,
    );
    echo json_encode($res);exit;
   } else {
    $res = array(
     'status' => 'success',
     'code'   => 1,
    );
    $this->view->render($res);

   }

  }

 }

 public function getUserinfo()
 {
  $method = $this->cors->accept();

  $userHash = $_POST['userHash'];

//   echo json_encode($userHash);exit;

  $user_info = $this->auth_model->getUserinfo($userHash);

  if (!$user_info) {
   $res = array(
    'status' => 'error',
    'code'   => 1,
   );
   echo json_encode($res);exit;
  }

  $res = array(
   'status'   => 'success',
   'fullname' => $user_info[0]->account_name,
   'email'    => $user_info[0]->account_email,
   'code'     => 1,
  );
  echo json_encode($res);exit;

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
