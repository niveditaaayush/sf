<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class SignIn extends REST_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('accommodations_model');
        $this->load->model('visitors_model');
    }

    public function index_post() {
        $headers = apache_request_headers();
        $token = $headers['Token'];
        //$token = $this->input->get_request_header('Authorization');
        if ( ! isset($token) || $token != encode(basicSiteString())) {
            $this->set_response(array(
                'status' => FALSE,
                'message' => 'Sorry, it seems like you entered wrong credentials'
                ), REST_Controller::HTTP_UNAUTHORIZED);
        } else {
            $phoneNumber = $this->post('phone_number');
            if ( ! valid_mobile($phoneNumber)) {
                $this->set_response(array(
                    'status' => FALSE,
                    'message' => 'Invalid phone number'
                    ), REST_Controller::HTTP_OK);
                exit(0);
            }
            $aWhere = array('phoneNumber' => $phoneNumber);
            $accommodation = $this->accommodations_model->getAccommodationInfo($aWhere);
            if (@sizeof($accommodation) == 1) {
                $otp = uniqueotp();
                $aWhere1 = array('phoneNumber' => $accommodation->phoneNumber);
                $params = array('phoneNumber' => $accommodation->phoneNumber, 'otp' => $otp);
                $checkOTP = $this->accommodations_model->getAccommodationOTP($aWhere1);
                if(@sizeof($checkOTP) == 1){
                    $storeOTP = $this->accommodations_model->updateAccommodationOTP($params, $aWhere1);
                } else {
                    $storeOTP = $this->accommodations_model->storeAccommodationOTP($params);
                }

                if($storeOTP){
                    $params = array(
                        'to' => $phoneNumber,
                        'message' => $otp.' is your verification code for VMS'
                        );

                    $sendSMS = $this->accommodations_model->sendSMS($params);
                    if (valid_number($sendSMS->JobId) && $sendSMS->NoOfSMS == 1) {
                        $this->set_response(array(
                            'status' => TRUE,
                            'message' => 'OTP send to phone number',
                            'otp' => $otp
                            ), REST_Controller::HTTP_OK);
                    } else {
                        $this->set_response(array(
                            'status' => FALSE,
                            'message' => 'OTP sending failed to phone number'
                            ), REST_Controller::HTTP_OK);
                    }

                } else {
                    $this->set_response(array(
                        'status' => FALSE,
                        'message' => 'OTP not update in server'
                        ), REST_Controller::HTTP_OK);
                }

            } else {
                $this->set_response(array(
                    'status' => FALSE,
                    'message' => 'Oops, could not login, please verify your number and try again'
                    ), REST_Controller::HTTP_OK);
            }
        }
    }

    public function validateOTP_post() {
        $headers = apache_request_headers();
        $token = $headers['Token'];
        //$token = $this->input->get_request_header('Authorization');
        if ( ! isset($token) || $token != encode(basicSiteString())) {
            $this->set_response(array(
                'status' => FALSE,
                'message' => 'Sorry, it seems like you entered wrong credentials'
                ), REST_Controller::HTTP_UNAUTHORIZED);
        } else {
            $otp = $this->post('otp');
            $phoneNumber = $this->post('phone_number');
            $accommodation = $this->accommodations_model->getAccommodationInfo(array('phoneNumber' => $phoneNumber));
            if (@sizeof($accommodation) == 0) {
                $this->set_response(array(
                    'status' => FALSE,
                    'message' => 'Oops, could not login, please verify your number and try again'
                    ), REST_Controller::HTTP_OK);
            } else {
                $aWhere = array('otp' => $otp, 'phoneNumber' => $phoneNumber);
                $checkOTP = $this->accommodations_model->getAccommodationOTP($aWhere);
                if (@sizeof($checkOTP) == 1) {
                    $appVersion = $this->accommodations_model->applicationVersion();
                    $todayCheckins = $this->visitors_model->getAllCheckinsByAccommodation($accommodation->id, DATE);
                    $totalCheckins = $this->visitors_model->getAllCheckinsByAccommodation($accommodation->id);
                    $accommodation->todayCheckins = count($todayCheckins);
                    $accommodation->totalCheckins = count($totalCheckins);
                    $accommodation->filledRooms   = count($totalCheckins);
                    $accommodation->appVersion    = $appVersion->version;
                    
                    $this->set_response(array(
                        'status' => TRUE,
                        'message' => 'OTP validation successfully',
                        'data' => array('accommodation' => $accommodation)
                        ), REST_Controller::HTTP_OK);
                } else {
                    $this->set_response(array(
                        'status' => FALSE,
                        'message' => 'Invalid OTP'
                        ), REST_Controller::HTTP_OK);
                }
            }
        }
    }

    public function index_get() {
        $headers = apache_request_headers();
        $token = $headers['Token'];
        //$token = $this->input->get_request_header('Authorization');
        if ( ! isset($token) || empty($token)) {
            $this->set_response(array(
                'status' => FALSE,
                'message' => 'Sorry, it seems like you entered wrong credentials'
                ), REST_Controller::HTTP_UNAUTHORIZED);
        } else {
            $aWhere = array('token' => $token);
            $accommodation = $this->accommodations_model->getAccommodationInfo($aWhere);
            if (@sizeof($accommodation) == 1) {
                $this->set_response(array(
                    'status' => TRUE,
                    'message' => 'Valid Accommodation',
                    'data' => array('accommodation' => $accommodation),
                    ), REST_Controller::HTTP_OK);
            } else {
                $this->set_response(array(
                    'status' => FALSE,
                    'message' => 'Oops, could not login, please verify your number and try again'
                    ), REST_Controller::HTTP_OK);
            }
        }
    }

}
