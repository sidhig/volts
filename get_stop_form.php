<?php
		  session_start();
		  error_reporting(1);
		 include_once('connect.php');
	// Edit form script start //

					 
			
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Stop Report</title>
<link rel="image icon" type="image/png" sizes="160x160" href="image/icon.png">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="js/jquery.min.js"></script>
  <script type="text/javascript" src="jquery-1.4.1.min.js"></script>
<script type="text/javascript" src="js/drop.js"></script>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="//cdn.jsdelivr.net/webshim/1.14.5/polyfiller.js"></script>
<script>
    webshims.setOptions('forms-ext', {types: 'date'});
webshims.polyfill('forms forms-ext');
</script>
<style>
* {
    box-sizing: border-box;
}
.row:after {
    content: "";
    clear: both;
    display: block;
}
[class*="col-"] {
    float: left;
    padding: 15px;
}
html {
    font-family: "Lucida Sans", sans-serif;
}


/* For desktop: */

.col-12 {width: 100%;}
 .sel{width:10vw;}
 .intp{width:10vw;}
@media only screen and (max-width: 768px) {
    /* For mobile phones: */
    [class*="col-"] {
        width: 100%;
    }
    .intp {
        width: 100%;
    }
    .sel {
        width: 100%;
    }
    .tbl {
        height: 100%;
    }
}
footer {
      color:black;
      padding-top: .8vh;
      padding-bottom: 2.5vh;
      background-color: white;
      border: 1px solid #BBBBBB;
      width:100%;
    }
</style>
</head>
<body style="background-color: #d6dce2;">


  
<div class="row" style="margin-top:.3vh;border: 1px solid #BBBBBB;background-color: white;padding-bottom:.3vh;height:auto;min-height:70vh;">

 <input onclick='window.close();' type="button" value="Back" style="float:left;margin-top:2vh;" />
<center><h1>Stop Report</h1></center>
<form method="post" action="stop_report.php"  id="get_trip_report" onsubmit="return validateForm()" >
<center><div class="tbl" style="width:98%;">
<div class="col-12 right" style="margin-top:6vh;border: 1px solid black;background-color: white;padding-bottom:1vh;padding-left:1vh;height:auto;min-height:25vh;">

<strong>Driver: </strong><input list='browsers' class="intp" id='driver_name' ><input type='hidden' name="driver_name" id="hidden_driver_name">
<strong>Equip # : </strong><input list='equip_id' class="intp" id='equip_imei'><input type='hidden' name="equip_imei" id="hidden_equip_id">
<? date_default_timezone_set("EST5EDT"); $d=strtotime("-1 week");
 ?>
<strong>From date: </strong><input type="date" class="intp" name="from_date" id="from_date" value="<?=date("Y-m-d", $d)?>">
<strong>Time: </strong><input type="time" class="intp" name="from_time" id="from_time" value="00:00" >
<strong>To date: </strong><input type="date" class="intp" name="to_date" id="to_date" value="<?=date("Y-m-d")?>">
<strong>Time: </strong><input type="time" class="intp" name="to_time" id="to_time" value="00:00" ><br/><br/>


<input type="submit" id="submit" value="Get Report" /><br/><br/>
<span id="error" style="color:red; display:none;">Please wait while your request is processed.</span>
</div>
</div></center>
<script type="text/javascript" src="jquery-1.9.1.js"></script>

<script>

$("#driver_name").on('input', function() {
		var data = {};
		$("#browsers option").each(function(i,el) {  
				   data[$(el).data("value")] = $(el).val();
		});
		console.log(data, $("#browsers option").val());
		var value = $('#driver_name').val();
		//alert(value);
		if(typeof ($('#browsers [value="' + value + '"]').data('value')) === "undefined")
		{
					
		}
		else
		{
					
					var v_imei = ($('#browsers [value="' + value + '"]').data('value'));
					$("#hidden_driver_name").val(v_imei);
					
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

function validateForm() {
if (($( "#from_date" ).val() == "") || ($( "#from_time" ).val() == "") || ($( "#to_date" ).val() == "") || ($( "#to_time" ).val() == "")) {
alert("All fields must be filled out");
return false;
}
else if ($( "#hidden_driver_name" ).val() == "" && $( "#hidden_equip_id" ).val() == "") {
alert("Please select Driver/Equipment");
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


</form>
</div>
<? 

$result = $conn->query("select if(driver_name = '' ,concat(trim(DeviceName ),'(DNM)'), concat(trim(driver_name),'(',trim(DeviceName),')')) as  Deviceanddriver,DeviceName, DeviceIMEI from devicedetails where  username='gpc' and opco in (select name from role_opco where if('".$_SESSION['ROLE_opco']."'='0',1,id in (".$_SESSION['ROLE_opco']."))) and 
`primary` in (SELECT name from role_primary where if('".$_SESSION['ROLE_primary']."'='0',1,id in (".$_SESSION['ROLE_primary']."))) and `group` in (SELECT name from role_group where if('".$_SESSION['ROLE_group']."'='0',1,id in (".$_SESSION['ROLE_group']."))) and 
department in (SELECT name from role_dept where if('".$_SESSION['ROLE_dept']."'='0',1,id in (".$_SESSION['ROLE_dept']."))) and 
DeviceType in (SELECT eq_name from tbl_eqptype where if('".$_SESSION['ROLE_eqp']."'='0',1,id in (".$_SESSION['ROLE_eqp']."))) order by driver_name"); 

?>
<datalist id="browsers">
<? 

while($vehicle = $result->fetch_object())
			 {
			 ?>
			   <option data-value="<?=$vehicle->DeviceIMEI?>" value="<?=$vehicle->Deviceanddriver?>" > 
			<?  }
			 ?>
</datalist>
<?
$result = $conn->query("select if(driver_name = '' ,concat(trim(DeviceName ),'(DNM)'), concat(trim(driver_name),'(',trim(DeviceName),')')) as  Deviceanddriver,DeviceName, DeviceIMEI from devicedetails where username='gpc' and opco in (select name from role_opco where if('".$_SESSION['ROLE_opco']."'='0',1,id in (".$_SESSION['ROLE_opco']."))) and 
`primary` in (SELECT name from role_primary where if('".$_SESSION['ROLE_primary']."'='0',1,id in (".$_SESSION['ROLE_primary']."))) and `group` in (SELECT name from role_group where if('".$_SESSION['ROLE_group']."'='0',1,id in (".$_SESSION['ROLE_group']."))) and 
department in (SELECT name from role_dept where if('".$_SESSION['ROLE_dept']."'='0',1,id in (".$_SESSION['ROLE_dept']."))) and 
DeviceType in (SELECT eq_name from tbl_eqptype where if('".$_SESSION['ROLE_eqp']."'='0',1,id in (".$_SESSION['ROLE_eqp']."))) order by DeviceName");
?>
<datalist id="equip_id">
<? 
while($vehicle = $result->fetch_object())
			 {
			 ?>
			   <option data-value="<?=$vehicle->DeviceIMEI?>" value="<?=$vehicle->DeviceName?>" > 
			<?  }
			 ?>
</datalist>
<center><div>
<? include_once('fotter.php'); ?>
