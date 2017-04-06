<?
 include 'connect.php';
session_start();
 $string_res ='';
/* $data = mysql_fetch_object(mysql_query("select max(maxid) as maxid, min(minid) as minid from table_id_ref where `val_date` >= '".explode(" ",$_POST['start_time'])[0]."' and `val_date` <= '".explode(" ",$_POST['end_time'])[0]."'"));*/

/* $id = mysql_fetch_object(mysql_query("select max(id) as max_id,min(id) as min_id from event_data where id >= '".$_POST['minid']."' and 
if(date(now()) = '".explode(" ",$_POST['end_time'])[0]."' ,1 ,id <= '".$_POST['maxid']."') and event_data.DeviceImei ='".$_POST['imei']."'"));*/

/* $query = "select event_data.id,event_data.deviceid,event_data.eventcode,event_data.timestamp,event_data.lati,event_data.longi,event_data.altitude,event_data.speed,event_data.accelaration,event_data.declaration,event_data.rpm,event_data.heading,event_data.miles_driven,event_data.mpg,event_data.bettery,event_data.fule,tbl_eqptype.eqp_url,event_desc.description from event_data left join devicedetails on event_data.DeviceImei = devicedetails. DeviceIMEI left join tbl_eqptype on tbl_eqptype.eq_name = devicedetails.DeviceType left join event_desc on event_desc.eventcode = event_data.eventcode where event_data.DeviceImei ='".$_POST['imei']."' and event_data.id >= '".$_POST['minid']."' and event_data.id <= '".$_POST['maxid']."' and (event_data.`timestamp` between '".$_POST['start_time']."' and '".$_POST['end_time']."') order by timestamp desc";*/

 $end    = @$_POST["end_time"];
  $imei   = $_REQUEST["imei"];
if( $end !='')
{
  $enddate = explode(" ", $end)[0];
}
else
{
  $enddate  = '';
}
$maxdatecond = '';
    if( $end !='')
    { $currentdate = date("Y-m-d");
      if($enddate != $currentdate)
      {
        $maxdatecond = "and event_data.id <= '".$_POST['maxid']."'";
      }
    }
    

    $imeis = explode(",", $imei);

     $rows = array(); 
foreach ($imeis as $key => $value)
    {
         $data = "select event_data.id,event_data.deviceid,event_data.eventcode,event_data.timestamp,event_data.lati,event_data.longi,event_data.altitude,event_data.speed,event_data.accelaration,event_data.declaration,event_data.rpm,event_data.heading,event_data.miles_driven,event_data.mpg,event_data.bettery,event_data.fule,tbl_eqptype.eqp_url,event_desc.description,event_data.DeviceImei from event_data left join devicedetails on event_data.DeviceImei = devicedetails. DeviceIMEI left join tbl_eqptype on tbl_eqptype.eq_name = devicedetails.DeviceType left join event_desc on event_desc.eventcode = event_data.eventcode where event_data.DeviceImei = ".$value." and event_data.id >= '".$_POST['minid']."' ".$maxdatecond." and  if('".$_POST['start_time']."'!='',timestamp > '".$_POST['start_time']."',timestamp > DATE_SUB(NOW(), INTERVAL 24 hour)) and if('".$_POST['end_time']."'!='',timestamp < '".$_POST['end_time']."',1)  order by timestamp asc limit 1";
      

         $data = $conn->query($data);

          $rowssingle = array();
      
         while($r = $data->fetch_object())
         {
            $rowssingle[]  = (array)$r;
         } 
         $rows =  array_merge($rowssingle,$rows);
   
    }
  

$query = "select event_data.id,event_data.deviceid,event_data.eventcode,event_data.timestamp,event_data.lati,event_data.longi,event_data.altitude,event_data.speed,event_data.accelaration,event_data.declaration,event_data.rpm,event_data.heading,event_data.miles_driven,event_data.mpg,event_data.bettery,event_data.fule,tbl_eqptype.eqp_url,event_desc.description,event_data.DeviceImei from event_data left join devicedetails on event_data.DeviceImei = devicedetails. DeviceIMEI left join tbl_eqptype on tbl_eqptype.eq_name = devicedetails.DeviceType left join event_desc on event_desc.eventcode = event_data.eventcode where event_data.DeviceImei in (".$imei.") and event_data.id >= '".$_POST['minid']."' ".$maxdatecond." and if('".$_POST['start_time']."' !='',timestamp > '".$_POST['start_time']."',timestamp > DATE_SUB(NOW(), INTERVAL 24 hour)) and if('".$_POST['end_time']."'!='',timestamp < '".$_POST['end_time']."',1)  order by timestamp desc";
//echo $query; die();
   $result = $conn->query($query);
       $data_rows = array();
       //while($r = mysql_fetch_assoc($data))
       	while($r = $result->fetch_object())
       {
       $data_rows[]  = (array)$r;
       } 
	 
     
    foreach ($data_rows as $value) {
    	
      $string_res.="[\"". ( implode("\",\"",array_values($value)))."\"]" . ","; 
      
    }

   
    $finalstring_res = "[".trim($string_res, ",")."]"; 
    echo $finalstring_res;
      //$finalstring_res = substr($string_res,3); 
?>
