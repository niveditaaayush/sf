<?php $this->load->view('includes/header'); ?>
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
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <ul class="breadcome-menu">
                                <li>
                                    <a href="<?php echo base_url('admin/dashboard'); ?>">Safe CheckIn</a> <span class="bread-slash">></span>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('admin/checkins'); ?>"> Checkins </a><span class="bread-slash">></span>
                                </li>
                                <li>
                                    <span class="bread-blod">Past Checkins Reports</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 pull-right">
                            <a class="backUser btn btn-sm btn-primary login-submit-cs" style="position: absolute;top: 5px;right: 17px;" href="javascript:window.history.go(-1);">Back</a>
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
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <h1><span class="table-project-n">Past Checkin Reports </span></h1>
                                </div>
                            </div>
                        </div>
                        <div class="sparkline13-graph">                               
                            <table id='visiterReport' class='display dataTable'>
                                <thead>
                                    <tr>
                                        <th>Guest&nbsp;Name</th>
                                        <th>Accommodation&nbsp;Name</th>
                                        <th>Address</th>
                                        <th>District</th>
                                        <th>CheckIn</th>
                                        <th>CheckOut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (@sizeof($visitors) > 0) {
                                        foreach ($visitors as $visitor) {
                                            ?>
                                            <tr>
                                                <td><?php echo $visitor->guestName; ?></td>
                                                <td><?php echo $visitor->name; ?></td>
                                                <td><?php echo $visitor->address; ?></td>
                                                <td><?php echo $visitor->city; ?></td>
                                                <td style="width:98px;"><?php echo date("d-m-Y", strtotime($visitor->checkIn)); ?><br><?php echo date("h:i A", strtotime($visitor->checkIn)); ?></td>
                                                <td style="width:98px;"><?php echo date("d-m-Y", strtotime($visitor->checkOut)); ?><br><?php echo date("h:i A", strtotime($visitor->checkOut)); ?></td>
                                            </tr>
                                        <?php }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
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

    