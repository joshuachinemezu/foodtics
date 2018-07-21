<?php
class Pages extends CI_Controller
{

 private $btc;
 private $eth;
 private $bch;

 public function __construct()
 {
  parent::__construct();
  // $this->load->library("flash");
  // var_dump($this->data);exit;
 }

 public function index($page = 'index')
 {
  if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
   show_404();
  }

  $this->load->view('pages/' . $page);
 }
}
