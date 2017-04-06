<?
//print_r($_POST);die();
//$conn = new mysqli('localhost', 'root', '', "xirgo");
	 include_once('connect.php');
$devices = array();
$devices_id = array();

 //deviceid,lati,longi,DeviceImei
if($_POST['poi_latlong'] == '')
{
    $geocodeFromAdd = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".str_replace(' ','+',$_POST['add'])."&key=AIzaSyCLWeYaDJ385i-vxLhMjNJ51NTFCVuaGaM");
    $output = json_decode($geocodeFromAdd);
	$poi_lati_longi[0]=$output->results[0]->geometry->location->lat;
	$poi_lati_longi[1]=$output->results[0]->geometry->location->lng;   
}
else
{
	$poi_lati_longi=explode(',',$_POST['poi_latlong']);
}

$data = mysql_fetch_object(mysql_query("select max(maxid) as maxid, min(minid) as minid from table_id_ref where `val_date` >= '".explode(" ",$_POST['start_time'])[0]."' and `val_date` <= '".explode(" ",$_POST['end_time'])[0]."'"));

$res = "select deviceid,lati,longi,event_data.DeviceImei,`timestamp`,DeviceType,driver_name,(((acos(sin((".$poi_lati_longi[0]."*pi()/180)) * sin((`lati`*pi()/180))+cos((".$poi_lati_longi[0]."*pi()/180)) * cos((`lati`*pi()/180)) * cos(((".$poi_lati_longi[1]."- `longi`)*pi()/180))))*180/pi())*60*1.1515*1609.344*3.28084) as distance from event_data left join devicedetails on event_data.DeviceImei= devicedetails.DeviceIMEI where id >= '".$data->minid."' and 
if(date(now()) = '".explode(" ",$_POST['end_time'])[0]."' ,1 ,id <= '".$data->maxid."')  

and (`timestamp` between '".$_POST['start_time']."' and '".$_POST['end_time']."') having `distance` <= 1640.42 ";



 $result = mysql_query($res);
while($r = mysql_fetch_object($result)){ 


  if(in_array($r->deviceid,$devices_id)){
        
    }else{ 
    array_push($devices,$r->deviceid.'##'.$r->DeviceType.'##'.$r->driver_name.'##'.$r->DeviceImei);
    array_push($devices_id,$r->deviceid);
  }
  //}
//}
}

if(count($devices)>0){?>
     <tr>
   <th>Equipment #</th><th>Equipment Type</th><th>Driver Name</th><th></th><th><input type="button" value="Animated History" disabled="disabled" id="animate_button" style="float: right;opacity:0.5" onclick="device_his('<?=$data->maxid?>','<?=$data->minid?>','<?=$data_res[2]?>')"></th>
   </tr>
  <?
foreach ($devices as $value){
$data_res=explode('##',$value);
  ?>
  <tr>
  <td><?=$data_res[0]?></td>
  <td><?=$data_res[1]?></td>
  <td><?=$data_res[2]?></td>
<td><input type="button" value="Details"  onclick="device_det('<?=$_POST['add']?>','<?=$data_res[0]?>','<?=$poi_lati_longi[0]?>','<?=$poi_lati_longi[1]?>','<?=$data->maxid?>','<?=$data->minid?>')"></td>
<td style="text-align:center;" ><input type="checkbox" class="veh_anim_check" style="width:2.5vw;height:2.5vh;" onclick="enable_anim_butt();" name="veh_anim_check" value="'<?=$data_res[3]?>'"></td>
<?
// <input type="button" value="Animated History" style="float: right;" onclick="device_his('<?=$data_res[0]','<?=$data_res[3]','<?=$data->maxid','<?=$data->minid','<?=$data_res[2]')
?>
  </tr>
<?}
}else{?>
  <tr style="text-align:center;" >
  <td style="color:red;"><? echo "No activiy found";?></td>
  
  </tr>
<?}
 

?>