<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Properties extends REST_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('authentication_model');
        $this->load->model('accommodations_model');
    }

    public function index_post() {
        $token = $this->input->get_request_header('Authorization');
        if ( ! isset($token) || empty($token)) {
            $this->set_response(array(
                'status' => REST_Controller::HTTP_UNAUTHORIZED,
                'message' => 'Sorry, it seems like you entered wrong credentials'
                ), REST_Controller::HTTP_UNAUTHORIZED);
            exit(0);
        }
        $aWhere = array('token' => $token);
        $authenticate = $this->authentication_model->getAuthenticationInfo($aWhere);
        if (@sizeof($authenticate) == 1 && $authenticate->validity > time()) {
            
            $input = json_decode(trim(file_get_contents('php://input')), true);
            $params = array(
                'typeId'   => $input['accommodationType'],
                'SHOArea'  => $input['sho_area'],
                'city'     => $input['city'],
                'zone'     => $input['zone'],
                'circle'   => $input['circle']
                );
            $no_of_hotels = [];
            $no_of_dormitories = [];
            $no_of_lodges = NULL;
            $no_of_service_apartments = [];
            $no_of_guest_houses = [];
            $no_of_pg_accomodation = [];
            $no_of_home_stay = [];
            $no_of_hostels = [];
            $no_of_others = [];

            $getAllCounts  = $this->accommodations_model->getAllCounts($params);
            $getAllCheckins  = $this->accommodations_model->getAllCheckins($params);
            $getAllTodayCheckins  = $this->accommodations_model->getAllTodayCheckins($params);
            $getProperties = $this->accommodations_model->getAllPropertiesLike($params);
            if(@sizeof($getProperties) > 0){
                foreach ($getProperties as $getProperty) {
                    $todayCheckins = $this->accommodations_model->getAllCheckinsByAccommodation($getProperty->id, DATE);
                    $totalCheckins = $this->accommodations_model->getAllCheckinsByAccommodation($getProperty->id);
                    $getProperty->today_checkins = count($todayCheckins);
                    $getProperty->total_checkins = count($totalCheckins);
                }
            }

            if(@sizeof($getAllCounts) > 0){
                foreach ($getAllCounts as $value) {
                    if(ucwords($value->type) == 'Hotel'){
                        $no_of_hotels[] = $value->type;
                    } elseif(ucwords($value->type) == 'Dormitory'){
                        $no_of_dormitories[] = $value->type;
                    } elseif(ucwords($value->type) == 'Lodge'){
                        $no_of_lodges[] = $value->type;
                    } elseif(ucwords($value->type) == 'Service Apartment'){
                        $no_of_service_apartments[] = $value->type;
                    } elseif(ucwords($value->type) == 'Guest House'){
                        $no_of_guest_houses[] = $value->type;
                    } elseif(ucwords($value->type) == 'Pg'){
                        $no_of_pg_accomodation[] = $value->type;
                    } elseif(ucwords($value->type) == 'Home Stay'){
                        $no_of_home_stay[] = $value->type;
                    } elseif(ucwords($value->type) == 'Hostel'){
                        $no_of_hostels[] = $value->type;
                    } elseif(ucwords($value->type) == 'Others'){
                        $no_of_others[] = $value->type;
                    }
                }
            }
            $this->set_response(array(
                'status' => REST_Controller::HTTP_OK,
                'status_message' => 'OK',
                'result' => array(
                    'no_of_hotels'          => count($no_of_hotels),
                    'no_of_dormitories'     => count($no_of_dormitories),
                    'no_of_lodges'          => count($no_of_lodges),
                    'no_of_service_apartments' => count($no_of_service_apartments),
                    'no_of_guest_houses'    => count($no_of_guest_houses),
                    'no_of_pg_accomodation' => count($no_of_pg_accomodation),
                    'no_of_home_stay'       => count($no_of_home_stay),
                    'no_of_hostels'         => count($no_of_hostels),
                    'no_of_others'          => count($no_of_others),
                    'total_checkins'        => $getAllCheckins->total_checkins,
                    'today_checkins'        => $getAllTodayCheckins->total_checkins,
                    'property_list'         => $getProperties
                )
                ), REST_Controller::HTTP_OK);
        } else {
            $this->set_response([
                'status' => REST_Controller::HTTP_UNAUTHORIZED,
                'message' => 'Sorry, it seems like you entered wrong credentials'
                ], REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
}
