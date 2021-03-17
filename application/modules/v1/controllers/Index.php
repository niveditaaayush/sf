<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends MX_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        phpinfo(); die;
//        $data['heading'] = 'Home';
//        $this->load->view('welcome_message', $data);
    }

}
