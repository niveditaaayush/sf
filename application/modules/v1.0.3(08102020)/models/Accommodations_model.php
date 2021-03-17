<?php
if ( ! defined('BASEPATH')){
    exit('No direct script access allowed');
}

require_once APPPATH . 'third_party/vendor/autoload.php';
use Google\Cloud\Storage\StorageClient;

class Accommodations_model extends CI_Model {
    protected $tablename = 'vms19_accommodations';
    protected $accommodationTypes = 'vms19_accommodation_types';
    protected $otptable = 'vms19_accommodation_otp';
    protected $primaryinfotable = 'vms19_visitors_primary_info';
    protected $policestations = 'vms19_police_stations';
    protected $primarykey = 'id';
    protected $_iInsertedID = NULL;

    public function __construct() {
        parent::__construct();
    }
    
    public function getInsertedID() {
        return $this->_iInsertedID;
    }
    
    /*********** APPLICATION VERSION ***********/
    
    public function applicationVersion() {
        $this->db->select('version');
        $query = $this->db->get('vms19_app_version');
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return array();
    }

    /*********** COMMON FUNCTIONS ************/
    
    private function countAllRecords($table, $aWhere, $like = array()) {
        if (is_array($aWhere) && ! empty($aWhere)) {
            $this->db->where($aWhere);
        }
        if (is_array($like) && ! empty($like)) {
            foreach ($like as $key => $value) {
                $this->db->like($key, $value);
            }
        }
        $count = $this->db->count_all_results($table);
        if ($count > 0) {
            return $count;
        }
        return 0;
    }

    private function store($table, $params) {
        if (is_null($table) || empty($table)) {
            return FALSE;
        }
        $this->db->insert($table, $params);
        if ($this->db->affected_rows() > 0) {
            $this->_iInsertedID = $this->db->insert_id();
            return TRUE;
        }
        return FALSE;
    }

    private function update($table, $update_data, $aWhere) {
        if (is_null($table) || empty($table)) {
            return FALSE;
        }
        $this->db->where($aWhere);
        $this->db->update($table, $update_data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
        return FALSE;
    }

    private function getOneRecord($table, $aWhere) {
        if (is_null($table) || empty($table)) {
            return array();
        }
        $this->db->where($aWhere);
        $query = $this->db->get($table);
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return array();
    }

    private function getAllRecords($table, $aWhere) {
        if (is_null($table) || empty($table)) {
            return array();
        }
        $this->db->where($aWhere);
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();
    }

    /*********** ACCOMMODATION FUNCTIONS ************/
    
    public function getAllAccommodationTypes() {
        $query = $this->db->get($this->accommodationTypes);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();
    }
    
    public function countAllAccommodations($aWhere = array()) {
        return $this->countAllRecords($this->tablename, $aWhere);
    }
    
    
    public function getAccommodationInfo($aWhere) {
        if ( ! is_array($aWhere) || empty($aWhere)) {
            return array();
        }
        return $this->getOneRecord($this->tablename, $aWhere);
    }
    
    public function filterAccommodations($aWhere = array()) {
        if(is_array($aWhere) || !empty($aWhere)){
            foreach ($aWhere as $key => $value) {
                if(! empty($value)){
                    $this->db->where($key, $value);
                }
            }
        }
        $query = $this->db->get($this->tablename);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();
    }
    
    public function searchAccommodations($name = null) {
        if(! is_string($name) || empty($name)){
            return array();
        }
        $this->db->like('name', $name);
        $this->db->select('id, name');
        $query = $this->db->get($this->tablename);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();
    }
    
    public function getAllCounts($params = array()) {
        if(! is_array($params) || empty($params)){
            return array();
        }
        foreach ($params as $key => $value) {
            $this->db->like($key, $value);
        }
        $this->db->select('type');
        $query = $this->db->get($this->tablename);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();
    }
    
    public function getAllCheckins($accommodationId = null) {
        if(! valid_number($accommodationId)){
            return NULL;
        }
        $aWhere = array('accommodationId' => $accommodationId, 'status' => 1);
        return $this->countAllRecords($this->primaryinfotable, $aWhere);
    }
    
    public function getAllTodayCheckins($accommodationId = null, $date = null) {
        if(! valid_number($accommodationId) || is_null($date)){
            return NULL;
        }
        $aWhere = array('accommodationId' => $accommodationId);
        $like = array('checkIn' => $date);
        return $this->countAllRecords($this->primaryinfotable, $aWhere, $like);
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
    
    /*********** ZONES FUNCTIONS ************/
    
    public function getAllZones() {
        $query = $this->db->get($this->policestations);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();
    }
    
    public function getZone($aWhere = array()) {
        if(! is_array($aWhere) || empty($aWhere)){
            return array();
        }
        $this->db->where($aWhere);
        $query = $this->db->get($this->policestations);
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return array();
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
    
    public function deleteAccommodation($aWhere = array()) {
        if (!is_array($aWhere) || empty($aWhere)) {
            return FALSE;
        }
        $this->db->where($aWhere);
        $this->db->delete($this->tablename);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
        return FALSE;
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
    
        
    // GOOGLE CLOUD FUNCTIONALITIES

    public function upload_image($filename, $source) {
        $storage = new StorageClient();
        $file = fopen($source, 'r');
        $bucket = $storage->bucket(GCP_BUCKET_NAME);
        $object = $bucket->upload($file, [
            'name' => RELATIVE_ACCOMMODATIONS_IMAGES_PATH . $filename
        ]);
        $object->update(['acl' => []], ['predefinedAcl' => 'PUBLICREAD']);
        return $filename;
    }

    public function delete_image($filename) {
        $file = RELATIVE_ACCOMMODATIONS_IMAGES_PATH . $filename;
        if (file_get_contents(ACCOMMODATIONS_IMAGES_PATH.$filename)) {
            $storage = new StorageClient();
            $bucket = $storage->bucket(GCP_BUCKET_NAME);
            $object = $bucket->object($file);
            if ($object->delete()) {
                return TRUE;
            }
        }
        return FALSE;
    }

}
