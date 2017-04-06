
<?php
//print_r($_POST['unit']);
	session_start();
	include_once('connect.php');
	include_once('substationjson.php');
?>


<script>

function close_edit_sch() { 
	//var month = $.datepicker.formatDate('mm', new Date($("#from_date_sch").val()));
	//var year = $.datepicker.formatDate('yy', new Date($("#from_date_sch").val()));
	$("#error").show();
	$('#sch_view_div').hide();
	$('#schedule_abbr').show();
	$("#error").hide();
/*	$.post( "schedule_month.php",{ },function(data) {
		$("#schedule_month").empty();
		$("#schedule_month").html(data);
		});*/
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

</script>

<? if($_REQUEST['edit_id']!=''){
		$result = mysql_query("select substation_more.id as fac_id,eqp_schedule.* from eqp_schedule left join substation_more on substation_more.name = eqp_schedule.loc_need where eqp_schedule.id= '".$_REQUEST['edit_id']."'");
			$schedule = mysql_fetch_array($result);
	}

	$result = mysql_query("select trim(DeviceName) as 'DeviceName',DeviceType,DeviceIMEI,unit from devicedetails where username = 'gpc' and DeviceIMEI = '".$schedule['eqp_imei']."'");
	 $row = mysql_fetch_array($result);
	 /*$result = mysql_query("select * from roletable where username = '".$schedule['username']."'");
	 $user = mysql_fetch_array($result);*/
	?>
	 <button onclick="close_edit_sch();" style="float:left;">Back</button>
	 <form id='sch_edit' enctype="multipart/form-data">
	 <input type="hidden" value="<?=$_REQUEST['edit_id']?>" id="edit_sch_id" name="edit_sch_id" >
	 <input type="hidden" value="<?=$schedule['contact_name']?>" name="contact_name" >
	 <input type='hidden' name='type' value='edit_sch' >
	 <center><h2 style="  margin-right: 4vw;">Edit Schedule</h2></center>
	 <div id="instruction_data" style="color:red;width: 55vw;text-align: left;display:none;line-height: 3.2vh;">* Per ITS guidelines, mobile reservation/use is limited to up to 4 weeks without further review and approval. Due to the length of this request, please provide a more detailed description of the work to be done that requires this mobile to be on site for this extended time. Please consider alternatives that may make it possible to shorten the time frame to no more than 4 weeks instead.<br/><br/>If not, please provide the following information:<br/><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Details of project one line diagram if possible.<br/><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hours planned to work to reduce mobile installation time.<br/><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Other details you feel may be necessary for an approval.<br/><br/>
Walt Hamilton or Jody Benefield will review and, if necessary, present this to the ITS Participants when they next meet. Once a decision is made, the request will be approved or declined accordingly.<br/><br/>
Thank you!</div>
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
			 <option <? if($schedule['status']=='In Review'){ echo "selected"; } ?>>In Review</option>
			</select></td></tr>
	<tr><td>Contact Name:</td><td><input type="text" id="cont_name" name="contactname" value="<?=$schedule['contactname']?>" ></td></tr>
    <tr><td>Contact Office:</td><td><input type="text" id="contact_off" name="contact_off" value="<?=$schedule['contact_off']?>" ></td></tr>
    <tr><td>Contact Mobile:</td><td><input type="text" id="contact_mobile" name="contact_mobile" value="<?=$schedule['contact_mobile']?>" ></td></tr>
    <tr><td>Contact Linc:</td><td><input type="text" id="contact_linc" name="contact_linc" value="<?=$schedule['contact_linc']?>" ></td></tr>
    <tr><td>Contact Email:</td><td><input type="text" id="contact_email" name="contact_email" value="<?=$schedule['contact_email']?>" ></td></tr>		
	<tr align="left"><td>Voltage :</td><td><input id='voltage' name="voltage" value="<?=$schedule['voltage']?>" readonly></td></tr>
	<tr align="left"><td>MVA :</td><td><input id='mva' name="mva" value="<?=$schedule['mva']?>" readonly></td></tr>
	<tr align="left"><td>High Side :</td><td><input id='high_side' name="high_side" value="<?=$schedule['high_side']?>" readonly></td></tr>
	<tr align="left"><td>Low Side :</td><td><input id='low_side' name="low_side" value="<?=$schedule['low_side']?>" readonly></td></tr>
	<tr align="left"><td>Unit # :</td><td><input type="hidden" id="selected_imei" name="selected_imei" value="<?=$schedule['eqp_imei']?>"></input><input id="es_unit" name="unit" value="<?=$schedule['unit']?>" style="width: 5vw;" readonly/>&nbsp;<input type="button" onclick="get_eqp_list()" value="Change Unit" id="change_unit"><img src='image/spinner.gif' id="change_unit_spin" width='20px' style="display: none;"></td></tr>
	<tr><td colspan="1"></td><td  style="padding: 0.5vh;"><input type="checkbox"  name="check_assoc" id="check_assoc" onchange="showhide_assoc(this.checked)" checked> Associated Unit</td></tr>
	<tr id="asc_row" align="left"><td>Associated Units# :</td><td><input id="assoc_unit" name='assoc_unit' value="<?=$schedule['assoc_unit']?>" ><input type="hidden" id="hidd_assoc" value="<?=$schedule['assoc_unit']?>"></td></tr>
	
	<?
		$result = mysql_query("select roletable.*,setting.trip_sheet_note from roletable left join setting on setting.username = roletable.username where setting.role = 'schedule_admin'");
		$user = mysql_fetch_array($result);
	?>
	<tr align="left"><td>Schedule Company :</td><td><input name="adminuser" id="" value="<?=strtoupper($user['adminuser'])?>" /></td></tr>
	<tr align="left"><td>Gpc Contact Name :</td><td><input name="req_name" id="req_name" value="<?=ucwords($user['name'])?>" /></td></tr>
	<tr align="left"><td>Gpc Contact Email :</td><td><input name="emailid" id="req_email" value="<?=$user['trip_sheet_note']?>" /></td></tr>
	<tr align="left"><td>High Side Description :</td><td><textarea name="hs_desc" ><?=$schedule['hs_desc']?></textarea></td></tr>
	<tr align="left"><td>Low Side Description :</td><td><textarea name="ls_desc" ><?=$schedule['ls_desc']?></textarea></td></tr>
	<tr align="left"><td>Need Trailer Battery :</td><td><input type="radio" name="need_trail_bat" value="1" <? if($schedule['need_trail_bat']=='1'){ echo "checked"; } ?>> Yes 
	<input type="radio" name="need_trail_bat" value="0" <? if($schedule['need_trail_bat']=='0'){ echo "checked"; } ?>> No </td></tr>
	<tr align="left"><td>Need Cables :</td><td><input type="radio" name="need_cables" value="1" <? if($schedule['need_cables']=='1'){ echo "checked"; } ?>> Yes <input type="radio" name="need_cables" value="0" <? if($schedule['need_cables']=='0'){ echo "checked"; } ?>> No </td></tr>
	<tr align="left"><td>Need additional battery :</td><td><input type="radio" name="need_add_bat" value="1" <? if($schedule['need_add_bat']=='1'){ echo "checked"; } ?> > Yes <input type="radio" name="need_add_bat" value="0" <? if($schedule['need_add_bat']=='0'){ echo "checked"; } ?> > No </td></tr>
	<tr align="left"><td>WorkOrder# :</td><td><input id="HH_StompWoNum" name="HH_StompWoNum" value="<?=$schedule['HH_StompWoNum']?>" ></td></tr>
	<tr align="left"><td>Account# :</td><td><input id="HH_AccountNum" name="HH_AccountNum" value="<?=$schedule['HH_AccountNum']?>" ></td></tr>
	<tr align="left"><td>Upload Document :</td><td><input id="upload_document" name="upload_document[]" type="file" multiple/></td></tr>
	<tr><td colspan="1"></td><td><span style="color:red;">* Select Multiple Files Simultaneously </span></td></tr>
	<tr align="left"><td>Schedule Comments :</td><td><textarea name="comment" id="comment" ><?=$schedule['comment']?></textarea></td></tr>

<tr><th colspan='2'><center><input type="button" id="save_sch_btn" value="Save Schedule" /> <input type="button" onclick="close_edit_sch();" value="Back" /></center></td></tr>
<tr><th colspan='2'><span id="error" style="color:red; display:none;">Please wait while your request is processed.</span></td></tr>
</table>
<script>
$('#upload_document').change(function(){
    if(this.files.length>3){
        alert("You can't upload more than three files");
        $('#upload_document').val('');
    }
});
</script>
<center>
<div id="unit_table"></div>
</center>
</form>
<script>
function showhide_assoc(status){
	
	if(status){
		var hid_val = $('#hidd_assoc').val();
		$("#assoc_unit").val(hid_val);
		$('#asc_row').show();
	}else{
		$('#asc_row').hide();
		$('#assoc_unit').val();
	}
}

function get_eqp_list(){

			$("#change_unit_spin").show();
			$.post( "tmc_schedulable_unit_ajax.php",{ start_date: $("#from_date_sch").val(), end_date: $("#end_date_sch").val() },function(data) {
				$("#unit_table").html('');
				$("#unit_table").html(data);
				$("#change_unit_spin").hide();
			});
}

$("#from_date_sch,#end_date_sch").on('input', function() {
	if(($("#from_date_sch").val()!='') && ($("#end_date_sch").val())){
		var start = new Date($("#from_date_sch").val());
		var end = new Date($("#end_date_sch").val());
		var diff = new Date(end - start);
		var days = diff/1000/60/60/24;
		if(days<0){
			alert("End date must be greater then start date");
		}else{
			if (days >30){
				$('#instruction_data').show();
			}else{
				$('#instruction_data').hide();
			}
			$("#eds_error").show();
			$.post( "tmc_schedulable_unit_ajax.php",{ start_date: $("#from_date_sch").val(), end_date: $("#end_date_sch").val(),eqp_id:$("#edit_sch_id").val() },function(data) {
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
		$("#hidd_assoc").val(obj.assoc_unit1+' '+obj.assoc_unit2+' '+obj.assoc_unit3);
		$("#selected_imei").val(imei_new);
		if(obj.unit == '5'){
			var asc_unit = 25;
		}else if(obj.unit == '6'){
			var asc_unit = 26;
		}else if(obj.unit == '7'){
			var asc_unit = 21;
		}
		if(obj.unit == '5' || obj.unit == '6' || obj.unit == '7'){
			$('#assoc_unit').val(asc_unit);
			$('#assoc_unit').prop('readonly',true);
			$('#asc_row').show();
			$('#check_assoc').prop('checked',true);
			$('#check_assoc').prop('disabled',true);
		}else{
			$('#assoc_unit').prop('readonly',false);
			$('#check_assoc').prop('disabled',false);
		}
	});
}


		
$("#save_sch_btn").on('click', function() { 
	
		if($("#from_date_sch").val()=='' || $("#end_date_sch").val()==''){
				alert("Please select schedule start date and end date");
				return false;
		}
		else if($("#veh_name_sch").val()==''){
				alert("Please fill requested location");
				return false;
		}
		else if($("#selected_imei").val()==''){
				alert("Please Select unit from available equipment list");
				return false;
		}else if($("#check_assoc").prop('checked') && ($('#assoc_unit').val().trim() == '' )){
				alert("Please fill associated unit");
				return false;
		}
		else{ 
				send_edit_data();
		}
});

	
	function send_edit_data(){

			$("#error").show();
			var formData = new FormData($('form#sch_edit')[0]);
			
			var other_data = $('#sch_edit').serializeArray();
			$.each(other_data,function(key,input){
			        formData.append(input.name,input.value);
			});

			$.ajax({
				type : 'POST',
				url : 'schedule_month.php',
				data : formData,
				async: false,
				cache: false,
				contentType: false,
				processData: false,
				success : function(data) { 
							alert("Schedule Successfully Updated");
							$('#new_sch').hide();
					   		$('#sch_view_div').hide();
					   		$('#schedule_abbr').show();
						}
				
			});
		}
status_reason();

</script>
