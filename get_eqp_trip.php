<?php

  session_start();
  error_reporting(0);
   include_once('connect.php');
  /*if(!isset($_SESSION['LOGIN_STATUS'])){
      header('location:login.php');
  }
$mbval='';*/
	if( $_REQUEST["equip_type"]!='All' )
{
	$result1 = mysql_query("select DeviceName,DeviceIMEI from devicedetails where username = 'gpc' and DeviceType = '".$_REQUEST["equip_type"]."' and CASE WHEN (select dept  as eqpval  from roletable where username = '".$_SESSION['LOGIN_user']."') = 'All' THEN 1 ELSE (select dept from roletable where username = '".$_SESSION['LOGIN_user']."') like CONCAT('%', department, '%')  END and  CASE WHEN (select `group`  as eqpval  from roletable where username = '".$_SESSION['LOGIN_user']."') = 'All' THEN 1 ELSE (select `group` from roletable where username = '".$_SESSION['LOGIN_user']."') like CONCAT('%', `group`, '%')  END");
		while($row = mysql_fetch_array($result1)) 
	{
		echo "<option data-value=".$row["DeviceIMEI"]." value=".$row["DeviceName"]."></option>";
	}
}
else if( $_REQUEST["equip_type"]=='All' )
{
	$result1 = mysql_query("select DeviceName,DeviceIMEI from devicedetails where username = 'gpc' and CASE WHEN (select dept  as eqpval  from roletable where username = '".$_SESSION['LOGIN_user']."') = 'All' THEN 1 ELSE (select dept from roletable where username = '".$_SESSION['LOGIN_user']."') like CONCAT('%', department, '%')  END and  CASE WHEN (select `group`  as eqpval  from roletable where username = '".$_SESSION['LOGIN_user']."') = 'All' THEN 1 ELSE (select `group` from roletable where username = '".$_SESSION['LOGIN_user']."') like CONCAT('%', `group`, '%')  END");
		while($row = mysql_fetch_array($result1)) 
	{		
		echo "<option data-value=".$row["DeviceIMEI"]." value=".$row["DeviceName"]."></option>";
	}
}
?>