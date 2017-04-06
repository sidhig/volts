<?php
		  session_start();
		  error_reporting(0);
		  include_once('connect.php');	
	// Edit form script start //

					 
			
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>DTC Report</title>
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
<script type="text/javascript" src="js/jquery.min.2.1.3.js"></script>
<!-- <script type="text/javascript" src="js/drop.js"></script> -->
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="//cdn.jsdelivr.net/webshim/1.14.5/polyfiller.js"></script>
<script>
webshims.setOptions('forms-ext', {types: 'date'});
webshims.polyfill('forms forms-ext');
</script>
</head>
<body BGCOLOR = '#d6dce2'>
<center><div id="container" style="width:98%;margin-top:-1vh;margin-bottom:.3vh;">
<div id="wrappermap" style="background-color: #fff; height:auto; min-height:550px;">

<table width="98%" style="margin:10px; table-layout:fixed;">
<tr><th align="left" style="width: 462px;"><input onclick='window.close();' type="button" value="Back" style="float:left;margin-top:2vh;" /></th></tr>
</table>

<center><h1>DTC Report</h1></center>
<form method="post" action="dtc_report_new.php" style="border:solid 1px black; margin-top: 20px; padding:20px;width:91vw;" id="get_usage_report" onsubmit="return validateForm()" >
<table border="0" width="100%" style=" border-spacing: 15px;">
<tr><td></td><th colspan="2">From</th><th colspan="2">To</th></tr>
<tr><th>Equipment #</th><th>Date</th><th>Time</th><th>Date</th><th>Time</th></tr>
<tr>

<? date_default_timezone_set("EST5EDT"); $d=strtotime("-1 week");
 ?>
 <th><select id="veh_name" name="veh_no" />
 <option value="All,All">All</option>
<?php
		 	$result = $conn->query("select * from `tbl_dct` group by `devicename` order by `devicename` asc");
			 while($row = $result->fetch_object())
			 {
			   echo "<OPTION VALUE=".$row->imei.','.$row->devicename.">".$row->devicename.'</option>';
			  }
			?>
			 </select></th>
<th><input type="date" name="from_date" id="from_date" value="<?=date("Y-m-d", $d)?>" /></th>
<th><input type="time" name="from_time" id="from_time" value="00:00" /></th>
<th><input type="date" name="to_date" id="to_date" value="<?=date("Y-m-d")?>" /></th>
<th><input type="time" name="to_time" id="to_time" value="<?=date("H:i")?>" /></th></tr>

</table>
<input type="submit" id="get_dtc_rep" value="Get Report" /> 

</form>

</div><!---wrappermap close -->
<script>

function validateForm() {

	var a = 1000*60*60*24;
	if((Date.parse($("#to_date").val())/a)-(Date.parse($("#from_date").val())/a)<8 && (Date.parse($("#to_date").val())/a)-(Date.parse($("#from_date").val())/a)>-1){
	
	}
	else{
	alert("Maximum number of days selected not more than 7 days.");
	return false;
	
	}
	
}

</script>		
</center></div><!--- container close -->
<center><div>
<? include_once('fotter.php'); ?>
