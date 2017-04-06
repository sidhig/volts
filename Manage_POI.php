<? session_start();
include_once("connect.php"); ?>
<center>
<h2>Manage POI</h2>
<div id="menu">
<input type="button" id="view_edit_poi"  class="btn btn-warning" style="width:20vw; height:5vh; color:black;" value="View/Edit" /><br /><br />
<? if($_SESSION['ROLE_can_edit']){ ?>
<input type="button" id="add_poi"  class="btn btn-warning" style="width:20vw; height:5vh; color:black;" value="Add New POI" /><br /><br />
<? } ?>
</div>
<form>

<table id="view_poi" width="30%" style="font-size:1.2rem;display:none;">
<tr><th style="text-align:center;">
<div id="select_poi_spin" style="color:red;display:none;"><img src="image/spinner.gif" width="20px" >Please wait...</div>
Type: <select id='poi_type'>
			<option value="" >--Select POI Type--</option>
<?php

			 $result = $conn->query("select * from substation_more group by `type` order by REPLACE( `type`, 'GPC Subs', '#' )");
			 while($substation = $result->fetch_object())
			 {
			 ?>
			 <option value="<?=$substation->type?>" ><?=$substation->type?></option>
			<?  }  ?>
		 	</select>
</th>
</tr>
<tr><th>&nbsp;</th></tr>
<tr>
<th style="text-align:center;">
	<datalist id="poi_dl">

		<!--<? $result = $conn->query("select * from substation_more where `type`='GPC Subs'");
			 //while($substation = $result->fetch_object())
			 {
			 ?>
			 <option data-value="<?=$substation->id?>" value="<?=$substation->name?>" ></option>
			<?  }  ?>-->
	</datalist>
	Name: <input id='poi_name' list="poi_dl" autocomplete="off">
</th>
</tr>
<tr><th>&nbsp;</th></tr>
<tr><th style="text-align:center;"><input id="poi_search" type="button" value="Search"> <input type="button" value="Back" onclick='$("#menu").show();$("#view_poi").hide();$("#poi_table,#poi_dl").empty();' ></th></tr>
</table>
</form><input id="poi_id" type="hidden">
<table id="poi_table" width="30%">
</table>
</center>
<script>
$('#view_edit_poi').click(function(){
	 $('#poi_name,#poi_type').css('border', '');
	 $("#poi_type,#poi_name").val('');
	$('#menu').hide();
	$('#view_poi').show();
});

function forcamera(poi_type){ 
 if(poi_type=="GPC Cameras"){
  $('.camera_ele').prop("disabled", false);
 }else{
  $('.camera_ele').val('');
  $('.camera_ele').prop("disabled", true);
 }
}

function poi_clear() {
$( "#poi_name_txt" ).val( "");
$( "#address_txt" ).val( "");
$( "#city_txt" ).val( "");
$( "#state_txt" ).val( "");
$( "#zip_txt" ).val( "");
$( "#lati_txt" ).val( "");
$( "#longi_txt" ).val( "");
return false;
}
 function get_map_poi(lati,longi)
 {  //alert($( "#"+lati ).val());
    if(($( "#"+lati ).val()=='') || ($( "#"+longi ).val()=='')){
		var myLatlng = new google.maps.LatLng(33.621669,-84.365368);
	}else{
		var myLatlng = new google.maps.LatLng($( "#"+lati ).val(),$( "#"+longi ).val());
	}
		var mapOptions = {
		  zoom: 15,
		  center: myLatlng
		}
		var map_manage_poi = new google.maps.Map(document.getElementById("poi_on_map"), mapOptions);

		// Place a draggable marker on the map
		var marker = new google.maps.Marker({
			position: myLatlng,
			map: map_manage_poi,
			draggable:true,
			title:"Drag me!"
		});

	marker.addListener('dragend', function(event) { 
		$("#"+lati ).val(this.position.lat());
		$("#"+longi ).val(this.position.lng()); 
		var geocodingAPI = "https://maps.googleapis.com/maps/api/geocode/json?address="+$("#lati_txt").val()+","+$("#longi_txt").val()+"&key=AIzaSyCLWeYaDJ385i-vxLhMjNJ51NTFCVuaGaM";
		$.getJSON(geocodingAPI, function (json) { //alert(json.results[0].address_components);
			 json.results[0].address_components.forEach(myFunction);
		});
	});

			 
    }
	 var state = '';
	  var address = '';
 function myFunction(item,index) { //alert(item.types[0]);
    if(item.types[0]=='administrative_area_level_2'){
		$( "#city_txt" ).val(item.long_name);
	}
    if(item.types[0]=='administrative_area_level_1'){
		$( "#state_txt" ).val(item.long_name);
	}
    else if(item.types[0]=='street_number'){
		address = item.long_name;
		$( "#address_txt" ).val(address.trim());
	}
    else if(item.types[0]=='route'){
		address = address+" "+item.long_name;
		$( "#address_txt" ).val(address.trim());
	}
    else if(item.types[0]=='locality'){
		address = address+" "+item.long_name;
		$( "#address_txt" ).val(address.trim());
		address='';
	}
    else if(item.types[0]=='postal_code'){
		$( "#zip_txt" ).val(item.long_name);
	}
}
function get_latlong() { 
	if ((($( "#lati_txt" ).val() != "") || ($( "#longi_txt" ).val() != "")) && ($('#address_txt').val().trim()=="") && ($('#city_txt').val().trim()=="") && ($('#state_txt').val().trim()=="")) {
		//alert('1');
		get_map_poi('lati_txt','longi_txt');
			var geocodingAPI = "https://maps.googleapis.com/maps/api/geocode/json?address="+$("#lati_txt").val()+","+$("#longi_txt").val()+"&key=AIzaSyCLWeYaDJ385i-vxLhMjNJ51NTFCVuaGaM";
		$.getJSON(geocodingAPI, function (json) { //alert(json.results[0].address_components);
			 json.results[0].address_components.forEach(myFunction);
		});
		
		/*var url2="https://www.google.com/maps/embed/v1/place?q="+$( "#lati_txt" ).val()+","+$( "#longi_txt" ).val()+"&key=AIzaSyCLWeYaDJ385i-vxLhMjNJ51NTFCVuaGaM";
		$("#poi_on_map_edit").attr("src", url2);*/
	}
	else {
		//alert('2');
		if((($('#address_txt').val().trim()=="") || ($('#city_txt').val().trim()=="") /*|| ($('#state_txt').val().trim()=="")*/)){
			alert("Required fields must be filled out");
			return false;
		}else if((($( "#lati_txt" ).val() == "") || ($( "#longi_txt" ).val() == ""))){
		add = $( "#address_txt" ).val()+' '+$( "#city_txt" ).val()+' '+$( "#state_txt" ).val();
		var geocodingAPI = "https://maps.googleapis.com/maps/api/geocode/json?address="+add+"&key=AIzaSyCLWeYaDJ385i-vxLhMjNJ51NTFCVuaGaM";
		$.getJSON(geocodingAPI, function (json) {
			//alert(json.results[0].formatted_address);
			 address = json.results[0].formatted_address;
			 //alert(address_components[0]);
			 latitude = json.results[0].geometry.location.lat;
			 longitude = json.results[0].geometry.location.lng;
			 $( "#lati_txt" ).val(latitude);
			 $( "#longi_txt" ).val(longitude);
			 get_map_poi('lati_txt','longi_txt');
		});
	}
	}
}

$("#poi_name").on('input', function() {
	 $('#poi_name').css('border', '');
		var data = {};
		$("#poi_dl option").each(function(i,el) {  
				   data[$(el).data("value")] = $(el).val();
		});
		console.log(data, $("#poi_dl option").val());
		var value = $('#poi_name').val();
		if(typeof ($('#poi_dl [value="' + value + '"]').data('value')) === "undefined")
		{
				$("#poi_id").val('');
		}
		else{ 
			var poi_id = $('#poi_dl [value="' + value + '"]').data('value');
			$("#poi_id").val(poi_id);	 }
});
function add_poi() {
if (($( "#poi_name_txt" ).val().trim()  == "") || ($( "#lati_txt" ).val().trim()  == "") || ($( "#longi_txt" ).val().trim()  == "") || ($( "#poi_type_dd" ).val().trim()  == "") || ($( "#geofence" ).val().trim()  == "")) {
alert("Required fields must be filled out");
return false;
}
else if($( "#poi_type_dd" ).val().trim()  == "GPC Cameras"){
			if(($( "#camid" ).val().trim()  == "") || $( "#cam_name" ).val().trim()  == ""){
				alert("Required fields must be filled out");
				return false;
			}
	}
	$.post( "get_poi_name.php",{ add_poi:'true',poi_name_txt: $("#poi_name_txt").val(),poi_type_dd: $("#poi_type_dd").val(),address_txt: $("#address_txt").val(),city_txt: $("#city_txt").val(),state_txt: $("#state_txt").val(),zip_txt: $("#zip_txt").val(),lati_txt: $("#lati_txt").val(),longi_txt: $("#longi_txt").val(),geofence: $("#geofence").val(),camid: $("#camid").val(),cam_name: $("#cam_name").val() },function(data) {
		$("#poi_table").empty();
		$("#poi_table").html(data);
			$.post( "get_poi_name.php",{ poi_type: $("#poi_type :selected").val() },function(data) {
				$("#poi_dl").empty();
				$("#poi_name").val("");
				$("#poi_dl").html(data);
			});
		});
	}

function del_poi() {
	yesorno = confirm("Are you want to delete this POI.");
		if(yesorno){
	$.post( "get_poi_name.php",{ del_poi:'true',poi_id: $("#poi_id").val(),poi_name_txt: $("#poi_name_txt").val(),poi_type_dd: $("#poi_type_dd").val() },function(data) {
		$("#poi_table").empty();
		$("#poi_table").html(data);
			$.post( "get_poi_name.php",{ poi_type: $("#poi_type :selected").val() },function(data) {
				$("#poi_dl").empty();
				$("#poi_name").val("");
				$("#poi_dl").html(data);
			});
		});
	}
}
function edit_poi() {
	if (($( "#poi_name_txt" ).val().trim() == "") || ($( "#lati_txt" ).val().trim()  == "") || ($( "#longi_txt" ).val().trim()  == "")) {
		alert("Required fields must be filled out");
		return false;
	}
	else if($( "#poi_type_dd" ).val().trim()  == "GPC Cameras"){
			if(($( "#camid" ).val().trim()  == "") || $( "#cam_name" ).val().trim()  == ""){
				alert("Required fields must be filled out");
				return false;
			}
	}

	$.post( "get_poi_name.php",{ edit_poi:'true',poi_id: $("#poi_id").val(), poi_name_txt: $("#poi_name_txt").val(),poi_type_dd: $("#poi_type_dd").val(),address_txt: $("#address_txt").val(),city_txt: $("#city_txt").val(),state_txt: $("#state_txt").val(),zip_txt: $("#zip_txt").val(),lati_txt: $("#lati_txt").val(),longi_txt: $("#longi_txt").val(),geofence: $("#geofence").val(),camid: $("#camid").val(),cam_name: $("#cam_name").val() },function(data) { //alert(data);
		$("#poi_table").empty();
		$("#poi_table").html(data);
			$.post( "get_poi_name.php",{ poi_type: $("#poi_type :selected").val() },function(data) {
				$("#poi_dl").empty();
				$("#poi_name").val("");
				$("#poi_dl").html(data);
			});
		});
	$("#poi_id").val('');

}

function back_menu() { //alert();
	$("#poi_table").empty();
	$("#menu").show();
	$("#view_poi").hide();
}

$("#add_poi").on('click', function() {
	$('#menu,#view_poi').hide();
	
	$.post( "get_poi_name.php",{ new_poi: 'new' },function(data) {
		//alert(data);
		$("#poi_table").empty();
		$("#poi_table").html(data);
		//alert($("#lati_txt").val());
	 get_map_poi('lati_txt','longi_txt');
	/* var geocodingAPI = "https://maps.googleapis.com/maps/api/geocode/json?address="+$("#lati_txt").val()+","+$("#longi_txt").val()+"&key=AIzaSyCLWeYaDJ385i-vxLhMjNJ51NTFCVuaGaM";
		$.getJSON(geocodingAPI, function (json) {
			 json.results[0].address_components.forEach(myFunction);
			 poi_clear();
		});
*/
		});

});
$("#poi_search").on('click', function() {
	
	if($("#poi_type").val()==''){
	 $('#poi_type').focus();
	 $("#poi_table").empty();
	  $('#poi_type').css('border', '2px solid red');
	}else if($("#poi_name").val()==''){
	 $('#poi_name').focus();
	 $("#poi_table").empty();
	  $('#poi_name').css('border', '2px solid red');
	} else{
		$('#view_poi').hide();
	$.post( "get_poi_name.php",{ poi_id: $("#poi_id").val(),poi_search:'true' },function(data) { //alert(data);
		$("#poi_table").empty();
		$("#poi_table").html(data);
		get_map_poi('lati_txt','longi_txt');

		var geocodingAPI = "https://maps.googleapis.com/maps/api/geocode/json?address="+$("#lati_txt").val()+","+$("#longi_txt").val()+"&key=AIzaSyCLWeYaDJ385i-vxLhMjNJ51NTFCVuaGaM";
		if($('#address_txt').val()==""){
		$.getJSON(geocodingAPI, function (json) { 
			 json.results[0].address_components.forEach(myFunction);
		});
	}
		});
}
});

$("#poi_type").on('change', function() { 
	$('#select_poi_spin').show();
	//$("#poi_dl").empty();
	 $('#poi_type').css('border', '');
	if($("#poi_type").val()=="GPC Cameras"){
		$('#camid,#cam_name').prop("disabled", false);
	}
	
	$.post( "get_poi_name.php",{ poi_type: $("#poi_type :selected").val() },function(data) { 
		$('#select_poi_spin').hide();
		$("#poi_dl").empty();
		$("#poi_name").val("");
		$("#poi_dl").html(data);
		});
});

</script>