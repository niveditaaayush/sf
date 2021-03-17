<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends MX_Controller {
    
    public $current_url;
    public $session_data;

    function __construct() {
        parent::__construct();
        login_check('admin', TRUE);
        $this->session_data = get_session_data();
    }

    public function index() {
        redirect('admin/dashboard');
    }

}
