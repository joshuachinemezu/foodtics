<?php
class Installer_model extends CI_Model
{

 public function __construct()
 {
  parent::__construct();
 }

 public function register($fullName, $companyName, $homeAddress, $service, $email, $mobileNumber, $password, $user_hash, $status_hash)
 {
  // User data array
  $options = [
   'cost' => 8,
  ];
  $password_hash = password_hash($password, PASSWORD_BCRYPT, $options);

  // Insert data for acccount table
  $account = array(
   'account_fullname' => $fullName,
   'account_email' => $email,
   'account_password' => $password_hash,
   'account_phoneNumber' => $mobileNumber,
   'account_hash' => $user_hash,
   'account_type' => 'installer',
  );

  if ($this->db->insert('account', $account)) {
   $user_id = $this->db->insert_id();

   $data = array(
    'status_account_id' => $user_id,
    'status_account_hash' => $user_hash,
    'status_hash' => $status_hash,
   );

   $installer = array(
    'installer_account_id' => $user_id,
    'installer_companyName' => $companyName,
    'installer_address' => $homeAddress,
   );

   // Check if installer added a service
   if (count($service) > 0) {
    // Iterate over the elements of the installer's service
    for ($i = 0; $i < count($service); $i++) {
     $installerService = array(
      'service_account_id' => $user_id,
      'service_name' => $service[$i],
     );

     $this->db->insert('service', $installerService);

    }
   }
  } else {
   $msg = $this->flash->error('Error in regsitration');
   // redirect('users/user_reg/'.$this->session__get('type'));
  }

  // Insert user
  $this->db->insert('status', $data);
  return $this->db->insert('installer', $installer);
 }

 // Log user in
 public function login($user_email, $user_password)
 {
  // Validate
  // password_verify($password,$user['password'])
  $this->db->where('user_email', $user_email);
  $this->db->limit(1);

  $result = $this->db->get('user');

  if ($result->num_rows() == 1) {
   if (password_verify($user_password, $result->result()[0]->user_password)) {
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

 public function purchase($invoice)
 {

  // Insert data for acccount table
  $data = array(
   'buy_user_id' => $this->session->userdata('user_id'),
   'buy_amount' => $this->input->post('amount'),
   'buy_method' => $this->input->post('method'),
   'buy_wallet' => $this->input->post('wallet_id'),
   'buy_invoice' => $invoice,
  );
  // Insert user
  return $this->db->insert('buy', $data);
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
