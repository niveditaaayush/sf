<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkins extends MX_Controller {
    
    public $current_url;
    public $session_data;

    function __construct() {
        parent::__construct();
        login_check('admin', TRUE);
        $this->session_data = get_session_data();
        $this->load->model('accommodations_model');
        $this->load->model('visitors_model');
        $this->current_url = base_url('admin/checkins');
    }

    public function index() {
        $data['current_url'] = $this->current_url;
        $data['checkins_type'] = 'active';
        $data['loginUser'] = loginUser();
        $data['visitors'] = array();
        $params = array(
            'city' => $data['loginUser']->district,
            'zone' => $data['loginUser']->zone,
            'circle' => $data['loginUser']->division,
            'SHOArea' => $data['loginUser']->sho_area
        );
        $data['cities'] = $this->accommodations_model->getAllCities();
        //$data['visitors'] = $this->visitors_model->activeVisitorWithAccommodation($params);
        $checkins = $this->visitors_model->getActiveCheckinsWithAccommodation($params);
        if(@sizeof($checkins) > 0){
            foreach($checkins as $checkin){
                $guest = $this->visitors_model->getPrimaryVisitorInfo(array('vpId' => $checkin->primaryId));
                if(@sizeof($guest) == 1){
                    $checkin->guestName = $guest->firstName.' '.$guest->lastName;
                    $checkin->address = $guest->address;
                    $data['visitors'][] = $checkin;
                }
            }
        }
        $this->load->view('checkins',$data);
    }

    public function all() {
        $data['checkins_type'] = 'all';
        $data['current_url'] = $this->current_url;
        $data['loginUser'] = loginUser();
        $params = array(
            'city' => $data['loginUser']->district,
            'zone' => $data['loginUser']->zone,
            'circle' => $data['loginUser']->division,
            'SHOArea' => $data['loginUser']->sho_area
        );
        $data['cities'] = $this->accommodations_model->getAllCities();
        //$data['visitors'] = $this->visitors_model->allVisitorWithAccommodation($params);
        $data['visitors'] = array();
        $checkins = $this->visitors_model->getAllCheckinsWithAccommodation($params);
        if(@sizeof($checkins) > 0){
            foreach($checkins as $checkin){
                $guest = $this->visitors_model->getPrimaryVisitorInfo(array('vpId' => $checkin->primaryId));
                if(@sizeof($guest) == 1){
                    $checkin->guestName = $guest->firstName.' '.$guest->lastName;
                    $checkin->address = $guest->address;
                    $data['visitors'][] = $checkin;
                }
            }
        }
        $this->load->view('checkins', $data);
    }
    
    public function past($id = null) {
        if(! valid_number(base64_decode($id))){
            $this->session->set_flashdata('error', 'Invalid checkin id found');
            redirect($this->current_url);
        }
        $aWhere = array('id' => base64_decode($id));
        $checkin = $this->visitors_model->getVisitorPrimaryInfo($aWhere);
        if(@sizeof($checkin) == 0){
            $this->session->set_flashdata('error', 'Checkin not found');
            redirect($this->current_url);
        }
        $data['checkins_type'] = 'past';
        $data['current_url'] = $this->current_url;
        $data['visitors'] = array();
        //$data['visitors'] = $this->visitors_model->allVisitorPastCheckins(array('phoneNumber' => $checkin->phoneNumber));
        $checkins = $this->visitors_model->getPastCheckins(array('phoneNumber' => $checkin->phoneNumber));
        if(@sizeof($checkins) > 0){
            foreach($checkins as $checkin){
                $guest = $this->visitors_model->getPrimaryVisitorInfo(array('vpId' => $checkin->primaryId));
                if(@sizeof($guest) == 1){
                    $checkin->guestName = $guest->firstName.' '.$guest->lastName;
                    $checkin->address = $guest->address;
                    $checkin->address = $guest->photoOfVisitor;
                    $checkin->address = $guest->idProofPhotoFront;
                    $checkin->address = $guest->idProofPhotoBack;
                    $data['visitors'][] = $checkin;
                }
            }
        }
        $this->load->view('past_checkins', $data);
    }
    
    public function activeExport($get_params = null){
        $status = 'active';
        return $this->export($status, $get_params);
    }
    
    public function allExport($get_params = null){
        $status = 'all';
        return $this->export($status, $get_params);
    }
    
    private function export($status, $get_params) {

        $from = NULL;
        $to = NULL;
        $params = array();
        $get = json_decode(base64_decode($get_params), TRUE);
        $loginUser = loginUser();
        $params = array(
            'city' => isset($get['district']) ? $get['district'] : $loginUser->district,
            'zone' => isset($get['zone']) ? $get['zone'] : $loginUser->zone,
            'circle' => isset($get['division']) ? $get['division'] : $loginUser->division,
            'SHOArea' => isset($get['sho_area']) ? $get['sho_area'] : $loginUser->sho_area
        );
        $from = isset($get['start_date']) ? date("Y-m-d 00:00:00", strtotime($get['start_date'])) : NULL;
        $to = isset($get['end_date']) ? date("Y-m-d 23:59:59", strtotime($get['end_date'])) : NULL;
        $this->load->helper('csv_helper');
        $checkins = $this->visitors_model->getAllCheckinsWthAccommodationExport($status, $params, $from, $to);
        if(@sizeof($checkins) == 0){
            $this->session->set_flashdata('error', 'Checkins not found');
            redirect($this->current_url);
        }
        $data[] = array('Accommodation Name', 'Accommodation Type', 'Guest Name', 'Gender', 'Age Group', 'Area', 'CheckIn', 'CheckOut');
        foreach($checkins as $checkin){
            $visitor = $this->visitors_model->getPrimaryVisitorInfo(array('id' => $checkin->vpId));
            if(@sizeof($visitor) == 1){
                $data[] = array(
                    $checkin->name,
                    $checkin->type,
                    $visitor->firstName.' '.$visitor->lastName,
                    $visitor->gender,
                    $visitor->ageGroup,
                    $visitor->address,
                    date('d-m-Y h:i A', strtotime($checkin->checkIn)),
                    $checkin->checkOut ? date('d-m-Y h:i A', strtotime($checkin->checkOut)) : NULL
                );
            }
        }
        array_to_csv($data, 'checkins_' . date('dMy') . '.csv');
    }
    
    public function details($id = null) {
        if(! valid_number(base64_decode($id))){
            $this->session->set_flashdata('error', 'Invalid checkin id found');
            redirect($this->current_url);
        }
        $aWhere = array('id' => base64_decode($id));
        $data['checkin'] = $this->visitors_model->getVisitorPrimaryInfo($aWhere);
        if(@sizeof($data['checkin']) == 0){
            $this->session->set_flashdata('error', 'Checkin not found');
            redirect($this->current_url);
        }
        $data['visitors'] = $this->visitors_model->getAllVisitorsInfo(array('vpId' => base64_decode($id)));
        $this->load->view('checkin_details', $data);
    }
    
    public function filter() {

        $data['current_url'] = $this->current_url;
        $data['loginUser'] = loginUser();
        $params = array(
            'city' => $this->input->get('district') ? $this->input->get('district') : $data['loginUser']->district,
            'zone' => $this->input->get('zone') ? $this->input->get('zone') : $data['loginUser']->zone,
            'circle' => $this->input->get('division') ? $this->input->get('division') : $data['loginUser']->division,
            'SHOArea' => $this->input->get('sho_area') ? $this->input->get('sho_area') : $data['loginUser']->sho_area
        );
        $from = $this->input->get('start_date') ? date("Y-m-d 00:00:00", strtotime($this->input->get('start_date'))) : NULL;
        $to = $this->input->get('end_date') ? date("Y-m-d 23:59:59", strtotime($this->input->get('end_date'))) : NULL;

        $data['cities'] = $this->accommodations_model->getAllCities();
        //$data['visitors'] = $this->visitors_model->activeVisitorWithAccommodation($params, $from, $to);
        $data['visitors'] = array();
        $checkins = $this->visitors_model->getActiveCheckinsWithAccommodation($params, $from, $to);
        if(@sizeof($checkins) > 0){
            foreach($checkins as $checkin){
                $guest = $this->visitors_model->getPrimaryVisitorInfo(array('vpId' => $checkin->primaryId));
                if(@sizeof($guest) == 1){
                    $checkin->guestName = $guest->firstName.' '.$guest->lastName;
                    $checkin->address = $guest->address;
                    $checkin->address = $guest->photoOfVisitor;
                    $checkin->address = $guest->idProofPhotoFront;
                    $checkin->address = $guest->idProofPhotoBack;
                    $data['visitors'][] = $checkin;
                }
            }
        }
        $this->load->view('checkins', $data);
    }
    
    public function updateRoomCheckins() {
        set_time_limit(0);
        $accommodations = $this->accommodations_model->getAllAccommodations();
        if(@sizeof($accommodations) == 0){
            $this->session->set_flashdata('error', 'We are unable to find the accommodations');
            redirect('admin/dashboard');
        }
        foreach ($accommodations as $accommodation) {
            $primaryInfo = $this->visitors_model->getAllPrimaryVisitorWithPrimaryInfo(array('accommodationId' => $accommodation->id));
            if(@sizeof($primaryInfo) > 0){
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
                                if(@sizeof($getRoomCheckin) == 0){
                                    $insertRoomCheckin = $this->visitors_model->storeCheckinRoomInfo($params);
                                }
                            }
                        }
                    }
                }
            }
        }
        $this->session->set_flashdata('success', 'Room checkins updated successfully!');
        redirect('admin/dashboard');
    }
}
