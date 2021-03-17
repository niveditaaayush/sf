<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Safe CheckIn</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/img/logosn.ico">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css?ts=<?= time() ?>">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css?ts=<?= time() ?>">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/animate.css?ts=<?= time() ?>">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/meanmenu.min.css?ts=<?= time() ?>">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/main.css?ts=<?= time() ?>">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/metisMenu/metisMenu.min.css?ts=<?= time() ?>">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/metisMenu/metisMenu-vertical.css?ts=<?= time() ?>">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css?ts=<?= time() ?>">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/responsive.css?ts=<?= time() ?>">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/scrollbar/jquery.mCustomScrollbar.min.css?ts=<?= time() ?>">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/modals.css?ts=<?= time() ?>">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/notifications/lobibox.min.css?ts=<?= time() ?>">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/notifications/notifications.css?ts=<?= time() ?>">
        <link rel='stylesheet' href='<?php echo base_url(); ?>assets/css/buttons.dataTables.min.css?ts=<?= time() ?>'>
        <link href='<?php echo base_url(); ?>assets/css/jquery.dataTables.min.css?ts=<?= time() ?>' rel='stylesheet' type='text/css'>
        <script src="<?php echo base_url(); ?>assets/js/vendor/jquery-1.12.4.min.js"></script>
    </head>
    <body>
        <!-- Start Header menu area -->
        <div class="left-sidebar-pro">
            <nav id="sidebar" class="">
                <div class="sidebar-header">
                    <a href="<?php echo base_url('admin/dashboard'); ?>"><img class="main-logo" src="<?php echo base_url(); ?>assets/img/logo/safecheckin.png" alt="" /></a>
                    <strong><a href="<?php echo base_url('admin/dashboard'); ?>"><img src="<?php echo base_url(); ?>assets/img/logo/logosn.png" alt="" /></a></strong>
                </div>
                <div class="left-custom-menu-adp-wrap comment-scrollbar">
                    <nav class="sidebar-nav left-sidebar-menu-pro">
                        <ul class="metismenu" id="menu11">
                            <li class="sidebardashboard">
                                <a title="Dashboard" href="<?php echo base_url('admin/dashboard'); ?>"><span class="dashboardicon"><img src="<?php echo base_url(); ?>assets/img/logo/dashboardicon.svg" alt="dashboard" /></span>&nbsp;&nbsp;&nbsp;<span class="mini-sub-pro">Dashboard</span></a>
                            </li>
                            <li class="sidebarvisitors">
                                <a class="sidebarmenuvisitors" href="<?php echo base_url('admin/checkins'); ?>"><span class="dashboardicon"><img src="<?php echo base_url(); ?>assets/img/logo/ReportsIcon.svg" alt="reports" /></span>&nbsp;&nbsp;&nbsp; <span class="mini-click-non">Reports</span></a>
                                <ul class="submenu-angle">
                                    <li class="submenureports"><a title="reports" href="<?php echo base_url('admin/checkins'); ?>" aria-expanded="false"> <span class="mini-click-non">Checkins </span></a></li>
                                    <li class="sidebaraccommodation"><a title="accommodation" href="<?php echo base_url('admin/accommodations'); ?>" aria-expanded="false"> <span class="mini-click-non">Accommodations</span></a></li>
                                </ul>
                            </li>
                            <li class="sidebarsuspects">
                                <a  href="<?php echo base_url('admin/suspects'); ?>" aria-expanded="false"><span class="dashboardicon"><img src="<?php echo base_url(); ?>assets/img/logo/SuspectsIcon.svg" alt="Suspects" /></span>&nbsp;&nbsp;&nbsp; <span class="mini-click-non">Suspects</span></a>
                            </li>   
                            <li class="sidebarupdates">
                                <a  href="#" aria-expanded="false"><span class="dashboardicon"><img src="<?php echo base_url(); ?>assets/img/logo/UpdatesIcon.svg" alt="Updates" /></span>&nbsp;&nbsp;&nbsp; <span class="mini-click-non">Updates</span></a>
                            </li>            
                        </ul>
                    </nav>
                </div>
            </nav>
        </div>
        <!-- End Header menu area -->
        <!-- Start Welcome area -->
        <div class="all-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="logo-pro">
                            <a href="index.php"><img class="main-logo" src="<?php echo base_url(); ?>assets/img/logo/safecheckin.png" alt="" /></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-advance-area">
                <div class="header-top-area">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="header-top-wraper">
                                    <div class="row">
                                        <div class="col-lg-1 col-md-0 col-sm-1 col-xs-12">
                                            <div class="menu-switcher-pro">
                                                <button type="button" id="sidebarCollapse" class="btn bar-button-pro header-drl-controller-btn btn-info navbar-btn"><i class="educate-icon educate-nav"></i></button>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-7 col-sm-6 col-xs-12">

                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="header-right-info">
                                                <ul class="nav navbar-nav mai-top-nav header-right-menu">
                                                    <li class="nav-item tspolice">
                                                        <!-- <img src="<?php echo base_url(); ?>assets/img/logo/tsPolice.png" alt="" /> -->
                                                        <span class="admin-name">POLICE DASHBOARD</span>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle">
                                                            <img title="<?php echo decode($this->session_data['name']) ?>" src="<?php echo base_url(); ?>assets/img/logo/tsPolice.png" alt="" />
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class ="logout-btn" href="<?php echo base_url('admin/login/logout'); ?>"><span class="edu-icon edu-locked author-log-ic"></span>Log Out</a>
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
                <!-- Mobile Menu start -->
                <div class="mobile-menu-area">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="mobile-menu">
                                    <nav id="dropdown">
                                        <ul class="mobile-menu-nav">
                                            <li><a href="<?php echo base_url('admin/dashboard'); ?>">Dashboard</a></li>
                                            <li><a data-toggle="collapse1" data-target="" href="#">Reports <span class="admin-project-icon edu-icon edu-down-arrow"></span></a>
                                                <ul class="collapse1 dropdown-header-top">
                                                    <li><a href="<?php echo base_url('admin/checkins'); ?>">Checkins</a></li>
                                                    <li><a href="<?php echo base_url('admin/accommodations'); ?>">Accommodation</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="<?php echo base_url('admin/suspects'); ?>">Suspects</a></li>
                                            <li><a href="<?php echo base_url('admin/updates'); ?>">Updates</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Mobile Menu end -->