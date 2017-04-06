<?php
  //print_r(data);
  //$_POST(data);
		  session_start();
		  error_reporting(0);
	 include_once('connect.php'); 
	include_once('substationjson.php');
	//  $_SESSION["favcolor"] = "green";
	// $_SESSION["favcolor"] = "green";
	$unitId = $_POST['unit'];
	//$location = $_GET['loc'];
	//echo " select unit,high_side,low_side,mva,DeviceImei,voltage from devicedetails where unit='".$_POST['unit']."'";
	$get_unit=$conn->query("select unit,high_side,low_side,mva,DeviceImei,voltage from devicedetails where unit='".$_POST['unit']."'")->fetch_object();
	//print_r($get_unit);
    //$qry="select unit,high_side,low_side,mva,DeviceImei from devicedetails where unit='".$_GET['unit_']."'";
     $asd =$get_unit->DeviceImei; 
      //print_r($asd);
     
	$latires = $conn->query("select  Event_data_last_view.deviceid as 'DeviceName',DeviceType,lati,longi,DeviceImei as 'DeviceIMEI',IF((TIME_TO_SEC(TIMEDIFF(now(),maxdata.timestamp))/7200)>1,2,0) as timediff,'4011' as `status`, (Event_data_last_view.`timestamp` -interval 0 hour) as 'timestamp',driver_name from (select MAX(Event_data_last_view.timestamp) as timestamp , Event_data_last_view.deviceid from Event_data_last_view,event_desc where Event_data_last_view.eventcode = event_desc.eventcode  and Event_data_last_view.DeviceImei  in (Select DeviceIMEI from devicedetails where UserName = 'GPC' group by DeviceIMEI) group by Event_data_last_view.deviceid) as maxdata, Event_data_last_view,event_desc where Event_data_last_view.timestamp = maxdata.timestamp and Event_data_last_view.eventcode = event_desc.eventcode and maxdata.deviceid = Event_data_last_view.deviceid and DeviceIMEI = '".$asd."'  and lati!='' and lati is not null ")->fetch_object();
	if($latires->lati!=''){
	$poiqry = $conn->query("SELECT (name) AS 'poi',(((acos(sin((".$latires->lati."*pi()/180)) * sin((lati*pi()/180))+cos((".$latires->lati."*pi()/180)) * cos((lati*pi()/180)) * cos(((".$latires->longi."- longi)*pi()/180))))*180/pi())*60*1.1515) as distance FROM `substation_more` order by distance limit 1");
	$forpoi=$poiqry->fetch_object();
	//print_r($forpoi);
}
?>
 <script src="js/jquery.min.js"></script>

 <span style="float:left;"><input type="button" value="Back" onclick="$('#schedule_abbr').load('Schedule_Calendar.php');"></span>
<center>
	<form id="new_eqp"  >
		<h2>New Schedule</h2>
	<table border="0" style="border-spacing: 15px; ">
		<input type="hidden" name="schedule" value="new" >
		<b>
		<tr>
			<td>From Date<span style="color:red;">*</span>:</td>
			<td><input type="date" id="start_date" name="start_date" value="" min="<?=date('Y-m-d')?>"></td>
		</tr>
		<tr>
			<td>To Date<span style="color:red;">*</span>:</td>
			<td><input type="date" id="end_date" name="end_date" value="" min="<?=date('Y-m-d')?>"></td>
		</tr>
		<tr>
			<th colspan='2'><span id="error" style="color:red; display:none;">Please wait while geting available unit for given date.</span>
			</th>
		</tr>

		<tr><td>Location Needed<span style="color:red;">*</span>:</td><td>
<datalist id="poi_list" ><?=ltrim($substation_dl,"<option data-value='' value='Address' >")?></datalist><input list='poi_list' type="text" name="loc_need" id="loc_need" value=""></td></tr>
		<tr>
			<td>Contact Name:</td>
			<td><input type="text" id="cont_name" name="contactname" value="" ></td>
		</tr>
		<tr>
			<td>Contact Office:</td>
			<td><input type="text" id="contact_off" name="contact_off" value="" ></td>
		</tr>
		<tr>
			<td>Contact Mobile:</td>
			<td><input type="text" id="contact_mobile" name="contact_mobile" value="" ></td>
		</tr>
		<tr>
			<td>Contact Linc:</td>
			<td><input type="text" id="contact_linc" name="contact_linc" value="" ></td>
		</tr>
		<tr>
			<td>Contact Email:</td>
			<td><input type="text" id="contact_email" name="contact_email" value="" ></td>
		</tr>
		<tr>
			<td>Schedule for <span style="color:red;">*</span>:</td>
			<td><select name = "schedule_for" id = "schedule_for" >
				<option>On site work</option>
		        <option>Equipment Servicing</option>
		        <option>Emergency </option></select>
		    </td>
		</tr>
		<tr>
			<td>Voltage<span style="color:red;">*</span>:</td>
			<td><input type="text" name="voltage" id="voltage" value="<?=$get_unit->voltage?>"></td>
		</tr>

		<tr>
			<td>MVA<span style="color:red;">*</span>:</td>
			<td><input type="number" name="mva" id="mva" value="<?=$get_unit->mva?>"></td>
		</tr>
		<tr>
			<td>High Side<span style="color:red;">*</span>:</td>
			<td><input type="text" name="high_side" id="high_side" value="<?=$get_unit->high_side?>"></td>
		</tr>
		<tr>
			<td>Low Side<span style="color:red;">*</span>:</td>
			<td><input type="text" name="low_side" id="low_side" value="<?=$get_unit->low_side?>"></td>
		</tr>
		<tr>
			<td>Unit#<span style="color:red;">*</span>:</td>
			<td><input type="hidden" id="selected_imei" name="selected_imei" value="<?=$get_unit->DeviceImei?>"></input>
				<input type="text" name="unit" id="es_unit" placeholder="Select Unit# from list" value="<?=$get_unit->unit?>" readonly>
			</td>
		</tr>
		<?
		$result = mysql_query("select roletable.*,setting.trip_sheet_note from roletable left join setting on setting.username = roletable.username where setting.role = 'schedule_admin'");
		$user = mysql_fetch_array($result);
					 ?>
		<tr>
			<td>Schedule Company :</td>
			<td><input value="<?=strtoupper($user['adminuser'])?>" readonly></td>
		</tr>
		<tr>
			<td>Gpc Contact Name :</td>
			<td><input value="<?=ucwords($user['name'])?>" readonly></td>
		</tr>
		<tr>
			<td>Gpc Contact Email :</td>
			<td><input name ="emailid" value="<?=$user['trip_sheet_note']?>"  readonly></td>
		</tr>
		<tr>
			<td>Associated Unit# :</td>
			<td><input type="text" name="assocunit" id="assocunit" placeholder="Associated Units" ></td>
		</tr>
		<tr>
			<td>High Side Description :</td>
			<td><textarea name="hs_desc" ></textarea></td>
		</tr>
		<tr>
			<td>Low Side Description :</td>
			<td><textarea name="ls_desc" ></textarea></td>
		</tr>
		<tr align="left">
			<td>Need Trailer Battery :</td>
			<td>
				<input type="radio" name="need_trail_bat" value="1"> Yes 
				<input type="radio" name="need_trail_bat" value="0" checked> No 
			</td>
		</tr>
		<tr align="left">
			<td>Need Cables :</td>
			<td>
				<input type="radio" name="need_cables" value="1"> Yes 
				<input type="radio" name="need_cables" value="0" checked> No 
			</td>
		</tr>
		<tr align="left">
			<td>Need additional battery :</td>
			<td>
				<input type="radio" name="need_add_bat" value="1"> Yes 
				<input type="radio" name="need_add_bat" value="0" checked> No 
			</td>
		</tr>
		<tr align="left">
			<td>WorkOrder# :</td>
			<td><input id="HH_StompWoNum" name="HH_StompWoNum" ></td>
		</tr>
		<tr align="left">
			<td>Account# :</td>
			<td><input id="HH_AccountNum" name="HH_AccountNum" ></td>
		</tr>

		<tr><td>Schedule Comments :</td><td><textarea name="comment" ></textarea></td></tr>

		<tr>
			<th colspan='2'><center>
				<input type="button" id="add_sch2" value="Add Schedule" > 
				<!-- <input type="button" value="Back" onclick="$('#schedule_month').load('schedule_motel_web.php');"> --></center>
			</th>
		</tr>

		<?//}?>
    </table></b>
    <br>
		   <div id="unit_table">
           </div>
		

</form></center>

<script>
$("#start_date,#end_date").on('input', function() {
	if(($("#start_date").val()!='') && ($("#end_date").val())){
		var start = new Date($("#start_date").val());
		var end = new Date($("#end_date").val());
		var diff = new Date(end - start);
		var days = diff/1000/60/60/24;
		if(days<0){
			alert("End date must be greater then start date");
		}else{
			//$("#error").show();
			$.post( "tmc_motel.php",{ start_date: $("#start_date").val(), end_date: $("#end_date").val(), unit: $("#es_unit").val() },function(data) {
				//alert(data);
				//$("#unit_table").html('');
				//$("#unit_table").html(data);
				/*if(data==0){
					alert('tt');
				$("#start_date").val('');
				$("#end_date").val('');
                 }*/
                 /*if(data!=1){
                 alert(data);
				$("#start_date").val('');
				$("#end_date").val('');	
                 }*/

				/*$("#unit").val('');
				$("#voltage").val('');
				$("#mva").val('');
				$("#high_side").val('');
				$("#low_side").val('');
				$("#assocunit").val('');
				$("#selected_imei").val('');*/
				$("#error").hide();

			});
		}
	}
});

$("#add_sch2").on('click', function() { 
		if($("#start_date").val()=='' || $("#end_date").val()==''){
			alert("Please select schedule start date and end date");
			return false;
		}
		else if($("#loc_need").val()==''){
			alert("Please fill requested location");
			return false;
		}
		/*else if($("#selected_imei").val()==''){
			alert("Please Select unit from available equipment list");
			return false;
		}*/
		else{
			
			$.ajax({
				type : 'POST',
				url : 'Equipment Abbreviated Schedule.php',
				data : $('#new_eqp').serialize(),
				success : function(data) { 
					//alert(data);
							$("#schedule_abbr").empty();
							$("#schedule_abbr").html(data);
							$('#h_sch').show();
							$("#loading_indicator").hide();
							/*$("#schedule_month").load("schedule_motel_web.php");*/
						}
			});
		}
});

</script>
