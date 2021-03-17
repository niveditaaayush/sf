<div class="footer-copyright-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="footer-copy-right">
                    <p>Copyright © 2020. All rights reserved. Template by <a href="#">Safe CheckIn</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        // get all zones
        $('#district').on('change', function () {
            var district = $(this).val();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url();?>admin/dashboard/getAjaxDistrictZones',
                data: {'district': district}
            }).done(function (response) {
                var data = JSON.parse(response);
                $('select#zone').html('<option value="">Select Zone</option>');
                $('select#division').html('<option value="">Select Division</option>');
                $('select#sho_area').html('<option value="">Select SHO Area</option>');
                if (data.status === true && data.zones !== '') {
                    $.each(data.zones, function (key, value) {
                        var obj = $('<option value="' + value.zone + '">' + value.zone + '</option>');
                        $('select#zone').append(obj);
                    });
                }
            }).fail(function () {
                alert('zones not found for this district');
            });
        });
        // get all divisions
        $('#zone').on('change', function () {
            var zone = $(this).val();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>admin/dashboard/getAjaxZoneDivisions',
                data: {'zone': zone}
            }).done(function (response) {
                var data = JSON.parse(response);
                $('select#division').html('<option value="">Select Division</option>');
                $('select#sho_area').html('<option value="">Select SHO Area</option>');
                if (data.status === true && data.divisions !== '') {
                    $.each(data.divisions, function (key, value) {
                        if(value.division == null){
                            var obj = $('<option value="' + value.division + '">No Division</option>');
                        } else {
                            var obj = $('<option value="' + value.division + '">' + value.division + '</option>');
                        }
                        
                        $('select#division').append(obj);
                    });
                }
            }).fail(function () {
                alert('divisions not found for this zone');
            });
        });
        // get all police stations
        $('#division').on('change', function () {
            var zone = $('#zone').val();
            var division = $(this).val();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>admin/dashboard/getAjaxDivisionSHOArea',
                data: {'zone':zone,'division': division}
            }).done(function (response) {
                var data = JSON.parse(response);
                $('select#sho_area').html('<option value="">Select SHO Area</option>');
                if (data.status === true && data.sho_areas !== '') {
                    $.each(data.sho_areas, function (key, value) {
                        var obj = $('<option value="' + value.station + '">' + value.station + '</option>');
                        $('select#sho_area').append(obj);
                    });
                }
            }).fail(function () {
                alert('sho area not found for this division');
            });
        });
        $("body").on("click", ".actions.delete", function (e) {
            var conf = confirm("Are you sure you want to delete?");
            if (conf == false)
                e.preventDefault();
        });
    });
    
    $(window).on('load', function () {
        var district = $('#district').val();
        var zone = $('#zone').val();
        if(zone == ''){
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url();?>admin/dashboard/getAjaxDistrictZones',
                data: {'district': district}
            }).done(function (response) {
                var data = JSON.parse(response);
                $('select#zone').html('<option value="">Select Zone</option>');
                if (data.status === true && data.zones !== '') {
                    $.each(data.zones, function (key, value) {
                        var obj = $('<option value="' + value.zone + '">' + value.zone + '</option>');
                        $('select#zone').append(obj);
                    });
                }
            }).fail(function () {
                alert('zones not found for this district');
            });
        }
    });
        // get all divisions
    $(window).on('load', function () {
        var zone = $('#zone').val();
        var division = $('#division').val();
        if(division == ''){
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>admin/dashboard/getAjaxZoneDivisions',
                data: {'zone': zone}
            }).done(function (response) {
                var data = JSON.parse(response);
                $('select#division').html('<option value="">Select Division</option>');
                if (data.status === true && data.divisions !== '') {
                    $.each(data.divisions, function (key, value) {
                        var obj = $('<option value="' + value.division + '">' + value.division + '</option>');
                        $('select#division').append(obj);
                    });
                }
            }).fail(function () {
                alert('divisions not found for this zone');
            });
        }
    });
        // get all police stations
    $(window).on('load', function () {
        var division = $('#division').val();
        var sho_area = $('#sho_area').val();
        if(sho_area == ''){
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>admin/dashboard/getAjaxDivisionSHOArea',
                data: {'division': division}
            }).done(function (response) {
                var data = JSON.parse(response);
                $('select#sho_area').html('<option value="">Select SHO Area</option>');
                if (data.status === true && data.sho_areas !== '') {
                    $.each(data.sho_areas, function (key, value) {
                        var obj = $('<option value="' + value.station + '">' + value.station + '</option>');
                        $('select#sho_area').append(obj);
                    });
                }
            }).fail(function () {
                alert('sho area not found for this division');
            });
        }
    });
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.meanmenu.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.sticky.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.scrollUp.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/metisMenu/metisMenu.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/metisMenu/metisMenu-active.js"></script>    
<!--<sc type="text/javascript"ript src="<?php echo base_url(); ?>assets/js/tawk-chat.js"></script>-->
<!--    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/data-table/bootstrap-table.js"></script>-->
<script type="text/javascript" src='<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js'></script>
<script type="text/javascript" src='<?php echo base_url(); ?>assets/js/dataTables.buttons.min.js'></script>
<script type="text/javascript" src='<?php echo base_url(); ?>assets/js/pdfmake.min.js'></script>
<script type="text/javascript" src='<?php echo base_url(); ?>assets/js/vfs_fonts.js'></script>
<script type="text/javascript" src='<?php echo base_url(); ?>assets/js/buttons.html5.min.js'></script>
<script type="text/javascript" src='<?php echo base_url(); ?>assets/js/buttons.print.min.js'></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/notifications/lobibox.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/notifications/notification-active.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/main.js"></script>
<?php if ( ! empty($this->session->flashdata('success') && $this->session->flashdata('success') != '')) { ?>
    <script type="text/javascript">
        var successText = '<?php echo $this->session->flashdata('success'); ?>';
        if (successText != '') {
            Lobibox.notify('success', {
                    size: 'mini',
                    msg: successText
                });
        }
    </script>
<?php } elseif ( ! empty($this->session->flashdata('error') && $this->session->flashdata('error') != '')) { ?>
    <script type="text/javascript">
        var errorText = '<?php echo $this->session->flashdata('error'); ?>';
        if (errorText != '') {
            Lobibox.notify('error', {
                    size: 'mini',
                    msg: errorText
                });
        }
    </script>
<?php } ?>
</body>
</html>
