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
    
    public function activeVisitorWithAccommodation($aWhere = array(), $from = null, $to = null) {
        if (is_array($aWhere) && !empty($aWhere)) {
            foreach ($aWhere as $key => $value) {
                if(! empty($value)){
                    $this->db->where('a.'.$key, $value);
                }
            }
        }
        $this->db->where('vi.status', 1);
        if(! empty($from)){
            $this->db->where('vi.checkIn >=', $from);
        }
        if(! empty($to)){
            $this->db->where('vi.checkIn <=', $to);
        }
        $this->db->select('a.name, a.type, CONCAT(v.firstName, " ", v.lastName) AS guestName, vi.id AS primaryId, vi.phoneNumber, v.address,'
            . ' vi.roomNumber, vi.checkIn, vi.checkOut, v.photoOfVisitor, v.idProofPhotoBack, v.idProofPhotoFront');
        $this->db->from('vms19_visitors v');
        $this->db->join('vms19_visitors_primary_info vi', 'vi.id = v.vpId', 'inner');
        $this->db->join('vms19_accommodations a', 'a.id = vi.accommodationId', 'inner');
        $this->db->order_by('vi.checkIn', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();
    }
    
    public function allVisitorWithAccommodation($aWhere = array(), $from = null, $to = null) {
        if (is_array($aWhere) && !empty($aWhere)) {
            foreach ($aWhere as $key => $value) {
                if(! empty($value)){
                    $this->db->where('a.'.$key, $value);
                }
            }
        }
        if(! empty($from)){
            $this->db->where('vi.checkIn >=', $from);
        }
        if(! empty($to)){
            $this->db->where('vi.checkIn <=', $to);
        }
        $this->db->select('a.name, a.type, CONCAT(v.firstName, " ", v.lastName) AS guestName, vi.id AS primaryId, vi.phoneNumber, v.address,'
            . ' vi.roomNumber, vi.checkIn, vi.checkOut, v.photoOfVisitor, v.idProofPhotoBack, v.idProofPhotoFront');
        $this->db->from('vms19_visitors v');
        $this->db->join('vms19_visitors_primary_info vi', 'vi.id = v.vpId', 'inner');
        $this->db->join('vms19_accommodations a', 'a.id = vi.accommodationId', 'inner');
        $this->db->order_by('vi.checkIn', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();
    }
    
    public function allVisitorPastCheckins($aWhere = array(), $from = null, $to = null) {
        if (is_array($aWhere) && !empty($aWhere)) {
            foreach ($aWhere as $key => $value) {
                if(! empty($value)){
                    $this->db->where('vi.'.$key, $value);
                }
            }
        }
        if(! empty($from)){
            $this->db->where('vi.checkIn >=', $from);
        }
        if(! empty($to)){
            $this->db->where('vi.checkIn <=', $to);
        }
        $this->db->where('vi.status', 0);
        $this->db->select('a.name, a.type, a.city, CONCAT(v.firstName, " ", v.lastName) AS guestName, vi.id AS primaryId, vi.phoneNumber, v.address,'
            . ' vi.roomNumber, vi.checkIn, vi.checkOut, v.photoOfVisitor, v.idProofPhotoBack, v.idProofPhotoFront');
        $this->db->from('vms19_visitors v');
        $this->db->join('vms19_visitors_primary_info vi', 'vi.id = v.vpId', 'inner');
        $this->db->join('vms19_accommodations a', 'a.id = vi.accommodationId', 'inner');
        $this->db->order_by('vi.checkIn', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();
    }
    
    // UPDATE ALL ROOM CHECKINS WITH PRIMARY INFO    
    public function getAllPrimaryVisitorWithPrimaryInfo($aWhere = array()) {
        if (is_array($aWhere) && !empty($aWhere)) {
            foreach ($aWhere as $key => $value) {
                if(! empty($value)){
                    $this->db->where('vi.'.$key, $value);
                }
            }
        }
        $this->db->select('v.*, vi.roomNumber, vi.checkIn, vi.checkOut');
        $this->db->from('vms19_visitors v');
        $this->db->join('vms19_visitors_primary_info vi', 'vi.id = v.vpId', 'inner');
        $this->db->order_by('vi.id', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();
    }

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
    
    public function getLatestPrimaryInfoActivity($aWhere = array()) {
        if ( ! is_array($aWhere) || empty($aWhere)) {
            return array();
        }
        $this->db->where($aWhere);
        $this->db->order_by('checkIn', 'DESC');
        $this->db->order_by('checkOut', 'DESC');
        $this->db->limit(1);
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
        $this->db->where($aWhere);
        $this->db->delete($this->tablename);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
        return FALSE;
    }

    /*     * ********* START VISITORS FUNCTIONS *********** */

    public function countAllVisitors($aWhere = array()) {
        return $this->countAllRecords($this->visitorstable, $aWhere);
    }

//    public function countAllActiveVisitors($aWhere = array()) {
//
//        if (is_array($aWhere) && ! empty($aWhere)) {
//            foreach ($aWhere as $key => $value) {
//                $this->db->like('vms19_visitors_primary_info.' . $key, $value);
//            }
//        }
//        $this->db->where('vms19_visitors_primary_info.status', 1);
//        $this->db->join($this->tablename, 'vms19_visitors_primary_info.id = vms19_visitors.vpId');
//        $this->db->join('vms19_accommodations', 'vms19_accommodations.id = vms19_visitors_primary_info.accommodationId');
//        $count = $this->db->count_all_results($this->visitorstable);
//        if ($count > 0) {
//            return $count;
//        }
//        return 0;
//    }

    public function countAllActiveVisitors($date = null, $accommodationId = null) {

        if ( ! is_null($date) || ! empty($date)) {
            $this->db->like('vms19_visitors_primary_info.checkIn', $date);
        }
        if (valid_number($accommodationId)) {
            $this->db->where('vms19_accommodations.id', $accommodationId);
        }
        $this->db->where('vms19_visitors_primary_info.status', 1);
        $this->db->join($this->tablename, 'vms19_visitors_primary_info.id = vms19_visitors.vpId');
        $this->db->join('vms19_accommodations', 'vms19_accommodations.id = vms19_visitors_primary_info.accommodationId');
        $count = $this->db->count_all_results($this->visitorstable);
        if ($count > 0) {
            return $count;
        }
        return 0;
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

    /*     * ********* START VISITORS ROOM FUNCTIONS *********** */

    public function countAllCheckins($aWhere = array(), $like = array()) {
        return $this->countAllRecords($this->roomCheckintable, $aWhere, $like);
    }

//    public function countAllActiveCheckins($aWhere = array(), $like = array()) {
//        return $this->countAllRecords($this->roomCheckintable, $aWhere, $like);
//    }

    public function countAllActiveCheckins($date = null, $accommodationId = null) {

        if ( ! empty($date)) {
            $this->db->like('vms19_visitors_primary_info.checkIn', $date);
        }
        if (valid_number($accommodationId)) {
            $this->db->where('vms19_accommodations.id', $accommodationId);
        }
        $this->db->where('vms19_visitors_primary_info.status', 1);
        $this->db->where('vms19_room_checkins.checkOut', NULL);
        $this->db->from($this->roomCheckintable);
        $this->db->join('vms19_visitors_primary_info', 'vms19_visitors_primary_info.id = vms19_room_checkins.vpId', 'inner');
        $this->db->join('vms19_accommodations', 'vms19_accommodations.id = vms19_visitors_primary_info.accommodationId', 'inner');
        $count = $this->db->count_all_results();
        if ($count > 0) {
            return $count;
        }
        return 0;
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
        if ( ! valid_number($accommodationId)) {
            return 0;
        }
        $this->db->where(array('vms19_visitors_primary_info.accommodationId' => $accommodationId, 'vms19_visitors_primary_info.status' => 1));
        if ( ! is_null($date)) {
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
    
    // CHECKINS FUNCTIONS
    public function getActiveCheckinsWithAccommodation($aWhere = array(), $from = null, $to = null) {
        
        if (is_array($aWhere) && !empty($aWhere)) {
            foreach ($aWhere as $key => $value) {
                if(! empty($value)){
                    $this->db->where('a.'.$key, $value);
                }
            }
        }
        if(! empty($from)){
            $this->db->where('vi.checkIn >=', $from);
        }
        if(! empty($to)){
            $this->db->where('vi.checkIn <=', $to);
        }
        $this->db->where('vi.status', 1);
        $this->db->select('a.name, a.type, rc.vpId AS primaryId, vi.phoneNumber, vi.checkIn');
        $this->db->from('vms19_room_checkins rc');
        $this->db->join('vms19_visitors_primary_info vi', 'vi.id = rc.vpId', 'inner');
        $this->db->join('vms19_accommodations a', 'a.id = vi.accommodationId', 'inner');
        $this->db->order_by('vi.checkIn', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();
    }
    
    public function getAllCheckinsWithAccommodation($aWhere = array(), $from = null, $to = null) {
        
        if (is_array($aWhere) && !empty($aWhere)) {
            foreach ($aWhere as $key => $value) {
                if(! empty($value)){
                    $this->db->where('a.'.$key, $value);
                }
            }
        }
        if(! empty($from)){
            $this->db->where('vi.checkIn >=', $from);
        }
        if(! empty($to)){
            $this->db->where('vi.checkIn <=', $to);
        }
        $this->db->select('a.name, a.type, rc.vpId AS primaryId, vi.phoneNumber, vi.checkIn, vi.checkOut');
        $this->db->from('vms19_room_checkins rc');
        $this->db->join('vms19_visitors_primary_info vi', 'vi.id = rc.vpId', 'inner');
        $this->db->join('vms19_accommodations a', 'a.id = vi.accommodationId', 'inner');
        $this->db->order_by('vi.checkIn', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();
    }
    
    public function getPastCheckins($aWhere = array(), $from = null, $to = null) {
        if (is_array($aWhere) && !empty($aWhere)) {
            foreach ($aWhere as $key => $value) {
                if(! empty($value)){
                    $this->db->where('vi.'.$key, $value);
                }
            }
        }
        if(! empty($from)){
            $this->db->where('vi.checkIn >=', $from);
        }
        if(! empty($to)){
            $this->db->where('vi.checkIn <=', $to);
        }
        $this->db->where('vi.status', 0);
        $this->db->select('a.name, a.type, a.city, vi.id AS primaryId, vi.phoneNumber, vi.roomNumber, rc.roomNumber, vi.checkIn, vi.checkOut');
        $this->db->from('vms19_room_checkins rc');
        $this->db->join('vms19_visitors_primary_info vi', 'vi.id = rc.vpId', 'inner');
        $this->db->join('vms19_accommodations a', 'a.id = vi.accommodationId', 'inner');
        $this->db->order_by('vi.checkIn', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();
    }
    
    public function getAllCheckinsWthAccommodationExport($status = null, $aWhere = array(), $from = null, $to = null) {

        if (is_array($aWhere) && !empty($aWhere)) {
            foreach ($aWhere as $key => $value) {
                if(! empty($value)){
                    $this->db->where('a.'.$key, $value);
                }
            }
        }
        if($status == 'active'){
            $this->db->where('vi.status', 1);
        }
        if(! empty($from)){
            $this->db->where('vi.checkIn >=', $from);
        }
        if(! empty($to)){
            $this->db->where('vi.checkIn <=', $to);
        }
        $this->db->select('a.name, a.type, rc.vpId, vi.checkIn, vi.checkOut');
        $this->db->from('vms19_room_checkins rc');
        $this->db->join('vms19_visitors_primary_info vi', 'vi.id = rc.vpId', 'inner');
        $this->db->join('vms19_accommodations a', 'a.id = vi.accommodationId', 'inner');
        $this->db->order_by('vi.checkIn', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();
    }

    public function countAllSOS($a_id)
    {
        if (valid_number($a_id)) {
            $this->db->where('vms19_accommodations.id', $a_id);
        }
        $this->db->where('checkout' , NULL);
        $this->db->where('sos !=',NULL);
        $this->db->where('vms19_visitors_primary_info.status', 1);
        $this->db->join($this->tablename, 'vms19_visitors_primary_info.id = vms19_visitors.vpId');
        $this->db->join('vms19_accommodations', 'vms19_accommodations.id = vms19_visitors_primary_info.accommodationId');
        $count = $this->db->count_all_results($this->visitorstable);
       // print_r($count); exit;
        if ($count > 0) {
            return $count;
        }
        return 0;
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
