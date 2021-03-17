<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Errors extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index()
	{
        $data['title'] = '404 Page Not Found';
        //$this->load->view('header', $data);
		$this->load->view('html/error_general');
        //$this->load->view('footer', $data);
	}

}

/* End of file client.php */
/* Location: ./application/controllers/client.php */