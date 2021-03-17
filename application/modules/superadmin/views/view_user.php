<?php $this->load->view('includes/header'); ?>

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
                                <li><span class="bread-blod">View User</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 pull-right">
                        <a class="backUser btn btn-sm btn-primary login-submit-cs" style="position: absolute;top: 5px;right: 17px;" href="javascript:window.history.go(-1);">Back</a>
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
                            <table id='table' class='display dataTable no-footer viewUser'>
                                <tbody>
                                    <tr>
                                        <td>ID</td>
                                        <td><?php echo $user->id;?></td>
                                    </tr>
                                    <tr>
                                        <th>User&nbsp;Name</th>
                                        <td><?php echo $user->userName;?></td>
                                    </tr>
                                    <tr>
                                        <th>Email&nbsp;ID</th>
                                        <td><?php echo $user->email;?></td> 
                                    </tr>
                                    <tr>
                                       <th>Phone&nbsp;Number</th>
                                        <td><?php echo $user->phoneNumber;?></td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td><?php echo ($user->status == 1) ? 'Active' : 'Inactive';?></td>
                                    </tr>
                                </tbody> 
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Static Table End -->
    <?php $this->load->view('includes/footer'); ?>
