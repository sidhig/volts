<?php
		  session_start();
		  error_reporting(0);
	 include_once('connect.php'); 
	include_once('substationjson.php');
?>

 <span style="float:left;"><input type="button" value="Back" onclick="sch_back();"></span>
<center>

<form id="new_eqp_sch" enctype="multipart/form-data" ><h2>New Schedule</h2>
<div id="instruc_data" style="color:red;width: 55vw;text-align: left;display:none;line-height: 3.2vh;">* Per ITS guidelines, mobile reservation/use is limited to up to 4 weeks without further review and approval. Due to the length of this request, please provide a more detailed description of the work to be done that requires this mobile to be on site for this extended time. Please consider alternatives that may make it possible to shorten the time frame to no more than 4 weeks instead.<br/><br/>If not, please provide the following information:<br/><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Details of project one line diagram if possible.<br/><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hours planned to work to reduce mobile installation time.<br/><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Other details you feel may be necessary for an approval.<br/><br/>
Walt Hamilton or Jody Benefield will review and, if necessary, present this to the ITS Participants when they next meet. Once a decision is made, the request will be approved or declined accordingly.<br/><br/>
Thank you!</div>
<table border="0" style="border-spacing: 15px; ">
<input type="hidden" name="schedule" value="new" >
<b>
<tr><td>From Date<span style="color:red;">*</span>:</td><td><input type="date" id="start_date" name="start_date" value="" min="<?=date('Y-m-d')?>"></td></tr>
<tr><td>To Date<span style="color:red;">*</span>:</td><td><input type="date" id="end_date" name="end_date" value="" min="<?=date('Y-m-d')?>"></td></tr>
<tr><th colspan='2'><span id="error" style="color:red; display:none;">Please wait while geting available unit for given date.</span></th></tr>
<tr><td>Location Needed<span style="color:red;">*</span>:</td><td>
<datalist id="poi_list" ><?=ltrim($substation_dl,"<option data-value='' value='Address' >")?></datalist><input list='poi_list' type="text" name="loc_need" id="loc_need" value=""></td></tr>
<tr><td>Contact Name:</td><td><input type="text" id="cont_name" name="contactname" value="" ></td></tr>
<tr><td>Contact Office:</td><td><input type="text" id="contact_off" name="contact_off" value="" ></td></tr>
<tr><td>Contact Mobile:</td><td><input type="text" id="contact_mobile" name="contact_mobile" value="" ></td></tr>
<tr><td>Contact Linc:</td><td><input type="text" id="contact_linc" name="contact_linc" value="" ></td></tr>
<tr><td>Contact Email:</td><td><input type="text" id="contact_email" name="contact_email" value="" ></td></tr>
<tr><td>Schedule for <span style="color:red;">*</span>:</td><td><select name = "schedule_for" id = "schedule_for" ><option>On site work</option>
<option>Equipment Servicing</option>
<option>Emergency </option></select></td></tr></td></tr>
<tr><td>Voltage<span style="color:red;">*</span>:</td><td><input type="text" name="voltage" id="voltage" value="" readonly></td></tr>

<tr><td>MVA<span style="color:red;">*</span>:</td><td><input type="number" name="mva" id="mva" value="" readonly></td></tr>
<tr><td>High Side<span style="color:red;">*</span>:</td><td><input type="text" name="high_side" id="high_side" value="" readonly></td></tr>
<tr><td>Low Side<span style="color:red;">*</span>:</td><td><input type="text" name="low_side" id="low_side" value="" readonly></td></tr>
<tr><td>Unit#<span style="color:red;">*</span>:</td><td><input type="hidden" id="selected_imei" name="selected_imei"></input><input type="text" name="unit" id="es_unit" placeholder="Select Unit# from list" value="" readonly></td><td  style="padding: 0.5vh;"></td></tr>
<tr><td colspan="1"></td><td><input type="checkbox"  name="check_assoc" id="check_assoc" onchange="show_hide_assoc(this.checked)" checked> Associated Unit</td></tr>

<tr id="assoc_row" ><td>Associated Unit# :</td><td><input type="text" name="assocunit" id="assocunit" placeholder="Associated Units" value=""><input type="hidden" id="hid_assoc"></td></tr>
<?
$result = mysql_query("select roletable.*,setting.trip_sheet_note from roletable left join setting on setting.username = roletable.username where setting.role = 'schedule_admin'");
$user = mysql_fetch_array($result);
			 ?>
<tr><td>Schedule Company :</td><td><input value="<?=strtoupper($user['adminuser'])?>" readonly></td></tr>
<tr><td>Gpc Contact Name :</td><td><input value="<?=ucwords($user['name'])?>" readonly></td></tr>
<tr><td>Gpc Contact Email :</td><td><input name ="emailid" value="<?=$user['trip_sheet_note']?>"  readonly></td></tr>
<tr><td>High Side Description :</td><td><textarea name="hs_desc" ></textarea></td></tr>
<tr><td>Low Side Description :</td><td><textarea name="ls_desc" ></textarea></td></tr>
<tr align="left"><td>Need Trailer Battery :</td><td><input type="radio" name="need_trail_bat" value="1"> Yes <input type="radio" name="need_trail_bat" value="0" checked> No </td></tr>
<tr align="left"><td>Need Cables :</td><td><input type="radio" name="need_cables" value="1"> Yes <input type="radio" name="need_cables" value="0" checked> No </td></tr>
<tr align="left"><td>Need additional battery :</td><td><input type="radio" name="need_add_bat" value="1"> Yes <input type="radio" name="need_add_bat" value="0" checked> No </td></tr>
<tr align="left"><td>WorkOrder# :</td><td><input id="HH_StompWoNum" name="HH_StompWoNum" ></td></tr>
<tr align="left"><td>Account# :</td><td><input id="HH_AccountNum" name="HH_AccountNum" ></td></tr>
<tr align="left"><td>Upload Document :</td><td><input id="upload_docs" name="upload_docs[]" type="file" multiple/></td></tr>
<tr><td colspan="1"></td><td><span style="color:red;">* Select Multiple Files Simultaneously </span></td></tr>
<tr><td>Schedule Comments :</td><td><textarea name="comment" ></textarea></td></tr>

<tr><th colspan='2'><center><input type="button" id="add_sch1" value="Add Schedule" > <input type="button" value="Back" onclick="sch_back();"></center></th></tr>


</table>
<script>
$('#upload_docs').change(function(){
    if(this.files.length>3){
        alert("You can't upload more than three files");
        $('#upload_docs').val('');
    }
});
</script>
</b>
<br>

<div id="unit_table">

</div>

</form></center>
<script>
function show_hide_assoc(status){
	
	if(status){
		var hid_val = $('#hid_assoc').val();
		$("#assocunit").val(hid_val);
		$('#assoc_row').show();
	}else{
		$('#assoc_row').hide();
		$('#assocunit').val('');
	}
}


$("#start_date,#end_date").on('input', function() {
	if(($("#start_date").val()!='') && ($("#end_date").val())){
		var start = new Date($("#start_date").val());
		var end = new Date($("#end_date").val());
		var diff = new Date(end - start); 
		var days = diff/1000/60/60/24;//alert(days);
		if(days<0){
			alert("End date must be greater then start date");
		}else{
			if (days >30){
				$('#instruc_data').show();
			}else{
				$('#instruc_data').hide();
			}
			
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
		$("#hid_assoc").val(obj.assoc_unit1+' '+obj.assoc_unit2+' '+obj.assoc_unit3);
		$("#selected_imei").val(imei_new);
		if(obj.unit == '5'){
			var asc_unit = 25;
		}else if(obj.unit == '6'){
			var asc_unit = 26;
		}else if(obj.unit == '7'){
			var asc_unit = 21;
		}
		if(obj.unit == '5' || obj.unit == '6' || obj.unit == '7'){
			$('#assocunit').val(asc_unit);
			$('#assocunit').prop('readonly',true);
			$('#assoc_row').show();
			$('#check_assoc').prop('checked',true);
			$('#check_assoc').prop('disabled',true);
		}else{
			//$('#assoc_row').hide();
			//$('#assocunit').val('');
			$('#assocunit').prop('readonly',false);
			//$('#check_assoc').prop('checked',false);
			$('#check_assoc').prop('disabled',false);
		}
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
		}else if($("#check_assoc").prop('checked') && ($('#assocunit').val().trim() == '' )){
			alert("Please fill associated unit");
			return false;
		}
		else{ 
			send_form_data();
		}
});


function send_form_data(){

			var formData = new FormData($('form#new_eqp_sch')[0]);
			
			var other_data = $('#new_eqp_sch').serializeArray();
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
							alert("New Schedule Created Successfully");
							$("#schedule_month").empty();
							$("#schedule_month").load('schedule_month.php');
						}
				
			});
}
</script>
