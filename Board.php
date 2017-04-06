
<script>
var is_show_all = false;
  function show_table(){
$('#show_all_spinner').show();
  $.post('testing_board.php',{show_all:'true'},function(data){
  	//alert(data);
  	$('.table_info').html('');
  	$('#show_all_spinner').hide();
  	$('.table_info').html(data);
  	$(".board_arrow").css('transform','rotate(180deg)');
  	$(".board_table").show(); 
  });
 }
   
 /*function show_table(){
$(".board_table").show(); 
$("#board_json").val('[{"eq_a1_0":1,"eq_a1_1":1,"eq_a1_2":1,"eq_a1_3":1,"eq_a1_4":1,"eq_a1_5":1,"eq_a1_6":1,"eq_a1_7":1,"eq_a1_8":1,"eq_a1_9":1,"eq_a1_10":1,"eq_a1_11":1,"eq_a1_12":1,"eq_a1_13":1,"eq_a1_14":1,"eq_a1_15":1,"eq_a1_16":1,"eq_a1_17":1,"eq_a1_18":1,"eq_a1_19":1,"eq_a1_20":1,"eq_a1_21":1,"eq_a1_22":1,"eq_a1_23":1,"eq_a1_24":1,"eq_a1_25":1,"eq_a1_26":1,"eq_a1_27":1,"eq_a1_28":1,"eq_a1_29":1,"eq_a1_30":1,"eq_a1_31":1,"eq_a1_32":1,"eq_a1_33":1,"eq_a1_34":1,"eq_a1_35":1,"eq_a1_36":1,"eq_a1_37":1,"eq_a1_38":1,"eq_a1_39":1,"eq_a1_40":1,"eq_a1_41":1,"eq_a1_42":1,"eq_a1_43":1,"eq_a1_44":1,"eq_a1_45":1,"eq_a1_46":1,"eq_a1_47":1,"eq_a1_48":1,"eq_a1_49":1,"eq_a1_50":1,"eq_a1_51":1,"eq_a1_52":1,"eq_a1_53":1}]');
$(".board_arrow").css('transform','rotate(180deg)');

 }*/
/**/ function hide_all_table(){
$(".board_table").hide(); 
$("#board_json").val('[{"eq_a1_0":0,"eq_a1_1":0,"eq_a1_2":0,"eq_a1_3":0,"eq_a1_4":0,"eq_a1_5":0,"eq_a1_6":0,"eq_a1_7":0,"eq_a1_8":0,"eq_a1_9":0,"eq_a1_10":0,"eq_a1_11":0,"eq_a1_12":0,"eq_a1_13":0,"eq_a1_14":0,"eq_a1_15":0,"eq_a1_16":0,"eq_a1_17":0,"eq_a1_18":0,"eq_a1_19":0,"eq_a1_20":0,"eq_a1_21":0,"eq_a1_22":0,"eq_a1_23":0,"eq_a1_24":0,"eq_a1_25":0,"eq_a1_26":0,"eq_a1_27":0,"eq_a1_28":0,"eq_a1_29":0,"eq_a1_30":0,"eq_a1_31":0,"eq_a1_32":0,"eq_a1_33":0,"eq_a1_34":0,"eq_a1_35":0,"eq_a1_36":0,"eq_a1_37":0,"eq_a1_38":0,"eq_a1_39":0,"eq_a1_40":0,"eq_a1_41":0,"eq_a1_42":0,"eq_a1_43":0,"eq_a1_44":0,"eq_a1_45":0,"eq_a1_46":0,"eq_a1_47":0,"eq_a1_48":0,"eq_a1_49":0,"eq_a1_50":0,"eq_a1_51":0,"eq_a1_52":0,"eq_a1_53":0}]');
$(".board_arrow").css('transform','rotate(0deg)');

//$("[onclick^='view_table']").css("transform","rotate(0deg)");
//$("[onclick^='hide_table']").css("transform","rotate(0deg)");
//$("[onclick^='hide_table']").
 }
function view_table(id2,eq_type)  {
  $( "#show_all_radio" ).prop( "checked", false );
  $( "#hide_all_radio" ).prop( "checked", false );
  $("#div-"+id2).hide();
  $("#spin_"+id2).show();
  $("#div-"+id2).attr('onclick','hide_table(\''+id2+'\',\''+eq_type+'\')');
  var eqp_toview=$.parseJSON($( "#board_json" ).val());
  var full_id='eq_'+id2;
  eqp_toview[0][full_id] = 1;
  eqp_toview_string = JSON.stringify(eqp_toview);
  $( "#board_json" ).val(eqp_toview_string);

  $.post('testing_board.php',{eq_type:eq_type},function(data){
  	$('#'+id2).html(data);
  	$("#div-"+id2).show();
  	$("#spin_"+id2).hide();
  	$("#div-"+id2).css('transform','rotate(180deg)');
  	$('#'+id2).toggle();
  });
} 

 function hide_table(id2,eq_type)  {
 	var arrow_deg = getRotationDegrees($("#div-"+id2));
	if(arrow_deg == 0){ 
    	view_table(id2,eq_type);
	}else{
		$("#div-"+id2).hide();
  		$("#spin_"+id2).show();
		$('#'+id2).toggle();
		$( "#show_all_radio" ).prop( "checked", false );
		$("#div-"+id2).attr('onclick','view_table(\''+id2+'\',\''+eq_type+'\')');
	  	var eqp_toview=$.parseJSON($( "#board_json" ).val());
		var full_id='eq_'+id2;
	    eqp_toview[0][full_id] = 0;
		eqp_toview_string = JSON.stringify(eqp_toview);
		$( "#board_json" ).val(eqp_toview_string);
		$("#div-"+id2).show();
  		$("#spin_"+id2).hide();
	    $("#div-"+id2).css('transform','rotate(0deg)');
}
}  

function getRotationDegrees(obj) {
    var matrix = obj.css("-webkit-transform") ||
    obj.css("-moz-transform")    ||
    obj.css("-ms-transform")     ||
    obj.css("-o-transform")      ||
    obj.css("transform");
    if(matrix !== 'none') {
        var values = matrix.split('(')[1].split(')')[0].split(',');
        var a = values[0];
        var b = values[1];
        var angle = Math.round(Math.atan2(b, a) * (180/Math.PI));
    } else { var angle = 0; }
    return (angle < 0) ? angle + 360 : angle;
}

</script>
<center><!----><label class="radio-inline">
      <input type="radio" name="radio1" id="hide_all_radio"   onclick='hide_all_table();' >Hide all equipment
    </label>
<label class="radio-inline">
     <input type="radio" name="radio1" id="show_all_radio"  onclick='show_table();' >Show all equipment
    </label></center>
<center>
<center><div id="board_spinner" style="color:red; clear: both; font-size: 1.2rem; display:none;"><img src="image/spinner.gif" width="20px"> Please Wait... Refreshing...</div></center>
<center><div id="show_all_spinner" style="color:red; clear: both; font-size: 1.2rem; display:none;"><img src="image/spinner.gif" width="20px"> Please Wait...</div></center>


<?
error_reporting(0);
session_start();
include_once('connect.php');

if($_POST['board_json']!=''){
$obj_toshowhide = json_decode($_POST['board_json']);
}else{
$_POST['board_json'] = '[{"eq_a1_0":0,"eq_a1_1":0,"eq_a1_2":0,"eq_a1_3":0,"eq_a1_4":0,"eq_a1_5":0,"eq_a1_6":0,"eq_a1_7":0,"eq_a1_8":0,"eq_a1_9":0,"eq_a1_10":0,"eq_a1_11":0,"eq_a1_12":0,"eq_a1_13":0,"eq_a1_14":0,"eq_a1_15":0,"eq_a1_16":0,"eq_a1_17":0,"eq_a1_18":0,"eq_a1_19":0,"eq_a1_20":0,"eq_a1_21":0,"eq_a1_22":0,"eq_a1_23":0,"eq_a1_24":0,"eq_a1_25":0,"eq_a1_26":0,"eq_a1_27":0,"eq_a1_28":0,"eq_a1_29":0,"eq_a1_30":0,"eq_a1_31":0,"eq_a1_32":0,"eq_a1_33":0,"eq_a1_34":0,"eq_a1_35":0,"eq_a1_36":0,"eq_a1_37":0,"eq_a1_38":0,"eq_a1_39":0,"eq_a1_40":0,"eq_a1_41":0,"eq_a1_42":0,"eq_a1_43":0,"eq_a1_44":0,"eq_a1_45":0,"eq_a1_46":0,"eq_a1_47":0,"eq_a1_48":0,"eq_a1_49":0,"eq_a1_50":0,"eq_a1_51":0,"eq_a1_52":0,"eq_a1_53":0}]';

$obj_toshowhide = json_decode($_POST['board_json']);
}?>
 <span class="table_info">
<div id ="style" style="height:auto; /*border: 3px ridge blue; */ margin-top:5px;font-size:.9vw; "> 
<?
//print_r($_POST);
		//$fresult = mysql_query("select DeviceType from devicedetails where UserName = 'GPC' group by DeviceType");
		$fresult = $conn->query("select devicetype.*,tbl_eqptype.eq_code from (select  DeviceType ,count(*) as 'count' from (select MAX(Event_data_last_view.timestamp) as timestamp , Event_data_last_view.deviceid from Event_data_last_view,event_desc where Event_data_last_view.eventcode = event_desc.eventcode  and Event_data_last_view.DeviceImei  in (Select DeviceIMEI from devicedetails where UserName = 'gpc' group by DeviceIMEI) group by Event_data_last_view.deviceid) as maxdata, Event_data_last_view,event_desc where Event_data_last_view.timestamp = maxdata.timestamp and Event_data_last_view.eventcode = event_desc.eventcode and maxdata.deviceid = Event_data_last_view.deviceid and DeviceType in (SELECT eq_name from tbl_eqptype where if('".$_SESSION['ROLE_eqp']."'='0',1,id in (".$_SESSION['ROLE_eqp']."))
) and DeviceIMEI != '270113183010345228'  group by DeviceType order by  DeviceType) as devicetype left join tbl_eqptype on devicetype.DeviceType = tbl_eqptype.eq_name order by  DeviceType"); ?>
<? 		$nr = $fresult->num_rows;//echo $nr; 
		$col_wants = 8;
		$once_width = (100/8);
		$no_rows = round($nr/$col_wants);
	for($i=0;$i<$nr;$i++) { ?>
<? $equip = $fresult->fetch_object(); ?>
	<? if($i % $no_rows == 0 || $nr<7) { 
			if($i != 0) { ?></div><? } ?>
			<div class="panel panel-primary"  style="float:left;height:auto;width:<?=$once_width?>%;margin-bottom: 0px; ">
	<? } ?>

<div class="panel-heading"  style="border: 2px ridge #BCC6CC;background-color:#e8e8e8;color:black;padding: 8px 2px; border :1px solid black;">

<span id="spin_a1_<?=$i?>" style="float: right;display: none;margin-top: 4px;margin-right: 8px;padding: 0px 2px;">
	<img src="image/spinner.gif" width="12px">
</span>
  <span class="board_arrow" style="float:right;margin-top: 4px;margin-right: 8px;padding: 0px 2px;<? if($obj_toshowhide[0]->{'eq_a1_'.$i}==1){ ?>transform:rotate(180deg);<?}else{ ?>transform:rotate(0deg);<? } ?> height: 15px;" id="div-a1_<?=$i?>" 
  onclick="<? if($obj_toshowhide[0]->{'eq_a1_'.$i}==1){ ?>hide_table('a1_<?=$i?>','<?=$equip->DeviceType?>')<?}else{ ?>view_table('a1_<?=$i?>','<?=$equip->DeviceType?>')<? } ?>">
 
  <img src="image/drop_arrow.png" style="height: 2.5vh;"></img>
  </span><b><a onclick="zoom_eqp_type('<?=$equip->DeviceType?>',21);" style="cursor:pointer; color:green; font-size:1.2rem;" ><? //$obj_toshowhide[0]->{'eq_a1_'.$i}?><?=$equip->DeviceType?> (<?=$equip->count?>)</a></b></div>           
 
  <table class="board_table" style="border: 3px ridge green; font-family:monospace;<? if($obj_toshowhide[0]->{'eq_a1_'.$i}==1){ }else{ ?>display:none;<? } ?>width:100%;margin-bottom: 0px;font-size:large;" id="a1_<?=$i?>">
       <?/* $qry = $conn->query("select  Event_data_last_view.deviceid as 'DeviceName',DeviceType,lati,longi,DeviceImei as 'DeviceIMEI',IF((TIME_TO_SEC(TIMEDIFF(now(),maxdata.timestamp))/7200)>1,2,0) as timediff,'4011' as `status`, (Event_data_last_view.`timestamp` -interval 0 hour) as 'timestamp',driver_name from (select MAX(Event_data_last_view.timestamp) as timestamp , Event_data_last_view.deviceid from Event_data_last_view,event_desc where Event_data_last_view.eventcode = event_desc.eventcode  and Event_data_last_view.DeviceImei  in (Select DeviceIMEI from devicedetails where UserName = 'GPC' group by DeviceIMEI) group by Event_data_last_view.deviceid) as maxdata, Event_data_last_view,event_desc where Event_data_last_view.timestamp = maxdata.timestamp and Event_data_last_view.eventcode = event_desc.eventcode and maxdata.deviceid = Event_data_last_view.deviceid and  DeviceType  = '".$equip->DeviceType."' and DeviceIMEI != '270113183010345228'  group by Event_data_last_view.deviceid order by DeviceName asc"); 
		while($latires = $qry->fetch_object()) {
		$forPOI = $conn->query("SELECT lower('".$latires->DeviceName."') as 'DeviceName',(name) AS 'POI',(((acos(sin((".$latires->lati."*pi()/180)) * sin((lati*pi()/180))+cos((".$latires->lati."*pi()/180)) * cos((lati*pi()/180)) * cos(((".$latires->longi."- longi)*pi()/180))))*180/pi())*60*1.1515) as distance, '".$latires->DeviceType."' as 'DeviceType' ,'".$latires->DeviceIMEI."' as 'DeviceIMEI','4011' as `status` FROM `substation_more`  order by distance limit 1");
		$row0 = $forPOI->fetch_object();
		$for_req = $conn->query("SELECT * FROM trip_sheet where veh_no = '".$latires->DeviceIMEI."' and (status='Open' or status='EnRoute') order by time_sheet limit 1")->fetch_object(); 
		$for_eqp_det = $conn->query("select eqp_det from devicedetails where DeviceIMEI = '".$latires->DeviceIMEI."' and eqp_det is not null")->fetch_object();
		if($equip->DeviceType=='Mobile Substation' | $equip->DeviceType=='Mobile Switch'){
			$for_unit = $conn->query("select concat('(',unit,')') as unit from devicedetails where DeviceIMEI = '".$latires->DeviceIMEI."' and unit is not null")->fetch_object(); 
			$latires->driver_name = $for_unit->unit;
		}
		if(($for_req->req_by!='')|($for_req->req_no!='')){ $req_data = "<br>".$for_req->req_by."<br>".$for_req->req_no; } else { $req_data = ''; }
		?>
		<tr align="center" style="height:65px;"><td class="board-td" style="background:#ffffff; padding: 2px;font-size:1rem;    border: 1px solid black; ">
		<a onclick="zoom_eqp_type('<?=$row0->DeviceIMEI?>',20);" style="cursor:pointer; color:black;" >
		<? if($row0->distance >0 && $row0->distance <1) {
		$fortime = $conn->query("select time,poi from tbl_lastpoitime where imei = '".$latires->DeviceIMEI."'")->fetch_object(); 
		if($fortime->time!=''){
		$atime = substr($fortime->time,5,2)."-".substr($fortime->time,8,2)."-".substr($fortime->time,2,2)." ".substr($fortime->time,11,8); } else { $atime=''; }
		echo "<span style='color:blue;Font-size:1.2rem;' >".$row0->DeviceName."</span><br>".$for_eqp_det->eqp_det."<br>".$latires->driver_name.$req_data."<br>".$atime."<br>(".ucwords($row0->POI).")"; } 
		else echo  "<span style='color:blue;' >".$row0->DeviceName."</span><br>".$for_eqp_det->eqp_det."<br>".$latires->driver_name.$req_data; ?></a></td></tr>

		<? 
		
		} */
		 ?>
		
  </table>   

<? 
}
  /* CASE WHEN (select dept  as eqpval  from roletable where username = '".$_SESSION['LOGIN_user']."') = 'All' THEN 1 ELSE (select dept from roletable where username = '".$_SESSION['LOGIN_user']."') like CONCAT('%', department, '%')  END and  CASE WHEN (select `group`  as eqpval  from roletable where username = '".$_SESSION['LOGIN_user']."') = 'All' THEN 1 ELSE (select `group` from roletable where username = '".$_SESSION['LOGIN_user']."') like CONCAT('%', `Groupname`, '%')  END and*/
?>

<input id='board_json' name='board_json' type='hidden' value='<?=$_POST['board_json']?>'><?//'{'.rtrim($board_json,',').'}'?>
</div><br>
  </span>
</center>
