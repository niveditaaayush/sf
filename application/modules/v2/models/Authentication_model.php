<?php
if ( ! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Authentication_model extends CI_Model {

    protected $tablename = 'vms19_secure_token';
    protected $primarykey = 'id';

    public function __construct() {
        parent::__construct();
    }

    public function getAuthenticationInfo() {
        $query = $this->db->get($this->tablename);
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return array();
    }

    public function updateAuthenticationInfo($update_data = array()) {
        if ( ! is_array($update_data) || empty($update_data)) {
            return FALSE;
        }
        $this->db->update($this->tablename, $update_data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
        return FALSE;
    }

}
