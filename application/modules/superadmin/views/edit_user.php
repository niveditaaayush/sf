<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    $this->load->view('includes/header');
?>
<style type="text/css">
    .users a.nav-item {
        background: #DCF6F9;
        border-left: 5px solid #4BC7E9;
        color: #000;
    }
</style>
<link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>css/form/all-type-forms.css">
<div class="breadcome-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcome-list single-page-breadcome">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <ul class="breadcome-menu">
                                <li><a href="#">Safe CheckIn</a> <span class="bread-slash">></span>
                                </li>
                                <li><span class="bread-blod">Edit User</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Static Table Start -->
<div class="data-table-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list">
                    <div class="sparkline13-hd">
                        <div class="sparkline13-graph">
                            <div class="basic-login-form-ad">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="all-form-element-inner">
                                            <form action="<?php echo base_url('superadmin/users/edit/'.base64_encode($user->id));?>" method="post">
                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label class="login2 pull-right pull-right-pro">User Name</label>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <input type="text" name="user_name" class="form-control" placeholder="User Name" value="<?php echo $user->userName ? $user->userName : '';?>"/>
                                                            <?php echo (form_error('user_name') != '') ? "<div class='alert alert-danger' role='alert'>" . form_error('user_name') . "</div>" : NULL;?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label class="login2 pull-right pull-right-pro">Email ID</label>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <input type="text" name="email" class="form-control" placeholder="Email ID" value="<?php echo $user->email ? $user->email : '';?>"/>
                                                            <?php echo (form_error('email') != '') ? "<div class='alert alert-danger' role='alert'>" . form_error('email') . "</div>" : NULL;?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label class="login2 pull-right pull-right-pro">Phone Number</label>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <input type="text" name="phone_number" class="form-control" placeholder="Phone Number" value="<?php echo $user->phoneNumber ? $user->phoneNumber : '';?>"/>
                                                            <?php echo (form_error('phone_number') != '') ? "<div class='alert alert-danger' role='alert'>" . form_error('phone_number') . "</div>" : NULL;?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label class="login2 pull-right pull-right-pro">District</label>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <div class="form-select-list">
                                                                <select id="district" class="form-control custom-select-value" name="district" value="<?php echo $user->phoneNumber ? $user->phoneNumber : '';?>">
                                                                    <option value="">Select District</option>
                                                                    <?php if(sizeof($cities) > 0){
                                                                        foreach($cities as $city){?>
                                                                      
                                                                    <option value="<?php echo $city->district; ?>" <?php if ($city->district == $user->district) { echo "selected";} ?>><?php echo $city->district; ?></option>
                                                                    <?php }
                                                                    }?>
                                                                </select>
                                                                <?php echo (form_error('district') != '') ? "<div class='alert alert-danger' role='alert'>" . form_error('district') . "</div>" : NULL;?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label class="login2 pull-right pull-right-pro">Zone</label>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <div class="form-select-list">
                                                                <select id="zone" class="form-control custom-select-value" name="zone">
                                                                    <option value="">Select Zone</option>
                                                                    <?php if ( ! empty($user->zone)) { ?>
                                                                    <option value="<?php echo $user->zone; ?>" selected><?php echo $user->zone; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <?php echo (form_error('zone') != '') ? "<div class='alert alert-danger' role='alert'>" . form_error('zone') . "</div>" : NULL;?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label class="login2 pull-right pull-right-pro">Division</label>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <div class="form-select-list">
                                                                <select id="division" class="form-control custom-select-value" name="division">
                                                                    <option value="">Select Division</option>
                                                                    <?php if ( ! empty($user->division)) { ?>
                                                                    <option value="<?php echo $user->division; ?>" selected><?php echo $user->division; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <?php echo (form_error('division') != '') ? "<div class='alert alert-danger' role='alert'>" . form_error('division') . "</div>" : NULL;?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label class="login2 pull-right pull-right-pro">SHO Area</label>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <div class="form-select-list">
                                                                <select id="sho_area" class="form-control custom-select-value" name="sho_area">
                                                                    <option value="">Select SHO Area</option>
                                                                    <?php if ( ! empty($user->sho_area)) { ?>
                                                                    <option value="<?php echo $user->sho_area; ?>" selected><?php echo $user->sho_area; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <?php echo (form_error('sho_area') != '') ? "<div class='alert alert-danger' role='alert'>" . form_error('sho_area') . "</div>" : NULL;?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group-inner">
                                                    <div class="login-btn-inner">
                                                        <div class="row">
                                                            <div class="col-lg-4"></div>
                                                            <div class="col-lg-8 btn-user">
                                                            <div class="row">
                                                                <div class="login-horizental cancel-wp pull-left form-bc-ele">
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <a href="<?php echo base_url('superadmin/users');?>" class="btn btn-white btn-sm btn-primary login-submit-cs cancle-btn">Cancel</a>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <input type="hidden" name="recordId" value="<?php echo base64_encode($user->id); ?>">
                                                                        <button class="btn btn-sm btn-primary login-submit-cs" type="submit" name="submit" value="updateUser">Update</button>
                                                                    </div>
                                                                </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Static Table End -->
    <?php $this->load->view('includes/footer'); ?>
