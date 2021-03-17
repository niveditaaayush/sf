<?php
if ( ! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Visitors_model extends CI_Model {
    protected $tablename = 'vms19_visitors_primary_info';
    protected $visitorstable = 'vms19_visitors';
    protected $visitorsOTPtable = 'vms19_visitors_otp';
    protected $primarykey = 'id';
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
        return $this->getAllRecords($this->tablename, $aWhere);
    }

    public function getVisitorPrimaryInfo($aWhere) {
        if ( ! is_array($aWhere) || empty($aWhere)) {
            return array();
        }
        return $this->getOneRecord($this->tablename, $aWhere);
    }

    public function getVisitorOTP($aWhere) {
        if ( ! is_array($aWhere) || empty($aWhere)) {
            return array();
        }
        return $this->getOneRecord($this->visitorsOTPtable, $aWhere);
    }

    public function storeVisitorPrimaryInfo($params) {
        if ( ! is_array($params) || empty($params)) {
            return FALSE;
        }
        return $this->store($this->tablename, $params);
    }
    
    public function storeVisitorOTP($params) {
        if ( ! is_array($params) || empty($params)) {
            return FALSE;
        }
        return $this->store($this->visitorsOTPtable, $params);
    }
    
    public function updateVisitorPrimaryInfo($update_data = array(), $aWhere = array()) {
        if ( ! is_array($update_data) || empty($update_data) || ! is_array($aWhere) || empty($aWhere)) {
            return FALSE;
        }
        return $this->update($this->tablename, $update_data, $aWhere);
    }
    
    public function updateVisitorOTP($update_data = array(), $aWhere = array()) {
        if ( ! is_array($update_data) || empty($update_data) || ! is_array($aWhere) || empty($aWhere)) {
            return FALSE;
        }
        return $this->update($this->visitorsOTPtable, $update_data, $aWhere);
    }
    
    /*********** START VISITORS FUNCTIONS ************/
    
    public function getAllVisitorsInfo($aWhere) {
        if ( ! is_array($aWhere) || empty($aWhere)) {
            return array();
        }
        return $this->getAllRecords($this->visitorstable, $aWhere);
    }
    
    public function getVisitorInfo($aWhere) {
        if ( ! is_array($aWhere) || empty($aWhere)) {
            return array();
        }
        return $this->getOneRecord($this->visitorstable, $aWhere);
    }    

    public function storeVisitorInfo($params) {
        if ( ! is_array($params) || empty($params)) {
            return FALSE;
        }
        return $this->store($this->visitorstable, $params);
    }

    public function updateVisitorInfo($update_data = array(), $aWhere = array()) {
        if ( ! is_array($update_data) || empty($update_data) || ! is_array($aWhere) || empty($aWhere)) {
            return FALSE;
        }
        return $this->update($this->visitorstable, $update_data, $aWhere);
    }

}
