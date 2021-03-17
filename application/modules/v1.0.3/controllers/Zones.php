<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Zones extends REST_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('accommodations_model');
        $this->load->model('admin_model');
        $this->methods['index_get']['limit'] = 1000;
    }

    public function index_get() {
        $headers = apache_request_headers();
        $token = $headers['Token'];
        //$token = $this->input->get_request_header('Authorization');
             if (isset($token) && ! empty($token)) {
            $aaWhere = array('token' => $token);
            $authenticate = $this->admin_model->getOneRecord('vms19_admins',$aaWhere);
            if (sizeof($authenticate) != 1) {
            $aaWhere = array('token' => $token);
            $authenticate_accodomation = $this->accommodations_model->getAccommodationInfo($aaWhere);
            if (sizeof($authenticate_accodomation) != 1) {
            $this->set_response(array(
                'status' => FALSE,
                'message' => 'Sorry, it seems like you entered wrong credentials'
                ), REST_Controller::HTTP_UNAUTHORIZED);
            return;
             }
            // $this->set_response(array(
            //     'status' => FALSE,
            //     'message' => 'Sorry, it seems like you entered wrong credentials'
            //     ), REST_Controller::HTTP_UNAUTHORIZED);
            // return;
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
         {
            $zones = $this->accommodations_model->getAllZones();
            $this->set_response(array(
                'status' => TRUE,
                'message' => 'Zones loaded successfully!',
                'data' => array('zones' => $zones),
                ), REST_Controller::HTTP_OK);
        }
    }

}
