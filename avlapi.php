<?PHP
require_once('connect.php');
$apikey		= @$_GET["key"];
$format		= @$_GET["format"];

$Message  = "Some Error...............";

if ($db_found) 
	{
		if ($apikey =='8df3ddff059ae7768bb015113f736da2')
		{
				  mysql_query("set time_zone = '-4:00' ");
		 		  $data = mysql_query("select  Event_data_last_view.DeviceImei as IMEI,Event_data_last_view.eventcode as 'EVENT',Event_data_last_view.deviceid as 'EQUIPMENT',IF((TIME_TO_SEC(TIMEDIFF(now(),maxdata.timestamp))/7200)>1,'INACTIVE',(if ((Event_data_last_view.eventcode = '4001' ||Event_data_last_view.eventcode = '6011'),'ON','OFF'))) as 'IGNITION_STATUS',Event_data_last_view.`timestamp` as 'TIME' ,lati as 'LATI', longi as 'LONGI',speed as 'SPEED',heading as 'HEADING' from (select MAX(Event_data_last_view.timestamp) as timestamp , Event_data_last_view.deviceid from Event_data_last_view,event_desc where Event_data_last_view.eventcode = event_desc.eventcode  and Event_data_last_view.DeviceImei  in (Select DeviceIMEI from devicedetails where UserName = 'gpc'  and OBDType = 'OBDII'  group by DeviceIMEI) group by Event_data_last_view.deviceid) as maxdata, Event_data_last_view,event_desc where Event_data_last_view.timestamp = maxdata.timestamp and Event_data_last_view.eventcode = event_desc.eventcode and maxdata.deviceid = Event_data_last_view.deviceid group by Event_data_last_view.deviceid order by Event_data_last_view.deviceid") or die(mysql_error()); 

			  $rows = array();
			  while($r = mysql_fetch_assoc($data))
			  {
				  $trip_qry = mysql_fetch_assoc(mysql_query("SELECT name AS 'POI' FROM `substation_more` left join (select time_sheet,veh_no from trip_sheet where veh_no = '".$r['DeviceImei']."' order by `id` DESC limit 1) as tp on '".$r['DeviceImei']."' = tp.veh_no  order by (((acos(sin((".$r['LATI']."*pi()/180)) * sin((lati*pi()/180))+cos((".$r['LATI']."*pi()/180)) * cos((lati*pi()/180)) * cos(((".$r['LONGI']."- longi)*pi()/180))))*180/pi())*60*1.1515) limit 1")); 

				  $details = mysql_fetch_assoc(mysql_query("select DeviceType as 'EQUIPMENT_TYPE',eqp_det as 'EQUIPMENT_DETAIL',crew as 'CREW',driver_name as 'DRIVER_NAME' from devicedetails where DeviceIMEI = '".$r['IMEI']."'"));

       $rows[]  = array_merge(array_merge((array)$r,(array)$details),(array)$trip_qry);
					//$rows[] = $r;
			  }
			  if ($format == 'json')
				echo json_encode($rows);
				else
				echo xmlrpc_encode_request($rows); 
		
		}
		else
		{
			 $data = mysql_query("Select 'Invalid key!!' as result");
			 $rows = array();
			  while($r = mysql_fetch_assoc($data))
			  {
					$rows[] = $r;
			  }
			    if ($format == 'json')
					echo json_encode($rows);
		}
	}
?>

