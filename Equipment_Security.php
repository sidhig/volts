<? 
  session_start();
include_once("connect.php"); ?>
<center>
<h2>Equipment Security</h2>
<input type="button" id="arm_disarm_view" class="btn btn-warning" style="width:20vw; height:5vh; color:black;" value="Arm/Disarm Security" /><br /><br />
<input type="button" id="sec_al_manage_view" class="btn btn-warning" style="width:20vw; height:5vh; color:black;" value="Security Alert Management" /><br /><br />
</center>
<style>
caption{
text-align:center;
}
</style>
<script>
$("#arm_disarm_view").on('click', function() {
	$("#arm_disarm_view").hide();
	$("#sec_al_manage_view").hide();
	$("#arm_disarm_div").show();
});
</script>
<center>
<div id="arm_disarm_div" style="display:none;  margin-top: -50px;">
 <table width="50%">
 <tr><th>Equipment Type: <input type="text" value="Storage Container" disabled></th><th></th>
 <th>Equipment #: <select id="eqp_id" name="veh_no" ><option readonly value=''>Select Equipment</option>
<?php
		 	$result = $conn->query("select * from devicedetails where DeviceType like '%Storage Container%' and devicedetails.DeviceIMEI != '270113183009586452'");
			 while($row = $result->fetch_object())
			 {
			   ?><OPTION VALUE="<?=$row->DeviceIMEI?>"><?=$row->DeviceName?></option><?
			  }
			?>
			 </select></th>
<th style='vertical-align: bottom;'>		 
<input type="button" id="arm_back" value="Close" style="float:left;">
</th>
</tr>
</table><br />
<table id="get_container_ajax" width="70%" style=' font-size: 1.2rem;'>
</table>
<script>
function arm_dis_btn() {
	$.post( "get_container_status.php",{ 
		change_status: 'true',arm_cur_status: $("#arm_cur_status").val(),eqp_container_name: $("#eqp_id :selected").text(),
		eqp_container_id: $("#eqp_id :selected").val(),tbl_armed_id: $("#tbl_armed_id").val(),send_dd:$("#send_dd :selected").val(),
		arm_manually: $("input[name='armed']:checked").val(),
		Monday: $("input[name='Monday']:checked").val(), mon_start: $("input[name='mon_start']").val(), mon_end: $("input[name='mon_end']").val(),
		Tuesday: $("input[name='Tuesday']:checked").val(), tues_start: $("input[name='tues_start']").val(), tues_end: $("input[name='tues_end']").val(),
		Wednesday: $("input[name='Wednesday']:checked").val(), wed_start: $("input[name='wed_start']").val(), wed_end: $("input[name='wed_end']").val(),
		Thursday: $("input[name='Thursday']:checked").val(), thur_start: $("input[name='thur_start']").val(), thur_end: $("input[name='thur_end']").val(),
		Friday: $("input[name='Friday']:checked").val(), fri_start: $("input[name='fri_start']").val(), fri_end: $("input[name='fri_end']").val(),
		Saturday: $("input[name='Saturday']:checked").val(), sat_start: $("input[name='sat_start']").val(), sat_end: $("input[name='sat_end']").val(),
		Sunday: $("input[name='Sunday']:checked").val(), sun_start: $("input[name='sun_start']").val(), sun_end: $("input[name='sun_end']").val()
	},function(data) {
		$.post( "get_container_status.php",{ get_status:'true', eqp_container_id: $("#eqp_id :selected").val() },function(data) {
		$("#get_container_ajax").empty();
		$("#get_container_ajax").html(data);
		});
		});
		
}
$("#eqp_id").on('change', function() {
	$.post( "get_container_status.php",{ get_status:'true', eqp_container_id: $("#eqp_id :selected").val() },function(data) {
		$("#get_container_ajax").empty();
		$("#get_container_ajax").html(data);
		});
});


$("#arm_back").on('click', function() {
	$("#arm_disarm_div").hide();
	$("#sec_al_manage_view").show();
	$("#arm_disarm_view").show();
});
$("#sec_al_manage_view").on('click', function() {
	$("#arm_disarm_view").hide();
	$("#sec_al_manage_view").hide();
	$("#sec_manage_div").show();
});
/*second form buttons*/
$("#sec_manage_back").on('click', function() {
	$("#sec_manage_div").hide();
	$("#sec_al_manage_view").show();
	$("#arm_disarm_view").show();
});
$("#sec_new_btn").on('click', function() {
	$("#sec_new_btn").hide();
	$("#new_sec_form").show();
});
$("#close_new_sec").on('click', function() {
	$("#new_sec_form").hide();
	$("#sec_new_btn").show();
});

$('#add_eqp_sec').click(function() {
	if($("#sec_name").val()=='' || $("#send_to").val()==''){ alert("Required field must be filled."); return false; }
	else{
		$.post( "get_container_status.php",{ query:"insert into eqp_sec_alert set name ='"+$("#sec_name").val()+"',rec_by ='"+$("input[name='rec_by']:checked").val()+"', send_to = '"+$("#send_to").val()+"'"},function(data) {
			$("#new_sec_form").hide();
			$("#sec_new_btn").show();
			$("#sec_alert_tbl").empty();
			$("#sec_alert_tbl").html(data);
			$("#sec_name").val('');
			$("#send_to").val('');
		});
	}
});

$("#edit_eqp_sec").click(function(){
	if($("#ed_sec_name").val()=='' || $("#ed_send_to").val()==''){ alert("Reuired field must be filled."); return false; }
	else{
		$.post( "get_container_status.php",{ query:"update eqp_sec_alert set name ='"+$("#ed_sec_name").val()+"',rec_by ='"+$("input[name='ed_rec_by']:checked").val()+"', send_to = '"+$("#ed_send_to").val()+"' where id = '"+$("#sec_id").val()+"'" },function(data) {
			$("#edit_sec_form").hide();
			$("#sec_alert_tbl").empty();
			$("#sec_alert_tbl").html(data);
		});
	}
});
$(".del_eqp_sec").click(function(){
	var r = confirm("Are you want to delete this data?");
if (r != true) {
    return false;
} else{
		var $row = $(this).closest("tr");
		//alert($row.find(".sec_id").text());
		$.post( "get_container_status.php",{ query:"delete from eqp_sec_alert where id = '"+$row.find(".sec_id").text()+"'" },function(data) {
			//alert(data);
			$("#new_sec_form").hide();
			$("#sec_manage_div").show();
			$("#sec_new_btn").show();
			$("#sec_alert_tbl").empty();
			$("#sec_alert_tbl").html(data);
		});
}
});



$(".edit_sec_alert").click(function(){
	$("#new_sec_form").hide();
	$("#sec_new_btn").show();
	$("#edit_sec_form").show();
	var $row = $(this).closest("tr");
	$("#ed_sec_name").val($row.find(".sec_name").text());
	$("#ed_send_to").val($row.find(".ed_send_to").text());
	$("#sec_id").val($row.find(".sec_id").text());
	if($row.find(".ed_rec_by").text()=='Phone'){ $("#ed_sec_phone").prop('checked','checked'); }
	else if($row.find(".ed_rec_by").text()=='Email'){ $("#ed_sec_email").prop('checked','checked'); }
});
$("#ed_send_to").keypress(function (e) {
	if($('#ed_sec_phone').is(':checked')) { 
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        $("#ed_errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
     }
	}
   });
   $('#ed_sec_phone,#ed_sec_email').click(function() {
	$("#ed_send_to").val('');
});
$("#send_to").keypress(function (e) {
	if($('#sec_phone').is(':checked')) { 
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
     }
	}
   });
$('#sec_phone,#sec_email').click(function() {
	$("#send_to").val('');
});
</script>
</div>
<!---Second button-->

<div id="sec_manage_div" style="display:none; margin-top: -75px;">
<? if($_SESSION['LOGIN_role']=='admin_gpc' || $_SESSION['LOGIN_role']=='superadmin'){ ?>
<input type="button" id="sec_new_btn" class="btn btn-warning" style="width:20vw; height:5vh; color:black;" value="New Security Alert" /><br /><br />
<form id="new_sec_form" style="display:none; border: 1px solid black; width: 50%; padding:0 1% 1% 1%;">
<table width="90%">
<caption><h3>New Security Alert<h3></caption>
<tr><td><strong>Name:<span style="color:red;">*</span></strong></td><td><input id="sec_name"></td></tr>
<tr><td rowspan="2"><strong>Receive By:<span style="color:red;">*</span></strong></td><td><input type="radio" id="sec_phone" name="rec_by" value="Phone" checked> Phone</td></tr>
<tr><td><input type="radio" name="rec_by" id="sec_email" value="Email"> Email</td></tr>
<tr><td ><strong>Send To:<span style="color:red;">*</span></strong></td><td width="50%"><input type="text" id="send_to"><span id="errmsg" style="color:red;"></span></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><th colspan="2" style="text-align:center;"><input id="add_eqp_sec" type="button" value="Add"> <input type="button" id="close_new_sec" value="Close"></th></tr>
</table>
</form>


<form id="edit_sec_form" style="display:none; border: 1px solid black; width: 50%; padding:0 1% 1% 1%;">
<table width="90%">
<caption><h3>Edit Security Alert<h3></caption>
<tr><td><strong>Name:<span style="color:red;">*</span></strong></td><td><input id="ed_sec_name"><input id="sec_id" type="hidden"></td></tr>
<tr><td rowspan="2"><strong>Receive By:<span style="color:red;">*</span></strong></td><td><input type="radio" id="ed_sec_phone" name="ed_rec_by" value="Phone" > Phone</td></tr>
<tr><td><input type="radio" name="ed_rec_by" id="ed_sec_email" value="Email"> Email</td></tr>
<tr><td ><strong>Send To:<span style="color:red;">*</span></strong></td><td width="50%"><input type="text" id="ed_send_to"><span id="ed_errmsg" style="color:red;"></span></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><th colspan="2" style="text-align:center;"><input id="edit_eqp_sec" type="button" value="Save"> <input type="button" onclick='$("#edit_sec_form").hide();' id="close_edit_sec" value="Close"></th></tr>
</table>
</form>
<?}?>

<table width="70%" id="sec_alert_tbl"><tr><th style="text-align:center;">Name</th><th style="text-align:center;">Receive By</th><th style="text-align:center;">Send To</th>
	<? if($_SESSION['LOGIN_role']=='admin_gpc' || $_SESSION['LOGIN_role']=='superadmin'){ ?>
	<th>Edit/Delete</th><?}?>
</tr>
<? $result = $conn->query("select * from eqp_sec_alert order by id desc");
			 while($sec = $result->fetch_object())
			 {
			 ?>
			 <tr align="center">
			 	<td class="sec_id" style="display:none;"><?=$sec->id?></td>
			    <td class="sec_name"><?=$sec->name?></td><td class="ed_rec_by"><?=$sec->rec_by?></td>
			    <td class="ed_send_to"><?=$sec->send_to?></td>
			 	<? if($_SESSION['LOGIN_role']=='admin_gpc' || $_SESSION['LOGIN_role']=='superadmin'){ ?>
			    <th><a class="edit_sec_alert" ><img src ="image/edit.png"/></a> <a class="del_eqp_sec" ><img src ="image/deny.png"/></a></th><?}?>
			</tr>
			<?  }  ?>
</table>

<input type="button" id="sec_manage_back" value="Close" >
</div>
</center>