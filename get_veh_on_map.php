<?PHP
include_once('connect.php');
error_reporting(0);
$veh_no = $_GET["eqp"];


//if ($dbconn) {
		  
		
if($veh_no!=''){
			  $data = mysql_query("select lati,longi,timestamp,eventcode from event_data_last left join devicedetails on event_data_last.DeviceImei =  devicedetails.DeviceIMEI where DeviceName = '$veh_no' order by `timestamp` desc limit 1")or die(mysql_error()); 


			  if( mysql_affected_rows() == 0)
			  {
				 echo "Sorry no data found!!";
			  }
			 
			  else
			  {
				   $row = mysql_fetch_assoc($data);
				   
						$url = "http://maps.google.com/maps?q=". $row['lati'].'+'.$row['longi'];
						header("Location: $url ");
				   
			  }
		   }else{
			echo "Equipment number not found!!";
		   }
	//}
	
?>

