<?php
		  session_start();
		  //error_reporting(0);

	 include_once('connect.php');
	include_once('substationjson.php');
?>
<!--<script type="text/javascript" src="jquery-1.4.1.min.js"></script>
<script type="text/javascript" src="js/drop.js"></script>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="//cdn.jsdelivr.net/webshim/1.14.5/polyfiller.js"></script>
<script>
webshims.setOptions('forms-ext', {types: 'date'});
webshims.polyfill('forms forms-ext');
</script>-->
<script>
function close_edit_sch() { 
	//var month = $.datepicker.formatDate('mm', new Date($("#from_date_sch").val()));
	//var year = $.datepicker.formatDate('yy', new Date($("#from_date_sch").val()));
	$("#error").show();
	$.post( "schedule_month.php",{ },function(data) {
		$("#schedule_month").empty();
		$("#schedule_month").html(data);
		});
}
$("#equip_type_sch").on('change', function() {
var equip_type = $("#equip_type_sch").val();
		$.post( "get_eqp_trip.php",{ equip_type: equip_type },function(data) {
		$("#browsers_sch").empty();
		$("#veh_name_sch").val("");
		$("#browsers_sch").html(data);
		$("#veh_name_hidden_sch").val("");	
		});	
});
function status_reason(){
	var status = $("#sch_status").val();
	if(status == 'Deny' || status == 'Delete' ){
		$("#d_reason").show();
	}else{
		$("#d_reason").hide();
	}
}
/*$(function() {
$( "#from_date_sch,#end_date_sch" ).datepicker();
});*/
</script>

<? if($_REQUEST['edit_id']!=''){
		$result = mysql_query("select substation_more.id as fac_id,eqp_schedule.* from eqp_schedule left join substation_more on substation_more.name = eqp_schedule.loc_need where eqp_schedule.id= '".$_REQUEST['edit_id']."'");
			$schedule = mysql_fetch_array($result);
	}

	$result = mysql_query("select trim(DeviceName) as 'DeviceName',DeviceType,DeviceIMEI,unit from devicedetails where username = 'gpc' and DeviceIMEI = '".$schedule['eqp_imei']."'");
	 $row = mysql_fetch_array($result);
	 $result = mysql_query("select * from roletable where username = '".$schedule['username']."'");
	 $user = mysql_fetch_array($result);
	?>
	 <button onclick="sch_back();" style="float:left;">Back</button>
	 <form id='sch_edit'>
	 <input type="hidden" value="<?=$_REQUEST['edit_id']?>" name="edit_sch_id" >
	 <input type="hidden" value="<?=$schedule['contact_name']?>" name="contact_name" >
	 <input type='hidden' name='type' value='edit_sch' >
	 <center><h2 style="  margin-right: 4vw;">Edit Schedule</h2></center>
<table border="0" style="border-spacing: 15px; ">
<caption></caption>

	<tr><td>From Date <span style="color:red;">*</span>:</td><td><input type="date" name="start_date" id="from_date_sch" value="<?=$schedule['start_date']?>" min="<?=date('Y-m-d')?>" /></td></tr>
	<tr align="left"><td>To Date <span style="color:red;">*</span>:</td><td><input type="date" name="end_date" id="end_date_sch" value="<?=$schedule['end_date']?>" min="<?=date('Y-m-d')?>" /></td></tr>
	<tr id="eds_error" style="color:red; display:none;"><th colspan='2'>Please wait while geting available unit for given date.</th></tr>
	<tr align="left"><td>Pickup Date :</td><td><input type="date" name="pickup_date" id="pickup_date" value="<?=$schedule['pickup_date']?>" /></td></tr>
	<tr align="left"><td>Delivery Date :</td><td><input type="date" name="del_date" id="del_date" value="<?=$schedule['del_date']?>" /></td></tr>
	<tr align="left"><td>Location Needed <span style="color:red;">*</span>:</td><td><input id="veh_name_sch" list='poi_list' name="loc_need" value="<?=$schedule['loc_need']?>" /></td></tr>	
	<datalist id="poi_list" ><?=$substation_dl?></datalist>
	<tr align="left"><td>Schedule for <span style="color:red;">*</span>:</td><td><select name = "schedule_for" id = "schedule_for" ><option <? if($schedule['sch_for']=='On site work'){ echo "selected"; } ?> >On site work</option>
	<option <? if($schedule['sch_for']=='Equipment Servicing'){ echo "selected"; } ?> >Equipment Servicing</option>
	<option <? if($schedule['sch_for']=='Emergency'){ echo "selected"; } ?> >Emergency </option></select></td></tr></td></tr>
	<tr align="left"><td>Status :</td><td>
			 <select id="sch_status" name="sch_status" onclick = 'status_reason()' <? /*if($schedule['status']=='Approved'){ echo "disabled"; }*/ ?>>
			 <option <? if($schedule['status']=='Pending'){ echo "selected"; } ?>>Pending</option>
			  <option <? if($schedule['status']=='Approved'){ echo "selected"; } ?>>Approved</option>
			 <option <? if($schedule['status']=='Deny'){ echo "selected"; } ?>>Deny</option>
			 <option <? if($schedule['status']=='Delete'){ echo "selected"; } ?>>Delete</option>
			 <option <? if($schedule['status']=='Completed'){ echo "selected"; } ?>>Completed</option>
			</select></td></tr>
	<tr align="left"><td>Voltage :</td><td><input id='voltage' name="voltage" value="<?=$schedule['voltage']?>" ></td></tr>
	<tr align="left"><td>MVA :</td><td><input id='mva' name="mva" value="<?=$schedule['mva']?>" ></td></tr>
	<tr align="left"><td>High Side :</td><td><input id='high_side' name="high_side" value="<?=$schedule['high_side']?>" ></td></tr>
	<tr align="left"><td>Low Side :</td><td><input id='low_side' name="low_side" value="<?=$schedule['low_side']?>" ></td></tr>
	<tr align="left"><td>Unit # :</td><td><input type="hidden" id="selected_imei" name="selected_imei" value="<?=$schedule['eqp_imei']?>"></input><input id="es_unit" name="unit" value="<?=$schedule['unit']?>" /></td></tr>
	<tr align="left"><td>Schedule Company :</td><td><input name="adminuser" id="" value="<?=$user['adminuser']?>" /></td></tr>
	<tr align="left"><td>Gpc Contact Name :</td><td><input name="req_name" id="req_name" value="<?=$user['name']?>" /></td></tr>
	<tr align="left"><td>Gpc Contact Email :</td><td><input name="emailid" id="req_email" value="<?=$user['emailid']?>" /></td></tr>
	<tr align="left"><td>Associated Units :</td><td><input id="assoc_unit" name='assoc_unit' value="<?=$schedule['assoc_unit']?>" ></td></tr>
	<tr align="left"><td>High Side Description :</td><td><textarea name="hs_desc" ><?=$schedule['hs_desc']?></textarea></td></tr>
	<tr align="left"><td>Low Side Description :</td><td><textarea name="ls_desc" ><?=$schedule['ls_desc']?></textarea></td></tr>
	<tr align="left"><td>Need Trailer Battery :</td><td><input type="radio" name="need_trail_bat" value="1" <? if($schedule['need_trail_bat']=='1'){ echo "checked"; } ?>> Yes 
	<input type="radio" name="need_trail_bat" value="0" <? if($schedule['need_trail_bat']=='0'){ echo "checked"; } ?>> No </td></tr>
	<tr align="left"><td>Need Cables :</td><td><input type="radio" name="need_cables" value="1" <? if($schedule['need_cables']=='1'){ echo "checked"; } ?>> Yes <input type="radio" name="need_cables" value="0" <? if($schedule['need_cables']=='0'){ echo "checked"; } ?>> No </td></tr>
	<tr align="left"><td>Need additional battery :</td><td><input type="radio" name="need_add_bat" value="1" <? if($schedule['need_add_bat']=='1'){ echo "checked"; } ?> > Yes <input type="radio" name="need_add_bat" value="0" <? if($schedule['need_add_bat']=='0'){ echo "checked"; } ?> > No </td></tr>
	<tr align="left"><td>WorkOrder# :</td><td><input id="HH_StompWoNum" name="HH_StompWoNum" value="<?=$schedule['HH_StompWoNum']?>" ></td></tr>
	<tr align="left"><td>Account# :</td><td><input id="HH_AccountNum" name="HH_AccountNum" value="<?=$schedule['HH_AccountNum']?>" ></td></tr>
	<tr align="left"><td>Schedule Comments :</td><td><textarea name="comment" id="comment" ><?=$schedule['comment']?></textarea></td></tr>

<tr><th colspan='2'><center><input type="button" id="save_sch_btn" value="Save Schedule" /> <input type="button" onclick="close_edit_sch();" value="Back" /></center></td></tr>
<tr><th colspan='2'><span id="error" style="color:red; display:none;">Please wait while your request is processed.</span></td></tr>
</table>
<center>
<div id="unit_table"></div>
</center>
</form>
<script>

$("#from_date_sch,#end_date_sch").on('input', function() {
	if(($("#from_date_sch").val()!='') && ($("#end_date_sch").val())){
		var start = new Date($("#from_date_sch").val());
		var end = new Date($("#end_date_sch").val());
		var diff = new Date(end - start);
		var days = diff/1000/60/60/24;
		if(days<0){
			alert("End date must be greater then start date");
		}else{
			$("#eds_error").show();
			$.post( "tmc_schedulable_unit_ajax.php",{ start_date: $("#from_date_sch").val(), end_date: $("#end_date_sch").val() },function(data) {
				$("#unit_table").html('');
				$("#unit_table").html(data);
				$("#unit").val('');
				$("#voltage").val('');
				$("#mva").val('');
				$("#high_side").val('');
				$("#low_side").val('');
				$("#assocunit").val('');
				$("#selected_imei").val('');
				$("#eds_error").hide();
			});
		}
	}
});
function select_unit_imei(imei_new){
   $.post( "tmc_dev_details.php",{ imei: imei_new },function(data) {
		var obj = jQuery.parseJSON( data );
		$("#es_unit").val(obj.unit);
		$("#voltage").val(obj.voltage);
		$("#mva").val(obj.mva);
		$("#high_side").val(obj.high_side);
		$("#low_side").val(obj.low_side);
		$("#assoc_unit").val(obj.assoc_unit1+' '+obj.assoc_unit2+' '+obj.assoc_unit3);
		$("#selected_imei").val(imei_new);
	});
}
$("#save_sch_btn").on('click', function() { 
	
	if($("#veh_name_sch").val()!=''){
		$("#error").show();
		//alert($('#sch_edit').serialize());
			/*$.post( "schedule_month.php",{type: $("#type").val(),edit_sch_id: $("#edit_sch_id").val(),unit: $("#unit").val(),assoc_unit: $("#assoc_unit").val(),start_date: $("#from_date_sch").val(),end_date: $("#end_date_sch").val(),req_email: $("#req_email").val() ,loc_need: $("#veh_name_sch").val(),sch_status: $("#sch_status").val(),comment: $("#comment").val(),HH_StompWoNum: $("#HH_StompWoNum").val(),HH_AccountNum: $("#HH_AccountNum").val(),HH_NoticeSentToHH: $("#HH_NoticeSentToHH").val(),HH_BillingComplete: $("#HH_BillingComplete").val(),HH_DeliverDate: $("#HH_DeliverDate").val(),HH_PickupDate: $("#HH_PickupDate").val(),HH_Comments: $("#HH_Comments").val() ,deny_delete_reason: $("#deny_delete_reason").val() ,HH_GtcToInstall: $("#HH_GtcToInstall").val() },function(data) {
				$("#schedule_month").empty();
				$("#schedule_month").html(data);
			});*/
			$.ajax({
				type : 'POST',
				url : 'schedule_month.php',
				data : $('#sch_edit').serialize(),
				success : function(data) {
							$("#schedule_month").empty();
							$("#schedule_month").html(data);
						}
			});
		}else{
			alert('Please select Euipment #');
		}
});
status_reason();
/*$("#equip_type_sch").on('change', function() {
var equip_type = $("#equip_type_sch").val();
		$.post( "get_eqp_trip.php",{ equip_type: equip_type },function(data) {
		$("#browsers_sch").empty();
		$("#veh_name_sch").val("");
		$("#browsers_sch").html(data);
		$("#veh_name_hidden_sch").val('');
		});	
});

$("#veh_name_sch").on('input', function() {
		var data = {};
		$("#browsers_sch option").each(function(i,el) {  
				   data[$(el).data("value")] = $(el).val();
		});
		console.log(data, $("#browsers_sch option").val());
		var value = $('#veh_name_sch').val();
		if(typeof ($('#browsers_sch [value="' + value + '"]').data('value')) === "undefined")
		{
					$("#veh_name_hidden_sch").val('');
		}
		else
		{
			var v_imei = ($('#browsers_sch [value="' + value + '"]').data('value'));
			$("#veh_name_hidden_sch").val(v_imei);
		}

});*/


</script>
