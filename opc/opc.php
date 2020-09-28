<?php
    //displays errors and warning but does not display parse errors such as missing semicolons or missing curly braces
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    //imports openCage class librarys
	include('openCage/AbstractGeocoder.php');
	include('openCage/Geocoder.php');

    //uses API key access openCage results
	$geocoder = new \OpenCage\Geocoder\Geocoder('657bb4a61a7f47af84f3ace052fa11a0');

    //collects coordinates results and uses english language
    $result = $geocoder->geocode( '54.5223, -6.0071' , [ 'language' => 'en' ]);

    //creats array to display address information
    $openCageResult = [];
    $openCageResult['Address'] = [];

    //loop through results to display specific information
    foreach ($result['results'] as $display) {

        $address['Address'] = $display['formatted'];
        $address['Postcode'] = strtoupper($display['components']['postcode']);
        $address['State'] = strtoupper($display['components']['state']);
        $address['Geometry']['Latitude'] = $display['geometry']['lat'];
        $address['Geometry']['Longitude'] = $display['geometry']['lng'];

        //adds the address results to array
        array_push($openCageResult['Address'], $address);
    }

    //creats array to display location information
    $openCageResult['Location'] = [];
    
    foreach ($result['results'] as $display) {

        $location['Flag'] = $display['annotations']['flag'];
        $location['Country'] = $display['components']['country'];
        $location['Continent'] = $display['components']['continent'];
        $location['Timezone'] = $display['annotations']['timezone']['name'];
        $location['Driving'] = $display['annotations']['roadinfo']['drive_on'];
        $location['Speed'] = $display['annotations']['roadinfo']['speed_in'];

         //adds the location results to array
        array_push($openCageResult['Location'], $location);
    }
    
    //displays values on JSON format
    echo json_encode($openCageResult);
?>