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
                                <li><span class="bread-blod">Edit Mobile Admin</span>
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
                                            <form action="<?php echo base_url('superadmin/mobileadmin/edit/'.base64_encode($user->id));?>" method="post">
                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                            <label class="login2 pull-right pull-right-pro">Name</label>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <input type="text" name="name" class="form-control" placeholder="Name" value="<?php echo $user->name ? $user->name : '';?>"/>
                                                            <?php echo (form_error('name') != '') ? "<div class='alert alert-danger' role='alert'>" . form_error('name') . "</div>" : NULL;?>
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
                                                
                                                <div class="form-group-inner">
                                                    <div class="login-btn-inner">
                                                        <div class="row">
                                                            <div class="col-lg-4"></div>
                                                            <div class="col-lg-8 btn-user">
                                                            <div class="row">
                                                                <div class="login-horizental cancel-wp pull-left form-bc-ele">
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <a href="<?php echo base_url('superadmin/mobileadmin');?>" class="btn btn-white btn-sm btn-primary login-submit-cs cancle-btn">Cancel</a>
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
</div>
    <!-- Static Table End -->
    <?php $this->load->view('includes/footer'); ?>
