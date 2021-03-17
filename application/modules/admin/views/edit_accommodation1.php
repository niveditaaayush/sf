<?php $this->load->view('includes/header'); ?>
<style type="text/css">
    .users a.nav-item {
        background: #DCF6F9;
        border-left: 5px solid #4BC7E9;
        color: #000;
    }

/*image gallery*/
.image-checkbox {
	cursor: pointer;
	box-sizing: border-box;
	-moz-box-sizing: border-box;
	-webkit-box-sizing: border-box;
	border: 4px solid transparent;
	margin-bottom: 0;
	outline: 0;
}
.image-checkbox input[type="checkbox"] {
	display: none;
}
.hardware{
  margin-top: 20px;
}
.btn-file input[type=file] {
  position: absolute;
  top: 0;
  right: 0;
  min-width: 100%;
  min-height: 100%;
  font-size: 100px;
  text-align: right;
  filter: alpha(opacity=0);
  opacity: 0;
  background: red;
  cursor: inherit;
  display: block;
}
.photoupload {
    text-align: left;
    border-color: #dddddd;
    padding: 2px 10px;
    font-size: 12px;
    border-radius: 30px;
}
@media(max-width:1050px){
    .col-lg-7.btn-user {
    margin-left: 18px;
}
}
.sidebaraccommodation, .sidebarvisitors a.sidebarmenuvisitors {background: #DCF6F9;border-left: 5px solid #4BC7E9;color: #000;}
</style>
<link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>css/form/all-type-forms.css">
<div class="breadcome-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcome-list single-page-breadcome">
                    <div class="row">
                        <div class="col-lg-4 col-md-5 col-sm-5 col-xs-12">
                            <ul class="breadcome-menu">
                                <li><a href="#">Safe CheckIn</a> <span class="bread-slash">></span>
                                </li>
                                <li><span class="bread-blod">Edit Accommodation</span>
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
                                            <form action="<?php echo base_url('admin/accommodations/edit/' . base64_encode($accommodation->id)); ?>" method="post">
                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2 pull-right pull-right-pro">Category</label>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <input type="text" name="type" class="form-control" placeholder="Category" value="<?php echo $accommodation->type ? $accommodation->type : ''; ?>" readonly />
                                                            <?php echo (form_error('type') != '') ? "<div class='alert alert-danger' role='alert'>" . form_error('type') . "</div>" : NULL; ?>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2 pull-right pull-right-pro">Name</label>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <input type="text" name="name" class="form-control" placeholder="Name" value="<?php echo $accommodation->name ? $accommodation->name : ''; ?>" readonly />
                                                            <?php echo (form_error('name') != '') ? "<div class='alert alert-danger' role='alert'>" . form_error('name') . "</div>" : NULL; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2 pull-right pull-right-pro">Address</label>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <input type="text" name="address" class="form-control" placeholder="Address" value="<?php echo $accommodation->address ? $accommodation->address : ''; ?>"/>
                                                            <?php echo (form_error('address') != '') ? "<div class='alert alert-danger' role='alert'>" . form_error('address') . "</div>" : NULL; ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2 pull-right pull-right-pro">Pincode</label>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <input type="text" name="pincode" class="form-control" placeholder="Pincode" value="<?php echo $accommodation->pincode ? $accommodation->pincode : ''; ?>"/>
                                                            <?php echo (form_error('pincode') != '') ? "<div class='alert alert-danger' role='alert'>" . form_error('pincode') . "</div>" : NULL; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2 pull-right pull-right-pro">Phone Number</label>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <input type="text" name="phoneNumber" class="form-control" placeholder="Phone Number" value="<?php echo $accommodation->phoneNumber ? $accommodation->phoneNumber : ''; ?>"/>
                                                            <?php echo (form_error('phoneNumber') != '') ? "<div class='alert alert-danger' role='alert'>" . form_error('phoneNumber') . "</div>" : NULL; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2 pull-right pull-right-pro">Email ID</label>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <input type="text" name="email" class="form-control" placeholder="Email ID" value="<?php echo $accommodation->email ? $accommodation->email : ''; ?>"/>
                                                            <?php echo (form_error('email') != '') ? "<div class='alert alert-danger' role='alert'>" . form_error('email') . "</div>" : NULL; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2 pull-right pull-right-pro">Photo</label>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <span class="file-input btn btn-block  photoupload btn-file">
                                                                 Photo Browse&hellip; 
                                                                 <input type="file" name="photo" class="form-control" placeholder="Photo">
                                                            </span>
                                                            
                                                            <?php echo (form_error('photo') != '') ? "<div class='alert alert-danger' role='alert'>" . form_error('photo') . "</div>" : NULL; ?>
                                                        </div>
                                                       
                                                    </div>
                                                </div>
                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2 pull-right pull-right-pro">No Of Rooms</label>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <input type="text" name="noOfRooms" class="form-control" placeholder="No Of Rooms" value="<?php echo $accommodation->noOfRooms ? $accommodation->noOfRooms : ''; ?>"/>
                                                            <?php echo (form_error('noOfRooms') != '') ? "<div class='alert alert-danger' role='alert'>" . form_error('noOfRooms') . "</div>" : NULL; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 hardware">
                                                            <label class="login2 pull-right pull-right-pro">Available Hardware</label>
                                                        </div>
                                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                           <div class="row">
                                                               <div class="col-xs-3 col-sm-3 col-md-3 nopad text-center">
                                                      <label class="image-checkbox">
                                                         <img id="Computer-img" class="img-responsive" src="<?php echo base_url(); ?>assets/img/logo/Computera.svg" />
                                                         <input id="Computer" type="checkbox" name="availableHardware[]" value="computer" checked />
                                                    </label>
                                                    </div>
                                                    <div class="col-xs-3 col-sm-3 col-md-3 nopad text-center">
                                                      <label class="image-checkbox">
                                                         <img id="Laptop-img" class="img-responsive" src="<?php echo base_url(); ?>assets/img/logo/Laptopd.svg" />
                                                        <input id="Laptop" type="checkbox" name="availableHardware[]" value="laptop" />
                                                      </label>
                                                    </div>
                                                    <div class="col-xs-3 col-sm-3 col-md-3 nopad text-center">
                                                      <label class="image-checkbox">
                                                         <img id="mobile-img" class="img-responsive" src="<?php echo base_url(); ?>assets/img/logo/mobiled.svg" />
                                                        <input id="mobile" type="checkbox" name="availableHardware[]" value="mobile" />
                                                      </label>
                                                    </div>
                                                    <div class="col-xs-3 col-sm-3 col-md-3 nopad text-center">
                                                      <label class="image-checkbox">
                                                        <img id="tab-img" class="img-responsive" src="<?php echo base_url(); ?>assets/img/logo/tabd.svg" />
                                                        <input id="tab" type="checkbox" name="availableHardware[]" value="tab" />
                                                      </label>
                                                    </div>
                                                           </div>
                                                        </div>
                                                        
<!--                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <input type="text" name="availableHardware" class="form-control" placeholder="Available Hardware" value="<?php echo $accommodation->availableHardware ? $accommodation->availableHardware : ''; ?>"/>
                                                            <?php echo (form_error('availableHardware') != '') ? "<div class='alert alert-danger' role='alert'>" . form_error('availableHardware') . "</div>" : NULL; ?>
                                                        </div>-->
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2 pull-right pull-right-pro">Registration Date</label>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <input type="text" name="registrationDate" class="form-control" placeholder="Registration Date" value="<?php echo $accommodation->registrationDate ? $accommodation->registrationDate : ''; ?>"/>
                                                            <?php echo (form_error('registrationDate') != '') ? "<div class='alert alert-danger' role='alert'>" . form_error('registrationDate') . "</div>" : NULL; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2 pull-right pull-right-pro">Grade</label>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <input type="text" name="grade" class="form-control" placeholder="Grade" value="<?php echo $accommodation->grade ? $accommodation->grade : ''; ?>"/>
                                                            <?php echo (form_error('grade') != '') ? "<div class='alert alert-danger' role='alert'>" . form_error('grade') . "</div>" : NULL; ?>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2 pull-right pull-right-pro">City</label>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <input type="text" name="city" class="form-control" placeholder="City" value="<?php echo $accommodation->city ? $accommodation->city : ''; ?>"/>
                                                            <?php echo (form_error('city') != '') ? "<div class='alert alert-danger' role='alert'>" . form_error('city') . "</div>" : NULL; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2 pull-right pull-right-pro">State</label>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <input type="text" name="state" class="form-control" placeholder="State" value="<?php echo $accommodation->state ? $accommodation->state : ''; ?>"/>
                                                            <?php echo (form_error('state') != '') ? "<div class='alert alert-danger' role='alert'>" . form_error('state') . "</div>" : NULL; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2 pull-right pull-right-pro">Country</label>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <input type="text" name="country" class="form-control" placeholder="Country" value="<?php echo $accommodation->country ? $accommodation->country : ''; ?>"/>
                                                            <?php echo (form_error('country') != '') ? "<div class='alert alert-danger' role='alert'>" . form_error('country') . "</div>" : NULL; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--demo-->
                                                 
                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2 pull-right pull-right-pro">District</label>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <div class="form-select-list">
                                                                <select id="district" class="form-control custom-select-value" name="district" value="<?php echo $accommodation->phoneNumber ? $accommodation->phoneNumber : '';?>">
                                                                    <option value="">Select District</option>
                                                                    <?php if(@sizeof($cities) > 0){
                                                                        foreach($cities as $city){?>
                                                                      
                                                                    <option value="<?php echo $city->district; ?>" <?php if ($city->district == $accommodation->city) { echo "selected";} ?>><?php echo $city->district; ?></option>
                                                                    <?php }
                                                                    }?>
                                                                </select>
                                                                <?php echo (form_error('district') != '') ? "<div class='alert alert-danger' role='alert'>" . form_error('district') . "</div>" : NULL;?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2 pull-right pull-right-pro">Zone</label>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <div class="form-select-list">
                                                                <select id="zone" class="form-control custom-select-value" name="zone">
                                                                    <option value="">Select Zone</option>
                                                                    <?php if ( ! empty($accommodation->zone)) { ?>
                                                                    <option value="<?php echo $accommodation->zone; ?>" selected><?php echo $accommodation->zone; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <?php echo (form_error('zone') != '') ? "<div class='alert alert-danger' role='alert'>" . form_error('zone') . "</div>" : NULL;?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2 pull-right pull-right-pro">Division</label>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <div class="form-select-list">
                                                                <select id="division" class="form-control custom-select-value" name="division">
                                                                    <option value="">Select Division</option>
                                                                    <?php if ( ! empty($accommodation->circle)) { ?>
                                                                    <option value="<?php echo $accommodation->circle; ?>" selected><?php echo $accommodation->circle; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <?php echo (form_error('division') != '') ? "<div class='alert alert-danger' role='alert'>" . form_error('division') . "</div>" : NULL;?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2 pull-right pull-right-pro">SHO Area</label>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <div class="form-select-list">
                                                                <select id="sho_area" class="form-control custom-select-value" name="sho_area">
                                                                    <option value="">Select SHO Area</option>
                                                                    <?php if ( ! empty($accommodation->SHOArea)) { ?>
                                                                    <option value="<?php echo $accommodation->SHOArea; ?>" selected><?php echo $accommodation->SHOArea; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <?php echo (form_error('sho_area') != '') ? "<div class='alert alert-danger' role='alert'>" . form_error('sho_area') . "</div>" : NULL;?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                              
                                                <!--demo-->
                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2 pull-right pull-right-pro">Owner Name</label>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <input type="text" name="ownerName" class="form-control" placeholder="ownerName" value="<?php echo $accommodation->ownerName ? $accommodation->ownerName : ''; ?>"/>
                                                            <?php echo (form_error('ownerName') != '') ? "<div class='alert alert-danger' role='alert'>" . form_error('ownerName') . "</div>" : NULL; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2 pull-right pull-right-pro">Owner Phone Number</label>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <input type="text" name="ownerPhoneNumber" class="form-control" placeholder="Owner Phone Number" value="<?php echo $accommodation->ownerPhoneNumber ? $accommodation->ownerPhoneNumber : ''; ?>"/>
                                                            <?php echo (form_error('ownerPhoneNumber') != '') ? "<div class='alert alert-danger' role='alert'>" . form_error('ownerPhoneNumber') . "</div>" : NULL; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2 pull-right pull-right-pro">Owner Email</label>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <input type="text" name="ownerEmail" class="form-control" placeholder="Owner Email" value="<?php echo $accommodation->ownerEmail ? $accommodation->ownerEmail : ''; ?>"/>
                                                            <?php echo (form_error('ownerEmail') != '') ? "<div class='alert alert-danger' role='alert'>" . form_error('ownerEmail') . "</div>" : NULL; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2 pull-right pull-right-pro">Owner Aadhar Number</label>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <input type="text" name="ownerAadharNumber" class="form-control" placeholder="Owner Aadhar Number" value="<?php echo $accommodation->ownerAadharNumber ? $accommodation->ownerAadharNumber : ''; ?>"/>
                                                            <?php echo (form_error('ownerAadharNumber') != '') ? "<div class='alert alert-danger' role='alert'>" . form_error('ownerAadharNumber') . "</div>" : NULL; ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2 pull-right pull-right-pro">Owner Address</label>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <input type="text" name="ownerAddress" class="form-control" placeholder="Owner Address" value="<?php echo $accommodation->ownerAddress ? $accommodation->ownerAddress : ''; ?>"/>
                                                            <?php echo (form_error('ownerAddress') != '') ? "<div class='alert alert-danger' role='alert'>" . form_error('ownerAddress') . "</div>" : NULL; ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group-inner">
                                                    <div class="login-btn-inner">
                                                        <div class="row">
                                                            <div class="col-lg-5"></div>
                                                            <div class="col-lg-7 btn-user">
                                                                <div class="row">
                                                                    <div class="login-horizental cancel-wp pull-left form-bc-ele">
                                                                        <div class="row">
                                                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                                                <a href="<?php echo base_url('admin/accommodations'); ?>" class="btn btn-white btn-sm btn-primary login-submit-cs cancle-btn">Cancel</a>
                                                                            </div>
                                                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                                                <button class="btn btn-sm btn-primary login-submit-cs" type="submit" name="submit" value="updateUser">Update</button>
                                                                            </div>
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
     
        <!-- Static Table End -->
        <?php $this->load->view('includes/footer'); ?>
        <script>

        $("#Computer").click(function () {
            if ($(this).is(":checked")) {
                $('#Computer-img').attr('src', '<?php echo base_url(); ?>assets/img/logo/Computera.svg');
            } else {
                $('#Computer-img').attr('src', '<?php echo base_url(); ?>assets/img/logo/Computerd.svg');
            }
        });
        $("#Laptop").click(function () {
            if ($(this).is(":checked")) {
                $('#Laptop-img').attr('src', '<?php echo base_url(); ?>assets/img/logo/Laptopa.svg');
            } else {
                $('#Laptop-img').attr('src', '<?php echo base_url(); ?>assets/img/logo/Laptopd.svg');
            }
        });
          $("#mobile").click(function () {
            if ($(this).is(":checked")) {
                $('#mobile-img').attr('src', '<?php echo base_url(); ?>assets/img/logo/mobilea.svg');
            } else {
                $('#mobile-img').attr('src', '<?php echo base_url(); ?>assets/img/logo/mobiled.svg');
            }
        });
        $("#tab").click(function () {
            if ($(this).is(":checked")) {
                $('#tab-img').attr('src', '<?php echo base_url(); ?>assets/img/logo/taba.svg');
            } else {
                $('#tab-img').attr('src', '<?php echo base_url(); ?>assets/img/logo/tabd.svg');
            }
        });
        </script>