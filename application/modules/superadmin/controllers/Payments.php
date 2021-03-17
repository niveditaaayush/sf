<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payments extends MX_Controller {
    
    public $current_url;
    public $session_data;

    function __construct() {
        parent::__construct();
        login_check('superadmin', TRUE);
        $this->session_data = get_session_data();
        $this->load->model('suspect_model');
        $this->current_url = base_url('superadmin/payments');
    }

    public function index() {
        
            $data['suspects'] = $this->suspect_model->getAllSuspectInfo();
            $this->load->view('payments', $data);
        
    }
    

}
