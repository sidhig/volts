<?
			include_once('connect.php');
			session_start();
            //echo $_POST['hid_but'];
            $_SESSION['num']=$_POST['hid_but'];
?>
<style>
@font-face {
    font-family: myFirstFont;
    src: url(digital_counter_7.ttf);
}
.header{
    position: relative;
    margin-top: 100px;

}

.box{

    width: 1.4vw;
    height: 12vh;
       margin: 5vh 0vw 0vh 8vw;
    transition: transform 1s linear;
    transform-origin: bottom center;
    background-image: url(image/pin.png);
    background-size: 100% 100%;
	transform: rotate(-135deg);
}

.box1{

    width: 1vw;
    height: 8.5vh;
    margin: 5.4vh 0vw 0vh 6.2vw;
    transition: transform 1s linear;
    transform-origin:bottom center;
    background-image: url(image/pin.png);
    background-size: 100% 100%;
    transform: rotate(-135deg);
}

.box2{

    width: 1vw;
    height: 8.5vh;
    margin: 3vh 0vw 0vh 5vw;
    transition: transform 1s linear;
    transform-origin:bottom center;
    background-image: url(image/pin.png);
    background-size: 100% 100%;
    transform: rotate(-135deg);
}


.box-rotate {
  transform: rotate(90deg);
}
.box1-rotate {
  transform: rotate(90deg);
}
.box2-rotate {
  transform: rotate(90deg);
}
.tab td{
    width:27%;
}

</style>
<script>
function jbus_details_back(){
	jbus_imei_show='';
$("#trip_sheet_div").hide(); 
$("#trip_sheet_div").html("");
}
$('#dash_but').click(function(){
    is_dash_open =1;
   $('#dash_but').hide();
    $('#details_but').show();
    $('#dash_head').show();
    $('#det_head').hide();
    //$( "#info" ).addClass( "header" );
    //$('#dash_but').attr('disabled',true).css({opacity:0.5});
    //$('#details_but').attr('disabled',false).css({opacity:1});
    $('#details').hide();
    $('#dashboard').show();
});
$('#details_but').click(function(){
    is_dash_open =0;
    //$('#details_but').attr('disabled',true).css({opacity:0.5});
    $('#details_but').hide();
     $('#dash_but').show();
     $('#dash_head').hide();
    $('#det_head').show();
    //$('#dash_but').attr('disabled',false).css({opacity:1});
    $('#dashboard').hide();
    $('#details').show();
    
});
</script>
<center>
<div style='background:white; font-size: 1.2rem; width: 60vw;
    min-height: 80vh;
    border: #746F6F 1px solid;
    background-color: white;
    border-radius: 4px;'>
<table width="90%" style="table-layout:fixed;">
<tr>
	<th style='text-align:left;width: 35%;'><input onclick='jbus_details_back();' type="button" value="Back" /><input type="button" id="dash_but" value="Dashboard"  <? if($_REQUEST['is_dash_open']){ ?> style="display:none; <? } ?>"><input type="button" id="details_but" value="Details" <? if(!$_REQUEST['is_dash_open']){ ?> style='display:none;' <? } ?> ></th>
	<th style='text-align:center;width: 40%;'><h3 id="det_head" <? if($_REQUEST['is_dash_open']){ ?> style="display:none;"<? } ?> ><b>Engine Details</b></h3><h3 id="dash_head" <? if(!$_REQUEST['is_dash_open']){ ?> style='display:none;' <? } ?> ><b>Dashboard</b></h3></th>
	<td align="right" style='text-align:right;width: 30%;'></td>
</tr>
</table>
<? 
$abc = explode('<strong>Status :</strong>',$_POST['status']);
$ignstatus = @$abc[1];

$pto = $conn->query("select  `ptotime`  from tbl_jbusengine left join tbl_vin_imei on tbl_vin_imei.vin = tbl_jbusengine.vin where tbl_vin_imei.imei = '".$_POST['jbus_imei']."' order by tbl_jbusengine.id desc limit 2");
$pto_row = $pto->fetch_object();
	$curr = $pto_row->ptotime;
$pto_row = $pto->fetch_object();
	$prev = $pto_row->ptotime;

	if($curr>$prev && trim($abc[0])!='Ignition OFF'){ 
	$image='image/igon.png';
	}else{
	$image='image/igoff.png';
	}
	?>

<?
$odomt = $conn->query("select miles_driven_sys from event_data_last where deviceid = '".$_POST['eqpname']."' order by timestamp desc limit 1")->fetch_object();

 $result = $conn->query("select `oiltemp` as 'tem',truncate(`oilpres`,2) as 'pre',`obd_spd`,`fuellvl`,`coollvl`,`torque`,`e_load`,`enghrs`, 
CONVERT( `TrueOdo`/10, DECIMAL(10,1))  as 'miles'  from tbl_jbusengine left join tbl_vin_imei on tbl_vin_imei.vin = tbl_jbusengine.vin where tbl_vin_imei.imei = '".$_POST['jbus_imei']."' order by tbl_jbusengine.id desc limit 1");
$r = $result->fetch_object(); 
//echo $r->pre;
$torque = $r->torque;
$angle = 270*$torque/100;
$torque_angle = $angle-135;

$e_load = $r->e_load;
$angle = 270*$e_load/100;
$e_load_angle = $angle-135;

$coollvl = $r->coollvl;
$angle = 270*$coollvl/100;
$coollvl_angle = $angle-135;

$fuellvl = $r->fuellvl;
$angle = 270*$fuellvl/100;
$fuellvl_angle = $angle-135;

$speed = $_POST['speed'];
$angle = 270*$speed/90;
$speed_angle = $angle-135;

$tem = $r->tem;
$angle = 270*$tem/270;
$temp_angle = $angle-135;

$pres = $r->pre;
$angle = 270*$pres/90;
$pres_angle = $angle-135;
?>

<style>
.speed-rotate {
  transform: rotate(<?=$speed_angle?>deg);
}
.temp-rotate {
  transform: rotate(<?=$temp_angle?>deg);
}
.pres-rotate {
  transform: rotate(<?=$pres_angle?>deg);
}
.fuellvl-rotate {
  transform: rotate(<?=$fuellvl_angle?>deg);
}
.torque-rotate {
  transform: rotate(<?=$torque_angle?>deg);
}
.e_load-rotate {
  transform: rotate(<?=$e_load_angle?>deg);
}
.coollvl-rotate {
  transform: rotate(<?=$coollvl_angle?>deg);
}
.numberCircle {
    padding: 2px;
    background: #313133;
    border: 1px solid #161516;
    color: #fcf9f9;
    text-align: center;
    font: 12px Arial, sans-serif;
}
</style>

<div id="dashboard" style='<? if(!$_REQUEST['is_dash_open']){ ?> display:none; <? } ?> '  >
    <div style="background-image: url(image/dashboardbg.jpg);border: 1px solid black;
    float: left;
    width: 100%;
   ">
    <table class="tab" width='90%' >
    <tr><td style='padding-right: 10px;'> 
<div style='background-image: url(image/temp.png);
    width: 100%;float:left;
    height: 34vh;
    background-size: 100% 100%;  /*margin: 0px 2%;*/ color:white;'>
	<span style=' margin-top: 23vh;
    float: left;
    margin-left: 40%;
    background: black;
    padding: 0 0 0 4px;
    letter-spacing: 1px;
    font-size: 1.4vw;font-family: myFirstFont;'><?=$r->tem?></span>
	<div id='temp_pin' class="box"></div>
</div>
   </td><td>
<div style='background-image: url(image/pressure.png);
    width: 100%;float:left;
    height: 34vh;
    background-size: 100% 100%;  /*margin: 0px 2%; */color:white;'>
    <span style=' margin-top: 23vh;
    float: left;
    margin-left:  38%;
    background: black;
    padding: 0 0 0 4px;
    letter-spacing: 1px;
    font-size: 1.4vw;font-family: myFirstFont;'><?=$r->pre?></span>
    <div id='pres_pin' class="box"></div>
</div>
   </td><td style="width: 2%;">
<div style='/*float:left;
    height: 6vh;
    width: 2%;*/
    margin-top: 30vh;'><img src='<?=$image?>' width='50px' /><b style="margin-left: 0.5vw;color: darkgray;">PTO</b>
</div>
    </td><td>
<div style='background-image: url(image/an_meter.png);
    width: 100%;float:left;
    height: 34vh;
    background-size: 100% 100%; /* margin: 0px 0%;*/ color:white;'>
    <span style=' margin-top: 23vh;
    float: left;
    margin-left: 31.5%;
    background: black;
    padding: 0 0 0 2px;
    letter-spacing: 1px;
    font-size: 1.4vw;font-family: myFirstFont;'> <?=$odomt->miles_driven_sys?></span>
    <div id='speed_pin' class="box"></div>
    <!-- <img id='fuellvl_pin' class="box1" style="    margin: 24px -20px;
    height: 67px;" src="image/pin.png"></div> -->
</div>
</td></tr>
</table>
<table width='90%' style="    margin-left: 17vw;
    /* margin-bottom: 0vh; */
    margin-top: -5vh;">
 <tr>
 <td style="width:11%;">
 <div style=' 
    color: white;
	background-image:url("image/enghrs1.png");
	background-size:100% 100%;
        padding: 1vh;
        width: 5.5vw;
        height: 8vh;
    letter-spacing: 3px;
    font-size: 1.2vw; /* font-family: myFirstFont; */ font-family: sans-serif;'> <span style='margin-left: 0%;margin-top:21%;float:left;'>
	<strong><? 
	$arr = str_split(str_pad($r->enghrs, 4, "0", STR_PAD_LEFT));
foreach($arr as $val)
{
	echo('<span class="numberCircle">'.$val.'</span>');
}
	?></strong></span></div>
    </td>
 
 </tr> 
</table>
<table class="tab" width='90%'>
    <tr><td style="width:20%;">
 <div style='background-image: url(image/fuel.png);
    width: 85%;float:left;
    height: 24vh;
    background-size: 100% 100%; /* margin: 0px 2%;*/ color:white;'>
    <span style=' margin-top: 18vh;
    float: left;
    margin-left: 36%;
    background: black;
    padding: 0 0 0 4px;
    letter-spacing: 1px;
    font-size: 1.2vw;font-family: myFirstFont;'><?=$r->fuellvl?></span>
    <div id='fuellvl_pin' class="box2"></div>
    <!-- <img id='fuellvl_pin' class="box1" style="    margin: 24px -20px;
    height: 67px;" src="image/pin.png"></div> -->

 </td><td style="width:20%;">
<div style='background-image: url(image/coolantLevel.png);
    width: 100%;float:left;
    height: 28.5vh;
    background-size: 100% 100%; /* margin: 0px 2%;*/ color:white;'>
    <span style=' margin-top: 20vh;
    float: left;
    margin-left: 40%;
    background: black;
    padding: 0 0 0 4px;
    letter-spacing: 1px;
    font-size: 1.2vw;font-family: myFirstFont;'><?=$r->coollvl?></span>
 <div id='coollvl_pin' class="box1"></div>
   <!--  <img id='coollvl_pin' class="box1" style="    margin: 23px 0px;
    height: 67px;" src="image/pin.png">  -->
</div>
 </td><td style="width:20%;">
<div style='background-image: url(image/torque.png);
    width: 100%;float:left;
    height: 28.5vh;
    background-size: 100% 100%;  /* margin: 0px 2%; */color:white;'>
	<span style=' margin-top: 20vh;
    float: left;
    margin-left: 40%;
    background: black;
    padding: 0 0 0 4px;
    letter-spacing: 1px;
    font-size: 1.2vw;font-family: myFirstFont;'><?=$r->torque?></span>
	<div id='torque_pin' class="box1"></div>
    <!-- <img id='torque_pin' class="box1" style="    margin: 33px -8px;
    height: 67px;" src="image/pin.png"> -->
</div>
 </td><td style="width:20%;">
<div style='background-image: url(image/engineLoad.png);
    width: 100%;float:left;
    height: 28.5vh;
    background-size: 100% 100%;  /* margin: 0px 2%;*/ color:white;'>
	<span style=' margin-top: 20vh;
    float: left;
    margin-left: 40%;
    background: black;
    padding: 0 0 0 2px;
    letter-spacing: 1px;
    font-size: 1.2vw;font-family: myFirstFont;'> <?=$r->e_load?></span>
	<div id='e_load_pin' class="box1"></div>
    <!-- <img id='e_load_pin' class="box1" style="    margin: 28px -3px;
    height: 67px;" src="image/pin.png"> -->
			
</div>   
</td></tr>
</table>
<?
/*
if($_POST['event']=='4001'){
    $image_src="image/ignon.png";
}else if($_POST['event']=='6011'){
    $image_src="image/ignstart.png";
}else if($_POST['event']=='4002' || $_POST['event']=='6012'){
    $image_src="image/ignoff.png";
}*/
if($_POST['event']=='4002' || $_POST['event']=='6012'){
    $image_src="image/ignoff.png";
}else if($_POST['event']=='6011'){
    $image_src="image/ignstart.png";
}else{
    $image_src="image/ignon.png";
}
?>

<table width='90%' style="margin-left: 26vw;
    margin-top: -6vh;">
 <tr>

 <td style="width:20%;">
 <!-- <div style='background-image: url(<?=$image_src?>);width: 100%;float:left;height: 28.5vh;
 background-size: 100% 100%;'>
    </div> -->
   <img src="<?=$image_src?>" style="height: 15.6vh;width: 7.4vw;">
 </td>
 </tr> 
</table>
</div>

    <table style="table-layout:fixed;">
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <td style='text-align:left;width: 29%;'>Equipment Type : <strong><?=$_POST['type']?></strong></td>
        <td style='text-align:center;width: 25%;'>Driver Name : <strong><?=$_POST['dname']?></strong></td>
        <td align="right" style='text-align:center;width: 25%;'>Equipment # : <strong><?=$_POST['eqpname']?></td>
        <!--<td align="right" style='text-align:center;width: 20%;'>Battery : <strong><?=$_POST['bat']?></td>-->
    </tr>
    </table>

</div><!--Dashboad close-->

<div id="details" <? if($_REQUEST['is_dash_open']){ ?> style='display:none;' <? } ?> >
<table id="info" width="90%" style="table-layout:fixed;">
<tr>
    <td style='text-align:left;width: 29%;'>Equipment Type : <strong><?=$_POST['type']?></strong></td>
    <td style='text-align:center;width: 25%;'>Driver Name : <strong><?=$_POST['dname']?></strong></td>
    <td align="right" style='text-align:center;width: 25%;'>Equipment # : <strong><?=$_POST['eqpname']?></td>
    <!--<td align="right" style='text-align:center;width: 20%;'>Battery : <strong><?=$_POST['bat']?></td>-->
</tr>
</table>
<table width='80%' style='margin:10px;' cellspacing="10" cellpadding="10" >
<tr style=' vertical-align: top;' >
<th>
<table  border='1' width='100%' cellspacing="10" cellpadding="10" style='table-layout:fixed; '>
<?

if($_POST['event']!='4002' &&  $_POST['event']!='6012'){ $ignstate='On'; }else{ $ignstate='Off'; }
//$ignstate = @$_POST['ignstate'];

$odomt = $conn->query("select miles_driven_sys from event_data_last where deviceid = '".$_POST['eqpname']."' order by timestamp desc limit 1")->fetch_object();

$r = array();
$result = $conn->query("select  

DATE_FORMAT(`timeval`,'%b %d %Y %h:%i %p')  as 'Date and Time',
tbl_jbusengine.`vin` as 'VIN' ,
`year` as 'Year' ,
Manufacturer, 
Model ,
Engine,
Axles,
GVWR,
concat('Ignition ','".$ignstate."',' / ','".$abc[1]."')  as 'Vehicle Status', 
CONVERT( `TrueOdo`/10, DECIMAL(10,1))  as 'OBD Odometer (miles)', 
CONVERT(  `fueluse` * 0.264172, DECIMAL(10,0))  as 'Total Fuel Use (Gal)' , 
`oiltemp` as 'Oil Temperature(F)',
truncate(`oilpres`,2) as 'Oil Pressure(psi)'  

from tbl_jbusengine left join tbl_vin_imei on tbl_vin_imei.vin = tbl_jbusengine.vin where tbl_vin_imei.imei = '".$_POST['jbus_imei']."' order by tbl_jbusengine.id desc limit 1");
$r = $result->fetch_assoc();
$x = 0;
 foreach($r as $key=>$value){ 
    $x++;
    if($x == 10){
        $value = $odomt->miles_driven_sys;
    }
    ?>
<tr align='center' style='font-size:12px; padding-left:5px;'>
<th style='text-align:left; padding:5px; '><?=$key?></th>
<td style='text-align:left; padding:5px; '><?=$value?></td>
</tr>

<?
}
?>
</table>
</th><th>
<table border='1' width='100%' cellspacing="10" cellpadding="10" style='table-layout:fixed; margin-left: 10px;' >

<?


$result = $conn->query("select    

t2.fuellvl as 'Fuel level (%)',
t2.enghrs as 'Engine Hrs',
'".$_POST['speed']."' as 'Speed (MPH)', 
t2.rpm as 'RPM', 
t2.ect as 'Engine Coolant Temperature (F)',
t2.coollvl as 'Coolant Level (%)', 

FORMAT ( if( 
(t2.fueluse-t1.fueluse) > 0 , 
 ((( ( t2.TrueOdo/10)- (t1.TrueOdo/10))) /((t2.fueluse - t1.fueluse)*0.264172))
,0),2) as MPG,


t2.torque as 'Torque (%)',
t2.mantemp as 'Manifold Temperature ( F)',
CONVERT((t2.ptotime/3600 ), DECIMAL(10,1))  as 'PTO Time (HH.H)',
t2.pedal as 'Accelerator Position', 
t2.e_load as 'Engine Load (%)', 
 t2.iat as 'Intake Air Temperature (F)' 
 
 from tbl_jbusengine t1
join tbl_jbusengine t2 on (t1.id+1)=(t2.id) and t1.id<t2.id where t2.imei = '".$_POST['jbus_imei']."' order by t2.id desc limit 1");
$r = $result->fetch_assoc();
 foreach($r as $key=>$value){ ?>
<tr align='center' style='font-size:12px; padding-left:5px;'>
	<th style='text-align:left; padding:5px;'><?=$key?></th>
	<td style='text-align:left; padding:5px;'><?=$value?></td>
</tr>

<?
}
?>
</table>
</th>
</tr>
</table>
</div>

</center>