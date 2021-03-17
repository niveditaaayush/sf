<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
global $previous_url;

//check is logged in or not
if (!function_exists('login_check')) {

    function login_check($user_type = 'admin', $logged_in_status = TRUE) {
        if ($user_type == 'superadmin') {
            if ($logged_in_status) {
                if (!is_admin_logged_in()) {
                    if (is_user_logged_in()) {
                        redirect('admin/dashboard');
                    } else {
                        redirect('admin/login');
                    }
                }
            } else if (is_logged_in()) {
                redirect_dashboard($user_type);
            }
        } else {
            if ($logged_in_status) {
                if (!is_user_logged_in()) {
                    if (is_admin_logged_in()) {
                        redirect('superadmin/dashboard');
                    } else {
                        redirect('superadmin/login');
                    }
                }
            } else if (is_logged_in()) {
                redirect_dashboard($user_type);
            }
        }
    }

}
//redirect home/login page
if (!function_exists('redirect_loginpage')) {

    function redirect_loginpage($user_type = 'admin') {
        if ($user_type == 'superadmin') {
            redirect('superadmin/login');
        } else {
            redirect('admin/login');
        }
    }

}
//redirect dashboard
if (!function_exists('redirect_dashboard')) {

    function redirect_dashboard($user_type = 'admin') {
        if ($user_type == 'superadmin') {
            redirect('superadmin/dashboard');
        } else {
            redirect('admin/dashboard');
        }
        redirect('admin/login');
    }

}
//check is user/admin logged in or not
if (!function_exists('is_logged_in')) {

    function is_logged_in() {
        return (is_user_logged_in() OR is_admin_logged_in()) ? TRUE : FALSE;
    }

}
//check is user logged in or not
if (!function_exists('is_user_logged_in')) {

    function is_user_logged_in() {
        $CI = &get_instance();
        return isset($CI->session->userdata['logged_in']) ? TRUE : FALSE;
    }

}
//check is admin logged in or not
if (!function_exists('is_admin_logged_in')) {

    function is_admin_logged_in() {
        $CI = &get_instance();
        return isset($CI->session->userdata['adminlogged_in']) ? TRUE : FALSE;
    }

}
//getting session data
if (!function_exists('get_session_data')) {

    function get_session_data() {
        $CI = &get_instance();
        if (is_user_logged_in()) {
            return $CI->session->userdata['logged_in'];
        } else if (is_admin_logged_in()) {
            return $CI->session->userdata['adminlogged_in'];
        }
        return array();
    }

}
//setting session data
if (!function_exists('set_session_data')) {

    function set_session_data($new_data = array(), $update = FALSE) {
        $CI = &get_instance();
        if (is_array($new_data) && !empty($new_data)) {
            $session_data = get_session_data();
            foreach ($new_data as $key => $val) {
                if ($update) {
                    if (isset($session_data[$key]))
                        $session_data[$key] = $val;
                }
                else {
                    $session_data[$key] = $val;
                }
            }
            _update_session($CI, $session_data);
        }
        return;
    }

}
//update sesion data
if (!function_exists('update_session_data')) {

    function update_session_data($upd_data = array()) {
        if (is_array($upd_data) && !empty($upd_data))
            return set_session_data($upd_data, TRUE);
        return;
    }

}
//unsetting session data
if (!function_exists('unset_session_data')) {

    function unset_session_data($rem_data = array()) {
        $CI = &get_instance();
        if (is_array($rem_data) && !empty($rem_data)) {
            $session_data = get_session_data();
            foreach ($rem_data as $key => $val) {
                if (isset($session_data[$key]))
                    unset($session_data[$key]);
            }
            _update_session($CI, $session_data);
        }
        return;
    }

}

function _update_session($CI, $session_data) {
    if (is_user_logged_in()) {
        $CI->session->set_userdata('logged_in', $session_data);
    } else if (is_admin_logged_in()) {
        $CI->session->set_userdata('adminlogged_in', $session_data);
    }
}

//setting a server space
if (!function_exists('get_file_size')) {

    function get_file_size($path = '') {
        $size = exec('du -sk ' . $path);
        preg_match('/\d+/', $size, $res_in_kb);
        $KB = isset($res_in_kb[0]) ? $res_in_kb[0] : 0;
        //return ($KB * 1024);
        //in bytes
        return $KB; // in KB
    }

}

if(! function_exists('folder_size')) {
    function folder_size ($dir) {
        $size = 0;
        foreach (glob(rtrim($dir, '/').'/*', GLOB_NOSORT) as $each) {
            $size += is_file($each) ? filesize($each) : folderSize($each);
        }
        return $size;
    }    
}
//getting a client ip
if (!function_exists('get_ip_address')) {

    function get_ip_address() {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARTDED_FOR'] != '') {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
        return (isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : '';
    }

}
//getting a client geo info(browser,ip,city,state,country)
if (!function_exists('get_geo_info')) {

    function get_geo_info() {
        $geo_details = '';
        $ip = get_ip_address();
        if ($ip != '') {
            $geo_details = json_decode(file_get_contents("http://ipinfo.io/{$ip}"));
        }
        return $geo_details;
    }

}
//getting a client geo info(browser,ip,city,state,country)
if (!function_exists('set_headers')) {

    function set_headers() {
        $CI = &get_instance();
        $CI->output->set_header("HTTP/1.0 200 OK");
        $CI->output->set_header("HTTP/1.1 200 OK");
        $CI->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
        $CI->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $CI->output->set_header("Cache-Control: post-check=0, pre-check=0");
        $CI->output->set_header("Pragma: no-cache");
    }

}
/* End of file logincheck.php */
/* Location: ./system/helpers/logincheck.php */
