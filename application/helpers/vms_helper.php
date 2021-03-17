<?php
if ( ! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

if ( ! function_exists('basicAuthorizationToken')) {

    function basicAuthorizationToken() {
        return encode('VMS©VISITOR_MANAGEMENT_SYSTEM');
    }

}

if ( ! function_exists('generateAuthorizationToken')) {

    function generateAuthorizationToken($str) {
        return encode('VMS©' . $str);
    }

}

if ( ! function_exists('basicSiteString')) {

    function basicSiteString() {
        return 'VMS©VISITOR_MANAGEMENT_SYSTEM';
    }

}

if(! function_exists('date_timestamp')){
    function date_timestamp() {
        return date("YmdHis");
    }
    
}

if(! function_exists('valid_timestamp')){
    function valid_timestamp() {
        return strtotime("+1 day");
    }
    
}

if (!function_exists('app_version')) {

    function app_version() {
        $CI = & get_instance();
        $CI->load->model('superadmin/accommodations_model');
        $version = $CI->accommodations_model->applicationVersion();
        return $version->version;
    }
}

if (!function_exists('accommodation_types')) {

    function accommodation_types() {
        $CI = & get_instance();
        $CI->load->model('superadmin/accommodations_model');
        return $CI->accommodations_model->getAllAccommodationTypes();
    }
}

if(! function_exists('loginUser')){
    function loginUser() {
        $CI = & get_instance();
        $sessionData = get_session_data();
        $aWhere = array('id' => decode($sessionData['loginID']));
        $CI->load->model('superadmin/admin_model');
        $loginUser = $CI->admin_model->getAdminInfo($aWhere);
        if(@sizeof($loginUser) == 0){
            $CI->session->set_flashdata('error','Invalid account, please login again');
            redirect('admin/login');
        }
        return $loginUser;
    }
}
if (!function_exists('da')) {

    function da($data) {
        echo "<PRE>";
        print_r($data);
    }
}