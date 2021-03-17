<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Authenticate extends REST_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('authentication_model');
    }

    public function index_get() {
        $token = $this->input->get_request_header('Authorization');
        if ( ! empty($token) && $token === basicAuthorizationToken()) {
            $getToken = $this->authentication_model->getAuthenticationInfo();
            if(@sizeof($getToken) === 1) {
                $token = encode(basicAuthorizationToken(date_timestamp().basicSiteString()));
                $params = array(
                    'token' => $token,
                    'validity' => valid_timestamp()
                );
                $updateToken = $this->authentication_model->updateAuthenticationInfo($params);
                if(!$updateToken){
                    $this->response([
                    'status' => REST_Controller::HTTP_OK,
                    'message' => 'Token generate failed please try again later'
                    ], REST_Controller::HTTP_OK);
                }
                $this->response([
                'status' => REST_Controller::HTTP_OK,
                'message' => "Token Generated",
                'token' => $token,
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => REST_Controller::HTTP_BAD_REQUEST,
                    'message' => 'Invalid Authentication'
                    ], REST_Controller::HTTP_BAD_REQUEST);
            }
            
        } else {
            $this->response([
                'status' => REST_Controller::HTTP_UNAUTHORIZED,
                'message' => 'Invalid Authentication'
                ], REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

}
