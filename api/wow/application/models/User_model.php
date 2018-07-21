<?php
	class User_model extends CI_Model{

		function __construct() {
			parent::__construct();
		}

		public function register($enc_password){
			// User data array
			$data = array(
				'user_fullname' => $this->input->post('user_fullname'),
				'user_email' => $this->input->post('user_email'),
                'user_password' => $enc_password,
                'user_phone' => $this->input->post('user_phone'),
                'user_address' => $this->input->post('user_address'),
                'user_facebook' => $this->input->post('user_facebook'),
                'user_twitter' => $this->input->post('user_twitter'),
                'user_instagram' => $this->input->post('user_instagram'),
			);

			// Insert user
			return $this->db->insert('user', $data);
		}

		// Log user in
		public function login($user_email, $user_password){
			// Validate
			$this->db->where('user_email', $user_email);
			$this->db->where('user_password', $user_password);

			$result = $this->db->get('user');

			if($result->num_rows() == 1){
				return true;
			} else {
				return false;
			}
		}

		// Check username exists
		public function check_username_exists($username){
			$query = $this->db->get_where('users', array('username' => $username));
			if(empty($query->row_array())){
				return true;
			} else {
				return false;
			}
		}

		// Check email exists
		public function check_email_exists($email){
			$query = $this->db->get_where('users', array('email' => $email));
			if(empty($query->row_array())){
				return true;
			} else {
				return false;
			}
		}

		// Read data from database to show data in admin page
		public function read_user_information($username) {

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