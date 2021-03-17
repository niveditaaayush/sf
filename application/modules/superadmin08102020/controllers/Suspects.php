<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suspects extends MX_Controller {
    
    public $current_url;
    public $session_data;

    function __construct() {
        parent::__construct();
        login_check('superadmin', TRUE);
        $this->session_data = get_session_data();
        $this->load->model('suspect_model');
        $this->current_url = base_url('superadmin/suspects');
    }

    public function index() {
        if($this->input->post('submit') == 'addSuspect'){
            $this->add();
        } else {
            $data['suspects'] = $this->suspect_model->getAllSuspectInfo();
            $this->load->view('suspects', $data);
        }
    }
    
    private function add() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'trim|xss_clean');
        $this->form_validation->set_rules('id_proof_type', 'ID Proof Type', 'trim|xss_clean');
        $this->form_validation->set_rules('id_number', 'ID Number', 'trim|xss_clean');
        $this->form_validation->set_rules('vehicle_number', 'Vehicle Number', 'trim|xss_clean');
        if ($this->form_validation->run() === FALSE) {
            $this->index();
        } else {

            $filename = NULL;
            if ( ! empty($_FILES['userfile']['name'])) {
                $filename = time().clear_string($_FILES['userfile']['name']);
                $tmpname = $_FILES['userfile']['tmp_name'];
                $photo = $this->suspect_model->upload_image($filename, $tmpname);
            }
          
            $params = array(
                'name' => $this->input->post('name'),
                'idProofType' => $this->input->post('id_proof_type'),
                'idNumber' => $this->input->post('id_number'),
                'vehicleNumber' => $this->input->post('vehicle_number'),
                'photo' => $photo,
                'createdBy' => decode($this->session_data['loginID']),
                'createdOn' => DATETIME
            );
           
            $storeSuspectInfo = $this->suspect_model->storeSuspectInfo($params);
            if ($storeSuspectInfo) {
                $this->session->set_flashdata('success', 'Suspect added successfully!');
                redirect($this->current_url);
            } else {
                if(! is_null($filename)){
                    $this->suspect_model->delete_image($filename);
                }
                $this->session->set_flashdata('error', 'Unable to add suspect.');
                redirect($this->current_url);
            }
        }
    }
    
//    public function edit($id = null) {
//        
//        if($this->input->post('submit') == 'updateSuspect'){
//            $this->update($id);
//        } else {
//            $aWhere = array('id' => base64_decode($id));
//            $data['suspect'] = $this->suspect_model->getSuspectInfo($aWhere);
//            if(@sizeof($data['suspect']) == 0){
//                $this->session->set_flashdata('error', 'Invalid suspect found');
//                redirect($this->current_url);
//            }
//            $this->load->view('edit_suspect', $data);
//        }
//        
//    }
    
    public function update($id = null) {
        
        if(! valid_number(base64_decode($id))){
            $this->session->set_flashdata('error', 'Invalid suspect id found');
            redirect($this->current_url);
        }

        if($this->input->post('submit') == 'updateSuspect'){

            $aWhere = array('id' => base64_decode($id));
            $suspect = $this->suspect_model->getSuspectInfo($aWhere);
            if(@sizeof($suspect) == 0){
                $this->session->set_flashdata('error', 'Invalid suspect found');
                redirect($this->current_url);
            }

            $filename = NULL;
            if ( ! empty($_FILES['userfile']['name'])) {
                $filename = time().clear_string($_FILES['userfile']['name']);
                $tmpname = $_FILES['userfile']['tmp_name'];
                $photo = $this->suspect_model->upload_image($filename, $tmpname);
            } else {
                $suspect->photo;
            }

            $params = array(
                'name' => $this->input->post('name'),
                'idProofType' => $this->input->post('id_proof_type'),
                'idNumber' => $this->input->post('id_number'),
                'vehicleNumber' => $this->input->post('vehicle_number'),
                'photo' => $photo,
                'createdBy' => decode($this->session_data['loginID']),
                'createdOn' => DATETIME
            );
           
            $updateSuspectInfo = $this->suspect_model->updateSuspectInfo($params, $aWhere);
            if ($updateSuspectInfo) {
                if(! is_null($filename)){
                    $this->suspect_model->delete_image($suspect->photo);
                }
                $this->session->set_flashdata('success', 'Suspect updated successfully!');
                redirect($this->current_url);
            } else {
                $this->suspect_model->delete_image($filename);
                $this->session->set_flashdata('error', 'Unable to update the suspect.');
                redirect($this->current_url);
            }
        } else {
            $this->session->set_flashdata('error', 'Invalid form submit.');
            redirect($this->current_url);
        }
    }
    
    public function delete($id = null) {
        if(! valid_number(base64_decode($id))){
            $this->session->set_flashdata('error', 'Invalid suspect id found');
            redirect($this->current_url);
        }
        $aWhere = array('id' => base64_decode($id));
        $suspect = $this->suspect_model->getSuspectInfo($aWhere);
        if(@sizeof($suspect) == 0){
            $this->session->set_flashdata('error', 'Invalid suspect found');
            redirect($this->current_url);
        }
        $del = $this->suspect_model->deleteSuspectInfo($aWhere);
        if ($del) {
            if(! is_null($suspect->photo)){
                $this->suspect_model->delete_image($suspect->photo);
            }
            $this->session->set_flashdata('success', 'Suspect deleted successfully!');
            redirect($this->current_url);
        } else {
            $this->session->set_flashdata('error', 'Unable to delete the suspect.');
            redirect($this->current_url);
        }
    }
}
