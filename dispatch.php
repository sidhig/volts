<?
  session_start();
 include_once('connect.php');
$currentlati  = '' ;
$currentlongi = '' ;

if(isset($_POST['curr_lati']))
{

	$currentlati  = $_POST['curr_lati'];
	$currentlongi = $_POST['curr_longi'];

	$result1 = mysql_query("SELECT *,(((acos(sin((".$_POST['curr_lati']."*pi()/180)) * sin((`lati`*pi()/180))+cos((".$_POST['curr_lati']."*pi()/180)) * cos((`lati`*pi()/180)) * cos(((".$_POST['curr_longi']."- `longi`)*pi()/180))))*180/pi())*60*1.1515*1.609344) as distance FROM `substation_more` where lati!='0.00000000' having `distance` <= 1 order by distance
	limit 1"); // distance in km
	$row1 = mysql_fetch_array($result1);

	if($row1['name'] =='') 
	{
			$geocodeFromLatLong = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($_POST['curr_lati']).','.trim($_POST['curr_longi']).'&sensor=false'); 
			$output = json_decode($geocodeFromLatLong);
			//print_r($output);
			//$status = $output->status;
			//Get address from json data
			$address = $output->results[0]->formatted_address;
			
			$dataval = $output->results[0]->address_components;
	
			  foreach($dataval as $elements)
			  {
			   if($elements->types[0] == 'street_number')
			   {
				$Addressval = $elements->long_name;
			   }
			   if($elements->types[0] == 'route')
			   {
				$Addressval = $Addressval." ".$elements->long_name;
			   }
			   if($elements->types[0] == 'locality')
			   {
				$Cityval = $elements->long_name;
			   }
			   if($elements->types[0] == 'administrative_area_level_1')
			   {
				$stateval = $elements->long_name;
			   }
			   if($elements->types[0] == 'postal_code')
			   {
				$postalval = $elements->long_name;
			   }
			  }
			$address = $Addressval . ",".$Cityval.",".$stateval.",".$postalval;
			$add=explode(',',$address);
			$city_zip=explode(' ',trim($add[1])); // print_r($add);
		  

	}
	
}
?>

<style>
.font{
font-size:1.2rem;
width:8vw; 
}
.font_lable{
font-size:1.2rem;
width: 10vw;" 
}
textarea {
    resize: none;
}

</style>
<!-- <script type="text/javascript" src="js/date.js"></script> -->
<script>
var is_map=<?if(isset($_POST['status'])){ echo "'map'";}else{ echo "'view'";}?>;
$(document).ready(function(){
  if($('#radio_but_poi').prop('checked')== true){
    $('#add_map').hide();
    $('#poi_map').show();
  }else{
     $('#add_map').show();
     $('#poi_map').hide();
  }

});
function show_poi(){
   $('#currnt_poi,#currnt_add').html('');
   $('#poi_map').show();
   $('#add_map').hide();
 $('#disp_add,#disp_city,#disp_state,#disp_zip,#name,#phone,#msg,#input_poi').val('');
}

function show_add(){ 
  $('#currnt_poi,#currnt_add').html('');
  $('#poi_map').hide();
  $('#disp_add,#disp_city,#disp_state,#disp_zip,#name,#phone,#msg,#input_poi').val('');
   $('#add_map').show();
}

function go_dispatch(){
	var name = $('#name').val();
	var phone = $('#phone').val();
	var message = $('#msg').val();
	
	if($('#radio_but_poi').prop('checked')==true)
  	{
		 if(($("#input_poi").val() == ''))
		 {
		  alert('Please select any POI');
		  return false;
		 }
  	}else{
	if($("#add").val()=='' || $("#city").val()=='' || $("#state").val()=='')
	   {
       alert('Please fill complete address');
         return false;
     }
	}
if(name ==''){
	 alert('Please fill the name field');
	 return false;
}else if(phone ==''){
	alert('Please enter phone number');
	 return false;
}else if(message == ''){
	alert('Please write message');
	 return false;
}

if($('#radio_but_poi').prop('checked')==true){
	var val = $('#input_poi').val();
  var is_poi=1;
			if(typeof ($('#poi_list [value="' + val + '"]').data('value')) === "undefined")
			{
             
			}
			else
			{
				 poi_lati_longi = ($('#poi_list [value="' + val + '"]').data('value'));//alert(poi_lati_longi);
			}
      if(poi_lati_longi != '')
  		{
  			var res = poi_lati_longi.split(",");
  			document.getElementById("html_lati").value = res[0];
  			document.getElementById("html_longi").value = res[1];
  		}
}else{
    is_poi=0;
	  var add = $( "#disp_add" ).val()+' '+$( "#disp_city" ).val()+' '+$( "#disp_state" ).val()+' '+$( "#disp_zip" ).val();    
      $.post( "get_latilongi_from_add.php",{add:add},function(data) 
      { //alert(data);
      	var res = data.split(",");
        document.getElementById("html_lati").value = res[0];
        document.getElementById("html_longi").value = res[1];
      });
}
$('#disp_spin').show();
var lati=$('#html_lati').val();
var longi=$('#html_longi').val();
var link="http://maps.google.com/?q="+lati+','+longi;
 var from='<?=$_SESSION['LOGIN_name']?>';
 var comp_msg="VOLTS Dispatch From: "+from+"\nLocation: "+link+"\nMessage: "+message;
 //alert(comp_msg);
 var address=$( "#disp_add" ).val();
 var city=$( "#disp_city" ).val();
 var state=$( "#disp_state" ).val();
 var zip=$( "#disp_zip" ).val();
 var poi_name=$( "#input_poi" ).val();
 //alert(from);
$.post( "sendmessage.php",{ link:link,name:name,phone:phone,message:comp_msg},function(data) { //alert(data);
	if(data.substr(0,6) !='<br />'){
		var is_response=1;
	alert('Message Sent');
	}else{
    is_response=0;
		alert('Message Failed');
	}
  //alert(phone);
  $.post( "save_dispatch_det.php",{go:'go',from:from,poi:poi_name,is_response:is_response,is_poi:is_poi,add:address,city:city,state:state,zip:zip,name:name,phone:phone,message:message,lati_longi:lati+','+longi},function(data){ //alert(data);
    });
	$('#name,#phone,#msg').val('');
	$('#disp_spin').hide();

 });
}

$("#input_poi").on('input', function () { 
    var val = this.value;
    if($('#poi_list option').filter(function(){
        return this.value === val;        
    }).length) {
      $('#currnt_poi').text(this.value);
        //alert(this.value);
    }
});

$("#name").on('input', function () { 
  $('#phone').val('');
 $.post( "save_dispatch_det.php",{to:this.value},function(data){ //alert(data);
  var r=$.trim(data)
  if(r !=''){
    $('#phone').val(r);
  }
    });   
});

 function disp_history(){
  $('#disp_spin').show();
  $.post("disp_history.php",{},function(data){
    $('#dispatch_history').html('');
    $('#dispatch_history').html(data);
    $('#disp_spin').hide();
    $('#dispatch_history').show();
    $('#dispatch_view').hide();
  });
 }
</script>
<input  type="hidden" name="html_lati" value="<?=$currentlati;?>"  id="html_lati">
<input  type="hidden" name="html_longi" value="<?=$currentlongi;?>" id="html_longi">
<center>
<div id="dispatch_view">
<center><span id="disp_spin" class="font" style="display:none;color: red;"><strong><img src="image/spinner.gif" width="20px">Sending....</strong></span></center>

<!-- <button onclick='back();' style="position: absolute; left: 5vw;">Back</button> -->
<input type="button" id="disp_history" value="History" style="margin-left: 80vw;" onclick="disp_history()">

 
<h3><strong id="currnt_poi"><? if($row1['name']!='' || $_POST['status']== false){ echo $row1['name'];}?></strong></h3>
<h3><strong id="currnt_add"><?=$address?></strong></h3>


  <label class="radio-inline">
      <input type="radio" name="radio_val" id="radio_but_poi" <?if($row1['name']!='' || $_POST['status']== false){ echo "checked";}?>  onchange='show_poi()' value="POI">POI
    </label>
<label class="radio-inline">
     <input type="radio" name="radio_val" id="radio_but_add"  <?if($row1['name']=='' && $_POST['status']){ echo "checked";}?> value="address" onchange='show_add()' >Address
    </label><br/>

      <span  id="poi_map" style="font-size:1.2rem;">POI :<input type="text" id="input_poi" list="poi_list" style="display: inline;width:20vw;margin-left: 4vw;" class="form-control font_lable" value="<? echo @$row1['name']; ?>">
<datalist id="poi_list">
 <option value=""></option>
         <?php
           $result ="select * from substation_more where
            lati >-90 and lati <90   and longi >-180 and longi < 180 and lati != 0 and longi != 0 ";
           $result = $conn->query($result);

           while($vehicle = $result->fetch_object())
           { //print_r($row1['name']);
           ?>
           <option data-value="<?=$vehicle->lati.",".$vehicle->longi?>" value="<?=$vehicle->name?>" >
         </option>
          <?}?>
  </datalist>
</span> 

    <table  id="add_map" border='0' style="margin-left: 6vw;display:none;">

    <tr>
       <th class="font" style='text-align: left;padding-top: 1vh;'>Address:  
       </th>
       <th class="font" style='text-align: left;padding-top: 1vh;'>
        <input type="text" class="form-control font_lable" id="disp_add" value="<?=$add[0]?>" > 
       </th>
       </tr>
       <tr>
       <th class="font" style='text-align: left;padding-top: 1vh;'>City: 
       </th>
        <th class="font" style='text-align: left;padding-top: 1vh;'>
          <input type="text" class="form-control font_lable" id="disp_city" value="<?=$add[1]?>" >  
       </th>
    </tr>
    <tr>
       <th class="font" style='text-align: left;padding-top: 1vh;'>State:
       </th>
       <th class="font" style='text-align: left;padding-top: 1vh;'>
        <input type="text" class="form-control font_lable" id="disp_state" value="<?=$add[2]?>" >  
       </th>
       </tr>
       <tr>
       <th class="font" style='text-align: left;padding-top: 1vh;'>Zip: </th>
       <th class="font" style='text-align: left;padding-top: 1vh;'>
        <input type="text" class="form-control font_lable" id="disp_zip" value="<?=$add[3]?>" > 
       </th>
    </tr>
</table>
<table  border='0' style="margin-left: 6vw;">

    <tr>
       <th class="font" style='text-align: left;padding-top: 1vh;'>Name:  
       </th>
       <th class="font" style='text-align: left;padding-top: 1vh;'>
        <input type="text" class="form-control font_lable" id="name" value="" > 
       </th>
    </tr>
    <tr>
       <th class="font" style='text-align: left;padding-top: 1vh;'>Phone #:
       </th>
       <th class="font" style='text-align: left;padding-top: 1vh;'>
        <input type="number" class="form-control font_lable" id="phone" value="" > 
       </th>
    </tr>
        <tr>
       <th class="font" style='text-align: left;padding-top: 1vh;'>Message:
       </th>
       <th class="font" style='text-align: left;padding-top: 1vh;'>
        <textarea id="msg" rows="4" cols="30" class="form-control font_lable" placeholder="Write your message..."></textarea>
       </th>
    </tr>
</table>
<input type="button" class="font" name="dispatch" value="Dispatch" onclick="go_dispatch()" style="margin-top: 2vh;">
</div>
<div id="dispatch_history">
<div>
</center>
