<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        login_check('superadmin', TRUE);
    }

    public function index()
	{
        redirect('superadmin/index');
	}
}
