<? include_once('connect.php'); 
session_start(); ?>

<center>
<input type="button" id='tracker_mgmt_btn' value="Tracker Management" onclick='show_tracker_mgmt();' class="btn btn-warning" style="width:20vw; height:4rem; color:black;margin-top:3rem;" /><br />
<? if($_SESSION['LOGIN_role']=='admin' || $_SESSION['LOGIN_role']=='superadmin'){ ?>
<input type="button" id='setting_btn' value="Settings" onclick='showsetting();' class="btn btn-warning" style="width:20vw; height:4rem; color:black; margin-top:3rem;" /><br />
<?if($_SESSION['LOGIN_role']=='admin'){?>
<input type="button" id='user_btn' value="User Management " onclick='show_user();' class="btn btn-warning" style="width:20vw; height:4rem; color:black; margin-top:3rem;" /><br />
<?}else if($_SESSION['LOGIN_role']=='superadmin' ){?>
<input type="button" id='user_btn' value="User Management " onclick='show_user_role();' class="btn btn-warning" style="width:20vw; height:4rem; color:black; margin-top:3rem;" /><br />
<a href="combination_view.php" target="_blank"><input type="button" id='hrchy_btn' value="Company Hierarchy" class="btn btn-warning" style="width:20vw; height:4rem; color:black; margin-top:3rem;" /></a><br />
<?}?>
<!--<input type="button" id='tracker_conf_btn' value="Tracker Configuration " onclick='show_tracker_conf();' class="btn btn-warning" style="width:20vw; height:4rem; color:black; margin-top:3rem;" />-->
<? } ?>
<? //{ ?>
<!-- <input type="button" id='user_btn' value="User Management " onclick='show_user();' class="btn btn-warning" style="width:20vw; height:4rem; color:black; margin-top:3rem;" /><br /> -->
<? //} ?>
<script>
function sch_back() {
	//alert('test');
	$("#spin_loading").show();
	$("#Admin").load('Admin.php');
	//$("#spin_loading").hide();
}
function show_tracker_mgmt(){
	    $("#user_btn,#hrchy_btn").hide();
		$("#tracker_mgmt_btn").hide();
		$("#setting_btn").hide();
		$("#tracker").show();
		$("#tracker_conf_btn").hide();
		$("#user_role").hide();
		//$("#tracker").html("");
		$("#tracker").load('tracker_list.php');
}

function show_tracker_conf(){
	    $("#user_btn,#hrchy_btn").hide();
		$("#tracker_mgmt_btn").hide();
		$("#setting_btn").hide();
		$("#tracker_conf_btn").hide();
		$("#track_conf").show();
		$("#user_role").hide();
		//$("#tracker").html("");
		$("#track_conf").load('tracker_conf.php');
}

function show_user_role(){
	    $("#user_btn,#hrchy_btn").hide();
		$("#tracker_mgmt_btn").hide();
		$("#setting_btn").hide();
		$("#tracker_conf_btn").hide();
		$("#user_role").show();
		//$("#tracker").html("");
		$("#user_role").load('manage_role.php');
}
function show_user(){
	    $("#user_btn,#hrchy_btn").hide();
		$("#tracker_mgmt_btn").hide();
		$("#setting_btn").hide();
		$("#tracker_conf_btn").hide();
		$("#user").show();
		$("#user_role").hide();
		//$("#tracker").html("");
		$("#user").load('user_details.php');
}
function showsetting(){
		$("#tracker_mgmt_btn,#hrchy_btn").hide();
		 $("#user_btn").hide();
		$("#setting_btn").hide();
		$("#settings").show();
		$("#user_role").hide();
		$("#tracker_conf_btn").hide();
}

function set_close(){
		$("#settings").hide();
		$("#tracker_mgmt_btn").show();
		$("#setting_btn").show();
		 $("#user_btn").show();
		 $("#tracker_conf_btn").show();
		 $('#hrchy_btn').show();
		 $("#user_role").hide();
}
function save_setting(){
		$("#save_setting1").val("Saving");
		$.post( "setting_ajax_query.php",{ new_trip_sheet: $("#new_trip_sheet_setting").val(), trip_sheet_note: $("#trip_sheet_note_setting").val(), low_battery_alert: $("#trip_sheet_battery_alert").val()  },function(data) {
			alert(data);
				$("#save_setting1").val("Save");
			});
}

function del_role_user(role){
    //alert(role);
  if(confirm("Are you sure to delete all users with role: "+role+ "?")){
    $("#spin_loading").show(); 
      $.ajax({
        type: "POST",
        url: "user_query.php",
        data: "del_user_role="+role,
        success: function(data) {
          alert(data);
          //manage_role();
          $("#user_role").load('manage_role.php');
          $("#spin_loading").hide();
        }
      });
  }
}

</script>
<div id='tracker' style="display:none; background-color:white;width:95vw;<? if($_SESSION['ROLE_can_edit'] && $_SESSION['LOGIN_role'] != 'normal'){ echo "margin-top: -8vh;"; }else{ echo "margin-top: 0vh;";}?>" >
<center><img src='image/spinner.gif'> <strong>Please wait while getting Tracker Management...</strong></center>
</div>
<?if($_SESSION['LOGIN_role']!='superadmin'){?>
<div id='user' style="display:none; background-color:white;width:95vw;margin-top: -8vh;" >
<center><img src='image/spinner.gif'> <strong>Please wait while getting User Details...</strong></center>
</div>
<?}else{?>
<div id='user_role' style="display:none; background-color:white;width:95vw;margin-top: -8vh;" >
<center><img src='image/spinner.gif'> <strong>Please wait while getting User Details...</strong></center>
</div>
<?}?>
<div id='track_conf' style="display:none; background-color:white;width:95vw;margin-top:-8vh;" >
<center><img src='image/spinner.gif'> <strong>Please wait while getting Tracker Configuration...</strong></center>
</div>

<div id="settings" style="display:none; background-color:white;width:95vw;" >
<center><h2>Settings</h2>
<?php  $dev_row = mysql_fetch_assoc(mysql_query("select * from setting where username = '".$_SESSION['LOGIN_user']."'")); ?>
<? if($_SESSION['LOGIN_role']!='schedule_admin'){ ?> 
<strong>Send new Trip Sheets to:</strong> 
<input id="new_trip_sheet_setting" class="form-control" type="text" value="<?php echo $dev_row['new_trip_sheet']?>" style="width:18vw;margin-top:.5vh;"/><br />

<strong>Send Trip Sheet notifications to:</strong> 
<input id="trip_sheet_note_setting" type="text" class="form-control" value="<?php echo $dev_row['trip_sheet_note']?>" style="width:18vw;margin-top:.5vh;"/><br />

<strong>Send Low Battery Alert to:</strong> 
<input id="trip_sheet_battery_alert" type="text" class="form-control" value="<?php echo $dev_row['low_battery_alert']?>" style="width:18vw;margin-top:.5vh;"/><br />

 <? } else{ ?>
<strong>Send notifications to:</strong> 
<input id="trip_sheet_note_setting" type="text" class="form-control" value="<?php echo $dev_row['trip_sheet_note']?>" style="width:18vw;margin-top:.5vh;"/><br />
  <? } ?>

<input id ="save_setting1" type="button" onclick="save_setting();" value="Save"  class="btn btn-primary"/>&nbsp;<input onclick="set_close()" type="button" value="Close" class="btn btn-primary"/>
</center>
</div>