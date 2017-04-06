<?php
		  session_start();
		  error_reporting(0);
		  include_once('connect.php');	
	// Edit form script start //

		//echo "$res";			 
			
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Crew Change Report</title>
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

<center><h1>Crew Change Report</h1></center>
<form method="post" action="crew_change_report_new.php" style="border:solid 1px black; margin-top: 20px; padding:20px;width:91vw;"  onsubmit="return validateForm()" >
<table border="0" width="100%" style=" border-spacing: 15px;">

<tr><th colspan="2"></th><th colspan="2">From</th><th colspan="2">To</th></tr>
<tr><th>Equip#</th><th>Crew</th><th>Date</th><th>Time</th><th>Date</th><th>Time</th></tr>
<tr>

<? date_default_timezone_set("EST5EDT"); $d=strtotime("-1 week");
 ?>
<th><input list="equip_id" class="intp"   id="equip_imei"><input type="hidden" name="equip_imei" id="hidden_equip_id">
<datalist id="equip_id">
  <?
      echo "select if(driver_name = '' ,concat(trim(DeviceName ),'(DNM)'), concat(trim(driver_name),'(',trim(DeviceName),')')) as  Deviceanddriver,DeviceName, DeviceIMEI from devicedetails where  username='gpc' and opco in (select name from role_opco where if('".$_SESSION['ROLE_opco']."'='0',1,id in (".$_SESSION['ROLE_opco']."))) and 
`primary` in (SELECT name from role_primary where if('".$_SESSION['ROLE_primary']."'='0',1,id in (".$_SESSION['ROLE_primary']."))) and `group` in (SELECT name from role_group where if('".$_SESSION['ROLE_group']."'='0',1,id in (".$_SESSION['ROLE_group']."))) and 
department in (SELECT name from role_dept where if('".$_SESSION['ROLE_dept']."'='0',1,id in (".$_SESSION['ROLE_dept']."))) and 
DeviceType in (SELECT eq_name from tbl_eqptype where if('".$_SESSION['ROLE_eqp']."'='0',1,id in (".$_SESSION['ROLE_eqp']."))) order by driver_name";

          $res = $conn->query("select if(driver_name = '' ,concat(trim(DeviceName ),'(DNM)'), concat(trim(driver_name),'(',trim(DeviceName),')')) as  Deviceanddriver,DeviceName, DeviceIMEI from devicedetails where  username='gpc' and opco in (select name from role_opco where if('".$_SESSION['ROLE_opco']."'='0',1,id in (".$_SESSION['ROLE_opco']."))) and 
`primary` in (SELECT name from role_primary where if('".$_SESSION['ROLE_primary']."'='0',1,id in (".$_SESSION['ROLE_primary']."))) and `group` in (SELECT name from role_group where if('".$_SESSION['ROLE_group']."'='0',1,id in (".$_SESSION['ROLE_group']."))) and 
department in (SELECT name from role_dept where if('".$_SESSION['ROLE_dept']."'='0',1,id in (".$_SESSION['ROLE_dept']."))) and 
DeviceType in (SELECT eq_name from tbl_eqptype where if('".$_SESSION['ROLE_eqp']."'='0',1,id in (".$_SESSION['ROLE_eqp']."))) order by driver_name");
               while($cam = $res->fetch_object())
               {
               ?><option data-value="<?=$cam->DeviceIMEI?>" value="<?=$cam->DeviceName?>" >
               
               
              <?  }  //$con->close();   ?>
</datalist></th>

<th><input list="browsers" class="intp user-success"   id="crew_name"><input type="hidden" name="crew_name" id="hidden_crew_name">
	<datalist  id="browsers">
  <?
       
          $res = $conn->query("select imei,name,crew from tbl_driverchnage group by crew");
               while($cam = $res->fetch_object())
               {
               ?><option data-value="<?=$cam->imei?>" value="<?=$cam->crew?>" >
               
               
              <?  }  //$con->close();   ?>
</datalist></th>

<th><input type="date" name="from_date" id="from_date" value="<?=date("Y-m-d", $d)?>" /></th>
<th><input type="time" name="from_time" id="from_time" value="00:00" /></th>
<th><input type="date" name="to_date" id="to_date" value="<?=date("Y-m-d")?>" /></th>
<th><input type="time" name="to_time" id="to_time" value="<?=date("H:i")?>" /></th></tr>

</table>
<input type="submit" value="Get Report" /> 

</form>

</div><!---wrappermap close -->
<script>
$("#crew_name").on('input', function() {
		var data = {};
		$("#browsers option").each(function(i,el) {  
				   data[$(el).data("value")] = $(el).val();
		});
		console.log(data, $("#browsers option").val());
		var value = $('#crew_name').val();
		//alert(value);
		if(typeof ($('#browsers [value="' + value + '"]').data('value')) === "undefined")
		{
					
		}
		else
		{
					
					var v_imei = ($('#browsers [value="' + value + '"]').data('value'));
					$("#hidden_crew_name").val(value);
					
		}

});

$("#equip_imei").on('input', function() {
		var data = {};
		$("#equip_id option").each(function(i,el) {  
				   data[$(el).data("value")] = $(el).val();
		});
		console.log(data, $("#equip_id option").val());
		var value = $('#equip_imei').val();
		//alert(value);
		if(typeof ($('#equip_id [value="' + value + '"]').data('value')) === "undefined")
		{
					
		}
		else
		{
					
					var v_imei = ($('#equip_id [value="' + value + '"]').data('value'));
					$("#hidden_equip_id").val(v_imei);
					
		}

});
// function validateForm() {

// 	var a = 1000*60*60*24;
// 	if((Date.parse($("#to_date").val())/a)-(Date.parse($("#from_date").val())/a)<8 && (Date.parse($("#to_date").val())/a)-(Date.parse($("#from_date").val())/a)>-1){
	
// 	}
// 	else{
// 	alert("Maximum number of days selected not more than 7 days.");
// 	return false;
	
// 	}
	
// }
function validateForm() {
 if ($( "#hidden_crew_name" ).val() == "" && $( "#hidden_equip_id" ).val() == "") {
		alert("Please select Crew/Equip #");
		return false;
	}
	else {
	var a = 1000*60*60*24;
	if((Date.parse($("#to_date").val())/a)-(Date.parse($("#from_date").val())/a)<8 && (Date.parse($("#to_date").val())/a)-(Date.parse($("#from_date").val())/a)>-1){
	
	}
	else{
	alert("Maximum number of days selected not more than 7 days.");
	return false;
	
	}
	}
}


</script>		
</center></div><!--- container close -->
<center><div>
<? include_once('fotter.php'); ?>
