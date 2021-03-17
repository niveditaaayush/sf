<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
  |--------------------------------------------------------------------------
  | Display Debug backtrace
  |--------------------------------------------------------------------------
  |
  | If set to TRUE, a backtrace will be displayed along with php errors. If
  | error_reporting is disabled, the backtrace will not display, regardless
  | of this setting
  |
 */
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
  |--------------------------------------------------------------------------
  | File and Directory Modes
  |--------------------------------------------------------------------------
  |
  | These prefs are used when checking and setting modes when working
  | with the file system.  The defaults are fine on servers with proper
  | security, but you may wish (or even need) to change the values in
  | certain environments (Apache running a separate process for each
  | user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
  | always be used to set the mode correctly.
  |
 */
defined('FILE_READ_MODE') OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE') OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE') OR define('DIR_WRITE_MODE', 0755);

/*
  |--------------------------------------------------------------------------
  | File Stream Modes
  |--------------------------------------------------------------------------
  |
  | These modes are used when working with fopen()/popen()
  |
 */
defined('FOPEN_READ') OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE') OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE') OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE') OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE') OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE') OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT') OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT') OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
  |--------------------------------------------------------------------------
  | Exit Status Codes
  |--------------------------------------------------------------------------
  |
  | Used to indicate the conditions under which the script is exit()ing.
  | While there is no universal standard for error codes, there are some
  | broad conventions.  Three such conventions are mentioned below, for
  | those who wish to make use of them.  The CodeIgniter defaults were
  | chosen for the least overlap with these conventions, while still
  | leaving room for others to be defined in future versions and user
  | applications.
  |
  | The three main conventions used for determining exit status codes
  | are as follows:
  |
  |    Standard C/C++ Library (stdlibc):
  |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
  |       (This link also contains other GNU-specific conventions)
  |    BSD sysexits.h:
  |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
  |    Bash scripting:
  |       http://tldp.org/LDP/abs/html/exitcodes.html
  |
 */
defined('EXIT_SUCCESS') OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR') OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG') OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE') OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS') OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT') OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE') OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN') OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX') OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

/*
  |--------------------------------------------------------------------------
  | Add new functionalities
  |--------------------------------------------------------------------------
 */

if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) {
    define('HTTPS', TRUE);
    define('HTTP_REQUEST', 'https://');
} else {
    define('HTTPS', FALSE);
    define('HTTP_REQUEST', 'http://');
}

define('HTTP_HOST', $_SERVER['HTTP_HOST']);

if (strpos($_SERVER['SERVER_NAME'], 'safecheckin.in') !== false) {
    define('SITE_NAME', '');
} else {
    define('SITE_NAME', '');
}

define('BASE_URL', HTTP_REQUEST . HTTP_HOST . '/' . SITE_NAME);
define('ABSOLUTE_BASE_URL', HTTP_REQUEST . HTTP_HOST . '/' . SITE_NAME);
define('ROOTPATH', dirname(dirname(dirname(realpath(__FILE__)))));
define('RELATIVE_BASE_URL', ROOTPATH . '/');
define('HTTP_SERVER', HTTP_REQUEST . HTTP_HOST); // HTTP
define('HTTPS_SERVER', HTTP_REQUEST . HTTP_HOST . '/'); // HTTPS

/*
  |--------------------------------------------------------------------------
  | Common Absolute paths, used for file showing/retreiving from server
  |--------------------------------------------------------------------------
 */

define('ASSETS_PATH', ABSOLUTE_BASE_URL . 'assets/');
define('CSS_PATH', ASSETS_PATH . 'css/');
define('JS_PATH', ASSETS_PATH . 'js/');
define('IMAGES_PATH', ASSETS_PATH . 'images/');
define('TEMP_PATH', ASSETS_PATH . 'temp/');

/*
  |--------------------------------------------------------------------------
  | Common Relative paths, used for file uploading
  |--------------------------------------------------------------------------
 */

define('RELATIVE_ASSETS_PATH', RELATIVE_BASE_URL . 'assets/');
define('RELATIVE_CSS_PATH', RELATIVE_ASSETS_PATH . 'css/');
define('RELATIVE_JS_PATH', RELATIVE_ASSETS_PATH . 'js/');
define('RELATIVE_IMAGES_PATH', RELATIVE_ASSETS_PATH . 'images/');
define('RELATIVE_TEMP_PATH', RELATIVE_ASSETS_PATH . 'temp/');

/*
  |--------------------------------------------------------------------------
  | common usage functions
  |--------------------------------------------------------------------------
 */

define('DATE', date('Y-m-d'));
define('DATETIME', date('Y-m-d H:i:s'));
define('NUMBER', '/^\d+$/');
define('COMMA_NUMBER_FORMAT', '/^\d+(?:,\d+)*$/');
define('GCP_BUCKET_NAME', 'safecheckin');

/*
  |-------------------------------------------------------------------------------
  | DOMAIN BASED RELATIVE AND ABSOLUTE PATHS, USED  FOR FILE UPLOADING AND VIEWING
  |-------------------------------------------------------------------------------
 */

if (strpos($_SERVER['SERVER_NAME'], 'safecheckin.in') !== false) {
    define('VIEW_PATH', 'https://storage.googleapis.com/safecheckin/');
    define('UPLOADS_PATH', '');
} elseif ( strpos($_SERVER['SERVER_NAME'], 'raskeysoft.com') !== false) {
    define('VIEW_PATH', 'https://storage.googleapis.com/safecheckin/staging/');
    define('UPLOADS_PATH', 'staging/');
} else {
    define('VIEW_PATH', ABSOLUTE_BASE_URL . 'uploads/');
    define('UPLOADS_PATH', RELATIVE_BASE_URL . 'uploads/');
}

/*
  |--------------------------------------------------------------------------
  | Absolute paths, used for file showing/retreiving from server
  |--------------------------------------------------------------------------
 */

define('ADMIN_IMAGES_PATH', VIEW_PATH . 'admin/');
define('VISITORS_IMAGES_PATH', VIEW_PATH . 'visitors/');
define('ACCOMMODATIONS_IMAGES_PATH', VIEW_PATH . 'accommodations/');
define('SUSPECT_IMAGES_PATH', VIEW_PATH . 'suspects/');

/*
  |--------------------------------------------------------------------------
  | Relative paths, used for file uploading
  |--------------------------------------------------------------------------
 */

define('RELATIVE_ADMIN_IMAGES_PATH', UPLOADS_PATH . 'admin/');
define('RELATIVE_VISITORS_IMAGES_PATH', UPLOADS_PATH . 'visitors/');
define('RELATIVE_ACCOMMODATIONS_IMAGES_PATH', UPLOADS_PATH . 'accommodations/');
define('RELATIVE_SUSPECT_IMAGES_PATH', UPLOADS_PATH . 'suspects/');

/*
  |--------------------------------------------------------------------------
  | Database Tables
  |--------------------------------------------------------------------------
 */

define('ACCOMMODATIONS', 'vms19_accommodations');
define('ACCOMMODATIONS_OTP', 'vms19_accommodation_otp');
define('ACCOMMODATION_TYPES', '	vms19_accommodation_types');
define('ADMINISTRATION', 'vms19_administration');
define('ADMINS', 'vms19_admins');
define('POLICE_STATIONS', 'vms19_police_stations');
define('ROOM_CHECKINS', 'vms19_room_checkins');
define('VISITORS', '	vms19_visitors');
define('VISITORS_OTP', '	vms19_visitors_otp');
define('VISITORS_PRIMARY_INFO', '	vms19_visitors_primary_info');
