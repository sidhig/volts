<?PHP
include_once('connect.php');
error_reporting(2);
$tp = $_GET["tp"];


//if ($dbconn) {
		  
			 mysql_query("set time_zone = '-4:00' ");

		    $data = mysql_query("(select veh_no from trip_sheet where status <> 'Completed'  and status <> 'Arrived' and  time_sheet = '$tp')union all
(select veh_no from relocation where status <> 'Completed'  and status <> 'Arrived' and  time_sheet = '$tp')")or die(mysql_error()); 
		    if( mysql_affected_rows() == 0)
		    {
			   $data = mysql_query("(select `status` from trip_sheet where  time_sheet = '$tp') union all (select `status` from trip_sheet where  time_sheet = '$tp')")or die(mysql_error()); 
				while ($row = mysql_fetch_assoc($data))
			   {
				    echo "This Tripsheet already ". $row['status'];
			   }
		    }
		    else
		    {
			   while ($row = mysql_fetch_assoc($data))
			   {
				    $veh_no   =  $row['veh_no'];
			   }

			  $data = mysql_query("select lati,longi,timestamp,eventcode from event_data_last  where DeviceImei = '$veh_no' order by `timestamp` desc limit 1")or die(mysql_error()); 


			  if( mysql_affected_rows() == 0)
			  {
				 echo "Sorry no data found!!";
			  }
			 
			  else
			  {
				   while($row = mysql_fetch_assoc($data))
				   {
						$url = "http://maps.google.com/maps?q=". $row['lati'].'+'.$row['longi'];
						header("Location: $url ");
				   }
			  }
		   }
	//}
	
?>

