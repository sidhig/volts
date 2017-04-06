<?php

  session_start();
include_once('connect.php');

if( $_REQUEST["eqp_container_id"]!='' & $_REQUEST["get_status"]=='true' )
{
	$row = mysql_fetch_array(mysql_query("select max(timestamp),Description from event_data_last left join  sc_tbl on sc_tbl.code = event_data_last.eventcode where DeviceImei = '".$_REQUEST["eqp_container_id"]."'"));
	$status = mysql_fetch_array(mysql_query("select * from tbl_armed where imei = '".$_REQUEST["eqp_container_id"]."'"));
	?>
		
<tr><th>Last Door Status: <?=$row['Description']?></th><th>&nbsp;&nbsp;As Of: <? if(($row['max(timestamp)'])!=''){ echo date("m-d-Y h:i A",strtotime($row['max(timestamp)'])); } ?></th><th align="right">Security Status: </th><th align="left"><? if($status['isarmed']=='0'){echo "Disarmed"; }elseif($status['isarmed']=='1'){echo "Armed";}else{echo "Disarmed";}?></th></tr>
<tr><th>&nbsp;<input type="hidden" id="arm_cur_status" value="<?=$status['isarmed']?>" ><input type="hidden" id="tbl_armed_id" value="<?=$status['isarmedbytime']?>" ><? $phpArray = json_decode($status['arm_schedule'],true);
?></th></tr>
<tr><th><input type="radio" name="armed" value="manual" <? if($status['isarmedbytime']=='0'||$status['isarmedbytime']==''){ ?>checked<? } ?>> Manually <? if($status['isarmed']=='0'){echo "Arm"; }elseif($status['isarmed']=='1'){echo "Disarm";}else{echo "Arm";}?></th>
<th style='text-align: left;'><input type="radio" name="armed" value="auto" <? if($status['isarmedbytime']=='1'){ ?>checked<? } ?>  > Arm By Time:</th><th></th></tr>
<tr><th></th><th>Days</th><th >Arm </th><th> Disarm</th></tr>
<tr><th></th><th style='text-align: left;'><input type="checkbox" id="Monday" name="Monday" value="1" <? if($phpArray['schedule'][0]['work']==1){ echo "checked"; } ?>/>Monday </th>
<th><input type="time" id="mon_start" name="mon_start" value="<? if($phpArray['schedule'][0]['start']!=''){echo $phpArray['schedule'][0]['start'];}else{ echo '19:00'; } ?>" /> </th><th><input type="time" id="mon_end" name="mon_end" value="<? if($phpArray['schedule'][0]['end']!=''){echo $phpArray['schedule'][0]['end'];}else{ echo '06:00'; } ?>" /></th></tr>
<tr><th></th><th style='text-align: left;'><input type="checkbox" id="Tuesday" name="Tuesday" value="1" <? if($phpArray['schedule'][1]['work']==1){ echo "checked"; } ?>/>Tuesday </th>
<th><input type="time" id="tues_start" name="tues_start" value="<? if($phpArray['schedule'][1]['start']!=''){echo $phpArray['schedule'][1]['start'];}else{ echo '19:00'; } ?>" /></th><th><input type="time" id="tues_end" name="tues_end" value="<? if($phpArray['schedule'][1]['end']!=''){echo $phpArray['schedule'][1]['end'];}else{ echo '06:00'; } ?>" /></th></tr>
<tr><th></th><th style='text-align: left;'><input type="checkbox" id="Wednesday" name="Wednesday" value="1" <? if($phpArray['schedule'][2]['work']==1){ echo "checked"; } ?>/>Wednesday </th>
<th><input type="time" id="wed_start" name="wed_start" value="<? if($phpArray['schedule'][2]['start']!=''){echo $phpArray['schedule'][2]['start'];}else{ echo '19:00'; } ?>" /></th><th><input type="time" id="wed_end" name="wed_end" value="<? if($phpArray['schedule'][2]['end']!=''){echo $phpArray['schedule'][2]['end'];}else{ echo '06:00'; } ?>" /></th></tr>
<tr><th></th><th style='text-align: left;'><input type="checkbox" id="Thursday" name="Thursday" value="1" <? if($phpArray['schedule'][3]['work']==1){ echo "checked"; } ?>/>Thursday </th>
<th><input type="time" id="thur_start" name="thur_start" value="<? if($phpArray['schedule'][3]['start']!=''){echo $phpArray['schedule'][3]['start'];}else{ echo '19:00'; } ?>" /></th><th><input type="time" id="thur_end" name="thur_end" value="<? if($phpArray['schedule'][3]['end']!=''){echo $phpArray['schedule'][3]['end'];}else{ echo '06:00'; } ?>" /></th></tr>
<tr><th></th><th style='text-align: left;'><input type="checkbox" id="Friday" name="Friday"  value="1" <? if($phpArray['schedule'][4]['work']==1){ echo "checked"; } ?>/>Friday </th>
<th><input type="time" id="fri_start" name="fri_start" value="<? if($phpArray['schedule'][4]['start']!=''){echo $phpArray['schedule'][4]['start'];}else{ echo '19:00'; } ?>" /></th><th><input type="time" id="fri_end" name="fri_end" value="<? if($phpArray['schedule'][4]['end']!=''){echo $phpArray['schedule'][4]['end'];}else{ echo '06:00'; } ?>" /></th></tr>
<tr><th></th><th style='text-align: left;'><input type="checkbox" id="Saturday" name="Saturday" value="1" <? if($phpArray['schedule'][5]['work']==1){ echo "checked"; } ?>/>Saturday </th>
<th><input type="time" id="sat_start" name="sat_start" value="<? if($phpArray['schedule'][5]['start']!=''){echo $phpArray['schedule'][5]['start'];}else{ echo '00:00'; } ?>" /></th><th><input type="time" id="sat_end" name="sat_end" value="<? if($phpArray['schedule'][5]['end']!=''){echo $phpArray['schedule'][5]['end'];}else{ echo '23:59'; } ?>" /></th></tr>
<tr><th></th><th style='text-align: left;'><input type="checkbox"  id="Sunday" name="Sunday" value="1" <? if($phpArray['schedule'][6]['work']==1){ echo "checked"; } ?>/>Sunday </th>
<th><input type="time" id="sun_start" name="sun_start" value="<? if($phpArray['schedule'][6]['start']!=''){echo $phpArray['schedule'][6]['start'];}else{ echo '00:00'; } ?>" /></th><th><input type="time" id="sun_end" name="sun_end" value="<? if($phpArray['schedule'][6]['end']!=''){echo $phpArray['schedule'][6]['end'];}else{ echo '23:59'; } ?>" /></th></tr>
<tr><th>&nbsp;</th></tr>
<tr><th colspan="3"><center><strong>Send Alert To : </strong> <select id="send_dd">
<? $result = mysql_query("select * from eqp_sec_alert");
			 while($row = mysql_fetch_array($result))
			 {
			   echo "<OPTION VALUE=".$row["id"].">".$row["name"].'</option>';
			  }
			?></select></center></th></tr>
<tr><th>&nbsp;</th></tr>
<? if($_SESSION['LOGIN_role']=='admin_gpc' || $_SESSION['LOGIN_role']=='superadmin'){ ?>
<tr><th colspan="3"><center>

<input type="button" onclick="arm_dis_btn();" class="btn btn-warning" style="width:12vw; height:5vh; color:black;" value="<? if($status['isarmed']=='0'){echo "Arm Security"; }elseif($status['isarmed']=='1'){echo "Disarm Security";}else{echo "Arm Security";}?>" />

</center>
</th></tr>

	<? }
}else if($_REQUEST["eqp_container_id"]!='' & $_REQUEST["change_status"]=='true')
{
	if($_POST['arm_manually']=="auto"){ $isarmedbytime=1; }else if($_POST['arm_manually']=="manual"){ $isarmedbytime=0; }
	//if($_POST['arm_cur_status']=="auto"){ $isarmedbytime=0; }else if($_POST['arm_manually']=="manual"){ $isarmedbytime=1; }
	if($_POST['Monday']==""){ $_POST['Monday']=0; }
	if($_POST['Tuesday']==""){ $_POST['Tuesday']=0; }
	if($_POST['Wednesday']==""){ $_POST['Wednesday']=0; }
	if($_POST['Thursday']==""){ $_POST['Thursday']=0; }
	if($_POST['Friday']==""){ $_POST['Friday']=0; }
	if($_POST['Saturday']==""){ $_POST['Saturday']=0; }
	if($_POST['Sunday']==""){ $_POST['Sunday']=0; }
	$json = '{ "schedule" : [{"day":"Monday","work":'.$_POST['Monday'].',"start":"'.$_POST['mon_start'].'","end":"'.$_POST['mon_end'].'"},  
               {"day":"Tuesday","work":'.$_POST['Tuesday'].',"start":"'.$_POST['tues_start'].'","end":"'.$_POST['tues_end'].'"},
               {"day":"Wednesday","work":'.$_POST['Wednesday'].',"start":"'.$_POST['wed_start'].'","end":"'.$_POST['wed_end'].'"},
			   {"day":"Thursday","work":'.$_POST['Thursday'].',"start":"'.$_POST['thur_start'].'","end":"'.$_POST['thur_end'].'"},
			   {"day":"Friday","work":'.$_POST['Friday'].',"start":"'.$_POST['fri_start'].'","end":"'.$_POST['fri_end'].'"},
			   {"day":"Saturday","work":'.$_POST['Saturday'].',"start":"'.$_POST['sat_start'].'","end":"'.$_POST['sat_end'].'"},
			   {"day":"Sunday","work":'.$_POST['Sunday'].',"start":"'.$_POST['sun_start'].'","end":"'.$_POST['sun_end'].'"}]}';

	if($_REQUEST["arm_cur_status"]=='1'){$new_status='0'; $email_body =$_REQUEST["eqp_container_name"]." is disarmed"; }
	else if($_REQUEST["arm_cur_status"]=='0'){$new_status='1'; $email_body =$_REQUEST["eqp_container_name"]." is armed";; }
	else{ $new_status='1'; $email_body =$_REQUEST["eqp_container_name"]." is armed"; }
$result1 = mysql_query("insert into tbl_armed set imei ='".$_REQUEST["eqp_container_id"]."',isarmed ='".$new_status."', isarmedbytime = '".$isarmedbytime."', send_to='".$_REQUEST["send_dd"]."', arm_schedule = '".$json."' ON DUPLICATE KEY UPDATE isarmed ='".$new_status."', isarmedbytime = '".$isarmedbytime."', send_to='".$_REQUEST["send_dd"]."', arm_schedule = '".$json."'");

require_once "Mail.php";
require_once 'Mail/mime.php';

$body  = $email_body;
$subject = "";
$usermail = '6782098143@vtext.com';

error_reporting(0);

  $from = "NO_REPLY_VOLTS<noreply.volts@gmail.com>";
    
        $host = "ssl://smtp.gmail.com";
        $port = "465";
        $username = "noreply.volts@gmail.com";  //<> give errors
        $password = "saurabhlew";

        $headers = array ('From' => $from,
          'To' => $usermail,
          'Subject' => $subject);
        $smtp = @Mail::factory('smtp',
          array ('host' => $host,
            'port' => $port,
            'auth' => true,
            'username' => $username,
            'password' => $password));
    
  $mime = new Mail_mime($crlf);
  $mime->setTXTBody($body);
  $mime->setHTMLBody($body);
  //$str = $_REQUEST["create_for"]."/".$filename;
  $mime->addAttachment($str, 'text/plain');
  $body = $mime->get();
  $headers = $mime->headers($headers);

        $mail = $smtp->send($usermail, $headers, $body);
 
   if (@PEAR::isError($mail)) 
   {
          echo($mail->getMessage() );
      } 
   else
   {
  // echo $_REQUEST["filename"];
        // echo("Email successfully sent! to ".$_REQUEST["email"]);
      }

//print_r("insert into tbl_armed set imei ='".$_REQUEST["eqp_container_id"]."',isarmed ='".$new_status."', isarmedbytime = '".$isarmedbytime."', arm_schedule = '".$json."' ON DUPLICATE KEY UPDATE isarmed ='".$new_status."', isarmedbytime = '".$isarmedbytime."', arm_schedule = '".$json."'");
}
else if($_REQUEST["query"]!=''){
$result1 = mysql_query($_REQUEST["query"]);
?><tr><th style="text-align:center;">Name</th><th style="text-align:center;">Receive By</th><th style="text-align:center;">Send To</th><th>Edit/Delete</th></tr>
<? $result = mysql_query("select * from eqp_sec_alert order by id desc");
			 while($sec = mysql_fetch_array($result))
			 {
			 ?>
			 <tr align="center"><td class="sec_id" style="display:none;"><?=$sec["id"]?></td><td class="sec_name"><?=$sec["name"]?></td><td class="ed_rec_by"><?=$sec["rec_by"]?></td><td class="ed_send_to"><?=$sec["send_to"]?></td><th><a class="edit_sec_alert" ><img src ="image/edit.png"/></a> <a class="del_eqp_sec" ><img src ="image/deny.png"/></a></th></tr>
			<?  }  ?>
<?
}
 ?>			
<script>


$(".edit_sec_alert").click(function(){
	$("#new_sec_form").hide();
	$("#sec_new_btn").show();
	$("#edit_sec_form").show();
	var $row = $(this).closest("tr");
	$("#ed_sec_name").val($row.find(".sec_name").text());
	$("#ed_send_to").val($row.find(".ed_send_to").text());
	$("#sec_id").val($row.find(".sec_id").text());
	if($row.find(".ed_rec_by").text()=='Phone'){ $("#ed_sec_phone").prop('checked','checked'); }
	else if($row.find(".ed_rec_by").text()=='Email'){ $("#ed_sec_email").prop('checked','checked'); }
});

$(".del_eqp_sec").click(function(){
	var r = confirm("Are you want to delete this data?");
if (r != true) {
    return false;
} else{
		var $row = $(this).closest("tr");
		//alert($row.find(".sec_id").text());
		$.post( "get_container_status.php",{ query:"delete from eqp_sec_alert where id = '"+$row.find(".sec_id").text()+"'"  },function(data) {
			//alert(data);
			$("#new_sec_form").hide();
			$("#sec_manage_div").show();
			$("#sec_new_btn").show();
			$("#sec_alert_tbl").empty();
			$("#sec_alert_tbl").html(data);
		});
}
});
</script>