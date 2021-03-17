<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MX_Controller {
    
    public $current_url;
        
    public function __construct() {
        parent::__construct();
        $this->load->model('admin_model');
        $this->current_url = base_url('admin/login');
    }

    public function index() {
        login_check('admin', FALSE);
        if ($this->input->post('submit') && $this->input->post('submit') == 'sendOTP') {
            $this->sendOTP();
        } else {
            $this->load->view('login');
        }
    }
    
    public function sendOTP() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('phone_number', 'Phone Number', 'trim|required|numeric|xss_clean');
        if ($this->form_validation->run() === FALSE) {
            unset($_POST['submit']);
            //$this->index();
            $this->load->view('login');
        } else {
            $phone_number = $this->input->post('phone_number');
            $aWhere = array('phoneNumber' => $phone_number, 'type' => 'admin');
            $check = $this->admin_model->getAdminInfo($aWhere);
            if (@sizeof($check) == 1) {
                if($check->status != 1){
                    $this->session->set_flashdata('phone_number', 'Your account disabled, please contact administrator.');
                    redirect($this->current_url);
                }
                $otp = uniqueotp();
                $params = array(
                    'otp' => $otp,
                    'updateOn' => DATETIME
                    );
                
                $update = $this->admin_model->updateAdminInfo($params, $aWhere);
                if($update){
                    $smsParams = array(
                        'to' => $phone_number,
                        'message' => $otp . ' is your verification code for VMS'
                    );
                    $sendSMS = $this->admin_model->sendSMS($smsParams);
                    if (valid_number($sendSMS->JobId) && $sendSMS->NoOfSMS == 1) {
                        $this->session->set_flashdata('success', 'Please check your phone and enter the OTP.');
                        redirect($this->current_url.'/otp/'. base64_encode($check->id));
                    } else {
                        $this->session->set_flashdata('phone_number', 'Something went wrong please try again later.');
                        redirect($this->current_url);
                    }
                } else {
                    $this->session->set_flashdata('phone_number', 'Something went wrong please try again later.');
                    redirect($this->current_url);
                }
            } else {
                $this->session->set_flashdata('phone_number', 'User not found with this phone number');
                redirect($this->current_url);
            }
        }
    }
    
    public function otp($id = null) {
        if(! valid_number(base64_decode($id))){
            $this->session->set_flashdata('phone_number', 'Invalid login attempt found.');
            redirect($this->current_url);
        }
        if($this->input->post('submit') == 'validateOTP'){
            $this->loginCheck($id);
        }
        $aWhere = array('id' => base64_decode($id), 'type' => 'admin');
        $data['user'] = $this->admin_model->getAdminInfo($aWhere);
        if(@sizeof($data['user']) == 0){
            $this->session->set_flashdata('phone_number', 'User not found with this phone number');
            redirect($this->current_url);
        }
        $this->load->view('otp', $data);
    }

    private function loginCheck($id) {

        $this->load->library('form_validation');
        $this->form_validation->set_rules('otp', 'OTP', 'trim|required|numeric|xss_clean');
        if ($this->form_validation->run() === FALSE) {
            unset($_POST['submit']);
            $this->otp($id);
        } else {
            $otp = $this->input->post('otp');
            $check = $this->admin_model->getAdminInfo(array('id' => base64_decode($id)));
            if (@sizeof($check) == 1) {
                if ($otp == $check->otp) {
                    $sess_array = array('ID' => encode(session_id()), 'loginID' => encode($check->id), 'name' => encode($check->name), 'lastLogin' => DATETIME);
                    $this->session->set_userdata('logged_in', $sess_array);
                    redirect('admin/dashboard');
                } else {
                    $this->session->set_flashdata('error', 'Please enter valid OTP');
                    redirect($this->current_url.'/otp/'.$id);
                }
            } else {
                $this->session->set_flashdata('error', 'Invalid login attempt found.');
                redirect($this->current_url);
            }
        }
    }

    public function logout() {
        login_check('admin', TRUE);
        $this->session->unset_userdata('logged_in');
        $this->session->sess_destroy();
        //delete_cookie('vmssession');
        $this->db->cache_delete_all();
        redirect($this->current_url);
    }
}
