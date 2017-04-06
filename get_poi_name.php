<?php

  session_start();
include_once('connect.php');

if( $_REQUEST["poi_type"]!='' )
{
	$result1 = mysql_query("select * from substation_more where `type`='".$_REQUEST["poi_type"]."'");
	
	while($row = mysql_fetch_array($result1)) 
	{
		echo "<option data-value='".$row["id"]."' value='".$row["name"]."'></option>";
	}
}
else if( $_REQUEST["poi_id"]!='' & $_REQUEST["poi_search"]=='true' )//search clicked
{    
	$result1 = mysql_query("select * from substation_more where id='".$_REQUEST["poi_id"]."'");
		$row = mysql_fetch_array($result1); 
	
	?>
<tr><td><strong>Name: </strong><span style="color:red;">*</span></td><th><input id="poi_name_txt" value="<?=$row['name']?>" style="width:100%"><input id="poi_id" type="hidden" value="<?=$row['id']?>" ></th></tr>
<tr><td><strong>Type: </strong><span style="color:red;">*</span></td><th><select id="poi_type_dd" onchange="forcamera(this.value);" style="width:100%">
<? $result = mysql_query("select `type` from substation_more group by `type`");
			 while($substation = mysql_fetch_array($result))
			 {
			 ?>
			 <option value="<?=$substation["type"]?>" <? if($substation["type"]==$row['type']){ echo "selected";} ?> ><?=$substation["type"]?></option>
			<?  }  ?></select></th></tr>
			<? $add = explode(", ",$row['address']); ?>

<tr><td><strong>Address: </strong></td><th><input id="address_txt" value="<?=$add[0]?>" placeholder="Address" style="width:100%"></th></tr>
<tr><td><strong>City: </strong></td><th><input id="city_txt" value="<?=$add[1]?>" placeholder="City" style="width:100%"></th></tr>
<tr><td><strong>State: </strong></td><th><input id="state_txt" value="<?=$add[2]?>" placeholder="State" style="width:100%"></th></tr>
<tr><td><strong>Zip </strong></td><th><input id="zip_txt" value="<?=$add[3]?>" placeholder="Zip" style="width:100%"></th></tr>
<tr><td><strong>Latitude: </strong><span style="color:red;">*</span></td><th><input id="lati_txt" value="<?=$row['lati']?>" style="width:100%"></th></tr>
<tr><td><strong>Longitude: </strong><span style="color:red;">*</span></td><th><input id="longi_txt" value="<?=$row['longi']?>" style="width:100%"></th></tr>
<tr><td><strong>Geofence: </strong><span style="color:red;">*</span></td><th><select id="geofence"  style="width:100%" >

			 <option value="0.25" <? if($row['geofence']=="0.25"){ echo "selected";} ?> >TINY (.25 mi) </option>
			 <option value="0.5" <? if($row['geofence']=="0.5"){ echo "selected";} ?> >SMALL (.5 mi) </option>
			 <option value="1.0" <? if($row['geofence']=="1.0"){ echo "selected";} ?> >NORMAL (1.0 mi) </option>
			 <option value="2.0" <? if($row['geofence']=="2.0"){ echo "selected";} ?> >LARGE (2.0 mi) </option>
		</select></th></tr>

<tr><td><strong>Camera Id: </strong><span style="color:red;">*</span></td><th><input id="camid" class='camera_ele' <? if($row["type"]!='GPC Cameras'){ echo "disabled";} ?> value="<?=$row['camid']?>" style="width:100%" placeholder="Camera Id" ></th></tr>
<tr><td><strong>Camera Name: </strong><span style="color:red;">*</span></td><th><input id="cam_name" class='camera_ele' <? if($row["type"]!='GPC Cameras'){ echo "disabled";} ?> value="<?=$row['cam_name']?>" style="width:100%" placeholder="Camera Name" ></th></tr>
<tr><th colspan="2" style="text-align:center;">  

<? if($_SESSION['ROLE_can_edit']){ ?>

<input id="poi_save" type="button" value="Save" onclick="edit_poi();" > 
<? } ?>
<input type="button" value="Close" onclick='$("#poi_table,#poi_dl").empty();$("#view_poi").show();$("#poi_type,#poi_name").val("");' ></th></tr>' >
</th></tr>
<tr><th colspan="2">&nbsp;</th></tr>
<tr><th colspan="2" style="text-align:center;"><input style="margin-bottom: 1%;" type="button" value="Edit Location On Map" onclick="get_latlong();"> </th></tr>
<!--<tr><th colspan="2"><iframe id="poi_on_map_edit" src="" width="100%" height="150"></iframe></th></tr>-->
<tr><th colspan="2"><div id="poi_on_map" style=' width: 100%; height: 40vh;'></div></th></tr>

<tr><th colspan="2" style="text-align:center;"><? if($_SESSION['ROLE_can_edit']){ ?>
<input id="poi_delete" style="margin-top:2%" type="button" value="Delete POI" onclick="del_poi();" > 

<? } ?> </th></tr>


<? } 
else if( $_REQUEST["new_poi"]=='new' )//new button clicked
{ ?>
<tr><td><strong>Name: </strong><span style="color:red;">*</span></td><th><input id="poi_name_txt" placeholder="Name" value="" style="width:100%"><input id="poi_id" type="hidden" ></th></tr>
<tr><td><strong>Type: </strong><span style="color:red;">*</span></td><th><select id="poi_type_dd" onchange="forcamera(this.value);" style="width:100%" >
			<option value="" ></option>
<? $result = mysql_query("select `type` from substation_more group by `type`");
			 while($substation = mysql_fetch_array($result))
			 {
			 ?>
			 <option value="<?=$substation["type"]?>" ><?=$substation["type"]?></option>
			<?  }  ?></select></th></tr>
<tr><td><strong>Address: </strong></td><th><input id="address_txt" placeholder="Address" value="" style="width:100%"></th></tr>
<tr><td><strong>City: </strong></td><th><input id="city_txt" placeholder="City" value="" style="width:100%"></th></tr>
<tr><td><strong>State: </strong></td><th><input id="state_txt" placeholder="State" value="" style="width:100%"></th></tr>
<tr><td><strong>Zip: </strong></td><th><input id="zip_txt" placeholder="Zip" value="" style="width:100%"></th></tr>
<tr><td><strong>Latitude: </strong><span style="color:red;">*</span></td><th><input id="lati_txt" placeholder="Latitude" value="" style="width:100%"></th></tr>
<tr><td><strong>Longitude: </strong><span style="color:red;">*</span></td><th><input id="longi_txt" value="" placeholder="Longitude" style="width:100%"></th></tr>
<tr><td><strong>Geofence: </strong><span style="color:red;">*</span></td><th><select id="geofence" style="width:100%" >
			<option value="" ></option>
			 <option value="0.25" >TINY (.25 mi) </option>
			 <option value="0.5" >SMALL (.5 mi) </option>
			 <option value="1.0" >NORMAL (1.0 mi) </option>
			 <option value="2.0" >LARGE (2.0 mi) </option>
		</select></th></tr>
<tr><td><strong>Camera Id: </strong><span style="color:red;">*</span></td><th><input id="camid" class="camera_ele" placeholder="Camera Id" style="width:100%"></th></tr>
<tr><td><strong>Camera Name: </strong><span style="color:red;">*</span></td><th><input id="cam_name" class="camera_ele" placeholder="Camera Name" style="width:100%"></th></tr>

<tr><th colspan="2">&nbsp;</th></tr>
<tr><th colspan="2" style="text-align: center;"><input class="poi_add_new" type="button" value="Add" onclick="add_poi();"> <input class="" type="button" value="View on Map" onclick="get_latlong();"> <input type="reset" value="Clear" onclick="poi_clear();" > <input type="button" value="Close" onclick='$("#poi_table").empty();$("#menu").show();$("#view_poi").hide();' ></th></tr>
<tr><th colspan="2">&nbsp;</th></tr>
<!--<tr><th colspan="2"><iframe id="poi_on_map_add" src="" width="100%" height="150"></iframe></th></tr>-->
<tr><th colspan="2"><div id="poi_on_map" style=' width: 100%; height: 40vh;'></div></th></tr>

<? } 
else if( $_REQUEST["del_poi"]!='' & $_REQUEST["poi_id"]!='' )//delete clicked
{ 
$result1 = mysql_query("delete from substation_more where id ='".$_REQUEST["poi_id"]."' and `type` ='".$_REQUEST["poi_type_dd"]."'");
	echo "<center><h4>".$_REQUEST["poi_name_txt"]." Successfully Deleted.</h4><input type='button' value='Close' onclick='back_menu();' ><center>";
}
else if( $_REQUEST["add_poi"]=='true' & $_REQUEST["poi_name_txt"]!='' & $_REQUEST["poi_type_dd"]!='' )//add poi form submit
{ 

$result1 = mysql_query("insert into substation_more set name ='".mysql_real_escape_string($_REQUEST["poi_name_txt"])."',`type` ='".$_REQUEST["poi_type_dd"]."',address ='".mysql_real_escape_string($_REQUEST["address_txt"]).", ".mysql_real_escape_string($_REQUEST["city_txt"]).", ".mysql_real_escape_string($_REQUEST["state_txt"]).", ".mysql_real_escape_string($_REQUEST["zip_txt"])."',lati ='".$_REQUEST["lati_txt"]."',longi ='".$_REQUEST["longi_txt"]."',geofence ='".$_REQUEST["geofence"]."',camid ='".$_REQUEST["camid"]."',cam_name ='".$_REQUEST["cam_name"]."'");
	echo "<center><h4>".$_REQUEST["poi_name_txt"]." Successfully added.</h4><input type='button' value='Close' onclick='back_menu();' ><center>";
 } 
else if( $_REQUEST["edit_poi"]=='true' & $_REQUEST["poi_name_txt"]!='' & $_REQUEST["poi_type_dd"]!='' )//add poi form submit
{ 
	$camid=(($_REQUEST["camid"]=="") ? NULL : $_REQUEST["camid"] );
	$cam_name=(($_REQUEST["cam_name"]=="") ? NULL : $_REQUEST["cam_name"] );
	
$result1 = mysql_query("update substation_more set `type` ='".$_REQUEST["poi_type_dd"]."',name = '".mysql_real_escape_string($_REQUEST["poi_name_txt"])."', address ='".mysql_real_escape_string($_REQUEST["address_txt"]).", ".mysql_real_escape_string($_REQUEST["city_txt"]).", ".mysql_real_escape_string($_REQUEST["state_txt"]).", ".mysql_real_escape_string($_REQUEST["zip_txt"])."',lati ='".$_REQUEST["lati_txt"]."',longi ='".$_REQUEST["longi_txt"]."',geofence ='".$_REQUEST["geofence"]."',camid ='".$camid."',cam_name ='".$cam_name."' where id = '".$_REQUEST["poi_id"]."'");
	echo "<center><h4>".$_REQUEST["poi_name_txt"]." Successfully Updated.</h4><input type='button' value='Close' onclick='back_menu();' ><center>";
 } ?>
 