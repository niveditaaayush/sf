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
                                    <li><span class="bread-blod">Payments</span>
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
</div>
<!-- Static Table Start -->
<div class="data-table-area mg-b-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list">
                    <div class="sparkline13-hd">
                        <div class="main-sparkline13-hd">
                            <h1 class="reportaccommo">All<span class="table-project-n"> payments</span> info</h1>
                        </div>
                    </div>
                    <div class="sparkline13-graph">
                        <div class="text-right col-lg-10 col-md-10 col-sm-10 col-xs-12" style="margin-bottom: -24px;">
                                <select id="payment_filter">
                                    <option value="">All</option>
                                    <option value="">paid Payments</option>
                                    <option value="">Pending Payments</option>
                                    
                                    ?>
                                </select>
                            </div>
                        <table id='suspectInfo' class='display dataTable'>
                            <thead>
                                <tr>
                                    <th>Sl No.</th>
                                    <th>Accodomation</th>
                                    <th>Owner Details</th>
                                    <th>Total Amount</th>
                                    <th>Paid Amount</th>
                                    <th>Pay Date</th>
                                    <th>Payment Status</th>
                                    <th>Payment Type</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                            <?php $i=1; if(sizeof($suspects) > 0){
                                    foreach ($suspects as $value) {?>
                                <tr>
                                    <td><?php echo $i++;?></td>
                                    <td class="result-name"><a href="#"><?php echo "sudarshan recident";?></a></td>
                                    <td class="result-id-proof-type"><?php echo "ramnath Patil<br/>8528528520";?></td>
                                    <td class="result-id-number"><?php echo "5000/-";?></td>
                                    <td class="result-id-number"><?php echo "5000/-";?></td>
                                    <td class="result-vehicle-number"><?php echo "11/10/2020";?></td>
                                    <td><?php echo"Paid";?></td>
                                    <td><?php echo"Card Payment";?></td>
                                    
                                </tr>
                            <?php }?>
                            <tr>
                                    <td><?php echo $i++;?></td>
                                    <td class="result-name"><a href="#"><?php echo "sudarshan recident";?></a></td>
                                    <td class="result-id-proof-type"><?php echo "ramnath Patil<br/>8528528520";?></td>
                                    <td class="result-id-number"><?php echo "5000/-";?></td>
                                    <td class="result-id-number"><?php echo "-";?></td>
                                    <td class="result-vehicle-number"><?php echo "11/10/2020";?></td>
                                    <td><?php echo "Pending";?></td>
                                    <td><?php echo "-";?></td>
                                    
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
        
       
    });
</script>


