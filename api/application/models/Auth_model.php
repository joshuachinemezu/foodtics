<?php
class Auth_model extends CI_Model
{

 public function __construct()
 {
  parent::__construct();
 }

 // Log user in
 public function login($user_email, $user_password)
 {
  // Validate
  // password_verify($password,$user['password'])
  $this->db->where('account_email', $user_email);
  $this->db->limit(1);

  $result = $this->db->get('account');

  if ($result->num_rows() == 1) {
   if (password_verify($user_password, $result->result()[0]->account_password)) {
    $res = $result->result();
   } else {
    $res = false;
   }
  } else {
   $res = false;
  }

  return $res;
 }

 // Verify user
 public function verify($image)
 {

  // Insert data for acccount table
  $data = array(
   'verify_user_id' => $this->session->userdata('user_id'),
   'verify_img' => $image,
   'verify_mode' => $this->input->post('mode'),
  );
  // Insert user
  return $this->db->insert('verify', $data);
 }

 // Check whether user has uploaded and image or not uploaded a verify image
 public function check_verify()
 {
  $user_id = $this->session->userdata('user_id');
  $query = $this->db->get_where('verify', array('verify_user_id' => $user_id, 'verify_reject' => 0));
  return $query->result();
 }

 // Read data from database to show data in admin page
 public function read_user_information($username)
 {

  $condition = "user_name =" . "'" . $username . "'";
  $this->db->select('*');
  $this->db->from('user');
  $this->db->where($condition);
  $this->db->limit(1);
  $query = $this->db->get();

  if ($query->num_rows() == 1) {
   return $query->result();
  } else {
   return false;
  }
 }
}
