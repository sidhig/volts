<?
//print_r($_POST);die();
//$conn = new mysqli('localhost', 'root', '', "xirgo");


    $geocodeFromAdd = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".str_replace(' ','+',$_POST['add'])."&key=AIzaSyCLWeYaDJ385i-vxLhMjNJ51NTFCVuaGaM");
    $output = json_decode($geocodeFromAdd);
	$lati  =$output->results[0]->geometry->location->lat;
	$longi =$output->results[0]->geometry->location->lng; 

	echo $lati .",".$longi;

?>	