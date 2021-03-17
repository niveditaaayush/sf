<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visitors extends MX_Controller {
    
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
        $data['current_url'] = base_url('admin/visitors');
        $data['loginUser'] = loginUser();
        $params = array(
            'city' => $data['loginUser']->district,
            'zone' => $data['loginUser']->zone,
            'circle' => $data['loginUser']->division,
            'SHOArea' => $data['loginUser']->sho_area,
            'status' => 1
        );
        $data['cities'] = $this->accommodations_model->getAllCities();
        $data['visitors'] = $this->visitors_model->activeVisitorWithAccommodation($params);
        $this->load->view('visitors',$data);
    }
    
    public function filter() {
        $district   = $this->input->get('district');
        $zone       = $this->input->get('zone');
        $circle     = $this->input->get('division');
        $sho_area   = $this->input->get('sho_area');
        $params = array(
            'city' => $district,
            'SHOArea' => $sho_area,
            'zone' => $zone,
            'circle' => $circle
        );
        $from = $this->input->get('start_date') ? date("Y-m-d 00:00:00", strtotime($this->input->get('start_date'))) : NULL;
        $to = $this->input->get('end_date') ? date("Y-m-d 23:59:59", strtotime($this->input->get('end_date'))) : NULL;

        $data['current_url'] = base_url('admin/visitors');
        $data['loginUser'] = loginUser();
        $data['cities'] = $this->accommodations_model->getAllCities();
        $data['visitors'] = $this->visitors_model->activeVisitorWithAccommodation($params, $from, $to);
        $this->load->view('visitors', $data);
    }
}
