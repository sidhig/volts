<?
			include_once('connect.php');
			session_start();

?>
<style>
th,caption{
text-align: center;
}
</style>
<center>
<table border='1' width='90%' cellspacing="10" style="text-align: center;">
<caption><h3>Repair Request</h3></caption>
<tr><th>Equip#</th><th >Requested</th><th>Comments</th><th>Call Status</th><th>Driver</th><th>Dispatched</th></tr>
<tr><th></th><th></th><th></th><th></th><th></th><th></th></tr>
<?
$result = $conn->query("select vforcerepairrequest.*,vforcedispatch.id as dispatchid,vforcedispatch.status as 'callstatus',vforcedispatch.callfor , vforcedispatch.creationdate,devicedetails.DeviceType,devicedetails.DeviceIMEI from vforcerepairrequest left join vforcedispatch on vforcerepairrequest.id = vforcedispatch.requestid  left join devicedetails on vforcerepairrequest.devicename =  devicedetails.DeviceName where  (vforcedispatch.status  != 'Completed' and vforcedispatch.status != 'Cancel') or vforcerepairrequest.status  = 'requested' order by requestdate desc");
while($row = $result->fetch_object()) {?>
 
<tr style='font-size:14px;'>
<td><a onclick="zoom_eqp_type('<?=$row->DeviceIMEI?>',20);" style="cursor:pointer; font-weight:700;" ><?=$row->devicename?></a></td>
<td><?=date('m-d-Y H:i A',strtotime($row->requestdate))?></td>
<td><?=$row->comments?></td>
<td><? if($row->status !='requested') { echo($row->callstatus); } else { echo('Requested'); } ?></td>
<td><?=$row->drivername?></td>
<td><?=$row->callfor?></td>
</tr>
<?
 
}
?>
</table>
</center>