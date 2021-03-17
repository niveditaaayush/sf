<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MX_Controller {
    
    public $current_url;
        
    public function __construct() {
        parent::__construct();
        $this->load->model('admin_model');
        $this->current_url = base_url('superadmin/login');
    }

    public function index() {
        login_check('superadmin', FALSE);
        if ($this->input->post('submit') && $this->input->post('submit') == 'Login') {
            $this->loginCheck();
        } else {
            $this->load->view('login');
        }
    }

    private function loginCheck() {

        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email address', 'trim|required|valid_email|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
        if ($this->form_validation->run() === FALSE) {
            //$this->index();
            $this->load->view('login');

        } else {
            $emailId = $this->input->post('email');
            $password = $this->input->post('password');
            $check = $this->admin_model->getAdminInfo(array('email' => $emailId));
            if (@sizeof($check) == 1) {
                if($check->type != 'superadmin'){
                    $this->session->set_flashdata('error', 'Your not super admin, Please login the admin panel');
                    redirect($this->current_url);
                }
                if($check->status == 0){
                    $this->session->set_flashdata('error', 'Your account as inactive, Please contact higher officials.');
                    redirect($this->current_url);
                }
                if (verifyPassword($password, $check->password)) {
                    $sess_array = array('ID' => encode(session_id()), 'loginID' => encode($check->id), 'userName' => encode($check->userName), 'lastLogin' => DATETIME);
                    $this->session->set_userdata('adminlogged_in', $sess_array);
                    redirect('superadmin/dashboard');
                } else {
                    $this->session->set_flashdata('password', 'Please provide a valid password');
                    redirect($this->current_url);
                }
            } else {
                $this->session->set_flashdata('email', 'Please provide a valid email');
                redirect($this->current_url);
            }
        }
    }

    public function logout() {
        login_check('superadmin', TRUE);
        $this->session->unset_userdata('adminlogged_in');
        $this->session->sess_destroy();
        //delete_cookie('vmssession');
        $this->db->cache_delete_all();
        redirect($this->current_url);
    }
}
