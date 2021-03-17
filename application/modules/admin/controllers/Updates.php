<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Updates extends MX_Controller {
    
    public $current_url;
    public $session_data;

    function __construct() {
        parent::__construct();
        login_check('admin', TRUE);
        $this->session_data = get_session_data();
        $this->load->model('accommodations_model');
        $this->load->model('visitors_model');        
    }

    public function index() {
//        $aWhere = array('id' => $this->get('id'));
//     
//        $accommodation = $this->accommodations_model->getAccommodationInfo($aWhere);
//        print_r($accommodation);exit;
        
        $this->load->view('index');
    }

}
