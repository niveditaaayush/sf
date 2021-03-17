<?php $this->load->view('includes/header'); ?>
<style>
    .users a.nav-item {
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
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <ul class="breadcome-menu">
                                <li><a href="#">Safe CheckIn</a> <span class="bread-slash">></span>
                                </li>
                                <li><span class="bread-blod">Mobile Admin</span>
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
                        <div class="main-sparkline13-hd">
                            <div class="row">
                                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                    <h1 class="reportaccommo">Mobile Admins</h1>
                                </div>
                                <div class="col-md-3 pull-right">
                                    <a class="addUser btn btn-sm btn-primary login-submit-cs" style="top:22px; position: relative;z-index: 1;" href="<?php echo base_url('superadmin/mobileadmin/add');?>">Add Mobile Admin</a>
                                </div>  
                            </div>
                        </div> 
                        <div class="sparkline13-graph">
                            <table id='table' class='display dataTable'>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User&nbsp;Name</th>
                                        
                                        <th>Phone&nbsp;Number</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(sizeof($admins) > 0){
                                    $i=1;
                                    foreach($admins as $admin){?>
                                    <tr>
                                        <td><?php echo $i++;?></td>
                                        <td><?php echo $admin->name;?></td>
                                        
                                        <td><?php echo maskPhoneNumber($admin->phoneNumber);?></td>
                                        <td><a href="<?php echo base_url('superadmin/mobileadmin/status/'.base64_encode($admin->id).'/'.$admin->Status);?>"><?php echo ($admin->Status == 1) ? 'Active' : 'Inactive';?></a></td>
                                        <td>
                                            
                                            <a href="<?php echo base_url('superadmin/mobileadmin/edit/'.base64_encode($admin->id));?>" class="btn btn-primary user-edit-icon"><i class="fa fa-pencil"></i></a>
                                            <a href="<?php echo base_url('superadmin/mobileadmin/remove/'.base64_encode($admin->id));?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php }
                                }?>
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
            var userDataTable = $('#table').DataTable({});
            $('#searchName').keyup(function () {
                userDataTable.draw();
            });
        });
    </script>
