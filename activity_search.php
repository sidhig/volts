
<?
  session_start();
 include_once('connect.php');

/*print_r($_POST);
if($_POST['status']){
  echo 'yes';
}else{
  echo 'no';
}
*/

$currentlati  = '' ;
$currentlongi = '' ;



if(isset($_POST['curr_lati']))
{

	$currentlati  = $_POST['curr_lati']  ;
	$currentlongi = $_POST['curr_longi'] ;

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
<input  type="hidden" name="html_lati" value="<?=$currentlati;?>"  id="html_lati">
<input  type="hidden" name="html_longi" value="<?=$currentlongi;?>" id="html_longi">
<style>
.font{
font-size:1.2rem;
width:8vw; 
}
.font_lable{
font-size:1.2rem;
width: 10vw;" 
}
</style>
<script type="text/javascript" src="js/date.js"></script>
<script> 
var anim_list = new Array();
  <? include_once('setmarkerhistory.php'); ?>
    
  </script>
  <script>
  var map;
var is_map_status=<?if(isset($_POST['status'])){ echo "'map'";}else{ echo "'view'";}?>;
//alert(is_map_status);
function back_to_search(){
    $("#sel_view").val('Activity Search');
  $("#search_view").show();
  //$("#map_ani_his").empty();
  $("#dev_det").html('');
  $("#anim_his").hide();
  $("#details_view").hide();
}

function enable_anim_butt(){
      anim_list = [];
  
      $('.veh_anim_check:checked').each(function () {
            anim_list.push($(this).val());
         });

     if(anim_list.length==0){
      $('#animate_button').prop('disabled',true);
      $('#animate_button').css('opacity',0.5);
     }else{
      $('#animate_button').prop('disabled',false);
      $('#animate_button').css('opacity',1);
     }
  
}

function device_his(maxid,minid,driver){  // on click of animated history in active search
  $("#det_spin").show();
 var imei = anim_list.join();
   $.post( "animated_history.php",{ maxid:maxid,minid:minid,imei:imei,start_time: $("#sdate").val()+" "+$("#stime").val(), end_time: $("#edate").val()+" "+$("#etime").val() },function(data) { 
//alert(data);
    var siteshistory = $.parseJSON(data);
    $("#search_view").hide();
    $('#equip_head,#heading').empty();
    $("#anim_his").show();
    //$('#equip_head').html('<b>Equipment # : </b> '+ +" &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>Driver : </b>" +driver);
    if($('#radio_poi').prop('checked')== true){
      $('#heading').html('POI : '+$('#curr_poi').text());
    }else if($('#curr_add').text() == ''){
        var add_heading=$( "#add1" ).val()+' '+$( "#city1" ).val()+' '+$( "#state1" ).val()+' '+$( "#zip1" ).val();
          if(add_heading == '' || add_heading == undefined){
           add_heading=$( "#add" ).val()+' '+$( "#city" ).val()+' '+$( "#state" ).val()+' '+$( "#zip" ).val(); 
          }
         
        $('#heading').html('Address : '+add_heading);
     
    }else{
      $('#heading').html('Address : '+$('#curr_add').text());
    }
    $("#details_view").hide();
    $("#det_spin").hide();
    initialize_anim_his(siteshistory,false);
	$('#pause').attr('src', "image/pause.png");
  });
}

function device_det(address,search_dev_id,lati,longi,maxid,minid){
  //alert(address);
  $("#det_spin").show();
  //var poi_name = $('#map_poi option:selected').text();
  var poi_name = $('#curr_poi').text();
  var add = $('#curr_add').text();
  if(add == ''){
    add=address;
  }
  $.post( "active_search_veh_det.php",{ add:add,poi_name:poi_name,dev_id: search_dev_id,lati: lati,longi: longi,maxid: maxid,minid: minid,start_time: $("#sdate").val()+" "+$("#stime").val(), end_time: $("#edate").val()+" "+$("#etime").val() },function(data) { 
    //alert(data);
    $("#search_view").hide();
    $("#details_view").html('');
    $("#details_view").html(data);
    $("#details_view").show();
    $("#det_spin").hide();
  });
}
function initialize_anim_his(ani_history,issingle) // for initailize the vehicle on map
    { //alert(ani_history[0][4]+','+ ani_history[0][5]);
        isstartend = true;
		document.getElementById("dev_det").innerHTML='<strong><img src="image/spinner.gif" width="20px">Please wait while getting history...</strong>';
		ispaused = false;
		history_val = true; 
		var centerMap = new google.maps.LatLng(ani_history[0][4], ani_history[0][5]); 
		var zoomval = map.getZoom();
		var centerMap = map.getCenter();

	    var myMapType = map.getMapTypeId();
    
		var myOptions =
		{
			 zoom: zoomval,
			 center: centerMap,
			 mapTypeId: myMapType
		}
		var test = new Array();
		map = new google.maps.Map(document.getElementById("map_ani_his"), myOptions);
		setMarkershistory(map, ani_history,true,issingle,true);
		infowindow = new google.maps.InfoWindow({
			content: "loading..."
		});

		var bikeLayer = new google.maps.BicyclingLayer();
		bikeLayer.setMap(map);
		
		var headingval = document.getElementById("heading").innerHTML;

		var latitude = document.getElementById("html_lati").value;
		var longitude = document.getElementById("html_longi").value;


	    var siteLatLng = new google.maps.LatLng( latitude, longitude );
		var marker = new google.maps.Marker({
			  position: siteLatLng,
			  map: map,
			  title: headingval
		});
		
		
    }

/*function back(){
   $("#distance_poi_veh").hide();
   $("#Search").html('');
    //$(".current_view").show();
    $('#Map').show();
    //map_refresh();
    initialize_both(LocationData,substationData);
     imei_arr = [];//for zoom one
    $('.multiselect,#d_map').removeAttr("disabled");
   $("#d_map").val('');
     $("#clear_searchtext").hide();
        $('#Search').hide();
        infowindow.close();
}*/

$( "#go").on('click', function() 
{

  if($('#radio_poi').prop('checked')==true)
  {
		 if(($("#map_poi").val() == '' || $("#map_poi1").val() == ''))
		 {
		  alert('Please select any POI');
		  return false;
		 }
  }
 else
  {
     if($("#add1").val()=='' || $("#city1").val()=='' || $("#state1").val()=='' || $("#add").val()=='' || $("#city").val()=='' || $("#state").val()=='')
	 {
       alert('Please fill all required fields');
         return false;
     }
   }
     $('#det_spin').show();
    if($('#radio_poi').prop('checked')==true)
	{
			var val = $('#map_poi').val();
			if(typeof ($('#map_poi_sech [value="' + val + '"]').data('value')) === "undefined")
			{
             
			}
			else
			{
				var poi_value = ($('#map_poi_sech [value="' + val + '"]').data('value'));
			}
			var poi_latlong = poi_value;
			if(poi_latlong == undefined)
			{
				var val1 = $('#map_poi1').val();
				if(typeof ($('#map_poi_sech1 [value="' + val1 + '"]').data('value')) === "undefined")
				{
             
				}
				else
				{
					var poi_value1 = ($('#map_poi_sech1 [value="' + val1 + '"]').data('value'));
				}
			poi_latlong = poi_value1;
     }

		if(poi_latlong != '')
		{
			var res = poi_latlong.split(",");
			document.getElementById("html_lati").value = res[0];
			document.getElementById("html_longi").value = res[1];
		}
      }
	  else
		 {
            var add = $( "#add" ).val()+' '+$( "#city" ).val()+' '+$( "#state" ).val()+' '+$( "#zip" ).val();
            if($( "#add" ).val() == undefined){
             add = $( "#add1" ).val()+' '+$( "#city1" ).val()+' '+$( "#state1" ).val()+' '+$( "#zip1" ).val();
            }
			
			$.post( "get_latilongi_from_add.php",{add:add},function(data) 
			{ 
				poi_latlong = data;
				var res = data.split(",");
				document.getElementById("html_lati").value = res[0];
				document.getElementById("html_longi").value = res[1];
                
        });
			
      }
		  $.post( "distance_poi_veh.php",{add:add,poi_latlong: poi_latlong,start_time: $("#sdate").val()+" "+$("#stime").val(), end_time: $("#edate").val()+" "+$("#etime").val() },function(data) { //alert(data);
              $("#distance_poi_veh").html(data);
              $("#data_table").show();
              $('#det_spin').hide();
       
        });
   // }
});
$(document).ready(function(){
  if($('#radio_poi').prop('checked')== true && $('#curr_poi,#curr_add').text()==''){
    show_poi();
  }
});
function show_poi(){
   $('#curr_poi,#curr_add').html('');
   $('#poi_map').show();
   $('#add_map').hide();
  $('#map_poi,#map_poi1').val('');
$("#show_poi").show();
$("#show_add").hide();
//$("#radio_val").val('');
//$("#abc").show();
}
function show_add(){
  $('#curr_poi,#curr_add').html('');
  $('#poi_map').hide();
  $('#add,#city,#state,#zip').val('');
   $('#add_map').show();
  $("#show_add").show();
  $("#show_poi").hide();
  //$("#radio_val").val('');
 // $("#Activity_Search").load("activity_search.php");
 // $("#abc").hide();
}
/*function change_heading(text){
    //var val = this.value;
    if($('#map_poi_sech option').filter(function(){
        return this.value === text;        
    }).length) {
        //send ajax request
        alert(this.value);
    }


  $('#curr_poi').text(text);
}
*/

$("#map_poi").on('input', function () {
    var val = this.value;
    if($('#map_poi_sech option').filter(function(){
        return this.value === val;        
    }).length) {
      $('#curr_poi').text(this.value);
        //alert(this.value);
    }
});

$("#map_poi1").on('input', function () {
    var val = this.value;
    if($('#map_poi_sech1 option').filter(function(){
        return this.value === val;        
    }).length) {
      $('#curr_poi').text(this.value);
        //alert(this.value);
    }
});

  </script>
<div id="search_view">
<center><span id="det_spin" class="font" style="display:none;color: red;"><strong><img src="image/spinner.gif" width="20px">Please wait...</strong></span></center>

<!-- <button onclick='back();' style="position: absolute; left: 5vw;">Back</button> -->

<center>
 
<h3><strong id="curr_poi"><? if($row1['name']!='' || $_POST['status']== false){ echo $row1['name'];}?></strong></h3>
<h3><strong id="curr_add"><?=$address?></strong></h3>


  <label class="radio-inline">
      <input type="radio" name="radio_val" id="radio_poi" <?if($row1['name']!='' || $_POST['status']== false){ echo "checked";}?>  onchange='show_poi()' value="POI">POI
    </label>
<label class="radio-inline">
     <input type="radio" name="radio_val" id="radio_add"  <?if($row1['name']=='' && $_POST['status']){ echo "checked";}?> value="address" onchange='show_add()' >Address
    </label><br/>

 <div id="show_poi" style="display:none;">
<?if($_POST['status']== false || $address!=''){?>
      <span  style="font-size:1.2rem;">POI :<input type="text" id="map_poi" list="map_poi_sech" style="display: inline;width:20vw;margin-left: 4vw;" class="form-control font_lable" >
<datalist id="map_poi_sech">
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
   <?}?>
</div> 


<div id="show_add" style="display:none;">
  <?if($_POST['status']== false || $address==''){?>
<table  border='0' style="margin-left: 6vw;">

    <tr>
       <th class="font" style='text-align: left;padding-top: 1vh;'>Address:  
       </th>
       <th class="font" style='text-align: left;padding-top: 1vh;'>
        <input type="text" class="form-control font_lable" id="add1" value="" > 
       </th>
       </tr>
       <tr>
       <th class="font" style='text-align: left;padding-top: 1vh;'>City: 
       </th>
        <th class="font" style='text-align: left;padding-top: 1vh;'>
          <input type="text" class="form-control font_lable" id="city1" value="" >  
       </th>
    </tr>
    <tr>
       <th class="font" style='text-align: left;padding-top: 1vh;'>State:
       </th>
       <th class="font" style='text-align: left;padding-top: 1vh;'>
        <input type="text" class="form-control font_lable" id="state1" value="" >  
       </th>
       </tr>
       <tr>
       <th class="font" style='text-align: left;padding-top: 1vh;'>Zip: </th>
       <th class="font" style='text-align: left;padding-top: 1vh;'>
        <input type="text" class="form-control font_lable" id="zip1" value="" > 
       </th>
    </tr>
</table>
<?}?>
 </div>
<!-- <div id="abc"> -->
<?if($row1['name']!=''){?>
      <span  id="poi_map" style="font-size:1.2rem;">POI :<input type="text" id="map_poi1" list="map_poi_sech1" style="display: inline;width:20vw;margin-left: 4vw;" class="form-control font_lable" value="<? echo @$row1['name']; ?>">
<datalist id="map_poi_sech1">
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
  <?}else if($address!=''){?>
    <table  id="add_map" border='0' style="margin-left: 6vw;">

    <tr>
       <th class="font" style='text-align: left;padding-top: 1vh;'>Address:  
       </th>
       <th class="font" style='text-align: left;padding-top: 1vh;'>
        <input type="text" class="form-control font_lable" id="add" value="<?=$add[0]?>" > 
       </th>
       </tr>
       <tr>
       <th class="font" style='text-align: left;padding-top: 1vh;'>City: 
       </th>
        <th class="font" style='text-align: left;padding-top: 1vh;'>
          <input type="text" class="form-control font_lable" id="city" value="<?=$add[1]?>" >  
       </th>
    </tr>
    <tr>
       <th class="font" style='text-align: left;padding-top: 1vh;'>State:
       </th>
       <th class="font" style='text-align: left;padding-top: 1vh;'>
        <input type="text" class="form-control font_lable" id="state" value="<?=$add[2]?>" >  
       </th>
       </tr>
       <tr>
       <th class="font" style='text-align: left;padding-top: 1vh;'>Zip: </th>
       <th class="font" style='text-align: left;padding-top: 1vh;'>
        <input type="text" class="form-control font_lable" id="zip" value="<?=$add[3]?>" > 
       </th>
    </tr>
</table>
    <?}?>

<table  border='0' style="margin-left: 6vw;">

    <tr>
       <th class="font" style='text-align: left;padding-top: 1vh;'>Start Date:  
       </th>
       <th class="font" style='text-align: left;padding-top: 1vh;'>
        <input type="date" class="form-control font_lable" id="sdate" value="<?php echo date('Y-m-d',strtotime("-1 days")); ?>" > 
       </th>
       <th class="font" style='text-align: left;padding-left:1vw;padding-top: 1vh;'>Start Time: 
       </th>
        <th class="font" style='text-align: left;padding-top: 1vh;'>
          <input type="time" class="form-control font_lable" id="stime" value='00:00' > 
       </th>
    </tr>
    <tr>
       <th class="font" style='text-align: left;padding-top: 1vh;'>End Date:
       </th>
       <th class="font" style='text-align: left;padding-top: 1vh;'>
        <input type="date" class="form-control font_lable"  id="edate" value="<?php echo date('Y-m-d'); ?>" > 
       </th>
       <th class="font" style='text-align: left;padding-left:1vw;padding-top: 1vh;'>End Time: </th>
       <th class="font" style='text-align: left;padding-top: 1vh;'>
        <input type="time" class="form-control font_lable"  id="etime" value="23:59" > 
       </th>
    </tr>
</table>

 <div> 
      <input id="curr_lati" type="hidden" value="<?=$_POST['curr_lati']?>"/>
      <input id="curr_longi" type="hidden" value="<?=$_POST['curr_longi']?>"/>&nbsp;<br> 
      <input type="button" id="go" value="Go">
  </div>
 <table  id="data_table" style="display:none;border: 1px solid #ddd;width: 60vw;margin-top: 2vh;" class="table" >

   <tbody id="distance_poi_veh"></tbody>
 </table>
 </center>
 </div>
 <div id="details_view"></div>

 <div id="anim_his" style="display:none;">
   <center><span id="his_spin" class="font" style="display:none;color: red;"><strong><img src="image/spinner.gif" width="20px">Please wait while getting history...</strong></span></center>

 <button onclick='back_to_search();' style="position: absolute; left: 5vw;">Back</button>

<center>
<h4 id="equip_head"></h4>
<h4 id="heading"></h4>

<table style="width: 20vw;margin-left: 75vw; margin-top: -10vh;" border='0'>
 <th class="font">
  <div id="animated_his" style="width:6vw; height: 6vh; margin-top:3vh;" >
    <img id="prv" style="width:1.6vw; cursor:pointer;" src = 'image/prev.png' onclick="prv_start();" > 
    <img id="pause" style="width:1.6vw; cursor:pointer;" src = 'image/pause.png' onclick="resume_pause();" > 
    <img id="next" style="width:1.6vw; cursor:pointer;" src = 'image/next.png' onclick="next_start();" >
  </div>
 </th>
 <th class="font">Speed: <input type="range" value="" min="0" max="2" onchange="change_speed(this.value);"> 
  <div> <input id="bread_check" type="checkbox" > Breadcrumbs</div>
 </th>
 </tr>
 </table>
 </center>

 <center>
  <span id="dev_det" class="font"></span>
 <div id="map_ani_his" style="min-height:62vh!important;margin-top: 2vh;width:75vw;"></div>
 </center>
 <script>
        var history_val = false;
      var ispaused = false;
      var isnext    = false;
      var isprevious  = false;
      var isstartover = false;
      var ishistoryrunning = false;
      var speed_anim = 600;
      var isstartend = false;
      var isbreadcrumps= false;
     //var ani_history = <?=$finalstring_res?>;
     //alert(ani_history);
$('#bread_check:checkbox').change(function() {
if($(this).is(":checked")) 
{
  isbreadcrumps = true;
}
else
{
  isbreadcrumps = false;
}

});

function change_speed(a)
{
 if(a==0){ speed_anim = 100; }
 else if(a==1){ speed_anim = 400; }
 else if(a==2){ speed_anim = 800; }
}

function resume_pause() 
{

  ispaused = !ispaused; 
  if (ispaused)
  {
    $('#pause').attr('src', "image/play.png");
  }
  else
  {
    $('#pause').attr('src', "image/pause.png");
  }

}


function start_resume()
{
  isstartover = true;
  ispaused = false; 
  $('#pause').css('src', "image/pause.png");
  
}

function next_start()
{

  ispaused = true;
  isnext = true;
  if (ispaused)
  {
    $('#pause').attr('src', "image/play.png");
  }
}

function prv_start()
{
  

  ispaused = true;
  isprevious = true;
  if (ispaused)
  {
    $('#pause').attr('src', "image/play.png");
  }
  else
  {
    $('#pause').attr('src', "image/pause.png");
  }
}

 </script>
 </div>
