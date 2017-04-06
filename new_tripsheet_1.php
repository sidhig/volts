<? include_once('connect.php'); ?>

  <!----><meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  
  <style>
  
.datalst{
	width: 4vw;
}
.int{
	width: 20vw;
}
.datalist{
  width:5.2vw;
}

/*@media only screen and (max-width: 768px) {
   
    .int {
        width: 100%;
    }
    .datalist {
        width: 100%;
    }
  }
  @media (min-width: 768px){
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
table caption {
	padding: .3em 0;
}

@media screen and (max-width: 767px) {
  table caption {
    border-bottom: 0px solid #ddd;
  }
}
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 2px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 0px solid transparent;
    padding-left: 2vw;
    font-weight: normal;
}
  </style>
  <div style="background-color:white;">
<div class="container">
  <div class="row">
    <div class="col-xs-12">
    <div class="table-responsive">	
      <table  class="table" style="margin-top:1vh;margin-bottom:1vh;">
        <tr>
	  <th style='text-align:left'><input onclick='$("#trip_sheet_div").hide();' type="button" value="Back" /></th>
	  <th><b style="margin-left: 24vw;font-size:2.0rem;">TRIP SHEET AND BILL OF LADING</b></th>
	  <th align="right">Time Sheet Number:  <strong><? date_default_timezone_set("EST5EDT"); ?><span id="trip_sheet_no"><?=$trip_no = date('YmdHis')?></span></strong></strong></th>
</tr>
    </table>
    <table  class="table" style="border: 1px solid black;">
          
      <tr>
          <th style="padding-top: 2px;">Date Requested :</th>
          <td><input name="req_date" id="req_date" type="date" value="<?php print(date("Y-m-d")); ?>" style="background-color: rgb(206, 206, 206);" class="int"/></td>
              <th style="padding-top: 2px;">Date To Be Delivered :</th>
              <td><input name="del_date" id="del_date" type="date" style="background-color: rgb(206, 206, 206);" class="int"/></td>
      </tr>
      <tr>
          <th>Contact Person :</th>
          <td><input name="contact_person" id="contact_person" type="text" style="background-color: rgb(206, 206, 206);" class="int"/></td>
          <th>Contact No :</th>
          <td><input name="contact_no" id="contact_no" type="text" style="background-color: rgb(206, 206, 206);" class="int"/></td>
      </tr>
      <tr>
        <th>Requested By :</th>
        <td><input name="req_by" id="req_by" type="text" style="background-color: rgb(206, 206, 206);" class="int"/></td>
        <th>Requester No :</th><td><input name="req_no" id="rel_req_no" type="text" style="background-color: rgb(206, 206, 206);" class="int"/></td>
      </tr>
      <tr>
        <th>Item Being Delivered :</th> 
        <td><input name="item_name" id="item_name" type="text" style="background-color: rgb(206, 206, 206);" class="int"/></td>
        <th>Requester Email :</th> 
        <td><input name="req_email" type="text" class="int"/>
          <datalist id='danny_email'>
          <option value='DWMARTIN@southernco.com'>
          </datalist></td>
      </tr>
      <tr>
        <th>Trip Sheet Status :</th> 
        <td><input name="status" id="status" type="text" value="Open" style="background-color: rgb(206, 206, 206);" readonly class="int"/></td>
        <th>Dispatcher :</th> 
	      <td>
          <select id="Dispatcher" name="dispatcher" class="int">
            <?php
				   $result = $conn->query("select * from tbl_dispatcher order by `id`");
				   while($row  = $result->fetch_object())
				   { ?>
				   <OPTION VALUE='<?=$row->id?>'><?=$row->name?><? if($row->id!='0'){ ?><?="(".$row->id.")"?><? } ?></option>
				   <?  } ?>
			    </select>
        </td>
      </tr>
      <tr>
        <th>Contract Driver :</th> 
        <td><input name="contract_driver" type="text" class="int"/>
        <th>Driver Phone :</th> 
        <td><input name="driver_phone" type="text" class="int"/></td>
      </tr>
      <tr>
        <th>Notes (PLEASE READ) :</th> 	
        <td><textarea name="notes" cols="90" style="" class="int"></textarea></td>
        <th>Tracked Equipment Type :</th>
        <td>
          <select id="equip_type" name="equip_type" class="int">
		       <option value="All">All</option>
		       <?php
		 	     $result = mysql_query("select * from tbl_eqptype where CASE WHEN (select eqp  as eqpval  from roletable where username = '".$_SESSION['LOGIN_user']."') = 'All' THEN 1 ELSE (select eqp from roletable where username = '".$_SESSION['LOGIN_user']."') like CONCAT('%', eq_name, '%')  END order by eq_name");
			     while($vehicle = mysql_fetch_array($result))
			     {
			     ?>
			     <option><?=$vehicle["eq_name"]?></option>
			     <?  } ?>
			     <option>Not Tracked</option>
		      </select>
        </td>
      </tr>
      <tr>
        <th>Equipment Numbers :</th> 
	      <td><input name="equip_no1" type="text" style="width:6.4vw;"/> 
            <input name="equip_no2" type="text" style="width:6.4vw;"/> 
            <input name="equip_no3" type="text" style="width:6.4vw;"/> 
            <input id="veh_name_hidden" name = "veh_no" type="hidden" />
        </td>
        <th>Tracked Equipment # :</th>  
        <td><input id="veh_name"  type="browsers" list="rel_browsers" autocomplete="off" style="background-color: rgb(206, 206, 206);" class="int" />
		      <datalist id="rel_browsers">
		
            <?php
		 	      $result = mysql_query("select trim(DeviceName) as 'DeviceName',DeviceIMEI from devicedetails where username = 'gpc'");
			     while($row = mysql_fetch_array($result))
			     {

			    echo "<option data-value=".$row["DeviceIMEI"]." value=".$row["DeviceName"]."></option>";
			   }
			   ?>
			   </datalist>
        </td>
      </tr>	
    </table>

    <table  class="table" style="border: 1px solid black;">
      <tr>
        <th>Bobtail Miles :</th>
        <td><input name="bobtail_miles" style="" class="int"/></td>
        <th>w/Trailer Miles :</th>
        <td><input name="trail_miles"  class="int"/></td>
      </tr>
      <tr>
        <th>Dispatch Miles :</th>
        <td><input id="disp_miles"  name="disp_miles" type="text" class="int"/>
            <div id='wait_for_miles' style="color:red; clear: both; display:none;"><img src="image/spinner.gif" width="20px">Please wait...</div> 
            <input id="calc_miles" type="button" value="Calculate miles" />
        </td>
        <th>Trip Type:</th>
        <td>
          <select id="trip_type" name="trip_type" onchange="return dist();" class="int">
           <option value="2" >Round Trip</option>
           <option value="1" selected>One Way</option>
          </select>
        </td>
      </tr>
      <? include_once('substationjson.php'); ?>
      <tr>
           <datalist id="poi_list" ><?=$substation_dl?></datalist>
	      <th>Departure POI :</th> 
	      <td><input name="depart_poi" list="poi_list" id="depart_poi1" value='' autocomplete="off" style="background-color: rgb(206, 206, 206); " class="int"/></td>
	        <span id="rel_d_add"> 
	      <th style="padding-left: 1vw;">Departure Address :</th> 
        <td><input type="text" id="depart_add" name="depart_add"  style="background-color: rgb(206, 206, 206);" class="int"/> </span></td>
	    </tr>
	    <tr>
			  <input type="hidden" name="dlati" id="dlati" value="" />
			  <input type="hidden" name="dlongi" id="dlongi" value="" />
			  <input type="hidden" name="alati" id="alati" value="" />
			  <input type="hidden" name="alongi" id="alongi" value="" />
			  <input type="hidden" name="gotlocation" id="gotlocation" value="1" />
      </tr>
           <? for($btn=1;$btn<=5;$btn++){ ?>
      <tr id='poi<?=$btn?>' <? if($btn!=1){ ?> style='display:none;' <? } ?> >
	      <th>Arrival POI<?=$btn?> :</th>
		    <td><input name="o_poi<?=$btn?>" list="rel_poi_list" id="o_poi<?=$btn?>" autocomplete="off" class="int" /></td>
		      <td><span id="a_add<?=$btn?>" style='display:none;'>Arrival Address<?=$btn?> :<input id="o_add<?=$btn?>" name="o_add<?=$btn?>" style="width:40%;" /></span>
	      </td>
	      <td>
		     <input type="hidden" name="lati<?=$btn?>" id="lati<?=$btn?>" value="<?=$other_poi["lati_o"]?>" />
		     <input type="hidden" name="longi<?=$btn?>" id="longi<?=$btn?>" value="<?=$other_poi["longi_o"]?>" />
	      </td>
      </tr>
          <? } ?>
      <tr>
	      <th>Final Arrival POI :</th>
	      <td ><input name="arrival_poi" list="poi_list" id="rel_arrival_poi" value='' autocomplete="off" style="background-color: rgb(206, 206, 206); " class="int"/></td>
	      <span id="rel_a_add">
	      <th>Arrival Address :</th>
	      <td><input type="text" id="arrival_add" name="arrival_add"  style="background-color: rgb(206, 206, 206);width:40%;" /></span>
	      <input type='button' onclick="show_poi('#relpoi_2')" id="addpoi" value='Add Another POI'>
	      <input type='button' id="rempoi" onclick="remove_poi('#relpoi_2')" value='Delete POI' style="display:none;">
	      </td>
	    </tr>
      <tr>
        <th>Print GPC Rep :</th> 
        <td><input name="print_rep" type="text" class="int"/></td>
        <th>Sign GPC Rep :</th> 
        <td><input name="sign_rep" type="text" class="int"/></td>
      </tr>
    </table>
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
calc_miles_click();
});
$("#depart_poi1,#arrival_poi,#o_poi1,#o_poi2,#o_poi3,#o_poi4,#o_poi5").on('input', function() {
poi_change(); 
});
</script>


    <div style="border: 1px solid black;"> 
    <table summary="This table shows how to create responsive tables using Bootstrap's default functionality" class="table" style="">
      <thead>
      <tr>
        <th style="text-align: center;">PRCN</th>
        <th style="text-align: center;">CT</th>
        <th style="text-align: center;">ACTV</th>
        <th style="text-align: center;">EWO</th>
        <th style="text-align: center;">PROJ</th>
        <th style="text-align: center;">LOC</th>
        <th style="text-align: center;">FERC</th>
        <th style="text-align: center;">SUB</th>
        <th style="text-align: center;">RRCN</th>
        <th style="text-align: center;">AL</th>
        <th style="text-align: center;">Total</th>
      </tr>
      </thead>
    <tbody>
      <tr align="center">
        <td><input name="prcn1" type="text" class="datalst" /></td>
        <td><input name="ct1" type="text" class="datalst" /></td>
        <td><input name="actv1" type="text" class="datalst" /></td>
        <td><input name="ewo1" type="text" class="datalst" /></td>
        <td><input name="proj1" type="text" class="datalst" /></td>
        <td><input name="loc1" type="text" class="datalst" /></td>
        <td><input name="ferc1" type="text" class="datalst" /></td>
        <td><input name="sub1" type="text" class="datalst" /></td>
        <td><input name="rrcn1" type="text" class="datalst" /></td>
        <td><input name="al1" type="text" class="datalst" /></td>
        <td><input name="total1" type="text" class="datalst" /></td>
      </tr>
      <tr align="center">
        <td class="datalst"><input name="prcn2" type="text" class="datalst" /></td><td><input name="ct2" type="text" class="datalst" />
        </td>
        <td><input name="actv2" type="text" class="datalst" /></td>
        <td><input name="ewo2" type="text" class="datalst" /></td>
        <td><input name="proj2" type="text" class="datalst" /></td>
        <td><input name="loc2" type="text" class="datalst" /></td>
        <td><input name="ferc2" type="text" class="datalst" /></td>
        <td><input name="sub2" type="text" class="datalst" /></td>
        <td><input name="rrcn2" type="text" class="datalst" /></td>
        <td><input name="al2" type="text" class="datalst" /></td>
        <td><input name="total2" type="text" class="datalst" /></td>
      </tr>
      <tr align="center">
        <td><input name="prcn3" type="text" class="datalst"/></td>
        <td><input name="ct3" type="text" class="datalst"/></td>
        <td><input name="actv3" type="text" class="datalst"/></td>
        <td><input name="ewo3" type="text" class="datalst"/></td>
        <td><input name="proj3" type="text" class="datalst"/></td>
        <td><input name="loc3" type="text" class="datalst"/></td>
        <td><input name="ferc3" type="text" class="datalst"/></td>
        <td><input name="sub3" type="text" class="datalst"/></td>
        <td><input name="rrcn3" type="text" class="datalst"/></td>
        <td><input name="al3" type="text" class="datalst"/></td>
        <td><input name="total3" type="text" class="datalst"/></td>
      </tr>
      <tr align="center">
        <td><input name="prcn4" type="text" class="datalst"/></td>
        <td><input name="ct4" type="text" class="datalst"/></td>
        <td><input name="actv4" type="text" class="datalst"/></td>
        <td><input name="ewo4" type="text" class="datalst"/></td>
        <td><input name="proj4" type="text" class="datalst"/></td>
        <td><input name="loc4" type="text" class="datalst"/></td>
        <td><input name="ferc4" type="text" class="datalst"/></td>
        <td><input name="sub4" type="text" class="datalst"/></td>
        <td><input name="rrcn4" type="text" class="datalst"/></td>
        <td><input name="al4" type="text" class="datalst"/></td>
        <td><input name="total4" type="text" class="datalst"/></td>
      </tr>
     </tbody>
    </table>
        <p style="margin-left: 1vw;">Approved: <input name="approved" type="text" style="width:200px;" /> <span style="float:right; padding-right:24px;">Total Cost: <input name="total_cost" type="text" /> </span></p>	
    </div>

    </div><!--end of .table-responsive-->
    </div>
    </div>
   </div>
  <div class="container" >
  <div class="row">
    <div class="col-xs-12" style="border: 1px solid black;margin-top:2vh;margin-bottom:1vh;">
      <div class="table-responsive" >
    <center><h3>Trip Completed</h3></center>
    <table class="table" style=""> 
      <td>Driver Signature:</td> 
      <td style=""><input name="driver_sign" type="text" /></td>
      <td>Date: </td>
      <td><input name="complete_date" type="date" /></td>
    </table>
  </div>
  </div>
  </div></div>
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
      else if (($( "#depart_poi1" ).val().toLowerCase().trim() == "")) {
      alert("Departure POI must be filled out");
    $( "#depart_poi1" ).focus();
      return false;
      }
      else if (($( "#arrival_poi" ).val().toLowerCase().trim() == "address") && ($( "#arrival_add" ).val().trim() == "")) {
      alert("Arrival Address must be filled out");
    $( "#arrival_poi" ).focus();
      return false;
      }
      else if (($( "#arrival_poi" ).val().toLowerCase().trim() == "")) {
      alert("Arrival POI must be filled out");
    $( "#arrival_poi" ).focus();
      return false;
      }
      
      if ($("#submit_button").val() == "Save")
      {
        $("#submit_button").val("Saving Tripsheet ...");
      }
      
    
          $.ajax({
            type: 'post',
            url: 'Post.php',
            data: $('#trip_form_post').serialize(),
            success: function (data) {
        alert(data);
       /* //$( "#trip_data" ).hide();
        $( "#trip_form" ).hide();
        $( "#dispatch" ).show();
        //$( "#trip_sheet_list" ).html('');
        //$( "#trip_sheet_list" ).html(data);
        document.getElementById("trip_form_post").reset();
        ts = $("#time_sheet").val();
        ts++;
        $("#time_sheet").val(ts);
        $("#refresh_ts_btn").val("Refreshing...");
          $.post( "tsrefresh.php",{ name: "" },function(data) {
              $( "#trip_sheet_list" ).html('');
              $( "#trip_sheet_list" ).html(data);
              d_status_filter();
              $("#refresh_ts_btn").val("Refresh");
            });*/
  
            }, 
      error: function (xhr) 
      {
        count++;
        $("#submit_button").val("Please wait. Retrying to save Tripsheet ...count " + count);
        setTimeout(function(){
          form_sub();
        }, 2000);
      
        /*var str_responce = confirm('Unable to save. Try again?'+'('+xhr.status+')');
        if (str_responce)
        {
            count++;
            $("#submit_button").val("Please wait. Retrying to save Tripsheet ...");
            form_sub();
        }
        else
        {
            $("#submit_button").val("Save");
            return false;
        }*/
      }

      });
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


  <center>
	  <input id="submit_button" type="button" value="Save" onclick="form_sub();"  /></form> 
	  <input type="button" value="Print" onclick="PrintElem();" /> 
	  <input onclick='$("#trip_sheet_div").hide();' type="button" value="Close" />
  </center>

  <div class="row" style="margin-bottom:1vh; margin-left: 22vh;width:84.5%">
	 <div class="col-sm-9" style="">
		Any Questions Call Radio <strong>29710</strong>
		</div>
		<div class="col-sm-3" style="">
		After Hours Phone <strong>770-262-0560</strong>
		</div>
	</div>


<div id="direction_url" style="display:;background:white;">
<center><iframe id="dir" src="" width="90%" height="400"></iframe>
<div id="direction" style=' text-align: left; /*margin-left: 20vh;*/width:90%;  font-size: 1.2rem;'></div></center>
</div><!--direction_url close-->
</div>
</div></div>
