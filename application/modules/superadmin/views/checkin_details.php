<?php $this->load->view('includes/header'); ?>
<style type="text/css">
    .submenureports, .sidebarvisitors a.sidebarmenuvisitors {
        background: #DCF6F9;
        border-left: 5px solid #4BC7E9;
        color: #000;
    }
    .visitorsImages img{
        width: 32px;
        height: auto;
        object-fit: contain;
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
                                    <a href="<?php echo base_url('superadmin');?>">Safe CheckIn</a> <span class="bread-slash">></span>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('superadmin/checkins');?>">CheckIns</a> <span class="bread-slash">></span>
                                </li>
                                <li>
                                    <span class="bread-blod">View CheckIn</span>
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
<div class="data-table-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list">
                    <div class="sparkline13-hd">
                        <div class="sparkline13-graph accommodationTable">                               
                            <table id='visiterReport' class='display dataTable'>
                                <thead>
                                    <tr>
                                        <th>Guest&nbsp;Name</th>
                                        <th>Phone&nbsp;Number</th>
                                        <th>ID&nbsp;Proof&nbsp;Type</th>
                                        <th>ID&nbsp;Proof&nbsp;Number</th>
                                        <th>Gender</th>
                                        <th>Age&nbsp;Group</th>
                                        <th>Address</th>
                                        <th>Images</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (sizeof($visitors) > 0) {
                                        foreach ($visitors as $visitor) {
                                            ?>
                                            <tr>
                                                <td><?php echo $visitor->firstName.' '.$visitor->lastName; ?></td>
                                                <td><?php echo $checkin->phoneNumber; ?></td>
                                                <td><?php echo $visitor->idProofType; ?></td>
                                                <td><?php echo maskPhoneNumber($visitor->idProofNumber); ?></td>
                                                <td><?php echo $visitor->gender; ?></td>
                                                <td><?php echo $visitor->ageGroup; ?></td>
                                                <td><?php echo $visitor->address; ?><br><?php echo $visitor->pincode; ?></td>
                                                <td class="visitorsImages" style="width:200px;">
                                                    <a data-toggle="modal" data-value="<?php echo $visitor->photoOfVisitor;?>" data-target="#visitorsImages" href="#">
                                                        <img src="<?php echo VIEW_PATH.'visitors/'.$visitor->photoOfVisitor?>">
                                                    </a>
                                                    <a data-toggle="modal" data-value="<?php echo $visitor->idProofPhotoBack;?>" data-target="#visitorsImages" href="#">
                                                        <img src="<?php echo VIEW_PATH.'visitors/'.$visitor->idProofPhotoBack?>">
                                                    </a>
                                                    <a data-toggle="modal" data-value="<?php echo $visitor->idProofPhotoFront;?>" data-target="#visitorsImages" href="#">
                                                        <img src="<?php echo VIEW_PATH.'visitors/'.$visitor->idProofPhotoFront?>">
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!--model image-->
                        <div id="visitorsImages" class="modal modal-edu-general default-popup-PrimaryModal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header1 header-color-modal1 bg-color-11">

                                        <div class="modal-close-area modal-close-df">
                                            <a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
                                        </div>
                                    </div>
                                    <div class="modal-body"> 
                                        <img src="#" alt="model Image" />
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <!--model image ends-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Static Table End -->
<script type="text/javascript">
    $(document).ready(function () {
        $('body').on('click', 'td.visitorsImages a', function (){
            var image = $(this).attr('data-value');
            if(image != ''){
                var imagePath = '<?php echo VIEW_PATH.'visitors/';?>';
                $('#visitorsImages').find('.modal-body').html('<img src="'+imagePath+image+'" class="responsive">');
            }
        });
    });
</script>
<?php $this->load->view('includes/footer'); ?>
