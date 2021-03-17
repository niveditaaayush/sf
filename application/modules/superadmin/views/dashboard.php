<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('includes/header');
$totalAccommodations = ($liveAccommodations + $inactiveAccommodations);
if ($totalAccommodations != 0) {
    $activePercent = bcdiv($liveAccommodations / $totalAccommodations, 1, 5) * 100;
    $inActivePercent = bcdiv($inactiveAccommodations / $totalAccommodations, 1, 5) * 100;
} else {
    $activePercent = $liveAccommodations * 100;
    $inActivePercent = $inactiveAccommodations * 100;
}
//$colourCodes = array('#4BC7E9', '#A280D8', '#31BDA3', '#E27171', '#E28E33', '#5566B5', '#FF7BAC', '#666666', '#006DF0');
$colourCodes = array('#67DDDD', '#8E67FD', 'yellow', '#00E64D', '#FF9900', '#6991FD', '#FD7567', '#E661AC', 'purple');
$hopper = 0; $sos=0;

$district = $this->input->get('district');
$zone = $this->input->get('zone');
$circle = $this->input->get('division') != 'null' ? $this->input->get('division') : NULL;
$sho_area = $this->input->get('sho_area');

if(!empty($district))
{
    $acc_activeurl = base_url('superadmin/accommodations/filter/1?district='.$district.'&zone='.$zone.'&division='.$circle.'&sho_area='.$sho_area);
    $acc_inactiveurl = base_url('superadmin/accommodations/filter/0?district='.$district.'&zone='.$zone.'&division='.$circle.'&sho_area='.$sho_area);
    $checkin_url = base_url('superadmin/checkins/filter?district='.$district.'&zone='.$zone.'&division='.$circle.'&sho_area='.$sho_area);
    $visitor_url = base_url('superadmin/visitors/filter?district='.$district.'&zone='.$zone.'&division='.$circle.'&sho_area='.$sho_area);
}
else{
    $acc_activeurl = base_url('superadmin/accommodations/active');
    $acc_inactiveurl = base_url('superadmin/accommodations/inactive');
    $checkin_url = base_url('superadmin/checkins');
    $visitor_url = base_url('superadmin/visitors');
}
?>
<div class="breadcome-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcome-list">
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                            <ul class="breadcome-menu">
                                <li><a href="<?php echo base_url('superadmin/dashboard'); ?>">Safe CheckIn</a> <span class="bread-slash">></span>
                                </li>
                                <li><span class="bread-blod">Dashboard</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                            <?php $this->load->view('data_filters');?>
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
                                    <a href="<?php echo base_url('superadmin/accommodations'); ?>">View Details</a>
                                </div> 
                            </div>
                        </div>
                        <div class="row inactive">
                            <div class="col-lg-6 col-md-12 col-sm-6 col-xs-12 safecheck">
                                <div class="analytics-sparkle-line reso-mg-b-30 accommodations">
                                    <a class="accommodation-status" href="<?php echo $acc_activeurl; ?>">
                                        <div class="analytics-content">
                                            <h2 class="text-success"><?php echo $liveAccommodations; ?></h2>
                                            <span class="text-success">Active Accommodations</span>
                                            <div class="progress m-b-0">
                                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $liveAccommodations; ?>" aria-valuemin="0" aria-valuemax="<?php echo $totalAccommodations; ?>" style="width:<?php echo $activePercent; ?>%;"> 
                                                    <span class="sr-only"><?php echo $activePercent; ?>% Complete</span> 
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-6 col-xs-12 safecheck">
                                <div class="analytics-sparkle-line reso-mg-b-30 accommodations">
                                    <a class="accommodation-status" href="<?php echo $acc_inactiveurl;?>">
                                        <div class="analytics-content">
                                            <h2 class="text-success"><?php echo $inactiveAccommodations; ?></h2>
                                            <span class="text-success">Inactive Accommodations</span>
                                            <div class="progress m-b-0">
                                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $inactiveAccommodations; ?>" aria-valuemin="0" aria-valuemax="<?php echo $totalAccommodations; ?>" style="width:<?php echo $inActivePercent; ?>%;">
                                                    <span class="sr-only"><?php echo $inActivePercent; ?>% Complete</span> </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-12  col-xs-12 safecheck">
                                <div class="analytics-sparkle-line reso-mg-b-30 totalaccomm">
                                    <a href="<?php echo base_url('superadmin/accommodations'); ?>">
                                        <div class="analytics-content">
                                            <h2 class="text-success"><?php echo $totalAccommodations; ?></h2>
                                            <span class="text-success">Total No. Of Accommodations</span>
                                        </div>
                                    </a>
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
                                    <a href="<?php echo base_url('superadmin/checkins'); ?>">View Checkins</a>
                                </div> 
                            </div>
                        </div>
                        <div class="row check">
                            <div class="col-lg-6 col-md-12 col-sm-6 col-xs-12 ">
                                <div class="col-lg-12  col-xs-12 safecheck acticheck">
                                    <div class="analytics-sparkle-line1 reso-mg-b-30 ">
                                        <a class="accommodation-status" href="<?php echo $checkin_url; ?>">
                                            <div class="analytics-content">
                                                <h2 class="text-success"><?php echo $totalCheckins; ?></h2>
                                                <span class="text-success">Total No. Of Active Checkins</span>
                                            </div>
                                        </a>
                                    </div>
                                    <hr/>
                                    <div class="analytics-sparkle-line1 reso-mg-b-30 ">
                                        <a class="accommodation-status" href="<?php echo $visitor_url; ?>">
                                            <div class="analytics-content">
                                                <h2 class="text-success"><?php echo $totalVisitors; ?></h2>
                                                <span class="text-success">Total No. Of Active Visitors</span>
                                            </div>
                                        </a>
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
                                            <a href="<?php echo base_url('superadmin/checkins/filter?start_date='.date('Y-m-d').'&end_date='.date('Y-m-d'));?>">Today Reports</a>
                                        </div> 
                                    </div>
                                    <hr/>
                                    <div class="analytics-sparkle-line1 reso-mg-b-30 ">
                                        <div class="analytics-content">
                                            <h2 class="text-success"><?php echo $todayVisitors; ?></h2>
                                            <span class="text-success">Total No. Of Visitors Today</span>
                                        </div>
                                        <div class="todayreports">
                                            <!--<a href="#">Today Reports</a>-->
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
                                            <td><a href="#" title="<?php echo $accommdationsType->type; ?>" onclick="filterMarkersByTag('<?php echo $accommdationsType->type; ?>');return false;"><?php echo $accommdationsType->type; ?></a></td>
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
                    <div class="responsive-mg-b-30">

                        <div class="sparkline8-graph">
                        <div id="map-canvas" style="width: auto; height: 390px"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- add suspectslist nivedita  -->
<div class="courses-area mg-b-15">
    <div class="container-fluid">
        <div class="row allaccom">
            <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12 accomudation">
                <h5>Suspects</h5>
                <div class="white-box">
                    <div class="static-table-list">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    
                                    <th>ID Proof</th>
                                    <th>Vehicle</th>

                                    
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (@sizeof($Suspects) > 0) {
                                    foreach ($Suspects as $suspect) {
                                        ?>
                                        <tr>
                                            <td><?php echo $suspect->firstName.' '.$suspect->lastName;?></td>
                                            <td><?php echo $suspect->idProofType;?></br><?php echo $suspect->idProofNumber;?></td>
                                            
                                            <td><?php echo $suspect->vehicleNumber;?></td>
                                            
                                        <?php }
                                    }
                                    ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>   
            <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12 accomudation">
                <h5>Hoppers</h5>
                <div class="white-box">
                    <div class="static-table-list">
                        <p class="zoro"><?php echo $hopper; ?></p>
                        <p>NO Hoppers Found</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- <div class="courses-area mg-b-15">
    <div class="container-fluid">
        <div class="row allaccom">
            <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12 accomudation">
                <h5>Hoppers</h5>
                <div class="white-box">
                    <div class="static-table-list">
                        <p class="zoro"><?php echo $hopper; ?></p>
                        <p>NO Hoppers Found</p>
                    </div>
                </div>
            </div>
            

        </div>
    </div>
</div> -->

<script src="<?php echo base_url(); ?>assets/js/google.maps/google.maps-active.js"></script>

<style>.sidebardashboard{background: #DCF6F9;border-left: 5px solid #4BC7E9;color: #000;}ul.breadcome-menu {text-align: left;margin-left: -12px;}</style>
<?php $this->load->view('includes/footer'); ?><script async defer type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyAyeWp1FICFLemClhblvKP8muO03rQrE4o&callback=initialize"></script>

<script>
    var map;
    var infoWindow;
    var markers = [];
    var markersData = <?php echo json_encode($accommodations);?> 
    function initialize() {
    var mapOptions = {
        center: new google.maps.LatLng(18.1480068,80.5861528),
        mapTypeId: 'roadmap',
    };

    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
    infoWindow = new google.maps.InfoWindow();
    google.maps.event.addListener(map, 'click', function() {
        infoWindow.close();
    });
    displayMarkers();
    }

    function displayMarkers(){
    var bounds = new google.maps.LatLngBounds();
    for (var i = 0; i < markersData.length; i++){
        var latlng = new google.maps.LatLng(markersData[i].lat, markersData[i].lng);
        var title = markersData[i].title;
        var description = markersData[i].description;
        var type = markersData[i].type;
        //var postalCode = markersData[i].postalCode;
        createMarker(latlng, title, description, type);
        bounds.extend(latlng);  
    }
    map.fitBounds(bounds);
    }

    function createMarker(latlng, title, description, type){
    var icon = "";
                switch (type) {
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
        map: map,
        position: latlng,
        title: title,
        animation: google.maps.Animation.DROP,
        icon: new google.maps.MarkerImage(icon)
    });
    
    marker.tag = type;
    markers.push(marker);
    google.maps.event.addListener(marker, 'click', function() {
        var iwContent = '<div id="iw_container">' +
                '<div class="iw_title">' + title + '</div>' +
            '<div class="iw_content">' + description + '<br />' +
            type + '<br />' +
            '</div></div>';
        infoWindow.setContent(iwContent);
        infoWindow.open(map, marker);
    });
    }

    function filterMarkersByTag(tagName) {
        var bounds = new google.maps.LatLngBounds();
        
        markers.forEach(function(marker) {
            marker.setMap(null);
        });

        var filtered = markers.filter(function(marker) {
            return marker.tag === tagName;
        }); 
        
        if (filtered && filtered.length) {
            filtered.forEach(function(marker) {
                bounds.extend(marker.getPosition());
                marker.setMap(map);
            });

            map.fitBounds(bounds);
        }
    }
    </script>