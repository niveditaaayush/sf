<?php
if ( ! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

if ( ! function_exists('uniqueToken')) {

    function uniqueToken() {
        return md5(uniqid() . microtime() . rand());
    }

}

if (!function_exists('old_uniqueotp')) {

    function old_uniqueotp() {
        $length = 6;
        $characters = '123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}

if (!function_exists('uniqueotp')) {

    function uniqueotp() {
        $length = 4;
        $characters = '123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}

/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 */
if ( ! function_exists('getPassword')) {

    function getPassword($plainPassword) {
        return password_hash($plainPassword, PASSWORD_BCRYPT);
    }

}
/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 * @param {string} $hashedPassword : This is hashed password
 */
if ( ! function_exists('verifyPassword')) {

    function verifyPassword($plainPassword, $hashedPassword) {
        return password_verify($plainPassword, $hashedPassword) ? TRUE : FALSE;
    }

}

if ( ! function_exists('string')) {

    function string($str) {
        return trim(preg_replace('/ +/', '', preg_replace('/[^A-Za-z]/', '', urldecode(html_entity_decode(strip_tags($str))))));
    }

}

if ( ! function_exists('string_spaces')) {

    function string_spaces($str) {
        return trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z]/', ' ', urldecode(html_entity_decode(strip_tags($str))))));
    }

}

if (!function_exists('clear_string')) {

    function clear_string($str) {
        return trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9.]/', '-', urldecode(html_entity_decode(strip_tags($str))))));
    }

}

if ( ! function_exists('remove_html_tags')) {

    function remove_html_tags($str) {
        return trim(urldecode(html_entity_decode(strip_tags($str))));
    }

}

if ( ! function_exists('paragraph')) {

    function paragraph($str) {
        return trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 @&!?()]/', ' ', urldecode(html_entity_decode(strip_tags($str))))));
    }

}

if ( ! function_exists('different_string')) {

    function different_string($str) {
        return trim(urldecode(html_entity_decode(strip_tags($str))));
    }

}

if ( ! function_exists('valid_string')) {

    function valid_string($str) {
        return (bool) preg_match('/^[a-zA-Z\/]+$/', $str);
    }

}

if ( ! function_exists('validateAlphaSpaces')) {

    function validateAlphaSpaces($str) {
        return preg_match('/^[\pL\s]+$/u', $str);
    }

}

/**
 * Alpha-numeric w/ spaces
 *
 * @param	string
 * @return	bool
 */
if ( ! function_exists('alpha_numeric_spaces')) {

    function alpha_numeric_spaces($str) {
        return (bool) preg_match('/^[A-Z0-9 ]+$/i', $str);
    }

}

if ( ! function_exists('valid_url')) {

    function valid_url($str) {
        if (empty($str)) {
            return FALSE;
        } elseif (preg_match('/^(?:([^:]*)\:)?\/\/(.+)$/', $str, $matches)) {
            if (empty($matches[2])) {
                return FALSE;
            } elseif ( ! in_array(strtolower($matches[1]), array('http', 'https'), TRUE)) {
                return FALSE;
            }

            $str = $matches[2];
        }

        // PHP 7 accepts IPv6 addresses within square brackets as hostnames,
        // but it appears that the PR that came in with https://bugs.php.net/bug.php?id=68039
        // was never merged into a PHP 5 branch ... https://3v4l.org/8PsSN
        if (preg_match('/^\[([^\]]+)\]/', $str, $matches) && ! is_php('7') && filter_var($matches[1], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== FALSE) {
            $str = 'ipv6.host' . substr($str, strlen($matches[1]) + 2);
        }

        return (filter_var('http://' . $str, FILTER_VALIDATE_URL) !== FALSE);
    }

}

/**
 * Valid Email
 *
 * @param	string
 * @return	bool
 */
if ( ! function_exists('valid_email')) {

    function valid_email($str) {
        if (function_exists('idn_to_ascii') && preg_match('#\A([^@]+)@(.+)\z#', $str, $matches)) {
            $domain = defined('INTL_IDNA_VARIANT_UTS46') ? idn_to_ascii($matches[2], 0, INTL_IDNA_VARIANT_UTS46) : idn_to_ascii($matches[2]);
            $str = $matches[1] . '@' . $domain;
        }

        return (bool) filter_var($str, FILTER_VALIDATE_EMAIL);
    }

}

if ( ! function_exists('valid_mobile')) {

    function valid_mobile($mobile) {

        return preg_match('/^[0-9]{10}+$/', $mobile);
    }

}

if ( ! function_exists('maskPhoneNumber')) {
    function maskPhoneNumber($number){
        return substr($number, 0, 2) . str_repeat("*", strlen($number)-5) . substr($number, -3);
    }
}

if (!function_exists('valid_number')) {

    function valid_number($number) {
        return (bool) preg_match('/^\d+$/', $number);
    }

}

/**
 * Value should be within an array of values
 *
 * @param	string
 * @param	string
 * @return	bool
 */
if ( ! function_exists('in_list')) {

    function in_list($value, $list) {
        return in_array($value, explode(',', $list), TRUE);
    }

}

/**
 * Is a Natural number  (0,1,2,3, etc.)
 *
 * @param	string
 * @return	bool
 */
if ( ! function_exists('is_natural')) {

    function is_natural($str) {
        return ctype_digit((string) $str);
    }

}

/**
 * Is a Natural number, but not a zero  (1,2,3, etc.)
 *
 * @param	string
 * @return	bool
 */
if ( ! function_exists('is_natural_no_zero')) {

    function is_natural_no_zero($str) {
        return ($str != 0 && ctype_digit((string) $str));
    }

}

if ( ! function_exists('valid_base64')) {

    function valid_base64($str) {
        return (base64_encode(base64_decode($str)) === $str);
    }

}

if ( ! function_exists('csrf_token')) {

    function csrf_token($str) {
        $CI = & get_instance();
        $csrf = NULL;
        if ($str == 'name') {
            $csrf = $CI->security->get_csrf_token_name();
        } elseif ($str == 'hash') {
            $csrf = $CI->security->get_csrf_hash();
        }
        return $csrf;
    }

}

if ( ! function_exists('encode')) {

    function encode($sStr) {
        $CI = & get_instance();
        return $CI->aesencryption->encrypt($sStr);
    }

}

if ( ! function_exists('decode')) {

    function decode($sStr) {
        $CI = & get_instance();
        return $CI->aesencryption->decrypt($sStr);
    }

}

if ( ! function_exists('utc_datetime')) {

    function utc_datetime() {
        $t = microtime(true);
        $micro = sprintf("%03d", ($t - floor($t)) * 1000);
        $utc = gmdate('Y-m-d\TH:i:s.', $t) . $micro . 'Z';
        return $utc;
    }

}

if ( ! function_exists('years_between_dates')) {

    function years_between_dates($date1, $date2) {
        $diff = $date2 - $date1;
        return floor($diff / (365 * 60 * 60 * 24));
    }

}

if ( ! function_exists('months_between_dates')) {

    function months_between_dates($date1, $date2) {
        $diff = $date2 - $date1;
        $years = floor($diff / (365 * 60 * 60 * 24));
        return floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
    }

}

if ( ! function_exists('days_between_dates')) {

    function days_between_dates($date1, $date2) {
        $inDate = strtotime($date1);
        $outTime = strtotime($date2);
        $diff = $outTime - $inDate;
        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        return floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
    }

}

if ( ! function_exists('hours_between_dates')) {

    function hours_between_dates($date1, $date2) {
        $diff = $date2 - $date1;
        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
        return floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));
    }

}

if ( ! function_exists('minutes_between_dates')) {

    function minutes_between_dates($date1, $date2) {
        $diff = $date2 - $date1;
        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
        $hours = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));
        return floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60) / 60);
    }

}

if ( ! function_exists('seconds_between_dates')) {

    function seconds_between_dates($date1, $date2) {
        $diff = $date2 - $date1;
        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
        $hours = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));
        $minutes = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60) / 60);
        return floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60 - $minutes * 60));
    }

}

if ( ! function_exists('month_first_day')) {

    function month_first_day($format) {
        return date($format, strtotime("first day of this month"));
    }

}

if ( ! function_exists('month_last_day')) {

    function month_last_day($format) {
        return date($format, strtotime("last day of this month"));
    }

}
