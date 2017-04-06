
  <!--<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <? include_once('connect.php');
   session_start();
  //print_r($_POST);
  if($_POST['time_sheet']!=''){
  $obj = $conn->query("select * from trip_sheet where time_sheet = '".$_POST['time_sheet']."'")->fetch_object();
   //print_r($obj->auto_complete);
  }
  ?>
  <style>
  
.int{
  width:17vw;
}
.datalst{
  width:6vw;
}
.datalist{
  width:5.2vw;
}
.col-sm-1{
	width: 5%;
}
.row{
margin-top:1.5vh;
text-align:left;
}
@media only screen and (max-width: 768px) {
   
    .int {
        width: 100%;
    }
    .datalist {
        width: 100%;
    }
  }
/*  @media (min-width: 768px){
.col-sm-3 {
    width: 25%;
}
}@page {
    size: A3;
    margin-left: -5cm;
    margin-right: -5cm;
    }*/
@media print {
  [class*="col-sm-"] {
    float: left;
	width:20%;
  }
  .col-sm-1{
	width:5%;
  }
  .row{
	width:100%;
	margin-left:5%;
  }
  .container-fluid{
 margin-left:5%;
 height:30vh;
  }
}

  </style>
  <div style='background:white; font-size: 1.2rem;'>
  <center>
<table width="90%" style="table-layout:fixed;">
<tr>
	<th style='text-align:left;width: 30%;'><input onclick='$("#trip_sheet_div").hide(); $("#trip_sheet_div").html("");' type="button" value="Back" /></th>
	<th style='text-align:center;width: 40%;'><h3><b>TRIP SHEET AND BILL OF LADING</b></h3></th>
	<td align="right" style='text-align:right;width: 30%;'>Time Sheet Number: <strong><?=$obj->time_sheet?></strong></td>
</tr>
<? if($obj->status!='Cancel' && $obj->status!='Completed' ) { ?>
<tr>
	<td><input type="button" id="cancel_ts" value="Cancel This Trip Sheet" onclick="del_tracker_dialog('Reason for cancellation:',<?=$obj->time_sheet?>,'cancel_trip','prompt_box');" /></td>
	<td></td>
	<td align="right" style='text-align:right;width: 30%;'><input type="button"  value="Complete This Trip Sheet" onclick="del_tracker_dialog('Are you sure you want to Complete this Trip Sheet ?',<?=$obj->time_sheet?>,'del_trip_true','');" /></td>
</tr>
<? } ?>
</table></center>
<form id="trip_form_post">
<div class="container-fluid" style="width:90%;border: 2px solid black;text-align:left; padding-bottom: 1.5vh; margin-top: 1.5vh;">
<input type="hidden" id="time_sheet" name="time_sheet" value="<?=$obj->time_sheet?>" />
<input type="hidden" name="trip_form" value="edit"  />
  <div class="row">
		<div class="col-sm-1" ></div>
		<div class="col-sm-2" >
		  <strong>Date To Be Delivered: </strong>
		</div>
		<div class="col-sm-3" >
		  <input name="del_date" id="del_date" type="date" style="background-color: rgb(206, 206, 206);" class="int" value="<?=$obj->del_date;?>">     
		</div>
		<div class="col-sm-1" ></div>
		<div class="col-sm-2" >
		 <strong>Date Requested: </strong>
		</div>
		<div class="col-sm-3" >
		 <input type="date" class="int" name="req_date" id="req_date" style="background-color: rgb(206, 206, 206);" value="<?=$obj->req_date;?>">
		</div>
   </div>

   <div class="row">
   
		<div class="col-sm-1" ></div>
		<div class="col-sm-2" >
		  <strong>Contact Person: </strong>
		</div>
		<div class="col-sm-3" >
		  <input type="text" class="int" name="contact_person" id="contact_person" style="background-color: rgb(206, 206, 206);" value="<?=$obj->contact_person;?>">     
		</div>
		<div class="col-sm-1" ></div>
		<div class="col-sm-2" >
		 <strong>Contact No.: </strong>
		</div>
		<div class="col-sm-3" >
		 <input type="text" class="int" name="contact_no" id="contact_no" style="background-color: rgb(206, 206, 206);" value="<?=$obj->contact_no;?>">
		</div>
    </div>

     <div class="row">
		<div class="col-sm-1" ></div>
		<div class="col-sm-2" >
		  <strong>Requested By: </strong>
		</div>
		<div class="col-sm-3" >
		  <input type="text" class="int" name="req_by" id="req_by" style="background-color: rgb(206, 206, 206);" value="<?=$obj->req_by;?>">  
		</div>
		<div class="col-sm-1" ></div>
		<div class="col-sm-2" >
		 <strong>Requester No. </strong>
		</div>
		<div class="col-sm-3" >
		 <input name="req_no" id="req_no" type="text" style="background-color: rgb(206, 206, 206);" class="int" value="<?=$obj->req_no;?>"/>
		</div>
    </div>

     <div class="row">
		<div class="col-sm-1" ></div>
		<div class="col-sm-2" >
		<strong>Item Being Delivered: </strong>
		</div>
		<div class="col-sm-3" >
		  <input name="item_name" id="item_name" type="text" style="background-color: rgb(206, 206, 206);" class="int" value="<?=$obj->item_name;?>"/>
		</div>
		<div class="col-sm-1" ></div>
		<div class="col-sm-2" >
		 <strong>Requester Email. </strong>
		</div>
		<div class="col-sm-3" >
			<input name="req_email" type="text" list='danny_email' class="int" value="<?=$obj->req_email;?>" />
			<datalist id='danny_email'>
			<option value='DWMARTIN@southernco.com'>
			</datalist>
		</div>
    </div>

     <div class="row">
		<div class="col-sm-1" ></div>
		<div class="col-sm-2" >
		  <strong>Trip Sheet Status : </strong>
		</div>

		<div class="col-sm-3" >
		    <input name="status" id="status" type="text" style="background-color: rgb(206, 206, 206); width:8vw;" class="int" readonly value="<?=$obj->status;?>" />
		    <? if($obj->status=='Cancel'){ ?>
		          Reason for Cancellation: <span style="color:red"><?=$obj->reason_cancel?></span>
		          <? } ?>
		    <span style='margin-top: 4px; float: right; margin-right: 3vw;'><input name="auto_complete" type='checkbox' style='margin-bottom: 0px; float: left;' <? if($obj->auto_complete==1){?> checked="checked" <? } ?> value='1'>&nbsp;Auto Complete </span>
		  </div>

			<div class="col-sm-1" ></div>
		<div class="col-sm-2" >
		 <strong>Dispatcher </strong>
		</div>
		<div class="col-sm-3" >
		 <select id="Dispatcher" name="dispatcher" class="int" style="" >
				<?php
				$result = $conn->query("select * from tbl_dispatcher order by `id`");
				 while($disp = $result->fetch_object())
				 { ?>
				   <OPTION VALUE='<?=$disp->id?>' <? if($disp->id==$obj->dispatcher_id){ ?><?="selected"?><? } ?>><?=$disp->name?><? if($disp->id!='0'){ ?><?="(".$disp->id.")"?><? } ?></option>
				<?  }
				?>
			</select>
		</div>
    </div>
<script>
$("#contract_driver").on('input', function() {
$("#driver_phone").val(get_phone($("#contract_driver").val().toLowerCase()));
});
</script>
     <div class="row">
		<div class="col-sm-1" ></div>
		<div class="col-sm-2" >
		<datalist id='driver_list' >
		<?php
				$result = mysql_query("select name_driver,number_phone from tbl_driver order by name_driver");
				 while($row = mysql_fetch_array($result))
				 {
					echo "<option data-value=".$row["number_phone"]." value=".$row["name_driver"]."></option>";
					}
				?>
		</datalist>
		 <strong>Contract Driver </strong>
		</div>
		<div class="col-sm-3" >
		  <input name="contract_driver" id="contract_driver" list='driver_list' type="text" class="int" value="<?=$obj->contract_driver;?>" style=""/>
		</div>
		<div class="col-sm-1" ></div>
		<div class="col-sm-2" >
			<strong>Driver Phone </strong>  
		</div>
		<div class="col-sm-3" >
		  <input id="driver_phone" name="driver_phone" type="text" class="int" style="" value="<?=$obj->driver_phone;?>"/>
		</div>
    </div>

     <div class="row">
		<div class="col-sm-1" ></div>
		<div class="col-sm-2" >
		  <strong>Notes (PLEASE READ): </strong>
		</div>
		<div class="col-sm-3" >
		  <textarea name="notes" cols="90" class="int" style=""><?=$obj->notes;?></textarea>
		</div>
		<div class="col-sm-1" ></div>
		<div class="col-sm-2" >
		 <strong>Tracked Equipment Type </strong>
		</div>
		<div class="col-sm-3" >
		<select id="equip_type" name="equip_type" class="int" style="">
			   <option value="All">All</option>
			   <?php
				$result = $conn->query("SELECT * from tbl_eqptype where if('".$_SESSION['ROLE_eqp']."'='0',1,id in (".$_SESSION['ROLE_eqp'].")) order by eq_name asc");
				 while($vehicle = $result->fetch_object())
				 {
				 ?>
				   <option <? if($vehicle->eq_name==$obj->eqp_type){ echo "selected"; } ?> ><?=$vehicle->eq_name?></option>
				<?  } 
				 ?>
				 <option>Not Tracked</option>
			</select>
		</div>
    </div>

     <div class="row">
		<div class="col-sm-1" ></div>
		<div class="col-sm-2" >
		  <strong>Equipment Numbers </strong>
		</div>
		<div class="col-sm-3" >
		  <input name="equip_no1" type="text" class="datalist" style="" value="<?=$obj->equip_no1?>"/> 
		  <input name="equip_no2" type="text" class="datalist" style="" value="<?=$obj->equip_no2?>"/> 
		  <input name="equip_no3" type="text" class="datalist" value="<?=$obj->equip_no3?>"/> 
		  <input id="veh_name_hidden" name="veh_no" type="hidden" value="<?=$obj->veh_no?>"/>
		</div>
		<div class="col-sm-1" ></div>
		<div class="col-sm-2" >
		 <strong>Tracked Equipment #</strong>
		</div>
		<div class="col-sm-3" >
			<datalist id="browsers">
				<?php
				$result = $conn->query("select trim(DeviceName) as 'DeviceName',DeviceIMEI from devicedetails where DeviceType in (SELECT eq_name from tbl_eqptype where if('".$_SESSION['ROLE_eqp']."'='0',1,id in (".$_SESSION['ROLE_eqp'].")) order by eq_name asc)");
				 while($vehicle = $result->fetch_object())
				 {?>
					 <option data-value="<?=$vehicle->DeviceIMEI?>" value="<?=$vehicle->DeviceName?>" <? if($obj->veh_no == $vehicle->DeviceIMEI){ $vehname = $vehicle->DeviceName; } ?>></option>
				<? }
				?>
			</datalist>
			<input id="veh_name" value="<?=$vehname?>" type="browsers" list="browsers" style="background-color: rgb(206, 206, 206);"  class="int"/>
		</div>
    </div>

</div>
<div class="container-fluid" style="width:90%;border: 2px solid black;margin-top:1vh;">
  
  <div class="row" style="margin-top:1.5vh;">
	<div class="col-sm-1" ></div>
    <div class="col-sm-2" >
      <strong>Bobtail Miles: </strong>
    </div>
    <div class="col-sm-3" >
      <input name="bobtail_miles" type="text" class="int" style="margin-bottom: .5vh;margin-top:.5vh;" value="<?=$obj->bobtail_miles?>"/>    
    </div>
	<div class="col-sm-1" ></div>
    <div class="col-sm-2" >
     <strong>w/Trailer Miles: </strong>
    </div>
    <div class="col-sm-3" >
     <input name="trail_miles" type="text" class="int" style="margin-bottom: .5vh;margin-top:.5vh;" value="<?=$obj->trail_miles?>"/>
    </div>
    </div>
     <div class="row" >
	<div class="col-sm-1" ></div>
    <div class="col-sm-2" >
      <strong>Dispatch Miles: </strong>
    </div>
    <div class="col-sm-3" >
      <input id="disp_miles" name="disp_miles" type="text" class="int" style="margin-bottom: .5vh;margin-top:.5vh;" value="<?=$obj->disp_miles?>"/><div id='wait_for_miles' style="color:red; clear: both; display:none;"><img src="image/spinner.gif" width="10px">Please wait...</div> <input id="calc_miles" type="button" value="Calculate miles" />    
    </div>
	<div class="col-sm-1" ></div>
    <div class="col-sm-2" >
     <strong>Trip Type: </strong>
    </div>
    <div class="col-sm-3" >
     <select id="trip_type" name="trip_type" onchange="return dist();" class="int" style="margin-bottom: .5vh;margin-top:.5vh;">
		 <option value="2" >Round Trip</option>
		 <option value="1" <? if($obj->depart_poi!=$obj->arrival_poi || $obj->depart_add!=$obj->arrival_add){ ?>selected<? } ?>>One Way</option>
	 </select>
    </div>
    </div>
<? include_once('substationjson.php'); ?>
		<datalist id="poi_list" ><?=$substation_dl?></datalist>   
		
	<div class="row" >
	<div class="col-sm-1" ></div>
    <div class="col-sm-2" >
      <strong>Departure POI: </strong>
    </div>
    <div class="col-sm-3" >
     <input name="depart_poi" type="text" list="poi_list" id="depart_poi1" style="background-color: rgb(206, 206, 206); margin-bottom: .5vh;margin-top:.5vh;" class="int" value="<?=$obj->depart_poi?>"/>
    </div>
	<div class="col-sm-1" ></div>
  <div class="col-sm-2" >
       <strong>Departure Date/Time: </strong>
  </div> 
  <div class="col-sm-3" >
        <input name="depart_time" value="<? if($obj->depart_time!='') { echo date('m/d/Y h:i A',strtotime($obj->depart_time)); } ?>" disabled class="int">
        </div>
    </div>

 <div class="row" id="d_add" <? if($obj->depart_add==''){ ?> style='display:none;' <? } ?> >
     <div class="col-sm-1" ></div>
        
   <div class="col-sm-2" >
    <strong>Departure Address: </strong>
   </div>
   <div class="col-sm-3" >
    <input type="text" id="depart_add" name="depart_add"  style="background-color: rgb(206, 206, 206);margin-bottom: .5vh;margin-top:.5vh;" class="int" value="<?=$obj->depart_add?>"/> 
   </div>
   </div>
     
      <input type="hidden" name="dlati" id="dlati" value="<?=$obj->dlati?>" />
  <input type="hidden" name="dlongi" id="dlongi" value="<?=$obj->dlongi?>" />
  <input type="hidden" name="alati" id="alati" value="<?=$obj->alati?>" />
  <input type="hidden" name="alongi" id="alongi" value="<?=$obj->alongi?>" />
  <input type="hidden" name="gotlocation" id="gotlocation" value="1" />
  <? $result = $conn->query("select * from tripsheet_other_poi where `tsn`='".$obj->time_sheet."'");
      ?>

      <? $onclick=5; ?>
      <?for($btn=1;$btn<=5;$btn++){ ?>
        <div  id='poi<?=$btn?>' <? if(!($other_poi =$result->fetch_object()))  { ?> style='display:none;' <? $onclick--; } ?> >
    <div class="row">
      <div class="col-sm-1"></div>
      <div class="col-sm-2">
        <strong>Arrival POI<?=$btn?>: </strong>
      </div>
      <div class="col-sm-3" >
       <input name="o_poi<?=$btn?>" list="poi_list" id="o_poi<?=$btn?>" class="int" style="" value="<?=$other_poi->poi?>" <? if($other_poi->is_in=='1' || $other_poi->is_out=='1'){ ?> disabled <? } ?> />
      </div>

     <div class="col-sm-1" ></div>
     <span id="a_add<?=$btn?>" <? if($other_poi->add==''){ ?> style='display:none;' <? } ?> >
  	   <div class="col-sm-2"  >
  		Arrival Address<?=$btn?>: 
  		</div>
  		<div class="col-sm-3" >
  		<input id="o_add<?=$btn?>" name="o_add<?=$btn?>" value="<?=$other_poi->add?>" class="int" >
  		<input type="hidden" name="lati<?=$btn?>" id="lati<?=$btn?>" value="<?=$other_poi->lati_o?>" class="int" style="" >
  		<input type="hidden" name="longi<?=$btn?>" id="longi<?=$btn?>" value="<?=$other_poi->longi_o?>" class="int" style=""/>
  		</div>
  	</span>
    </div>
    <div class="row">
  	  <div class="col-sm-1"></div>
      <div class="col-sm-2"  >
        <strong>Arrival Date/Time<?=$btn?>: </strong>
      </div>
      <div class="col-sm-3" >
       <input name="arrival_time<?=$btn?>" value="<? if($other_poi->arrival_time!='') { echo date_format(date_add(date_create($other_poi->arrival_time), date_interval_create_from_date_string('2 hours')),"m-d-y h:iA"); } 
          ?>" readonly disabled  class="int"> 
      </div>
      <div class="col-sm-1" ></div>
      <div class="col-sm-2" style="">
       <strong>Departure Date/Time<?=$btn?>: </strong>
      </div>
      <div class="col-sm-3" >
       <input name="depart_time<?=$btn?>" value="<? if($other_poi->depart_time!='') { echo date_format(date_add(date_create($other_poi->depart_time), date_interval_create_from_date_string('2 hours')),"m-d-y h:iA"); } 
      ?>" readonly disabled  class="int" style="">
      </div>
    </div>
  </div>
	<?}?>
	   <div class="row" >
		 <div class="col-sm-1" ></div>
		 <div class="col-sm-2" ></div>
		 <div class="col-sm-3" >
			 <input type='button' id="addpoi" <? if($onclick=='5'){ ?> style='display:none;' <? } ?> onclick="show_poi('#poi_<?=++$onclick?>')" value='Add Another POI' >
			 <input type='button' id="rempoi" <? if($onclick=='1'){ ?> style='display:none;' <? } ?> onclick="remove_poi('#poi_<?=--$onclick?>')" value='Delete POI' >
		 </div>
		
		</div>
     <div class="row" >
     <div class="col-sm-1" ></div>
    <div class="col-sm-2" >
      <strong>Final Arrival POI: </strong>
    </div>
    <div class="col-sm-3" >
      <input type="text" name="arrival_poi" list="poi_list" id="arrival_poi" style="background-color: rgb(206, 206, 206); margin-bottom: .5vh;margin-top:.5vh;" class="int" value='<?=$obj->arrival_poi?>'/>
    </div>
	<div class="col-sm-1" ></div>
  <div class="col-sm-2" >
   <strong>Arrival Date/Time: </strong>
  </div> 
  <div class="col-sm-3" >
   <input name="depart_time" value="<? if($obj->arrival_time!='') { echo date('m/d/Y h:i A',strtotime($obj->arrival_time)); } ?>" disabled class="int">
  </div>
 </div>
 
 <div class="row" id="a_add"  <? if($obj->arrival_add==''){ ?> style='display:none;' <? } ?>>
     <div class="col-sm-1" ></div>
      
   <div class="col-sm-2" >
    <strong>Arrival Address: </strong>
   </div>
   <div class="col-sm-3" >
    <input type="text" id="arrival_add" name="arrival_add"  style="background-color: rgb(206, 206, 206);margin-bottom: .5vh;margin-top:.5vh;" class="int" value='<?=$obj->arrival_add?>'/>
   </div>
    
    </div>
     <div class="row" >
     <div class="col-sm-1" ></div>
    <div class="col-sm-2"  >
      <strong>Print GPC Rep: </strong>
    </div>
    <div class="col-sm-3" >
     <input name="print_rep" type="text" class="int" style="margin-bottom: .5vh;margin-top:.5vh;" value="<?=$obj->print_rep?>"/>
    </div>
    <div class="col-sm-1" ></div>
    <div class="col-sm-2" >
     <strong>Sign GPC Rep: </strong>
    </div>
    <div class="col-sm-3" >
     <input name="sign_rep" type="text" class="int" style="margin-bottom: .5vh;margin-top:.5vh;" value="<?=$obj->sign_rep?>" />
    </div>
    </div><br>

    
</div><br>
<script src="dir_dis.js" ></script>
<script>

$("#equip_type").on('change', function() {
var equip_type = $("#equip_type").val();
if(equip_type!='Not Tracked') {
    $.post( "get_eqp_trip.php",{ equip_type: equip_type },function(data) {
    $("#browsers").empty();
    $("#veh_name").val("");
    $("#browsers").html(data);
    $("#depart_poi1").val("");  
    }); 
  }
  else { 
  $("#veh_name").val("Not Tracked");
  $("#browsers").html("<option value='Not Tracked'></option>");
  }
});
$("#calc_miles").click( function() { 
calc_miles_click($("#depart_poi1").val(),$("#depart_add").val(),$("#dlati").val(),$("#dlongi").val(),
				 $("#arrival_poi").val(),$( "#arrival_add" ).val(),$("#alati").val(),$("#alongi").val(),
				 $("#o_poi1").val(),$("#o_add1").val(),$("#lati1").val(),$("#longi1").val(),
				 $("#o_poi2").val(),$("#o_add2").val(),$("#lati2").val(),$("#longi2").val(),
				 $("#o_poi3").val(),$("#o_add3").val(),$("#lati3").val(),$("#longi3").val(),
				 $("#o_poi4").val(),$("#o_add4").val(),$("#lati4").val(),$("#longi4").val(),
				 $("#o_poi5").val(),$("#o_add5").val(),$("#lati5").val(),$("#longi5").val());
});
$("#depart_poi1,#arrival_poi,#o_poi1,#o_poi2,#o_poi3,#o_poi4,#o_poi5").on('input', function() {
poi_change(); 
});
$(document).ready(function() {
calc_miles_click($("#depart_poi1").val(),$("#depart_add").val(),$("#dlati").val(),$("#dlongi").val(),
				 $("#arrival_poi").val(),$( "#arrival_add" ).val(),$("#alati").val(),$("#alongi").val(),
				 $("#o_poi1").val(),$("#o_add1").val(),$("#lati1").val(),$("#longi1").val(),
				 $("#o_poi2").val(),$("#o_add2").val(),$("#lati2").val(),$("#longi2").val(),
				 $("#o_poi3").val(),$("#o_add3").val(),$("#lati3").val(),$("#longi3").val(),
				 $("#o_poi4").val(),$("#o_add4").val(),$("#lati4").val(),$("#longi4").val(),
				 $("#o_poi5").val(),$("#o_add5").val(),$("#lati5").val(),$("#longi5").val());
});
</script>

<center><div class="trip" id="cost" style="margin:10px;border:2px solid black; padding:10px; font-weight:600; align:center; min-width:1000px; width:90%;">
<div class="container">           
  <div class="table-responsive">          
  <table class="table">
    <thead>
      <tr>
        <th >PRCN</th><th>CT</th><th>ACTV</th><th>EWO</th><th>PROJ</th><th>LOC</th><th>FERC</th><th>SUB</th><th>RRCN</th><th>AL</th><th>Total</th>
      </tr>
    </thead>
   <?php  
$qry = $conn->query("select * from trip_cost where trip_id = '".$obj->id."'");
		 	//$result = mysql_query($qry);			
?>
   <tbody>
<?
for($i=1;$i<=4;$i++) { 
$cost = $qry->fetch_object();
?>

    <tr align="center">
    <td><input name="prcn<?=$i?>" type="text" value="<?=$cost->prcn?>" class="datalst"/></td>
    <td><input name="ct<?=$i?>" type="text" value="<?=$cost->ct?>" class="datalst"/></td>
	<td><input name="actv<?=$i?>" type="text" value="<?=$cost->actv?>" class="datalst"/></td>
	<td><input name="ewo<?=$i?>" type="text" value="<?=$cost->ewo?>" class="datalst"/></td>
	<td><input name="proj<?=$i?>" type="text" value="<?=$cost->proj?>" class="datalst"/></td>
	<td><input name="loc<?=$i?>" type="text" value="<?=$cost->loc?>" class="datalst"/></td>
	<td><input name="ferc<?=$i?>" type="text" value="<?=$cost->ferc?>" class="datalst"/></td>
	<td><input name="sub<?=$i?>" type="text" value="<?=$cost->sub?>" class="datalst"/></td>
	<td><input name="rrcn<?=$i?>" type="text" value="<?=$cost->rrcn?>" class="datalst"/></td>
	<td><input name="al<?=$i?>" type="text" value="<?=$cost->al?>" class="datalst"/></td>
	<td><input name="total<?=$i?>" type="text" value="<?=$cost->total?>" class="datalst"/></td>
    </tr>
<?php } ?>
    </tbody>
  </table>
  </div>
</div>

	<div class="row" style="margin-bottom:1vh;">
	 <div class="col-sm-9" style="">
		Approved: <input name="approved" type="text" style="width:200px;" value="<?=$obj->approved?>" /> 
		</div>
		<div class="col-sm-3" style="">
		Total Cost: <input name="total_cost" type="text" value="<?=$obj->total_cost?>" />
		</div>
	</div>
</div></center>


<center><div class="container-fluid trip" style="width:90%;border:2px solid black;margin-bottom:1vh;">

<h3>Trip Completed</h3>
  <div class="row" style="margin-bottom:1vh;">
    <div class="col-sm-9" style="">
Driver Signature: <input name="driver_sign" type="text" value="<?=$obj->driver_sign?>" readonly/>
</div>
    <div class="col-sm-3" style="">
Date: <input name="complete_date" type="date" value="<?=$obj->complete_date?>" readonly/>
</div>
  </div>
</div></center>

<script type="text/javascript">

var count = 0 ;

function form_sub() 
{ 

if (($( "#req_date" ).val().trim() == "") || ($( "#del_date" ).val().trim() == "") || ($( "#contact_person" ).val().trim() == "") || ($( "#contact_no" ).val().trim() == "") || ($( "#req_by" ).val().trim() == "") || ($( "#req_no" ).val().trim() == "") || ($( "#item_name" ).val().trim() == "") || ($( "#status" ).val().trim() == "")) {
		  alert("All Required fields must be filled out");
		  return false;
      }
      else if ($( "#veh_name" ).val().trim() == "") {
		  alert("Tracked Equipment # must be filled out");
		  $( "#veh_name" ).focus();
		  return false;
      }
      else if (($( "#depart_poi1" ).val().toLowerCase().trim() == "address") && ($( "#depart_add" ).val().trim() == "")) {
		  alert("Departure Address must be filled out");
		  $( "#depart_poi1" ).focus();
		  return false;
      }
      else if (($( "#depart_poi1" ).val().trim() == "")) {
		  alert("Departure POI must be filled out");
		  $( "#depart_poi1" ).focus();
		  return false;
      }
      else if (($( "#arrival_poi" ).val().toLowerCase().trim() == "address") && ($( "#arrival_add" ).val().trim() == "")) {
		  alert("Arrival Address must be filled out");
		  $( "#arrival_poi" ).focus();
		  return false;
      }
      else if (($( "#arrival_poi" ).val().trim() == "")) {
		  alert("Arrival POI must be filled out");
		  $( "#arrival_poi" ).focus();
		  return false;
      }
	  else if (($( "#trip_type" ).val()== "2") && (($("#o_poi1" ).val().toLowerCase().trim() == "address") && ($("#o_add1" ).val().trim() == "")) ) {
		  if($('#poi1').css('display') == 'none')
			{
			show_poi('#poi_1');
			}
		  alert("Atleast one poi must be filled out for round trip");
		  $( "#o_add1" ).focus();
		  return false;
      }
	  else if (($( "#trip_type" ).val()== "2") && ($( "#o_poi1" ).val().trim() == "") ) {
		   if($('#poi1').css('display') == 'none')
			{
			show_poi('#poi_1');
			}
		  alert("Atleast one poi must be filled out for round trip");
		  $( "#o_poi1" ).focus();
		  return false;
      }
	  else{
        $("#submit_button").val("Saving Tripsheet ...");
		$("#ts_refresh_spinner").show();
          $.ajax({
            type: 'post',
            url: 'tripsheet_query.php',
            data: $('#trip_form_post').serialize(),
            success: function (data) {
				//alert(data);
			$("#trip_sheet_div").hide();
			$("#trip_sheet_tbl_body").load('trip_tbl_body.php');
			$("#trip_sheet_div").html("");
            }, 
      error: function (xhr) 
      {
        count++;
        $("#submit_button").val("Please wait. Retrying to save Tripsheet ...count " + count);
        setTimeout(function(){
          form_sub();
        }, 2000);
      }

      });
     }
      
}

  function PrintElem(){
	  document.createElement('ifrmPrint');
	  $("#views").hide();
      try{
        var oIframe = document.getElementById('ifrmPrint');
        var oContent = document.getElementById('trip_sheet_div').innerHTML;
		alert(oContent);
        var oDoc = (oIframe.contentWindow || oIframe.contentDocument);
        if (oDoc.document) oDoc = oDoc.document;
        oDoc.write('<head><title>title</title>');
        oDoc.write("</head><body onload=' this.print();'>");
        oDoc.write(oContent + '</body>');
        oDoc.close();
      } catch(e){
        self.print();
      }
    }
/**/
    function PrintElem1() 
    {    
        //window.print();
		//alert('test');
		  var divToPrint = document.getElementById('trip_sheet_div');
           var popupWin = window.open('', '_blank' );
           popupWin.document.open();
           popupWin.document.write('<html><body width="100%" onload="window.print()" >' + divToPrint.innerHTML + '</body></html>');
            popupWin.document.close();/**/
      //return true;
    }
</script>
  <center><? if($obj->status!='Cancel' && $obj->status!='Completed' ) { ?>
	  <input id="submit_button" type="button" value="Save" onclick="form_sub();"  />
	  <? } ?>
	  </form> 
	  <!-- <a target='_blank' href='trip_pdf.php?tsn=<?=$obj->time_sheet?>' ><input type="button" value="Print" /></a> -->
	  <a target='_blank' href="trip_pdf.php?tsn=<?=$obj->time_sheet?>&map_true=0" ><input type="button" value="Print" /></a>
	  <a target='_blank' href="trip_pdf.php?tsn=<?=$obj->time_sheet?>&map_true=1" ><input type="button" value="Print With Map" /></a>
	  <input onclick='$("#trip_sheet_div").hide();' type="button" value="Close" />
  </center>

<div class="row" style="margin-bottom:1vh; margin-left: 22vh;">
	 <div class="col-sm-9" style="">
		Any Questions Call Radio <strong>29710</strong>
		</div>
		<div class="col-sm-3" style="">
		After Hours Phone <strong>770-262-0560</strong>
		</div>
	</div>

</div>
<div id="direction_url" style="display:;background:white;">
<center><iframe id="dir" src="" width="90%" height="400"></iframe>
<div id="direction" style=' text-align: left; /*margin-left: 20vh;*/width:90%;  font-size: 1.2rem;'></div></center>
</div><!--direction_url close-->
</div>