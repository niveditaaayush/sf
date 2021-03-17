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

                $aWhere1 = array('accommodationId' => $authenticate->id, 'status' => 1, 'checkOut' => NULL);
                $visitorPrimaryInfo = $this->visitors_model->getAllVisitorPrimaryInfo($aWhere1);

                if (@sizeof($visitorPrimaryInfo) > 0) {
                    foreach ($visitorPrimaryInfo as $primaryInfo) {
                        $visitor = $this->visitors_model->getPrimaryVisitorInfo(array('vpId' => $primaryInfo->id));
                        $primaryInfo->userName = $visitor ? ($visitor->firstName . ' ' . $visitor->lastName) : '';
                        $primaryInfo->checkins = $this->visitors_model->getAllCheckinRoomsInfo($primaryInfo->id);
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
                $otp = uniqueotp();
                $phoneNumber = $this->post('phone_number');
                $aWhere1 = array('phoneNumber' => $phoneNumber, 'status' => 1);
                $primaryInfo = $this->visitors_model->getLatestPrimaryInfo($aWhere1);
                if (@sizeof($primaryInfo) == 0) {
                    $aWhere2 = array('phoneNumber' => $phoneNumber);
                    $params = array('phoneNumber' => $phoneNumber, 'otp' => $otp);
                    $checkOTP = $this->visitors_model->getVisitorOTP($aWhere2);
                    if (@sizeof($checkOTP) == 1) {
                        $storeOTP = $this->visitors_model->updateVisitorOTP($params, $aWhere2);
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
                        'message' => 'Sorry, the guest with this mobile number already checked in'
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

                $aWhere1 = array('otp' => $otp, 'phoneNumber' => $phoneNumber);
                $checkOTP = $this->visitors_model->getVisitorOTP($aWhere1);
                if (@sizeof($checkOTP) == 1) {
                    $aWhere2 = array('phoneNumber' => $phoneNumber, 'status' => 0);
                    $primaryInfo = $this->visitors_model->getLatestPrimaryInfo($aWhere2);
                    if (@sizeof($primaryInfo) == 1) {
                        $visitor = $this->visitors_model->getPrimaryVisitorInfo(array('vpId' => $primaryInfo->id));
                        $this->set_response(array(
                            'status' => TRUE,
                            'data' => $visitor ? array('primaryVisitor' => $visitor) : NULL
                            ), REST_Controller::HTTP_OK);
                    } else {
                        $this->response([
                            'status' => TRUE,
                            'message' => 'New checkin'
                            ], REST_Controller::HTTP_OK);
                    }
                } else {
                    $this->set_response(array(
                        'status' => FALSE,
                        'message' => 'Sorry, Invalid OTP'
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
        if (!isset($token) || empty($token)) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Sorry, it seems like you entered wrong credentials'
                ], REST_Controller::HTTP_UNAUTHORIZED);
            return;
        }
        $aWhere = array('token' => $token);
        $authenticate = $this->accommodations_model->getAccommodationInfo($aWhere);

        if (@sizeof($authenticate) == 0) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Sorry, it seems like you entered wrong credentials'
                ], REST_Controller::HTTP_UNAUTHORIZED);
        }
        if (! valid_number($this->post('phone_number'))) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Sorry, the phone number could not be null'
                ], REST_Controller::HTTP_UNAUTHORIZED);
            return;
        }
        $aWhere1 = array('phoneNumber' => $this->post('phone_number'), 'status' => 1);
        $visitoPrimaryInfo = $this->visitors_model->getVisitorPrimaryInfo($aWhere1);
        if (@sizeof($visitoPrimaryInfo) > 0) {
            $this->set_response(array(
                'status' => FALSE,
                'message' => 'Sorry, Visitors already exist with this phone number.'
                ), REST_Controller::HTTP_OK);
            return;
        }
        if (is_array($this->post('room_number')) && ! empty($this->post('room_number'))) {
            $roomNumbers = implode(',', $this->post('room_number'));
            $params = array(
                'accommodationId' => $this->post('accommodation_id'),
                'phoneNumber' => $this->post('phone_number'),
                'noOfVisitors' => $this->post('no_of_visitors'),
                'noOfRooms' => $this->post('no_of_rooms'),
                'roomNumber' => $roomNumbers,
                'nationality' => $this->post('nationality'),
                'maleAdults' => $this->post('male_adults'),
                'femaleAdults' => $this->post('female_adults'),
                'maleChild' => $this->post('male_child'),
                'femaleChild' => $this->post('female_child'),
                'purposeOfVisit' => $this->post('purpose_of_visit'),
                'portal' => $this->post('portal'),
                'portalId' => $this->post('portal_id'),
                'sos'   => $this->post('sos'),
                'status' => 1,
                'checkIn' => $this->post('check_in'),
                'createdBy' => $authenticate->id,
                'createdOn' => DATETIME
            );
            $storeVrisitorPrimaryInfo = $this->visitors_model->storeVisitorPrimaryInfo($params);
            if ($storeVrisitorPrimaryInfo) {
                if($authenticate->status == 0){
                    $this->accommodations_model->updateAccommodationInfo(array('status' => 1), $aWhere);
                }
                $id = $this->visitors_model->getInsertedID();
                if($authenticate->typeId != 8){
                    if (is_array($this->post('room_number')) && ! empty($this->post('room_number'))) {
                        foreach ($this->post('room_number') as $rnumber) {
                            $roomParams = array(
                                'vpId' => $id,
                                'roomNumber' => $rnumber,
                                'checkIn' => $this->post('check_in')
                            );
                            $this->visitors_model->storeCheckinRoomInfo($roomParams);
                        }
                    }
                }
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
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Room number(s) not found',
                ], REST_Controller::HTTP_OK);
        }
    }
    
    public function updatePrimaryInfo_post() {
        $headers = apache_request_headers();
        $token = $headers['Token'];
        //$token = $this->input->get_request_header('Authorization');
        if (!isset($token) || empty($token)) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Sorry, it seems like you entered wrong credentials'
                ], REST_Controller::HTTP_UNAUTHORIZED);
            return;
        }
        $authenticate = $this->accommodations_model->getAccommodationInfo(array('token' => $token));
        if (@sizeof($authenticate) == 0) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Sorry, it seems like you entered wrong credentials'
                ], REST_Controller::HTTP_UNAUTHORIZED);
        }
        $aWhere = array('id' => $this->post('primary_id'), 'status' => 1);
        $visitorPrimaryInfo = $this->visitors_model->getVisitorPrimaryInfo($aWhere);
        if (@sizeof($visitorPrimaryInfo) == 0) {
            $this->set_response(array(
                'status' => FALSE,
                'message' => 'Sorry, Visitor PrimaryInfo not found.'
                ), REST_Controller::HTTP_OK);
            return;
        }        
        if (!is_null($this->post('room_number'))) {
            $primaryParams = array(
                'roomNumber' => $this->post('room_number'),
                'sos'   => $this->post('sos'),
                'updatedBy' => $authenticate->id,
                'updatedOn' => DATETIME
            );

            if(valid_number($this->post('visitor_id')) && $authenticate->typeId == 8){
                $updateVrisitorPrimaryInfo = $this->visitors_model->updateVisitorPrimaryInfo($primaryParams, $aWhere);
            } else {
                $aWhere1 = array('id' => $this->post('id'));
                $visitorRoomInfo = $this->visitors_model->getCheckinRoomInfo($aWhere1);
                if (@sizeof($visitorRoomInfo) == 0) {
                    $this->set_response(array(
                        'status' => FALSE,
                        'message' => 'Sorry, Visitors checkin not found.'
                        ), REST_Controller::HTTP_OK);
                    return;
                }
                $params = array(
                    'visitorId' => $this->post('visitor_id'),
                    'roomNumber' => $this->post('room_number')
                );
                $updateCheckin = $this->visitors_model->updateCheckinRoomInfo($params, $aWhere1);
                if($updateCheckin){
                    $primaryParams['roomNumber'] = str_replace($visitorRoomInfo->roomNumber, $this->post('room_number'), $visitorPrimaryInfo->roomNumber);
                    $updateVrisitorPrimaryInfo = $this->visitors_model->updateVisitorPrimaryInfo($primaryParams, $aWhere);
                }
            }
            if (isset($updateVrisitorPrimaryInfo)) {
                $this->response([
                    'status' => TRUE,
                    'message' => 'Visitor checkin updated successfully!'
                    ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Unable to update the visitor checkin details'
                    ], REST_Controller::HTTP_OK);
            }
            
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Room number(s) not found'
                ], REST_Controller::HTTP_OK);
        }
    }

    public function primaryVisitor_get() {
        $headers = apache_request_headers();
        $token = $headers['Token'];
        //$token = $this->input->get_request_header('Authorization');
        if (isset($token) && ! empty($token)) {

            $aWhere = array('token' => $token);
            $authenticate = $this->accommodations_model->getAccommodationInfo($aWhere);

            if (@sizeof($authenticate) == 1) {
                $aWhere1 = array('phoneNumber' => $this->get('phone_number'), 'status' => 0);
                $primaryInfo = $this->visitors_model->getLatestPrimaryInfo($aWhere1);
                if (@sizeof($primaryInfo) > 0) {
                    $visitor = $this->visitors_model->getPrimaryVisitorInfo(array('vpId' => $primaryInfo->id));
                    if (@sizeof($visitor) == 1) {
                        $this->set_response(array(
                            'status' => TRUE,
                            'primaryVisitor' => $visitor
                            ), REST_Controller::HTTP_OK);
                    } else {
                        $this->set_response(array(
                            'status' => FALSE,
                            'message' => 'Visitor not found'
                            ), REST_Controller::HTTP_OK);
                    }
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'Checkin already exist with this number'
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

    public function index_post() {
        set_time_limit(180);
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

                        if ( ! empty($_FILES['visitor_photo']['name'])) {
                            $filename1 = clear_string($_FILES['visitor_photo']['name']);
                            $tmpname1 = $_FILES['visitor_photo']['tmp_name'];
                            $photoOfVisitor = $this->visitors_model->upload_image($filename1, $tmpname1);
                        } else {
                            $photoOfVisitor = $this->post('visitor_photo');
                        }

                        if ( ! empty($_FILES['id_proof_photo_front']['name'])) {
                            $filename2 = clear_string($_FILES['id_proof_photo_front']['name']);
                            $tmpname2 = $_FILES['id_proof_photo_front']['tmp_name'];
                            $idProofPhotoFront = $this->visitors_model->upload_image($filename2, $tmpname2);
                        } else {
                            $idProofPhotoFront = $this->post('id_proof_photo_front');
                        }

                        if ( ! empty($_FILES['id_proof_photo_back']['name'])) {
                            $filename3 = clear_string($_FILES['id_proof_photo_back']['name']);
                            $tmpname3 = $_FILES['id_proof_photo_back']['tmp_name'];
                            $idProofPhotoBack = $this->visitors_model->upload_image($filename3, $tmpname3);
                        } else {
                            $idProofPhotoBack = $this->post('id_proof_photo_back');
                        }
                        
                        if ( ! empty($_FILES['visa_expiry_page']['name'])) {
                            $filename4 = clear_string($_FILES['visa_expiry_page']['name']);
                            $tmpname4 = $_FILES['visa_expiry_page']['tmp_name'];
                            $visaExpiryPage = $this->visitors_model->upload_image($filename4, $tmpname4);
                        } else {
                            $visaExpiryPage = $this->post('visa_expiry_page');
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
                            'visaExpiryPage' => $visaExpiryPage,
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
                            $id = $this->visitors_model->getInsertedID();
                            if ($authenticate->typeId == 8) {
                                $checkinParams = array(
                                    'vpId' => $this->post('vp_id'),
                                    'visitorId' => $id,
                                    'checkIn' => DATETIME
                                );
                                $this->visitors_model->storeCheckinRoomInfo($checkinParams);
                            }
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

    public function checkOut_get() {
        $headers = apache_request_headers();
        $token = $headers['Token'];
        //$token = $this->input->get_request_header('Authorization');
        if (isset($token) && ! empty($token)) {

            $aWhere = array('token' => $token);
            $authenticate = $this->accommodations_model->getAccommodationInfo($aWhere);

            if (@sizeof($authenticate) == 1) {

                $id = $this->get('primary_id');
                $visitorId = $this->get('visitor_id');
                $roomNumber = $this->get('room_number');

                $aWhere1 = array('id' => $id, 'checkOut' => NULL);
                $visitoPrimaryInfo = $this->visitors_model->getVisitorPrimaryInfo($aWhere1);

                if (@sizeof($visitoPrimaryInfo) > 0) {
                    $params = array(
                        'status' => 0,
                        'checkOut' => DATETIME,
                        'updatedBy' => $authenticate->id,
                        'updatedOn' => DATETIME
                    );
                    $aWhere2 = array('vpId' => $id, 'checkOut' => NULL);
                    $checkOutparams = array('checkOut' => DATETIME);
                    $checkins = $this->visitors_model->countAllCheckinRooms($aWhere2);
                    if ($authenticate->typeId == 8) {
                        $aWhereCheckOut = array_merge($aWhere2, array('visitorId' => $visitorId));
                    } else {
                        $aWhereCheckOut = array_merge($aWhere2, array('roomNumber' => $roomNumber));
                    }
                    if ($checkins > 0) {
                        $checkOut = $this->visitors_model->updateCheckinRoomInfo($checkOutparams, $aWhereCheckOut);
                        if ($checkOut && $checkins == 1) {
                            $this->visitors_model->updateVisitorPrimaryInfo($params, $aWhere1);
                        }
                    } else {
                        $checkOut = $this->visitors_model->updateVisitorPrimaryInfo($params, $aWhere1);
                    }
                    if ($checkOut) {
                        if($authenticate->status == 0){
                            $this->accommodations_model->updateAccommodationInfo(array('status' => 1), $aWhere);
                        }
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
