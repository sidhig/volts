<?
include_once('connect.php');
include_once ('for_msg.php');
  //error_reporting(0);
 // if(!isset($_SESSION['LOGIN_STATUS'])){
  //    header('location:login.php');
 // }
 //print_r($_POST);
 //echo "Please wait while saving Trip Sheet";
 //echo "veh no:".$_POST['veh_no'];

if(isset($_POST['trip_form']) && $_POST['trip_form'] == "new"){ 
			if(
			isset($_POST['time_sheet']) && $_POST['time_sheet'] != "" && 
			isset($_POST['req_date']) && $_POST['req_date'] != "" && 
			isset($_POST['del_date']) && $_POST['del_date'] != "" && 
			isset($_POST['contact_person']) && $_POST['contact_person'] != "" &&  
			isset($_POST['contact_no']) && $_POST['contact_no'] != "" && 
			isset($_POST['req_by']) && $_POST['req_by'] != "" && 
			isset($_POST['req_no']) && $_POST['req_no'] != "" && 
			isset($_POST['item_name']) && $_POST['item_name'] != "" &&
			isset($_POST['veh_no']) && $_POST['veh_no'] != "" && 
			isset($_POST['arrival_poi']) && $_POST['arrival_poi'] != "" && 
			isset($_POST['depart_poi']) && $_POST['depart_poi'] != "") {
			if ($_POST['arrival_poi'] != "Address")
			{
				$poi = explode(",",$_POST['arrival_poi']);
				$_POST['arrival_poi'] = $poi[0];
			}
			if ($_POST['depart_poi'] != "Address")
			{
				$poi = explode(",",$_POST['depart_poi']);
				$_POST['depart_poi'] = $poi[0];
			}
			if (!isset($_POST['auto_complete']))
			{
				$_POST['auto_complete'] = 0;
			}
			 $trip = "INSERT INTO 
				relocation SET 
				time_sheet = '".trim(mysql_real_escape_string($_POST['time_sheet']))."',
				`req_date` = '".trim(mysql_real_escape_string($_POST['req_date']))."',
				`del_date` = '".trim(mysql_real_escape_string($_POST['del_date']))."',
				contact_person = '".trim(mysql_real_escape_string($_POST['contact_person']))."',
				contact_no = '".trim(mysql_real_escape_string($_POST['contact_no']))."',
				req_by = '".trim(mysql_real_escape_string($_POST['req_by']))."',
				req_no = '".trim(mysql_real_escape_string($_POST['req_no']))."',
				item_name = '".trim(mysql_real_escape_string($_POST['item_name']))."',
				req_email = '".trim(mysql_real_escape_string($_POST['req_email']))."',
				notes = '".trim(mysql_real_escape_string($_POST['notes']))."',
				contract_driver = '".trim(mysql_real_escape_string($_POST['contract_driver']))."',
				driver_phone = '".trim(mysql_real_escape_string($_POST['driver_phone']))."',
				veh_no = '".trim(mysql_real_escape_string($_POST['veh_no']))."',
				equip_no1 = '".trim(mysql_real_escape_string($_POST['equip_no1']))."',
				equip_no2 = '".trim(mysql_real_escape_string($_POST['equip_no2']))."',
				equip_no3 = '".trim(mysql_real_escape_string($_POST['equip_no3']))."',
				bobtail_miles = '".trim(mysql_real_escape_string($_POST['bobtail_miles']))."',
				trail_miles = '".trim(mysql_real_escape_string($_POST['trail_miles']))."',
				disp_miles = '".trim(mysql_real_escape_string($_POST['disp_miles']))."',
				print_rep = '".trim(mysql_real_escape_string($_POST['print_rep']))."',
				sign_rep = '".trim(mysql_real_escape_string($_POST['sign_rep']))."',
				approved = '".trim(mysql_real_escape_string($_POST['approved']))."',
				total_cost = '".trim(mysql_real_escape_string($_POST['total_cost']))."',
				driver_sign = '".trim(mysql_real_escape_string($_POST['driver_sign']))."',				
				alati = '".trim(mysql_real_escape_string($_POST['alati']))."',
				alongi = '".trim(mysql_real_escape_string($_POST['alongi']))."',
				alati2 = '".trim(mysql_real_escape_string($_POST['alati2']))."',
				alongi2 = '".trim(mysql_real_escape_string($_POST['alongi2']))."',
				dlati = '".trim(mysql_real_escape_string($_POST['dlati']))."',
				dlongi = '".trim(mysql_real_escape_string($_POST['dlongi']))."',
				depart_poi = '".trim(mysql_real_escape_string($_POST['depart_poi']))."',
				depart_add = '".trim(mysql_real_escape_string($_POST['depart_add']))."',
				depart_time = '".trim(mysql_real_escape_string($_POST['depart_time']))."',
				arrival_poi = '".trim(mysql_real_escape_string($_POST['arrival_poi']))."',
				arrival_add = '".trim(mysql_real_escape_string($_POST['arrival_add']))."',
				arrival_time = '".trim(mysql_real_escape_string($_POST['arrival_time']))."',
				arrival_poi2 = '".trim(mysql_real_escape_string($_POST['arrival_poi2']))."',
				arrival_add2 = '".trim(mysql_real_escape_string($_POST['arrival_add2']))."',
				arrival_time2 = '".trim(mysql_real_escape_string($_POST['arrival_time2']))."',
				gotlocation = '".trim(mysql_real_escape_string($_POST['gotlocation']))."',
				dispatcher_id = '".trim(mysql_real_escape_string($_POST['dispatcher']))."',
				status = 'Open',
				complete_date = '".mysql_real_escape_string($_POST['complete_date'])."',
				auto_complete = '".trim(mysql_real_escape_string($_POST['auto_complete']))."',
				eqp_type = '".trim(mysql_real_escape_string($_POST['equip_type']))."'";
			$result = mysql_query($trip) or die(mysql_error());
			$id = mysql_insert_id();
					$count = 0;
			if(($_POST['o_poi1']!='') || ((strtolower($_POST['o_poi1'])=='address') && $_POST['o_add1']!='')){
				$count++;
				$other_poi = "INSERT INTO relocation_other_poi SET 
				tsn = '".mysql_real_escape_string($_POST['time_sheet'])."',
				poi = '".trim(mysql_real_escape_string($_POST['o_poi1']))."',
				`add` = '".trim(mysql_real_escape_string($_POST['o_add1']))."',
				is_count = '".$count."'";
			$result = mysql_query($other_poi) or die(mysql_error());
			}
			if(($_POST['o_poi2']!='') || ((strtolower($_POST['o_poi2'])=='address') && $_POST['o_add2']!='')){
				$count++;
				$other_poi = "INSERT INTO relocation_other_poi SET 
				tsn = '".mysql_real_escape_string($_POST['time_sheet'])."',
				poi = '".trim(mysql_real_escape_string($_POST['o_poi2']))."',
				`add` = '".trim(mysql_real_escape_string($_POST['o_add2']))."',
				is_count = '".$count."'";
			$result = mysql_query($other_poi) or die(mysql_error());
			}
			if(($_POST['o_poi3']!='') || ((strtolower($_POST['o_poi3'])=='address') && $_POST['o_add3']!='')){
				$count++;
				$other_poi = "INSERT INTO relocation_other_poi SET 
				tsn = '".mysql_real_escape_string($_POST['time_sheet'])."',
				poi = '".trim(mysql_real_escape_string($_POST['o_poi3']))."',
				`add` = '".trim(mysql_real_escape_string($_POST['o_add3']))."',
				is_count = '".$count."'";
			$result = mysql_query($other_poi) or die(mysql_error());
			}
			if(($_POST['o_poi4']!='') || ((strtolower($_POST['o_poi4'])=='address') && $_POST['o_add4']!='')){
				$count++;
				$other_poi = "INSERT INTO relocation_other_poi SET 
				tsn = '".mysql_real_escape_string($_POST['time_sheet'])."',
				poi = '".trim(mysql_real_escape_string($_POST['o_poi4']))."',
				`add` = '".trim(mysql_real_escape_string($_POST['o_add4']))."',
				is_count = '".$count."'";
			$result = mysql_query($other_poi) or die(mysql_error());
			}
			if(($_POST['o_poi5']!='') || ((strtolower($_POST['o_poi5'])=='address') && $_POST['o_add5']!='')){
				$count++;
				$other_poi = "INSERT INTO relocation_other_poi SET 
				tsn = '".mysql_real_escape_string($_POST['time_sheet'])."',
				poi = '".trim(mysql_real_escape_string($_POST['o_poi5']))."',
				`add` = '".trim(mysql_real_escape_string($_POST['o_add5']))."',
				is_count = '".$count."'";
			$result = mysql_query($other_poi) or die(mysql_error());
			}
			/*if(isset($_POST['total1']) && $_POST['total1'] != ""){ $rowinform=1; }
			if(isset($_POST['total2']) && $_POST['total2'] != ""){ $rowinform=2; }
			if(isset($_POST['total3']) && $_POST['total3'] != ""){ $rowinform=3; }
			if(isset($_POST['total4']) && $_POST['total4'] != ""){ $rowinform=4; }*/
			if($result){
				if($_POST['equip_type']=='Not Tracked'){
					$for_not_tracked = "update relocation SET `is_in` = '1',`is_out` = '1',`is_arrived` = '1',`is_in2` = '1' 
					where id = '".$id."' and time_sheet = '".mysql_real_escape_string($_POST['time_sheet'])."'";
					$result = mysql_query($for_not_tracked);
				}
			for($i=1;$i<=4;$i++)
			{
			//	if($_POST['total'.$i]!=''){
					$cost = "INSERT INTO 
						`relocation_cost` SET 
						prcn = '".trim(mysql_real_escape_string($_POST['prcn'.$i]))."',
						`ct` = '".trim(mysql_real_escape_string($_POST['ct'.$i]))."',
						`actv` = '".trim(mysql_real_escape_string($_POST['actv'.$i]))."',
						ewo = '".trim(mysql_real_escape_string($_POST['ewo'.$i]))."',
						proj = '".trim(mysql_real_escape_string($_POST['proj'.$i]))."',
						loc = '".trim(mysql_real_escape_string($_POST['loc'.$i]))."',
						ferc = '".trim(mysql_real_escape_string($_POST['ferc'.$i]))."',
						sub = '".trim(mysql_real_escape_string($_POST['sub'.$i]))."',
						rrcn = '".trim(mysql_real_escape_string($_POST['rrcn'.$i]))."',
						al = '".trim(mysql_real_escape_string($_POST['al'.$i]))."',
						total = '".trim(mysql_real_escape_string($_POST['total'.$i]))."',
						trip_id = '".$id."'";
						$result = mysql_query($cost) or die(mysql_error());
			//	}
			}	 
			createmsg($_POST['time_sheet'],'relocation');
			if($_POST['equip_type']=='Mobile Substation' || $_POST['equip_type']=='Mobile Switch'){
					if (strtolower($_POST['arrival_poi']) == "address")
					{
						$_POST['arrival_poi'] = $_POST['arrival_add'];
					}
					if (strtolower($_POST['depart_poi']) == "address")
					{
						$_POST['depart_poi'] = $_POST['depart_add'];
					}
				echo $msg = "A new Relocation Sheet has been added for ".$_POST['equip_type']." from ".$_POST['depart_poi']." to ".$_POST['arrival_poi'].".";
				$user = mysql_fetch_array(mysql_query("select * from setting where username = 'mwarren'"));
				mailwithsub($msg,'New Relocation Sheet Created',$user['trip_sheet_note'].',prakhar.mona01@gmail.com,dimondsaurabh@gmail.com');
			}
			unset($_POST);
					}		
					}
					else {
					$err = "Please Fill All Fields.";
					}
 }
 elseif(isset($_POST['trip_form']) && $_POST['trip_form'] == "edit"){ 
			if (!isset($_POST['auto_complete']))
			{
				$_POST['auto_complete'] = 0;
			}
		$trip = "update 
				relocation SET 
				`req_date` = '".trim(mysql_real_escape_string($_POST['req_date']))."',
				`del_date` = '".trim(mysql_real_escape_string($_POST['del_date']))."',
				contact_person = '".trim(mysql_real_escape_string($_POST['contact_person']))."',
				contact_no = '".trim(mysql_real_escape_string($_POST['contact_no']))."',
				req_by = '".trim(mysql_real_escape_string($_POST['req_by']))."',
				req_no = '".trim(mysql_real_escape_string($_POST['req_no']))."',
				item_name = '".trim(mysql_real_escape_string($_POST['item_name']))."',
				req_email = '".trim(mysql_real_escape_string($_POST['req_email']))."',
				notes = '".trim(mysql_real_escape_string($_POST['notes']))."',
				contract_driver = '".trim(mysql_real_escape_string($_POST['contract_driver']))."',
				driver_phone = '".trim(mysql_real_escape_string($_POST['driver_phone']))."',
				veh_no = '".trim(mysql_real_escape_string($_POST['veh_no']))."',
				equip_no1 = '".trim(mysql_real_escape_string($_POST['equip_no1']))."',
				equip_no2 = '".trim(mysql_real_escape_string($_POST['equip_no2']))."',
				equip_no3 = '".trim(mysql_real_escape_string($_POST['equip_no3']))."',
				bobtail_miles = '".trim(mysql_real_escape_string($_POST['bobtail_miles']))."',
				trail_miles = '".trim(mysql_real_escape_string($_POST['trail_miles']))."',
				disp_miles = '".trim(mysql_real_escape_string($_POST['disp_miles']))."',
				print_rep = '".trim(mysql_real_escape_string($_POST['print_rep']))."',
				sign_rep = '".trim(mysql_real_escape_string($_POST['sign_rep']))."',
				approved = '".trim(mysql_real_escape_string($_POST['approved']))."',
				total_cost = '".trim(mysql_real_escape_string($_POST['total_cost']))."',
				driver_sign = '".trim(mysql_real_escape_string($_POST['driver_sign']))."',				
				alati = '".trim(mysql_real_escape_string($_POST['alati']))."',
				alongi = '".trim(mysql_real_escape_string($_POST['alongi']))."',
				alati2 = '".trim(mysql_real_escape_string($_POST['alati2']))."',
				alongi2 = '".trim(mysql_real_escape_string($_POST['alongi2']))."',
				dlati = '".trim(mysql_real_escape_string($_POST['dlati']))."',
				dlongi = '".trim(mysql_real_escape_string($_POST['dlongi']))."',
				depart_poi = '".trim(mysql_real_escape_string($_POST['depart_poi']))."',
				depart_add = '".trim(mysql_real_escape_string($_POST['depart_add']))."',
				depart_time = '".trim(mysql_real_escape_string($_POST['depart_time']))."',
				arrival_poi = '".trim(mysql_real_escape_string($_POST['arrival_poi']))."',
				arrival_add = '".trim(mysql_real_escape_string($_POST['arrival_add']))."',
				arrival_time = '".trim(mysql_real_escape_string($_POST['arrival_time']))."',
				arrival_poi2 = '".trim(mysql_real_escape_string($_POST['arrival_poi2']))."',
				arrival_add2 = '".trim(mysql_real_escape_string($_POST['arrival_add2']))."',
				arrival_time2 = '".trim(mysql_real_escape_string($_POST['arrival_time2']))."',
				gotlocation = '".trim(mysql_real_escape_string($_POST['gotlocation']))."',
				dispatcher_id = '".trim(mysql_real_escape_string($_POST['dispatcher']))."',
				complete_date = '".mysql_real_escape_string($_POST['complete_date'])."',
				auto_complete = '".trim(mysql_real_escape_string($_POST['auto_complete']))."',
				eqp_type = '".trim(mysql_real_escape_string($_POST['equip_type']))."'
			where
				time_sheet = '".$_POST['time_sheet']."'";
			$result = mysql_query($trip) or die(mysql_error());
			$count = 0;
			$del_other_poi = mysql_query("DELETE from relocation_other_poi WHERE tsn = '".mysql_real_escape_string($_POST['time_sheet'])."' and (is_in = '0' or is_out = '0')") or die(mysql_error());
			if(($_POST['o_poi1']!='') || ((strtolower($_POST['o_poi1'])=='address') && $_POST['o_add1']!='')){
				$count++;
				$other_poi = "INSERT INTO relocation_other_poi SET 
				tsn = '".mysql_real_escape_string($_POST['time_sheet'])."',
				poi = '".trim(mysql_real_escape_string($_POST['o_poi1']))."',
				`add` = '".trim(mysql_real_escape_string($_POST['o_add1']))."',
				`lati_o` = '".mysql_real_escape_string($_POST['lati1'])."',
				`longi_o` = '".mysql_real_escape_string($_POST['longi1'])."',
				is_count = '".$count."'";
			$result = mysql_query($other_poi) or die(mysql_error());
			}
			if(($_POST['o_poi2']!='') || ((strtolower($_POST['o_poi2'])=='address') && $_POST['o_add2']!='')){
				$count++;
				$other_poi = "INSERT INTO relocation_other_poi SET 
				tsn = '".mysql_real_escape_string($_POST['time_sheet'])."',
				poi = '".trim(mysql_real_escape_string($_POST['o_poi2']))."',
				`add` = '".trim(mysql_real_escape_string($_POST['o_add2']))."',
				`lati_o` = '".mysql_real_escape_string($_POST['lati2'])."',
				`longi_o` = '".mysql_real_escape_string($_POST['longi2'])."',
				is_count = '".$count."'";
			$result = mysql_query($other_poi) or die(mysql_error());
			}
			if(($_POST['o_poi3']!='') || ((strtolower($_POST['o_poi3'])=='address') && $_POST['o_add3']!='')){
				$count++;
				$other_poi = "INSERT INTO relocation_other_poi SET 
				tsn = '".mysql_real_escape_string($_POST['time_sheet'])."',
				poi = '".trim(mysql_real_escape_string($_POST['o_poi3']))."',
				`add` = '".trim(mysql_real_escape_string($_POST['o_add3']))."',
				`lati_o` = '".mysql_real_escape_string($_POST['lati3'])."',
				`longi_o` = '".mysql_real_escape_string($_POST['longi3'])."',
				is_count = '".$count."'";
			$result = mysql_query($other_poi) or die(mysql_error());
			}
			if(($_POST['o_poi4']!='') || ((strtolower($_POST['o_poi4'])=='address') && $_POST['o_add4']!='')){
				$count++;
				$other_poi = "INSERT INTO relocation_other_poi SET 
				tsn = '".mysql_real_escape_string($_POST['time_sheet'])."',
				poi = '".trim(mysql_real_escape_string($_POST['o_poi4']))."',
				`add` = '".trim(mysql_real_escape_string($_POST['o_add4']))."',
				`lati_o` = '".mysql_real_escape_string($_POST['lati4'])."',
				`longi_o` = '".mysql_real_escape_string($_POST['longi4'])."',
				is_count = '".$count."'";
			$result = mysql_query($other_poi) or die(mysql_error());
			}
			if(($_POST['o_poi5']!='') || ((strtolower($_POST['o_poi5'])=='address') && $_POST['o_add5']!='')){
				$count++;
				$other_poi = "INSERT INTO relocation_other_poi SET 
				tsn = '".mysql_real_escape_string($_POST['time_sheet'])."',
				poi = '".trim(mysql_real_escape_string($_POST['o_poi5']))."',
				`add` = '".trim(mysql_real_escape_string($_POST['o_add5']))."',
				`lati_o` = '".mysql_real_escape_string($_POST['lati5'])."',
				`longi_o` = '".mysql_real_escape_string($_POST['longi5'])."',
				is_count = '".$count."'";
			$result = mysql_query($other_poi) or die(mysql_error());
			}
			$updated_row = mysql_fetch_array(mysql_query("select id from relocation where time_sheet = '".$_POST['time_sheet']."'"));
			$id = $updated_row['id'];
			$costqry = mysql_query("select id from `relocation_cost` where trip_id = '".$id."'");
			
			if($result){
			for($i=1;$i<=4;$i++)
			{
			$updated_row = mysql_fetch_array($costqry);
			$cost = "update `relocation_cost` SET 
				prcn = '".trim(mysql_real_escape_string($_POST['prcn'.$i]))."',
				`ct` = '".trim(mysql_real_escape_string($_POST['ct'.$i]))."',
				`actv` = '".trim(mysql_real_escape_string($_POST['actv'.$i]))."',
				ewo = '".trim(mysql_real_escape_string($_POST['ewo'.$i]))."',
				proj = '".trim(mysql_real_escape_string($_POST['proj'.$i]))."',
				loc = '".trim(mysql_real_escape_string($_POST['loc'.$i]))."',
				ferc = '".trim(mysql_real_escape_string($_POST['ferc'.$i]))."',
				sub = '".trim(mysql_real_escape_string($_POST['sub'.$i]))."',
				rrcn = '".trim(mysql_real_escape_string($_POST['rrcn'.$i]))."',
				al = '".trim(mysql_real_escape_string($_POST['al'.$i]))."',
				total = '".trim(mysql_real_escape_string($_POST['total'.$i]))."'
				where
				trip_id = '".$id."' and
				id = '".$updated_row['id']."'";
				$result = mysql_query($cost) or die(mysql_error());
			}	 
			createmsg($_POST['time_sheet'],'relocation');
			if($_POST['equip_type']=='Mobile Substation' || $_POST['equip_type']=='Mobile Switch'){
				if (strtolower($_POST['arrival_poi']) == "address")
					{
						$_POST['arrival_poi'] = $_POST['arrival_add'];
					}
					if (strtolower($_POST['depart_poi']) == "address")
					{
						$_POST['depart_poi'] = $_POST['depart_add'];
					}
				$msg = "Relocation Sheet has been Edited for ".$_POST['equip_type']." from ".$_POST['depart_poi']." to ".$_POST['arrival_poi'].".";
				$user = mysql_fetch_array(mysql_query("select * from setting where username = 'mwarren'"));
				mailwithsub($msg,'New Trip Sheet Created',$user['trip_sheet_note'].',prakhar.mona01@gmail.com,dimondsaurabh@gmail.com');
			}

 }
 }	else if(isset($_POST['trip_form']) && $_POST['trip_form'] == "Completed"){ 
	 $trip = "update relocation SET `status` = 'Completed',`is_in` = '1',`is_out` = '1',`is_arrived` = '1',`is_in2` = '1' where time_sheet = '".$_POST['time_sheet']."'";
	 $result = mysql_query($trip) or die(mysql_error());
	 //$result = mysql_query("update `eqp_schedule` SET `status` = 'Completed' where tsn = '".$_POST['time_sheet']."'");
 }	else if(isset($_POST['trip_form']) && $_POST['trip_form'] == "Cancel"){ 
	 $trip = "update relocation SET `status` = 'Cancel', `reason_cancel` = '".$_POST['reason_cancel']."',`is_in` = '1',`is_out` = '1',`is_arrived` = '1',`is_in2` = '1' where time_sheet = '".$_POST['time_sheet']."'";
	 $result = mysql_query($trip) or die(mysql_error());
 }				 
?>
