<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Accommodations extends REST_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('accommodations_model');
        $this->load->model('visitors_model');
    }

    public function index_get() {
        $headers = apache_request_headers();
        $token = $headers['Token'];
        //$token = $this->input->get_request_header('Authorization');
        if ( ! isset($token) || $token != encode(basicSiteString())) {
            $this->set_response(array(
                'status' => FALSE,
                'message' => 'Sorry, it seems like you entered wrong credentials'
                ), REST_Controller::HTTP_UNAUTHORIZED);
            return;
        }
        $aWhere = array('id' => $this->get('id'));
        $accommodation = $this->accommodations_model->getAccommodationInfo($aWhere);
        if (@sizeof($accommodation) == 1) {
            $this->set_response(array(
                'status' => TRUE,
                'message' => 'Accommodation loaded successfully!',
                'accommodation' => $accommodation
                ), REST_Controller::HTTP_OK);
        } else {
            $this->set_response(array(
                'status' => FALSE,
                'message' => 'Oops, could not login, please verify your number and try again'
                ), REST_Controller::HTTP_OK);
        }
    }
    
    public function types_get() {
        $headers = apache_request_headers();
        $token = $headers['Token'];
        //$token = $this->input->get_request_header('Authorization');
        if ( ! isset($token) || $token != encode(basicSiteString())) {
            $this->set_response(array(
                'status' => FALSE,
                'message' => 'Sorry, it seems like you entered wrong credentials'
                ), REST_Controller::HTTP_UNAUTHORIZED);
            return;
        }
        $accommodationTypes = $this->accommodations_model->getAllAccommodationTypes();
        if (@sizeof($accommodationTypes) == 1) {
            $this->set_response(array(
                'status' => TRUE,
                'message' => 'Accommodation types loaded successfully!',
                'accommodationTypes' => $accommodationTypes
                ), REST_Controller::HTTP_OK);
        } else {
            $this->set_response(array(
                'status' => FALSE,
                'message' => 'Accommodation types not found'
                ), REST_Controller::HTTP_OK);
        }
    }
    
    public function filter_get() {
        $headers = apache_request_headers();
        $token = $headers['Token'];
        //$token = $this->input->get_request_header('Authorization');
        if ( ! isset($token) || $token != encode(basicSiteString())) {
            $this->set_response(array(
                'status' => FALSE,
                'message' => 'Sorry, it seems like you entered wrong credentials'
                ), REST_Controller::HTTP_UNAUTHORIZED);
        } else {
            $aWhere = array(
                'city' => $this->get('city'),
                'SHOArea' => $this->get('sho_area'),
                'zone' => $this->get('zone')
            );
            $accommodations = $this->accommodations_model->filterAccommodations($aWhere);
            $this->set_response(array(
                'status' => TRUE,
                'accommodations' => $accommodations
            ), REST_Controller::HTTP_OK);
        }
    }
    
    public function search_get() {
        $headers = apache_request_headers();
        $token = $headers['Token'];
        //$token = $this->input->get_request_header('Authorization');
        if ( ! isset($token) || $token != encode(basicSiteString())) {
            $this->set_response(array(
                'status' => FALSE,
                'message' => 'Sorry, it seems like you entered wrong credentials'
                ), REST_Controller::HTTP_UNAUTHORIZED);
        } else {
             $name = $this->get('name');
            if(! is_string($name) || empty($name)){
                $this->set_response(array(
                   'status' => FALSE,
                   'message' => 'Worng inputs'
               ), REST_Controller::HTTP_OK);
            } else {
               $accommodations = $this->accommodations_model->searchAccommodations($name);
               $this->set_response(array(
                   'status' => TRUE,
                   'accommodations' => $accommodations
               ), REST_Controller::HTTP_OK); 
            }
        }
    }
    
    public function sendOTP_post() {
        $headers = apache_request_headers();
        $token = $headers['Token'];
        //$token = $this->input->get_request_header('Authorization');
        if ( ! isset($token) || $token != encode(basicSiteString())) {
            $this->set_response(array(
                'status' => FALSE,
                'message' => 'Sorry, it seems like you entered wrong credentials'
                ), REST_Controller::HTTP_UNAUTHORIZED);
            exit(0);
        }

        $otp = uniqueotp();
        $phoneNumber = $this->post('phone_number');
        $aWhere = array('phoneNumber' => $phoneNumber);
        $accommodation = $this->accommodations_model->getAccommodationInfo($aWhere);
        if (@sizeof($accommodation) == 1) {
            $this->set_response(array(
                'status' => FALSE,
                'message' => 'Sorry, This phone number already registered, please try to sign In.'
                ), REST_Controller::HTTP_OK);
        } else {
            $params = array('phoneNumber' => $phoneNumber, 'otp' => $otp);
            $checkOTP = $this->accommodations_model->getAccommodationOTP($aWhere);
            if (@sizeof($checkOTP) == 1) {
                $storeOTP = $this->accommodations_model->updateAccommodationOTP($params, $aWhere);
            } else {
                $storeOTP = $this->accommodations_model->storeAccommodationOTP($params);
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
            exit(0);
        }
        $otp = $this->post('otp');
        $phoneNumber = $this->post('phone_number');
        $aWhere = array('phoneNumber' => $phoneNumber, 'otp' => $otp);
        $checkOTP = $this->accommodations_model->getAccommodationOTP($aWhere);
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
    }

    public function signUp_post() {
        $headers = apache_request_headers();
        $token = $headers['Token'];
        //$token = $this->input->get_request_header('Authorization');
        if ( ! isset($token) || $token != encode(basicSiteString())) {
            $this->set_response(array(
                'status' => FALSE,
                'message' => 'Sorry, it seems like you entered wrong credentials'
                ), REST_Controller::HTTP_UNAUTHORIZED);
        } else {
            $aWhere = array('phoneNumber' => $this->post('phone_number'));
            $accommodation = $this->accommodations_model->getAccommodationInfo($aWhere);
            if(@sizeof($accommodation) > 0){
                $this->set_response(array(
                    'status' => FALSE,
                    'message' => 'Accommodation already having with this phone number, please signIn'
                    ), REST_Controller::HTTP_OK);
            } else {
                $aWhere1 = array('zone' => $this->post('zone'), 'station' => $this->post('station'));
                $getZone = $this->accommodations_model->getZone($aWhere1);
                if (@sizeof($getZone) != 1) {
                    $this->set_response(array(
                        'status' => FALSE,
                        'message' => 'Zone not found'
                        ), REST_Controller::HTTP_OK);
                } else {

                    if ( ! empty($_FILES['accommodation_photo']['name'])) {
                        $filename = clear_string($_FILES['accommodation_photo']['name']);
                        $tmpname = $_FILES['accommodation_photo']['tmp_name'];
                        $accommodationPhoto = $this->accommodations_model->upload_image($filename, $tmpname);

                        $params = array(
                            'typeId' => $this->post('type_id'),
                            'type' => $this->post('type'),
                            'name' => $this->post('name'),
                            'email' => $this->post('email'),
                            'phoneNumber' => $this->post('phone_number'),
                            'token' => generateAuthorizationToken($this->post('phone_number')),
                            'photo' => $accommodationPhoto,
                            'noOfRooms' => $this->post('no_of_rooms'),
                            'address' => $this->post('address'),
                            'pincode' => $this->post('pincode'),
                            'latitude' => $this->post('latitude'),
                            'longitude' => $this->post('longitude'),
                            'availableHardware' => $this->post('available_hardware'),
                            'registrationDate' => date("Y-m-d", strtotime($this->post('registration_date'))),
                            'grade' => $this->post('grade'),
                            'city' => $getZone->district,
                            'state' => 'Telangana',
                            'zone' => $this->post('zone'),
                            'country' => 'India',
                            'SHOArea' => $this->post('station'),
                            'circle' => $getZone->division,
                            'ownerName' => $this->post('owner_name'),
                            'ownerPhoneNumber' => $this->post('owner_phone_number'),
                            'ownerEmail' => $this->post('owner_email'),
                            'ownerAadharNumber' => $this->post('owner_aadhar_number'),
                            'ownerAddress' => $this->post('owner_address'),
                            'createdOn' => DATETIME
                        );

                        $storeAccommodationInfo = $this->accommodations_model->storeAccommodationInfo($params);
                        if ($storeAccommodationInfo) {
                            $params['id'] = $this->accommodations_model->getInsertedID();
                            $this->response([
                                'status' => TRUE,
                                'message' => 'Accommodation added successfully!',
                                'data' => ['accommodation' => $params]
                                ], REST_Controller::HTTP_OK);
                        } else {
                            $this->accommodations_model->delete_image($accommodationPhoto);
                            $this->response([
                                'status' => FALSE,
                                'message' => 'Accommodation adding failed!',
                                ], REST_Controller::HTTP_OK);
                        }
                    } else {
                        $this->response([
                            'status' => FALSE,
                            'message' => 'Please choose accommodation image',
                            ], REST_Controller::HTTP_OK);
                    }
                }
            }
        }
    }
    
    public function profile_get() {
        $headers = apache_request_headers();
        $token = $headers['Token'];
        //$token = $this->input->get_request_header('Authorization');
        if ( ! isset($token) || empty($token)) {
            $this->set_response(array(
                'status' => FALSE,
                'message' => 'Sorry, it seems like you entered wrong credentials'
                ), REST_Controller::HTTP_UNAUTHORIZED);
            exit(0);
        }
        $aWhere = array('token' => $token);
        $accommodation = $this->accommodations_model->getAccommodationInfo($aWhere);
        if (@sizeof($accommodation) == 1) {
            $appVersion = $this->accommodations_model->applicationVersion();
            $todayCheckins = $this->visitors_model->getAllCheckinsByAccommodation($accommodation->id, DATE);
            $totalCheckins = $this->visitors_model->getAllCheckinsByAccommodation($accommodation->id);
            $accommodation->todayCheckins = count($todayCheckins);
            $accommodation->totalCheckins = count($totalCheckins);
            $accommodation->filledRooms   = count($totalCheckins);
            $accommodation->appVersion    = $appVersion->version;
            $this->set_response(array(
                'status' => TRUE,
                'message' => 'Accommodation loaded successfully',
                'data' => array('accommodation' => $accommodation)
                ), REST_Controller::HTTP_OK);
        } else {
            $this->set_response(array(
                'status' => FALSE,
                'message' => 'Oops, could not login, please verify your number and try again'
                ), REST_Controller::HTTP_OK);
        }
    }
    
    public function update_post() {
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
            if(@sizeof($accommodation) == 0){
                $this->set_response(array(
                    'status' => FALSE,
                    'message' => 'Oops, could not login, please verify your number and try again'
                    ), REST_Controller::HTTP_OK);
            } else {
                $todayCheckins = $this->visitors_model->getAllCheckinsByAccommodation($accommodation->id, DATE);
                $totalCheckins = $this->visitors_model->getAllCheckinsByAccommodation($accommodation->id);
                $accommodation->todayCheckins = count($todayCheckins);
                $accommodation->totalCheckins = count($totalCheckins);
                $accommodation->filledRooms   = count($totalCheckins);
                $aWhere1 = array('zone' => $this->post('zone'), 'station' => $this->post('station'));
                $getZone = $this->accommodations_model->getZone($aWhere1);
                if (@sizeof($getZone) != 1) {
                    $this->set_response(array(
                        'status' => FALSE,
                        'message' => 'Zone not found'
                        ), REST_Controller::HTTP_OK);
                } else {
                    $filename = NULL;
                    if ( ! empty($_FILES['accommodation_photo']['name'])) {
                        $filename = clear_string($_FILES['accommodation_photo']['name']);
                        $tmpname = $_FILES['accommodation_photo']['tmp_name'];
                        $accommodationPhoto = $this->accommodations_model->upload_image($filename, $tmpname);
                    } else {
                        $accommodationPhoto = $accommodation->photo;
                    }
                    $params = array(
                        'email' => $this->post('email'),
                        'photo' => $accommodationPhoto,
                        'noOfRooms' => $this->post('no_of_rooms'),
                        'address' => $this->post('address'),
                        'pincode' => $this->post('pincode'),
                        'latitude' => $this->post('latitude'),
                        'longitude' => $this->post('longitude'),
                        'availableHardware' => $this->post('available_hardware'),
                        'registrationDate' => date("Y-m-d", strtotime($this->post('registration_date'))),
                        'grade' => $this->post('grade'),
                        'city' => $getZone->district,
                        'state' => $this->post('state'),
                        'zone' => $this->post('zone'),
                        'country' => $this->post('country'),
                        'SHOArea' => $this->post('station'),
                        'circle' => $getZone->division,
                        'ownerName' => $this->post('owner_name'),
                        'ownerPhoneNumber' => $this->post('owner_phone_number'),
                        'ownerEmail' => $this->post('owner_email'),
                        'ownerAadharNumber' => $this->post('owner_aadhar_number'),
                        'ownerAddress' => $this->post('owner_address'),
                        'updatedBy' => $accommodation->id,
                        'updatedOn' => DATETIME
                    );
                    $updateAccommodationInfo = $this->accommodations_model->updateAccommodationInfo($params, $aWhere);
                    if ($updateAccommodationInfo) {
                        if(! is_null($filename)){
                            $this->accommodations_model->delete_image($accommodation->photo);
                        }
                        $this->response([
                            'status' => TRUE,
                            'message' => 'Accommodation updated successfully!',
                            'data' => array('accommodation' => array_merge(json_decode(json_encode($accommodation), TRUE), $params))
                            ], REST_Controller::HTTP_OK);
                    } else {
                        $this->accommodations_model->delete_image($filename);
                        $this->response([
                            'status' => FALSE,
                            'message' => 'Accommodation updated failed!',
                            ], REST_Controller::HTTP_OK);
                    }
                }
            }
        }
    }
    
    public function updateByAdmin_post() {
        $headers = apache_request_headers();
        $token = $headers['Token'];
        //$token = $this->input->get_request_header('Authorization');
        if ( ! isset($token) || $token != encode(basicSiteString())) {
            $this->set_response(array(
                'status' => FALSE,
                'message' => 'Sorry, it seems like you entered wrong credentials'
                ), REST_Controller::HTTP_UNAUTHORIZED);
        } else {
            $aWhere = array('id' => $this->post('id'));
            $accommodation = $this->accommodations_model->getAccommodationInfo($aWhere);
            if(@sizeof($accommodation) == 0){
                $this->set_response(array(
                    'status' => FALSE,
                    'message' => 'Oops, could not login, please verify your number and try again'
                    ), REST_Controller::HTTP_OK);
            } else {
                $aWhere1 = array('zone' => $this->post('zone'), 'station' => $this->post('station'));
                $getZone = $this->accommodations_model->getZone($aWhere1);
                if (@sizeof($getZone) != 1) {
                    $this->set_response(array(
                        'status' => FALSE,
                        'message' => 'Zone not found'
                        ), REST_Controller::HTTP_OK);
                } else {
                    $filename = NULL;
                    if ( ! empty($_FILES['accommodation_photo']['name'])) {
                        $filename = clear_string($_FILES['accommodation_photo']['name']);
                        $tmpname = $_FILES['accommodation_photo']['tmp_name'];
                        $accommodationPhoto = $this->accommodations_model->upload_image($filename, $tmpname);
                    } else {
                        $accommodationPhoto = $accommodation->photo;
                    }
                    $params = array(
                        'email' => $this->post('email'),
                        'photo' => $accommodationPhoto,
                        'noOfRooms' => $this->post('no_of_rooms'),
                        'address' => $this->post('address'),
                        'pincode' => $this->post('pincode'),
                        'latitude' => $this->post('latitude'),
                        'longitude' => $this->post('longitude'),
                        'availableHardware' => $this->post('available_hardware'),
                        'registrationDate' => date("Y-m-d", strtotime($this->post('registration_date'))),
                        'grade' => $this->post('grade'),
                        'city' => $getZone->district,
                        'state' => $this->post('state'),
                        'zone' => $this->post('zone'),
                        'country' => $this->post('country'),
                        'SHOArea' => $this->post('station'),
                        'circle' => $getZone->division,
                        'ownerName' => $this->post('owner_name'),
                        'ownerPhoneNumber' => $this->post('owner_phone_number'),
                        'ownerEmail' => $this->post('owner_email'),
                        'ownerAadharNumber' => $this->post('owner_aadhar_number'),
                        'ownerAddress' => $this->post('owner_address'),
                        'updatedBy' => $accommodation->id,
                        'updatedOn' => DATETIME
                    );
                    $updateAccommodationInfo = $this->accommodations_model->updateAccommodationInfo($params, $aWhere);
                    if ($updateAccommodationInfo) {
                        if(! is_null($filename)){
                            $this->accommodations_model->delete_image($accommodation->photo);
                        }
                        $this->response([
                            'status' => TRUE,
                            'message' => 'Accommodation updated successfully!',
                            'data' => array('accommodation' => array_merge(json_decode(json_encode($accommodation), TRUE), $params))
                            ], REST_Controller::HTTP_OK);
                    } else {
                        $this->accommodations_model->delete_image($filename);
                        $this->response([
                            'status' => FALSE,
                            'message' => 'Accommodation updated failed!',
                            ], REST_Controller::HTTP_OK);
                    }
                }
            }
        }
    }

    public function delete_get() {
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
                $aWhere1 = array('accommodationId' => $accommodation->id);
                $visitorPrimaryInfo = $this->visitors_model->getAllVisitorPrimaryInfo($aWhere1);
                if (@sizeof($visitorPrimaryInfo) > 0) {
                    foreach ($visitorPrimaryInfo as $value) {
                        $visitors = $this->visitors_model->getAllVisitorsInfo(array('vpId' => $value->id));
                        if (@sizeof($visitors) > 0) {
                            foreach ($visitors as $visitor) {
                                $this->visitors_model->deleteVisitor(array('id' => $visitor->id));
                                $this->visitors_model->delete_image($visitor->photoOfVisitor);
                                $this->visitors_model->delete_image($visitor->idProofPhotoFront);
                                $this->visitors_model->delete_image($visitor->idProofPhotoBack);
                            }
                        }
                        $this->visitors_model->deleteVisitorRoomCheckins(array('vpId' => $value->id));
                        $this->visitors_model->deleteVisitorPrimaryInfo(array('id' => $value->id));
                    }
                }
                $remove = $this->accommodations_model->deleteAccommodation($aWhere);
                if ($remove) {
                    $this->accommodations_model->delete_image($accommodation->photo);
                    $this->set_response(array(
                        'status' => TRUE,
                        'message' => 'Accommodation removed successfully!'
                        ), REST_Controller::HTTP_OK);
                } else {
                    $this->set_response(array(
                        'status' => FALSE,
                        'message' => 'Unable to remove accommodation please try again later'
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
    
    private function readCSV($csvFile) {
        $file_handle = fopen($csvFile, 'r');
        while ( ! feof($file_handle)) {
            $line_of_text[] = fgetcsv($file_handle, 1024);
        }
        fclose($file_handle);
        return $line_of_text;
    }

    public function import_post() {
        $headers = apache_request_headers();
        $token = $headers['Token'];
        //$token = $this->input->get_request_header('Authorization');
        if ( ! isset($token) || $token != encode(basicSiteString())) {
            $this->set_response(array(
                'status' => FALSE,
                'message' => 'Sorry, it seems like you entered wrong credentials'
                ), REST_Controller::HTTP_UNAUTHORIZED);
        } else {
            set_time_limit(0);
            $this->load->helper('url');
            $filename = $_FILES["file"]["tmp_name"];
            if ($_FILES["file"]["size"] > 0) {
                $readCSV = $this->readCSV($filename);
                if ( ! empty($readCSV)) {
                    foreach ($readCSV as $importdata) {
                        if ( ! empty($importdata)) {
                            $getZone = $this->accommodations_model->getZone(array('station' => trim($importdata[17])));
                            $params = array(
                                'type'      => trim(ucwords(strtolower($importdata[1]))),
                                'name'      => trim($importdata[2]),
                                'address'   => trim($importdata[3]),
                                'pincode'   => trim($importdata[4]),
                                'phoneNumber' => trim($importdata[5]),
                                'email' => trim($importdata[6]),
                                'token'     => generateAuthorizationToken(trim($importdata[5])),
                                'noOfRooms' => trim($importdata[9]),
                                'availableHardware' => trim($importdata[10]),
                                'registrationDate' => trim($importdata[11]),
                                'grade' => trim($importdata[12]),
                                'city'      => ! empty($getZone) ? $getZone->district : trim($importdata[13]),
                                'state'     => 'Telangana',//trim($importdata[14]),
                                'country'   => 'India', //trim($importdata[15]),
                                'zone'      => ! empty($getZone) ? $getZone->zone : trim($importdata[16]),
                                'SHOArea'   => ! empty($getZone) ? $getZone->station : trim($importdata[17]),
                                'circle'    => ! empty($getZone) ? $getZone->division : trim($importdata[18]),
                                'ownerName' => trim($importdata[19]),
                                'ownerPhoneNumber' => trim($importdata[20]),
                                'ownerEmail' => trim($importdata[21]),
                                'ownerAadharNumber' => trim($importdata[22]),
                                'ownerAddress' => trim($importdata[23]),
                                'latitude' => trim($importdata[24]),
                                'longitude' => trim($importdata[25]),
                                'createdBy' => trim($importdata[0]),
                                'createdOn' => DATETIME,
                                'updatedBy' => trim($importdata[0]),
                                'updatedOn' => DATETIME
                            );
                            
                            $aWhere = array('id' => trim($importdata[0]));
                            $accommodation = $this->accommodations_model->getAccommodationInfo($aWhere);
                            if(@sizeof($accommodation) == 1){
                                $storeAccommodationInfo = $this->accommodations_model->updateAccommodationInfo($params, $aWhere);
                            } else {
                                $storeAccommodationInfo = $this->accommodations_model->storeAccommodationInfo($params);
                            }
                        }
                    }
                    if (isset($storeAccommodationInfo)) {
                        $this->response([
                            'status' => TRUE,
                            'message' => 'Accommodation added successfully!'
                            ], REST_Controller::HTTP_OK);
                    } else {
                        $this->response([
                            'status' => FALSE,
                            'message' => 'Accommodation adding failed!',
                            ], REST_Controller::HTTP_OK);
                    }
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'The file does not have any data..',
                        ], REST_Controller::HTTP_OK);
                }
                $this->response([
                    'status' => TRUE,
                    'message' => 'Data are imported successfully..',
                    ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => TRUE,
                    'message' => 'Something went wrong..',
                    ], REST_Controller::HTTP_OK);
            }
        }
    }

}
