<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Api_model extends CI_Model {

    protected $auctionTable = 'ae_auctions';
    protected $managerTable = 'ae_managers';
    protected $vehicleTypes = 'ae_vehicleTypes';
    protected $vehicleMakers = 'ae_vehicleMakers';
    protected $vehicleModels = 'ae_vehicleModels';
    protected $vehicleVariants = 'ae_vehicleVariants';
    protected $yards = 'ae_yards';
    protected $sellers = 'ae_vendors';
    protected $vehicles = 'ae_vehicles';
    protected $yardManagers = 'ae_yardManagers';
    protected $parkingVehicles = 'ae_parkingVehicles';
    protected $sellerParkingYard = 'ae_sellerParkingYard';
    protected $managerBalance   = 'ae_managerBalance';
    protected $sellerBalance   = 'ae_sellerBalance';
    protected $bankBalance   = 'ae_bankBalance';
    protected $yardPayments = 'ae_parkingVehiclePayments';
    protected $sellerBuyerPayments = 'ae_sellerBuyerPayments';
    protected $primarykey = 'id';

    public function __construct() {
        parent::__construct();
    }
    
    /*********** START COMMON FUNCTIONS ************/
    
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
    
    /*********** END COMMON FUNCTIONS ************/
    
    public function getManagerInformation($aWhere) {
        if (!is_array($aWhere) || empty($aWhere)) {
            return array();
        }
        return $this->getOneRecord($this->managerTable, $aWhere);
    }
    
    public function getAllManagers($aWhere) {
        if (!is_array($aWhere) || empty($aWhere)) {
            return array();
        }
        return $this->getAllRecords($this->managerTable, $aWhere);
    }

    public function getAllVehicleTypes() {
        $this->db->select('*')->from($this->vehicleTypes);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();
    }

    public function getVehicleTypeInformation($aWhere) {
        if (!is_array($aWhere) || empty($aWhere)) {
            return array();
        }
        return $this->getOneRecord($this->vehicleTypes, $aWhere);
    }

    public function getAllMakersByVehicleTypeId($aWhere = array()) {
        if (!is_array($aWhere) || empty($aWhere)) {
            return array();
        }
        return $this->getAllRecords($this->vehicleMakers, $aWhere);
    }

    public function getMakerInformation($aWhere) {
        if (!is_array($aWhere) || empty($aWhere)) {
            return array();
        }
        return $this->getOneRecord($this->vehicleMakers, $aWhere);
    }

    public function getAllModelsByMakerId($aWhere = array()) {
        if (!is_array($aWhere) || empty($aWhere)) {
            return array();
        }
        return $this->getAllRecords($this->vehicleModels, $aWhere);
    }

    public function getModelInformation($aWhere) {
        if (!is_array($aWhere) || empty($aWhere)) {
            return array();
        }
        return $this->getOneRecord($this->vehicleModels, $aWhere);
    }

    public function getAllVariantsByModelId($aWhere = array()) {
        if (!is_array($aWhere) || empty($aWhere)) {
            return array();
        }
        $this->db->where($aWhere);
        $this->db->select('*')->from($this->vehicleVariants);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();
    }

    public function getVariantInformation($aWhere) {
        if (!is_array($aWhere) || empty($aWhere)) {
            return array();
        }
        $this->db->where($aWhere);
        $query = $this->db->get($this->vehicleVariantss);
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return array();
    }

    public function getAllManagerYards($iMid = NULL, $limit = 0, $offset = 0) {
        if (!preg_match(NUMBER, $iMid)) {
            return array();
        }
        $this->db->where(array('ae_yardManagers.managerId' => $iMid, 'ae_yards.status' => 'Active'));
        $this->db->select('ae_yards.*, (SELECT count(*) FROM ae_parkingVehicles WHERE ae_yards.id = ae_parkingVehicles.yId AND outwardTime IS NULL) AS VehiclesCount');
        $this->db->from($this->yardManagers);
        $this->db->join('ae_yards', 'ae_yards.id = ae_yardManagers.yardId', 'left');
        $this->db->order_by('ae_yardManagers.id', 'ASC');
        if ($limit != 0) {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();
    }

    // YARDS INFORMATION
    public function getParkingYardSellers($iYid = NULL) {
        if (!preg_match(NUMBER, $iYid)) {
            return array();
        }
        $query = $this->db->query('SELECT GROUP_CONCAT(ae_vendors.userName) AS sellers'
                . ' FROM ae_sellerParkingYard'
                . ' LEFT JOIN ae_vendors ON (ae_vendors.id=ae_sellerParkingYard.sellerId)'
                . ' WHERE ae_sellerParkingYard.yardId = ' . $iYid);
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return array();
    }

    // PARKING YARD BILLING DETAILS
    public function getYardPaymentDetails($iYid = NULL) {
        if (!preg_match(NUMBER, $iYid)) {
            return array();
        }
        $this->db->where(array('ae_parkingVehiclePayments.yardId' => $iYid));
        $this->db->select('ae_parkingVehiclePayments.*, ae_yards.name AS yardName, ae_managers.userName AS manager');
        $this->db->join('ae_yards', 'ae_yards.id = ae_parkingVehiclePayments.yardId');
        $this->db->join('ae_managers', 'ae_managers.id = ae_parkingVehiclePayments.managerId');
        $query = $this->db->get($this->yardPayments);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();
    }
    
    public function getManagerDepositDetails($id = NULL) {
        if (!preg_match(NUMBER, $id)) {
            return array();
        }
        $this->db->where(array('ae_parkingVehiclePayments.id' => $id));
        $this->db->select('ae_parkingVehiclePayments.*, ae_yards.name AS yardName, ae_managers.userName AS manager');
        $this->db->join('ae_yards', 'ae_yards.id = ae_parkingVehiclePayments.yardId');
        $this->db->join('ae_managers', 'ae_managers.id = ae_parkingVehiclePayments.managerId');
        $query = $this->db->get($this->yardPayments);
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return array();
    }

    // YARD PARKING VEHICLES INFORMATION
    public function getYardParkingVehicles($iYid = NULL) {
        if (!preg_match(NUMBER, $iYid)) {
            return array();
        }
        $this->db->where(array('ae_parkingVehicles.yId' => $iYid, 'ae_parkingVehicles.outwardTime' => NULL));
        $this->db->select('ae_vehicles.id, ae_vehicles.regNumber, ae_vehicles.vehicleId, ae_vehicleModels.model, ae_vehicleTypes.type, ae_vendors.userName AS sellerName');
        $this->db->join('ae_vehicles', 'ae_vehicles.id = ae_parkingVehicles.vehicleId AND ae_vehicles.status = 1');
        $this->db->join('ae_vendors', 'ae_vendors.id = ae_parkingVehicles.sellerId', 'left');
        $this->db->join('ae_vehicleModels', 'ae_vehicleModels.id = ae_vehicles.modelId');
        $this->db->join('ae_vehicleTypes', 'ae_vehicleTypes.id = ae_vehicles.typeId');
        $query = $this->db->get($this->parkingVehicles);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();
    }

    public function getParkingVehicleInformation($iVid = NULL) {
        if (!preg_match(NUMBER, $iVid)) {
            return array();
        }
        $this->db->where(array('ae_parkingVehicles.vehicleId' => $iVid));
        $this->db->select('ae_parkingVehicles.*, ae_vehicles.*, ae_vendors.userName AS sellerName, ae_yards.name AS yardName, ae_vehicleTypes.type AS vehicleType, ae_vehicleMakers.maker AS makerName, ae_vehicleModels.model AS modelName, ae_vehicleVariants.variant AS variantName');
        $this->db->join('ae_vehicles', 'ae_vehicles.id = ae_parkingVehicles.vehicleId AND ae_vehicles.status = 1');
        $this->db->join('ae_vendors', 'ae_vendors.id = ae_parkingVehicles.sellerId');
        $this->db->join('ae_yards', 'ae_yards.id = ae_parkingVehicles.yId');
        $this->db->join('ae_vehicleTypes', 'ae_vehicleTypes.id = ae_vehicles.typeId');
        $this->db->join('ae_vehicleMakers', 'ae_vehicleMakers.id = ae_vehicles.makerId');
        $this->db->join('ae_vehicleModels', 'ae_vehicleModels.id = ae_vehicles.modelId');
        $this->db->join('ae_vehicleVariants', 'ae_vehicleVariants.id = ae_vehicles.variantId');
        $query = $this->db->get($this->parkingVehicles);
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return array();
    }

    public function getVehicleInformation($regNumber = NULL) {
        if (!is_string($regNumber) || empty($regNumber)) {
            return array();
        }
        $this->db->where(array('ae_vehicles.regNumber' => $regNumber, 'ae_vehicles.status' => 1));
        $this->db->select('ae_vehicles.id, ae_parkingVehicles.id AS parkingId, ae_parkingVehicles.yId AS yardId, ae_parkingVehicles.sellerId, ae_parkingVehicles.inwardTime, ae_parkingVehicles.outwardTime, ae_vehicles.vehicleId, ae_vehicles.regNumber, ae_vehicles.typeId, ae_vehicles.status, ae_vendors.userName AS sellerName, ae_vehicleModels.model AS modelName');
        $this->db->join('ae_parkingVehicles', 'ae_vehicles.id = ae_parkingVehicles.vehicleId', 'inner');
        $this->db->join('ae_vendors', 'ae_vendors.id = ae_parkingVehicles.sellerId', 'left');
        $this->db->join('ae_vehicleModels', 'ae_vehicleModels.id = ae_vehicles.modelId', 'left');
        $query = $this->db->get($this->vehicles);
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return array();
    }
    
    public function getParkingVehicle($aWhere = array()) {
        if (! is_array($aWhere) || empty($aWhere)) {
            return array();
        }
        $this->db->where($aWhere);
        $query = $this->db->get($this->vehicles);
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return array();
    }

    public function getYardVehicleInformation($yardId = NULL, $regNumber = NULL) {
        if (!preg_match(NUMBER, $yardId) || !is_string($regNumber) || empty($regNumber)) {
            return array();
        }
        $this->db->where(array('ae_vehicles.regNumber' => $regNumber, 'ae_parkingVehicles.yId' => $yardId, 'ae_vehicles.status' => 1));
        $this->db->select('ae_vehicles.id, ae_parkingVehicles.id AS parkingId, ae_parkingVehicles.sellerId, ae_parkingVehicles.inwardTime,'
            . ' ae_parkingVehicles.outwardTime, ae_vehicles.vehicleId, ae_vehicles.regNumber, ae_vehicles.typeId, ae_vehicles.status, ae_vehicleTypes.type,'
            . ' ae_vendors.userName AS sellerName, ae_vendors.billingLimit, ae_vendors.amountLimit, ae_vehicleModels.model AS modelName');
        $this->db->join('ae_parkingVehicles', 'ae_vehicles.id = ae_parkingVehicles.vehicleId', 'inner');
        $this->db->join('ae_vendors', 'ae_vendors.id = ae_parkingVehicles.sellerId', 'left');
        $this->db->join('ae_vehicleTypes', 'ae_vehicleTypes.id = ae_vehicles.typeId', 'left');
        $this->db->join('ae_vehicleModels', 'ae_vehicleModels.id = ae_vehicles.modelId', 'left');
        $query = $this->db->get($this->vehicles);
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return array();
    }

    // PARKING SELLERS
    public function getAllSellersByYard($yid = NULL) {
        if (!preg_match(NUMBER, $yid)) {
            return array();
        }
        $query = $this->db->query('SELECT DISTINCT(ae_sellerParkingYard.sellerId), ae_vendors.userName AS sellerName '
                . 'FROM ae_sellerParkingYard JOIN ae_vendors ON (ae_vendors.id = ae_sellerParkingYard.sellerId)'
                . ' WHERE ae_sellerParkingYard.yardId = ' . $yid);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();
    }

    public function getParkingSellerInformation($yardId = NULL, $sellerId = NULL) {
        if (!preg_match(NUMBER, $yardId) || !preg_match(NUMBER, $sellerId)) {
            return array();
        }
        $this->db->where(array('yardId' => $yardId, 'sellerId' => $sellerId));
        $query = $this->db->get($this->sellerParkingYard);
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return array();
    }

    public function storeYardPayment($params) {
        if (!is_array($params) || empty($params)) {
            return FALSE;
        }
        return $this->store($this->yardPayments, $params);
    }
    
    public function storeVehicleInformation($params) {
        if (!is_array($params) || empty($params)) {
            return FALSE;
        }
        return $this->store($this->vehicles, $params);
    }
    
    public function storeParkingVehicleInformation($params) {
        if (!is_array($params) || empty($params)) {
            return FALSE;
        }
        return $this->store($this->parkingVehicles, $params);
    }

    public function updateParkingInformation($update_data = array(), $aWhere = array()) {
        if (!is_array($update_data) || empty($update_data) || !is_array($aWhere) || empty($aWhere)) {
            return FALSE;
        }
        return $this->update($this->parkingVehicles, $update_data, $aWhere);
    }

    public function updateVehicleInformation($update_data = array(), $aWhere = array()) {
        if (!is_array($update_data) || empty($update_data) || !is_array($aWhere) || empty($aWhere)) {
            return FALSE;
        }
        return $this->update($this->vehicles, $update_data, $aWhere);
    }
    
    public function updateDepositInformation($update_data = array(), $aWhere = array()) {
        if (!is_array($update_data) || empty($update_data) || !is_array($aWhere) || empty($aWhere)) {
            return FALSE;
        }
        return $this->update($this->yardPayments, $update_data, $aWhere);
    }

    /*     * *************** SEARCH VEHICLE FUNCTIONS ************************* */

    public function getAllVehiclesBySearch($search = NULL) {
        if (!is_string($search) || $search == '') {
            return array();
        }
        $this->db->or_like('ae_vehicles.vehicleId', $search);
        $this->db->or_like('ae_vehicles.regNumber', $search);
        $this->db->or_like('ae_vehicles.engineNo', $search);
        $this->db->or_like('ae_vehicles.chassisNo', $search);
        $this->db->select('ae_yards.name AS yardName, ae_vehicles.id, ae_vehicles.regNumber, ae_vehicles.vehicleId, ae_vehicleModels.model, ae_vehicleTypes.type, ae_parkingVehicles.outwardTime, ae_vendors.userName AS sellerName');
        $this->db->join('ae_vehicles', 'ae_vehicles.id = ae_parkingVehicles.vehicleId');
        $this->db->join('ae_yards', 'ae_yards.id = ae_parkingVehicles.yId');
        $this->db->join('ae_vendors', 'ae_vendors.id = ae_parkingVehicles.sellerId', 'left');
        $this->db->join('ae_vehicleModels', 'ae_vehicleModels.id = ae_vehicles.modelId');
        $this->db->join('ae_vehicleTypes', 'ae_vehicleTypes.id = ae_vehicles.typeId');
        $query = $this->db->get($this->parkingVehicles);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();
    }

    public function getYardVehiclesBySearch($iYid = NULL, $search = NULL) {
        if (!is_string($search) || $search == '' || !preg_match(NUMBER, $iYid)) {
            return array();
        }
        $this->db->where(array('ae_parkingVehicles.yId' => $iYid));
        $this->db->select('ae_vehicles.id, ae_vehicles.regNumber, ae_vehicles.vehicleId, ae_vehicleModels.model, ae_vehicleTypes.type, ae_parkingVehicles.outwardTime, ae_vendors.userName AS sellerName');
        $this->db->join('ae_vehicles', 'ae_vehicles.id = ae_parkingVehicles.vehicleId AND (ae_vehicles.vehicleId LIKE "%' . $search . '%" OR ae_vehicles.regNumber LIKE "%' . $search . '%" OR ae_vehicles.engineNo LIKE "%' . $search . '%" OR ae_vehicles.chassisNo LIKE "%' . $search . '%")');
        $this->db->join('ae_vendors', 'ae_vendors.id = ae_parkingVehicles.sellerId', 'left');
        $this->db->join('ae_vehicleModels', 'ae_vehicleModels.id = ae_vehicles.modelId');
        $this->db->join('ae_vehicleTypes', 'ae_vehicleTypes.id = ae_vehicles.typeId');
        $query = $this->db->get($this->parkingVehicles);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();
    }
    
    /******************* MANAGER BALANCE *******************/
    
    public function addManagerBalance($params = array()) {
        if (!is_array($params) || empty($params)) {
            return FALSE;
        }
        return $this->store($this->managerBalance, $params);
    }
    
    public function updateManagerBalance($update_data = array(), $aWhere = array()) {
        if (!is_array($update_data) || empty($update_data) || !is_array($aWhere) || empty($aWhere)) {
            return FALSE;
        }
        return $this->update($this->managerBalance, $update_data, $aWhere);
    }
    
    public function managerCurrentBalance($aWhere) {
        if (!is_array($aWhere) || empty($aWhere)) {
            return array();
        }
        return $this->getOneRecord($this->managerBalance, $aWhere);
    }

    public function latestManagerBalance($aWhere) {
        if (!is_array($aWhere) || empty($aWhere)) {
            return array();
        }
        $this->db->where($aWhere);
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get($this->managerBalance);
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return array();
    }
    
    /**************** END MAMAGER BALANCE *****************/

    /*************** START AUCTIONS ***************/
    
    public function getManagerAuctions($iMid) {
        if (! preg_match(NUMBER, $iMid)) {
            return array();
        }
        $query = $this->db->query('SELECT aus.id, aus.name, aus.date, aus.startTime, aus.endTime, aus.entryFee, ays.address, '
            . '(SELECT COUNT(*) FROM ae_auctionVehicles WHERE auctionId = '.$iMid.') AS totalVehicles, '
            . '(SELECT COUNT(*) FROM ae_auctionVehicles WHERE status = 3 AND auctionId = '.$iMid.') AS sold '
            . 'FROM ae_auctionManagers aums '
            . 'JOIN ae_auctions aus ON (aus.id = aums.auctionId) '
            . 'JOIN ae_yards ays ON (ays.id = aus.assignedYard) '
            . 'WHERE aums.managerId = '.$iMid);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();
    }
    
    public function getManagerAuction($iMid = null, $iID = null) {
        if (! preg_match(NUMBER, $iMid) || ! preg_match(NUMBER, $iID)) {
            return array();
        }
        $query = $this->db->query('SELECT aus.id, aus.name, aus.date, aus.entryFee, ays.address, '
            . '(SELECT COUNT(*) FROM ae_auctionVehicles WHERE auctionId = '.$iMid.') AS totalVehicles, '
            . '(SELECT COUNT(*) FROM ae_auctionVehicles WHERE status = 3 AND auctionId = '.$iMid.') AS sold '
            . 'FROM ae_auctionManagers aums '
            . 'JOIN ae_auctions aus ON (aus.id = aums.auctionId) '
            . 'JOIN ae_yards ays ON (ays.id = aus.assignedYard) '
            . 'WHERE aums.managerId = '.$iMid.' AND auctionId = '.$iID);
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return array();
    }
    
    public function getAuctionVehicles($iAid = NULL) {
        if (!preg_match(NUMBER, $iAid)) {
            return array();
        }
        $this->db->where(array('ae_auctionVehicles.auctionId' => $iAid));
        $this->db->select('ae_vehicles.id, ae_vehicles.regNumber, ae_vehicles.vehicleId, ae_auctionVehicles.reservePrice, ae_vehicleModels.model, ae_vehicleTypes.type, ae_vendors.userName AS sellerName');
        $this->db->join('ae_vehicles', 'ae_vehicles.id = ae_auctionVehicles.vehicleId AND ae_vehicles.status = 1');
        $this->db->join('ae_vendors', 'ae_vendors.id = ae_auctionVehicles.sellerId', 'left');
        $this->db->join('ae_vehicleModels', 'ae_vehicleModels.id = ae_vehicles.modelId');
        $this->db->join('ae_vehicleTypes', 'ae_vehicleTypes.id = ae_vehicles.typeId');
        $query = $this->db->get('ae_auctionVehicles');
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();
    }
    
    /*************** END AUCTIONS ****************/
    
    
    /*************** MANAGER ACCESS BANK ACCOUNTS ****************/
    
    
    public function getManagerAccessBanks($managerId = null) {
        if (! preg_match(NUMBER, $managerId)) {
            return array();
        }
        $this->db->where(array('ae_managerAccessBankAccounts.managerId' => $managerId));
        $this->db->select('ae_bankAccounts.id, ae_bankAccounts.bankName, ae_bankAccounts.branchName');
        $this->db->join('ae_bankAccounts', 'ae_bankAccounts.id = ae_managerAccessBankAccounts.bankId');
        $query = $this->db->get('ae_managerAccessBankAccounts');
        if($query->num_rows() > 0){
            return $query->result();
        }
        return array();
    }
    
    // SELLER PAYMENTS FUNCTIONS
    
    public function addSellerBalance($params = array()) {
        if (!is_array($params) || empty($params)) {
            return FALSE;
        }
        return $this->store($this->sellerBalance, $params);
    }
    
    public function updateSellerBalance($update_data = array(), $aWhere = array()) {
        if (!is_array($update_data) || empty($update_data) || !is_array($aWhere) || empty($aWhere)) {
            return FALSE;
        }
        return $this->update($this->sellerBalance, $update_data, $aWhere);
    }
    
    public function sellerCurrentBalance($aWhere) {
        if (!is_array($aWhere) || empty($aWhere)) {
            return array();
        }
        return $this->getOneRecord($this->sellerBalance, $aWhere);
    }
    
    public function sellerBalance($aWhere = array()) {
        if ( ! is_array($aWhere) || empty($aWhere)) {
            return array();
        }
        $this->db->where($aWhere);
        $this->db->select('SUM(discount) AS discount, SUM(totalAmount) AS totalAmount, SUM(paidAmount) AS paidAmount');
        $query = $this->db->get($this->sellerBuyerPayments);
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return array();
    }

    public function latestSellerBalance($aWhere) {
        if (!is_array($aWhere) || empty($aWhere)) {
            return array();
        }
        $this->db->where($aWhere);
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get($this->sellerBalance);
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return array();
    }
    
    public function sellerInvoice($params) {
        if(!is_array($params) || empty($params)){
            return FALSE;
        }
        return $this->store('ae_sellerBuyerPayments', $params);
    }
    
    /******************* BANK BALANCE *******************/
    
    public function addBankBalance($params = array()) {
        if (!is_array($params) || empty($params)) {
            return FALSE;
        }
        return $this->store($this->bankBalance, $params);
    }
    
    public function updateBankBalance($update_data = array(), $aWhere = array()) {
        if (!is_array($update_data) || empty($update_data) || !is_array($aWhere) || empty($aWhere)) {
            return FALSE;
        }
        return $this->update($this->bankBalance, $update_data, $aWhere);
    }
    
    public function bankCurrentBalance($aWhere) {
        if (!is_array($aWhere) || empty($aWhere)) {
            return array();
        }
        return $this->getOneRecord($this->bankBalance, $aWhere);
    }

    public function latestBankBalance($aWhere) {
        if (!is_array($aWhere) || empty($aWhere)) {
            return array();
        }
        $this->db->where($aWhere);
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get($this->bankBalance);
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return array();
    }
    
    /**************** END BANK BALANCE *****************/
}
