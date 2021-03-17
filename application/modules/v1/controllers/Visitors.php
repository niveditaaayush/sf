<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Visitors extends REST_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('accommodations_model');
        $this->load->model('visitors_model');
    }

    public function index_get() {
        $headers = apache_request_headers();
        $token = $headers['Token'];
        //$token = $this->input->get_request_header('Authorization');
        if (isset($token) && ! empty($token)) {
            $aWhere = array('token' => $token);
            $authenticate = $this->accommodations_model->getAccommodationInfo($aWhere);
            if (@sizeof($authenticate) == 1) {
                $aWhere1 = array('status' => 1, 'accommodationId' => $authenticate->id);
                $visitorPrimaryInfo = $this->visitors_model->getAllVisitorPrimaryInfo($aWhere1);
                if (@sizeof($visitorPrimaryInfo) > 0) {
                    foreach ($visitorPrimaryInfo as $key => $value) {
                        $visitor = $this->visitors_model->getPrimaryVisitorInfo(array('vpId' => $value->id));
                        $value->userName = $visitor ? ($visitor->firstName . ' ' . $visitor->lastName) : '';
                    }
                    $this->set_response([
                        'status' => TRUE,
                        'data' => array('visitors' => $visitorPrimaryInfo),
                        ], REST_Controller::HTTP_OK);
                } else {
                    $this->set_response([
                        'status' => FALSE,
                        'message' => 'No vistitors were found'
                        ], REST_Controller::HTTP_OK);
                }
            } else {
                $this->set_response(array(
                    'status' => FALSE,
                    'message' => 'Sorry, it seems like you entered wrong credentials'
                    ), REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            $this->set_response(array(
                'status' => FALSE,
                'message' => 'Sorry, it seems like you entered wrong credentials'
                ), REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    public function details_get() {
        $headers = apache_request_headers();
        $token = $headers['Token'];
        //$token = $this->input->get_request_header('Authorization');
        if (isset($token) && ! empty($token)) {

            $aWhere = array('token' => $token);
            $authenticate = $this->accommodations_model->getAccommodationInfo($aWhere);

            if (@sizeof($authenticate) == 1) {

                $vpId = $this->get('vp_id');
                $visitorId = $this->get('visitorId');

                if ($vpId === NULL) {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'Visitors primary details id not found'
                        ], REST_Controller::HTTP_OK);
                } else {

                    $visitorPrimaryInfo = $this->visitors_model->getVisitorPrimaryInfo(array('id' => $vpId));
                    if (@sizeof($visitorPrimaryInfo) > 0) {
                        if ($visitorId === NULL) {
                            $visitors = $this->visitors_model->getAllVisitorsInfo(array('vpId' => $vpId));
                            $this->response([
                                'status' => TRUE,
                                'data' => array('visitorsPrimaryInfo' => $visitorPrimaryInfo, 'visitors' => $visitors),
                                ], REST_Controller::HTTP_OK);
                        }

                        $id = (int) $visitorId;

                        if ($id <= 0) {
                            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
                        }

                        $visitors = $this->visitors_model->getVisitorInfo(array('id' => $id));

                        $this->response([
                            'status' => TRUE,
                            'data' => array('visitorsPrimaryInfo' => $visitorPrimaryInfo, 'visitors' => $visitors),
                            ], REST_Controller::HTTP_OK);
                    } else {
                        $this->response([
                            'status' => FALSE,
                            'message' => 'No vistitors were found'
                            ], REST_Controller::HTTP_OK);
                    }
                }
            } else {
                $this->set_response(array(
                    'status' => FALSE,
                    'message' => 'Sorry, it seems like you entered wrong credentials'
                    ), REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            $this->set_response(array(
                'status' => FALSE,
                'message' => 'Sorry, it seems like you entered wrong credentials'
                ), REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    public function sendOTP_post() {
        $headers = apache_request_headers();
        $token = $headers['Token'];
        //$token = $this->input->get_request_header('Authorization');
        if (isset($token) && ! empty($token)) {

            $aWhere = array('token' => $token);
            $authenticate = $this->accommodations_model->getAccommodationInfo($aWhere);
            if (@sizeof($authenticate) == 1) {

                $otp = old_uniqueotp();
                $phoneNumber = $this->post('phone_number');
                $aWhere1 = array('phoneNumber' => $phoneNumber);
                $params = array('phoneNumber' => $phoneNumber, 'otp' => $otp);

                $checkOTP = $this->visitors_model->getVisitorOTP($aWhere1);
                if (@sizeof($checkOTP) == 1) {
                    $storeOTP = $this->visitors_model->updateVisitorOTP($params, $aWhere1);
                } else {
                    $storeOTP = $this->visitors_model->storeVisitorOTP($params);
                }
                if ($storeOTP) {
                    $params = array(
                        'to' => $phoneNumber,
                        'message' => $otp . ' is your verification code for VMS'
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
                    'message' => 'Sorry, it seems like you entered wrong credentials'
                    ), REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            $this->set_response(array(
                'status' => FALSE,
                'message' => 'Sorry, it seems like you entered wrong credentials'
                ), REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    public function validateOTP_post() {
        $headers = apache_request_headers();
        $token = $headers['Token'];
        //$token = $this->input->get_request_header('Authorization');
        if (isset($token) && ! empty($token)) {

            $aWhere = array('token' => $token);
            $authenticate = $this->accommodations_model->getAccommodationInfo($aWhere);
            if (@sizeof($authenticate) == 1) {

                $otp = $this->post('otp');
                $phoneNumber = $this->post('phone_number');

                $aWhere = array('otp' => $otp, 'phoneNumber' => $phoneNumber);
                $checkOTP = $this->visitors_model->getVisitorOTP($aWhere);
                if (@sizeof($checkOTP) == 1) {
                    $this->set_response(array(
                        'status' => TRUE,
                        'message' => 'OTP validation successfully'
                        ), REST_Controller::HTTP_OK);
                } else {
                    $this->set_response(array(
                        'status' => FALSE,
                        'message' => 'Invalid OTP'
                        ), REST_Controller::HTTP_OK);
                }
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Sorry, it seems like you entered wrong credentials'
                    ], REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Sorry, it seems like you entered wrong credentials'
                ], REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    public function primaryInfo_post() {
        $headers = apache_request_headers();
        $token = $headers['Token'];
        //$token = $this->input->get_request_header('Authorization');
        if (isset($token) && ! empty($token)) {

            $aWhere = array('token' => $token);
            $authenticate = $this->accommodations_model->getAccommodationInfo($aWhere);

            if (@sizeof($authenticate) == 1) {
                $aWhere1 = array('phoneNumber' => $this->post('phone_number'), 'status' => 1);
                $visitoPrimaryInfo = $this->visitors_model->getVisitorPrimaryInfo($aWhere1);
                if (@sizeof($visitoPrimaryInfo) > 0) {
                    $this->set_response(array(
                        'status' => FALSE,
                        'message' => 'Sorry, Visitors already exist with this phone number.'
                        ), REST_Controller::HTTP_OK);
                } else {
                    $params = array(
                        'accommodationId' => $this->post('accommodation_id'),
                        'phoneNumber' => $this->post('phone_number'),
                        'noOfVisitors' => $this->post('no_of_visitors'),
                        'noOfRooms' => $this->post('no_of_rooms'),
                        'roomNumber' => $this->post('room_number'),
                        'maleAdults' => $this->post('male_adults'),
                        'femaleAdults' => $this->post('female_adults'),
                        'maleChild' => $this->post('male_child'),
                        'femaleChild' => $this->post('female_child'),
                        'purposeOfVisit' => $this->post('purpose_of_visit'),
                        'status' => 1,
                        'checkIn' => $this->post('check_in'),
                        'createdBy' => $authenticate->id,
                        'createdOn' => DATETIME
                    );
                    $storeVrisitorPrimaryInfo = $this->visitors_model->storeVisitorPrimaryInfo($params);
                    if ($storeVrisitorPrimaryInfo) {
                        $id = $this->visitors_model->getInsertedID();
                        $this->response([
                            'status' => TRUE,
                            'message' => 'Visitors primary details stored successfully!',
                            'data' => array('vrisitorPrimaryInfo' => array_merge(array('id' => $id), $params)),
                            ], REST_Controller::HTTP_OK);
                    } else {
                        $this->response([
                            'status' => FALSE,
                            'message' => 'Unable to store visitors primary details',
                            ], REST_Controller::HTTP_OK);
                    }
                }
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Sorry, it seems like you entered wrong credentials'
                    ], REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Sorry, it seems like you entered wrong credentials'
                ], REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    public function checkOut_get() {
        $headers = apache_request_headers();
        $token = $headers['Token'];
        //$token = $this->input->get_request_header('Authorization');
        if (isset($token) && ! empty($token)) {

            $aWhere = array('token' => $token);
            $authenticate = $this->accommodations_model->getAccommodationInfo($aWhere);

            if (@sizeof($authenticate) == 1) {
                $aWhere1 = array('id' => $this->get('id'));
                $visitoPrimaryInfo = $this->visitors_model->getVisitorPrimaryInfo($aWhere1);
                if (@sizeof($visitoPrimaryInfo) > 0) {
                    $params = array(
                        'status' => 0,
                        'checkOut' => DATETIME,
                        'updatedBy' => $authenticate->id,
                        'updatedOn' => DATETIME
                    );
                    $updateVrisitorPrimaryInfo = $this->visitors_model->updateVisitorPrimaryInfo($params, $aWhere1);
                    if ($updateVrisitorPrimaryInfo) {
                        $this->response([
                            'status' => TRUE,
                            'message' => 'Visitors checkout successfully!',
                            ], REST_Controller::HTTP_OK);
                    } else {
                        $this->response([
                            'status' => FALSE,
                            'message' => 'Unable to checkout please try again later',
                            ], REST_Controller::HTTP_OK);
                    }
                } else {
                    $this->set_response(array(
                        'status' => FALSE,
                        'message' => 'Sorry, Visitors record not found'
                        ), REST_Controller::HTTP_OK);
                }
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Sorry, it seems like you entered wrong credentials'
                    ], REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Sorry, it seems like you entered wrong credentials'
                ], REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    public function index_post() {
        $headers = apache_request_headers();
        $token = $headers['Token'];
        //$token = $this->input->get_request_header('Authorization');
        if (isset($token) && ! empty($token)) {
            $aWhere = array('token' => $token);
            $authenticate = $this->accommodations_model->getAccommodationInfo($aWhere);

            if (@sizeof($authenticate) == 1) {
                $aWhere1 = array('id' => $this->post('vp_id'));
                $visitoPrimaryInfo = $this->visitors_model->getVisitorPrimaryInfo($aWhere1);

                if (@sizeof($visitoPrimaryInfo) > 0) {

                    if ($this->post('id_proof_number') == 'com.accommodation.sa' || strpos($this->post('id_proof_number'), '.') == true) {

                        $this->visitors_model->deleteVisitorPrimaryInfo($aWhere1);
                        $this->set_response([
                            'status' => FALSE,
                            'message' => 'Sorry, please update the app from Play Store'
                            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                    } else {

                        $photoOfVisitor = NULL;
                        $idProofPhotoFront = NULL;
                        $idProofPhotoBack = NULL;

                        if ( ! empty($_FILES['visitor_photo']['name'])) {
                            $filename1 = time() . clear_string($_FILES['visitor_photo']['name']);
                            $tmpname1 = $_FILES['visitor_photo']['tmp_name'];
                            $photoOfVisitor = $this->visitors_model->upload_image($filename1, $tmpname1);
                        }

                        if ( ! empty($_FILES['id_proof_photo_front']['name'])) {
                            $filename2 = time() . clear_string($_FILES['id_proof_photo_front']['name']);
                            $tmpname2 = $_FILES['id_proof_photo_front']['tmp_name'];
                            $idProofPhotoFront = $this->visitors_model->upload_image($filename2, $tmpname2);
                        }

                        if ( ! empty($_FILES['id_proof_photo_back']['name'])) {
                            $filename3 = time() . clear_string($_FILES['id_proof_photo_back']['name']);
                            $tmpname3 = $_FILES['id_proof_photo_back']['tmp_name'];
                            $idProofPhotoBack = $this->visitors_model->upload_image($filename3, $tmpname3);
                        }

                        $params = array(
                            'vpId' => $this->post('vp_id'),
                            'firstName' => $this->post('first_name'),
                            'lastName' => $this->post('last_name'),
                            'photoOfVisitor' => $photoOfVisitor,
                            'idProofType' => $this->post('id_proof_type'),
                            'idProofNumber' => $this->post('id_proof_number'),
                            'idProofPhotoFront' => $idProofPhotoFront,
                            'idProofPhotoBack' => $idProofPhotoBack,
                            'gender' => $this->post('gender'),
                            'ageGroup' => $this->post('age_group'),
                            'address' => $this->post('address'),
                            'pincode' => $this->post('pincode'),
                            'vehicleNumber' => $this->post('vehicle_number'),
                            'createdBy' => $authenticate->id,
                            'createdOn' => DATETIME
                        );

                        $storeVrisitorInfo = $this->visitors_model->storeVisitorInfo($params);
                        if ($storeVrisitorInfo) {
                            $this->response([
                                'status' => TRUE,
                                'message' => 'Visitor added successfully!',
                                ], REST_Controller::HTTP_OK);
                        } else {
                            $this->visitors_model->delete_image($photoOfVisitor);
                            $this->visitors_model->delete_image($idProofPhotoFront);
                            $this->visitors_model->delete_image($idProofPhotoBack);
                            $this->response([
                                'status' => FALSE,
                                'message' => 'Visitor adding failed!',
                                ], REST_Controller::HTTP_OK);
                        }
                    }
                } else {
                    $this->set_response([
                        'status' => FALSE,
                        'message' => 'Sorry, visitors primary information not found'
                        ], REST_Controller::HTTP_OK);
                }
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Sorry, it seems like you entered wrong credentials'
                    ], REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Sorry, it seems like you entered wrong credentials'
                ], REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    public function deleteNunVisitorsPrimaryInfo_delete() {
        $primaryInfos = $this->visitors_model->getAllPrimaryInfo();
        if (@sizeof($primaryInfos) > 0) {
            foreach ($primaryInfos as $primaryInfo) {
                $aWhere = array('vpId' => $primaryInfo->id);
                $visitorsCount = $this->visitors_model->countAllVisitors($aWhere);
                if ($visitorsCount == 0) {
                    $aWhere1 = array('id' => $primaryInfo->id);
                    $delete = $this->visitors_model->deleteVisitorPrimaryInfo($aWhere1);
                }
            }
            if (isset($delete)) {
                $this->set_response([
                    'status' => TRUE,
                    'message' => 'Unused data removed from server'
                    ], REST_Controller::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Sorry, Unable to delete some records'
                    ], REST_Controller::HTTP_OK);
            }
        }
    }

}
