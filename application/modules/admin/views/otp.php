<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Login Safe CheckIn</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/img/favicon.ico">
        <link href="https://fonts.googleapis.com/css?family=Play:400,700" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css?ts=<?= time() ?>">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css?ts=<?= time() ?>">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/animate.css?ts=<?= time() ?>">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/main.css?ts=<?= time() ?>">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/form/all-type-forms.css?ts=<?= time() ?>">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css?ts=<?= time() ?>">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/responsive.css?ts=<?= time() ?>">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/form/all-type-forms.css?ts=<?= time() ?>">
        <script src="<?php echo base_url(); ?>assets/js/vendor/modernizr-2.8.3.min.js"></script>
    </head>
    <body style="background: #94b9de">
        <div class="error-pagewrap">
            <div class="error-page-int">
                <div class="text-center m-b-md custom-login">
                    <div class="sidebar-header" style="text-align: center; margin-left: 0px; margin-top: 2px; margin-bottom: 10px;">
                        <a href="<?php echo base_url('admin/login');?>" class="text-center"><img class="main-logo" src="<?php echo base_url(); ?>assets/img/logo/safecheckin.png" alt="" /></a>
                    </div>
                </div>
                <div class="content-error">
                    <div class="hpanel">
                        <div class="panel-body">
                            <?php if($this->session->flashdata('error')){ echo "<div class='alert alert-danger' role='alert'>" . $this->session->flashdata('error') . "</div>";}; ?>
                            <?php if($this->session->flashdata('success')){ echo "<div class='alert alert-success' role='alert'>" . $this->session->flashdata('success') . "</div>";}; ?>
                            <form action="<?php echo base_url('admin/login/otp/'.base64_encode($user->id)); ?>" id="loginForm" method="post">
                                <div class="form-group">
                                    <label class="control-label" for="phone_number">OTP</label>
                                    <input type="text" data-mask="9999" title="Please enter valid otp" required name="otp" id="otp" class="form-control" autofocus>
                                    <?php echo (form_error('otp') != '') ? "<div class='alert alert-danger' role='alert'>" . form_error('otp') . "</div>" : NULL;?>
                                </div>
                                <button type="submit" name="submit" value="validateOTP" class="btn btn-success btn-block loginbtn">Validate OTP</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>   
        </div>
        <script src="<?php echo base_url(); ?>assets/js/vendor/jquery-1.12.4.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/input-mask/jasny-bootstrap.min.js"></script>
    </body>
</html>