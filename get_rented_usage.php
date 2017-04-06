<?php
		  session_start();
		  error_reporting(0);
		 /* if(!isset($_SESSION['LOGIN_STATUS'])){
			  header('location:login.php');
		  }*/

	 include_once('connect.php');
	// Edit form script start //

					 
			
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Rental Equipment Report</title>
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
<center><h1>Rental Equipment Report</h1></center>
<form method="post" action="" style="border:solid 1px black; margin-top: 20px; padding:20px;width:91vw;" id="get_usage_report" onsubmit="return validateForm()" >
<table border="0" width="100%" style=" border-spacing: 15px;">
<tr><td></td><td></td><td></td><th colspan="2">From</th><th colspan="2">To</th></tr>
<tr><th>Rental Company</th><th>Equipment Type</th><th>Equipment #</th><th>Date</th><th>Time</th><th>Date</th><th>Time</th></tr>
<tr><th><select id="rent" name="rent"><option value="All">All</option>
<?php
		 	$result = $conn->query("select ownedby from devicedetails where ownedby !='' and ownedby !='GPC' and OBDType = 'Wired' and UserName = 'gpc' and ownedby not like '%GPC%' and DeviceName !='' and CASE WHEN (select dept  as eqpval  from roletable where username = '".$_SESSION['LOGIN_user']."') = 'All' THEN 1 ELSE (select dept from roletable where username = '".$_SESSION['LOGIN_user']."') like CONCAT('%', department, '%')  END and  CASE WHEN (select `group`  as eqpval  from roletable where username = '".$_SESSION['LOGIN_user']."') = 'All' THEN 1 ELSE (select `group` from roletable where username = '".$_SESSION['LOGIN_user']."') like CONCAT('%', `group`, '%')  END group by ownedby");
			 while($row = $result->fetch_object())
			 {
			   echo "<OPTION value='".$row->ownedby."'>".$row->ownedby.'</option>';
			  }
			?>
		  </select>
</th>

<th><select id="equip_type" name="equip_type"><option value="All">All</option>
<?php
		 	$result = $conn->query("select DeviceType from devicedetails where OBDType = 'Wired' and UserName = 'gpc' and ownedby not like '%GPC%' and DeviceName !='' and CASE WHEN (select dept  as eqpval  from roletable where username = '".$_SESSION['LOGIN_user']."') = 'All' THEN 1 ELSE (select dept from roletable where username = '".$_SESSION['LOGIN_user']."') like CONCAT('%', department, '%')  END and  CASE WHEN (select `group`  as eqpval  from roletable where username = '".$_SESSION['LOGIN_user']."') = 'All' THEN 1 ELSE (select `group` from roletable where username = '".$_SESSION['LOGIN_user']."') like CONCAT('%', `group`, '%')  END group by DeviceType");
			 while($row = $result->fetch_object())
			 {
			   echo "<OPTION>".$row->DeviceType.'</option>';
			  }
			?>
		  </select>
</th>
<? date_default_timezone_set("EST5EDT"); $d=strtotime("-1 week");
 ?>
 <th><select id="veh_name" name="veh_no" /><option value="All">All</option>
<?php
		 	$result = $conn->query("select DeviceName,DeviceIMEI from devicedetails where username = 'gpc' and ownedby not like '%GPC%' and OBDType = 'Wired' and DeviceName !='' and CASE WHEN (select dept  as eqpval  from roletable where username = '".$_SESSION['LOGIN_user']."') = 'All' THEN 1 ELSE (select dept from roletable where username = '".$_SESSION['LOGIN_user']."') like CONCAT('%', department, '%')  END and  CASE WHEN (select `group`  as eqpval  from roletable where username = '".$_SESSION['LOGIN_user']."') = 'All' THEN 1 ELSE (select `group` from roletable where username = '".$_SESSION['LOGIN_user']."') like CONCAT('%', `group`, '%')  END group by DeviceIMEI");
			 while($row = $result->fetch_object())
			 {
			   echo "<OPTION VALUE=".$row->DeviceIMEI.">".$row->DeviceName.'</option>';
			  }
			?>
			 </select></th>
<th><input type="date" name="from_date" id="from_date" value="<?=date("Y-m-d", $d)?>" /></th>
<th><input type="time" name="from_time" id="from_time" value="00:00" /></th>
<th><input type="date" name="to_date" id="to_date" value="<?=date("Y-m-d")?>" /></th>
<th><input type="time" name="to_time" id="to_time" value="<?=date("H:i")?>" /></th></tr>

</table>

<center>
<!--<div id="excep_report" style="border:gray 1px solid; width:220px; background-color:#ececec; margin-top: 15px;"><a onclick="this.form.submit()"><h3>SUBMIT</h3></a></div>
-->
<input type="button" id="get_dt_rep" value="Get Report" /> <input type="hidden" id="get_ov_rep" value="Overview Report" /><br /><br />
<span id="error" style="color:red; display:none;">Please wait while your request is processed.</span>
</center>
</form>
<script type="text/javascript" src="jquery-1.9.1.js"></script>
<script>
$("#equip_type").on('change', function() {
var equip_type = $("#equip_type").val();
		$.post( "get_eqp_rented_wired.php",{ equip_type: equip_type },function(data) {
		$("#veh_name").empty();
		data1='<option value="All">All</option>'+data;
		$("#veh_name").html(data1);
		});
});
$("#rent").on('change', function() {
var rent_comp = $("#rent").val();
		$.post( "get_rented_eqptype.php",{ rent_comp: rent_comp },function(data) {
			$("#equip_type").empty();
			data1='<option value="All">All</option>'+data;
			$("#equip_type").html(data1);
		});
});

$("#get_dt_rep").click( function() {
$("#get_usage_report").attr("action","usage_rented_report.php");
$("#get_usage_report").submit();
});
$("#get_ov_rep").click( function() {
$("#get_usage_report").attr("action","usage_rented_ov_report.php");
$("#get_usage_report").submit();
});

function validateForm() {
if (($( "#from_date" ).val() == "") || ($( "#from_time" ).val() == "") || ($( "#to_date" ).val() == "") || ($( "#to_time" ).val() == "")) {
alert("All fields must be filled out");
return false;
}
else {
$("#error").show();
}
	if($("#to_date").val()!='' & $("#from_date").val()!='') {
	var a = 1000*60*60*24;
	if((Date.parse($("#to_date").val())/a)-(Date.parse($("#from_date").val())/a)<31 & (Date.parse($("#to_date").val())/a)-(Date.parse($("#from_date").val())/a)>-1){
	//alert($("#from_date").val());  & ($( "#to_time" ).val() == null) & ($( "#from_time" ).val() == null) 
	}
	else{
	alert("Maximum number of days selected not more than 30 days.");
	return false;
	//$(this).val('');
	}
	}
}

</script>

</div><!---wrappermap close -->

		
</center></div><!--- container close -->
<center><div>
<? include_once('fotter.php'); ?>