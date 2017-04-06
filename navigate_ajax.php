<?php
  //session_start();
  error_reporting(0);
 /* if(!isset($_SESSION['LOGIN_STATUS'])){
      header('location:login.php');
  }
 include_once('config.php');
$mbval='';*/
	if( $_REQUEST["url2"] )
{

//$_REQUEST["url2"] = "https://maps.googleapis.com/maps/api/directions/json?key=AIzaSyCLWeYaDJ385i-vxLhMjNJ51NTFCVuaGaM&origin=BLAKELY,GA&destination=ny";
//$_REQUEST["url2"] = "https://maps.googleapis.com/maps/api/directions/json?key=AIzaSyCLWeYaDJ385i-vxLhMjNJ51NTFCVuaGaM&origin=delhi&destination=agra";

//echo $_REQUEST["url2"];
$_REQUEST["url2"] = str_replace(' ',',',$_REQUEST["url2"]);
	$content = file_get_contents(rtrim($_REQUEST["url2"],'|'));
	$myArray = json_decode($content, true);
	$dist = 0;
	foreach($myArray['routes'][0]['legs'] as $val){
		$dist1 = str_replace(" mi","",$val['distance']['text']);
		$dist1 = str_replace(",","",$dist1);
		$dist = $dist + $dist1;
	}
	echo round($dist);
	echo '##$$';
	foreach($myArray['routes'][0]['legs'] as $var){
				$count = 1 ;
				echo "Start : " .$var['start_address']."<br/>";
				foreach ($var['steps'] as $key =>  $post)
				 {
					 echo $post['html_instructions']."<br>";
					 echo $post['distance']['text']."_____________________________________________<br><br>";
					$count++;
				 }
				 echo "End : " .$var['end_address']."<br/><br/>"; 
	}

	$r = array();
	$r[] = array('dlati'=>$myArray['routes'][0]['legs'][0]['start_location']['lat'],'dlongi'=>$myArray['routes'][0]['legs'][0]['start_location']['lng']);
	$final = count($myArray['routes'][0]['legs'])-1;
	$r[] = array('alati'=>$myArray['routes'][0]['legs'][$final]['end_location']['lat'],'alongi'=>$myArray['routes'][0]['legs'][$final]['end_location']['lng']);
for($i=0;$i<$final;$i++){
	$j=$i+1;
	$r[] = array('arrival_lati'.$j=>$myArray['routes'][0]['legs'][$i]['end_location']['lat'],'arrival_longi'.$j=>$myArray['routes'][0]['legs'][$i]['end_location']['lng']);
}/*$a = array();
for($i=0;$i<$final;$i++){
	$j=$i+1;
	$a[] = array('arrival_lati'.$j=>$myArray['routes'][0]['legs'][$i]['end_location']['lat'],'arrival_longi'.$j=>$myArray['routes'][0]['legs'][$i]['end_location']['lng']);
}
echo json_encode($a);*/
echo '##$$';
echo json_encode($r);
}

?>