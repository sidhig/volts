<?php
error_reporting(0);
session_start();
include_once('connect.php');
ini_set("max_execution_time", 5000);

//$msg = createmsg($tripsheet);

function mailto1($msg,$usermail)
{
	$subject = '' ;
	$body = $msg;
	$sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);

    $msg = $usermail."#### ".$subject." #### ".$body;
    $len = strlen($msg);

    socket_sendto($sock, $msg, $len, 0, '127.0.0.1', 2123);
    socket_close($sock);
}

function mailwithsub($msg,$subject,$usermail){

		$body = $msg;
    	$sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);

		$msg = $usermail."#### ".$subject." #### ".$body;
		$len = strlen($msg);

		socket_sendto($sock, $msg, $len, 0, '127.0.0.1', 2123);
		socket_close($sock);
       
}



function createmsg($tripsheet,$table)
{

	$url1 = tinyurl('http://192.169.226.71/volts/maploc.php?tp='.$tripsheet);
	$url2 = tinyurl('http://192.169.226.71/volts/trip_pdf.php?tsn='.$tripsheet);
	$vehicle = mysql_fetch_array(mysql_query("select DeviceName,DeviceType,devicedetails.unit,time_sheet,".$table.".driver_phone from ".$table." left join devicedetails on ".$table.".veh_no = devicedetails.DeviceIMEI where time_sheet = '".$tripsheet."'"));
	if($vehicle["DeviceType"]=='Mobile Switch' || $vehicle["DeviceType"] =='Mobile Substation'){ $vehicle["DeviceName"]=$vehicle["unit"]; }
	$message = $vehicle["DeviceType"]." ".$vehicle["DeviceName"]." (".$url1.") ".$vehicle["time_sheet"]." (".$url2.") is assigned to you ".date('m/d/Y h:i A',strtotime($vehicle["time_sheet"]));

	if ($vehicle["driver_phone"] != '')
	{
			$phone1 = $vehicle["driver_phone"]."@txt.att.net";
			$phone2 = $vehicle["driver_phone"]."@vtext.com";
			$phone3 = $vehicle["driver_phone"]."@tmomail.net";
			$phone4 = $vehicle["driver_phone"]."@messaging.sprintpcs.com";
			mailto1($message,$phone1);
			mailto1($message,$phone2);
			mailto1($message,$phone3);
			mailto1($message,$phone4);
	}
}


function tinyurl($lurl){
    $curl = curl_init(); 
    $post_data = array('format' => 'json',
                       'apikey' => '7A9A3B8B593CEDD06082',
                       'provider' => 'tinyurl_com',
                       'url' => $lurl );
    $api_url = 'http://tiny-url.info/api/v1/create';
    curl_setopt($curl, CURLOPT_URL, $api_url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
    $result = curl_exec($curl);
    curl_close($curl);
 	$obj = json_decode($result);
    return $obj->{'shorturl'};
	//return $result;
}
?>
