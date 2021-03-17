<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visitors extends MX_Controller {
    
    public $current_url;
    public $session_data;

    function __construct() {
        parent::__construct();
        login_check('superadmin', TRUE);
        $this->session_data = get_session_data();
        $this->load->model('accommodations_model');
        $this->load->model('visitors_model');         
    }

    public function index() {
        $data['current_url'] = base_url('superadmin/visitors');
        $data['cities'] = $this->accommodations_model->getAllCities();
        $data['visitors'] = $this->visitors_model->activeVisitorWithAccommodation();
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

        $data['current_url'] = base_url('superadmin/visitors');
        $data['cities'] = $this->accommodations_model->getAllCities();
        $data['visitors'] = $this->visitors_model->activeVisitorWithAccommodation($params, $from, $to);
        $this->load->view('visitors', $data);
    }
    
    public function updateRoomCheckins() {
        set_time_limit(0);
        $accommodations = $this->accommodations_model->getAllAccommodations();
        if(sizeof($accommodations) == 0){
            $this->session->set_flashdata('error', 'We are unable to find the accommodations');
            redirect('superadmin/dashboard');
        }
        foreach ($accommodations as $accommodation) {
            $primaryInfo = $this->visitors_model->getAllPrimaryVisitorWithPrimaryInfo(array('accommodationId' => $accommodation->id));
            if(sizeof($primaryInfo) > 0){
                foreach ($primaryInfo as $value) {
                    if(! empty($value->roomNumber)){
                        $rooms = explode(',', $value->roomNumber);
                        if(is_array($rooms) && ! empty($rooms)){
                            foreach ($rooms as $room) {
                                $params = array(
                                    'vpId' => $value->vpId,
                                    'visitorId' => $accommodation->type == "Hostel" ? $value->id : NULL,
                                    'roomNumber' => $accommodation->type != "Hostel" ? $room : NULL,
                                    'checkIn' => $value->checkIn,
                                    'checkOut' => $value->checkOut
                                );
                                $aWhere = array(
                                    'vpId' => $value->vpId,
                                    'visitorId' => $accommodation->type == "Hostel" ? $value->id : NULL,
                                    'roomNumber' => $accommodation->type != "Hostel" ? $room : NULL,
                                    );
                                $getRoomCheckin = $this->visitors_model->getCheckinRoomInfo($aWhere);
                                if(sizeof($getRoomCheckin) == 0){
                                    $insertRoomCheckin = $this->visitors_model->storeCheckinRoomInfo($params);
                                }
                            }
                        }
                    }
                }
            }
        }
        $this->session->set_flashdata('success', 'Room checkins updated successfully!');
        redirect('superadmin/dashboard');
    }
}
