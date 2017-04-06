<?
include_once('connect.php');


	$qry = $conn->query("select section from tbl_combination where company in (".$_POST['comp_id'].") and what='1'");
	$sec_str = '';
		while($sec_res = $qry->fetch_object()){
			
			$sec_str.= $sec_res->section.',';
		}
		$sec = implode(',',array_unique(explode(',',rtrim($sec_str,','))));
	if($_POST['for'] != 'company'){
		$sec = $_POST['sec_id'];
	}	
	if($sec != ''){
		$qry_bu = $conn->query("select business_unit from tbl_combination where company in (".$_POST['comp_id'].") and section in (".$sec.") and what='2'");

		$bu_str = '';
		while($bu_res = $qry_bu->fetch_object()){
			
			$bu_str.= $bu_res->business_unit.',';
		}
		$bu = implode(',',array_unique(explode(',',rtrim($bu_str,','))));
		if($_POST['for'] == 'bu'){
			$bu = $_POST['bu_id'];
		}
		if($bu != ''){
			$qry_loc = $conn->query("select location from tbl_combination where company in (".$_POST['comp_id'].") and section in (".$sec.") and business_unit in (".$bu.") and what='3'");
			$loc_str = '';
			while($loc_res = $qry_loc->fetch_object()){
				
				$loc_str.= $loc_res->location.',';
			}
			$loc = implode(',',array_unique(explode(',',rtrim($loc_str,','))));
		}
		if($_POST['for'] == 'location'){
		$loc = $_POST['loc_id'];
		}

		if($loc != ''){
			$qry_wrkgrp = $conn->query("select workgroup from tbl_combination where company in (".$_POST['comp_id'].") and section in (".$sec.") and business_unit in (".$bu.") and location in (".$loc.") and what='4'");
			$wrkgrp_str = '';
			while($wrkgrp_res = $qry_wrkgrp->fetch_object()){
				
				$wrkgrp_str.= $wrkgrp_res->workgroup.',';
			}
			$wrkgrp = implode(',',array_unique(explode(',',rtrim($wrkgrp_str,','))));
		}
	}
	?>
	<?if($_POST['for'] != 'section' && $_POST['for'] != 'bu' && $_POST['for'] != 'location'){?>
	<script>
		$('#primary option').each(function(index, option) {
			$(option).remove();
		});
		$('#primary').multiselect('rebuild');
	</script>
	<?}?>
	<?if($_POST['for'] != 'bu'  && $_POST['for'] != 'location'){?>
	<script>
		 $('#group option').each(function(index, option) {
			$(option).remove();
		});
		$('#group').multiselect('rebuild');
	</script>
	<?}?>
	<? if($_POST['for'] != 'location'){?>
	<script>
		$('#dept option').each(function(index, option) {
			$(option).remove();
		});
		$('#dept').multiselect('rebuild');
	</script>
	<?}?>
	<script>
		$('#workgroup option').each(function(index, option) {
			$(option).remove();
		});
		$('#workgroup').multiselect('rebuild'); 
	</script>

	<?
	if($sec != ''){
		if($_POST['for'] != 'section' && $_POST['for'] != 'bu' && $_POST['for'] != 'location'){
			$q = $conn->query("select * from role_primary where id in (".$sec.") order by name asc");
			while($res = $q->fetch_object()){?>
				<script>
					$('#primary').append('<option value=<?=$res->id?> selected><?=$res->name?></option>');
				</script>
			<?}
		}
		if($_POST['for'] != 'bu' && $_POST['for'] != 'location' && $bu !=''){
		$q = $conn->query("select * from role_group where id in (".$bu.") order by name asc");
		while($res = $q->fetch_object()){?>
			<script>
				$('#group').append('<option value=<?=$res->id?> selected><?=$res->name?></option>');
			</script>
		<?}
		}if($_POST['for'] != 'location' && $loc !=''){
			echo "select * from role_dept where id in (".$loc.") order by name asc";
		$q = $conn->query("select * from role_dept where id in (".$loc.") order by name asc");
		while($res = $q->fetch_object()){?>
			<script>
				$('#dept').append('<option value=<?=$res->id?> selected><?=$res->name?></option>');
			</script>
		<?}
		}
		if($wrkgrp !=''){
			$q = $conn->query("select * from tbl_workgroup where id in (".$wrkgrp.") order by name asc");
			while($res = $q->fetch_object()){?>
				<script>
					$('#workgroup').append("<option value=<?=$res->id?> selected><?=$res->name?></option>");
				</script>
			<?}
		}
	}
	?>
<?if($_POST['for'] != 'section' && $_POST['for'] != 'bu' && $_POST['for'] != 'location'){?>
	<script>
		$('#primary').multiselect('rebuild');
	</script>
<?}
if($_POST['for'] != 'bu' && $_POST['for'] != 'location'){
?>
	<script>
		$('#group').multiselect('rebuild');
	</script>
<?}if($_POST['for'] != 'location'){?>
	<script>
		$('#dept').multiselect('rebuild');
	</script>
<?}?>
	<script>
		$('#workgroup').multiselect('rebuild');
	</script>