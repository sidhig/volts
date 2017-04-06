  <? include_once('connect.php'); 
  session_start(); ?>
<? 
 		
function breakspace($a){
	$a = str_replace('  ',' ',$a);
	$a = str_replace('  ',' ',$a);
	$a = trim($a);
	$poi = explode(" ",$a); 
	$val='';
	$val1='';
	foreach($poi as $val){ $val1 =$val1.$val."<br>"; }
	return $val1;
}



$trip_qry = "select relocation.*, devicedetails.DeviceName,devicedetails.DeviceType,otherPOI.* from relocation left join devicedetails on relocation.veh_no = devicedetails.DeviceIMEI 
left join (

SELECT t1. tsn,  

       COALESCE((Select if(poi='address',`add`,poi)  from relocation_other_poi where id = MIN(t1.id)),'') as poi1 ,
	COALESCE((Select arrival_time  from relocation_other_poi where id = MIN(t1.id)),'') as at1,
	COALESCE((Select depart_time  from relocation_other_poi where id = MIN(t1.id)),'') as dt1,
	COALESCE((Select lati_o  from relocation_other_poi where id = MIN(t1.id)),'') as lati1,
	COALESCE((Select longi_o  from relocation_other_poi where id = MIN(t1.id)),'') as longi1,

       COALESCE((Select if(poi='address',`add`,poi) from relocation_other_poi where id = MIN(t2.id)) ,'') as poi2,
	COALESCE((Select arrival_time from relocation_other_poi where id = MIN(t2.id)) ,'') as at2,
	COALESCE((Select depart_time from relocation_other_poi where id = MIN(t2.id)) ,'') as dt2,
	COALESCE((Select lati_o  from relocation_other_poi where id = MIN(t2.id)),'') as lati2,
	COALESCE((Select longi_o  from relocation_other_poi where id = MIN(t2.id)),'') as longi2,

       COALESCE( (Select if(poi='address',`add`,poi)  from relocation_other_poi where id = MIN(t3.id)),'') as poi3,
	COALESCE((Select arrival_time from relocation_other_poi where id = MIN(t3.id)) ,'') as at3,
	COALESCE((Select depart_time from relocation_other_poi where id = MIN(t3.id)) ,'') as dt3,
	COALESCE((Select lati_o  from relocation_other_poi where id = MIN(t3.id)),'') as lati3,
	COALESCE((Select longi_o  from relocation_other_poi where id = MIN(t3.id)),'') as longi3,

        COALESCE((Select if(poi='address',`add`,poi)  from relocation_other_poi where id = MIN(t4.id) ),'') as poi4,
	COALESCE((Select arrival_time from relocation_other_poi where id = MIN(t4.id)) ,'') as at4,
	COALESCE((Select depart_time from relocation_other_poi where id = MIN(t4.id)) ,'') as dt4,
	COALESCE((Select lati_o  from relocation_other_poi where id = MIN(t4.id)),'') as lati4,
	COALESCE((Select longi_o  from relocation_other_poi where id = MIN(t4.id)),'') as longi4

FROM    relocation_other_poi t1
        LEFT JOIN relocation_other_poi T2 
            ON t1.tsn = t2.tsn
            AND t2.id > t1.id
        LEFT JOIN relocation_other_poi T3 
            ON t2.tsn= t3.tsn
            AND t3.id > t2.id and t3.id is not null
        LEFT JOIN relocation_other_poi T4 
            ON t3.tsn= t4.tsn
            AND t4.id > t3.id
GROUP BY t1.tsn 
) as otherPOI
on relocation.time_sheet = otherPOI.tsn where ((relocation.status <> 'Inactive' and relocation.status <> 'Completed' and relocation.status <> 'Cancel') or req_date > date(now() - interval 15 day)) and devicedetails.DeviceType in (SELECT eq_name from tbl_eqptype where if('".$_SESSION['ROLE_eqp']."'='0',1,id in (".$_SESSION['ROLE_eqp'].")))  order by id desc";
		$result = mysql_query($trip_qry);
		$ldate = '';
 while($disp = mysql_fetch_array($result)){  ?>
			 <? if($ldate != substr($disp['time_sheet'],0,8) and $ldate !=''){ ?>
				<tr><td colspan="15" style="background: rgb(218, 225, 233); height:8px;"> </td></tr>
			<? } ?>
			<? if($disp['status']=='Pending'){ $bgcolor='yellow';}
				else if($disp['status']=='Open'){ $bgcolor='lightblue';}
				else if($disp['status']=='EnRoute'){ $bgcolor='lightgreen';}
				else if($disp['status']=='Arrived'){ $bgcolor='#ffa1ae';}
				else if($disp['status']=='Cancel'){ $bgcolor='lightgrey';}
				else if($disp['status']=='Completed'){ $bgcolor='#ffa1ae';}
			?>
 		<tr align="center">
		<td><input type='checkbox' <?if($disp['status']=='Completed' || $disp['status']=='Cancel'){ ?> disabled checked <? } else { ?> id='check_<?=$disp['time_sheet']?>' class="chk_rel" onchange="selected_relocation_list();" value="<?=$disp['time_sheet']?>" <? } ?> />
		</td>
		<td class="d_tsn"><form method="post" action="trip.php" id="form<?=$disp['time_sheet']?>"><input type="hidden" name="time_sheet" value="<?=$disp['time_sheet']?>" />
		<? if($_SESSION['ROLE_can_edit']){ ?>
			<a onclick="edit_rl('<?=$disp['time_sheet']?>');" style="cursor:pointer;" ><?=$disp['time_sheet']?></a>
		<? } else { ?>
			<strong><?=$disp['time_sheet']?></strong>
		<? } ?>
		</form></td>
		<td style="background-color:<?=$bgcolor?>;"><?=$disp['status']?></td>
		
		<th style="background-color:<? if($disp['is_out']=='1'){ ?>#ffa1ae<? } elseif($disp['is_arrived']=='1'){ ?>lightgreen<? } ?>;text-align: center;" >
			<a target="_blank" href="http://maps.google.com/maps?q=<?=$disp['dlati'].",".$disp['dlongi']?>" >
			<? if(strtolower($disp['depart_poi'])=='address'){ echo breakspace($disp['depart_add']); } else { echo breakspace($disp['depart_poi']); }?></a>
				<? if($disp['depart_time']!=''){ echo "<br><span style='font-size: 75%;'>D:".date_format(date_create($disp['depart_time']),"m-d-y h:iA")."</span>"; } ?>
			</th>
		
		<th style="background-color:<? if($disp['dt1']!=''){ ?>#ffa1ae<? } elseif($disp['at1']!=''){ ?>lightgreen<? } ?>;text-align: center;" >
				<a target="_blank" href="http://maps.google.com/maps?q=<?=$disp['lati1'].",".$disp['longi1']?>" ><?=breakspace($disp['poi1'])?></a>
			<? if($disp['at1']!=''){ 
				//date_add($date, date_interval_create_from_date_string('2 hours'))
			echo "<br><span style='font-size: 75%;'>A:".date_format(date_add(date_create($disp['at1']), date_interval_create_from_date_string('2 hours')),"m-d-y h:iA")."</span>"; } ?>
			<? if($disp['dt1']!=''){ echo "<br><span style='font-size: 75%;'>D:".date_format(date_add(date_create($disp['dt1']), date_interval_create_from_date_string('2 hours')),"m-d-y h:iA")."</span>"; } ?>
		</th>
		
		<th style="background-color:<? if($disp['dt2']!=''){ ?>#ffa1ae<? } elseif($disp['at2']!=''){ ?>lightgreen<? } ?>;text-align: center;" >
				<a target="_blank" href="http://maps.google.com/maps?q=<?=$disp['lati2'].",".$disp['longi2']?>" ><?=breakspace($disp['poi2'])?></a>
			<? if($disp['at2']!=''){ echo "<br><span style='font-size: 75%;'>A:".date_format(date_add(date_create($disp['at2']), date_interval_create_from_date_string('2 hours')),"m-d-y h:iA")."</span>"; } ?>
			<? if($disp['dt2']!=''){ echo "<br><span style='font-size: 75%;'>D:".date_format(date_add(date_create($disp['dt2']), date_interval_create_from_date_string('2 hours')),"m-d-y h:iA")."</span>"; } ?>
		</th>

		<th style="background-color:<? if($disp['dt3']!=''){ ?>#ffa1ae<? } elseif($disp['at3']!=''){ ?>lightgreen<? } ?>;text-align: center;" >
				<a target="_blank" href="http://maps.google.com/maps?q=<?=$disp['lati3'].",".$disp['longi3']?>" ><?=breakspace($disp['poi3'])?></a>
			<? if($disp['at3']!=''){ echo "<br><span style='font-size: 75%;'>A:".date_format(date_add(date_create($disp['at3']), date_interval_create_from_date_string('2 hours')),"m-d-y h:iA")."</span>"; } ?>
			<? if($disp['dt3']!=''){ echo "<br><span style='font-size: 75%;'>D:".date_format(date_add(date_create($disp['dt3']), date_interval_create_from_date_string('2 hours')),"m-d-y h:iA")."</span>"; } ?>
		</th>

		<th style="background-color:<? if($disp['is_in2']=='1'){ ?>#ffa1ae<? } elseif($disp['is_in']=='1'){ ?>lightgreen<? } ?>;text-align: center;"  >
			<a target="_blank" href="http://maps.google.com/maps?q=<?=$disp['alati'].",".$disp['alongi']?>" >
			<? if(strtolower($disp['arrival_poi'])=='address'){ echo breakspace($disp['arrival_add']); } else { echo breakspace($disp['arrival_poi']); }?></a>
				<? if($disp['arrival_time']!=''){ echo "<br><span style='font-size: 75%;'>A:".date_format(date_create($disp['arrival_time']),"m-d-y h:iA")."</span>"; } ?>
			</th>
		<td class="d_rdate"><?=date('m-d-y',strtotime($disp['req_date']))?></td>
		<td><?=date('m-d-y',strtotime($disp['del_date']))?></td>
		<td class="d_cp"><?=$disp['contact_person']?></td>
		<td class="d_cd"><?=str_replace('-','',$disp['contract_driver'])?></td>
		<td><?=$disp['driver_phone']?></td>
		<td class="d_iname"><?=$disp['item_name']?></td>	
		<td class="d_dname"><!--<a onclick="zoom_equippoi2('<?=$disp['veh_no']?>','4011','<? if(strtolower($disp['depart_poi'])=='address'){echo $disp['depart_add']; } else { echo $disp['depart_poi']; }?>','<? echo $disp['poi1'];  ?>','<? if(strtolower($disp['arrival_poi'])=='address'){echo $disp['arrival_poi']; } else { echo $disp['arrival_add']; }?>');" style="cursor:pointer;"><?=$disp['DeviceName']?></a>-->
		<a onclick="gethistory('<?=$disp['veh_no']?>','<? if($disp['depart_time']!=''){ echo $disp['depart_time']; } ?>','<? if($disp['arrival_time']!=''){ echo $disp['arrival_time']; } ?>',<?=$disp['time_sheet']?>,'rl',<?=$disp['DeviceName']?>);" style="cursor:pointer;"><?=$disp['DeviceName']?></a>
		
		</td><td class="" style="display:none;"><?=$disp['DeviceType']?></td>
<? //$disp['depart_time']='';date_format(date_create($disp['arrival_time']),"m-d-y h:i:s").date_format(date_create($disp['depart_time']),"m-d-y h:i:s") ?>
		<? //$ldate = substr($disp['time_sheet'],0,8); ?>	
		</tr>
		<? } ?>