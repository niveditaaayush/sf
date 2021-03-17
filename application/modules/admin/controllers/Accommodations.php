<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accommodations extends MX_Controller {
    
    public $current_url;
    public $session_data;

    function __construct() {
        parent::__construct();
        login_check('admin', TRUE);
        $this->session_data = get_session_data();
        $this->load->model('accommodations_model');
        $this->load->model('visitors_model');
        $this->current_url = base_url('admin/accommodations');
    }

    public function index() {
        $data['current_url'] = $this->current_url;
        $data['loginUser'] = loginUser();
        $data['type'] = 'all';
        $params = array(
            'city' => $data['loginUser']->district,
            'zone' => $data['loginUser']->zone,
            'circle' => $data['loginUser']->division,
            'SHOArea' => $data['loginUser']->sho_area
        );
        $data['cities'] = $this->accommodations_model->getAllCities();
        $data['accommodations'] = $this->accommodations_model->getAllAccommodationsWithLiveCheckins($params);
        $this->load->view('accommodations', $data);
    }
    
    public function active() {
        $data['current_url'] = $this->current_url;
        $data['loginUser'] = loginUser();
        $data['type'] = 'active';
        $aWhere = array(
            'city' => $data['loginUser']->district,
            'zone' => $data['loginUser']->zone,
            'circle' => $data['loginUser']->division,
            'SHOArea' => $data['loginUser']->sho_area,
            'status' => 1
        );
        $data['cities'] = $this->accommodations_model->getAllCities();
        $data['accommodations'] = $this->accommodations_model->getAllAccommodationsWithLiveCheckins($aWhere);
        $this->load->view('accommodations', $data);
    }
    
    public function inactive() {
        $data['current_url'] = $this->current_url;
        $data['loginUser'] = loginUser();
        $data['type'] = 'inactive';
        $aWhere = array(
            'city' => $data['loginUser']->district,
            'zone' => $data['loginUser']->zone,
            'circle' => $data['loginUser']->division,
            'SHOArea' => $data['loginUser']->sho_area,
            'status' => 0
        );
        $data['cities'] = $this->accommodations_model->getAllCities();
        $data['accommodations'] = $this->accommodations_model->getAllAccommodationsWithLiveCheckins($aWhere);
        $this->load->view('accommodations', $data);
    }

    public function filter() {
        
        $data['loginUser'] = loginUser();
        $district   = $this->input->get('district') ? $this->input->get('district') : $data['loginUser']->district;
        $zone       = $this->input->get('zone') ? $this->input->get('zone') : $data['loginUser']->zone;
        $circle     = $this->input->get('division') ? $this->input->get('division') : $data['loginUser']->division;
        $sho_area   = $this->input->get('sho_area') ? $this->input->get('sho_area') : $data['loginUser']->sho_area;       
        $params = array(
            'city' => $district,
            'SHOArea' => $sho_area,
            'zone' => $zone,
            'circle' => $circle
        );
        $data['current_url'] = $this->current_url;
        $data['type'] = 'all';
        $data['cities'] = $this->accommodations_model->getAllCities();
        $data['accommodations'] = $this->accommodations_model->getAllAccommodationsWithLiveCheckins($params);
        $this->load->view('accommodations', $data);
    }

    public function profile($id = null) {

        if ( ! valid_number(base64_decode($id))) {
            $this->session->set_flashdata('error', 'Invalid accommodation id found');
            redirect($this->current_url);
        }        
        $aWhere = array('id' => base64_decode($id));
         $data['accommodation'] = $this->accommodations_model->getAccommodationInfo($aWhere);
        if (@sizeof(array($data['accommodation'])) == 0) {
            $this->session->set_flashdata('error', 'Accommodation not found');
            redirect($this->current_url);
        }
        $this->load->view('view_accommodation', $data);
    }

     public function edit($id = null) {

        if ( ! valid_number(base64_decode($id))) {
            $this->session->set_flashdata('error', 'Invalid accommodation id found');
            redirect($this->current_url);
        }
        if ($this->input->post('submit') == 'updateUser') {
            $this->updateUser($id);
        } else {
            $aWhere = array('id' => base64_decode($id));
            $data['cities'] = $this->accommodations_model->getAllCities();            
            $data['accommodation'] = $this->accommodations_model->getAccommodationInfo($aWhere);
            if (@sizeof(array($data['accommodation'])) == 0) {
                $this->session->set_flashdata('error', 'Accommodation not found');
                redirect($this->current_url);
            }
            $this->load->view('edit_accommodation', $data);
        }
    }

    private function updateUser($id) {

        $this->load->library('form_validation');
//        $this->form_validation->set_rules('type', 'Type', 'required|xss_clean');
        $this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
        $this->form_validation->set_rules('address', 'Address', 'required|xss_clean');
        $this->form_validation->set_rules('pincode', 'Pincode', 'required|xss_clean');
//        $this->form_validation->set_rules('phoneNumber', 'Phone Number', 'required|xss_clean');
        $this->form_validation->set_rules('email', 'Email Id', 'required|valid_email|xss_clean');
        $this->form_validation->set_rules('noOfRooms', 'No Of Rooms', 'required|xss_clean');
        $this->form_validation->set_rules('availableHardware', 'available Hardware', 'xss_clean');
        $this->form_validation->set_rules('registrationDate', 'Registration Date', 'xss_clean');
        $this->form_validation->set_rules('grade', 'Grade', 'xss_clean');
        $this->form_validation->set_rules('state', 'State', 'required|xss_clean');
        $this->form_validation->set_rules('country', 'Country', 'required|xss_clean');
        $this->form_validation->set_rules('district', 'District', 'xss_clean');
        $this->form_validation->set_rules('zone', 'Zone', 'xss_clean');
        $this->form_validation->set_rules('division', 'Division', 'xss_clean');
        $this->form_validation->set_rules('sho_area', 'SHOArea', 'xss_clean');
        $this->form_validation->set_rules('ownerName', 'OwnerName', 'required|xss_clean');
        $this->form_validation->set_rules('ownerPhoneNumber', 'Owner Phone Number', 'xss_clean');
        $this->form_validation->set_rules('ownerEmail', 'Owner Email Id', 'valid_email|xss_clean');
        $this->form_validation->set_rules('ownerAadharNumber', 'Owner Aadhar Number', 'required|xss_clean');
        $this->form_validation->set_rules('ownerAddress', 'Owner Address', 'xss_clean');        
        if ($this->form_validation->run() == FALSE) {           
            unset($_POST['submit']);
            $this->edit($id);
        } else {           
            extract($_POST);
            unset($_POST['submit']);
            $filename = NULL;
            $aWhere = array('id' => base64_decode($id));
            $accommodation = $this->accommodations_model->getAccommodationInfo($aWhere);
            if (@sizeof(array($accommodation)) == 0) {
                $this->session->set_flashdata('error', 'Accommodation not found');
                redirect($this->current_url);
            }
            if ( ! empty($_FILES['accommodation_photo']['name'])) {
                $filename = clear_string($_FILES['accommodation_photo']['name']);
                $tmpname = $_FILES['accommodation_photo']['tmp_name'];
                $accommodationPhoto = $this->accommodations_model->upload_image($filename, $tmpname);
            } else {
                $accommodationPhoto = $accommodation->photo;
            }
            $availableHardwares = implode(",", $_POST['availableHardware']);
            $params = array(
                'address' => $address,
                'pincode' => $pincode,
                'email' => $email,
                'photo' => $accommodationPhoto,
                'availableHardware' => $availableHardwares,
                'registrationDate' => $registrationDate,
                'grade' => $grade,
                'city' => $district,
                'zone' => $zone,
                'circle' => $division,
                'SHOArea' => $sho_area,
                'state' => $state,
                'country' => $country,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'ownerName' => $ownerName,
                'ownerPhoneNumber' => $ownerPhoneNumber,
                'ownerEmail' => $ownerEmail,
                'ownerAadharNumber' => $ownerAadharNumber,
                'ownerAddress' => $ownerAddress,
                'updatedBy' => decode($this->session_data['loginID']),
                'updatedOn' => DATETIME
            );
            $update = $this->accommodations_model->updateAccommodationInfo($params, $aWhere);
            if ($update) {
                if ( ! is_null($filename)) {
                    $this->accommodations_model->delete_image($accommodation->photo);
                }
                $this->session->set_flashdata('success', 'Accommodation updated successfully.');
                redirect($this->current_url . '/profile/' . $id);
            } else {
                if ( ! is_null($filename)) {
                    $this->accommodations_model->delete_image($filename);
                }
                $this->session->set_flashdata('error', 'Unable to update the accommodation, please try again later.');
                redirect($this->current_url . '/edit/' . $id);
            }
        }
    }
    
    public function activeExport($get_params = null){
        $status = 'active';
        return $this->export($status, $get_params);
    }
    
    public function inactiveExport($get_params = null){
        $status = 'inactive';
        return $this->export($status, $get_params);
    }
    
    public function allExport($get_params = null){
        $status = 'all';
        return $this->export($status, $get_params);
    }
    
    private function export($status, $get_params){
        $params = array();
        $get = json_decode(base64_decode($get_params), TRUE);
        if(is_array($get) && ! empty($get)){
            $params = array(
                'city' => isset($get['district']) ? $get['district'] : NULL,
                'SHOArea' => isset($get['sho_area']) ? $get['sho_area'] : NULL,
                'zone' => isset($get['zone']) ? $get['zone'] : NULL,
                'circle' => isset($get['division']) ? $get['division'] : NULL
            );
        }
        $this->load->helper('csv_helper');
        $accommodations = $this->accommodations_model->getAllAccommodationsExport($status, $params);
        if(@sizeof($accommodations) == 0){
            $this->session->set_flashdata('error', 'Accommodations not found');
            redirect($this->current_url);
        }
        $data[] = array("Name", "Type", "Address", "Pincode", "Phone Number", "Email", "No Of Rooms", "Available Hardware", "Registration Date", "Grade",
            "City", "Zone", "Circle", "SHO Area", "State", "Country", "Owner Name", "Owner Phone Number", "Owner Email", "Owner Aadhar Number", "Owner Address",
             "Latitude", "Longitude");
        foreach($accommodations as $key => $accommodation){
            foreach ($accommodation as $value => $details) {
                if($value == 'registrationDate'){
                    $accommodation->registrationDate = date('d-m-Y ', strtotime($details));
                }
            }
            $data[] = json_decode(json_encode($accommodation), TRUE);
        }
        array_to_csv($data, 'accommodations_' . date('dMy') . '.csv');
        
    }

}
