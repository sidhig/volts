<?php
		  session_start();
		  error_reporting(0);
	 include_once('connect.php'); 
	include_once('substationjson.php');
?>
<!--<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script type="text/javascript" src="js/drop.js"></script>
<script src="//cdn.jsdelivr.net/webshim/1.14.5/polyfiller.js"></script>
<script>
webshims.setOptions('forms-ext', {types: 'date'});
webshims.polyfill('forms forms-ext');
/*$(function() {
$( "#start_date,#end_date" ).datepicker();
});*/
</script>
<link href="css/jquery-ui-1.10.0.custom.css" rel="stylesheet">
 
 <script src="js/modernizr.js">
 <script>
 Modernizr.load({
  test: Modernizr.inputtypes.date,
  nope: "js/jquery-ui.custom.js",
  callback: function() {
    $("input[type=date]").datepicker();
  }
   });
 </script>-->
 
<center><form id="new_eqp_sch"  ><h2>New Schedule</h2>
<table border="0" style="border-spacing: 15px; ">
<input type="hidden" name="schedule" value="new" >
<b>
<tr><td>From Date<span style="color:red;">*</span>:</td><td><input type="date" id="start_date" name="start_date" value="" min="<?=date('Y-m-d')?>"></td></tr>
<tr><td>To Date<span style="color:red;">*</span>:</td><td><input type="date" id="end_date" name="end_date" value="" min="<?=date('Y-m-d')?>"></td></tr>
<tr><th colspan='2'><span id="error" style="color:red; display:none;">Please wait while geting available unit for given date.</span></th></tr>
<tr><td>Location Needed<span style="color:red;">*</span>:</td><td>
<datalist id="poi_list" ><?=ltrim($substation_dl,"<option data-value='' value='Address' >")?></datalist><input list='poi_list' type="text" name="loc_need" id="loc_need" value=""></td></tr>
<tr><td>Schedule for <span style="color:red;">*</span>:</td><td><select name = "schedule_for" id = "schedule_for" ><option>On site work</option>
<option>Equipment Servicing</option>
<option>Emergency </option></select></td></tr></td></tr>
<tr><td>Voltage<span style="color:red;">*</span>:</td><td><input type="text" name="voltage" id="voltage" value=""></td></tr>

<tr><td>MVA<span style="color:red;">*</span>:</td><td><input type="number" name="mva" id="mva" value=""></td></tr>
<tr><td>High Side<span style="color:red;">*</span>:</td><td><input type="text" name="high_side" id="high_side" value=""></td></tr>
<tr><td>Low Side<span style="color:red;">*</span>:</td><td><input type="text" name="low_side" id="low_side" value=""></td></tr>
<tr><td>Unit#<span style="color:red;">*</span>:</td><td><input type="hidden" id="selected_imei" name="selected_imei"></input><input type="text" name="unit" id="es_unit" placeholder="Select Unit# from list" value="" readonly></td></tr>
<?
$result = mysql_query("select roletable.*,setting.trip_sheet_note from roletable left join setting on setting.username = roletable.username where setting.username = '".$_SESSION['LOGIN_user']."'");
$user = mysql_fetch_array($result);
			 ?>
<tr><td>Schedule Company :</td><td><input value="<?=strtoupper($user['adminuser'])?>" readonly></td></tr>
<tr><td>Gpc Contact Name :</td><td><input value="<?=ucwords($user['name'])?>" readonly></td></tr>
<tr><td>Gpc Contact Email :</td><td><input name ="emailid" value="<?=$user['trip_sheet_note']?>"  readonly></td></tr>
<tr><td>Associated Unit# :</td><td><input type="text" name="assocunit" id="assocunit" placeholder="Associated Units" ></td></tr>
<tr><td>High Side Description :</td><td><textarea name="hs_desc" ></textarea></td></tr>
<tr><td>Low Side Description :</td><td><textarea name="ls_desc" ></textarea></td></tr>
<tr align="left"><td>Need Trailer Battery :</td><td><input type="radio" name="need_trail_bat" value="1"> Yes <input type="radio" name="need_trail_bat" value="0" checked> No </td></tr>
<tr align="left"><td>Need Cables :</td><td><input type="radio" name="need_cables" value="1"> Yes <input type="radio" name="need_cables" value="0" checked> No </td></tr>
<tr align="left"><td>Need additional battery :</td><td><input type="radio" name="need_add_bat" value="1"> Yes <input type="radio" name="need_add_bat" value="0" checked> No </td></tr>
<tr align="left"><td>WorkOrder# :</td><td><input id="HH_StompWoNum" name="HH_StompWoNum" ></td></tr>
<tr align="left"><td>Account# :</td><td><input id="HH_AccountNum" name="HH_AccountNum" ></td></tr>

<tr><td>Schedule Comments :</td><td><textarea name="comment" ></textarea></td></tr>

<tr><th colspan='2'><center><input type="button" id="add_sch1" value="Add Schedule" > <input type="button" value="Back" onclick="sch_back();"></center></th></tr>


</table></b>
<br>

<div id="unit_table"><!--
<h1>Available Equipment</h1><br>
<table width="90%" border='1'>
<tr><th>Select</th><th>Unit#</th><th>Voltage</th><th>MVA</th><th>High Side</th><th>Low Side</th><th>Associated Unit</th><th>Location</th></tr>
<tbody id="fbody">
<? error_reporting(0);
$result = mysql_query("select * from devicedetails where unit not in (select unit from eqp_schedule where unit !='' and unit is not NULL and ((eqp_schedule.start_date >= '".$_POST['start_date']."' and eqp_schedule.start_date <= '".$_POST['end_date']."') or (eqp_schedule.end_date >= '".$_POST['start_date']."' and eqp_schedule.end_date <= '".$_POST['end_date']."'))) and (devicedetails.DeviceType = 'Mobile Switch' or devicedetails.DeviceType = 'Mobile Substation')");
while($vehicle = mysql_fetch_array($result))
			 {
			 ?>
<tr>
<th><input class="imei" type="radio" name = "imei" value="<?=$vehicle['DeviceIMEI']?>"></th>
<th class = "unit_class"><?=$vehicle['unit']?></th>
<th class = "voltage"><?=$vehicle['voltage']?></th>
<th class = "mva"><?=$vehicle['mva']?></th>
<th class = "high_side"><?=$vehicle['high_side']?></th>
<th class = "low_side"><?=$vehicle['low_side']?></th>
<th class = "assocunit"><?=$vehicle['assoc_unit1']?> <?=$vehicle['assoc_unit2']?> <?=$vehicle['assoc_unit3']?></th>
<th class = 'location'>
<? 
$appuser = $_SESSION['LOGIN_user'];
			 
$data = mysql_query("select  *,IF((TIME_TO_SEC(TIMEDIFF(now(),maxdata.timestamp))/7200)>1,2,0) as timediff, (Event_data_last_view.`timestamp` -interval 0 hour) as 'timestamp' from (select MAX(Event_data_last_view.timestamp) as timestamp , Event_data_last_view.deviceid from Event_data_last_view,event_desc where Event_data_last_view.eventcode = event_desc.eventcode  and Event_data_last_view.DeviceImei  in (Select DeviceIMEI from devicedetails where UserName = 'gpc' and unit = '".$vehicle['unit']."' group by DeviceIMEI) group by Event_data_last_view.deviceid) as maxdata, Event_data_last_view,event_desc where Event_data_last_view.timestamp = maxdata.timestamp and Event_data_last_view.eventcode = event_desc.eventcode and maxdata.deviceid = Event_data_last_view.deviceid and CASE WHEN (select dept  as eqpval  from roletable where username = '".$appuser."') = 'All' THEN 1 ELSE (select dept from roletable where username = '".$appuser."') like CONCAT('%', department, '%')  END and  CASE WHEN (select `group`  as eqpval  from roletable where username = '".$appuser."') = 'All' THEN 1 ELSE (select `group` from roletable where username = '".$appuser."') like CONCAT('%', `Groupname`, '%')  END and CASE WHEN (select `eqp`  as eqpval  from roletable where username = '".$appuser."') = 'All' THEN 1 ELSE (select `eqp` from roletable where username = '".$appuser."') like CONCAT('%', `DeviceType`, '%')  END group by Event_data_last_view.deviceid order by Event_data_last_view.deviceid");
$r = mysql_fetch_assoc($data);
		$trip_qry = mysql_fetch_assoc(mysql_query("SELECT lower(name) AS 'POI',(((acos(sin((".$r['lati']."*pi()/180)) * sin((lati*pi()/180))+cos((".$r['lati']."*pi()/180)) * cos((lati*pi()/180)) * cos(((".$r['longi']."- longi)*pi()/180))))*180/pi())*60*1.1515) as distance,time_sheet FROM `substation_more` left join (select time_sheet,veh_no from trip_sheet where veh_no = '".$r['DeviceImei']."' order by `id` DESC limit 1) as tp on '".$r['DeviceImei']."' = tp.veh_no  order by distance limit 1")); 

?><?=$trip_qry['POI'];?>

</th>
</tr>

			 <? } ?>
</tbody>
</table>-->

</div>

</form></center>
<script>
/*function filter_list(){
	//var data1 = $("#loc_need").val().toLowerCase();
	var data2 = $("#voltage").val().toLowerCase();
	var data3 = $("#mva").val().toLowerCase();
	var data4 = $("#high_side").val().toLowerCase();
	var data5 = $("#low_side").val().toLowerCase();
    var jo = $("#fbody").find("tr");
	//alert(data2);
    jo.hide();
   //Recusively filter the jquery object to get results.
   jo.filter(function (i, v) {
        var $t = $(this);
            if (($t.is(":contains('" + data2 + "')"))&&($t.is(":contains('" + data3 + "')"))&&($t.is(":contains('" + data4 + "')"))&&($t.is(":contains('" + data5 + "')"))) {
                return true;
            }
        return false;
    }).show();
}
$(":input").bind('keyup mouseup', function () {
    filter_list();          
})
$("#voltage,#high_side,#low_side").on('input', function() {
	filter_list();
});*/
$("#start_date,#end_date").on('input', function() {
	if(($("#start_date").val()!='') && ($("#end_date").val())){
		var start = new Date($("#start_date").val());
		var end = new Date($("#end_date").val());
		var diff = new Date(end - start);
		var days = diff/1000/60/60/24;
		if(days<0){
			alert("End date must be greater then start date");
		}else{
			$("#error").show();
			$.post( "tmc_schedulable_unit_ajax.php",{ start_date: $("#start_date").val(), end_date: $("#end_date").val() },function(data) {
				$("#unit_table").html('');
				$("#unit_table").html(data);
				$("#unit").val('');
				$("#voltage").val('');
				$("#mva").val('');
				$("#high_side").val('');
				$("#low_side").val('');
				$("#assocunit").val('');
				$("#selected_imei").val('');
				$("#error").hide();
			});
		}
	}
});


</script>
<!--<script type="text/javascript" src="js/jquery-1.9.1.js"></script>-->
<script>
$("#fbody input[name='imei']").click(function(){
   alert($('input:radio[name=imei]:checked').val());
	var data1 = $('input:radio[name=imei]:checked').val().toLowerCase();
    var $row = $(this).closest("tr");
	$("#es_unit").val($row.find(".unit_class").text());
	$("#voltage").val($row.find(".voltage").text());
	$("#mva").val($row.find(".mva").text());
	$("#high_side").val($row.find(".high_side").text());
	$("#low_side").val($row.find(".low_side").text());
	$("#assocunit").val($row.find(".assocunit").text());
	$("#selected_imei").val($('input:radio[name=imei]:checked').val());
});
function select_unit_imei(imei_new){
   $.post( "tmc_dev_details.php",{ imei: imei_new },function(data) {
		var obj = jQuery.parseJSON( data );
		$("#es_unit").val(obj.unit);
		$("#voltage").val(obj.voltage);
		$("#mva").val(obj.mva);
		$("#high_side").val(obj.high_side);
		$("#low_side").val(obj.low_side);
		$("#assocunit").val(obj.assoc_unit1+' '+obj.assoc_unit2+' '+obj.assoc_unit3);
		$("#selected_imei").val(imei_new);
	});
}
</script>
<script>

$("#add_sch1").on('click', function() { 
		if($("#start_date").val()=='' || $("#end_date").val()==''){
			alert("Please select schedule start date and end date");
			return false;
		}
		else if($("#loc_need").val()==''){
			alert("Please fill requested location");
			return false;
		}
		else if($("#selected_imei").val()==''){
			alert("Please Select unit from available equipment list");
			return false;
		}
		else{
			$.ajax({
				type : 'POST',
				url : 'schedule_month.php',
				data : $('#new_eqp_sch').serialize(),
				success : function(data) { 
							$("#schedule_month").empty();
							$("#schedule_month").html(data);
						}
			});
		}
});

</script>
