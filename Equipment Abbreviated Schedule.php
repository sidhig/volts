<script src="js/jquery.min.js"></script>
<script src="js/jquery-1.9.1.js"></script>

 <!-- <script src="js/bootstrap.min.js"></script>
   <link rel="stylesheet" href="css/bootstrap.min.css"> -->
<?
   // print_r(['unit']);
include_once('connect.php');?>
 <!-- <div style='background:white; font-size: 1.2rem;width: 100%; border-radius: 15px; padding: 5px; border: 2px solid #969090;'> -->
<center><div  style="width:93vw;border:1px solid #ddd;margin-top:1vh;">
	<span style="float:left;"><!-- <input type="button" value="Back" onclick="sch_back();$('#sch_cal').show();"> --></span>
	<h3><strong>Equipment Abbreviated Schedule</strong></h3>
	<!-- <h3>Please send scheduling request to GPC Substation Support - g2gpcsubsup@southernco.com</h3> -->
<table class="table" width:'98%'>
<?$qry = "select CAST(devicedetails.unit AS SIGNED) as unit_,devicedetails.unit,mvadata.high_side,mvadata.low_side,mvadata.mva,DeviceIMEI from devicedetails left join ( select CAST(unit AS SIGNED) as unit_,unit,high_side,low_side,mva,requires_mobile from devicedetails where unit != '' and  unit is not null and (high_side != '' or low_side != '' or mva!= '' )
order by  CAST(unit AS SIGNED) ) as mvadata on CAST(devicedetails.unit AS SIGNED) = mvadata.unit_ where devicedetails.unit != '' and  devicedetails.unit is not null group by CAST(unit AS SIGNED) order by  CAST(unit AS SIGNED)
";
$result = mysql_query($qry);
while($row=mysql_fetch_assoc($result)){
	$latires = mysql_fetch_array(mysql_query("select  Event_data_last_view.deviceid as 'DeviceName',DeviceType,lati,longi,DeviceImei as 'DeviceIMEI',IF((TIME_TO_SEC(TIMEDIFF(now(),maxdata.timestamp))/7200)>1,2,0) as timediff,'4011' as `status`, (Event_data_last_view.`timestamp` -interval 0 hour) as 'timestamp',driver_name from (select MAX(Event_data_last_view.timestamp) as timestamp , Event_data_last_view.deviceid from Event_data_last_view,event_desc where Event_data_last_view.eventcode = event_desc.eventcode  and Event_data_last_view.DeviceImei  in (Select DeviceIMEI from devicedetails where UserName = 'GPC' group by DeviceIMEI) group by Event_data_last_view.deviceid) as maxdata, Event_data_last_view,event_desc where Event_data_last_view.timestamp = maxdata.timestamp and Event_data_last_view.eventcode = event_desc.eventcode and maxdata.deviceid = Event_data_last_view.deviceid and DeviceIMEI = '".$row['DeviceIMEI']."'  and lati!='' and lati is not null "));
	if($latires['lati']!='')
	/*$poiqry = mysql_query("SELECT (name) AS 'poi',(((acos(sin((".$latires['lati']."*pi()/180)) * sin((lati*pi()/180))+cos((".$latires['lati']."*pi()/180)) * cos((lati*pi()/180)) * cos(((".$latires['longi']."- longi)*pi()/180))))*180/pi())*60*1.1515) as distance FROM `substation_more` order by distance limit 1");*/
     $poiqry = mysql_query("select storage_facility from subs_mobile where mobile ='".$row['unit_']."' order by mobile limit 1");
     //print_r($poiqry);
	$forpoi=mysql_fetch_array($poiqry);?>

<tr>
	<th style="width: 12vw;">
       <form method="post" action="" id="form<?=$row['unit']?>">
	       	<input type="hidden" name="time_sheet" value="<?=$row['unit']?>" />
			<a onclick="add_motel('<?=$row['unit']?>');" style="cursor:pointer;" >Mobile <?=$row['unit_']?></a>
		<!-- 	//print_r($row); -->
	  </form> 
	</th>
	<th><img src="image/calendar_icon.png" style="margin-left: -64px;" width="30" height="30"onclick="event_calender(<?=$row['unit_']?>)"></th>
	<th>HS<?=$row['high_side']?></th>
	<th>LS<?=$row['low_side']?></th>
	<th>MVA<?=$row['mva']?></th>
	<th colspan='3'>Storage Facility: <?=$forpoi['storage_facility']?></th>
</tr>

<?

$qry = "select id,status,unit,assoc_unit,start_date,end_date,loc_need,concat (if(contactname = '' or contactname is null , '' , contactname), if(contact_off = '' or contact_off is null , '' , concat(' , ',contact_off)),if(contact_mobile = '' or contact_mobile is null , '' , concat(' , ',contact_mobile)),if(contact_linc = '' or contact_linc is null , '' , concat(' , ',contact_linc)),if(contact_email = '' or contact_email is null , '' , concat(' , ',contact_email))) as contact from eqp_schedule where  
assoc_unit like '% ".$row['unit_']."A%' or assoc_unit like '% ".$row['unit_']."B%' or assoc_unit like '% ".$row['unit_']."C%' or  assoc_unit like '% ".$row['unit_']."%' 
or assoc_unit like '".$row['unit_']."A%' or assoc_unit like '".$row['unit_']."B%' or assoc_unit like '".$row['unit_']."C%'  or assoc_unit like '".$row['unit_']."%'   
or unit = '".$row['unit_']."A' or unit = '".$row['unit_']."B' or unit = '".$row['unit_']."C' or unit = '".$row['unit_']."' or assoc_unit like '%".$row['unit_']."' order by start_date desc LIMIT 3 ";
$subresult = mysql_query($qry);
if(mysql_num_rows($subresult)>0){?>
<tr>
	<th>Sched ID</th>
	<th>Units</th>
	<th>Co</th>
	<th>Start Date</th>
	<th>End Date</th>
	<th>Location</th>
	<th>Contact</th>
	<!-- <th>status</th> -->
</tr>
<?while($subrow=mysql_fetch_assoc($subresult)){?>
<tr>
	
<td ><?=$subrow['id']?><?
if($subrow['status']=="Pending"){

echo '<img src="image/yellow.png " >';
}
else  if($subrow['status']=="Approved"){

echo '<img src="image/red2.png">';
}
else if($subrow['status']=="Completed"){

echo '<img src="image/grey.png">';
}


?></td>
<td><?=$subrow['unit'].$subrow['assoc_unit']?></td>
<td>GPC</td>
<td><?=date('D, m/d/Y',strtotime($subrow['start_date']))?></td>
<td><?=date('D, m/d/Y',strtotime($subrow['end_date']))?></td>
<td><?=$subrow['loc_need']?></td>
<td><?=$subrow['contact']?></td>

</tr>
<?}}}?>


</table>
</div></center>
<!-- </div> -->
<script>
  $('#img').append('<img src="/image/yellow.png" />'); 
</script>
<script>
function event_calender(unit){ 
	
	$("#loading_spinner").show();
	//view = $("#sch_view").val();
$.post( "events_calendar.php",{ unit: unit },function(data) {
		$('#schedule_abbr').hide();
		$("#schedule_abbr").empty();
		$("#schedule_abbr").html(data);
		$('#schedule_abbr').show();
		$("#loading_spinner").hide();
		});
}

function add_motel(unit){
	//alert(unit);
	$('#sch_view_div').hide();
$.ajax({
						type: 'post',
						url: 'new_sch_cal_get.php',
						//data: $('#form'+unit).serialize(),
						data:"unit="+unit,
						success: function (data) {  //alert(data);
					   $("#schedule_abbr").empty();
					   $("#schedule_abbr").html(data);
					   $('#schedule_abbr').show();
					   //$("#loading_indicator").hide();
						}
                        
						});
}


</script>
