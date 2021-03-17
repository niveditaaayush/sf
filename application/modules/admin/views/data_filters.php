<?php
$district   = $this->input->get('district') ? $this->input->get('district') : $loginUser->district;
$zone       = $this->input->get('zone') ? $this->input->get('zone') : $loginUser->zone;
$division   = $this->input->get('division') ? $this->input->get('division') : $loginUser->division;
$sho_area   = $this->input->get('sho_area') ? $this->input->get('sho_area') : $loginUser->sho_area;
?>
<div class="basic-login-form-ad">
    <div class="row">
        <div class="basic-login-inner inline-basic-form">
            <form action="<?php echo $current_url.'/filter'; ?>" method="get">
                <div class="form-group-inner">
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12 district">
                        <div class="form-select-list">
                            <select id="district" class="form-control custom-select-value" name="district" <?php if($loginUser->district != NULL){ echo 'disabled';}?> >
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
                            <select id="zone" class="form-control custom-select-value" name="zone" <?php if($loginUser->zone != NULL){ echo 'disabled';} else { echo 'onload="loadZones()"';}?>>
                                <option value="">Select Zone</option>
                                <?php if ( ! empty($zone)) { ?>
                                <option value="<?php echo $zone; ?>" selected><?php echo $zone; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12 district">
                        <div class="form-select-list">
                            <select id="division" class="form-control custom-select-value" name="division" <?php if($loginUser->division != NULL){ echo 'disabled';}?>>
                                <option value="">Select Division</option>
                                <?php if ( ! empty($division)) { ?>
                                <option value="<?php echo $division; ?>" selected><?php echo $division; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12 district">
                        <div class="form-select-list">                                                                                    
                            <select id="sho_area" class="form-control custom-select-value" name="sho_area" <?php if($loginUser->sho_area != NULL){ echo 'disabled';}?>>
                                <option value="">Select SHO Area</option>
                                <?php if ( ! empty($sho_area)) { ?>
                                <option value="<?php echo $sho_area; ?>" selected><?php echo $sho_area; ?></option>
                                <?php } ?>
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