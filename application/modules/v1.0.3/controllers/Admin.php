<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Admin extends REST_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('admin_model');
        $this->load->model('accommodations_model');
        $this->load->model('visitors_model');
    }

    public function dashboard_get() {
        $headers = apache_request_headers();
        $token = $headers['Token'];
             if (isset($token) && ! empty($token)) {
            $aaWhere = array('token' => $token);
            $authenticate = $this->admin_model->getOneRecord('vms19_admins',$aaWhere);
             if (sizeof($authenticate) != 1) {
            $this->set_response(array(
                'status' => FALSE,
                'message' => 'Sorry, it seems like you entered wrong credentials'
                ), REST_Controller::HTTP_UNAUTHORIZED);
            return;
        }

        }
        else
        {
            $this->set_response(array(
                'status' => FALSE,
                'message' => 'Sorry, it seems like you entered wrong credentials'
                ), REST_Controller::HTTP_UNAUTHORIZED);
            return;
        }
        
        $accommodationsTypes = $this->accommodations_model->getAllAccommodationTypes();
        $totalAccommodations = $this->accommodations_model->countAllAccommodations();
        $liveAccommodations = $this->accommodations_model->countAllAccommodations(array('status' => 1));
        $totalVisitors = $this->visitors_model->countAllVisitors();
        $totalCheckins = $this->visitors_model->countAllCheckins();
        $todayCheckins = $this->visitors_model->countAllCheckins(array('checkIn' => DATETIME));
        $monthCheckins = $this->visitors_model->countAllCheckins();
        $this->set_response(array(
            'status' => TRUE,
            'message' => 'Dashboard data loaded successfully!',
            'data' => array(
                'accommodationsTypes' => $accommodationsTypes,
                'totalAccommodations' => $totalAccommodations,
                'liveAccommodations' => $liveAccommodations,
                'totalVisitors' => $totalVisitors,
                'totalCheckins' => $totalCheckins,
                'todayCheckins' => $todayCheckins,
                'monthCheckins' => $monthCheckins
            )
            ), REST_Controller::HTTP_OK);
    }

}
