<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MX_Controller {

    public $current_url;
    public $session_data;
    public $CI;

    function __construct() {
        parent::__construct();
        login_check('superadmin', TRUE);
        $this->session_data = get_session_data();
        $this->load->model('admin_model');
        $this->load->model('accommodations_model');
        $this->load->library('form_validation');
        $this->current_url = base_url('superadmin/users');
    }

    public function index() {
        $aWhere = array('status' => 1, 'type' => 'admin');
        $data['admins'] = $this->admin_model->getAllAdminsInfo($aWhere);
        $this->load->view('users', $data);
    }

    public function check_phoneNumber($str = null) {
        $id = $this->input->post('recordId');
        if (valid_base64($id) && preg_match(NUMBER, base64_decode($id))) {
            $aWhere = array('id !=' => base64_decode($id), 'phoneNumber' => $str);
        } else {
            $aWhere = array('phoneNumber' => $str);
        }
        $check = $this->admin_model->getAdminInfo($aWhere);
        if ($check != 0) {
            $this->form_validation->set_message('check_phoneNumber', 'The phone number already exist');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function check_email($str = null) {
        $id = $this->input->post('recordId');
        if (valid_base64($id) && preg_match(NUMBER, base64_decode($id))) {
            $aWhere = array('id !=' => base64_decode($id), 'email' => $str);
        } else {
            $aWhere = array('email' => $str);
        }
        $check = $this->admin_model->getAdminInfo($aWhere);
        if ($check != 0) {
            $this->form_validation->set_message('check_email', 'The email id already exist');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function add() {
        if ($this->input->post('submit') == 'addUser') {
            $this->createUser();
        } else {
            $data['cities'] = $this->accommodations_model->getAllCities();
            $this->load->view('add_user', $data);
        }
    }

    private function createUser() {
        $this->form_validation->set_rules('user_name', 'User Name', 'trim|required|alpha_numeric_spaces|min_length[2]|max_length[30]|xss_clean');
        $this->form_validation->set_rules('email', 'Email Id', 'trim|required|valid_email|is_unique[vms19_administration.email]|xss_clean');
        $this->form_validation->set_rules('phone_number', 'Phone Number', 'trim|required|is_unique[vms19_administration.phoneNumber]|xss_clean');
        $this->form_validation->set_rules('district', 'District', 'trim|required|xss_clean');
        $this->form_validation->set_rules('zone', 'Zone', 'trim|xss_clean');
        $this->form_validation->set_rules('division', 'Division', 'trim|xss_clean');
        $this->form_validation->set_rules('sho_area', 'SHO Area', 'trim|xss_clean');
        if ($this->form_validation->run($this) == FALSE) {
            unset($_POST['submit']);
            $this->add();
        } else {
            extract($_POST);
            unset($_POST['submit']);
            $params = array(
                'type' => 'admin',
                'userName' => $user_name,
                'email' => $email,
                'phoneNumber' => $phone_number,
                'district' => $district,
                'zone' => $zone,
                'division' => $division,
                'sho_area' => $sho_area,
                'createdOn' => DATETIME
            );
            $insert = $this->admin_model->storeAdminInfo($params);
            if ($insert) {
                $this->session->set_flashdata('success', 'User created successfully.');
                redirect($this->current_url);
            } else {
                $this->session->set_flashdata('error', 'Unable to create user, please try again later.');
                redirect($this->current_url . '/add');
            }
        }
    }

    public function edit($id = null) {
        if ( ! valid_number(base64_decode($id))) {
            $this->session->set_flashdata('error', 'Invalid user id found');
            redirect($this->current_url);
        }
        if ($this->input->post('submit') == 'updateUser') {
            $this->updateUser($id);
        } else {
            $aWhere = array('id' => base64_decode($id));
            $data['cities'] = $this->accommodations_model->getAllCities();
            $data['user'] = $this->admin_model->getAdminInfo($aWhere);
            if (@sizeof($data['user']) == 0) {
                $this->session->set_flashdata('error', 'User record found');
                redirect($this->current_url);
            }
            $this->load->view('edit_user', $data);
        }
    }

    private function updateUser($id) {
        $this->form_validation->set_rules('user_name', 'User Name', 'trim|required|alpha_numeric_spaces|min_length[2]|max_length[30]|xss_clean');
        $this->form_validation->set_rules('email', 'Email Id', 'trim|required|valid_email|xss_clean');
        $this->form_validation->set_rules('phone_number', 'Phone Number', 'trim|required|xss_clean');
        $this->form_validation->set_rules('district', 'District', 'trim|required|xss_clean');
        $this->form_validation->set_rules('zone', 'Zone', 'trim|xss_clean');
        $this->form_validation->set_rules('division', 'Division', 'trim|xss_clean');
        $this->form_validation->set_rules('sho_area', 'SHO Area', 'trim|xss_clean');
        if ($this->form_validation->run($this) == FALSE) {
            unset($_POST['submit']);
            $this->edit($id);
        } else {
            extract($_POST);
            unset($_POST['submit']);
            $params = array(
                'userName' => $user_name,
                'email' => $email,
                'phoneNumber' => $phone_number,
                'district' => $district,
                'zone' => $zone,
                'division' => $division,
                'sho_area' => $sho_area,
                'updateOn' => DATETIME
            );
            $aWhere = array('id' => base64_decode($id));
            $user = $this->admin_model->getAdminInfo($aWhere);
            if (@sizeof($user) == 0) {
                $this->session->set_flashdata('error', 'User record found');
                redirect($this->current_url);
            }
            $update = $this->admin_model->updateAdminInfo($params, $aWhere);
            if ($update) {
                $this->session->set_flashdata('success', 'User updated successfully.');
                redirect($this->current_url);
            } else {
                $this->session->set_flashdata('error', 'Unable to update the user, please try again later.');
                redirect($this->current_url . '/edit/' . $id);
            }
        }
    }

    public function view($id = null) {
        if ( ! valid_number(base64_decode($id))) {
            $this->session->set_flashdata('error', 'Invalid user id found');
            redirect($this->current_url);
        }
        $aWhere = array('id' => base64_decode($id));
        $data['user'] = $this->admin_model->getAdminInfo($aWhere);
        if (@sizeof($data['user']) == 0) {
            $this->session->set_flashdata('error', 'User record found');
            redirect($this->current_url);
        }
        $this->load->view('view_user', $data);
    }

    public function remove($id = null) {
        if ( ! valid_number(base64_decode($id))) {
            $this->session->set_flashdata('error', 'Invalid user id found');
            redirect($this->current_url);
        }
        $aWhere = array('id' => base64_decode($id));
        $user = $this->admin_model->getAdminInfo($aWhere);
        if (@sizeof($user) == 0) {
            $this->session->set_flashdata('error', 'User record found');
            redirect($this->current_url);
        }
        $remove = $this->admin_model->deleteAdminInfo($aWhere);
        if ($remove) {
            $this->session->set_flashdata('success', 'User remove successfully.');
            redirect($this->current_url);
        }
    }

}
