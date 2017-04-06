
  <!--<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <? include_once('connect.php'); 
  session_start();
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
	<td align="right" style='text-align:right;width: 30%;'>Time Sheet Number: <strong><? date_default_timezone_set("EST5EDT"); ?><span id="trip_sheet_no"><?=$trip_no = date('YmdHis')?></span></strong></td>
</tr>
</table></center>
<form id="trip_form_post" method='post' target='_blank' action='new_trip_pdf.php'>
<div class="container-fluid" style="width:90%;border: 2px solid black;text-align:left; padding-bottom: 1.5vh;">
<input type="hidden" id="time_sheet" name="time_sheet" value="<?=$trip_no?>" />
<input type="hidden" name="ts_or_rl" value='ts' >
<input type="hidden" name="trip_form" value="new"  />
  <div class="row">
		<div class="col-sm-1" ></div>
		<div class="col-sm-2" >
		  <strong>Date To Be Delivered: </strong>
		</div>
		<div class="col-sm-3" >
		  <input name="req_date" id="req_date" type="date" style="background-color: rgb(206, 206, 206);" class="int" value=<?php print(date("Y-m-d"));?>>     
		</div>
		<div class="col-sm-1" ></div>
		<div class="col-sm-2" >
		 <strong>Date Requested: </strong>
		</div>
		<div class="col-sm-3" >
		 <input type="date" class="int"  name="del_date" id="del_date" style="background-color: rgb(206, 206, 206);">
		</div>
   </div>

   <div class="row">
   
		<div class="col-sm-1" ></div>
		<div class="col-sm-2" >
		  <strong>Contact Person: </strong>
		</div>
		<div class="col-sm-3" >
		  <input type="text" class="int" name="contact_person" id="contact_person" style="background-color: rgb(206, 206, 206);">     
		</div>
		<div class="col-sm-1" ></div>
		<div class="col-sm-2" >
		 <strong>Contact No.: </strong>
		</div>
		<div class="col-sm-3" >
		 <input type="text" class="int" name="contact_no" id="contact_no" style="background-color: rgb(206, 206, 206);">
		</div>
    </div>

     <div class="row">
		<div class="col-sm-1" ></div>
		<div class="col-sm-2" >
		  <strong>Requested By: </strong>
		</div>
		<div class="col-sm-3" >
		  <input type="text" class="int" name="req_by" id="req_by" style="background-color: rgb(206, 206, 206);">  
		</div>
		<div class="col-sm-1" ></div>
		<div class="col-sm-2" >
		 <strong>Requester No. </strong>
		</div>
		<div class="col-sm-3" >
		 <input name="req_no" id="req_no" type="text" style="background-color: rgb(206, 206, 206);" class="int"/>
		</div>
    </div>

     <div class="row">
		<div class="col-sm-1" ></div>
		<div class="col-sm-2" >
		<strong>Item Being Delivered: </strong>
		</div>
		<div class="col-sm-3" >
		  <input name="item_name" id="item_name" type="text" style="background-color: rgb(206, 206, 206);" class="int"/>
		</div>
		<div class="col-sm-1" ></div>
		<div class="col-sm-2" >
		 <strong>Requester Email. </strong>
		</div>
		<div class="col-sm-3" >
			<input name="req_email" type="text" list='danny_email' class="int"/>
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
		  <input name="status" id="status" type="text" value=" Open" style="background-color: rgb(206, 206, 206); width: 8vw;" class="int" readonly/>&nbsp;
		  <span style='margin-top: 4px; float: right; margin-right: 3vw;'><input name="auto_complete" type='checkbox' style='margin-bottom: 0px; float: left;' value='1'>&nbsp;Auto Complete </span>
		</div>
			<div class="col-sm-1" ></div>
		<div class="col-sm-2" >
		 <strong>Dispatcher </strong>
		</div>
		<div class="col-sm-3" >
		 <select id="Dispatcher" name="dispatcher" class="int" style="" >
				<?php
				$result = mysql_query("select * from tbl_dispatcher order by `id`");
				 while($row = mysql_fetch_array($result))
				 { ?>
				   <OPTION VALUE='<?=$row["id"]?>'><?=$row['name']?><? if($row['id']!='0'){ ?><?="(".$row['id'].")"?><? } ?></option>
				<?  }
				?>
			</select>
		</div>
    </div>
<script>
function get_phone(qwe){
var dpoi = $('#driver_list option').filter(function() {  return this.value.toLowerCase() == qwe;  }).data('value');
return dpoi;
}
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
	 <input name="contract_driver" id="contract_driver" list='driver_list' type="text" class="int" style=""/>
		</div>
		<div class="col-sm-1" ></div>
		<div class="col-sm-2" >
			<strong>Driver Phone </strong>  
		</div>
		<div class="col-sm-3" >
		  <input id="driver_phone" name="driver_phone" type="text" class="int" style=""/>
		</div>
    </div>

     <div class="row">
		<div class="col-sm-1" ></div>
		<div class="col-sm-2" >
		  <strong>Notes (PLEASE READ): </strong>
		</div>
		<div class="col-sm-3" >
		  <textarea name="notes" cols="90" class="int" rows='3'> </textarea>
		</div>
		<div class="col-sm-1" ></div>
		<div class="col-sm-2" >
		 <strong>Tracked Equipment Type </strong>
		</div>
		<div class="col-sm-3" >
		<select id="equip_type" name="equip_type" class="int" style="">
			  <option value="All">All</option>
			   <?php
				$result = mysql_query("SELECT * from tbl_eqptype where if('".$_SESSION['ROLE_eqp']."'='0',1,id in (".$_SESSION['ROLE_eqp'].")) order by eq_name asc");
				 while($vehicle = mysql_fetch_array($result))
				 {
				 ?>
				   <option><?=$vehicle["eq_name"]?></option>
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
		  <input name="equip_no1" type="text" class="datalist" style=""/> 
		  <input name="equip_no2" type="text" class="datalist" style=""/> 
		  <input name="equip_no3" type="text" class="datalist"/> 
		  <input id="veh_name_hidden" name="veh_no" type="hidden" />
		</div>
		<div class="col-sm-1" ></div>
		<div class="col-sm-2" >
		 <strong>Tracked Equipment #</strong>
		</div>
		<div class="col-sm-3" >
		<input id="veh_name" type="browsers" list="browsers" style="background-color: rgb(206, 206, 206);"  class="int"/></span>
			<datalist id="browsers">
				<?php
				$result = mysql_query("select trim(DeviceName) as 'DeviceName',DeviceIMEI from devicedetails where DeviceType in (SELECT eq_name from tbl_eqptype where if('".$_SESSION['ROLE_eqp']."'='0',1,id in (".$_SESSION['ROLE_eqp'].")) order by eq_name asc)");
				 while($row = mysql_fetch_array($result))
				 {
					echo "<option data-value=".$row["DeviceIMEI"]." value=".$row["DeviceName"]."></option>";
				 }
				?>
			</datalist>
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
      <input name="bobtail_miles" type="text" class="int" style="margin-bottom: .5vh;margin-top:.5vh;"/>    
    </div>
	<div class="col-sm-1" ></div>
    <div class="col-sm-2" >
     <strong>w/Trailer Miles: </strong>
    </div>
    <div class="col-sm-3" >
     <input name="trail_miles" type="text" class="int" style="margin-bottom: .5vh;margin-top:.5vh;"/>
    </div>
    </div>
     <div class="row" >
	<div class="col-sm-1" ></div>
    <div class="col-sm-2" >
      <strong>Dispatch Miles: </strong>
    </div>
    <div class="col-sm-3" >
      <input id="disp_miles"  name="disp_miles" type="text" class="int" style="margin-bottom: .5vh;margin-top:.5vh;"/><div id='wait_for_miles' style="color:red; clear: both; display:none;"><img src="image/spinner.gif" width="10px">Please wait...</div> <input id="calc_miles" type="button" value="Calculate miles" />    
    </div>
	<div class="col-sm-1" ></div>
    <div class="col-sm-2" >
     <strong>Trip Type: </strong>
    </div>
    <div class="col-sm-3" >
     <select id="trip_type" name="trip_type" onchange="return dist();" class="int" style="margin-bottom: .5vh;margin-top:.5vh;">
		 <option value="2" >Round Trip</option>
		 <option value="1" >One Way</option>
	 </select>
    </div>
    </div>

	<div class="row" >
	<div class="col-sm-1" ></div>
    <div class="col-sm-2" >
      <strong>Departure POI: </strong>
    </div>
    <div class="col-sm-3" >
     <input name="depart_poi" type="text" list="poi_list" id="depart_poi1" style="background-color: rgb(206, 206, 206); margin-bottom: .5vh;margin-top:.5vh;" class="int"/>
    </div>
	<div class="col-sm-1" ></div>
	<span id="d_add">
		<div class="col-sm-2" >
		 <strong>Departure Address: </strong>
		</div>
		<div class="col-sm-3" >
		 <input type="text" id="depart_add" name="depart_add"  style="background-color: rgb(206, 206, 206);margin-bottom: .5vh;margin-top:.5vh;" class="int"/> 
		</div>
	</span>
    </div>
     
      <input type="hidden" name="dlati" id="dlati" value="" />
  <input type="hidden" name="dlongi" id="dlongi" value="" />
  <input type="hidden" name="alati" id="alati" value="" />
  <input type="hidden" name="alongi" id="alongi" value="" />
  <input type="hidden" name="gotlocation" id="gotlocation" value="1" />
  <?for($btn=1;$btn<=5;$btn++){ ?>
  <div class="row" id='poi<?=$btn?>' <? if($btn!=1){ ?> style='display:none;' <? } ?>>
  <div class="col-sm-1" ></div>
    <div class="col-sm-2"  >
      
      <strong>Arrival POI<?=$btn?>: </strong>
    </div>
    <div class="col-sm-3" >
     <input name="o_poi<?=$btn?>" type="text" list="poi_list" id="o_poi<?=$btn?>" class="int" style="margin-bottom: .5vh;margin-top:.5vh;"/>
    </div>
   <div class="col-sm-1" ></div>
   <span id="a_add<?=$btn?>" style='display:none;'>
	   <div class="col-sm-2"  >
		Arrival Address<?=$btn?>: 
		</div>
		<div class="col-sm-3" >
		<input id="o_add<?=$btn?>" name="o_add<?=$btn?>" class="int" />
		<input type="hidden" name="lati<?=$btn?>" id="lati<?=$btn?>" value="<?=$other_poi["lati_o"]?>" class="int" style="margin-bottom: .5vh;margin-top:.5vh;"/>
		<input type="hidden" name="longi<?=$btn?>" id="longi<?=$btn?>" value="<?=$other_poi["longi_o"]?>" class="int" style="margin-bottom: .5vh;margin-top:.5vh;"/>
		</div>
	</span>
    </div><?}?>
		<div class="row" >
		 <div class="col-sm-1" ></div>
		 <div class="col-sm-2" ></div>
		 <div class="col-sm-3" >
			 <input type='button' onclick="show_poi('#poi_2')" id="addpoi" value='Add Another POI' >
			 <input type='button' id="rempoi" onclick="remove_poi('#poi_2')" value='Delete POI' style="display:none;">
		 </div>
		</div>
     <div class="row" >
     <div class="col-sm-1" ></div>
    <div class="col-sm-2" >
      <strong>Final Arrival POI: </strong>
    </div>
    <div class="col-sm-3" >
      <input name="arrival_poi" list="poi_list" id="arrival_poi" style="background-color: rgb(206, 206, 206); margin-bottom: .5vh;margin-top:.5vh;" class="int"/>
    </div>
    <div class="col-sm-1" ></div>
	<span id="a_add" >
		<div class="col-sm-2" >
		 <strong>Arrival Address: </strong>
		</div>
		<div class="col-sm-3" >
		 <input type="text" id="arrival_add" name="arrival_add"  style="background-color: rgb(206, 206, 206);margin-bottom: .5vh;margin-top:.5vh;" class="int"/>
		</div>
	</span>
    </div>
     <div class="row" >
     <div class="col-sm-1" ></div>
    <div class="col-sm-2"  >
      <strong>Print GPC Rep: </strong>
    </div>
    <div class="col-sm-3" >
     <input name="print_rep" type="text" class="int" style="margin-bottom: .5vh;margin-top:.5vh;"/>
    </div>
    <div class="col-sm-1" ></div>
    <div class="col-sm-2" >
     <strong>Sign GPC Rep: </strong>
    </div>
    <div class="col-sm-3" >
     <input name="sign_rep" type="text" class="int" style="margin-bottom: .5vh;margin-top:.5vh;"/>
    </div>
    </div><br>

<script src="dir_dis.js" ></script>
</div><br>
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
    <tbody>
      <tr align="center">
<td><input name="prcn1" type="text" class="datalst" /></td><td><input name="ct1" type="text" class="datalst" /></td><td><input name="actv1" type="text" class="datalst" /></td><td><input name="ewo1" type="text" class="datalst" /></td><td><input name="proj1" type="text" class="datalst" /></td><td><input name="loc1" type="text" class="datalst" /></td><td><input name="ferc1" type="text" class="datalst" /></td><td><input name="sub1" type="text" class="datalst" /></td><td><input name="rrcn1" type="text" class="datalst" /></td><td><input name="al1" type="text" class="datalst" /></td><td><input name="total1" type="text" class="datalst" /></td>
</tr>
<tr align="center">
<td class="datalst"><input name="prcn2" type="text" class="datalst" /></td><td><input name="ct2" type="text" class="datalst" /></td><td><input name="actv2" type="text" class="datalst" /></td><td><input name="ewo2" type="text" class="datalst" /></td><td><input name="proj2" type="text" class="datalst" /></td><td><input name="loc2" type="text" class="datalst" /></td><td><input name="ferc2" type="text" class="datalst" /></td><td><input name="sub2" type="text" class="datalst" /></td><td><input name="rrcn2" type="text" class="datalst" /></td><td><input name="al2" type="text" class="datalst" /></td><td><input name="total2" type="text" class="datalst" /></td>
</tr>
<tr align="center">
<td><input name="prcn3" type="text" class="datalst"/></td><td><input name="ct3" type="text" class="datalst"/></td><td><input name="actv3" type="text" class="datalst"/></td><td><input name="ewo3" type="text" class="datalst"/></td><td><input name="proj3" type="text" class="datalst"/></td><td><input name="loc3" type="text" class="datalst"/></td><td><input name="ferc3" type="text" class="datalst"/></td><td><input name="sub3" type="text" class="datalst"/></td><td><input name="rrcn3" type="text" class="datalst"/></td><td><input name="al3" type="text" class="datalst"/></td><td><input name="total3" type="text" class="datalst"/></td>
</tr>
</tr>
<tr align="center">
<td><input name="prcn4" type="text" class="datalst"/></td><td><input name="ct4" type="text" class="datalst"/></td><td><input name="actv4" type="text" class="datalst"/></td><td><input name="ewo4" type="text" class="datalst"/></td><td><input name="proj4" type="text" class="datalst"/></td><td><input name="loc4" type="text" class="datalst"/></td><td><input name="ferc4" type="text" class="datalst"/></td><td><input name="sub4" type="text" class="datalst"/></td><td><input name="rrcn4" type="text" class="datalst"/></td><td><input name="al4" type="text" class="datalst"/></td><td><input name="total4" type="text" class="datalst"/></td>
</tr>
    </tbody>
  </table>
  </div>
</div>

	<div class="row" style="margin-bottom:1vh;">
	 <div class="col-sm-9" style="">
		Approved: <input name="approved" type="text" style="width:200px;" /> 
		</div>
		<div class="col-sm-3" style="">
		Total Cost: <input name="total_cost" type="text" />
		</div>
	</div>
</div></center>


<center><div class="container-fluid trip" style="width:90%;border:2px solid black;margin-bottom:1vh;">

<h3>Trip Completed</h3>
  <div class="row" style="margin-bottom:1vh;">
    <div class="col-sm-9" style="">
Driver Signature: <input name="driver_sign" type="text" />
</div>
    <div class="col-sm-3" style="">
Date: <input name="complete_date" type="date" />
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
		  $( "#o_add1" ).focus();
		  return false;
      }
	  else{
		  calc_miles_click($("#depart_poi1").val(),$("#depart_add").val(),$("#dlati").val(),$("#dlongi").val(),
				 $("#arrival_poi").val(),$( "#arrival_add" ).val(),$("#alati").val(),$("#alongi").val(),
				 $("#o_poi1").val(),$("#o_add1").val(),$("#lati1").val(),$("#longi1").val(),
				 $("#o_poi2").val(),$("#o_add2").val(),$("#lati2").val(),$("#longi2").val(),
				 $("#o_poi3").val(),$("#o_add3").val(),$("#lati3").val(),$("#longi3").val(),
				 $("#o_poi4").val(),$("#o_add4").val(),$("#lati4").val(),$("#longi4").val(),
				 $("#o_poi5").val(),$("#o_add5").val(),$("#lati5").val(),$("#longi5").val());
        $("#submit_button").val("Saving Tripsheet ...");
		var interval = setInterval(function(){   
          $.ajax({
            type: 'post',
            url: 'tripsheet_query.php',
            data: $('#trip_form_post').serialize(),
            success: function (data) {
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
	  clearInterval(interval) }, 2000);
     }
      
}

  function PrintElem(){
	/* $("#trip_form_post").attr('action','new_trip_pdf.php');
	 $("#trip_form_post").attr('target','_blank');*/
       $("#trip_form_post").submit();
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
  <center>
	  <input id="submit_button" type="button" value="Save" onclick="form_sub();"  /></form> 
	  <input type="button" value="Print" onclick="PrintElem();" /> 
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