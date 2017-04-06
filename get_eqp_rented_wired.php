<?php

  session_start();
  error_reporting(0);
   include_once('connect.php');
	if( $_REQUEST["equip_type"]!='All' )
{
	$result1 = mysql_query("select DeviceIMEI,DeviceName from devicedetails where DeviceName !='' and DeviceName is not null and
opco in (select name from role_opco where if('".$_SESSION['ROLE_opco']."'='0',1,id in (".$_SESSION['ROLE_opco']."))) and 
`primary` in (SELECT name from role_primary where if('".$_SESSION['ROLE_primary']."'='0',1,id in (".$_SESSION['ROLE_primary']."))) and 
`group` in (SELECT name from role_group where if('".$_SESSION['ROLE_group']."'='0',1,id in (".$_SESSION['ROLE_group']."))) and 
department in (SELECT name from role_dept where if('".$_SESSION['ROLE_dept']."'='0',1,id in (".$_SESSION['ROLE_dept']."))) and 
DeviceType in (SELECT eq_name from tbl_eqptype where if('".$_SESSION['ROLE_eqp']."'='0',1,id in (".$_SESSION['ROLE_eqp']."))) and 
ownedby not like '%GPC%' and OBDType = 'Wired' and DeviceType = '".$_REQUEST["equip_type"]."' order by DeviceName ");
		while($value = mysql_fetch_array($result1))
	{
		echo "<option value='".$value['DeviceIMEI']."' >".$value['DeviceName']."</option>";
	}
}
else if( $_REQUEST["equip_type"]=='All' )
{
	$result1 = mysql_query("select DeviceIMEI,DeviceName from devicedetails where DeviceName !='' and DeviceName is not null and
opco in (select name from role_opco where if('".$_SESSION['ROLE_opco']."'='0',1,id in (".$_SESSION['ROLE_opco']."))) and 
`primary` in (SELECT name from role_primary where if('".$_SESSION['ROLE_primary']."'='0',1,id in (".$_SESSION['ROLE_primary']."))) and 
`group` in (SELECT name from role_group where if('".$_SESSION['ROLE_group']."'='0',1,id in (".$_SESSION['ROLE_group']."))) and 
department in (SELECT name from role_dept where if('".$_SESSION['ROLE_dept']."'='0',1,id in (".$_SESSION['ROLE_dept']."))) and 
DeviceType in (SELECT eq_name from tbl_eqptype where if('".$_SESSION['ROLE_eqp']."'='0',1,id in (".$_SESSION['ROLE_eqp']."))) and 
ownedby not like '%GPC%' and OBDType = 'Wired' order by DeviceName");
		while($value = mysql_fetch_array($result1)) 
	{		
		echo "<option value='".$value['DeviceIMEI']."' >".$value['DeviceName']."</option>";
	}
}
?>