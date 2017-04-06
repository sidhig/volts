<?php
session_start();
include_once('connect.php');
$data = $conn->query("select IMEI from alexazoom order by id desc limit 1 " ) or die(mysqli_error()); 
if($data->num_rows > 0){
    while ($row = $data->fetch_object())
    {
    echo $row->IMEI;
   }}
 $conn->query("delete from alexazoom");
?>