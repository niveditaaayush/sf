<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MX_Controller {

    public $current_url;
    public $session_data;

    public function __construct() {
        parent::__construct();
        login_check('admin', TRUE);
        $this->session_data = get_session_data();
        $this->load->model('admin_model');
        $this->load->model('accommodations_model');
        $this->load->model('visitors_model');
    }

    public function index() {

        $data['current_url'] = base_url('admin/dashboard');
        $data['loginUser'] = loginUser();
        $params = array(
            'city' => $data['loginUser']->district,
            'zone' => $data['loginUser']->zone,
            'circle' => $data['loginUser']->division,
            'SHOArea' => $data['loginUser']->sho_area,
            'status' => 1
        );
        $data['cities'] = $this->accommodations_model->getAllCities();
        $data['accommodationsTypes'] = $this->accommodations_model->countAllAccommodationTypes($params);
        $data['liveAccommodations'] = $this->accommodations_model->countAllAccommodations($params);
        $inParams = array_merge($params, array('status' => 0));
        $data['inactiveAccommodations'] = $this->accommodations_model->countAllAccommodations($inParams);
        $accommodations = $this->accommodations_model->getAllAccommodationsForMap($params);
        if(@sizeof($accommodations) > 0){
            foreach ($accommodations as $key => $accommodation) {
                $todayCheckins[] = $this->visitors_model->countAllActiveCheckins(DATE, $accommodation->id);
                $totalCheckins[] = $this->visitors_model->countAllActiveCheckins(NULL, $accommodation->id);
                $todayVisitors[] = $this->visitors_model->countAllActiveVisitors(DATE, $accommodation->id);
                $totalVisitors[] = $this->visitors_model->countAllActiveVisitors(NULL, $accommodation->id);
                $sos[] = $this->visitors_model->countAllSOS($accommodation->id);
            }
        }
        $data['accommodations'] = $accommodations;
        $data['todayCheckins'] = isset($todayCheckins) ? array_sum($todayCheckins) : 0;
        $data['totalCheckins'] = isset($totalCheckins) ? array_sum($totalCheckins) : 0;
        $data['todayVisitors'] = isset($todayVisitors) ? array_sum($todayVisitors) : 0;
        $data['totalVisitors'] = isset($totalVisitors) ? array_sum($totalVisitors) : 0;
        $data['sos'] = isset($sos) ? array_sum($sos) : 0;
        $this->load->view('dashboard', $data);
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
            'circle' => $circle,
            'status' => 1
        );
        $data['current_url'] = base_url('admin/dashboard');
        $data['cities'] = $this->accommodations_model->getAllCities();
        $data['accommodationsTypes'] = $this->accommodations_model->countAllAccommodationTypes($params);
        $data['liveAccommodations'] = $this->accommodations_model->countAllAccommodations($params);
        $inParams = array_merge($params, array('status' => 0));
        $data['inactiveAccommodations'] = $this->accommodations_model->countAllAccommodations($inParams);
        $accommodations = $this->accommodations_model->getAllAccommodationsForMap($params);
        if(@sizeof($accommodations) > 0){
            foreach ($accommodations as $accommodation) {
                $todayCheckins[] = $this->visitors_model->countAllActiveCheckins(DATE, $accommodation->id);
                $totalCheckins[] = $this->visitors_model->countAllActiveCheckins(NULL, $accommodation->id);
                $todayVisitors[] = $this->visitors_model->countAllActiveVisitors(DATE, $accommodation->id);
                $totalVisitors[] = $this->visitors_model->countAllActiveVisitors(NULL, $accommodation->id);
            }
        }
        $data['accommodations'] = $accommodations;
        $data['todayCheckins'] = isset($todayCheckins) ? array_sum($todayCheckins) : 0;
        $data['totalCheckins'] = isset($totalCheckins) ? array_sum($totalCheckins) : 0;
        $data['todayVisitors'] = isset($todayVisitors) ? array_sum($todayVisitors) : 0;
        $data['totalVisitors'] = isset($totalVisitors) ? array_sum($totalVisitors) : 0;
        $this->session->set_flashdata('success','Accommodations loaded successfully!');
        $this->load->view('dashboard', $data);
    }

    public function getAjaxDistrictZones() {

        $district = $this->input->post('district');
        if ( ! is_string($district) || empty($district)) {
            echo json_encode(array('status' => FALSE, 'message' => 'Invalid district'));
            return;
        }
        $zones = $this->accommodations_model->getAllDistrictZones(array('district' => $district));
        if (@sizeof($zones) == 0) {
            echo json_encode(array('status' => FALSE, 'message' => 'Zones not found'));
            return;
        } else {
            echo json_encode(array('status' => TRUE, 'zones' => $zones));
            return;
        }
    }

    public function getAjaxZoneDivisions() {

        $zone = $this->input->post('zone');
        if ( ! is_string($zone) || empty($zone)) {
            echo json_encode(array('status' => FALSE, 'message' => 'Invalid zone name'));
            return;
        }
        $divisions = $this->accommodations_model->getAllZoneDivisions(array('zone' => $zone));
        if (@sizeof($divisions) == 0) {
            echo json_encode(array('status' => FALSE, 'message' => 'Divisions not found'));
            return;
        } else {
            echo json_encode(array('status' => TRUE, 'divisions' => $divisions));
            return;
        }
    }

    public function getAjaxDivisionSHOArea() {

        $zone = $this->input->post('zone');
        $division = $this->input->post('division');
        if ( ! is_string($zone) || empty($zone) ||  ! is_string($division) || empty($division)) {
            echo json_encode(array('status' => FALSE, 'message' => 'Invalid zone or division'));
            return;
        }
        $division = $division != 'null' ? $division : NULL;
        $aWhere = array('zone' => $zone, 'division' => $division);
        $sho_areas = $this->accommodations_model->getAllDivisionSHOArea($aWhere);
        if (@sizeof($sho_areas) == 0) {
            echo json_encode(array('status' => FALSE, 'message' => 'sho_areas not found'));
            return;
        } else {
            echo json_encode(array('status' => TRUE, 'sho_areas' => $sho_areas));
            return;
        }
    }

}
