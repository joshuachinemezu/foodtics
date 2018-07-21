<?php
class Auth_model extends CI_Model
{

 public function __construct()
 {
  parent::__construct();
 }

 public function register($fullname, $email, $purpose, $password, $user_hash)
 {
  // User data array
  $options = [
   'cost' => 8,
  ];
  $password_hash = password_hash($password, PASSWORD_BCRYPT, $options);

  // Insert data for acccount table
  $account = array(
   'account_name'     => $fullname,
   'account_email'    => $email,
   'account_password' => $password_hash,
   'account_hash'     => $user_hash,
   'account_type'     => $purpose,
  );

  if ($this->db->insert('account', $account)) {
   return true;
  } else {
   return false;
   // redirect('users/user_reg/'.$this->session__get('type'));
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
