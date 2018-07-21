<?php
class Sreq_model extends CI_Model
{

 public function __construct()
 {
  parent::__construct();
 }

 public function register($fullname, $email, $mobileNumber, $password, $user_hash, $status_hash)
 {
  // User data array
  $options = [
   'cost' => 8,
  ];
  $password_hash = password_hash($password, PASSWORD_BCRYPT, $options);

  // Insert data for acccount table
  $account = array(
   'account_fullname' => $fullname,
   'account_email' => $email,
   'account_password' => $password_hash,
   'account_phoneNumber' => $mobileNumber,
   'account_hash' => $user_hash,
   'account_type' => 'sreq',
  );

  if ($this->db->insert('account', $account)) {

   $data = array(
    'status_account_id' => $this->db->insert_id(),
    'status_account_hash' => $user_hash,
    'status_hash' => $status_hash,
   );

   $sreq = array(
    'sreq_account_id' => $this->db->insert_id(),
   );
  } else {
   $msg = $this->flash->error('Error in regsitration');
   // redirect('users/user_reg/'.$this->session__get('type'));
  }

  // Insert user
  $this->db->insert('status', $data);
  return $this->db->insert('sreq', $sreq);
 }

 // Check username exists
 public function check_username_exists($username)
 {
  $query = $this->db->get_where('users', array('username' => $username));
  if (empty($query->row_array())) {
   return true;
  } else {
   return false;
  }
 }

 // Check email exists
 public function check_email_exists($email)
 {
  $query = $this->db->get_where('account', array('account_email' => $email));
  if (empty($query->row_array())) {
   return true;
  } else {
   return false;
  }
 }

 // Check whether user has uploaded and image or not uploaded a verify image
 public function check_verify()
 {
  $user_id = $this->session->userdata('user_id');
  $query = $this->db->get_where('verify', array('verify_user_id' => $user_id, 'verify_reject' => 0));
  return $query->result();
 }

 // activate user
 public function activate($user_hash, $status_hash)
 {

  $query = $this->db->get_where('status', array('status_user_hash' => $user_hash, 'status_hash' => $status_hash));
  if (empty($query->row_array())) {
   return false;
  } else {
   // update data for user table
   $data = array(
    'status_status' => 1,
   );
   // update user
   $this->db->where(array('status_user_hash' => $user_hash, 'status_hash' => $status_hash));
   return $this->db->update('status', $data);
  }
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
