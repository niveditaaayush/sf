<?php $this->load->view('includes/header'); ?>
<style type="text/css">
    .sidebarsuspects{background: #DCF6F9;border-left: 5px solid #4BC7E9;color: #000;}
</style>
<div class="breadcome-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcome-list single-page-breadcome">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="breadcome-heading">
                                <ul class="breadcome-menu">
                                    <li><a href="<?php echo base_url('superadmin/dashboard');?>">Safe CheckIn</a> <span class="bread-slash">></span>
                                    </li>
                                    <li><span class="bread-blod">Suspects</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="modal-area-button addsuspect">
                                <a id="add_suspect" class="Primary mg-b-10" href="#" data-toggle="modal" data-target="#add-suspect">Add Suspect <span>+</span></a>
                            </div>
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
                            <h1 class="reportaccommo">All<span class="table-project-n"> Suspects</span> info</h1>
                        </div>
                    </div>
                    <div class="sparkline13-graph">
                        <table id='suspectInfo' class='display dataTable'>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Suspect Name</th>
                                    <th>ID Proof Type</th>
                                    <th>ID Number</th>
                                    <th>Vehicle Number</th>
                                    <th>Photo</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(@sizeof($suspects) > 0){
                                    foreach ($suspects as $value) {?>
                                <tr>
                                    <td><?php echo $value->id;?></td>
                                    <td class="result-name"><?php echo $value->name;?></td>
                                    <td class="result-id-proof-type"><?php echo $value->idProofType;?></td>
                                    <td class="result-id-number"><?php echo $value->idNumber;?></td>
                                    <td class="result-vehicle-number"><?php echo $value->vehicleNumber;?></td>
                                    <td><?php echo $value->photo;?></td>
                                    <td>
                                        <a class="btn btn-primary user-edit-icon" data-id="<?php echo base64_encode($value->id);?>" data-toggle="modal" data-target="#add-suspect" href="#"><i class="fa fa-pencil"></i></a>
                                        <a class="btn btn-danger actions delete" href="<?php echo base_url('superadmin/suspects/delete/'. base64_encode($value->id));?>"><i class="fa fa-trash"></i></a>
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
        <div id="add-suspect" class="modal modal-edu-general default-popup-PrimaryModal fade" role="dialog">
            <div class="modal-dialog modelsuspects">
                <div class="modal-content">
                    <div class="modal-header header-color-modal bg-color-1">
                        <img src="<?php echo base_url(); ?>assets/img/logo/addsuspect.svg" alt="reports" />
                        <h5 class="modal-title addsuspect">Add Suspect</h5>
                        <div class="modal-close-area modal-close-df">
                            <a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
                        </div>
                    </div>
                    <div class="modal-body ">
                        <form id="addSuspect" action="" enctype="multipart/form-data" class="suspect" method="post">
                            <div class="form-group-inner">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <input type="text" id="name" class="form-control" name="name" placeholder="Name" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-inner">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-select-list">
                                            <select id="id_proof_type" class="form-control custom-select-value" name="id_proof_type">
                                                <option value="">Select Identity Proof</option>
                                                <option value="Aadhar">Aadhar</option>
                                                <option value="Passport">Passport</option>
                                                <option value="Driving License">Driving License</option>
                                                <option value="Voter ID">Voter ID</option>
                                                <option value="Government ID">Government ID</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-inner">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <input type="text" id="id_number" class="form-control" name="id_number" placeholder="Id Number" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-inner">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <input type="text" id="vehicle_number" class="form-control" name="vehicle_number" placeholder="Vehicle Number" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-inner">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <input type="file" class="form-control" name="userfile" />
                                    </div>
                                </div>
                            </div>
                            <div class="login-btn-inner">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="modal-footer">
                                            <a data-dismiss="modal" href="#">Cancel</a>
                                            <button class="btn login-submit-cs" type="submit" name="submit" value="addSuspect">Add</button>
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
<!-- Static Table End -->
<?php $this->load->view('includes/footer'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#suspectInfo').DataTable({
            "ordering": false,
            "bStateSave": true
        });
        $('#searchName').keyup(function () {
            userDataTable.draw();
        });
        
        $('#add_suspect').on('click', function(){
            var url = '<?php echo base_url('superadmin/suspects'); ?>';
            $('#add-suspect').find('form#addSuspect').attr('action', url);
        });
        $('.user-edit-icon').on('click', function(){
            var parent = $(this).parent().parent();
            var id = $(this).attr('data-id');
            var name = parent.find('.result-name').text();
            var idProofType = parent.find('.result-id-proof-type').text();
            var idNumber = parent.find('.result-id-number').text();
            var vehicleNumber = parent.find('.result-vehicle-number').text();
            var url = '<?php echo base_url('superadmin/suspects/update/');?>';
            $('#add-suspect').find('form#addSuspect').attr('action', url+id);
            $('#add-suspect').find('#name').val(name);
            $('#add-suspect').find('select[name^="id_proof_type"] option[value="'+idProofType+'"]').attr("selected","selected");
            $('#add-suspect').find('#id_number').val(idNumber);
            $('#add-suspect').find('#vehicle_number').val(vehicleNumber);
            $('#add-suspect').find('button[name=submit]').val('updateSuspect');
            $('#add-suspect').find('button[name=submit]').text('update');
        });
    });
</script>


