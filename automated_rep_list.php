<?
			include_once('connect.php');
			session_start();
			$_SESSION['mbval']='reports';

?>
<style>
th{
	text-align: center;
}
    
</style>
<table id="dev_table" border=1 width=98% align="center" style="margin-bottom:1vh;">
<tr><th>Report Type</th><th>Sending Interval</th><th>Type</th><th>Value</th><th>Email</th><th>Edit/Delete</th></tr>
<tbody id="fbody">
<?php
//$row = mysql_query("select * from devicedetails where username = 'gpc' order by DeviceName");
$conn->query("set time_zone = '-4:00';");
$row = $conn->query("select * from automatedreport where email !='' and type !='' and typeval != ''");
				 
 while($dev_row = $row->fetch_object()){ ?>
<tr align="center">
<td ><span class="edit_report"><?=$dev_row->reportname?></span><? if($dev_row->reportname=='Exception Report'){ ?>(<span class="exc_type"><?=$dev_row->exec_type?></span>)<? } ?></td>
<td ><span class="dur" style="display:none;"><?=$dev_row->duration?></span><span class="span_id" style="display:none;"><?=$dev_row->id?></span><? 
if($dev_row->duration=='0'){ echo 'Daily'; }
if($dev_row->duration=='1'){ echo 'Weekly'; }
if($dev_row->duration=='2'){ echo 'Monthly'; } ?></td>
<td class="e_type"><?=$dev_row->type?></td>
<td class="e_typeval"><?=$dev_row->typeval?></td>
<td class="e_email"><?=$dev_row->email?></td>
<td><a class="edit" ><img src ="image/edit.png"/></a>
 <!--<a onclick="return confirm('Are you sure?')" href="index.php?dev_imei=<?=$dev_row->id?>&action=del_veh"><img src="image/deny.png"></a>!-->
<form method="post" action="get_automated.php" id="del_id<?=$dev_row->id?>">
<input type="hidden" name="rep_id" value="<?=$dev_row->id?>" />
<a onclick="fordelete('del_id<?=$dev_row->id?>');" style="cursor:pointer;" ><img src="image/deny.png"></a>
</form></td></tr>
<? } ?>
</tbody>
</table>
<script>
$(".edit").click(function(){
$("#add_veh").hide();
$("#add_form").hide();
$("#add_btn").hide();

$("#edit_form").css('display', 'block');
var $row = $(this).closest("tr");

$("#rep_id").val($row.find(".span_id").text());
$("#e_report").val($row.find(".edit_report").text());
if($row.find(".edit_report").text()=='Exception Report'){
$("#e_excep_type").show();
}
else{
$("#e_excep_type").hide();
}
$("#excep").val($row.find(".exc_type").text());
$("#e_duration").val($row.find(".dur").text());
$("#e_display_typ").val($row.find(".e_type").text());
$("#e_email").val($row.find(".e_email").text());
$("#e_typeval").val($row.find(".e_typeval").text());

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
//alert($row.find(".e_typeval").text());
//alert($('.active').val());
//if($('.active').val()=='Bronto'){
//$('.active').attr('checked', true); }
//$(".ui-dropdownchecklist-text").val($row.find(".e_typeval").text());
//$(".ui-dropdownchecklist-selector ui-state-default").val($row.find(".e_typeval").text());
//$("#ddcl-e_grp-ddw").val($row.find(".e_typeval").text());
    $("body").scrollTop(0);
});
function fordelete(formId){
if(confirm('Are you sure?')){ 
document.getElementById(formId).submit(); 
}
}
</script>