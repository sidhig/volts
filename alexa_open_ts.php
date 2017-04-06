<?php
  session_start();
  error_reporting(0);
include_once('connect.php');
$data = $conn->query("select IMEI from alexazoomts order by id desc limit 1 " ) or die(mysqli_error());
if($data->num_rows > 0){ 
    while ($row = $data->fetch_object())
    {
    echo dirname($_SERVER['PHP_SELF']).'/trip_pdf.php?tsn='.$row->IMEI;
    }}
	$conn->query("delete from alexazoomts ");
?>