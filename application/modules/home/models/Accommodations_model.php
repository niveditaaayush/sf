<?php
if ( ! defined('BASEPATH'))
    exit('No direct script access allowed');

class Accommodations_model extends CI_Model {
    protected $tablename = 'vms19_accommodations';
    protected $otptable = 'vms19_accommodation_otp';
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
