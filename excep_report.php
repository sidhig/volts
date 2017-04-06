<?php
		  session_start();
		  error_reporting(0);
		  
		  if($_POST["time_sheet"]!='') {
		  $_SESSION['time_sheet']= $_POST["time_sheet"];
}
		  if($_POST["from_date"]=='' & $_POST["to_date"]=='') {
		  header('location:report.php');
			}
			//print_r($_POST);
	 include_once('connect.php');
	if($_POST["driver_name"] != ''){
		$report = "select *,concat(driver_name , \"(\",deviceid,\")\") as 'dname' from event_data left join devicedetails on event_data.DeviceImei = devicedetails.DeviceIMEI  where `timestamp` > '".$_POST['from_date']." ".$_POST['from_time']."' and `timestamp` < '".$_POST['to_date']." ".$_POST['to_time']."'";
	}else{
		$report = "select *,deviceid as 'dname' from event_data left join devicedetails on event_data.DeviceImei = devicedetails.DeviceIMEI  where `timestamp` > '".$_POST['from_date']." ".$_POST['from_time']."' and `timestamp` < '".$_POST['to_date']." ".$_POST['to_time']."'";
	}
	

if($_POST["excep_type"]=='All') {
$a = " and (eventcode = '6016' || eventcode = '6015' || speed > '".$_POST["speed"]."' || accelaration > '".$_POST["accel"]."' || declaration > '".$_POST["decel"]."' || rpm  > '".$_POST["rpm"]."' || ( bettery < '".$_POST["battery"]."' and  bettery > '1' ))";
$report = $report.$a;
}
else if($_POST["excep_type"]!='All') {
if($_POST["excep_type"]=='Speed') { $a= " and ( speed > '".$_POST["speed"]."' )"; }
if($_POST["excep_type"]=='Idle') { $a= " and ( eventcode = '6016' )"; }
if($_POST["excep_type"]=='Accel') { $a= " and ( accelaration > '".$_POST["accel"]."' )"; }
if($_POST["excep_type"]=='Decel') { $a= " and ( declaration > '".$_POST["decel"]."' )"; }
if($_POST["excep_type"]=='RPM') { $a= " and ( rpm  > '".$_POST["rpm"]."' )"; }
if($_POST["excep_type"]=='Battery') { $a= " and ( bettery < '".$_POST["battery"]."' )  and ( bettery > '1' )"; }
if($_POST["excep_type"]=='Power Up') { $a= " and ( eventcode = '6015' )"; }
$report = $report.$a;
}
	
if($_POST["driver_name"]=='All' || $_POST["equip_imei"]=='All') {
$a= " and CASE WHEN (select dept  as eqpval  from roletable where username = '".$_SESSION['LOGIN_user']."') = 'All' THEN 1 ELSE (select dept from roletable where username = '".$_SESSION['LOGIN_user']."') like CONCAT('%', department, '%')  END and  CASE WHEN (select `group`  as eqpval  from roletable where username = '".$_SESSION['LOGIN_user']."') = 'All' THEN 1 ELSE (select `group` from roletable where username = '".$_SESSION['LOGIN_user']."') like CONCAT('%', `group`, '%')  END order by `deviceid` ";
$report = $report.$a;
}
else if($_POST["driver_name"]!='All' ||  $_POST["equip_imei"]!='All') {
	if($_POST["driver_name"] != ''){

		$a= " and `deviceid` = '".$_POST['driver_name']."' order by `deviceid` ";
	}else{
		$a= " and `deviceid` = '".$_POST['equip_imei']."' order by `deviceid` ";
	}
	

$report = $report.$a;
//echo $report;

}		

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Exception Report</title>
<link rel="icon" href="image/iocn.png" type="image/gif" sizes="16x16">
<link rel="stylesheet" type="text/css" href="css/style.css" />
<style>
 html, body, #map-canvas {
				height: 100%;
				margin: 0px;
				padding: 0px
			  }
.trip{
margin:10px;
border:2px solid black;
padding:10px;
font-weight:600;
align:center;
}
div#cost input{
width:90px;
}
footer {
      color:black;
      padding-top: 1vh;
      padding-bottom: 0vh;
      background-color: white;
      border: 1px solid #BBBBBB;
      width:98%;
    }
</style>
<script type="text/javascript" src="jquery-1.4.1.min.js"></script>
<script type="text/javascript" src="js/drop.js"></script>

</head>
<body BGCOLOR = '#d6dce2'>
<div id="container">
<center><div id="wrappermap" style="background-color: #fff; height:auto; min- float: left; border:1px solid black;margin-top:1vh;width:97vw;">
<table width="95%" style="margin:10px; table-layout:fixed;">
<tr>
<th align="left" style="width: 462px;"><a href="get_excep_report.php" ><input id="report_back" type="button" value="Back" style="float:left;" /></a></th></tr>
 </table>
<center><h1>Exception Report</h1>
<h3><?
if($_POST["driver_name"]=='All'){ 
	echo $_POST["driver_name"]; 
}else if($_POST["equip_imei"]=='All'){
	echo $_POST["equip_imei"];
}
else if($_POST['driver_name'] != ''){
	
	$result = $conn->query("select concat(driver_name , '(',DeviceName,')') as 'dname',DeviceName from devicedetails where  username='gpc' and DeviceName = '".$_POST["driver_name"]."'")->fetch_object();
}else{
	
	$result = $conn->query("select DeviceName as 'dname' from devicedetails where  username='gpc' and DeviceName = '".$_POST["equip_imei"]."'")->fetch_object();
}
echo $result->dname;
?>
</h3>
<h3>Exception Type : <?=$_POST["excep_type"]?></h3>
<h3>From: <?=date('m-d-Y h:i A',strtotime($_POST['from_date'].' '.$_POST['from_time']))?> 
To: <?=date('m-d-Y h:i A',strtotime($_POST['to_date'].' '.$_POST['to_time']))?></h3></center>
<table border="0" width="100%" style=" border-spacing: 15px;">
<tr><th>Driver</th><th>Exception</th><th>Details</th><th>Date</th><th>Time</th><th>Location</th></tr>
<? 
$csv_string = "Driver,Exception,Details,Date,Time,Location\r\n";
 $result = $conn->query($report);
  while($ereport = $result->fetch_object()){  
  $eventcode = $ereport->eventcode;
  $speed = $ereport->speed;
  $accelaration = $ereport->accelaration;
  $declaration = $ereport->declaration;
  $rpm = $ereport->rpm;
  $bettery = $ereport->bettery; ?>
 
  <? if($eventcode=='6016') { ?>
<tr><th><? if($dname!=$ereport->dname) { ?><?=$dname = $ereport->dname?><? } ?></th>
<th>Idle</th>
<th></th>
<th><?=$mmddyy = substr($ereport->timestamp,5,2)."-".substr($ereport->timestamp,8,2)."-".substr($ereport->timestamp,2,2)?></th>
<th><?=substr($ereport->timestamp,11,8)?></th>
<th>(<a target="_blank" href="https://maps.google.com/maps?q=<?=$ereport->lati.",".$ereport->longi?>" >GMap link</a>)</th></tr>
<? $csv_string = $csv_string.str_replace(","," ",$ereport->dname).",Idle, ,".$mmddyy.",".substr($ereport->timestamp,11,8).',=HYPERLINK("https://www.google.com/maps?q='.$ereport->lati.'+'.$ereport->longi.'")'."\r\n"; ?>
 <? } ?>
 
   <? if($eventcode=='6008') { ?>
<tr><th><? if($dname!=$ereport->dname) { ?><?=$dname = $ereport->dname?><? } ?></th>
<th>Battery Low</th>
<th></th>
<th><?=$mmddyy = substr($ereport->timestamp,5,2)."-".substr($ereport->timestamp,8,2)."-".substr($ereport->timestamp,2,2)?></th>
<th><?=substr($ereport->timestamp,11,8)?></th><th>(<a target="_blank" href="https://maps.google.com/maps?q=<?=$ereport->lati.",".$ereport->longi?>" >GMap link</a>)</th></tr>
<? $csv_string = $csv_string.str_replace(","," ",$ereport->dname).",Battery Low, ,".$mmddyy.",".substr($ereport->timestamp,11,8).',=HYPERLINK("https://www.google.com/maps?q='.$ereport->lati.'+'.$ereport->longi.'")'."\r\n"; ?>
 <? } ?>
  
      <? if($eventcode=='6015') { ?>
<tr><th><? if($dname!=$ereport->dname) { ?><?=$dname = $ereport->dname?><? } ?></th>
<th>Power Up</th>
<th></th>
<th><?=$mmddyy = substr($ereport->timestamp,5,2)."-".substr($ereport->timestamp,8,2)."-".substr($ereport->timestamp,2,2)?></th>
<th><?=substr($ereport->timestamp,11,8)?></th>
<th>(<a target="_blank" href="https://maps.google.com/maps?q=<?=$ereport->lati.",".$ereport->longi?>" >GMap link</a>)</th></tr>
<? $csv_string = $csv_string.str_replace(","," ",$ereport->dname).",Power Up, ,".$mmddyy.",".substr($ereport->timestamp,11,8).',=HYPERLINK("https://www.google.com/maps?q='.$ereport->lati.'+'.$ereport->longi.'")'."\r\n"; ?>
 <? } ?>
 
 <? if($speed>$_POST["speed"]) { ?>
<tr><th><? if($dname!=$ereport->dname) { ?><?=$dname = $ereport->dname?><? } ?></th>
<th>Speed</th>
<th><?=$ereport->speed?> MPH</th>
<th><?=$mmddyy = substr($ereport->timestamp,5,2)."-".substr($ereport->timestamp,8,2)."-".substr($ereport->timestamp,2,2)?></th>
<th><?=substr($ereport->timestamp,11,8)?></th>
<th>(<a target="_blank" href="https://maps.google.com/maps?q=<?=$ereport->lati.",".$ereport->longi?>" >GMap link</a>)</th></tr>
<? $csv_string = $csv_string.str_replace(","," ",$ereport->dname).",Speed,".$ereport->speed." MPH,".$mmddyy.",".substr($ereport->timestamp,11,8).',=HYPERLINK("https://www.google.com/maps?q='.$ereport->lati.'+'.$ereport->longi.'")'."\r\n"; ?>
 <? } ?>
  
  
  <? if($accelaration>$_POST["accel"]) { ?>
<tr><th><? if($dname!=$ereport->dname) { ?><?=$dname = $ereport->dname?><? } ?></th>
<th>Acceleration</th>
<th><?=$ereport->accelaration?> MPH/Sec</th>
<th><?=$mmddyy = substr($ereport->timestamp,5,2)."-".substr($ereport->timestamp,8,2)."-".substr($ereport->timestamp,2,2)?></th>
<th><?=substr($ereport->timestamp,11,8)?></th><th>(<a target="_blank" href="https://maps.google.com/maps?q=<?=$ereport->lati.",".$ereport->longi?>" >GMap link</a>)</th></tr>
<? $csv_string = $csv_string.str_replace(","," ",$ereport->dname).",Acceleration,".$ereport->accelaration." MPH/Sec,".$mmddyy.",".substr($ereport->timestamp,11,8).',=HYPERLINK("https://www.google.com/maps?q='.$ereport->lati.'+'.$ereport->longi.'")'."\r\n"; ?>
 <? } ?>
 
   <? if($declaration>$_POST["decel"]) { ?>
<tr><th><? if($dname!=$ereport->dname) { ?><?=$dname = $ereport->dname?><? } ?></th>
<th>Deacceleration</th>
<th><?=$ereport->declaration?> MPH/Sec</th>
<th><?=$mmddyy = substr($ereport->timestamp,5,2)."-".substr($ereport->timestamp,8,2)."-".substr($ereport->timestamp,2,2)?></th>
<th><?=substr($ereport->timestamp,11,8)?></th><th>(<a target="_blank" href="https://maps.google.com/maps?q=<?=$ereport->lati.",".$ereport->longi?>" >GMap link</a>)</th></tr>
<? $csv_string = $csv_string.str_replace(","," ",$ereport->dname).",Declaration,".$ereport->declaration." MPH/Sec,".$mmddyy.",".substr($ereport->timestamp,11,8).',=HYPERLINK("https://www.google.com/maps?q='.$ereport->lati.'+'.$ereport->longi.'")'."\r\n"; ?>
 <? } ?>
 
    <? if($rpm>$_POST["rpm"]) { ?>
<tr><th><? if($dname!=$ereport->dname) { ?><?=$dname = $ereport->dname?><? } ?></th>
<th>RPM</th>
<th><?=$ereport->rpm?> RPM</th>
<th><?=$mmddyy = substr($ereport->timestamp,5,2)."-".substr($ereport->timestamp,8,2)."-".substr($ereport->timestamp,2,2)?></th>
<th><?=substr($ereport->timestamp,11,8)?></th><th>(<a target="_blank" href="https://maps.google.com/maps?q=<?=$ereport->lati.",".$ereport->longi?>" >GMap link</a>)</th></tr>
<? $csv_string = $csv_string.str_replace(","," ",$ereport->dname).",RPM,".$ereport->rpm." RPM,".$mmddyy.",".substr($ereport->timestamp,11,8).',=HYPERLINK("https://www.google.com/maps?q='.$ereport->lati.'+'.$ereport->longi.'")'."\r\n"; ?>
 <? } ?>
 
     <? if($bettery<$_POST["battery"] and $bettery > 1 ) { ?>
<tr><th><? if($dname!=$ereport->dname) { ?><?=$dname = $ereport->dname?><? } ?></th>
<th>Battery</th>
<th><?=$ereport->bettery?></th>
<th><?=$mmddyy = substr($ereport->timestamp,5,2)."-".substr($ereport->timestamp,8,2)."-".substr($ereport->timestamp,2,2)?></th>
<th><?=substr($ereport->timestamp,11,8)?></th><th>(<a target="_blank" href="https://maps.google.com/maps?q=<?=$ereport->lati.",".$ereport->longi?>" >GMap link</a>)</th></tr>
<? $csv_string = $csv_string.str_replace(","," ",$ereport->dname).",Battery,".$ereport->bettery.",".$mmddyy."-".substr($ereport->timestamp,0,4).",".substr($ereport->timestamp,11,8).',=HYPERLINK("https://www.google.com/maps?q='.$ereport->lati.'+'.$ereport->longi.'")'."\r\n"; ?>
 <? } ?>
 
<? } ?>
</table>
<textarea id="csv_string" style="display:none;" ><?=$csv_string?></textarea>
<center>

<?
/*$myfile = fopen("Exc Report.csv", "w") or die("Unable to open file!");
fwrite($myfile, $csv_string);
fclose($myfile);*/
?>
<div id="butns" style="padding: 20px 24% 20px 24%;">
<input type="button" id="excep_report" style=" width: auto;  min-width: 25%;  font-weight: 700;  height: 40px;cursor:pointer; background: url('image/3_d_button.png'); background-size: 100% 100%; border:0px;" onclick="PrintElem('#wrappermap')" value="Print" />
<input type="button" id="excep_report" style=" width: auto;  min-width: 25%;  font-weight: 700;  height: 40px;cursor:pointer; background: url('image/3_d_button.png'); background-size: 100% 100%; border:0px;" onclick="exc()" value="Send CSV" />
<a id="csv_link" href=""><input type="button" id="excep_report" style=" width: auto;  min-width: 25%;  font-weight: 700;  height: 40px;cursor:pointer; background: url('image/3_d_button.png'); background-size: 100% 100%; border:0px;" onclick="exc_download()" value="Download CSV" /></a>
</div><!--butns div close -->
</div>
</center>
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
function exc(){
//alert($("#csv_string").val());
$.post( "create_csv.php",{ csv_string: $("#csv_string").val() },function(data) {
					filename = data;
					var email = prompt("Send CSV to Email");
						if(email!='' & email!=null){
						 	$.post( "create_csv.php",{ email: email, csv_string: $("#csv_string").val(),create_for: 'Exception' },function(data) { alert("Email send successfully to "+email); 
							});
						}
						else{ return false; }
					});
}
function exc_download(){
//alert($("#csv_string").val());
$.post( "create_csv.php",{ csv_string: $("#csv_string").val(),create_for: 'Exception' },function(data) { 
					//alert(data);
					$("#csv_link").attr("href", data);
					document.getElementById("csv_link").click();
					});
}
</script>
<script type="text/javascript">

function PrintElem(data) 
    {
	
        /*var mywindow = window.open('', 'wrappermap', 'height=600,width=1000');
        mywindow.document.write('<html><head><title>Trip Sheet</title>');		
        mywindow.document.write('</head><body onload="" >');
		if(data!=''){*/
        //mywindow.document.write($(data).html());
		// mywindow.document.write($("#trip_data").html());this.form.submit();onclick="return alert("If You want to create CSV file Enter Email here"); "
		$("#butns").hide();
		$("#report_back").hide();
		/* mywindow.document.write($("#wrappermap").html());
		 }
		
        mywindow.document.write('</body></html>');
		mywindow.print();*/
		window.print();
		$("#butns").show();
		$("#report_back").show();
		//mywindow.close();
        return true;
    }

</script>



</div><!---wrappermap close -->

		
	</center></div><!--- container close -->
	<center><div>
<? include_once('fotter.php'); ?>

