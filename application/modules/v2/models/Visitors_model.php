<?php
if ( ! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Visitors_model extends CI_Model {

    protected $_iInsertedID = NULL;

    public function __construct() {
        parent::__construct();
    }
    
    public function getInsertedID() {
        return $this->_iInsertedID;
    }

    /*     * ********* START COMMON FUNCTIONS *********** */

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
    
    /*********** START VISITORS PRIMARY FUNCTIONS ************/

    public function getAllVisitorPrimaryInfo($aWhere) {
        if ( ! is_array($aWhere) || empty($aWhere)) {
            return array();
        }
        return $this->getAllRecords(VISITORS_PRIMARY_INFO, $aWhere);
    }

    public function getVisitorPrimaryInfo($aWhere) {
        if ( ! is_array($aWhere) || empty($aWhere)) {
            return array();
        }
        return $this->getOneRecord(VISITORS_PRIMARY_INFO, $aWhere);
    }
    
    public function getPrimaryInfoVisitor($vpId = null, $name = null, $pinecode = null) {
        if(!valid_number($vpId)){
            return array();
        }
        if(! empty($name)){
            $this->db->like('CONCAT(firstName," ", lastName)', $name);
        }
        if(! empty($pinecode)){
            $this->db->where('pincode', $pinecode);
        }
        $this->db->where('vpId', $vpId);
        $this->db->select('id AS guestId, CONCAT(firstName, " ", lastName) AS guest_name, photoOfVisitor AS guest_photo, pincode AS guest_pincode');
        $this->db->order_by('id', 'ASC');
        $this->db->limit(1);
        $query = $this->db->get(VISITORS);
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return array();
    }
    
    public function getPrimaryInfoVisitorDetails($aWhere = array(), $guestId = null) {
        if(! is_array($aWhere) || empty($aWhere) || !valid_number($guestId)){
            return array();
        }
        $this->db->select('va.id AS houseId, va.name AS houseName, vvpi.roomNumber, vvpi.checkIn, vvpi.checkOut, vv.*');
        $this->db->from('vms19_visitors vv');
        $this->db->join('vms19_visitors_primary_info vvpi', 'vvpi.id = vv.vpId');
        $this->db->join('vms19_accommodations va', 'va.id = vvpi.accommodationId');
        foreach ($aWhere as $key => $value) {
            if(! empty($value)){
                $this->db->where('va.'.$key, $value);
            }
        }
        $this->db->where('vv.id', $guestId);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return array();
    }

    public function getVisitorOTP($aWhere) {
        if ( ! is_array($aWhere) || empty($aWhere)) {
            return array();
        }
        return $this->getOneRecord(VISITORS_OTP, $aWhere);
    }

    public function storeVisitorPrimaryInfo($params) {
        if ( ! is_array($params) || empty($params)) {
            return FALSE;
        }
        return $this->store(VISITORS_PRIMARY_INFO, $params);
    }
    
    public function storeVisitorOTP($params) {
        if ( ! is_array($params) || empty($params)) {
            return FALSE;
        }
        return $this->store(VISITORS_OTP, $params);
    }
    
    public function updateVisitorPrimaryInfo($update_data = array(), $aWhere = array()) {
        if ( ! is_array($update_data) || empty($update_data) || ! is_array($aWhere) || empty($aWhere)) {
            return FALSE;
        }
        return $this->update(VISITORS_PRIMARY_INFO, $update_data, $aWhere);
    }
    
    public function updateVisitorOTP($update_data = array(), $aWhere = array()) {
        if ( ! is_array($update_data) || empty($update_data) || ! is_array($aWhere) || empty($aWhere)) {
            return FALSE;
        }
        return $this->update(VISITORS_OTP, $update_data, $aWhere);
    }
    
    /*********** START VISITORS FUNCTIONS ************/
    
    public function getAllVisitorsInfo($aWhere) {
        if ( ! is_array($aWhere) || empty($aWhere)) {
            return array();
        }
        return $this->getAllRecords(VISITORS, $aWhere);
    }
    
    public function getVisitorInfo($aWhere) {
        if ( ! is_array($aWhere) || empty($aWhere)) {
            return array();
        }
        return $this->getOneRecord(VISITORS, $aWhere);
    }    

    public function storeVisitorInfo($params) {
        if ( ! is_array($params) || empty($params)) {
            return FALSE;
        }
        return $this->store(VISITORS, $params);
    }

    public function updateVisitorInfo($update_data = array(), $aWhere = array()) {
        if ( ! is_array($update_data) || empty($update_data) || ! is_array($aWhere) || empty($aWhere)) {
            return FALSE;
        }
        return $this->update(VISITORS, $update_data, $aWhere);
    }

}
