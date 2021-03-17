<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Errors extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index()
	{	
		$this->load->view('errors/html/error_general');
	}

}

/* End of file client.php */
/* Location: ./application/controllers/client.php */