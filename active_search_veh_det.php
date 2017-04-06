<?
//print_r($_POST);die();
 include_once('connect.php');

$query = "select concat('http://maps.google.com/?q=',lati,',',longi) as location,speed,altitude,accelaration,declaration,rpm,heading,DATE_FORMAT(`timestamp`,'%m/%d/%Y %h:%i %p') as `timestamp`,description,(((acos(sin((".$_POST['lati']."*pi()/180)) * sin((`lati`*pi()/180))+cos((".$_POST['lati']."*pi()/180)) * cos((`lati`*pi()/180)) * cos(((".$_POST['longi']."- `longi`)*pi()/180))))*180/pi())*60*1.1515*1609.344*3.28084) as distance from event_data left join event_desc on event_data.eventcode = event_desc.eventcode where  id >= '".$_POST['minid']."' and 
if(date(now()) = '".explode(" ",$_POST['end_time'])[0]."' ,1 ,id <= '".$_POST['maxid']."')  
and (`timestamp` between '".$_POST['start_time']."' and '".$_POST['end_time']."') and deviceid = '".$_POST['dev_id']."'  having `distance` <= 1640.42 order by `timestamp` desc";


?>
<style>
.font{
font-size:1.2rem;
width:8vw; 
}
.font_lable{
font-size:1.2rem;
width: 10vw;" 
}
</style>
<button onclick='back_to_search();' style="position: absolute; left: 5vw;">Back</button>
<center>
<div>
<h4>Equipment # : <?=$_POST['dev_id']?></h4>
<? if($_POST['poi_name']!=''){?>
<h4>POI : <?=$_POST['poi_name']?></h4>
<?}
if($_POST['add']!=''){?>
<h4>Address : <?=$_POST['add']?></h4>
<?}?>
</div>
</center>
<center>
<table style="border: 1px solid #ddd;width: 70vw;text-align:center;" class="table">
<th style="text-align:center;">Speed</th><th style="text-align:center;">Altitude</th><th style="text-align:center;">Acceleration</th><th style="text-align:center;">Deceleration</th><th style="text-align:center;">Timestamp</th><th style="text-align:center;">Description</th><th style="text-align:center;">Distance(Feet)</th>
<?
 $result = mysql_query($query);
while($r = mysql_fetch_object($result)){ ?>
	<tr>
<td><?=round($r->speed)?></td>
<td><?=round($r->altitude)?></td>
<td><?=round($r->accelaration)?></td>
<td><?=round($r->declaration)?></td>
<td><?=$r->timestamp?></td>
<td><?=$r->description?></td>
<td><?=round($r->distance)?><a target="_blank" href="<?=$r->location?>" style="float: right;"><img src="image/activity_search_icon.png" style="height: 5vh;"></a></td>
</tr>
<?}
?>
</table>
</center>
