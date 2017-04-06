<?php
		  session_start();
		  error_reporting(0);
		  include_once('connect.php');	
		  $_SESSION['LOGIN_dept']=='All';
	//print_r($_POST);	
		$_SESSION['mbval']=='reports';
		if(isset($_POST['dev']) && $_POST['dev'] == "add") {
		$dev_insert = "INSERT INTO 
				`automatedreport` SET 
				reportname = '".$_POST['report']."',
				`exec_type` = '".$_POST['excep_type']."',
				`duration` = '".$_POST['duration']."',
				`email` = '".$_POST['email']."',
				`type` = '".$_POST['dtype']."',
				typeval = '".$_POST['typeval']."'";
			$result = $conn->query($dev_insert) or die(mysqli_error());
			if($result){
					$err = "Device Successfully Added.";
					 unset($_POST);
					}		
					}
		else if(isset($_POST['dev']) && $_POST['dev'] == "edit") {
		$dev_insert = "update `automatedreport` SET 
				reportname = '".$_POST['report']."',
				`exec_type` = '".$_POST['excep_type']."',
				`duration` = '".$_POST['duration']."',
				`email` = '".$_POST['email']."',
				`type` = '".$_POST['dtype']."',
				typeval = '".$_POST['typeval']."'
				where id = '".$_POST['rep_id']."'";
			$result = $conn->query($dev_insert) or die(mysqli_error());
			if($result){
					$err = "Device Successfully Added.";
					 unset($_POST);
					}		
					}
		else if(isset($_POST['rep_id']) && $_POST['rep_id'] != "" ){
				$delqry = "delete from `automatedreport` where id = '".$_POST['rep_id']."'";
				$result = $conn->query($delqry) or die(mysqli_error()); 
					}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>New Automated Report</title>
<link rel="image icon" type="image/png" sizes="160x160" href="image/icon.png">
<link rel="stylesheet" type="text/css" href="css/style.css" />
<style>
body{
	background-color: #d6dce2;
}
 html, body, #map-canvas {
				height: 100%;
				margin: 0px;
				padding: 0px
			  }
td{
	padding-bottom: 1vh;
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
td{
	padding-bottom: 1vh;
}
footer {
      color:black;
      padding-top:.5vh;
      padding-bottom: 2.5vh;
      background-color: white;
      border: 1px solid #BBBBBB;
      width:98%;
    }
</style>
<script type="text/javascript" src="jquery-1.4.1.min.js"></script>
<!--<script type="text/javascript" src="js/drop.js"></script>-->
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="//cdn.jsdelivr.net/webshim/1.14.5/polyfiller.js"></script>
<script src="js/jquery-1.9.1.js"></script>
<script>
webshims.setOptions('forms-ext', {types: 'date'});
webshims.polyfill('forms forms-ext');
</script>
	<link rel="stylesheet" type="text/css" href="smoothness-1.11.2/jquery-ui-1.11.2.custom.css">
    <link rel="stylesheet" type="text/css" href="smoothness-1.11.2/ui.dropdownchecklist.themeroller.css">
    <!-- or use standalone -->
    <!-- <link rel="stylesheet" type="text/css" href="../src/ui.dropdownchecklist.standalone.css"> -->
		

    
    <!-- Include the basic JQuery support (core and FULL ui) -->
    <script type="text/javascript" src="smoothness-1.11.2/jquery-1.11.2.min.js"></script>
    <script type="text/javascript" src="smoothness-1.11.2/jquery-ui-1.11.2.min.js"></script>
    
    <!-- Include the DropDownCheckList support -->
    <script type="text/javascript" src="smoothness-1.11.2/ui.dropdownchecklist.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
<link rel="stylesheet" href="css/bootstrap-multiselect.css"> 
  <script src="js/bootstrap-multiselect.js"></script>
  <script>
    $(document).ready(function() {
      
      $('#etyp,#e_dev,#e_grp,#e_dpt,#e_etyp,#dpt,#dev,#grp').multiselect({
        includeSelectAllOption: true,
        selectAllText: 'All',
         numberDisplayed: 2
      }); 
}); 
    </script>
<script type="text/javascript">
				
function add(){
$("#add_veh").css('display', 'none');
$("#add_form").css('display', 'block');
$("#edit_form").hide();
$("#add_btn").hide();
}
function add_close(){
//alert("jhb");
$("#add_form").hide();
$("#add_veh").show();
$("#add_btn").show();
}
function edit_close(){
//alert("jhb");
$("#edit_form").hide();
$("#add_veh").show();
$("#add_btn").show();
}
</script>
</head>
<body style="background-color: #d6dce2;">
<center><div id="container" style="width:98%;height:auto;margin-top:1vh;margin-bottom:.7vh;background-color: #fff;border: 1px solid #BBBBBB;">
<div id="wrappermap" style="background-color: #fff; height:auto; min-height:550px;">
	<center><h1>Automated Report</h1></center>
<div id="tracker" style=" " >
<input id="track_close" type="button" value="Back" onclick='window.close();' style="margin-left:12px;margin-top:1vh;margin-bottom:1vh;float:left; " />
<center><input type="button" class="btn btn-warning" style="width:20vw; height:5vh; color:black;margin-top:3vh;margin-right:3vw;" value="New Automated Report" id="add_btn" onclick="add();" /></center>
<br />
<div id="add_form" style="display:; padding:10px; border:black 1px solid; margin: 15px; font-weight:600;">
<form action="get_automated.php" id="automated_form" method="post">
<input type="hidden" name="dev" value="add" />
<center><h3>New Automated Report</h3>
<table cellspacing="5px" width="60%" border=0 style="margin-left:30%;">
<tr>
<td>Report Type: </td><br><td style="padding-bottom: 1vh;">
<select name="report" id="report" style="font-weight: normal;">
<?
$sql = $conn->query("SELECT * from role_report where if('".$_SESSION['ROLE_report']."'=0,1,id in (".$_SESSION['ROLE_report'].") ) and name != 'Automated Report' order by name asc");
        while($obj = $sql->fetch_object()){ ?>
        <option ><?=$obj->name?></option>
<?}?>
</select>
</td></tr>
<tr id="excep_type">
<td>Exception Type: </td><td style="padding-bottom: 1vh;"><select name="excep_type" style="font-weight: normal;">
<option>Speed</option>
<option>Acceleration</option>
<option>Deacceleration</option>
<option>RPM</option>
<option>Battery</option></select>
</td></tr>
<tr><td>
Sending Interval: </td><td style="padding-bottom: 1vh;"><select name="duration" style="font-weight: normal;">
<option value="0">Daily</option>
<option value="1" selected="selected">Weekly</option>
<option value="2">Monthly</option></select>
</td>
</tr>
<tr>
<td>Type: </td><td style="padding-bottom: 1vh;"><select id="display_typ" name="dtype" style="font-weight: normal;"><option>Group</option><option>Department</option><option>Equipment Type</option><option>Equipment</option></select></td>
</tr>
<tr>
<td id="td_grp" style="display:;" >Group: </td><td id="td_grp2" ><select id="grp" name="group" class="s5a" multiple="multiple" onchange="$('#typeval').val($(this).val());" style="font-weight: normal;">
				<?  
                  $sql = $conn->query("SELECT * from role_group where if('".$_SESSION['ROLE_group']."'='0',1,id in (".$_SESSION['ROLE_group'].")) order by name asc");
                  while($obj = $sql->fetch_object()){
              ?>
                  <option selected ><?=$obj->name?></option>
              <?   } 
              ?>
			  </select>
		</td>
<td id="td_dept" style="display:none;">Department: </td><td id="td_dept2" ><select name="multi_eqp" style="display:none;" id="dpt" class="s5a" multiple="multiple" onchange="$('#typeval').val($(this).val());">
                  <?  
                  $sql = $conn->query("SELECT * from role_dept where if('".$_SESSION['ROLE_dept']."'='0',1,id in (".$_SESSION['ROLE_dept'].")) order by name asc");
                  while($obj = $sql->fetch_object()){
              ?>
                  <option selected ><?=$obj->name?></option>
              <?   } 
              ?>
				</select></span></td>
<td  id="td_eqptyp" style="display:none;">Equipment Type: </td><td id="td_eqptyp2" >
<select name="etyp" id="etyp" class="s5a" style="display:none;" multiple="multiple" onchange="$('#typeval').val($(this).val());" >
				<?  
                  $sql = $conn->query("SELECT * from tbl_eqptype where if('".$_SESSION['ROLE_eqp']."'='0',1,id in (".$_SESSION['ROLE_eqp'].")) order by eq_name asc");
                  while($obj = $sql->fetch_object()){
              ?>
                  <option selected ><?=$obj->eq_name?></option>
              <?   } 
              ?>
</select></td>
<td id="td_dev" style="display:none;">Equipment: </td><td id="td_dev2" >
		<select id="dev" class="s5a" style="display:none;" multiple="multiple" onchange="$('#typeval').val($(this).val());" >
		
		<?php
			  $sql = $conn->query("select DeviceName from devicedetails where DeviceName !='' and DeviceName is not null and
				opco in (select name from role_opco where if('".$_SESSION['ROLE_opco']."'='0',1,id in (".$_SESSION['ROLE_opco']."))) and 
				`primary` in (SELECT name from role_primary where if('".$_SESSION['ROLE_primary']."'='0',1,id in (".$_SESSION['ROLE_primary']."))) and `group` in (SELECT name from role_group where if('".$_SESSION['ROLE_group']."'='0',1,id in (".$_SESSION['ROLE_group']."))) and 
				department in (SELECT name from role_dept where if('".$_SESSION['ROLE_dept']."'='0',1,id in (".$_SESSION['ROLE_dept']."))) and 
				DeviceType in (SELECT eq_name from tbl_eqptype where if('".$_SESSION['ROLE_eqp']."'='0',1,id in (".$_SESSION['ROLE_eqp'].")))");
			 while($obj = $sql->fetch_object()){
			 ?>
			    <option ><?=$obj->DeviceName?></option>
			<?  } 
			 ?>
		 
		</select>
		
</td>
</tr>
<tr>
<td rowspan="">Email: </td>
<td rowspan="" style="padding-top: 1vh;"><textarea placeholder="Email" name="email" id='email' cols="50" rows="3"></textarea><br />
*Please separate by commas .. or on different lines in text box</td>
</tr>
</table>
<input id="typeval" name="typeval" type="hidden" />
<center>
<input type="button" id="automated_btn" class="btn btn-primary" value="Create Automated Report" />
<input type="reset" value="Close" class="btn btn-primary" onclick="add_close();" />
</center>
</form>
</div>

<div id="edit_form" style="display:; padding:20px; border:black 1px solid; margin: 15px;">
<form action="get_automated.php" method="post" id="post_form">
<input type="hidden" name="dev" value="edit" />
<input type="hidden" name="rep_id" id="rep_id" value="" />
<center><h3>Edit Automated Report</h3></center>
<table cellspacing="5px" width="60%" border=0 style="margin-left:30%;">
<tr>
<td><strong>Report Type: </strong></td><td style="padding-bottom: 1vh;">
<select name="report" id="e_report">

<?
$sql = $conn->query("SELECT * from role_report where if('".$_SESSION['ROLE_report']."'=0,1,id in (".$_SESSION['ROLE_report'].") ) and name != 'Automated Report' order by name asc");
        while($obj = $sql->fetch_object()){ ?>
        <option selected ><?=$obj->name?></option>
<?}?>
</select>
</td></tr>
<tr id="e_excep_type">
<td><strong>Exception Type: </strong></td><td style="padding-bottom: 1vh;"><select name="excep_type" id="excep">
<option>Speed</option>
<option>Acceleration</option>
<option>Deacceleration</option>
<option>RPM</option>
<option>Battery</option></select>
</td></tr>
<tr><td>
<strong>Sending Interval: </strong></td><td style="padding-bottom: 1vh;"><select name="duration" id="e_duration">
<option value="0">Daily</option>
<option value="1" selected="selected">Weekly</option>
<option value="2">Monthly</option></select>
</td>
</tr>
<tr>
<td><strong>Type: </strong></td><td style="padding-bottom: 1vh;"><select id="e_display_typ" name="dtype"><option>Group</option><option>Department</option><option>Equipment Type</option><option>Equipment</option></select></td>
</tr>
<tr class="tr_group">
<td style="display:;" style="padding-bottom: 1vh;"><strong>Group: </strong></td><td >
<select id="e_grp" name="group" class="s5a" multiple="multiple" onchange="$('#e_typeval').val($(this).val());" checked>
			<?  
                  $sql = $conn->query("SELECT * from role_group where if('".$_SESSION['ROLE_group']."'='0',1,id in (".$_SESSION['ROLE_group'].")) order by name asc");
                  while($role = $sql->fetch_object()){
              ?>
                  <option selected ><?=$role->name?></option>
              <?   } 
              ?>
			  </select>
		</td>
		</tr>
		<tr class="tr_dept" >
<td style="display:;"><strong>Department: </strong></td><td><select name="multi_eqp" style="display:;" id="e_dpt" class="s5a" multiple="multiple" onchange="$('#e_typeval').val($(this).val());">
                 <?  
                  $sql = $conn->query("SELECT * from role_dept where if('".$_SESSION['ROLE_dept']."'='0',1,id in (".$_SESSION['ROLE_dept'].")) order by name asc");
                  while($obj = $sql->fetch_object()){
              ?>
                  <option selected ><?=$obj->name?></option>
              <?   } 
              ?>
				</select></td>
				</tr>
<tr class="tr_eqptyp" >
<td style="display:;"><strong>Equipment Type: </strong></td><td >
<select name="etyp" id="e_etyp" class="s5a" style="display:;" multiple="multiple" onchange="$('#e_typeval').val($(this).val());" >
<?  
                  $sql = $conn->query("SELECT * from tbl_eqptype where if('".$_SESSION['ROLE_eqp']."'='0',1,id in (".$_SESSION['ROLE_eqp'].")) order by eq_name asc");
                  while($obj = $sql->fetch_object()){
              ?>
                  <option selected ><?=$obj->eq_name?></option>
              <?   } 
              ?>
</select></td>
</tr>
<tr class="tr_dev" >
<td style="display:;"><strong>Equipment: </strong></td><td style="padding-bottom: 1vh;">
		<select id="e_dev" class="s5a" style="display:;" multiple="multiple" onchange="$('#e_typeval').val($(this).val());" >
		<?php
			  $sql = $conn->query("select DeviceName from devicedetails where DeviceName !='' and DeviceName is not null and
				opco in (select name from role_opco where if('".$_SESSION['ROLE_opco']."'='0',1,id in (".$_SESSION['ROLE_opco']."))) and 
				`primary` in (SELECT name from role_primary where if('".$_SESSION['ROLE_primary']."'='0',1,id in (".$_SESSION['ROLE_primary']."))) and `group` in (SELECT name from role_group where if('".$_SESSION['ROLE_group']."'='0',1,id in (".$_SESSION['ROLE_group']."))) and 
				department in (SELECT name from role_dept where if('".$_SESSION['ROLE_dept']."'='0',1,id in (".$_SESSION['ROLE_dept']."))) and 
				DeviceType in (SELECT eq_name from tbl_eqptype where if('".$_SESSION['ROLE_eqp']."'='0',1,id in (".$_SESSION['ROLE_eqp'].")))");
			 while($obj = $sql->fetch_object()){
			 ?>
			    <option ><?=$obj->DeviceName?></option>
			<?  } 
			 ?>
		</select>
</td>
</tr>
<tr>
<td rowspan=""><strong>Email:</strong> </td>
<td  style="padding-top: 1vh;"><textarea placeholder="Email" name="email" id='e_email' cols="50" rows="3"></textarea><br />
<strong>*Please separate by commas .. or on different lines in text box</strong></td>
</tr>
</table>
<input id="e_typeval" name="typeval" type="hidden" />
<center>
<input id="save_btn" type="button" class="btn btn-primary" value="Save Automated Report" />
<input type="reset" value="Close" class="btn btn-primary" onclick="edit_close();" />
</center>
</form>
</div>


<script>
$(document).on('ready', function() {
$("#add_form").css('display', 'none');
$("#edit_form").css('display', 'none');
$("#td_eqptyp").hide();
$("#td_dept").hide();
$("#td_dev").hide();
$("#td_eqptyp2").css('display', 'none');
$("#td_dept2").css('display', 'none');
$("#td_dev2").css('display', 'none');
$(".tr_dept").css('display', 'none');
$(".tr_eqptyp").css('display', 'none');
$(".tr_dev").css('display', 'none');
});

$("#report").on('change', function() {
if($('#report :selected').val()=='Exception Report'){
$("#excep_type").show();
}
else{
$("#excep_type").hide();
}
});
$("#e_report").on('change', function() {
if($('#e_report :selected').val()=='Exception Report'){
$("#e_excep_type").show();
}
else{
$("#e_excep_type").hide();
}
});

$("#display_typ").on('change', function() {
	$("#typeval").val('');
if($('#display_typ :selected').val()=='Group'){
$("#td_grp").show();
$("#td_dept").hide();
$("#td_eqptyp").hide();
$("#td_dev").hide();
$("#td_grp2").css('display', 'block');
$("#td_dept2").css('display', 'none');
$("#td_eqptyp2").css('display', 'none');
$("#td_dev2").css('display', 'none');
}
else if($('#display_typ :selected').val()=='Department'){
$("#td_dept").show();
$("#td_grp").hide();
$("#td_eqptyp").hide();
$("#td_dev").hide();
$("#td_dept2").css('display', 'block');
$("#td_grp2").css('display', 'none');
$("#td_eqptyp2").css('display', 'none');
$("#td_dev2").css('display', 'none');
}
else if($('#display_typ :selected').val()=='Equipment Type'){
$("#td_eqptyp").show();
$("#td_grp").hide();
$("#td_dept").hide();
$("#td_dev").hide();
$("#td_eqptyp2").css('display', 'block');
$("#td_grp2").css('display', 'none');
$("#td_dept2").css('display', 'none');
$("#td_dev2").css('display', 'none');
}
else if($('#display_typ :selected').val()=='Equipment'){
$("#td_dev").show();
$("#td_grp").hide();
$("#td_dept").hide();
$("#td_eqptyp").hide();
$("#td_dev2").css('display', 'block');
$("#td_grp2").css('display', 'none');
$("#td_dept2").css('display', 'none');
$("#td_eqptyp2").css('display', 'none');
}
});
$("#e_display_typ").on('change', function() {
	$("#e_typeval").val('');
if($('#e_display_typ :selected').val()=='Group'){
$(".tr_group").css('display', 'table-row');
$(".tr_dept").css('display', 'none');
$(".tr_eqptyp").css('display', 'none');
$(".tr_dev").css('display', 'none');
}
else if($('#e_display_typ :selected').val()=='Department'){
$(".tr_dept").css('display', 'table-row');
$(".tr_group").css('display', 'none');
$(".tr_eqptyp").css('display', 'none');
$(".tr_dev").css('display', 'none');
}
else if($('#e_display_typ :selected').val()=='Equipment Type'){
$(".tr_eqptyp").css('display', 'table-row');
$(".tr_group").css('display', 'none');
$(".tr_dept").css('display', 'none');
$(".tr_dev").css('display', 'none');
}
else if($('#e_display_typ :selected').val()=='Equipment'){
$(".tr_dev").css('display', 'table-row');
$(".tr_group").css('display', 'none');
$(".tr_dept").css('display', 'none');
$(".tr_eqptyp").css('display', 'none');
}
});
$("#automated_btn").on('click', function() {
if($("textarea#email").val()==''){
alert("Please enter Email");
return false;
}
else if($("#typeval").val()==''){
alert("Please select "+$("#display_typ").val());
return false;
}
else{
//alert("submit");
$("#automated_form").submit();
}
});
$("#save_btn").on('click', function() {
	if($("textarea#e_email").val()==''){
	alert("Please enter Email");
	return false;
	}
	else if($("#e_typeval").val()==''){
	alert("Please select "+$("#e_display_typ").val());
	return false;
	}
	else{
	$("#post_form").submit();
	}
});
/*$("#type_filt").on('change', function() {
if($('#mb :selected').val()=='admin'){
	var data1 = $("#type_filt option:selected").text();
    var jo = $("#fbody").find("tr");
    if (data1 == "All") {
        jo.show();
        return;
    }
    jo.hide();
   //Recusively filter the jquery object to get results.
    jo.filter(function (i, v) {
        var $t = $(this);
            if ($t.is(":contains('" + data1 + "')")) {
                return true;
            }
        return false;
    }).show();
}
});
$("#eqp_filt").on('change', function() {
if($('#mb :selected').val()=='admin'){
	var data1 = $("#eqp_filt option:selected").text();
    var jo = $("#fbody").find("tr");
    if (data1 == "All") {
        jo.show();
        return;
    }
    jo.hide();
   //Recusively filter the jquery object to get results.
    jo.filter(function (i, v) {
        var $t = $(this);
            if ($t.is(":contains('" + data1 + "')")) {
                return true;
            }
        return false;
    }).show();
}
});
setInterval(function(){
    $('#tracker_table').load('tracker.php');
	//alert("reloading");
	}, 60000);
setInterval(function(){
    $('#rr').load('rr.php');
	//alert("reloading");
	}, 60000);*/
</script>


<div id='tracker_table'>
<?  include_once('automated_rep_list.php'); ?>
</div>
</div>

</div><!---wrappermap close -->
</div></center><!--- container close -->
<center><div>
<? include_once('fotter.php'); ?>
