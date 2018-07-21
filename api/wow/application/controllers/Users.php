<?php
	class Users extends CI_Controller{
	
			public function login(){
				$page = 'login';
			if(!file_exists(APPPATH.'views/users/'.$page.'.php')){
				// echo $page;
				show_404();
			}

			$data['title'] = 'Sign In';

			$this->form_validation->set_rules('user_email', 'Email', 'trim|required');
			$this->form_validation->set_rules('user_password', 'Password', 'trim|required');

			if($this->form_validation->run() === FALSE){
			$this->load->view('users/'.$page, $data);
			} else {
				
				// Get Email
				$email = $this->input->post('user_email');

				// Get and encrypt the password
				$password = md5($this->input->post('user_password'));

				// Login user
				$user_id = $this->user_model->login($email, $password);

				if($user_id){
					// Create session
					$user_data = array(
						'user_id' => $user_id,
						'email' => $email,
						'logged_in' => true
					);

					$this->session->set_userdata($user_data);

					// Set message
					$this->session->set_flashdata('user_loggedin', 'You are now logged in');

					redirect('dashboard');
				} else {
					// Set message
					$this->session->set_flashdata('login_failed', 'Login is invalid');

					redirect('login');
				}		
			}
		}

		public function forgot_password($page = 'forgot_password'){
			if(!file_exists(APPPATH.'views/users/'.$page.'.php')){
				show_404();
			}

			$data['title'] = ucfirst($page);

			$this->load->view('users/'.$page, $data);
		}

		public function register_as($page = 'register_as'){
			if(!file_exists(APPPATH.'views/users/'.$page.'.php')){
				show_404();
			}

			$data['title'] = ucfirst($page);

			$this->load->view('templates/form_header', $data);
			$this->load->view('users/'.$page, $data);
			$this->load->view('templates/footer');
		}

		public function choose_mode($page = 'choose_mode'){
			if(!file_exists(APPPATH.'views/users/'.$page.'.php')){
				show_404();
			}

			$data['title'] = ucfirst($page);

			$this->load->view('templates/form_header', $data);
			$this->load->view('users/'.$page, $data);
			$this->load->view('templates/footer');
		}

		public function register_sub_vendor($page = 'register_sub_vendor'){
			if(!file_exists(APPPATH.'views/users/'.$page.'.php')){
				show_404();
			}

			$data['title'] = ucfirst($page);

			$this->load->view('templates/form_header', $data);
			$this->load->view('users/'.$page, $data);
			$this->load->view('templates/footer');
		}

		public function user_reg(){

			$data['title'] = 'Sign Up';

			$this->form_validation->set_rules('user_fullname', 'Name', 'required');
			// $this->form_validation->set_rules('username', 'Username', 'required|callback_check_username_exists');
			$this->form_validation->set_rules('user_email', 'Email', 'required');
			$this->form_validation->set_rules('user_password', 'Password', 'required');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'matches[user_password]');
			$this->form_validation->set_rules('user_phone', 'Phone Number');
			$this->form_validation->set_rules('user_address', 'Address');
			$this->form_validation->set_rules('user_facebook', 'Facebook url');
			$this->form_validation->set_rules('user_twitter', 'Twitter url');
			$this->form_validation->set_rules('user_instagram', 'Instagram url');


			if($this->form_validation->run() === FALSE){
				$this->load->view('templates/form_header');
				$this->load->view('users/user_reg', $data);
				$this->load->view('templates/footer');
			} else {
				// Encrypt password
				$enc_password = md5($this->input->post('user_password'));

				$this->user_model->register($enc_password);

				// Set message
				$this->session->set_flashdata('user_registered', 'You are now registered and can log in');

				redirect('users/reg_success');
			}
		}

		public function vendor_reg($page = 'vendor_reg'){
			if(!file_exists(APPPATH.'views/users/'.$page.'.php')){
				show_404();
			}

			$data['title'] = ucfirst($page);

			$this->load->view('templates/form_header', $data);
			$this->load->view('users/'.$page, $data);
			$this->load->view('templates/footer');
		}

		public function reg_success(){
			if(!file_exists(APPPATH.'views/users/reg_success.php')){
				show_404();
			}

			$data['title'] = ucfirst('Regsitration successful');

			$this->load->view('templates/form_header', $data);
			$this->load->view('users/reg_success', $data);
			$this->load->view('templates/footer');
		}
	}