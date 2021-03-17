<?php $this->load->view('includes/header'); ?>
   
            <div class="breadcome-area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="breadcome-list single-page-breadcome">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <ul class="breadcome-menu">
                                            <li><a href="#">Safe CheckIn</a> <span class="bread-slash">></span>
                                            </li>
                                            <li><span class="bread-blod">Reports</span>
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
                                            <h1>Visitor <span class="table-project-n">Full Reports </span></h1>
                                            </div>
                                            <!-- <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                <span class="accommodations">
                                                    <a href="reports.php">Visitor Report</a>
                                                </span>&nbsp;<span class="visitorreport">
                                                <a href="accommodation.php">Accommodations Ropert</a>
                                            </span>
                                            
                                        </div> -->
                                </div>
                                <div class="col-lg-10 col-md-12 col-sm-12 col-xs-12">
                                        <div class="basic-login-form-ad">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="basic-login-inner inline-basic-form">
                                                        <form action="#">
                                                            <div class="form-group-inner">
                                                                <div class="row datepick">
                                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                        <div class="form-select-list startdate">
                                                                            <div class="input-group">
                                                                            <span class="fdate">From&nbsp;Date</span>&nbsp;&nbsp;&nbsp;<span class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                                                                                <input type="text" placeholder="From Date" name="startdate" class="form-control date-picker" id="startdate" />
                                                                            </div>
                                                                          
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                        <div class="form-select-list startdate">
                                                                            <div class="input-group">
                                                                            <span class="fdate">To&nbsp;Date</span>&nbsp;&nbsp;&nbsp;<span class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                                                                                <input type="text" placeholder="To Date" name="enddate" aria-describedby="basic-addon1" class="form-control date-picker" id="enddate" />
                                                                            </div>
                                                                           
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                                                        <div class="login-btn-inner">
                                                                            <div class="row">
                                                                              
                                                                                <div class="col-lg-6 col-md-5 col-sm-5 col-xs-12">
                                                                                    <div class="login-horizental lg-hz-mg"><button name="filter" id="filter" class="btn btn-sm btn-primary login-submit-cs" type="submit">Generate Report</button></div>
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

                            
                            <div class="sparkline13-graph">
                                <div class="datatable-dashv1-list custom-datatable-overright">
                                  
                                   
                                    <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"
                                        data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
                                        <thead>
                                            <tr>
                                                <!-- <th data-field="state" data-checkbox="true"></th> -->
                                                <!-- <th data-field="id">Acco. ID</th> -->
                                                <th data-field="name" >Accommodation Name</th>
                                                <th data-field="email">Guest Details</th>
                                                <th data-field="phone">Room No</th>
                                                <th data-field="complete">Check In</th>
                                                <th data-field="task">Check Out</th>
                                                <th data-field="date">Id Proof</th>
                                                <!-- <th data-field="price" data-editable="true">Address</th>
                                                <th data-field="action">Location</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                             <?php
                                            foreach($visitorsRepport as $visitorRepport){?>
                                         <tr>
                                            <td><?php echo $visitorRepport['name'];?></td>
                                            <td><?php echo $visitorRepport['guestDetails'];?></td>
                                            <td><?php echo $visitorRepport['roomNumber'];?></td>
                                            <td><?php echo $visitorRepport['checkIn'];?></td>
                                            <td><?php echo $visitorRepport['checkOut'];?></td>
<!--                                            <td><?php echo $visitorRepport['idProofPhotoFront'];?></td>-->
                                            <td><span class="viewlocation"><a href="#">View&nbsp;image</a></span></td>
                                         </tr>
                                            <?php }?>
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
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>  
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->
        <script type="text/javascript" language="javascript" >
        $(document).ready(function(){

         fill_datatable();

         function fill_datatable(startdate = '', enddate = '')
         {
          var dataTable = $('#table').DataTable({
           "processing" : true,
           "serverSide" : true,
           "order" : [],
           "searching" : false,
           "ajax" : {
            url: baseurl+"visitors/getAllVisiterReport",
            type:"POST",
            data:{
             startdate:startdate, enddate:enddate
            }
           }
          });
         }

         $('#filter').click(function(){
          var startdate = $('#startdate').val();
          var enddate = $('#enddate').val();
          if(startdate !== '' && enddate !== '')
          {
           $('#table').DataTable().destroy();
           fill_datatable(startdate, enddate);
          }
          else
          {
           alert('Select Both filter option');
           $('#table').DataTable().destroy();
           fill_datatable();
          }
         });


        });

       </script>
  
    <script>
//        $(document).ready(function() {
//    $('#table').DataTable( {
//        dom: 'Bfrtip',
//        buttons: [
//            'pdf', 'print', 'csv',{   //'copy', 'excelFlash', 'excel',
//            text: 'Reload',
//             action: function ( e, dt, node, config ) {
//                dt.ajax.reload();
//            }
//        }
//        ]
//    } );
//} );
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.0/js/bootstrap-datepicker.min.js"></script>

    <script>
        $(document).ready(function(){

            $("#startdate").datepicker({
                todayBtn:  1,
                autoclose: true,
            }).on('changeDate', function (selected) {
                var minDate = new Date(selected.date.valueOf());
                $('#enddate').datepicker('setStartDate', minDate);
            });

            $("#enddate").datepicker({autoclose: true,})
                .on('changeDate', function (selected) {
                    var maxDate = new Date(selected.date.valueOf());
                    $('#startdate').datepicker('setEndDate', maxDate);
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
    </style>
</body>

</html>