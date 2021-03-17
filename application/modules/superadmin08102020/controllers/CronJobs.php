<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CronJobs extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('accommodations_model');
        $this->load->model('visitors_model');
    }

    public function updateAccommodation() {

        set_time_limit(0);
        $accommodations = $this->accommodations_model->getAllAccommodations(array('status' => 1));
        if (@sizeof($accommodations) > 0) {
            foreach ($accommodations as $accommodation) {
                $aWhere = array('accommodationId' => $accommodation->id);
                $latestCheckin = $this->visitors_model->getLatestPrimaryInfoActivity($aWhere);
                if(@sizeof($latestCheckin) == 1){
                    if($accommodation->typeId == 8){
                        $time = strtotime('-30 days');
                    } else {
                        $time = strtotime('-72 hours');
                    }
                    
                    if(strtotime($latestCheckin->checkIn) < $time || $time > strtotime($latestCheckin->checkOut)){
                        $aWhere1 = array('id' => $accommodation->id);
                        $params = array(
                            'status' => 0,
                            'updatedOn' => DATETIME
                        );
                        $this->accommodations_model->updateAccommodationInfo($params, $aWhere1);
                    }
                }
            }
        }
    }

}
