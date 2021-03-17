<?php $this->load->view('includes/header');

if (! empty($accommodation->photo) && file_get_contents(ACCOMMODATIONS_IMAGES_PATH . $accommodation->photo)) {
    $file_path = ACCOMMODATIONS_IMAGES_PATH . $accommodation->photo;
} else {
    $file_path = ASSETS_PATH.'img/hotel-default-img.jpg';
}
?>
<style>
    .sidebaraccommodation, .sidebarvisitors a.sidebarmenuvisitors {background: #DCF6F9;border-left: 5px solid #4BC7E9;color: #000;}
     ul.breadcome-menu {
    margin-bottom: -17px;
}
</style>
<link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>css/form/all-type-forms.css">
<div class="breadcome-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcome-list single-page-breadcome">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                            <ul class="breadcome-menu">
                                <li>
                                    <a href="<?php echo base_url('admin');?>">Safe CheckIn</a> <span class="bread-slash">></span>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('admin/accommodations');?>">Accommodations</a> <span class="bread-slash">></span>
                                </li>
                                <li>
                                    <span class="bread-blod">View Accommodation</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 pull-right">
                            <a class="backUser btn btn-sm btn-primary login-submit-cs" style="position: absolute;top: 5px;right: 90px;" href="<?php echo base_url('admin/accommodations/edit/'.base64_encode($accommodation->id));?>">Edit</a>
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
                                        <td><?php echo $accommodation->id;?></td>
                                    </tr>
                                    <tr>
                                        <td>Type</td>
                                        <td><?php echo $accommodation->type;?></td>
                                    </tr>
                                    <tr>
                                        <td>Name</td>
                                        <td><?php echo $accommodation->name;?></td>
                                    </tr>
                                    <tr>
                                        <td>Address</td>
                                        <td><?php echo $accommodation->address;?></td>
                                    </tr>
                                    <tr>
                                        <td>Pincode</td>
                                        <td><?php echo $accommodation->pincode;?></td>
                                    </tr>
                                    <tr>
                                        <td>Phone Number</td>
                                        <td><?php echo $accommodation->phoneNumber;?></td>
                                    </tr>
                                    <tr>
                                        <th>Email&nbsp;ID</th>
                                        <td><?php echo $accommodation->email;?></td> 
                                    </tr>
                                    <tr>
                                        <td>Photo</td>
                                      
                                       <td><a data-toggle="modal" data-target="#accommodationPhoto" href="# "><img style="width:50px; height:50px;" src="<?php echo $file_path;?>"></a></td>
                                        <!--<td><?php echo $accommodation->photo;?></td>-->
                                    </tr>
                                    <tr>
                                        <th>No Of Rooms</th>
                                        <td><?php echo $accommodation->noOfRooms;?></td>
                                    </tr>
                                    
                                    <tr>
                                       <th>Available Hardware</th>
                                        <td><?php echo $accommodation->availableHardware;?></td>
                                    </tr>
                                    <tr>
                                       <th>Registration Date</th>
                                        <td><?php echo $accommodation->registrationDate;?></td>
                                    </tr>
                                    <tr>
                                       <th>Grad</th>
                                        <td><?php echo $accommodation->grade;?></td>
                                    </tr>
                                    <tr>
                                       <th>City</th>
                                        <td><?php echo $accommodation->city;?></td>
                                    </tr>
                                    <tr>
                                       <th>State</th>
                                        <td><?php echo $accommodation->state;?></td>
                                    </tr>
                                    <tr>
                                       <th>Country</th>
                                        <td><?php echo $accommodation->country;?></td>
                                    </tr>
                                    <tr>
                                       <th>Zone</th>
                                        <td><?php echo $accommodation->zone;?></td>
                                    </tr>
                                     <tr>
                                       <th>SHO Area</th>
                                        <td><?php echo $accommodation->SHOArea;?></td>
                                    </tr>
                                     <tr>
                                       <th>Circle</th>
                                        <td><?php echo $accommodation->circle;?></td>
                                    </tr>
                                     <tr>
                                       <th>Owner Name</th>
                                        <td><?php echo $accommodation->ownerName;?></td>
                                    </tr>
                                     <tr>
                                       <th>Owner Phone Number</th>
                                        <td><?php echo $accommodation->ownerPhoneNumber;?></td>
                                    </tr>
                                    <tr>
                                       <th>Owner Email</th>
                                        <td><?php echo $accommodation->ownerEmail;?></td>
                                    </tr>
                                     <tr>
                                       <th>Owner Aadhar Number</th>
                                        <td><?php echo $accommodation->ownerAadharNumber;?></td>
                                    </tr>
                                    <tr>
                                       <th>Owner Address</th>
                                        <td><?php echo $accommodation->ownerAddress;?></td>
                                    </tr>
                                     <tr>
                                        <th>Status</th>
                                        <td><?php echo ($accommodation->status == 1) ? 'Active' : 'Inactive';?></td>
                                    </tr>
                                </tbody> 
                            </table>
                            <!--model-->
                             <div id="accommodationPhoto" class="modal modal-edu-general default-popup-PrimaryModal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header1 header-color-modal1 bg-color-11">
                                       
                                        <div class="modal-close-area modal-close-df">
                                            <a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
                                        </div>
                                    </div>
                                    <div class="modal-body "> 
                                        <img style="width:auto; height:auto; object-fit: contain" src="<?php echo $file_path;?>">
                                    </div>

                                </div>
                            </div>
                        </div> 
                            <!--model-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Static Table End -->
    <?php $this->load->view('includes/footer'); ?>
