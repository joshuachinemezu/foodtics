<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Installer extends CI_Controller
{

 public function __construct()
 {
  parent::__construct();
  $this->load->library("cors");
  $this->load->model('installer_model');
  // var_dump($this->data);exit;
 }

 public function register()
 {
  $this->cors->accept();

  $json = file_get_contents('php://input');
  $obj = json_decode($json);
  $category = strip_tags($obj->category);
  $key = strip_tags($obj->key);
  $fullName = strip_tags($obj->fullName);
  $companyName = strip_tags($obj->companyName);
  $homeAddress = strip_tags($obj->homeAddress);
  $service = $obj->service;
  $mobileNumber = strip_tags($obj->mobileNumber);
  $email = strip_tags($obj->email);
  $password = strip_tags($obj->password);

//   $this->view->render(count($service));

  if ($key == "create" && $category == "installer") {

   if ($fullName == "" || $email == "" || $mobileNumber == "" || $password == "") {
    $res = array(
     'status' => 'error',
     'code' => 1,
    );
    $this->view->render($res);
   }

   $email_exist = $this->installer_model->check_email_exists($email);
   if (!$email_exist) {
    $res = array(
     'status' => 'error',
     'code' => 2,
    );
    $this->view->render($res);
   }

   $user_hash = strtoupper(substr(md5(rand()), 0, 10));
   $status_hash = strtoupper(substr(md5(rand()), 0, 5));
   $register = $this->installer_model->register($fullName, $companyName, $homeAddress, $service, $email, $mobileNumber, $password, $user_hash, $status_hash);
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
     'code' => 0,
    );
    $this->view->render($res);
   }

  }
 }

}
