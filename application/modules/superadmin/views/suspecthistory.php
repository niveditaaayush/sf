<?php $this->load->view('includes/header'); ?>
            <div class="breadcome-area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="breadcome-list single-page-breadcome">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <ul class="breadcome-menu">
                                            <li><a href="#">safe CheckIn</a> <span class="bread-slash">></span>
                                            </li>
                                            <li><span class="bread-blod">Suspects History</span>
                                            </li>
                                        </ul>
                                        <!-- <div class="breadcome-heading">
                                            <form role="search" class="sr-input-func">
                                                <input type="text" placeholder="Search..." class="search-int form-control">
                                                <a href="#"><i class="fa fa-search"></i></a>
                                            </form>
                                        </div> -->
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        
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
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                            <h1>Suspect <span class="table-project-n">Info </span></h1>
                                            </div>
                                            <!-- <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                <span class="accommodations">
                                                    <a href="reports.php">Visitor Report</a>
                                                </span>&nbsp;<span class="visitorreport">
                                                <a href="accommodation.php">Accommodations Ropert</a>
                                            </span>
                                            
                                        </div> -->
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="basic-login-form-ad">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                    <div class="basic-login-inner inline-basic-form">
                                                        <div class="suspectinfo">
                                                            <div>
                                                                <td> ID </td><td> : S001</td>
</div>
                                                            <div>
                                                                <td> Suspect Name </td><td> : Suspect NAme XYZ</td>
                                                            </div>
                                                            <div>
                                                                <td> Mobile No </td><td>  : 9874562310</td>
                                                            </div>
                                                            <div>
                                                                <td> Suspect image </td><td> : </td>
                                                            </div>
</div>                                                              
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                    <div class="basic-login-inner inline-basic-form">
                                                        <span class="removesuspect">
                                                            <a href="#">Remove&nbsp;Suspect</a>
                                                        </span>                                                   
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 back"><a href="suspects">< Back</a></div>
                                            </div>
                                        </div>
                                    </div>
                            </div>

                            
                            <div class="sparkline13-graph">
                            <table id='suspectHistory' class='display dataTable'>
                                    <thead>
                                        <tr>
                                            <th>Accommodation (20)</th>
                                            <th>Purpose Of Visite</th>
                                            <th>Check In</th>
                                            <th>Check Out</th>
                                            <th>Id Proof</th>
                                            <th>Mobile No</th>
                                        </tr>
                                    </thead>
                                </table>
                                <div class="datatable-dashv1-list custom-datatable-overright">                                   
                                    <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"
                                        data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
                                        <thead>
                                            <tr>
                                                <!-- <th data-field="state" data-checkbox="true"></th> -->
                                                <!-- <th data-field="id">Acco. ID</th> -->
                                                <th data-field="name" >Accommodation (20)</th>
                                                <th data-field="email" data-editable="true">Purpose Of Visite</th>
                                                <!-- <th data-field="phone" data-editable="true">Room No</th> -->
                                                <th data-field="complete">Check In</th>
                                                <th data-field="task" data-editable="true">Check Out</th>
                                                <th data-field="date" style="width: 252px;">Id Proof</th>
                                                 <th data-field="price" >Mobile No</th>
                                                <!--<th data-field="action">Location</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <!-- <td></td> -->
                                                <td>Hotel XYZ <span style="color: #4BC7E9;">Hotel</span></td>
                                                <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</td>
                                                <td>2020-02-10 :12:14:52</td>
                                                <td>2020-02-20 :12:00:62</td>
                                                <td><span class="nav-item tspolice">
                                               <img src="img/logo/tsPolice.png" alt="">
                                               </span><span class="nav-item tspolice">
                                               <img src="img/logo/tsPolice.png" alt="">
                                                </span><span class="nav-item tspolice">
                                                <img src="img/logo/tsPolice.png" alt="">
                                                </span></td>
                                                <td>98745613211</td>
                                            </tr>
                                            <tr>
                                                <!-- <td></td> -->
                                                <td>Hotel XYZ <span style="color: #4BC7E9;">Hotel</span></td>
                                                <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</td>
                                                <td>2020-02-10 :12:14:52</td>
                                                <td>2020-02-20 :12:00:62</td>
                                                <td><span class="nav-item tspolice">
                                               <img src="img/logo/tsPolice.png" alt="">
                                               </span><span class="nav-item tspolice">
                                               <img src="img/logo/tsPolice.png" alt="">
                                                </span><span class="nav-item tspolice">
                                                <img src="img/logo/tsPolice.png" alt="">
                                                </span></td>
                                                <td>98745613211</td>
                                            </tr>
                                            <tr>
                                                <!-- <td></td> -->
                                                <td>Hotel XYZ <span style="color: #4BC7E9;">Hotel</span></td>
                                                <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</td>
                                                <td>2020-02-10 :12:14:52</td>
                                                <td>2020-02-20 :12:00:62</td>
                                                <td><span class="nav-item tspolice">
                                               <img src="<?php echo base_url();?>assets/img/logo/tsPolice.png" alt="">
                                               </span><span class="nav-item tspolice">
                                               <img src="<?php echo base_url();?>assets/img/logo/tsPolice.png" alt="">
                                                </span><span class="nav-item tspolice">
                                                <img src="<?php echo base_url();?>assets/img/logo/tsPolice.png" alt="">
                                                </span></td>
                                                <td>98745613211</td>
                                            </tr>
                                            <tr>
                                                <!-- <td></td> -->
                                                <td>Hotel XYZ <span style="color: #4BC7E9;">Hotel</span></td>
                                                <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</td>
                                                <td>2020-02-10 :12:14:52</td>
                                                <td>2020-02-20 :12:00:62</td>
                                                  <td><span class="nav-item tspolice">
                                               <img src="<?php echo base_url();?>assets/img/logo/tsPolice.png" alt="">
                                               </span><span class="nav-item tspolice">
                                               <img src="<?php echo base_url();?>assets/img/logo/tsPolice.png" alt="">
                                                </span><span class="nav-item tspolice">
                                                <img src="<?php echo base_url();?>assets/img/logo/tsPolice.png" alt="">
                                                </span></td>
                                                <td>98745613211</td>
                                            </tr>
                                            <tr>
                                                <!-- <td></td> -->
                                                <td>Hotel XYZ <span style="color: #4BC7E9;">Hotel</span></td>
                                                <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</td>
                                                <td>2020-02-10 :12:14:52</td>
                                                <td>2020-02-20 :12:00:62</td>
                                                  <td><span class="nav-item tspolice">
                                               <img src="<?php echo base_url();?>assets/img/logo/tsPolice.png" alt="">
                                               </span><span class="nav-item tspolice">
                                               <img src="<?php echo base_url();?>assets/img/logo/tsPolice.png" alt="">
                                                </span><span class="nav-item tspolice">
                                                <img src="<?php echo base_url();?>assets/img/logo/tsPolice.png" alt="">
                                                </span></td>
                                                <td>98745613211</td>
                                            </tr>
                                            <tr>
                                                <!-- <td></td> -->
                                                <td>Hotel XYZ <span style="color: #4BC7E9;">Hotel</span></td>
                                                <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</td>
                                                <td>2020-02-10 :12:14:52</td>
                                                <td>2020-02-20 :12:00:62</td>
                                                  <td><span class="nav-item tspolice">
                                               <img src="<?php echo base_url();?>assets/img/logo/tsPolice.png" alt="">
                                               </span><span class="nav-item tspolice">
                                               <img src="<?php echo base_url();?>assets/img/logo/tsPolice.png" alt="">
                                                </span><span class="nav-item tspolice">
                                                <img src="<?php echo base_url();?>assets/img/logo/tsPolice.png" alt="">
                                                </span></td>
                                                <td>98745613211</td>
                                            </tr>
                                            <tr>
                                                <!-- <td></td> -->
                                                <td>Hotel XYZ <span style="color: #4BC7E9;">Hotel</span></td>
                                                <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</td>
                                                <td>2020-02-10 :12:14:52</td>
                                                <td>2020-02-20 :12:00:62</td>
                                                  <td><span class="nav-item tspolice">
                                               <img src="<?php echo base_url();?>assets/img/logo/tsPolice.png" alt="">
                                               </span><span class="nav-item tspolice">
                                               <img src="<?php echo base_url();?>assets/img/logo/tsPolice.png" alt="">
                                                </span><span class="nav-item tspolice">
                                                <img src="<?php echo base_url();?>assets/img/logo/tsPolice.png" alt="">
                                                </span></td>
                                                <td>98745613211</td>
                                            </tr>
                                            <tr>
                                                <!-- <td></td> -->
                                                <td>Hotel XYZ <span style="color: #4BC7E9;">Hotel</span></td>
                                                <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</td>
                                                <td>2020-02-10 :12:14:52</td>
                                                <td>2020-02-20 :12:00:62</td>
                                                  <td><span class="nav-item tspolice">
                                               <img src="<?php echo base_url();?>assets/img/logo/tsPolice.png" alt="">
                                               </span><span class="nav-item tspolice">
                                               <img src="<?php echo base_url();?>assets/img/logo/tsPolice.png" alt="">
                                                </span><span class="nav-item tspolice">
                                                <img src="<?php echo base_url();?>assets/img/logo/tsPolice.png" alt="">
                                                </span></td>
                                                <td>98745613211</td>
                                            </tr>
                                            <tr>
                                                <!-- <td></td> -->
                                                <td>Hotel XYZ <span style="color: #4BC7E9;">Hotel</span></td>
                                                <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</td>
                                                <td>2020-02-10 :12:14:52</td>
                                                <td>2020-02-20 :12:00:62</td>
                                                  <td><span class="nav-item tspolice">
                                               <img src="<?php echo base_url();?>assets/img/logo/tsPolice.png" alt="">
                                               </span><span class="nav-item tspolice">
                                               <img src="<?php echo base_url();?>assets/img/logo/tsPolice.png" alt="">
                                                </span><span class="nav-item tspolice">
                                                <img src="<?php echo base_url();?>assets/img/logo/tsPolice.png" alt="">
                                                </span></td>
                                                <td>98745613211</td>
                                            </tr>
                                            <tr>
                                                <!-- <td></td> -->
                                                <td>Hotel XYZ <span style="color: #4BC7E9;">Hotel</span></td>
                                                <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</td>
                                                <td>2020-02-10 :12:14:52</td>
                                                <td>2020-02-20 :12:00:62</td>
                                                  <td><span class="nav-item tspolice">
                                               <img src="<?php echo base_url();?>assets/img/logo/tsPolice.png" alt="">
                                               </span><span class="nav-item tspolice">
                                               <img src="<?php echo base_url();?>assets/img/logo/tsPolice.png" alt="">
                                                </span><span class="nav-item tspolice">
                                                <img src="<?php echo base_url();?>assets/img/logo/tsPolice.png" alt="">
                                                </span></td>
                                                <td>98745613211</td>
                                            </tr>
                                            <tr>
                                                <!-- <td></td> -->
                                                <td>Hotel XYZ <span style="color: #4BC7E9;">Hotel</span></td>
                                                <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</td>
                                                <td>2020-02-10 :12:14:52</td>
                                                <td>2020-02-20 :12:00:62</td>
                                                  <td><span class="nav-item tspolice">
                                               <img src="<?php echo base_url();?>assets/img/logo/tsPolice.png" alt="">
                                               </span><span class="nav-item tspolice">
                                               <img src="<?php echo base_url();?>assets/img/logo/tsPolice.png" alt="">
                                                </span><span class="nav-item tspolice">
                                                <img src="<?php echo base_url();?>assets/img/logo/tsPolice.png" alt="">
                                                </span></td>
                                                <td>98745613211</td>
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

         <script type="text/javascript">
	$(document).ready(function(){
	   	var userDataTable = $('#suspectHistory').DataTable({
	      	'processing': true,
	      	'serverSide': true,
	      	'serverMethod': 'post',
               
	      	//'searching': false, // Remove default Search Control
	      	'ajax': {
	          'url':'<?php base_url();?>suspects/suspectInfo',
	          'data': function(data){
                        data.searchName = $('#searchName').val();	
	          }
	      	},
            "lengthMenu": [[10, 25, 50, 75, -1], [10, 25, 50, 75, "All"]],
	      	'columns': [
                { data: 'suspectId' },
	         	{ data: 'suspectsName' },
	         	{ data: 'mobileNo' },
	         	{ data: 'idProof' },
                 //adds td row for button
                { data: null,
                    render: function ( data, type, row ) {
                        return '<span class="view-details"><a href="suspects/suspectHistory">View History</a></span>';                
                    }
                }        
            ]
	   	});

	   	
	  $('#searchName').keyup(function(){
	   		userDataTable.draw();
	   	});
	});
    </script>
    <style>
.datepick {
    margin-top: 10px;
}
.pull-right.search {
    position: relative;
    top: -45px;
    margin-bottom: 45px;
    display: none;
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
    display: none;
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
.suspectinfo div {
    margin: 10px -15px;
}
    </style>
