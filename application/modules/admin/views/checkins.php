<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$get_params = NULL;
if(is_array($this->input->get()) && ! empty($this->input->get())){
    $get_params = base64_encode(json_encode($this->input->get()));
}
$this->load->view('includes/header'); ?>
<link rel="stylesheet" href="<?php echo ASSETS_PATH;?>css/datapicker/datepicker3.css">
<style type="text/css">
    .submenureports, .sidebarvisitors a.sidebarmenuvisitors {
        background: #DCF6F9;
        border-left: 5px solid #4BC7E9;
        color: #000;
    }
</style>
<div class="breadcome-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcome-list single-page-breadcome">
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                            <ul class="breadcome-menu">
                                <li>
                                    <a href="<?php echo base_url('admin/dashboard'); ?>">Safe CheckIn</a> <span class="bread-slash">></span>
                                </li>
                                <li>
                                    <span class="bread-blod">Reports</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                            <?php $this->load->view('data_filters'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Static Table Start -->
<div class="data-table-area mg-b-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list">
                    <div class="sparkline13-hd">
                        <div class="main-sparkline13-hd">
                            <div class="row">
                                <?php if(isset($checkins_type) && $checkins_type == 'all'){?>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <h1><span class="table-project-n">All Checkin Reports </span></h1>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-right">
                                    <a class="btn btn-sm btn-primary full-checkins" href="<?php echo base_url('admin/checkins');?>">Active Checkins</a>
                                </div>
                                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                    <a class="btn btn-sm btn-primary full-checkins" href="<?php echo base_url('admin/checkins/allExport/'.$get_params);?>">export</a>
                                </div>
                                <?php } else {?>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <h1><span class="table-project-n">Active Checkin Reports </span></h1>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-right">
                                    <a class="btn btn-sm btn-primary full-checkins" href="<?php echo base_url('admin/checkins/all');?>">All Checkins</a>
                                </div>
                                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                    <a class="btn btn-sm btn-primary full-checkins" href="<?php echo base_url('admin/checkins/activeExport/'.$get_params);?>">export</a>
                                </div>
                                <?php }?>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="basic-login-form-ad">
                                    <div class="row fullreport">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="basic-login-inner inline-basic-form">
                                                <form action="<?php echo base_url('admin/checkins/filter'); ?>" method="get">
                                                    <div class="form-group-inner">
                                                        <div class="row datepick">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <div class="form-select-list startdate">
                                                                    <div class="input-group">
                                                                        <span class="fdate">From&nbsp;Date</span>&nbsp;&nbsp;&nbsp;<span class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                                                                        <input type="text" class="form-control date-picker" id="startdate" name="start_date" value="<?php echo $this->input->get('start_date'); ?>" placeholder="From Date" readonly />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <div class="form-select-list startdate">
                                                                    <div class="input-group">
                                                                        <span class="fdate">To&nbsp;Date</span>&nbsp;&nbsp;&nbsp;<span class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                                                                        <input type="text" class="form-control date-picker" id="enddate" name="end_date" value="<?php echo $this->input->get('end_date'); ?>" placeholder="To Date" readonly/>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <div class="login-btn-inner">
                                                                    <div class="row">
                                                                        <div class="col-lg-6 col-md-5 col-sm-5 col-xs-12">
                                                                            <div class="login-horizental lg-hz-mg">
                                                                                <button type="submit" id="filter" class="btn btn-sm btn-primary login-submit-cs">Submit</button>
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
                        <div class="sparkline13-graph accommodationTable">                               
                            <table id='visiterReport' class='display dataTable'>
                                <thead>
                                    <tr>
                                        <th>Accommodation&nbsp;Name</th>
                                        <th>Accommodation&nbsp;Type</th>
                                        <th>Guest&nbsp;Details</th>
                                        <th>CheckIn</th>
                                        <?php if(isset($checkins_type) && $checkins_type == 'all') {?>
                                        <th>CheckOut</th>
                                        <?php }?>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (@sizeof($visitors) > 0) {
                                        foreach ($visitors as $visitor) {
                                            ?>
                                            <tr>
                                                <td><?php echo $visitor->name; ?></td>
                                                <td><?php echo $visitor->type; ?></td>
                                                <td>
                                                    <p><?php echo $visitor->guestName; ?></p>
                                                    <p><?php echo maskPhoneNumber($visitor->phoneNumber); ?></p>
                                                    <p><?php echo $visitor->address; ?></p>
                                                </td>
                                                <td style="width:98px;"><?php echo date("d-m-Y", strtotime($visitor->checkIn)); ?><br><?php echo date("h:i A", strtotime($visitor->checkIn)); ?></td>
                                                <?php if(isset($checkins_type) && $checkins_type == 'all') {?>
                                                <td style="width:98px;"><?php echo $visitor->checkOut ? date("d-m-Y", strtotime($visitor->checkOut)) : NULL; ?><br><?php echo $visitor->checkOut ? date("h:i A", strtotime($visitor->checkOut)) : NULL; ?></td>
                                                <?php }?>
                                                <td class="visitorsImages" style="width:200px;">
                                                    <p class="view-details">
                                                        <a href="<?php echo base_url('admin/checkins/details/'. base64_encode($visitor->primaryId));?>">View Details</a>
                                                    </p>
                                                    <p class="view-details">                                                        
                                                        <a href="<?php echo base_url('admin/checkins/past/'. base64_encode($visitor->primaryId));?>">Past Checkins</a>
                                                    </p>
                                                </td>
                                            </tr>
                                        <?php }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!--model image-->
                        <div id="visitorsImages" class="modal modal-edu-general default-popup-PrimaryModal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header1 header-color-modal1 bg-color-11">

                                        <div class="modal-close-area modal-close-df">
                                            <a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
                                        </div>
                                    </div>
                                    <div class="modal-body"> 
                                        <img src="#" alt="model Image" />
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <!--model image ends-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="<?php echo ASSETS_PATH;?>js/datapicker/bootstrap-datepicker.js" type="c7b5187bba11185d67d58c59-text/javascript"></script>
    <script src="<?php echo ASSETS_PATH;?>js/datapicker/datepicker-active.js" type="c7b5187bba11185d67d58c59-text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('body').on('click', 'td.visitorsImages a', function (){
                var image = $(this).attr('data-value');
                if(image != ''){
                    var imagePath = '<?php echo VIEW_PATH.'visitors/';?>';
                    $('#visitorsImages').find('.modal-body').html('<img src="'+imagePath+image+'" class="responsive">');
                }
            });
            $('#visiterReport').DataTable({
                "ordering": false,
                "bStateSave": true
            });
            $("#startdate").datepicker({
                todayBtn: 1,
                autoclose: true,
                todayHighlight: true,
                format: 'yyyy-mm-dd'
            }).on('changeDate', function (selected) {
                var minDate = new Date(selected.date.valueOf());
                $('#enddate').datepicker('setStartDate', minDate);
            });

            $("#enddate").datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'yyyy-mm-dd'
            }).on('changeDate', function (selected) {
                var maxDate = new Date(selected.date.valueOf());
                $('#startdate').datepicker('setEndDate', maxDate);
            });
        });
    </script>
    <?php
    $this->load->view('includes/footer');

    