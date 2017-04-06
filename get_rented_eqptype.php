<?php
  session_start();
  error_reporting(0);
   include_once('connect.php');

	if( $_REQUEST["rent_comp"]!='All' )
{
	$result1 = mysql_query("select DeviceType from devicedetails where DeviceName !='' and DeviceName is not null and
opco in (select name from role_opco where if('".$_SESSION['ROLE_opco']."'='0',1,id in (".$_SESSION['ROLE_opco']."))) and 
`primary` in (SELECT name from role_primary where if('".$_SESSION['ROLE_primary']."'='0',1,id in (".$_SESSION['ROLE_primary']."))) and 
`group` in (SELECT name from role_group where if('".$_SESSION['ROLE_group']."'='0',1,id in (".$_SESSION['ROLE_group']."))) and 
department in (SELECT name from role_dept where if('".$_SESSION['ROLE_dept']."'='0',1,id in (".$_SESSION['ROLE_dept']."))) and 
DeviceType in (SELECT eq_name from tbl_eqptype where if('".$_SESSION['ROLE_eqp']."'='0',1,id in (".$_SESSION['ROLE_eqp']."))) and 
ownedby = '".$_REQUEST["rent_comp"]."' and ownedby not like '%GPC%' and OBDType = 'Wired' group by DeviceType order by DeviceType");
		while($value = mysql_fetch_array($result1))
	{
		echo "<option >".$value['DeviceType']."</option>";
	}
}
else if( $_REQUEST["rent_comp"]=='All' )
{
	$result1 = mysql_query("select DeviceType from devicedetails where DeviceName !='' and DeviceName is not null and
opco in (select name from role_opco where if('".$_SESSION['ROLE_opco']."'='0',1,id in (".$_SESSION['ROLE_opco']."))) and 
`primary` in (SELECT name from role_primary where if('".$_SESSION['ROLE_primary']."'='0',1,id in (".$_SESSION['ROLE_primary']."))) and 
`group` in (SELECT name from role_group where if('".$_SESSION['ROLE_group']."'='0',1,id in (".$_SESSION['ROLE_group']."))) and 
department in (SELECT name from role_dept where if('".$_SESSION['ROLE_dept']."'='0',1,id in (".$_SESSION['ROLE_dept']."))) and 
DeviceType in (SELECT eq_name from tbl_eqptype where if('".$_SESSION['ROLE_eqp']."'='0',1,id in (".$_SESSION['ROLE_eqp']."))) and 
 ownedby not like '%GPC%' and OBDType = 'Wired' group by DeviceType order by DeviceType");
		while($value = mysql_fetch_array($result1)) 
	{		
		echo "<option >".$value['DeviceType']."</option>";
	}
}
?>