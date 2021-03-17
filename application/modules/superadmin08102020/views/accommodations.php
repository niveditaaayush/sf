<?php $this->load->view('includes/header');
$get_params = NULL;
if(is_array($this->input->get()) && ! empty($this->input->get())){
    $get_params = base64_encode(json_encode($this->input->get()));
}
if($type == 'active'){
    $endPoint = 'activeExport';
}elseif($type == 'inactive'){
    $endPoint = 'inactiveExport';
} else {
    $endPoint = 'allExport';
}
?>
<style>

    .pull-right.search {
        position: relative;
        top: -45px;
        margin-bottom: 45px;

    }
    div#table_filter {
        display: none;
    }
    .bs-bars.pull-left {
        display: none;
    }
    div#table_info {
        display: none;
    }
    .pull-left.pagination-detail {
        position: absolute;
        top: -52px;
        right: 0;
        margin-top: -30px;

    }
    div#table_paginate {
        display: none;
    }
    div.dt-buttons {
        position: absolute;
        top: -40px;
        right: 0;
    }
    .accommodations a {
        padding: 2px 10px;
        border: 1px solid #4BC7E9;
        border-radius: 23px;
        background: #4BC7E9;
        font-size: 12px;
        color: #fff;
    }
    .visitorreport a {
        float: none;
        padding: 2px 10px;
        border: 1px solid #4BC7E9;
        border-radius: 23px;
        font-size: 12px;
    }
    .viewlocation a {
        float: none;
        padding: 2px 10px;
        border: 1px solid #4BC7E9;
        border-radius: 23px;
        font-size: 12px !important;
        color: #4BC7E9 !important;
    }
    .sidebaraccommodation, .sidebarvisitors a.sidebarmenuvisitors {background: #DCF6F9;border-left: 5px solid #4BC7E9;color: #000;}
</style>
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
                                <li><span class="bread-blod">Accommodation Reports</span>
                                </li>
                            </ul>

                        </div>
                        <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                            <?php $this->load->view('data_filters'); ?>
                        </div>
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
                                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                    <h1 class="reportaccommo">Accommodations <span class="table-project-n">Reports</span></h1>
                                </div>
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right">
                                    <a class="btn btn-sm btn-primary full-checkins" href="<?php echo base_url('superadmin/accommodations/'.$endPoint);?>">export</a>
                                </div>
                            </div>
                        </div> 
                        <div class="sparkline13-graph">
                            <div class="text-right col-lg-10 col-md-10 col-sm-10 col-xs-12" style="margin-bottom: -24px;">
                                <select id="accommodations_types">
                                    <option value="">Select Type</option>
                                    <?php if (accommodation_types() > 0) {
                                        foreach (accommodation_types() as $value) {
                                            ?>
                                            <option value="<?php echo $value->type; ?>"><?php echo $value->type; ?></option>
                                        <?php }
                                    }
                                    ?>
                                </select>
                            </div>
                            <table id='accommodationsReport' class='display dataTable table-responsive'>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Owner&nbsp;Name</th>
                                        <th>Live&nbsp;CheckIn</th>
                                        <th>Zone</th>
                                        <th>PS</th>
                                        <th>Contact</th>
                                        <th>Address</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if (@sizeof($accommodations) > 0) {
                                    foreach ($accommodations as $accommodation) {
                                        ?>
                                            <tr>
                                                <td><?php echo $accommodation->id; ?></td>
                                                <td><a href="<?php echo base_url('superadmin/accommodations/profile/' . base64_encode($accommodation->id)); ?>" class=""><?php echo $accommodation->name; ?></a></td>
                                                <td><?php echo $accommodation->type; ?></td>
                                                <td><?php echo $accommodation->ownerName; ?></td>
                                                <td><?php echo $accommodation->liveCheck; ?></td>
                                                <td><?php echo $accommodation->zone; ?></td>
                                                <td><?php echo $accommodation->SHOArea; ?></td>
                                                <td><?php echo maskPhoneNumber($accommodation->phoneNumber); ?></td>
                                                <td><?php echo $accommodation->address; ?></td>
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
    <!-- Static Table End -->
<?php $this->load->view('includes/footer'); ?>

    <script type="text/javascript">
        $(document).ready(function () {
            var userDataTable = $('#accommodationsReport').DataTable({
//                'processing': true,
//                'serverSide': true,
//                'serverMethod': 'post',

                //'searching': false, // Remove default Search Control
//                'ajax': {
//                    'url': '<?php base_url(); ?>accommodations/accommodationReport',
//                    'data': function (data) {
//                        data.searchName = $('#searchName').val();
//                    }
//                },
//                "lengthMenu": [[10, 25, 50, 75, -1], [10, 25, 50, 75, "All"]],
//                'columns': [
//                    {data: 'id'},
//                    {data: 'name'},
//                    {data: 'ownerName'},
//                    {data: 'liveCheck'},
//                    {data: 'zone'},
//                    {data: 'SHOArea'},
//                    {data: 'phoneNumber'},
//                    {data: 'address'}
//                ]
            });
            $('#accommodations_types').on('change', function () {
                userDataTable.columns(2).search(this.value).draw();
            });
            $('#searchName').keyup(function () {
                userDataTable.draw();
            });
        });
    </script>
