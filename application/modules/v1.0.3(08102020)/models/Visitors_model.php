<?php
if ( ! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once APPPATH . 'third_party/vendor/autoload.php';
use Google\Cloud\Storage\StorageClient;

class Visitors_model extends CI_Model {
    protected $tablename = 'vms19_visitors_primary_info';
    protected $visitorstable = 'vms19_visitors';
    protected $visitorsOTPtable = 'vms19_visitors_otp';
    protected $roomCheckintable = 'vms19_room_checkins';
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
    
    private function delete($table, $aWhere) {
        if ( ! is_array($aWhere) || empty($aWhere)) {
            return FALSE;
        }
        $this->db->where($aWhere);
        $this->db->delete($table);
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

    private function countAllRecords($table, $aWhere = array(), $like = array()) {
        if (is_null($table) || empty($table)) {
            return 0;
        }
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

    /*     * ********* START VISITORS PRIMARY FUNCTIONS *********** */

    public function getAllPrimaryInfo() {
        $query = $this->db->get($this->tablename);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();
    }

    public function getAllVisitorPrimaryInfo($aWhere = array()) {
        if ( ! is_array($aWhere) || empty($aWhere)) {
            return array();
        }
        return $this->getAllRecords($this->tablename, $aWhere);
    }
    
    public function getLatestPrimaryInfo($aWhere = array()) {
        if ( ! is_array($aWhere) || empty($aWhere)) {
            return array();
        }
        $this->db->where($aWhere);
        $this->db->limit(1);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get($this->tablename);
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return array();
    }

    public function getPrimaryVisitorInfo($aWhere = array()) {
        if ( ! is_array($aWhere) || empty($aWhere)) {
            return array();
        }
        $this->db->where($aWhere);
        $this->db->limit(1);
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get($this->visitorstable);
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return array();
    }

    public function getVisitorPrimaryInfo($aWhere = array()) {
        if ( ! is_array($aWhere) || empty($aWhere)) {
            return array();
        }
        return $this->getOneRecord($this->tablename, $aWhere);
    }

    public function getVisitorOTP($aWhere = array()) {
        if ( ! is_array($aWhere) || empty($aWhere)) {
            return array();
        }
        return $this->getOneRecord($this->visitorsOTPtable, $aWhere);
    }

    public function storeVisitorPrimaryInfo($params = array()) {
        if ( ! is_array($params) || empty($params)) {
            return FALSE;
        }
        return $this->store($this->tablename, $params);
    }

    public function storeVisitorOTP($params = array()) {
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

    public function deleteVisitorPrimaryInfo($aWhere = array()) {
        if ( ! is_array($aWhere) || empty($aWhere)) {
            return FALSE;
        }
        return $this->delete($this->tablename, $aWhere);
    }
    
    public function deleteVisitorRoomCheckins($aWhere = array()) {
        if ( ! is_array($aWhere) || empty($aWhere)) {
            return FALSE;
        }
        return $this->delete($this->roomCheckintable, $aWhere);
    }

    /*********** START VISITORS FUNCTIONS ************/

    public function countAllVisitors($aWhere = array()) {
        return $this->countAllRecords($this->visitorstable, $aWhere);
    }

    public function getAllVisitorsInfo($aWhere = array()) {
        if ( ! is_array($aWhere) || empty($aWhere)) {
            return array();
        }
        return $this->getAllRecords($this->visitorstable, $aWhere);
    }

    public function getVisitorInfo($aWhere = array()) {
        if ( ! is_array($aWhere) || empty($aWhere)) {
            return array();
        }
        return $this->getOneRecord($this->visitorstable, $aWhere);
    }

    public function storeVisitorInfo($params = array()) {
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

    public function deleteVisitor($aWhere = array()) {
        if ( ! is_array($aWhere) || empty($aWhere)) {
            return FALSE;
        }
        $this->db->where($aWhere);
        $this->db->delete($this->visitorstable);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
        return FALSE;
    }
    
    /*********** START VISITORS ROOM FUNCTIONS ************/
    
    public function countAllCheckins($aWhere = array(), $like = array()) {
        return $this->countAllRecords($this->roomCheckintable, $aWhere, $like);
    }

    public function countAllCheckinRooms($aWhere = array()) {
        if ( ! is_array($aWhere) || empty($aWhere)) {
            return NULL;
        }
        return $this->countAllRecords($this->roomCheckintable, $aWhere);
    }

    public function getAllCheckinRoomsInfo($primaryId = null) {
        if ( ! valid_number($primaryId)) {
            return array();
        }
        $aWhere = array('vpId' => $primaryId, 'checkOut' => NULL);
        $this->db->where($aWhere);
        $query = $this->db->get($this->roomCheckintable);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();
    }

    public function getAllCheckinsByAccommodation($accommodationId = null, $date = null) {
        if(! valid_number($accommodationId)){
            return 0;
        }
        $this->db->where('vms19_visitors_primary_info.accommodationId', $accommodationId);
        $this->db->where('vms19_visitors_primary_info.status', 1);
        $this->db->where('vms19_room_checkins.checkOut', null);
        if(! is_null($date)){
            $this->db->like('vms19_room_checkins.checkIn', $date);
        }
        $this->db->from($this->roomCheckintable);
        $this->db->join($this->tablename, 'vms19_visitors_primary_info.id = vms19_room_checkins.vpId');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();
    }

    public function getCheckinRoomInfo($aWhere = array()) {
        if ( ! is_array($aWhere) || empty($aWhere)) {
            return array();
        }
        return $this->getOneRecord($this->roomCheckintable, $aWhere);
    }

    public function storeCheckinRoomInfo($params = array()) {
        if ( ! is_array($params) || empty($params)) {
            return FALSE;
        }
        return $this->store($this->roomCheckintable, $params);
    }

    public function updateCheckinRoomInfo($update_data = array(), $aWhere = array()) {
        if ( ! is_array($update_data) || empty($update_data) || ! is_array($aWhere) || empty($aWhere)) {
            return FALSE;
        }
        return $this->update($this->roomCheckintable, $update_data, $aWhere);
    }

    public function deleteCheckinRoom($aWhere = array()) {
        if ( ! is_array($aWhere) || empty($aWhere)) {
            return FALSE;
        }
        $this->db->where($aWhere);
        $this->db->delete($this->roomCheckintable);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
        return FALSE;
    }

    // GOOGLE CLOUD FUNCTIONALITIES

    public function upload_image($filename, $source) {
        $storage = new StorageClient();
        $file = fopen($source, 'r');
        $bucket = $storage->bucket(GCP_BUCKET_NAME);
        $object = $bucket->upload($file, [
            'name' => RELATIVE_VISITORS_IMAGES_PATH . $filename
        ]);
        $object->update(['acl' => []], ['predefinedAcl' => 'PUBLICREAD']);
        return $filename;
    }

    public function delete_image($filename) {
        $file = RELATIVE_VISITORS_IMAGES_PATH . $filename;
        if (file_get_contents(VISITORS_IMAGES_PATH . $filename)) {
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
