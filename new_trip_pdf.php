<?php
require('fpdf.php');
//require('html2pdf.php');
include_once('connect.php');
    $pdf = new FPDF('P','mm','A4');
//$_REQUEST['tsn']='20160510073458';

	$pdf->AddPage();

$row = $_POST;
if($_POST['ts_or_rl']=='ts'){
$table='tripsheet';
	$costtable='trip';
	$heading='TRIP SHEET AND BILL OF LADING';
	$subheading='Time Sheet Number';
}
else if($_POST['ts_or_rl']=='rl'){
	$table='relocation';
	$heading='RELOCATION SHEET';
	$costtable='relocation';
	$subheading='Relocation Sheet Number';
}

	$pdf->SetFont('Arial','B',16);
	$pdf->Cell(190,10,$heading,0,1,'C');

	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(240,10,$subheading.' :',0,0,'C');
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(-150,10,$row['time_sheet'],0,1,'C');
	
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(49,10,'Date To Be Delivered:',0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(49,10,date('m/d/Y',strtotime($row['del_date'])),0);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(49,10,'Date Requested:',0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(49,10,date('m/d/Y',strtotime($row['req_date'])),0,1);
//$pdf->Cell(0,10,'',0,0);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(49,10,'Contact Person:',0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(49,10,$row['contact_person'],0);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(49,10,'Contact No.:',0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(49,10,$row['contact_no'],0,1);

	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(49,10,'Requested By:',0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(49,10,$row['req_by'],0);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(49,10,'Requester No.:',0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(49,10,$row['req_no'],0,1);

	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(49,10,'Item Being Delivered:',0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(49,10,$row['item_name'],0);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(49,10,'Requester Email:',0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(49,10,$row['req_email'],0,1);

	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(49,10,'Trip Sheet Status:',0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(49,10,$row['status'],0);
$dispatch=mysql_fetch_assoc(mysql_query("select * from tbl_dispatcher where id ='".$row['dispatcher']."'"));
//$dispatch= $_POST;
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(49,10,'Dispatcher:',0);
	$pdf->SetFont('Arial','',9);
	if($dispatch['id']=='0'){
	$pdf->Cell(49,10,'',0,1);}
	else{
	$pdf->Cell(49,10,$dispatch['name'],0,1);	
	}

	if($row['status']=='Cancel'){ 
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(49,10,'Reason for Cancellation:',0);
	$pdf->SetFont('Arial','',9);
	$pdf->SetTextColor(255,0,0);	
    $pdf->Cell(49,10,$row['reason_cancel'],0,1);}
	$pdf->SetTextColor(0,0,0);

	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(49,10,'Contract Driver:',0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(49,10,$row['contract_driver'],0);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(49,10,'Driver Phone:',0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(49,10,$row['driver_phone'],0,1);

	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(49,10,'Notes (PLEASE READ):',0);
	$pdf->SetFont('Arial','',9);
	$pdf->MultiCell(120,10,$row['notes'],0,1);
	$pdf->SetFont('Arial','B',9);

$dev_det = mysql_fetch_assoc(mysql_query("select DeviceName,eq_name from tbl_eqptype left join devicedetails on devicedetails.DeviceType = tbl_eqptype.eq_name where DeviceIMEI = '".$row['veh_no']."'"));
    
	//$dev_det = $_POST;
	$pdf->Cell(49,10,'Tracked Equipment Type:',0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(49,10,$dev_det['eq_name'],0); 

	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(49,10,'Tracked Equipment #:',0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(49,10,$dev_det['DeviceName'],0,1);

	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(49,10,'Equipment Numbers:',0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(49,10,$row['equip_no1']." ",0);
	$pdf->Cell(49,10,$row['equip_no2']." ",0);
	$pdf->Cell(49,10,$row['equip_no3'],0,1);

	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(49,10,'Bobtail Miles:',0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(49,10,$row['bobtail_miles'],0);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(49,10,'w/Trailer Miles:',0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(49,10,$row['trail_miles'],0,1);

	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(49,10,'Dispatch Miles:',0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(49,10,$row['disp_miles'],0);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(49,10,'Trip Type:',0);
	$pdf->SetFont('Arial','',9);
	if($row['depart_poi']!=$row['arrival_poi'] || $row['depart_add']!=$row['arrival_add']){
	$pdf->Cell(49,10,'One Way',0,1);}
	else {
	$pdf->Cell(49,10,'Round Trip',0,1);	
      }

	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(49,10,'Departure POI/Address:',0);
	$pdf->SetFont('Arial','',9);
	if(strtolower($row['depart_poi'])=='address'){
		$pdf->MultiCell(120,10,$row['depart_add'],0,1);
	}else{
		$pdf->MultiCell(120,10,$row['depart_poi'],0,1);
	}
	/*$pdf->SetFont('Arial','B',9);
	$pdf->Cell(49,10,'Departure Date/Time:',0);
	$pdf->SetFont('Arial','',9);
	if($row["depart_time"]!='') {
	$pdf->Cell(49,10,date('m/d/Y h:i A',strtotime($row['depart_time'])),0,1);}
	
	else {
		$pdf->Cell(49,10,'',0,1); 
	}*/

//$result = mysql_query("select *,if(poi='address',`add`,poi) as poiadd  from tripsheet_other_poi where `tsn`='".$_REQUEST['tsn']."'");
$obj = $_POST;
	//$i=1;
	$url_part = '&waypoints=';
	$url_img = '';
//while($obj=mysql_fetch_assoc($result)){
	for($i=1;$i<=5;$i++){
	$pdf->SetFont('Arial','B',9);
	if($obj['o_poi'.$i]!=''){
	$pdf->Cell(49,7,"Arrival POI/Address".$i,0);
	$pdf->SetFont('Arial','',9);
	
	if(strtolower($obj['o_poi'.$i])=='address'){
	$pdf->MultiCell(120,7,$obj['o_add'.$i],0);}
	else {
	$pdf->Cell(49,7,$obj['o_poi'.$i],0,1);}

	$url_part = $url_part.forurl($obj['o_poi'.$i],$obj['o_add'.$i],$obj['lati'.$i],$obj['longi'.$i]).'|';
    $url_img = $url_img.forurl($obj['o_poi'.$i],$obj['o_add'.$i],$obj['lati'.$i],$obj['longi'.$i]).'|';
    }}
//rtrim($url_part,'|');
	//$url_img = rtrim($url_img,'|');
	$url_part = rtrim(rtrim($url_part,'|'),'&waypoints=');
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(49,10,'Final Arrival POI:',0);
	$pdf->SetFont('Arial','',9);
	if(strtolower($row['arrival_poi'])=='address'){
		$pdf->MultiCell(120,10,$row['arrival_add'],0,1);
	}else{
		$pdf->MultiCell(120,10,$row['arrival_poi'],0,1);
	}
	//$pdf->Cell(49,10,$row['arrival_poi'],0,1); 
	/*$pdf->SetFont('Arial','B',9);
	$pdf->Cell(49,10,'Final Arrival Date/Time:',0);
	$pdf->SetFont('Arial','',9);
	if($row["arrival_time"]!='') {
		$pdf->Cell(49,10,date('m/d/Y h:i A',strtotime($row["arrival_time"])),0,1);}
	else {
		$pdf->Cell(49,10,'',0,1); 
	}*/

	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(49,10,'Print GPC Rep:',0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(49,10,$row['print_rep'],0);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(49,10,'Sign GPC Rep:',0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(49,10,$row['sign_rep'],0,1);

	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(18,10,'PRCN',0);
	$pdf->Cell(18,10,'CT',0);
	$pdf->Cell(18,10,'ACTV',0);
	$pdf->Cell(18,10,'EWO',0);
	$pdf->Cell(18,10,'PROJ',0);
	$pdf->Cell(18,10,'LOC',0);
	$pdf->Cell(18,10,'FERC',0);
	$pdf->Cell(18,10,'SUB',0);
	$pdf->Cell(18,10,'RRCN',0);
	$pdf->Cell(18,10,'AL',0);
	$pdf->Cell(18,10,'Total',0,1);

/*$qry = ("select * from trip_cost where trip_id = '".$row['id']."' and ( prcn !='' or ct !='' or actv !='' or ewo !='' or proj !='' or loc !='' or ferc !='' or sub !='' or rrcn !='' or al !='' or total !='')");
$result = mysql_query($qry);
while($cost=mysql_fetch_assoc($result)){*/
	$cost= $_POST;
	for($i=1;$i<=4;$i++){
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(18,10,$cost['prcn'.$i],0);
	$pdf->Cell(18,10,$cost['ct'.$i],0);
	$pdf->Cell(18,10,$cost['actv'.$i],0);
	$pdf->Cell(18,10,$cost['ewo'.$i],0);
	$pdf->Cell(18,10,$cost['proj'.$i],0);
	$pdf->Cell(18,10,$cost['loc'.$i],0);
	$pdf->Cell(18,10,$cost['ferc'.$i],0);
	$pdf->Cell(18,10,$cost['sub'.$i],0);
	$pdf->Cell(18,10,$cost['rrcn'.$i],0);
	$pdf->Cell(18,10,$cost['al'.$i],0);
	$pdf->Cell(18,10,$cost['total'.$i],0,1);
	$pdf->SetFont('Arial','',9);
}
	
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(20,10,'Approved: ',0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(130,10,$row['approved'],0);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(20,10,'Total Cost: ',0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(18,10,$row['total_cost'],0,1);

	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(190,10,'Trip Completed',0,1,'C');

	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(20,10,'Driver Signature: ',0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(130,10,$row['driver_sign'],0);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(20,10,'Date: ',0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(18,10,date('m/d/Y',strtotime($row['complete_date'])),0,1);
	$pdf->AddPage();

function forurl($poi,$add,$latitude,$longitude){
if (strtolower($poi) == "address" && $add!='')
		{
			$urlpart = $add;
		}else{
			$urlpart = $latitude.','.$longitude;
		}
return $urlpart;
}



//echo 'https://maps.googleapis.com/maps/api/staticmap?size=1100x396&key=AIzaSyB3ZjEflXhWK3O1Maaa6kj_w-LQmgOdNLk&path=weight:2|'.forurl($row['arrival_add'],$row['arrival_poi'],$row['alati'],$row['alongi']).'|'.$url_img.forurl($row['depart_poi'],$row['depart_add'],$row['dlati'],$row['dlongi']);

    $pdf->Image('https://maps.googleapis.com/maps/api/staticmap?size=1100x396&key=AIzaSyB3ZjEflXhWK3O1Maaa6kj_w-LQmgOdNLk&path=weight:2|'.forurl($row['arrival_add'],$row['arrival_poi'],$row['alati'],$row['alongi']).'|'.$url_img.forurl($row['depart_poi'],$row['depart_add'],$row['dlati'],$row['dlongi']),20,20,0,0,'PNG');

$pdf->SetY(130);
//echo 'https://maps.googleapis.com/maps/api/directions/json?&key=AIzaSyCLWeYaDJ385i-vxLhMjNJ51NTFCVuaGaM&origin='.forurl($row['arrival_poi'],$row['arrival_add'],$row['alati'],$row['alongi']).'&destination='.forurl($row['depart_poi'],$row['depart_add'],$row['dlati'],$row['dlongi']).$url_part;
$_REQUEST["url2"] = 'https://maps.googleapis.com/maps/api/directions/json?&key=AIzaSyCLWeYaDJ385i-vxLhMjNJ51NTFCVuaGaM&origin='.forurl($row['arrival_poi'],$row['arrival_add'],$row['alati'],$row['alongi']).'&destination='.forurl($row['depart_poi'],$row['depart_add'],$row['dlati'],$row['dlongi']).$url_part;
//echo $_REQUEST["url2"];
	$content = file_get_contents($_REQUEST["url2"]);
	$myArray = json_decode($content, true);

	foreach($myArray['routes'][0]['legs'] as $var){
				$count = 1 ;
			$pdf->cell(18,10,"Start : " .$var['start_address'],0,1);
				foreach ($var['steps'] as $key =>  $post)
				 {
					$pdf->MultiCell(190,10,strip_tags($post['html_instructions']),0,1);
					$pdf->Cell(18,10,$post['distance']['text'],0,1);
					$count++;
				 }
				    $pdf->Cell(18,10,"End : " .$var['end_address'],0,1); 
	}
 
 
$pdf->Output();

?>
