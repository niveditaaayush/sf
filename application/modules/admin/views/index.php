<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('includes/header');
$totalAccommodations = ($liveAccommodations + $inactiveAccommodations);
$activePercent = bcdiv($liveAccommodations / $totalAccommodations, 1, 5) * 100;
$inActivePercent = bcdiv($inactiveAccommodations / $totalAccommodations, 1, 5) * 100;
//$colourCodes = array('#4BC7E9', '#A280D8', '#31BDA3', '#E27171', '#E28E33', '#5566B5', '#FF7BAC', '#666666', '#006DF0');
$colourCodes = array('lightblue', 'purple', 'yellow', 'green', 'orange', 'blue', 'red', 'pink', 'purple');
?>
<div class="breadcome-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcome-list">
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                            <ul class="breadcome-menu">
                                <li><a href="<?php echo base_url('admin/dashboard'); ?>">Safe CheckIn</a> <span class="bread-slash">></span>
                                </li>
                                <li><span class="bread-blod">Dashboard</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                            <div class="basic-login-form-ad">
                                <div class="row">

                                    <div class="basic-login-inner inline-basic-form">
                                        <form action="<?php echo base_url('admin/dashboard/filter'); ?>" method="get">
                                            <div class="form-group-inner">
                                                <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12 district">
                                                    <div class="form-select-list">
                                                        <select id="city" class="form-control custom-select-value" name="city">
                                                            <option>Select District</option>
                                                            <?php
                                                            if (@sizeof($cities) > 0) {
                                                                foreach ($cities as $city) {
                                                                    ?>
                                                                    <option value="<?php echo $city->district; ?>"><?php echo $city->district; ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12 district">
                                                    <div class="form-select-list">
                                                        <select id="zone" class="form-control custom-select-value" name="zone">
                                                            <option value="">Select Zone</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12 district">
                                                    <div class="form-select-list">
                                                        <select id="division" class="form-control custom-select-value" name="division">
                                                            <option value="">Select Division</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12 district">
                                                    <div class="form-select-list">                                                                                    
                                                        <select id="sho_area" class="form-control custom-select-value" name="sho_area">
                                                            <option value="">Select SHO Area</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12 district">
                                                    <div class="login-btn-inner">
                                                        <div class="login-horizental lg-hz-mg"><button class="btn btn-sm btn-primary login-submit-cs" type="submit">Submit</button></div>
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
</div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="breadcome-list">
                <div class="row">
                    <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12">
                        <div class="row accom">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <h5>Accommodations</h5>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="viewdetail">
                                    <a href="<?php echo base_url('admin/accommodations'); ?>">View Details</a>
                                </div> 
                            </div>
                        </div>
                        <div class="row inactive">
                            <div class="col-lg-6 col-md-12 col-sm-6 col-xs-12 safecheck">
                                <div class="analytics-sparkle-line reso-mg-b-30 accommodations">
                                    <div class="analytics-content">
                                        <h2 class="text-success"><?php echo $liveAccommodations; ?></h2>
                                        <span class="text-success">Active Accommodations</span>
                                        <div class="progress m-b-0">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $liveAccommodations; ?>" aria-valuemin="0" aria-valuemax="<?php echo $totalAccommodations; ?>" style="width:<?php echo $activePercent; ?>%;"> 
                                                <span class="sr-only"><?php echo $activePercent; ?>% Complete</span> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-6 col-xs-12 safecheck">
                                <div class="analytics-sparkle-line reso-mg-b-30 accommodations">
                                    <div class="analytics-content">
                                        <h2 class="text-success"><?php echo $inactiveAccommodations; ?></h2>
                                        <span class="text-success">Inactive Accommodations</span>
                                        <div class="progress m-b-0">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $inactiveAccommodations; ?>" aria-valuemin="0" aria-valuemax="<?php echo $totalAccommodations; ?>" style="width:<?php echo $inActivePercent; ?>%;">
                                                <span class="sr-only"><?php echo $inActivePercent; ?>% Complete</span> </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12  col-xs-12 safecheck">
                                <div class="analytics-sparkle-line reso-mg-b-30 totalaccomm">
                                    <div class="analytics-content">
                                        <h2 class="text-success"><?php echo $totalAccommodations; ?></h2>
                                        <span class="text-success">Total No. Of Accommodations</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-6 col-sm-12 col-xs-12">
                        <div class="row checkactiv">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <h5>Checkins</h5>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="view-details viewcheck">
                                    <a href="<?php echo base_url('admin/visitors'); ?>">View Checkins</a>
                                </div> 
                            </div>
                        </div>
                        <div class="row check">
                            <div class="col-lg-6 col-md-12 col-sm-6 col-xs-12 ">
                                <div class="col-lg-12  col-xs-12 safecheck acticheck">
                                    <div class="analytics-sparkle-line1 reso-mg-b-30 ">
                                        <div class="analytics-content">
                                            <h2 class="text-success"><?php echo $totalCheckins; ?></h2>
                                            <span class="text-success">Total No. Of Active Checkins</span>
                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="analytics-sparkle-line1 reso-mg-b-30 ">
                                        <div class="analytics-content">
                                            <h2 class="text-success"><?php echo $totalVisitors; ?></h2>
                                            <span class="text-success">Total No. Of Active Visitors</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-6 col-xs-12 ">
                                <div class="col-lg-12  col-xs-12 safecheck checktoday">
                                    <div class="analytics-sparkle-line1 reso-mg-b-30 ">
                                        <div class="analytics-content">
                                            <h2 class="text-success"><?php echo $todayCheckins; ?></h2>
                                            <span class="text-success">Total No. Of Checkins Today</span>
                                        </div>
                                        <div class="todayreports">
                                            <a href="#">Today Reports</a>
                                        </div> 
                                    </div>
                                    <hr/>
                                    <div class="analytics-sparkle-line1 reso-mg-b-30 ">
                                        <div class="analytics-content">
                                            <h2 class="text-success"><?php echo $todayVisitors; ?></h2>
                                            <span class="text-success">Total No. Of Visitors Today</span>
                                        </div>
                                        <div class="todayreports">
                                            <a href="#">Today Reports</a>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="courses-area mg-b-15">
    <div class="container-fluid">
        <div class="row allaccom">
            <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12 accomudation">
                <h5>All Accommodations</h5>
                <div class="white-box">
                    <div class="static-table-list">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Label</th>
                                    <th>Category</th>
                                    <th>Registered</th>
                                    <th>Active</th>
                                    <th>Inactive</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (@sizeof($accommodationsTypes) > 0) {
                                    foreach ($accommodationsTypes as $key => $accommdationsType) {
                                        ?>
                                        <tr>
                                            <td><div class="color-box" style="background-color: <?php echo $colourCodes[$key]; ?>;"></div></td>
                                            <td><?php echo $accommdationsType->type; ?></td>
                                            <td><?php echo ($accommdationsType->active + $accommdationsType->inActive); ?></td>
                                            <td><?php echo $accommdationsType->active; ?></td>
                                            <td><?php echo $accommdationsType->inActive; ?></td>
                                        <?php }
                                    }
                                    ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12 accommap">
                <h5>Accommodations On Map</h5>
                <div class="white-box res-mg-t-30 table-mg-t-pro-n">
                    <div class="sparkline8-list responsive-mg-b-30">

                        <div class="sparkline8-graph">
                            <div id="dvMap" style="width: auto; height: 350px"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="courses-area mg-b-15">
    <div class="container-fluid">
        <div class="row allaccom">
            <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12 accomudation">
                <h5>Hoppers</h5>
                <div class="white-box">
                    <div class="static-table-list">
                        <p class="zoro">0</p>
                        <p>NO Hoppers Found</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        // get all cities
        $('#city').on('change', function () {
            var city = $(this).val();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>admin/dashboard/getAjaxSHOAreaList',
                data: {'city': city}
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
                alert('sho area not found for this city');
            });
        });
        // get all zones
        $('#sho_area').on('change', function () {
            var sho_area = $(this).val();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>admin/dashboard/getAjaxZonesList',
                data: {'sho_area': sho_area}
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
                alert('zones not found for this sho area');
            });
        });
    });
</script>
<script src="<?php echo base_url(); ?>assets/js/google.maps/google.maps-active.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBiNUO68DkrsFKFz744_LWMqCNI_GqYciQ&callback=initMap"></script>
<!--<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>-->
<script type="text/javascript">
    var markers = <?php echo json_encode($accommodations); ?>
//        [
//        {
//            "title": 'Bombay Hospital',
//            "lat": '18.9409388',
//            "lng": '72.82819189999998',
//            "description": 'Bombay Hospital',
//            "type": 'Hospital'
//        }
//    ];
    window.onload = function () {

        var mapOptions = {
            center: new google.maps.LatLng(markers[1].lat, markers[2].lng),
            zoom: 8,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var infoWindow = new google.maps.InfoWindow();
        var latlngbounds = new google.maps.LatLngBounds();
        var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
        var i = 0;
        var interval = setInterval(function () {
            var data = markers[i]
            var myLatlng = new google.maps.LatLng(data.lat, data.lng);
            var icon = "";
            switch (data.type) {
                case "Hotel":
                    icon = "lightblue";
                    break;
                case "Lodge":
                    icon = "purple";
                    break;
                case "Guest House":
                    icon = "yellow";
                    break;
                case "Dormitory":
                    icon = "green";
                    break;
                case "PG":
                    icon = "orange";
                    break;
                case "Service Apartment":
                    icon = "blue";
                    break;
                case "Home Stay":
                    icon = "red";
                    break;
                case "Hostel":
                    icon = "pink";
                    break;
                case "Others":
                    icon = "purple";
                    break;
            }
            icon = "http://maps.google.com/mapfiles/ms/icons/" + icon + ".png";
            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                title: data.title,
                animation: google.maps.Animation.DROP,
                icon: new google.maps.MarkerImage(icon)
            });
            (function (marker, data) {
                google.maps.event.addListener(marker, "click", function (e) {
                    infoWindow.setContent(data.description);
                    infoWindow.open(map, marker);
                });
            })(marker, data);
            latlngbounds.extend(marker.position);
            i++;
            if (i == markers.length) {
                clearInterval(interval);
                var bounds = new google.maps.LatLngBounds();
                map.setCenter(latlngbounds.getCenter());
                map.fitBounds(latlngbounds);
            }
        }, 80);
    }
</script>
<style>.dash{background: #DCF6F9;border-left: 5px solid #4BC7E9;color: #000;}ul.breadcome-menu {text-align: left;margin-left: -12px;}</style>
<?php $this->load->view('includes/footer'); ?>