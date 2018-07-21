<?php
class Pages extends CI_Controller
{

    private $btc;
    private $eth;
    private $bch;

    public function __construct()
    {
        parent::__construct();
        $this->load->library("flash");
        // var_dump($this->data);exit;
    }

    public function index($page = 'home')
    {
        $json= file_get_contents('php://input');
        $obj = json_decode($json);
        $key = strip_tags($obj->key);exit;
        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }
        // var_dump($vendors);exit;

        $data['title'] = ucfirst($page);

        $data['btc_usd'] = $this->btc;
        $data['eth_usd'] = $this->eth;
        $data['bch_usd'] = $this->bch;
        // var_dump($this->data);exit;

        $this->load->view('templates/header', $data);
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer');
    }

    public function makeFav()
    {
        if ($this->session->userdata('logged_in') == null) {
            $res = array(
                'status' => 'error',
                'code' => 1,
            );
            echo json_encode($res);
            exit;
        }

        $id = $_POST['id'];
        $user_id = $this->session->userdata('user_id');
        $vendor = $this->vendor_model->get_vendor_by_id($id);
        $vendor_id = $vendor[0]['vendor_account_id'];

        $create_fav = $this->fav_model->create_fav($user_id, $vendor_id);
        if ($create_fav) {
            $res = array(
                'status' => 'success',
                'code' => 2,
            );
            echo json_encode($res);
            exit;
        }
    }

    public function register($page = 'register')
    {

        if ($this->session->userdata('email') !== null) {
            redirect('dashboard');
        }
        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        if (isset($_POST) && !empty($_POST)) {
            if (!isset($_POST['fullname']) || !isset($_POST['email']) || !isset($_POST['phoneNumber']) || !isset($_POST['password'])) {
                $res = array(
                    'status' => 'error',
                    'code' => 0,
                );
                echo json_encode($res);exit;
            }

            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $phoneNumber = $_POST['phoneNumber'];
            $password = $_POST['password'];

            if ($fullname == "" || $email == "" || $phoneNumber == "" || $password == "") {
                $res = array(
                    'status' => 'error',
                    'code' => 1,
                );
                echo json_encode($res);exit;
            }

            $email_exist = $this->user_model->check_email_exists($email);
            if (!$email_exist) {
                $res = array(
                    'status' => 'error',
                    'code' => 2,
                );
                echo json_encode($res);exit;
            }

            $user_hash = strtoupper(substr(md5(rand()), 0, 10));
            $status_hash = strtoupper(substr(md5(rand()), 0, 5));
            $register = $this->user_model->register($fullname, $email, $phoneNumber, $password, $user_hash, $status_hash);
            if ($register) {
                // Send email to user
                $this->load->library('email');

                $this->email->from('support@thenewbroker.com', 'Admin');
                $this->email->to($email);
                $this->email->cc('admin@thenewbroker.com');
                $this->email->bcc('postman@thenewbroker.com');

                $this->email->subject('Verification Link');
                $this->email->message('Hello your account has been successfully created on The New Broker \n Click the link below to verify your account \n ' . base_url() . '/' . $user_hash . '/' . $status_hash);

                $this->email->send();

                $res = array(
                    'status' => 'success',
                    'code' => 0,
                );
                echo json_encode($res);exit;
            }

        }

        $data['title'] = ucfirst($page);

        $this->load->view('templates/header', $data);
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer');
    }

    public function login($page = 'login')
    {

        if ($this->session->userdata('email') !== null) {
            redirect('dashboard');
        }
        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        if (isset($_POST) && !empty($_POST)) {
            if (!isset($_POST['email']) || !isset($_POST['password'])) {
                $res = array(
                    'status' => 'error',
                    'code' => 0,
                );
                echo json_encode($res);exit;
            }

            $email = $_POST['email'];
            $password = $_POST['password'];

            if ($email == "" || $password == "") {
                $res = array(
                    'status' => 'error',
                    'code' => 1,
                );
                echo json_encode($res);exit;
            }

            $user_id = $this->user_model->login($email, $password);
            if ($user_id) {
                $user_data = array(
                    'user_id' => $user_id[0]->user_id,
                    'email' => $email,
                    'logged_in' => true,
                );

                $this->session->set_userdata($user_data);

                $res = array(
                    'status' => 'success',
                    'code' => 0,
                );
                echo json_encode($res);exit;
            } else {
                $res = array(
                    'status' => 'success',
                    'code' => 1,
                );
                echo json_encode($res);exit;
            }

        }

        $data['title'] = ucfirst($page);
        $this->load->view('flash');

        $this->load->view('templates/header', $data);
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer');
    }

    public function forgot_password()
    {

        $data['title'] = 'Forgot Password';

        $page = 'forgot_password';
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

    public function dashboard($page = 'dashboard')
    {
        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        // var_dump($this->session->userdata('email'));exit;
        // if(empty($this->user_model->check_verify())) {
        //     redirect('verify');
        // }

        $data['btc_usd'] = $this->btc;
        $data['eth_usd'] = $this->eth;
        $data['bch_usd'] = $this->bch;

        if ($this->session->userdata('email') === null) {
            redirect('login');
        }

        $data['title'] = ucfirst($page);

        $this->load->view('flash');
        $this->load->view('templates/dash_header', $data);
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/dash_footer');
    }

    public function success($page = 'success')
    {
        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        // var_dump($this->session->userdata('email'));exit;
        // if(empty($this->user_model->check_verify())) {
        //     redirect('verify');
        // }

        $data['btc_usd'] = $this->btc;
        $data['eth_usd'] = $this->eth;
        $data['bch_usd'] = $this->bch;

        $data['title'] = ucfirst($page);

        $this->load->view('flash');
        $this->load->view('templates/dash_header', $data);
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/dash_footer');
    }

    public function buy($page = 'buy')
    {

        if ($this->session->userdata('email') === null) {
            redirect('login');
        }
        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        $data['btc_usd'] = $this->btc;
        $data['eth_usd'] = $this->eth;
        $data['bch_usd'] = $this->bch;

        $this->form_validation->set_rules('wallet_id', 'Wallet id', 'required');
        $this->form_validation->set_rules('amount', 'Amount', 'required');
        $this->form_validation->set_rules('method', 'Payment method', 'required');

        if ($this->form_validation->run() === true) {
            if (!is_numeric($this->input->post('amount'))) {
                $this->flash->warning('Amount must be a number');
                redirect('buy');
            }

            $invoice = strtoupper(substr(md5(rand()), 0, 10));

            $purchase_info = array(
                'order_invoice' => $invoice,
                'order_method' => $this->input->post('method'),
                'order_amount' => $this->input->post('amount'),
            );

            $this->session->set_userdata($purchase_info);

            $order = $this->user_model->purchase($invoice);

            if ($order) {

                // Set message
                $msg = $this->flash->success('Order placed successfully');
                redirect('order_success');
            }
        }

        $data['title'] = ucfirst($page);

        $this->load->view('flash');
        $this->load->view('templates/dash_header', $data);
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/dash_footer');
    }

    public function order_success($page = 'order_success')
    {
        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        $data['title'] = ucfirst($page);

        $data['btc_usd'] = $this->btc;
        $data['eth_usd'] = $this->eth;
        $data['bch_usd'] = $this->bch;

        $this->load->view('flash');
        $this->load->view('templates/dash_header', $data);
        $this->load->view('pages/' . $page, $data);
        // $this->load->view('templates/dash_footer');
    }

    public function sell($page = 'sell')
    {
        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        $data['title'] = ucfirst($page);

        $this->load->view('flash');
        $this->load->view('templates/dash_header', $data);
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/dash_footer');
    }

    public function verify($page = 'verify')
    {
        if ($this->session->userdata('email') === null) {
            redirect('login');
        }

        if (!empty($this->user_model->check_verify())) {
            redirect('dashboard');
        }
        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        $data['btc_usd'] = $this->btc;
        $data['eth_usd'] = $this->eth;
        $data['bch_usd'] = $this->bch;

        $this->form_validation->set_rules('mode', 'Mode of Verification', 'required');

        if ($this->form_validation->run() === true) {
            if ($_FILES['userfile']['name'] === "") {
                $msg = $this->flash->error('Verification image is required');
                redirect('verify');
            }
            // if(){
            //         $this->flash->error('All fields must not be empty');
            //     header('location: verify');
            // }

            // Upload Image
            $config['upload_path'] = './assets/img/verify';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '2048';
            $config['max_width'] = '2000';
            $config['max_height'] = '2000';

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()) {
                $errors = array('error' => $this->upload->display_errors());
                $post_image = 'noimage.jpg';
            } else {
                $data = array('upload_data' => $this->upload->data());
                $verify_image = $_FILES['userfile']['name'];
            }

            $verify = $this->user_model->verify($verify_image);
            if ($verify) {
                $msg = $this->flash->success('Verification image uploaded');
                redirect('dashboard');

            }

        }

        $data['title'] = ucfirst($page);

        $this->load->view('flash');
        $this->load->view('templates/dash_header', $data);
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/dash_footer');
    }

    public function activate($user_hash, $status_hash)
    {

        // Set message

        $activate = $this->user_model->activate($user_hash, $status_hash);
        if ($activate) {
            $msg = $this->flash->success('User successfully activated');
        } else {
            $msg = $this->flash->error('Error in activating user');
        }

        redirect('success_verify');
    }

    public function logout()
    {
        // Unset user data
        $this->session->unset_userdata('logged_in');
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('email');

        // Set message
        $msg = $this->flash->success('You are now logged out');

        $this->load->view('flash');

        redirect('login');
    }
}
