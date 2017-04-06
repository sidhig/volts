  <? include_once('connect.php'); 
  //include_once('substationjson.php');
  session_start(); ?>
  <!--<link rel="stylesheet" type="text/css" href="tracker.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>-->
  
	<!--modal box-->
	<!--<script type="text/javascript" src="https://code.jquery.com/jquery-1.6.min.js"></script>modal box-->
	<!--<script type="text/javascript" src="js/jquery.reveal.js"></script>modal box
	<script src="js/jquery.min.1.12.0.js"></script>-->

	<link rel="stylesheet" href="css/jquery.modal.css">
	<script src="js/jquery.modal.js"></script>
<script>
function edit_rl(tsn){
				$("#rl_load_spinner").show(); 
		$.ajax({
            type: "POST",
            url: "edit_relocation.php",
            data: "time_sheet="+tsn,
            success: function(data) {
				$("#trip_sheet_div").html(data); 
				$("#trip_sheet_div").show();
				$("#rl_load_spinner").hide();
            }
        });
  }
$(document).ready(function(){
	$("#rl_search_filter_ts").on('input',function(){
	  filter_table($("#rl_d_rdate option:selected").val(),
		  $("#rl_d_cd option:selected").val(),
		  $("#rl_d_cp option:selected").val(),
		  $("#rl_search_filter_ts").val(),
		  $("#rl_d_iname option:selected").val(),
		  $("#rl_equipment_filter option:selected").val(),
		  $("#rl_d_status option:selected").val(),
		  $("#relocation_tbl_body"));
	});
	$("#rl_d_rdate,#rl_d_cd,#rl_d_cp,#rl_d_iname,#rl_equipment_filter,#rl_d_status").on('change', function() {
		filter_table($("#rl_d_rdate option:selected").val(),
		  $("#rl_d_cd option:selected").val(),
		  $("#rl_d_cp option:selected").val(),
		  $("#rl_search_filter_ts").val(),
		  $("#rl_d_iname option:selected").val(),
		  $("#rl_equipment_filter option:selected").val(),
		  $("#rl_d_status option:selected").val(),
		  $("#relocation_tbl_body"));
	});
	filter_table($("#rl_d_rdate option:selected").val(),
		  $("#rl_d_cd option:selected").val(),
		  $("#rl_d_cp option:selected").val(),
		  $("#rl_search_filter_ts").val(),
		  $("#rl_d_iname option:selected").val(),
		  $("#rl_equipment_filter option:selected").val(),
		  $("#rl_d_status option:selected").val(),
		  $("#relocation_tbl_body"));
});

</script>
<script>
function load_form(form){
$("#trip_sheet_div").load(form); 
$("#trip_sheet_div").show();
}
function complete_rel_true(tsn){ //alert(status);
     document.getElementById('dialogbox').style.display = "none";
     document.getElementById('dialogoverlay').style.display = "none";
      $("#ts_load_spinner").show();
     $.ajax({
     type: 'post',
     url: 'relocation_query.php',
     data: 'trip_form='+'Completed'+'&time_sheet='+tsn,
     success: function (data) { //alert(data);
     alert("Relocation Sheet number "+tsn+" completed successfully.");
     
     $("#trip_sheet_div").hide();
     $("#relocation_tbl_body").load('relocation_tbl_body.php');
	filter_table($("#rl_d_rdate option:selected").val(),
						  $("#rl_d_cd option:selected").val(),
						  $("#rl_d_cp option:selected").val(),
						  $("#rl_search_filter_ts").val(),
						  $("#rl_d_iname option:selected").val(),
						  $("#rl_equipment_filter option:selected").val(),
						  $("#rl_d_status option:selected").val(),
						  $("#relocation_tbl_body"));
      $("#rl_load_spinner").hide();
     $("#trip_sheet_div").html("");
     trip_list.length=0;
     }
    });
   $( ".chk_rel").prop( "checked", false );
    }

$('#comp_button_rel').click(function(){
    trip_list = [];
     $('.chk_rel:checked').each(function () {
            trip_list.push($(this).val());
        });
         //ts_change_status(trip_list,'Completed');
         open_dialog('Are you sure you want to complete this Relocation Sheet ?',trip_list,'complete_rel_true');
    });

function selected_relocation_list(){

   trip_list = [];
      $('.chk_rel:checked').each(function () {
            trip_list.push($(this).val());
         });

     if(trip_list.length==0){
      $('#comp_button_rel').prop('disabled',true);
      $('#comp_button_rel').css('opacity',0.5);
     }else{
      $('#comp_button_rel').prop('disabled',false);
      $('#comp_button_rel').css('opacity',1);
     }
  
}
</script>
<style>
 body{
  background-color: #d6dce2;
 }
 td{
  padding-bottom: .8vh;
 }
 .stg{
  margin-left: 2vw;
    margin-right: 4vw;
   }
.sel{
  width:15vw;
}
 .intp{width:15vw;}

.modal {
  width:40vw;
}
.modal a.close-modal {
    top: 0.5px;
    right: 0.5px;
	}

@media only screen and (max-width: 768px) {
    /* For mobile phones: */
   
    .intp {
        width: 100%;
    }
    .sel {
        width: 100%;
    }
	.modal {
	width:90vw;
  }
}
.btn{
  /*background: url(image/close.png) no-repeat;*/
}

 </style>

<!--<a href="Admin.php" class="btn btn-default" style="float:left;margin-top:-3vh;">Back</a><a href="" rel="modal:open"></a>-->
<center>
<? if($_SESSION['ROLE_can_edit']){ ?>
<input type="button" value="New Relocation Sheet" class="btn btn-warning intp" onclick='load_form("new_relocation.php");' style="color:black; margin-bottom:.3vh; padding: 1vh;" />
<? } ?>
<div id='rl_load_spinner' style="color:red; clear: both; display:none; font-size: .9vw;"><img src="image/spinner.gif" width="20px">Please wait...</div>
<div id='rl_refresh_spinner' style="color:red; clear: both; display:none; font-size: .9vw;"><img src="image/spinner.gif" width="20px">Refreshing Relocation Sheet List...</div>
</center>
<center>
<?
 $trip_qry = "select relocation.*, devicedetails.DeviceName from relocation left join devicedetails on relocation.veh_no = devicedetails.DeviceIMEI where req_date > date(now() - interval 15 day) "; ?>
         
        <div style="/*float:left; font-weight:;margin: 0 100px 10px 0;*/font-size: 1.3rem;">
         <div style="/*float:left;*/ font-weight:;/*margin: 0 100px 10px 0;*/"> 
		<table border=0 width=98% align="center" style="font-size: inherit;">
		<tr><th>Relocation #</th><th>Status</th><th>Date Requested</th><th>Contract Driver</th><th>Contact Person</th><th>Item Being Delivered</th><th>Equipment #</th></tr>
		 <tr><th>      
         <input id="rl_search_filter_ts" class="input"  style="padding: .1vh;">
         </th><th>         
          <select id="rl_d_status">
			<option value="">All</option>
			<option value="Active" selected>Active</option>
			<option value="Open">Open</option>
			<option value="EnRoute">EnRoute</option>
			<option value="Arrive">Arrived</option>
			<option value="Cancel" >Cancelled</option>
			<option value="Completed" >Completed</option>
		 </select>
        </th><th>  
         <select id="rl_d_rdate">
			<option value="">All</option>
			<? $result = mysql_query($trip_qry." group by `req_date` order by `req_date` "); while($ts = mysql_fetch_array($result)){  ?>
			<option ><?=date('m-d-y',strtotime($ts['req_date']))?></option><? } ?></select>
          </th><th>  
        <select id="rl_d_cd">
		<option value="">All</option>
		<? $result = mysql_query($trip_qry." and contract_driver is not null and contract_driver != '' group by `contract_driver` order by `contract_driver` "); while($ts = mysql_fetch_array($result)){  ?>
		<option ><?=$ts['contract_driver']?></option><? } ?>
		</select>
          </th><th>  
        <select id="rl_d_cp">
		<option value="">All</option>
		<? $result = mysql_query($trip_qry." group by `contact_person` order by `contact_person` "); while($ts = mysql_fetch_array($result)){  ?>
		<option ><?=$ts['contact_person']?></option><? } ?>
		</select>
           </th><th> 
        <select id="rl_d_iname">
		<option value="">All</option>
		<? $result = mysql_query($trip_qry." and `item_name`!='' group by `item_name` order by trim(item_name)"); while($ts = mysql_fetch_array($result)){  ?>
		<option ><?=$ts['item_name']?></option><? } ?>
		</select>
          </th><th> 
        <select id="rl_equipment_filter" name="DeviceType" class="input" >
		<option value=''>All</option>
            <?
           $result = $conn->query("SELECT * from tbl_eqptype where if('".$_SESSION['ROLE_eqp']."'='0',1,id in (".$_SESSION['ROLE_eqp'].")) order by eq_name asc");
           while($vehicle  = $result->fetch_object())
           {
          ?>
           <option value="<?=$vehicle->eq_name?>"><?=$vehicle->eq_name?></option>
          <?  } 
          ?>
          </select>
           </th></tr> 
		   <tr><td><input type="button" id="comp_button_rel"  value="Complete Selected" disabled="disabled" style="margin-top: 5%;margin-bottom: -8%;opacity:0.5"></td></tr>
		   <table>
         </div>
 <table border="1" style="width:98%; margin-top:20px; text-align: center; font-size: 1.35rem; background-color: white;">
 <head id='tracker_head'>
 <tr>
	<th style='text-align: center;'>Complete</th>
	<th style='text-align: center;'>Relocation #</th>
	<th style='text-align: center;'>Status</th>
	<th style='text-align: center;'>Depart POI</th>
	<th style='text-align: center;'>Arrival POI2</th>
	<th style='text-align: center;'>Arrival POI3</th>
	<th style='text-align: center;'>Arrival POI4</th>
	<th style='text-align: center;'>Final POI</th>
	<th style='text-align: center;'>Date Requested</th>
	<th style='text-align: center;'>Date To Be Delivered</th>
	<th style='text-align: center;'>Contact Person</th>
	<th style='text-align: center;'>Contract Driver</th>
	<th style='text-align: center;'>Driver Phone</th>
	<th style='text-align: center;'>Item Being Delivered</th>
	<th style='text-align: center;'>Equipment #</th>
</tr> 
</thead>
   <tbody id="relocation_tbl_body">
<? include_once('relocation_tbl_body.php'); ?>
</tbody>
</table>
</center>