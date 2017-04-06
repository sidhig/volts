<?php
		  session_start();
		  error_reporting(0);
		
		  if($_POST["time_sheet"]!='') {
		  $_SESSION['time_sheet']= $_POST["time_sheet"];
}
		  if($_POST["from_date"]=='' & $_POST["to_date"]=='') {
		  header('location:report.php');
			}
	 include_once('connect.php');
	// Edit form script start //
	//print_r($_POST);
	//echo $_POST['from_date']." ".$_POST['from_time'];


$qry_maxminid = $conn->query("select max(maxid) as maxid,min(minid) as minid from table_id_ref where if('".$_POST["from_date"]."'!='',val_date >= '".$_POST["from_date"]."',val_date >= date(DATE_SUB(NOW(), INTERVAL 24 hour))) and if('".$_POST["to_date"]."'!='',val_date <= '".$_POST["to_date"]."',1) ")->fetch_object();

	/*$qry_maxminid= mysql_fetch_array(mysql_query("select min(id) as `minid`, max(id) as `maxid`,date(timestamp) from event_data where `timestamp` > '".$_POST['from_date']." ".$_POST['from_time']."' and `timestamp` < '".$_POST['to_date']." ".$_POST['to_time']."' "));
*/
	//$maxid = $qry_maxminid['maxid'];
		//$minid = $qry_maxminid['minid'];

		/* and event_data.id <= '".$maxid."'*/
		$maxdatecond = '';
		if($_POST["to_date"] !='')
		{	$currentdate = date("Y-m-d");
			if($_POST["to_date"] != $currentdate)
			{
				$maxdatecond = "and id <= '".$qry_maxminid->maxid."'";
			}
		}

	
if($_POST["veh_no"]=='All') {
   $report = "select *,concat(driver_name , \"(\",deviceid,\")\") as 'dname' from event_data left join devicedetails on event_data.DeviceImei = devicedetails.DeviceIMEI where eventcode='6007' and  id >= '".$qry_maxminid->minid."' ".$maxdatecond." and event_data.DeviceImei in (select DeviceIMEI from  devicedetails  where department = 'Metering Services') order by `deviceid`";

}
else {
		$report = "select *,concat(driver_name , \"(\",deviceid,\")\") as 'dname' from event_data left join devicedetails on event_data.DeviceImei = devicedetails.DeviceIMEI where eventcode='6007' and  id >= '".$qry_maxminid->minid."' ".$maxdatecond." and event_data.DeviceImei = '".$_POST['veh_no']."'  order by `deviceid`";

}		
//echo $list;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Braking Report</title>
<link rel="image icon" type="image/png" sizes="160x160" href="image/icon.png">
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
<center><div id="container" style="width:98%;margin-top:-1vh;margin-bottom:.3vh;">
<div id="wrappermap" style="background-color: #fff; height:auto; min-height:550px;">
<table width="98%" style="margin:10px; table-layout:fixed;">
<tr>
<th align="left" style="width: 462px;">
 <form action="get_braking_rep.php" method="post"><input id="report_back" type="submit" value="Back" style="float:left;" /></form> </th></tr>
 </table>
<center><h1>Braking Report</h1>
<h3>From: <?=date('m-d-Y h:i A',strtotime($_POST['from_date'].' '.$_POST['from_time']))?> 
To: <?=date('m-d-Y h:i A',strtotime($_POST['to_date'].' '.$_POST['to_time']))?></h3></center>
<table border="0" width="100%" style=" border-spacing: 15px;">
<tr><th>Driver</th><th>Details</th><th>Date</th><th>Time</th><th>Location</th></tr>
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
 
   <? if($eventcode=='6007') { ?>
<tr><th><? if($dname!=$ereport->dname) { ?><?=$dname = $ereport->dname?><? } ?></th>
<th><?=$ereport->declaration?> MPH/Sec</th>
<th><?=$mmddyy = substr($ereport->timestamp,5,2)."-".substr($ereport->timestamp,8,2)."-".substr($ereport->timestamp,2,2)?></th>
<th><?=date('h:i:s A',strtotime($ereport->timestamp))?></th>
<th>(<a target="_blank" href="https://maps.google.com/maps?q=<?=$ereport->lati.",".$ereport->longi?>" >GMap link</a>)</th></tr>
<? $csv_string = $csv_string.str_replace(","," ",$ereport->dname).",Declaration,".$ereport->declaration." MPH/Sec,".$mmddyy.",".substr($ereport->timestamp,11,8).',=HYPERLINK("https://www.google.com/maps?q='.$ereport->lati.'+'.$ereport->longi.'")'."\r\n"; ?>
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
