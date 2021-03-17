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
       // $token = "YSFlP3glcCZyKGUpcypzXnZyIWluJmRhI2FlQHhwO3PQMTqZf0o5hDLfmjHAEu91A7EjLQbh5Ms1Xvs4jCEpdMU1jraKXRpzePb+Ku5isCtiUlY3sczAVpPOktIieR7v";
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
            $accommodation = $this->accommodations_model->getsigninaccess($aWhere);
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
        //$token = "YSFlP3glcCZyKGUpcypzXnZyIWluJmRhI2FlQHhwO3PQMTqZf0o5hDLfmjHAEu91A7EjLQbh5Ms1Xvs4jCEpdMU1jraKXRpzePb+Ku5isCtiUlY3sczAVpPOktIieR7v";
        //$token = $this->input->get_request_header('Authorization');
        if ( ! isset($token) || $token != encode(basicSiteString())) {
            $this->set_response(array(
                'status' => FALSE,
                'message' => 'Sorry, it seems like you entered wrong credentials'
                ), REST_Controller::HTTP_UNAUTHORIZED);
        } else {
            $otp = $this->post('otp');
            $phoneNumber = $this->post('phone_number');
            $isadmin = $this->accommodations_model->getAdminnInfo(array('phoneNumber' => $phoneNumber));
            if(@sizeof($isadmin) == 1)
            {
                $aWhere = array('otp' => $otp, 'phoneNumber' => $phoneNumber);
                    $checkOTP = $this->accommodations_model->getAccommodationOTP($aWhere);
                    if (@sizeof($checkOTP) == 1) {
                        $appVersion = $this->accommodations_model->applicationVersion();
                        
                        $isadmin->appVersion    = $appVersion->version;
                        
                        $isadmin->type = 'admin';
                        $isadmin->noOfRooms = $this->accommodations_model->allrooms();
                        $this->set_response(array(
                            'status' => TRUE,
                            'message' => 'OTP validation successfully',
                            'data' => array('accommodation' => $isadmin)
                            ), REST_Controller::HTTP_OK);
                    } else {
                        $this->set_response(array(
                            'status' => FALSE,
                            'message' => 'Invalid OTP'
                            ), REST_Controller::HTTP_OK);
                    }
            }
            else
            {
                $accommodation = $this->accommodations_model->getAccommodationInfo(array('phoneNumber' => $phoneNumber));
                if (sizeof($accommodation) == 0) {
                    $this->set_response(array(
                        'status' => FALSE,
                        'message' => 'Oops, could not login, please verify your number and try again'
                        ), REST_Controller::HTTP_OK);
                } else {
                    $aWhere = array('otp' => $otp, 'phoneNumber' => $phoneNumber);
                    $checkOTP = $this->accommodations_model->getAccommodationOTP($aWhere);
                    if (sizeof($checkOTP) == 1) {
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
            if (sizeof($accommodation) == 1) {
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
    public function countryCode_get()
    {
       
        $array = [
    '44' => 'UK',
    '1' => 'USA',
    '213' => 'Algeria',
    '376' => 'Andorra',
    '244' => 'Angola',
    '1264' => 'Anguilla',
    '1268' => 'Antigua & Barbuda',
    '54' => 'Argentina',
    '374' => 'Armenia',
    '297' => 'Aruba',
    '61' => 'Australia',
    '43' => 'Austria',
    '994' => 'Azerbaijan',
    '1242' => 'Bahamas',
    '973' => 'Bahrain ',
    '880' => 'Bangladesh',
    '1246' => 'Barbados ',
    '375' => 'Belarus',
    '32' => 'Belgium',
    '501' => 'Belize',
    '229' => 'Benin',
    '1441' => 'Bermuda',
    '975' => 'Bhutan',
    '591' => 'Bolivia ',
    '387' => 'Bosnia Herzegovina',
    '267' => 'Botswana',
    '55' => 'Brazil',
    '673' => 'Brunei',
    '359' => 'Bulgaria',
    '226' => 'Burkina Faso',
    '257' => 'Burundi',
    '855' => 'Cambodia ',
    '237' => 'Cameroon',
    '1' => 'Canada',
    '238' => 'Cape Verde Islands',
    '1345' => 'Cayman Islands ',
    '236' => 'Central African Republic',
    '56' => 'Chile',
    '86' => 'China ',
    '57' => 'Colombia',
    '269' => 'Comoros',
    '242' => 'Congo (+242)',
    '682' => 'Cook Islands',
    '506' => 'Costa Rica',
    '385' => 'Croatia',
    '53' => 'Cuba',
    '90392' => 'Cyprus North',
    '357' => 'Cyprus South',
    '42' => 'Czech Republic ',
    '45' => 'Denmark',
    '253' => 'Djibouti',
    '1809' => 'Dominica',
    '1809' => 'Dominican Republic ',
    '593' => 'Ecuador',
    '20' => 'Egypt ',
    '503' => 'El Salvador',
    '240' => 'Equatorial Guinea',
    '291' => 'Eritrea',
    '372' => 'Estonia ',
    '251' => 'Ethiopia',
    '500' => 'Falkland Islands ',
    '298' => 'Faroe Islands',
    '679' => 'Fiji',
    '358' => 'Finland',
    '33' => 'France ',
    '594' => 'French Guiana',
    '689' => 'French Polynesia',
    '241' => 'Gabon',
    '220' => 'Gambia',
    '7880' => 'Georgia',
    '49' => 'Germany',
    '233' => 'Ghana',
    '350' => 'Gibraltar',
    '30' => 'Greece',
    '299' => 'Greenland',
    '1473' => 'Grenada',
    '590' => 'Guadeloupe',
    '671' => 'Guam',
    '502' => 'Guatemala',
    '224' => 'Guinea',
    '245' => 'Guinea - Bissau',
    '592' => 'Guyana',
    '509' => 'Haiti',
    '504' => 'Honduras',
    '852' => 'Hong Kong',
    '36' => 'Hungary',
    '354' => 'Iceland',
    '91' => 'India',
    '62' => 'Indonesia',
    '98' => 'Iran',
    '964' => 'Iraq',
    '353' => 'Ireland',
    '972' => 'Israel',
    '39' => 'Italy',
    '1876' => 'Jamaica',
    '81' => 'Japan',
    '962' => 'Jordan',
    '7' => 'Kazakhstan',
    '254' => 'Kenya',
    '686' => 'Kiribati',
    '850' => 'Korea North',
    '82' => 'Korea South',
    '965' => 'Kuwait',
    '996' => 'Kyrgyzstan',
    '856' => 'Laos',
    '371' => 'Latvia',
    '961' => 'Lebanon',
    '266' => 'Lesotho',
    '231' => 'Liberia',
    '218' => 'Libya',
    '417' => 'Liechtenstein',
    '370' => 'Lithuania',
    '352' => 'Luxembourg',
    '853' => 'Macao',
    '389' => 'Macedonia',
    '261' => 'Madagascar',
    '265' => 'Malawi',
    '60' => 'Malaysia',
    '960' => 'Maldives',
    '223' => 'Mali',
    '356' => 'Malta',
    '692' => 'Marshall Islands',
    '596' => 'Martinique',
    '222' => 'Mauritania',
    '269' => 'Mayotte',
    '52' => 'Mexico',
    '691' => 'Micronesia',
    '373' => 'Moldova',
    '377' => 'Monaco',
    '976' => 'Mongolia',
    '1664' => 'Montserrat',
    '212' => 'Morocco',
    '258' => 'Mozambique',
    '95' => 'Myanmar',
    '264' => 'Namibia',
    '674' => 'Nauru',
    '977' => 'Nepal',
    '31' => 'Netherlands',
    '687' => 'New Caledonia',
    '64' => 'New Zealand',
    '505' => 'Nicaragua',
    '227' => 'Niger',
    '234' => 'Nigeria',
    '683' => 'Niue',
    '672' => 'Norfolk Islands',
    '670' => 'Northern Marianas',
    '47' => 'Norway',
    '968' => 'Oman',
    '680' => 'Palau',
    '507' => 'Panama',
    '675' => 'Papua New Guinea',
    '595' => 'Paraguay',
    '51' => 'Peru',
    '63' => 'Philippines',
    '48' => 'Poland',
    '351' => 'Portugal',
    '1787' => 'Puerto Rico',
    '974' => 'Qatar',
    '262' => 'Reunion',
    '40' => 'Romania',
    '7' => 'Russia',
    '250' => 'Rwanda',
    '378' => 'San Marino',
    '239' => 'Sao Tome & Principe',
    '966' => 'Saudi Arabia',
    '221' => 'Senegal',
    '381' => 'Serbia',
    '248' => 'Seychelles',
    '232' => 'Sierra Leone',
    '65' => 'Singapore',
    '421' => 'Slovak Republic',
    '386' => 'Slovenia',
    '677' => 'Solomon Islands',
    '252' => 'Somalia',
    '27' => 'South Africa',
    '34' => 'Spain',
    '94' => 'Sri Lanka',
    '290' => 'St. Helena',
    '1869' => 'St. Kitts',
    '1758' => 'St. Lucia',
    '249' => 'Sudan',
    '597' => 'Suriname',
    '268' => 'Swaziland',
    '46' => 'Sweden',
    '41' => 'Switzerland',
    '963' => 'Syria',
    '886' => 'Taiwan',
    '7' => 'Tajikstan',
    '66' => 'Thailand',
    '228' => 'Togo',
    '676' => 'Tonga',
    '1868' => 'Trinidad & Tobago',
    '216' => 'Tunisia',
    '90' => 'Turkey',
    '7' => 'Turkmenistan',
    '993' => 'Turkmenistan',
    '1649' => 'Turks & Caicos Islands',
    '688' => 'Tuvalu',
    '256' => 'Uganda',
    '380' => 'Ukraine',
    '971' => 'United Arab Emirates',
    '598' => 'Uruguay',
    '7' => 'Uzbekistan',
    '678' => 'Vanuatu',
    '379' => 'Vatican City',
    '58' => 'Venezuela',
    '84' => 'Vietnam',
    '84' => 'Virgin Islands - British ',
    '84' => 'Virgin Islands - US ',
    '681' => 'Wallis & Futuna',
    '969' => 'Yemen (North)',
    '967' => 'Yemen (South)',
    '260' => 'Zambia',
    '263' => 'Zimbabwe',
    ];
    $json = array();$i=0;
    foreach ($array as $key => $value)
    {
        $json[$i]['countryName'] = $value;
        $json[$i]['countryCode'] = '+'.$key;
        $i++;
    }
        $this->set_response(array(
        'status' => TRUE,
        'message' => 'telephone codes',
        'data' => array('codes' => $json),
        ), REST_Controller::HTTP_OK);
    }
    public function test_get($value='')
    {
        # code...
        //echo basicAuthorizationToken();
        //echo basicAuthorizationToken();
        echo encode("VMS@9052371773");


    }

}
