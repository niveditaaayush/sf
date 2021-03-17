<?php
$district   = $this->input->get('district');
$zone       = $this->input->get('zone');
$division   = $this->input->get('division');
$sho_area   = $this->input->get('sho_area');
?>
<div class="basic-login-form-ad">
    <div class="row">
        <div class="basic-login-inner inline-basic-form">
            <form action="<?php echo $current_url.'/filter'; ?>" method="get">
                <div class="form-group-inner">
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12 district">
                        <div class="form-select-list">
                            <select id="district" class="form-control custom-select-value" name="district">
                                <option value="">Select District/Commissionerate</option>
                                <?php
                                if (@sizeof($cities) > 0) {
                                    foreach ($cities as $city) {?>
                                        <option value="<?php echo $city->district; ?>" <?php if ($city->district == $district) { echo "selected";} ?>><?php echo $city->district; ?></option>
                                <?php }
                                }?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12 district">
                        <div class="form-select-list">
                            <select id="zone" class="form-control custom-select-value" name="zone">
                                <option value="">Select Zone</option>
                                <?php // added by nivedita for filters
                                 if(!empty($district))
                                 {
                                    $zones = $this->accommodations_model->getAllDistrictZones(array('district' => $district));
                                 }
                                 else
                                    $zones = array();
                                if (@sizeof($zones) > 0) {
                                    foreach ($zones as $zo) {?>
                                        <option value="<?php echo $zo->zone; ?>" <?php if ($zo->zone == $zone) { echo "selected";} ?>><?php echo $zo->zone; ?></option>
                                <?php }
                                }?>
                                
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12 district">
                        <div class="form-select-list">
                            <select id="division" class="form-control custom-select-value" name="division">
                                <option value="">Select Division</option>
                                <?php // added by nivedita for filters
                                 if(!empty($zone))
                                 {
                                    $divisions = $this->accommodations_model->getAllZoneDivisions(array('zone' => $zone));
                                 }
                                 else
                                    $divisions = array();
                                if (@sizeof($divisions) > 0) {
                                    foreach ($divisions as $divi) {
                                        if($divi->division){
                                         ?>
                                       
                                        <option value="<?php echo $divi->division; ?>" <?php if ($divi->division == $division) { echo "selected";} ?>><?php echo $divi->division; ?></option>
                                       <?php  }
                                        }
                                     }
                                       ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12 district">
                        <div class="form-select-list">                                                                                    
                            <select id="sho_area" class="form-control custom-select-value" name="sho_area">
                                <option value="">Select SHO Area</option>
                                <?php // added by nivedita for filters
                                 if(!empty($division))
                                 {
                                    $division = $division != 'null' ? $division : NULL;
                                    $aWhere = array('zone' => $zone, 'division' => $division);
                                    $sho_areas = $this->accommodations_model->getAllDivisionSHOArea($aWhere);
                                 }
                                 else
                                    $sho_areas = array();
                                if (@sizeof($sho_areas) > 0) {
                                    foreach ($sho_areas as $sho) {
                                        if($sho->station){?>
                                        <option value="<?php echo $sho->station; ?>" <?php  if ($sho->station == $sho_area) { echo "selected";} ?>><?php echo $sho->station; ?></option>
                                <?php }
                                    }
                                }?>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12 district">
                        <div class="login-btn-inner">
                            <div class="login-horizental lg-hz-mg"><button class="btn btn-sm btn-primary login-submit-cs" type="submit">Submit</button></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>