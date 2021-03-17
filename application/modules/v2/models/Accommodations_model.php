<?php
if ( ! defined('BASEPATH'))
    exit('No direct script access allowed');

class Accommodations_model extends CI_Model {
    protected $tablename = 'vms19_accommodations';
    protected $otptable = 'vms19_accommodation_otp';
    protected $visitorsprimary = 'vms19_visitors_primary_info';
    protected $visitorstable = 'vms19_visitors';
    protected $roomCheckintable = 'vms19_room_checkins';
    protected $primarykey = 'id';
    protected $_iInsertedID = NULL;

    public function __construct() {
        parent::__construct();
    }
    
    public function getInsertedID() {
        return $this->_iInsertedID;
    }

    /*********** COMMON FUNCTIONS ************/

    private function store($table, $params) {
        $this->db->insert($table, $params);
        if ($this->db->affected_rows() > 0) {
            $this->_iInsertedID = $this->db->insert_id();
            return TRUE;
        }
        return FALSE;
    }

    private function update($table, $update_data, $aWhere) {
        $this->db->where($aWhere);
        $this->db->update($table, $update_data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
        return FALSE;
    }

    private function getOneRecord($table, $aWhere) {

        $this->db->where($aWhere);
        $query = $this->db->get($table);
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return array();
    }

    private function getAllRecords($table, $aWhere) {

        $this->db->where($aWhere);
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();
    }

    /*********** ACCOMMODATION FUNCTIONS ************/
    
    public function getAllCounts($params = array()) {
        if(! is_array($params) || empty($params)){
            return array();
        }
        foreach ($params as $key => $value) {
            if(! empty($value)){
                $this->db->where($key, $value);
            }
        }
        $this->db->select('type');
        $query = $this->db->get($this->tablename);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();
    }

    public function getAllCheckins($params = array()) {
        if(! is_array($params) || empty($params)){
            return array();
        }
        foreach ($params as $key => $value) {
            if(! empty($value)){
                $this->db->where($this->tablename.'.'.$key, $value);
            }
        }
        $this->db->where('vms19_visitors_primary_info.status', 1);
        $this->db->select('COUNT("vms19_visitors_primary_info.*") AS total_checkins');
        $this->db->from('vms19_visitors_primary_info');
        $this->db->join($this->tablename, 'vms19_accommodations.id = vms19_visitors_primary_info.accommodationId');
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return array();
        
    }

    public function getAllTodayCheckins($params = array()) {
        if(! is_array($params) || empty($params)){
            return array();
        }
        $datetime = date('Y-m-d');
        foreach ($params as $key => $value) {
            if(! empty($value)){
                $this->db->where($this->tablename.'.'.$key, $value);
            }
        }
        $this->db->where('vms19_visitors_primary_info.status', 1);
        $this->db->like('vms19_visitors_primary_info.checkIn', $datetime);
        $this->db->select('COUNT("vms19_visitors_primary_info.*") AS total_checkins');
        $this->db->from('vms19_visitors_primary_info');
        $this->db->join($this->tablename, 'vms19_accommodations.id = vms19_visitors_primary_info.accommodationId');
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return array();
        
    }
    
    public function getAllCheckinsByAccommodation($accommodationId = null, $date = null) {
        if(! valid_number($accommodationId)){
            return 0;
        }
        $this->db->where(array('accommodationId' => $accommodationId, 'status' => 1));
        if(! is_null($date)){
            $this->db->like('checkIn', $date);
        }
        $this->db->from($this->visitorsprimary);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();
    }
    
//    public function getAllCheckinsList($params = array()) {
//        if(! is_array($params) || empty($params)){
//            return array();
//        }
//        $query = $this->db->query('SELECT va.id AS houseId, vvpi.id AS guest_primaryId, va.name AS houseName, vvpi.noOfRooms AS roomNumber, vvpi.checkIn, vvpi.checkOut, vvpi.maleAdults, vvpi.femaleAdults,'
//            . ' vvpi.maleChild, vvpi.femaleChild, va.SHOArea, va.city, va.state FROM vms19_visitors_primary_info vvpi JOIN vms19_accommodations va ON(va.id = vvpi.accommodationId)'
//            . ' WHERE va.name = "'.$params['hotel'].'" AND va.SHOArea = "'.$params['sho_area'].'" AND va.city = "'.$params['city'].'" AND va.zone = "'.$params['zone'].'" AND'
//            . ' va.circle = "'.$params['circle'].'" AND vvpi.phoneNumber = "'.$params['phome'].'" AND vvpi.checkIn BETWEEN "%'.$params['from_date'].'" AND "%'.$params['to_date'].'"'
//            . ' ORDER BY va.id ASC LIMIT '.$params['limit'].', '.$params['start']);
//        if ($query->num_rows() > 0) {
//            return $query->result();
//        }
//        return array();
//        
//    }
    
    public function getAllActiveCheckins() {
        $this->db->select('va.id AS houseId, va.type, vvpi.id AS guest_primaryId, va.name AS houseName, vvpi.phoneNumber, vvpi.noOfRooms AS roomNumber, vvpi.checkIn,'
            . ' vvpi.checkOut, vvpi.maleAdults, vvpi.femaleAdults, vvpi.maleChild, vvpi.femaleChild, va.SHOArea, va.city, va.state');
        $this->db->from('vms19_visitors_primary_info vvpi');
        $this->db->join('vms19_accommodations va', 'va.id = vvpi.accommodationId');
        $this->db->where('vvpi.status', 1);
        $this->db->where('vvpi.isShared', 0);
        $this->db->order_by('vvpi.checkIn', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();
    }
    
    public function getAllCheckinsList($aWhere = array(), $phone = null, $from_date = null, $to_date = null, $limit = null, $start = 0) {
        if(! is_array($aWhere) || empty($aWhere)){
            return array();
        }
        foreach ($aWhere as $key => $value) {
            if(! empty($value)){
                if($key == 'name'){
                    $this->db->like('va.'.$key, $value);
                } else {
                    $this->db->where('va.'.$key, $value);
                }
            }
        }
        if(! empty($phone)){
            $this->db->where('vvpi.phoneNumber', $phone);
        }
        $this->db->select('va.id AS houseId, va.type, vvpi.id AS guest_primaryId, va.name AS houseName, vvpi.phoneNumber, vvpi.noOfRooms AS roomNumber, vvpi.checkIn,'
            . ' vvpi.checkOut, vvpi.maleAdults, vvpi.femaleAdults, vvpi.maleChild, vvpi.femaleChild, va.SHOArea, va.city, va.state');
        $this->db->from('vms19_visitors_primary_info vvpi');
        $this->db->join('vms19_accommodations va', 'va.id = vvpi.accommodationId');
        $this->db->where('vvpi.checkIn >= ', $from_date);
        $this->db->where('vvpi.checkIn <= ', $to_date);
        $this->db->where('vvpi.status', 1);
        $this->db->limit($limit, $start);
        $this->db->order_by('vvpi.checkIn', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();
    }

    public function getAllPropertiesLike($params = array()) {
        if(! is_array($params) || empty($params)){
            return array();
        }
        foreach ($params as $key => $value) {
            if(! empty($value)){
                $this->db->where($key, $value);
            }
        }
        $query = $this->db->get($this->tablename);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();
    }

    public function getAccommodationInfo($aWhere) {
        if ( ! is_array($aWhere) || empty($aWhere)) {
            return array();
        }
        return $this->getOneRecord($this->tablename, $aWhere);
    }

    public function storeAccommodationInfo($params) {
        if ( ! is_array($params) || empty($params)) {
            return FALSE;
        }
        return $this->store($this->tablename, $params);
    }

    public function updateAccommodationInfo($update_data = array(), $aWhere = array()) {
        if ( ! is_array($update_data) || empty($update_data) || ! is_array($aWhere) || empty($aWhere)) {
            return FALSE;
        }
        return $this->update($this->tablename, $update_data, $aWhere);
    }
    
    /*********** ACCOMMODATION OTP FUNCTIONS ************/
    
    public function getAccommodationOTP($aWhere) {
        if ( ! is_array($aWhere) || empty($aWhere)) {
            return array();
        }
        return $this->getOneRecord($this->otptable, $aWhere);
    }
    
    public function storeAccommodationOTP($params) {
        if ( ! is_array($params) || empty($params)) {
            return FALSE;
        }
        return $this->store($this->otptable, $params);
    }
    
    public function updateAccommodationOTP($update_data = array(), $aWhere = array()) {
        if ( ! is_array($update_data) || empty($update_data) || ! is_array($aWhere) || empty($aWhere)) {
            return FALSE;
        }
        return $this->update($this->otptable, $update_data, $aWhere);
    }
    
    /*********** SMS GATEWAY FUNCTIONS ************/

    public function sendSMS($params = array()) {
        if (!is_array($params) || empty($params)) {
            return array();
        } else {
            $url = 'http://www.metamorphsystems.com/index.php/api/bulk-sms';
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "username=anirudhloya&password=Access@100&from=SafeCK&to=".$params['to']."&message=".$params['message']."&sms_type=2");
            $response = curl_exec($ch);
            curl_close($ch);
            return json_decode($response);
        }
    }

}
