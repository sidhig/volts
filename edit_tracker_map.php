  <? 
 
  include_once('connect.php'); 
  session_start(); 
  
  if ($result = $conn->query("select * from devicedetails where DeviceIMEI = '".$_REQUEST['imei']."'")) { 
        $obj = $result->fetch_object();
		 
		  //echo $_REQUEST['imei']; print_r($obj);die();
  }
 //echo "select * from devicedetails where DeviceIMEI = '".$_REQUEST['imei']."'";
 
  ?>

 <style>
 body{
  background-color: #d6dce2;
 }
 td{
  padding-right: 1vw;
  padding-bottom: 1vh;
 }
  .stg{
    margin-left: 2vw;
    margin-right: 1vw;
   }
.sel{
  width:15vw;
  border-radius: 4px;
  padding: 6px 12px;
  height: 34px;
  border: 1px solid #ccc;
}
 .intp{
  width:15vw;
   border-radius: 4px;
  padding: 6px 12px;
  height: 34px;
  border: 1px solid #ccc;
}

.modal {
  width:40vw;
}
.modal a.close-modal {
    top: 0.5px;
    right: 0.5px;
  }
 
th {
    text-align: center;
  }

@media only screen and (max-width: 768px) {
    /* For mobile phones: */
   
    .intp {
        width: 100%;
    }
    .sel {
        width: 100%;
    }
  .modal {
  width:90vw;
  }
}
.btn{
  /*background: url(image/close.png) no-repeat;*/
}

 </style>
 <script>
 
function validateForm(){
     if ($("#trackername").val().trim() == ''){
        alert('Please Fill Tracker Name');
        $("#trackername").focus();
        
      }
      else if($("#trackertype").val() == 'Xirgo JBUS' && $("#esn").val().trim() == ''){
          alert('Please Fill Tracker ESN');
          $("#esn").focus();
      }
      else if ($("#trackertype").val() != 'Xirgo JBUS' && $("#trackerimei").val().trim() == ''){
        alert('Please Fill Tracker MEID DEC');
        $("#trackerimei").focus();
        
      }
      else if ($("#trackerphone").val().trim() == ''){
        alert('Please Fill Tracker Phone');
        $("#trackerphone").focus();
        
      }
    else {
       $("#track_add_spinner").show();

       if(($('#trac_opco').val() == 'Georgia Power') && ($('#trac_primary').val() == 'Distribution')){ 
           $.ajax({
                  type: "POST",
                  url: "https://volts.systems/xirgo/auto_device_report.php",
                  data: '',
                  success: function(data) {
                    //alert("ajax"+data);
                  }
              });
        }
   $.ajax({
            type: "POST",
            url: "tracker_query.php",
            data: $('#new_tracker_form').serialize(),
            success: function(data) { //$("#track_add_spinner").html(data);return false;
        alert(data);
        $("#trip_sheet_div").html(""); 
        $("#trip_sheet_div").hide();
        //$("#tracker_add_btn").show();
        //$("#tracker_tbl_body").load('tracker_tbl_body.php');
            }
        });
    }
} 


 </script>
  <center>
  <div style='background:white; font-size: 1.2rem;width: 50%; border-radius: 15px; padding: 5px; border: 2px solid #969090;'>

 <form id='new_tracker_form' name="new_tracker_form">
            <h1 style="font-size:2.2rem;"><b>Update Tracker</b></h1>
			 <div id='track_add_spinner' style="color:red; clear: both; display:none;"><img src="image/spinner.gif" width="20px">Please wait...</div>
          <table>
            <tr>
            <td><strong class="stg">Company:</strong></td>
            <td><select id="trac_opco" name="opco" class="sel " style="background-color:#D3D3D3;">
				  <?  
                  $sql = $conn->query("SELECT * from role_opco where if('".$_SESSION['ROLE_opco']."'='0',1,id in (".$_SESSION['ROLE_opco'].")) order by name asc");
                  while($obj_role = $sql->fetch_object()){
              ?>
                  <option <?=($obj->opco==$obj_role->name)?'selected':''?> ><?=$obj_role->name?></option>
              <?   } 
              ?>
                </select>
            </td>
        </tr>
        <tr>
            <td><strong class="stg">Section:</strong></td>
            <td><select id="trac_primary" name="primary" class="sel" style="background-color:#D3D3D3;">
			 <?  
                  $sql = $conn->query("SELECT * from role_primary where if('".$_SESSION['ROLE_primary']."'='0',1,id in (".$_SESSION['ROLE_primary'].")) order by name asc");
                  while($obj_role = $sql->fetch_object()){
              ?>
                  <option <?=($obj->primary==$obj_role->name)?'selected':''?> ><?=$obj_role->name?></option>
              <?   } 
              ?>
              </select>
            </td>
        </tr>
        <tr>
            <td><strong class="stg">Business Unit:</strong></td>
            <td><select id="group" name="group" class="sel" style="background-color:#D3D3D3;">
			 <?  
                  $sql = $conn->query("SELECT * from role_group where if('".$_SESSION['ROLE_group']."'='0',1,id in (".$_SESSION['ROLE_group'].")) order by name asc");
                  while($obj_role = $sql->fetch_object()){
              ?>
                  <option <?=($obj->group==$obj_role->name)?'selected':''?> ><?=$obj_role->name?></option>
              <?   } 
              ?>
              </select>
           </td>
        </tr>
        <tr>
            <td><strong class="stg">Location:</strong></td>
            <td><input type='hidden' name='qry_type' value='new'>
              <select id="department" name="department" class="sel " style="background-color:#D3D3D3;">
			  <?  
                  $sql = $conn->query("SELECT * from role_dept where if('".$_SESSION['ROLE_dept']."'='0',1,id in (".$_SESSION['ROLE_dept'].")) order by name asc");
                  while($obj_role = $sql->fetch_object()){
              ?>
                  <option <?=($obj->department==$obj_role->name)?'selected':''?> ><?=$obj_role->name?></option>
              <?   } 
              ?>
              </select>
            </td>
        </tr>
        <tr>
            <td><strong class="stg">Workgroup:</strong></td>
           <td> 
            <!-- <input id="workgroup" name="workgroup" type="text" class="intp " value="<?=($obj->workgroup)?>" style="background-color:#D3D3D3;" placeholder="Workgroup"> -->
             <select id="workgroup" name="workgroup" class="sel " style="background-color:#D3D3D3;">
             <?  
                  $sql = $conn->query("SELECT * from tbl_workgroup where if('".$_SESSION['ROLE_wrokgroup']."'='0',1,id in (".$_SESSION['ROLE_wrokgroup'].")) order by name asc");
                  while($obj_role = $sql->fetch_object()){
              ?>
                  <option <?=($obj->Workgroup==$obj_role->name)?'selected':''?> ><?=$obj_role->name?></option>
              <?   } 
              ?>
              </select>
            </td>
        </tr>
        <tr>
            <td><strong class="stg">Tracker Name:</strong></td>   
            <td><input type='hidden' name='qry_type' value='new'>
              <input id="trackername" name="trackername" type="text" value='<?=($obj->DeviceName)?>' class="intp" style="background-color:#D3D3D3;" placeholder="Tracker Name">
            </td>
        </tr>
        
        <tr>
              <td><strong class="stg">Driver Name:</strong></td>
              <td><input id="drivername" name="drivername" type="text" value="<?=($obj->driver_name)?>" class="intp" placeholder="Driver Name">
              </td>
        </tr>
        
        <tr>
              <td><strong class="stg">Driver Phone:</strong></td>
              <td><input id="driverphone" name="driverphone" type="number" onkeypress='return event.charCode >= 48 && event.charCode <= 57' value="<?=($obj->driver_phone)?>" class="intp" placeholder="Driver Phone">
              </td>
        </tr>
        <tr> 
              <td ><strong class="stg">MEID HEX:</strong></td>
              <td><input id="meid_hex" name="meid_hex"  type="text" value='<?=($obj->MEID_HEX)?>' class="intp" style="background-color:#D3D3D3;" placeholder="Tracker MEID HEX" readonly >
              </td>
        </tr>
        <tr> 
              <td ><strong class="stg">MEID DEC:</strong></td>
              <td><input id="trackerimei" name="trackerimei"  type="text" value='<?=($obj->MEID_DEC)?>' class="intp" style="background-color:#D3D3D3;" placeholder="Tracker MEID DEC" readonly >
              </td>
        </tr>
        <tr> 
              <td ><strong class="stg">ESN:</strong></td>
              <td><input id="esn" name="esn"  type="text" value='<?=($obj->esn)?>' onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="intp" style="background-color:#D3D3D3;" placeholder="ESN" readonly >
              </td>
        </tr>
        
         <tr>      
            <td><strong class="stg">Tracker Type:</strong></td>
            <td>
                <select id="trackertype" name="trackertype" class="sel" style="background-color:#D3D3D3;">
				 <?
				   $result = $conn->query("SELECT OBDType,OBDType_2 FROM `devicedetails` group by OBDType");
				   while($vehicle  = $result->fetch_object())
				   {
				  ?>
				   <option <?=($vehicle->OBDType==$obj->OBDType)?'selected':''?> ><?=$vehicle->OBDType_2?></option>
				  <?  } 
				  ?>
                </select>
            </td>
        </tr>
          <tr>
            <td><strong class="stg">Tracker Phone:</strong></td>
            <td><input id="trackerphone" name="trackerphone" onkeypress='return event.charCode >= 48 && event.charCode <= 57' type="number" value='<?=($obj->DevicePhone)?>' class="intp" style="background-color:#D3D3D3;" placeholder="Tracker Phone">
            </td>
        </tr>
        <tr>
             <td><strong class="stg">Tag #:</strong></td>
             <td><input id="tag" name="tag" type="text" value='<?=($obj->tag)?>' class="intp" placeholder="Tag #">
              </td>
        </tr>
        <tr>
              <td><strong class="stg">Odometer:</strong></td>
              <td><input id="odometer" name="odometer" type="text" value='<?=($obj->odometer)?>' class="intp" placeholder="Odometer">
              </td>
        </tr> 
        <tr>
              <td><strong class="stg">Owned By:</strong></td> 
              <td>
                <select id="ownedby" name="ownedby" class="sel" style="background-color:#D3D3D3;" onChange="setattr()">
                  <option value='GPC' <?=($obj->ownedby=='GPC')?'selected':''?> >GPC</option>
                  <option value='Rental Company'  <?=($obj->ownedby!='GPC')?'selected':''?> >Rental Company</option>
                </select>
              </td>
        </tr>
		
        <tr class="tr_ren" <? if($obj->ownedby=='GPC'){ ?> style="display:none;" <? } ?> >
              <td><strong class="stg">Rental Company:</strong></td>
              <td><input id="rentalcompnay" name="rentalcompnay" type="text" value='<?=($obj->ownedby)?>' class="intp" style="background-color:#D3D3D3;" placeholder="Rental Company">
              </td>
        </tr>
		
        <tr>
              <td><strong class="stg">Crew:</strong></td>
              <td><input id="crew" name="crew" type="text"class="intp" value='<?=($obj->crew)?>'  placeholder="Crew">
              </td>
        </tr>
        <tr>
              <td><strong class="stg">Equipment:</strong></td>
              <td>
                <select id="equipment" name="equipment" class="sel" style="background-color:#D3D3D3;" onChange="setattr()">
                  <?
                   $result = $conn->query("select eq_name from tbl_eqptype order by eq_name");
                   while($vehicle  = $result->fetch_object())
                   {
                  ?>
                   <option <?=($obj->DeviceType==$vehicle->eq_name)?'selected':''?> ><?=$vehicle->eq_name?></option>
                  <?  } 
                  ?>
                </select>
              </td>
        </tr>
        <tr>
              <td><strong class="stg">Equipment Details:</strong></td>
              <td><input id="equipmentdetails" name="equipmentdetails" type="text" value="<?=($obj->eqp_det)?>" class="intp" placeholder="Equipment Details">
              </td>
        </tr>
        <tr class="tr_mobile" <? if($obj->DeviceType!='Mobile Switch' && $obj->DeviceType!='Mobile Substation'){ ?> style="display:none;" <? } ?> >
              <td><strong class="stg">Unit#:</strong></td>
              <td><input id="unit" name="unit" type="text" class="intp" value='<?=($obj->unit)?>' style="background-color:#D3D3D3;" placeholder="Unit#">
              </td>
        </tr>
       
        <tr class="tr_mobile" <? if($obj->DeviceType!='Mobile Switch' && $obj->DeviceType!='Mobile Substation'){ ?> style="display:none;" <? } ?> >
              <td ><strong class="stg">MVA:</strong></td>
              <td><input id="mva" name="mva" type="text" value='<?=($obj->mva)?>' class="intp" placeholder="MVA">
              </td>
        </tr>
        <tr class="tr_mobile" <? if($obj->DeviceType!='Mobile Switch' && $obj->DeviceType!='Mobile Substation'){ ?> style="display:none;" <? } ?> >
              <td ><strong class="stg">High Side:</strong></td>
              <td><input id="highside" name="highside" type="text" value='<?=($obj->high_side)?>' class="intp" placeholder="MVA">
              </td>
        </tr>
        <tr class="tr_mobile" <? if($obj->DeviceType!='Mobile Switch' && $obj->DeviceType!='Mobile Substation'){ ?> style="display:none;" <? } ?> >
              <td ><strong class="stg">Low Side:</strong></td>
              <td><input id="lowside" name="lowside" type="text" value='<?=($obj->low_side)?>' class="intp" placeholder="Low Side">
              </td>
        </tr>
        <tr class="tr_mobile" <? if($obj->DeviceType!='Mobile Switch' && $obj->DeviceType!='Mobile Substation'){ ?> style="display:none;" <? } ?> >
              <td ><strong class="stg">Assoc Unit1:</strong></td>
              <td><input id="assocunit1" name="assocunit1" type="text" value='<?=($obj->assoc_unit1)?>' placeholder="Unit1" class="intp" placeholder="Assoc Unit1">
              </td>
        </tr>
        <tr class="tr_mobile" <? if($obj->DeviceType!='Mobile Switch' && $obj->DeviceType!='Mobile Substation'){ ?> style="display:none;" <? } ?> >
              <td ><strong class="stg">Assoc Unit2:</strong></td>
              <td><input id="assocunit2" name="assocunit2" type="text" value='<?=($obj->assoc_unit2)?>' placeholder="Unit2" class="intp" placeholder="Assoc Unit2">
              </td>
        </tr>
        <tr class="tr_mobile" <? if($obj->DeviceType!='Mobile Switch' && $obj->DeviceType!='Mobile Substation'){ ?> style="display:none;" <? } ?> >
              <td><strong class="stg">Assoc Unit3:</strong></td>
              <td><input id="assocunit3" name="assocunit3" type="text" value='<?=($obj->assoc_unit3)?>' placeholder="Unit3" class="intp" placeholder="Assoc Unit3">
              </td>
        </tr>
        <tr class="tr_mobile" <? if($obj->DeviceType!='Mobile Switch' && $obj->DeviceType!='Mobile Substation'){ ?> style="display:none;" <? } ?> >
              <td><strong class="stg">Voltage:</strong></td>
              <td><input id="voltage" name="voltage" type="text" value='<?=($obj->voltage)?>' class="intp" placeholder="Voltage">
              </td>
        </tr>
        <tr class="tr_mobile" <? if($obj->DeviceType!='Mobile Switch' && $obj->DeviceType!='Mobile Substation'){ ?> style="display:none;" <? } ?> >
              <td><strong class="stg">Status:</strong></td>
              <td>
                <select id="status" name="status" class="sel" style="background-color:#D3D3D3;">
                    <option <?=($obj->status=='Available')?'selected':''?> >Available</option>
                    <option <?=($obj->status=='In Use')?'selected':''?> >In Use</option>
                    <option <?=($obj->status=='In Repair')?'selected':''?> >In Repair</option>
                    <option <?=($obj->status=='Reserved for Emergency')?'selected':''?> >Reserved for Emergency</option>
                </select>
              </td>
        </tr>
        <tr class="tr_mobile" <? if($obj->DeviceType!='Mobile Switch' && $obj->DeviceType!='Mobile Substation'){ ?> style="display:none;" <? } ?> >
              <td><strong class="stg">High Side Equipment:</strong></td>
              <td><input id="highsideequipment" name="highsideequipment" type="text" value='<?=($obj->hs_equipment)?>' class="intp" placeholder="High Side Equipment">
              </td>
        </tr>
        <tr class="tr_mobile" <? if($obj->DeviceType!='Mobile Switch' && $obj->DeviceType!='Mobile Substation'){ ?> style="display:none;" <? } ?> >
              <td><strong class="stg">Low Side Equipment:</strong></td>
              <td><input id="lowsideequipment" name="lowsideequipment" type="text" value='<?=($obj->ls_equipment)?>' class="intp"  placeholder="Low Side Equipment">
              </td>
        </tr>
        <tr class="tr_mobile" <? if($obj->DeviceType!='Mobile Switch' && $obj->DeviceType!='Mobile Substation'){ ?> style="display:none;" <? } ?> >  
              <td><strong class="stg">Equipment #:</strong></td>
              <td><input id="equipmentno" name="equipmentno" type="text" value='<?=($obj->equipment_no)?>' class="intp" placeholder="Equipment #">
              </td>
        </tr>
        <tr class="tr_mobile" <? if($obj->DeviceType!='Mobile Switch' && $obj->DeviceType!='Mobile Substation'){ ?> style="display:none;" <? } ?> >
              <td><strong class="stg">Storage Facility:</strong></td>
              <td><input id="storagefacility" name="storagefacility" type="text" value='<?=($obj->storage)?>' class=" intp" placeholder="Storage Facility">
              </td>
        </tr>
        <tr class="tr_mobile" <? if($obj->DeviceType!='Mobile Switch' && $obj->DeviceType!='Mobile Substation'){ ?> style="display:none;" <? } ?> >        
              <td><strong class="stg">Switch Type:</strong></td>
              <td><input id="switchtype" name="switchtype" type="text" value='<?=($obj->switch_type)?>' class="intp" placeholder="Switch Type">
              </td>
        </tr>
        <tr class="tr_mobile" <? if($obj->DeviceType!='Mobile Switch' && $obj->DeviceType!='Mobile Substation'){ ?> style="display:none;" <? } ?> >
              <td><strong class="stg">Voltage Configuration:</strong></td>
              <td><input id="voltageconfiguration" name="voltageconfiguration" value='<?=($obj->voltage_config)?>' type="text"class="intp" placeholder="Voltage Configuration">
              </td>
        </tr>
		 <tr>
              <td ><strong class="stg">Supervisor:</strong></td>    
              <td><input id="supervisor" name="supervisor" type="text" value="<?=($obj->supervisor)?>" class="intp" style="" placeholder="Supervisor">
              </td>
        </tr>
		
		<br>
        
        <input type='hidden' name='qry_type' value='edit'>
         </table><br>
         <input onclick='validateForm();' type='button'  value="Save Tracker" class="btn btn-primary" style="margin-bottom:1vh;height:5vh;"> 
        <a onclick='$("#trip_sheet_div").hide();$("#trip_sheet_div").html("");'><input type="button" class="btn btn-primary" value="Close" style="margin-bottom:1vh;height:5vh;"></a><br>
 
       </form>
    </div></center>