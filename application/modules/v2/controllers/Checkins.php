<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Checkins extends REST_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('authentication_model');
        $this->load->model('accommodations_model');
        $this->load->model('visitors_model');
    }

    public function index_post() {
        $token = $this->input->get_request_header('Authorization');
        if ( ! isset($token) || empty($token)) {
            $this->set_response(array(
                'status' => REST_Controller::HTTP_UNAUTHORIZED,
                'message' => 'Sorry, it seems like you entered wrong credentials'
                ), REST_Controller::HTTP_UNAUTHORIZED);
            return;
        }
        $aWhere = array('token' => $token);
        $authenticate = $this->authentication_model->getAuthenticationInfo($aWhere);
        if (@sizeof($authenticate) == 0 || $authenticate->validity < time()) {
            $this->set_response(array(
                'status' => REST_Controller::HTTP_UNAUTHORIZED,
                'message' => 'Sorry, it seems like you entered wrong credentials'
                ), REST_Controller::HTTP_UNAUTHORIZED);
            return;
        }

        $input = json_decode(trim(file_get_contents('php://input')), true);
        $where = array(
            'SHOArea' => $input['sho_area'],
            'name' => $input['hotel'],
            'city' => $input['city'],
            'zone' => $input['zone'],
            'circle' => $input['circle']
        );
        $from_date = date("Y-m-d H:i:s", strtotime($input['from_date']));
        $to_date = date("Y-m-d 23:59:59", strtotime($input['to_date']));
        $checkins = array();
        $getAllCheckins = $this->accommodations_model->getAllCheckinsList($where, $input['phone_number'], $from_date, $to_date, $input['limit'], $input['start']);
        if (@sizeof($getAllCheckins) > 0) {
            foreach ($getAllCheckins as $getCheckin) {
                $getVisitor = $this->visitors_model->getPrimaryInfoVisitor($getCheckin->guest_primaryId, $input['guest_name'], $input['guest_origin_pincode']);
                if (@sizeof($getVisitor) == 1) {
                    $getCheckin->guestId = $getVisitor->guestId;
                    $getCheckin->guest_name = $getVisitor->guest_name;
                    $getCheckin->guest_photo = $getVisitor->guest_photo;
                    $getCheckin->guest_pincode = $getVisitor->guest_pincode;
                    $checkins[] = $getCheckin;
                }
            }
        }
        $this->set_response(array(
            'status' => REST_Controller::HTTP_OK,
            'status_message' => 'OK',
            'count' => count($checkins),
            'checkins_list' => $checkins,
            ), REST_Controller::HTTP_OK);
    }

    public function index_get() {
        set_time_limit(0);
        $token = $this->input->get_request_header('Authorization');
        if ( ! isset($token) || empty($token)) {
            $this->set_response(array(
                'status' => REST_Controller::HTTP_UNAUTHORIZED,
                'message' => 'Sorry, it seems like you entered wrong credentials'
                ), REST_Controller::HTTP_UNAUTHORIZED);
            return;
        }
        $aWhere = array('token' => $token);
        $authenticate = $this->authentication_model->getAuthenticationInfo($aWhere);
        if (@sizeof($authenticate) == 0 || $authenticate->validity < time()) {
            $this->set_response(array(
                'status' => REST_Controller::HTTP_UNAUTHORIZED,
                'message' => 'Sorry, it seems like you entered wrong credentials'
                ), REST_Controller::HTTP_UNAUTHORIZED);
            return;
        }
        $checkins = array();
        $getAllCheckins = $this->accommodations_model->getAllActiveCheckins();
        if (@sizeof($getAllCheckins) > 0) {
            foreach ($getAllCheckins as $getCheckin) {
                $getVisitor = $this->visitors_model->getPrimaryInfoVisitor($getCheckin->guest_primaryId);
                if (@sizeof($getVisitor) == 1) {
                    $getCheckin->guestId = $getVisitor->guestId;
                    $getCheckin->guest_name = $getVisitor->guest_name;
                    $getCheckin->guest_photo = $getVisitor->guest_photo;
                    $getCheckin->guest_pincode = $getVisitor->guest_pincode;
                    $checkins[] = $getCheckin;
                }
            }
        }
        $this->set_response(array(
            'status' => REST_Controller::HTTP_OK,
            'status_message' => 'OK',
            'count' => count($checkins),
            'checkins_list' => $checkins,
            ), REST_Controller::HTTP_OK);
    }

    public function shared_get() {
        set_time_limit(0);
        $token = $this->input->get_request_header('Authorization');
        if ( ! isset($token) || empty($token)) {
            $this->set_response(array(
                'status' => REST_Controller::HTTP_UNAUTHORIZED,
                'message' => 'Sorry, it seems like you entered wrong credentials'
                ), REST_Controller::HTTP_UNAUTHORIZED);
            return;
        }
        $aWhere = array('token' => $token);
        $authenticate = $this->authentication_model->getAuthenticationInfo($aWhere);
        if (@sizeof($authenticate) == 0 || $authenticate->validity < time()) {
            $this->set_response(array(
                'status' => REST_Controller::HTTP_UNAUTHORIZED,
                'message' => 'Sorry, it seems like you entered wrong credentials'
                ), REST_Controller::HTTP_UNAUTHORIZED);
            return;
        }
        $ids = $this->get('primary_ids');
        $primaryIds = [];
        $updates = [];
        if (! preg_match(COMMA_NUMBER_FORMAT, $ids)) {
            $this->set_response(array(
                'status' => REST_Controller::HTTP_OK,
                'message' => 'Sorry, the primary id(s) are not in a number/comma-separated format.'
                ), REST_Controller::HTTP_OK);
            return;
        }
        $primaryIds = explode(',', $ids);
        if (@sizeof($primaryIds) > 0) {
            foreach ($primaryIds as $primaryId) {
                $aWhere = array('id' => $primaryId);
                $getVisitor = $this->visitors_model->getVisitorPrimaryInfo($aWhere);
                if (@sizeof($getVisitor) == 1) {
                    $params = array(
                        'isShared' => 1,
                        'updatedOn' => DATETIME
                    );
                    $updates[] = $this->visitors_model->updateVisitorPrimaryInfo($params, $aWhere);
                }
            }
        }
        if (count($updates) == count($primaryIds)) {
            $this->set_response(array(
                'status' => REST_Controller::HTTP_OK,
                'status_message' => 'OK',
                'message' => 'Records successfully updated in server',
                ), REST_Controller::HTTP_OK);
            return;
        }
        $this->set_response(array(
            'status' => REST_Controller::HTTP_OK,
            'status_message' => 'OK',
            'message' => 'Some records not updated in server',
            ), REST_Controller::HTTP_OK);
    }

    public function details_post() {
        $token = $this->input->get_request_header('Authorization');
        if ( ! isset($token) || empty($token)) {
            $this->set_response(array(
                'status' => REST_Controller::HTTP_UNAUTHORIZED,
                'message' => 'Sorry, it seems like you entered wrong credentials'
                ), REST_Controller::HTTP_UNAUTHORIZED);
            return;
        }
        $aWhere = array('token' => $token);
        $authenticate = $this->authentication_model->getAuthenticationInfo($aWhere);
        if (@sizeof($authenticate) == 0 || $authenticate->validity < time()) {
            $this->set_response(array(
                'status' => REST_Controller::HTTP_UNAUTHORIZED,
                'message' => 'Sorry, it seems like you entered wrong credentials'
                ), REST_Controller::HTTP_UNAUTHORIZED);
            return;
        }

        $input = json_decode(trim(file_get_contents('php://input')), true);
        $params = array(
            'SHOArea' => $input['sho_area'],
            'city' => $input['city'],
            'zone' => $input['zone'],
            'circle' => $input['circle']
        );
        $getVisitor = $this->visitors_model->getPrimaryInfoVisitorDetails($params, $input['guestId']);
        $this->set_response(array(
            'status' => REST_Controller::HTTP_OK,
            'status_message' => 'OK',
            'checkinDetails' => $getVisitor,
            ), REST_Controller::HTTP_OK);
    }

}
