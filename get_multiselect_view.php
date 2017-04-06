<?include_once("connect.php"); 
//print_r($_POST);die();
?>

  <script>

  $(document).ready(function() {

      $('#multi_sec,#multi_bu,#multi_loc,#multi_wrkgrp').multiselect({
        includeSelectAllOption: true,
        selectAllText: 'All',
         numberDisplayed: 1
      });
});
  </script>
  <!-- <center> -->
  <?if($_POST['for'] == 'comp'){?>
  
	  <? if($_POST['status'] == 'edit'){?>
			<table  class= "table" style="width: 28vw;border:1px solid black;border-collapse: initial;font-size: small;margin-top: 2vw;">
			<tr>
			<td class="set_td"><strong>Company : </strong></td>
			<td style="text-align: left;">
  				<select id="single_comp" class='form-control' size="1" >
		     				<option value="0" disabled selected>Select</option>

		                  <?  
		                      $sql = $conn->query("SELECT * from role_opco order by name asc");
		                      while($obj = $sql->fetch_object()){
		                        
		                  ?>
		                      <option value="<?=$obj->id?>" <?if($_POST['r_c_val'] == $obj->id){ echo "selected";}?>><?=$obj->name?></option>
		                  <?   } 
		                  ?>
		                </select>
		               
		    </td>
		    </tr>
		    <tr>
		    <td class="set_td"><strong>Name : </strong></td><td><input type='text' class='form-control' id='edit_comp_name' value=''></td>
		    </tr>
		    </table>
			<input type='button' id='update_comp_name' value='Update'>
	  <?}else{?>
	  <table class= "table" style="width: 28vw;border:1px solid black;border-collapse: initial;font-size: small;margin-top: 2vw;">
		<tr>
			<td class="set_td"><strong>New Company : </strong></td>
			<td><input type='text' class='form-control' id='new_comp' placeholder="Enter New Company " value=''></td>
		</tr>
	  </table>
	  <input type='button' id='add_comp_name' value='Add New'>
	  <?}?>
	   <script>
	   					$(document).ready(function(){
	   							var text = $('#single_comp option:selected').text();
						     	$('#edit_comp_name').val(text);
	   					});

						     $('#single_comp').change(function(){
						     	var text = $('#single_comp option:selected').text();
						     	$('#edit_comp_name').val(text);
						     });
							 
							 $('#add_comp_name').click(function(){ 
								var new_comp = $('#new_comp').val().trim();//alert(new_comp);
								if(new_comp == ''){
									alert("Please enter company name");
								}else{
									$.post('combination_qry.php',{for_what:'comp',action:'add',new_name:new_comp,what:'1'},function(data){
										alert(data);
										location.reload();
									});
								}
							});
							

							 $('#update_comp_name').click(function(){
								var exist_comp = $('#edit_comp_name').val().trim();
								var exist_id = $('#single_comp').val();
								if(exist_comp == ''){
									alert("Please enter company name");
								}else{
									$.post('combination_qry.php',{for_what:'comp',action:'edit',exist_name:exist_comp,exist_id:exist_id,what:'1'},function(data){
										alert(data);
										location.reload();
									});
								}
							});
						 </script>
 <?}else if($_POST['for'] == 'sec'){?>
		<br><table  class= "table" style="width: 28vw;border:1px solid black;border-collapse: initial;font-size: small;margin-top: 2vw;">
		<tr>
		<td class="set_td"><strong>Section : </strong></td>
		<td style="text-align: left;">
		<?if($_POST['status'] != 'edit'){?>
		  			<select id="multi_sec" multiple="multiple"  size="1" >

		                  <?  $sql_q = $conn->query($_POST['query'])->fetch_object();//print_r($sql_q);
		                      $sql = $conn->query("SELECT * from role_primary order by name asc");
		                      while($obj = $sql->fetch_object()){
		                        
		                  ?>
		                      <option value="<?=$obj->id?>" <? foreach(explode(',',$sql_q->section) as $val){if($val == $obj->id){ echo "selected";}}?>><?=$obj->name?></option>
		                  <?   } 
		                  ?>
		                </select>
		     <?}else{?>
		     	<select id="single_sec" class="form-control"  size="1" >
		     				<option value="0" disabled selected>Select</option>

		                  <?  $sql_q = $conn->query($_POST['query'])->fetch_object();//print_r($sql_q);
		                      $sql = $conn->query("SELECT * from role_primary where id in (".$sql_q->section.")order by name asc");
		                      while($obj = $sql->fetch_object()){
		                        
		                  ?>
		                      <option value="<?=$obj->id?>" <?if($_POST['r_c_val'] == $obj->id){ echo "selected";}?>><?=$obj->name?></option>
		                  <?   } 
		                  ?>
		                </select>
						
		     <?}?>
			 <input type="hidden" id="hid_comp_row_id1" value="<?=$sql_q->id?>">
		     <script>

	   					$(document).ready(function(){
	   							var text = $('#single_sec option:selected').text();
						     	$('#edit_sec_name').val(text);
	   					});


		     $('#single_sec').change(function(){
		     	var text = $('#single_sec option:selected').text();
		     	$('#edit_sec_name').val(text);
		     });
			 var company = '<?=$_POST['company']?>';
			 var what = '<?=$_POST['what']?>';
			 var row_id = $('#hid_comp_row_id1').val();
			 
			 $('#add_new_sec').click(function(){

			 	var seq = company; //alert(seq);
				localStorage.setItem("sequence", seq);

				 var comb = $('#multi_sec').val();
				 if(comb != '' && comb != undefined){
					var comb = $('#multi_sec').val().join();//alert(new_sec);
				 }
				var new_sec = $('#new_sec_name').val();//alert(new_sec);
				if(new_sec != '' && new_sec != undefined){
					var new_sec = $('#new_sec_name').val().trim();
				}
				if(new_sec == '' && (comb == '' || comb == null)){
					alert("Please fill the required fields");
				}else{ //alert(new_sec);
					 $.post('combination_qry.php',{for_what:'sec',action:'add',new_name:new_sec,comb:comb,company:company,what:what,row_id:row_id},function(data){
						alert(data);
						location.reload();
					}); 
				}
			});
			
					 $('#update_sec_name').click(function(){

					 	var seq = company; //alert(seq);
						localStorage.setItem("sequence", seq);

								var exist_sec = $('#edit_sec_name').val().trim();
								var exist_id = $('#single_sec').val();
								if(exist_sec == ''){
									alert("Please enter section name");
								}else{
									$.post('combination_qry.php',{for_what:'sec',action:'edit',exist_name:exist_sec,exist_id:exist_id},function(data){
										alert(data);
										location.reload();
									});
								}
					});
		     </script>
		 </td>
		 </tr>
		 <tr>
		 <td class="set_td">
		 <? if($_POST['status'] == 'edit'){?><strong> Name : </strong><?}else{?><strong>New Section : </strong><?}?>
		 </td>
		 <td>
		  <? if($_POST['status'] == 'edit'){?><input type='text' class="form-control" id='edit_sec_name' value=''><?}else{?><input type='text' class="form-control" id='new_sec_name' placeholder="Enter New Section " value=''><?}?>
		 </td>
		 </tr>
		 </table>
		 <? if($_POST['status'] == 'edit'){?><input type='button' id='update_sec_name'  style="margin-top:2vh;" value='Update'><?}else{?><input type='button' style="margin-top:2vh;" id='add_new_sec'  value='Add New'><?}?>
		 
 <?}else if($_POST['for'] == 'bu'){ //print_r($_POST);?>
		
		<table  class= "table" style="width: 28vw;border:1px solid black;border-collapse: initial;font-size: small;margin-top: 2vw;">
		<tr>
		<td class="set_td"><strong>Business Unit : </strong></td>
		<td style="text-align: left;">
		<?if($_POST['status'] != 'edit'){?>
		  			<select id="multi_bu" multiple="multiple" size="1" >

		                  <?  $sql_q = $conn->query($_POST['query'])->fetch_object();//echo "hello";print_r($sql_q);
		                      $sql = $conn->query("SELECT * from role_group  order by name asc");
		                      while($obj = $sql->fetch_object()){
		                        
		                  ?>
		                      <option value="<?=$obj->id?>" <? foreach(explode(',',$sql_q->business_unit) as $val){if($val == $obj->id){ echo "selected";}}?>><?=$obj->name?></option>
		                  <?   } 
		                  ?>
		                </select>
		         <?}else{?>

		         		<select id="single_bu" class="form-control" size="1" >
		         			<option value="0" disabled selected>Select</option>

		                  <?  $sql_q = $conn->query($_POST['query'])->fetch_object();//print_r($sql_q);
		                      $sql = $conn->query("SELECT * from role_group where id in (".$sql_q->business_unit.")order by name asc");
		                      while($obj = $sql->fetch_object()){
		                        
		                  ?>
		                      <option value="<?=$obj->id?>" <?if($_POST['r_c_val'] == $obj->id){ echo "selected";}?>><?=$obj->name?></option>
		                  <?   } 
		                  ?>
		                </select>
						

		         	<?}?>
					<input type="hidden" id="hid_comp_row_id2" value="<?=$sql_q->id?>">
		        <script>
						$(document).ready(function(){
	   							var text = $('#single_bu option:selected').text();
						     	$('#edit_bu_name').val(text);
	   					});

				     $('#single_bu').change(function(){
				     	var text = $('#single_bu option:selected').text();
				     	$('#edit_bu_name').val(text);
				     });
					 
			 var company = '<?=$_POST['company']?>';
			 var section = '<?=$_POST['section']?>';//alert(section);
			 var what = '<?=$_POST['what']?>';
			 var row_id = $('#hid_comp_row_id2').val();
			 
			 $('#add_new_bu').click(function(){

			 	var seq = company+','+section; //alert(seq);
				localStorage.setItem("sequence", seq);

				var comb = $('#multi_bu').val();
				if(comb != '' && comb != undefined){
				var comb = $('#multi_bu').val().join();
				}
				var new_bu = $('#new_bu_name').val();
				if(new_bu != '' && new_bu != undefined){
				var new_bu = $('#new_bu_name').val().trim();
				}
				if(new_bu == '' && (comb == '' || comb == null)){
					alert("Please fill the required fields");
				}else{
					 $.post('combination_qry.php',{for_what:'bu',action:'add',new_name:new_bu,comb:comb,company:company,section:section,what:what,row_id:row_id},function(data){
						alert(data);
						location.reload();
					}); 
				}
			});
			
						 $('#update_bu_name').click(function(){

						 	var seq = company+','+section; //alert(seq);
							localStorage.setItem("sequence", seq);

								var exist_bu = $('#edit_bu_name').val().trim();
								var exist_id = $('#single_bu').val();
								if(exist_bu == ''){
									alert("Please enter business unit name");
								}else{
									$.post('combination_qry.php',{for_what:'bu',action:'edit',exist_name:exist_bu,exist_id:exist_id},function(data){
										alert(data);
										location.reload();
									});
								}
						});
		     </script>
		 </td>
		 </tr>
		 <tr>
		 <td class="set_td">
		 	<?if($_POST['status'] == 'edit'){?><strong>Name : </strong><?}else{?><strong>New Business Unit : </strong><?}?>
		 </td>
		 <td>
		 <?if($_POST['status'] == 'edit'){?><input type='text' class="form-control" id='edit_bu_name' value=''><?}else{?><input type='text' class="form-control" id='new_bu_name' placeholder="Enter New Business Unit " value=''><?}?>
		 </td>
		 </tr>
		 </table>
		  <? if($_POST['status'] == 'edit'){?><input type='button' id='update_bu_name'  value='Update'><?}else{?><input type='button' id='add_new_bu'  value='Add New'><?}?>

 	<?}else if ($_POST['for'] == 'loc'){ ?>
 		<table  class= "table" style="width: 28vw;border:1px solid black;border-collapse: initial;font-size: small;margin-top: 2vw;">
		<tr>
		<td class="set_td"><strong>Location: </strong></td>
		<td style="text-align: left;">
		<?if($_POST['status'] != 'edit'){?>
		  			<select id="multi_loc" multiple="multiple" size="1" >

		                  <?  $sql_q = $conn->query($_POST['query'])->fetch_object();//print_r($sql_q);
		                      $sql = $conn->query("SELECT * from role_dept  order by name asc");
		                      while($obj = $sql->fetch_object()){
		                        
		                  ?>
		                      <option value="<?=$obj->id?>" <? foreach(explode(',',$sql_q->location) as $val){if($val == $obj->id){ echo "selected";}}?>><?=$obj->name?></option>
		                  <?   } 
		                  ?>
		                </select>
		     <?}else{?>

		     		<select id="single_loc" class="form-control" size="1" >
		     			<option value="0" disabled selected>Select</option>

		                  <?  $sql_q = $conn->query($_POST['query'])->fetch_object();//print_r($sql_q);
		                      $sql = $conn->query("SELECT * from role_dept where id in (".$sql_q->location.") order by name asc");
		                      while($obj = $sql->fetch_object()){
		                        
		                  ?>
		                      <option value="<?=$obj->id?>" <?if($_POST['r_c_val'] == $obj->id){ echo "selected";}?>><?=$obj->name?></option>
		                  <?   } 
		                  ?>
		                </select>
				
		     	<?}?>
					<input type="hidden" id="hid_comp_row_id3" value="<?=$sql_q->id?>">
		     	 <script>
		     	 	$(document).ready(function(){
	   							var text = $('#single_loc option:selected').text();
						     	$('#edit_loc_name').val(text);
	   				});



				     $('#single_loc').change(function(){
				     	var text = $('#single_loc option:selected').text();
				     	$('#edit_loc_name').val(text);
				     });
					 
			 var company = '<?=$_POST['company']?>';
			 var section = '<?=$_POST['section']?>';
			 var business_unit = '<?=$_POST['bu']?>';
			 var what = '<?=$_POST['what']?>';
			 var row_id = $('#hid_comp_row_id3').val();
			 
			 $('#add_new_loc').click(function(){

			 	var seq = company+','+section+','+business_unit; //alert(seq);
				localStorage.setItem("sequence", seq);

				 var comb = $('#multi_loc').val();
				if(comb != '' && comb != undefined){
				var comb = $('#multi_loc').val().join();
				 }
				 var new_loc = $('#new_loc_name').val();
				 if(new_loc != '' && new_loc != undefined){
				var new_loc = $('#new_loc_name').val().trim();
				 }
				if(new_loc == '' && (comb == '' || comb == null)){
					alert("Please fill the required fields");
				}else{
					 $.post('combination_qry.php',{for_what:'loc',action:'add',new_name:new_loc,comb:comb,company:company,section:section,business_unit:business_unit,what:what,row_id:row_id},function(data){
						alert(data);
						location.reload();
					}); 
				}
			});
			
						$('#update_loc_name').click(function(){
							var seq = company+','+section+','+business_unit; //alert(seq);
							localStorage.setItem("sequence", seq);
							
								var exist_loc = $('#edit_loc_name').val().trim();
								var exist_id = $('#single_loc').val();
								if(exist_loc == ''){
									alert("Please enter location name");
								}else{
									$.post('combination_qry.php',{for_what:'loc',action:'edit',exist_name:exist_loc,exist_id:exist_id},function(data){
										alert(data);
										location.reload();
									});
								}
						});
		     </script>
		 </td>
		 </tr>
		 <tr>
		 <td class="set_td">
		 <?if($_POST['status'] == 'edit'){?><strong>Name : </strong><?}else{?><strong>New Location : </strong><?}?>
		 </td>
		 <td>
		  <?if($_POST['status'] == 'edit'){?><input type='text' class="form-control" id='edit_loc_name' value=''><?}else{?><input type='text' class="form-control" id='new_loc_name' placeholder="Enter New Location " value=''><?}?>
		 </td>
		 </tr>
		 </table>
		<? if($_POST['status'] == 'edit'){?><input type='button' id='update_loc_name'  value='Update'><?}else{?> <input type='button' id='add_new_loc'  value='Add New'><?}?>


 		<?}else if ($_POST['for'] == 'wrkgrp'){ ?>
 		<table  class= "table" style="width: 28vw;border:1px solid black;border-collapse: initial;font-size: small;margin-top: 2vw;">
		<tr>
		<td class="set_td"><strong>Workgroup : </strong></td>
		<td style="text-align: left;">
		<?if($_POST['status'] != 'edit'){?>
		  			<select id="multi_wrkgrp" multiple="multiple" size="1" >

		                  <?  $sql_q = $conn->query($_POST['query'])->fetch_object();//echo $_POST['query'];print_r($sql_q);
		                      $sql = $conn->query("SELECT * from tbl_workgroup  order by name asc");
		                      while($obj = $sql->fetch_object()){
		                        
		                  ?>
		                      <option value="<?=$obj->id?>" <? foreach(explode(',',$sql_q->workgroup) as $val){if($val == $obj->id){ echo "selected";}}?>><?=$obj->name?></option>
		                  <?   } 
		                  ?>
		                </select>

		         <?}else{?>

		         	<select id="single_wrkgrp" class="form-control" size="1" >
		         			<option value="0" disabled selected>Select</option>

		                  <?  $sql_q = $conn->query($_POST['query'])->fetch_object();//print_r($sql_q);
		                      $sql = $conn->query("SELECT * from tbl_workgroup where id in (".$sql_q->workgroup.") order by name asc");
		                      while($obj = $sql->fetch_object()){
		                        
		                  ?>
		                      <option value="<?=$obj->id?>" <?if($_POST['r_c_val'] == $obj->id){ echo "selected";}?>><?=$obj->name?></option>
		                  <?   } 
		                  ?>
		                </select>
						
		         	<?}?>
					<input type="hidden" id="hid_comp_row_id4" value="<?=$sql_q->id?>">
		          <script>
		          	$(document).ready(function(){
	   							var text = $('#single_wrkgrp option:selected').text();
						     	$('#edit_wrkgrp_name').val(text);
	   				});



				     $('#single_wrkgrp').change(function(){
				     	var text = $('#single_wrkgrp option:selected').text();
				     	$('#edit_wrkgrp_name').val(text);
				     });
					 
				 
			 var company = '<?=$_POST['company']?>';
			 var section = '<?=$_POST['section']?>';
			 var business_unit = '<?=$_POST['bu']?>';//alert(location);
			var loc = '<?=$_POST['loc']?>';
			  var what = '<?=$_POST['what']?>';
			  var row_id = $('#hid_comp_row_id4').val();//alert(row_id);
				 
			 $('#add_new_wrkgrp').click(function(){

			 	var seq = company+','+section+','+business_unit+','+loc; //alert(seq);
				localStorage.setItem("sequence", seq);

				 var comb = $('#multi_wrkgrp').val();
				 if(comb != '' && comb != undefined){
				var comb = $('#multi_wrkgrp').val().join();
				 }
				 var new_wrkgrp = $('#new_wrkgrp_name').val();
				 if(new_wrkgrp != '' && new_wrkgrp != undefined){
				var new_wrkgrp = $('#new_wrkgrp_name').val().trim();
				 }
				if(new_wrkgrp == '' && (comb == '' || comb == null)){
					alert("Please fill the required fields");
				}else{
					 $.post('combination_qry.php',{for_what:'wrkgrp',action:'add',new_name:new_wrkgrp,comb:comb,company:company,section:section,business_unit:business_unit,location:loc,what:what,row_id:row_id},function(data){
						alert(data);
						location.reload();
					}); 
				}
			});
			
						$('#update_wrkgrp_name').click(function(){

								var seq = company+','+section+','+business_unit+','+loc; //alert(seq);
								localStorage.setItem("sequence", seq);

								var exist_wrkgrp = $('#edit_wrkgrp_name').val().trim();
								var exist_id = $('#single_wrkgrp').val();
								if(exist_wrkgrp == ''){
									alert("Please enter workgroup name");
								}else{
									$.post('combination_qry.php',{for_what:'wrkgrp',action:'edit',exist_name:exist_wrkgrp,exist_id:exist_id},function(data){
										alert(data);
										location.reload();
									});
								}
						}); 
		    	 </script>
		 </td>
		 </tr>
		 <tr>
		 <td class="set_td">
		  <?if($_POST['status'] == 'edit'){?><strong>Name : </strong><?}else{?><strong>New Workgroup : </strong><?}?>
		 </td>
		 <td>
		 <?if($_POST['status'] == 'edit'){?><input type='text' class="form-control" id='edit_wrkgrp_name' value=''><?}else{?><input type='text' class="form-control" id='new_wrkgrp_name' placeholder="Enter New Workgroup " value=''><?}?>
		 </td>
		 </tr>
		 </table>
		 <? if($_POST['status'] == 'edit'){?><input type='button' id='update_wrkgrp_name'  value='Update'><?}else{?> <input type='button' id='add_new_wrkgrp'  value='Add New'><?}?>


 		<?}?>
 		<!-- </center> -->
 		<? //include_once('right_click_popup.php');?>
