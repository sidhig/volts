  <? include_once('connect.php'); 
  session_start(); ?>
	<h1>Add Tracker</h1>
<div style=" border-color:white;">
              <strong>OPCO:</strong>
              
              <select id="opco" name="opco" class="input sel" style="background-color:#D3D3D3;">
          <?
           $result = $conn->query("SELECT opco FROM `devicedetails` group by opco");
           while($vehicle  = $result->fetch_object())
           {
          ?>
           <option value="<?=$vehicle->opco?>"><?=$vehicle->opco?></option>
          <?  } 
          ?>
          </select><br>
          
            <strong>Primary:</strong>
            
              <select id="primary" name="primary" class="input sel" style="background-color:#D3D3D3;">
              <option value=Distribution>Distribution</option>
              <option value=Fleet>Fleet</option>
              <option value=Generation>Generation</option>
              <option value=Transmission>Transmission</option>
              </select>
            <br>
            
            
             <strong>Group:</strong>
            <select id="group" name="group" class="input sel" style="background-color:#D3D3D3;">
              <option value=Automation>Automation</option>
              <option value=Construction>Construction</option>
              <option value=Maintenance>Maintenance</option>
              <option value=Operation>Operation</option>
              <option value=Repair>Repair</option>
              <option value=Fleet>Fleet</option>
            </select>
              <br>
              
             <strong>Department:</strong>
             
            <select id="department" name="department" class="input sel" style="background-color:#D3D3D3;">
              <option>Construction Support</option>
              <option>Construction Services/Heavy Hauling</option>
              <option>Fleet Supervisor</option>
              <option>FPK Fleet</option>
              <option>Line Construction</option>
              <option>Northern Fleet</option>
              <option>Parts Trucks</option>
              <option>Road Crew</option>
              <option>Substation Construction</option>
              <option>Southern Fleet</option>
            </select><br>
            
           
             <strong>Tracker Name:</strong>
              <input id="trackername" name="trackername" type="text" class="input intp" style="background-color:#D3D3D3;" placeholder="Tracker Name"><br>

              <strong>Driver Name:</strong>
              <input id="drivername" name="drivername" type="text" class="input intp" placeholder="Driver Name"><br>
             
              <strong>Driver Phone:</strong>
              <input id="driverphone" name="driverphone" type="text" class="input intp" placeholder="Driver Phone"><br>
                
              <strong>Tracker IMEI:</strong>
                <input id="trackerimei" name="trackerimei"  type="text" class="input intp" style="background-color:#D3D3D3;" placeholder="Tracker IMEI"><br>
               
              <strong>Tracker Type:</strong>
            <select id="trackertype" name="trackertype" class="input sel" style="background-color:#D3D3D3;">
              <?
               $result = $conn->query("SELECT OBDType FROM `devicedetails` group by OBDType");
               while($vehicle  = $result->fetch_object())
               {
              ?>
               <option value="<?=$vehicle->OBDType?>"><?=$vehicle->OBDType?></option>
              <?  } 
              ?>
            </select><br>
      
              <strong>Tracker Phone:</strong>
              <input id="trackerphone" name="trackerphone" type="text" class="input intp" style="background-color:#D3D3D3;" placeholder="Tracker Phone"><br>
              
              <strong>Tag #:</strong>
                <input id="tag" name="tag" type="text" class="input intp" placeholder="Tag #"><br>

              <strong>Odometer:</strong>
              <input id="odometer" name="odometer" type="text" class="input intp" placeholder="Odometer"><br> 
           
              <strong>Owned By:</strong>
            <select id="ownedby" name="ownedby" class="input sel" style="background-color:#D3D3D3;">
              <option value='GPC'>GPC</option>
              <option value='Rental Company'>Rental Company</option>
            </select><br>

              <strong>Equipment Details:</strong>
              <input id="equipmentdetails" name="equipmentdetails" type="text" class="input intp" placeholder="Equipment Details"><br>
           
              <strong>Crew:</strong>
              <input id="crew" name="crew" type="text"class="input intp"  placeholder="Crew"><br>
             
              <strong>Unit#:</strong>
              <input id="unit" name="unit" type="text" class="input mbsub intp" style="background-color:#D3D3D3;" placeholder="Unit#"><br>
           
              <strong>Equipment:</strong>
            <select id="equipment" name="equipment" class="input sel" style="background-color:#D3D3D3;">
                <?
               $result = $conn->query("SELECT DeviceType FROM `devicedetails` group by DeviceType");
               while($vehicle  = $result->fetch_object())
               {
              ?>
               <option value="<?=$vehicle->DeviceType?>"><?=$vehicle->DeviceType?></option>
              <?  } 
              ?>
            </select><br>
        
              <strong>Supervisor:</strong>
              <input id="supervisor" name="supervisor" type="text" class="input intp" style="background-color:#D3D3D3;" placeholder="supervisor"><br>
                
              <strong>MVA:</strong>
              <input id="mva" name="mva" type="text" class="input mbsub intp" placeholder="MVA"><br>

              <strong>High Side:</strong>
              <input id="highside" name="highside" type="text" class="input mbsub intp" placeholder="MVA"><br>
           
              <strong>Low Side:</strong>
              <input id="lowside" name="lowside" type="text" class="input mbsub intp" placeholder="Low Side"><br>
           
              <strong>Assoc Unit1:</strong>
              <input id="assocunit1" name="assocunit1" type="text" placeholder="Unit1" class="input mbsub intp" placeholder="Assoc Unit1"><br>
           
              <strong>Assoc Unit2:</strong>
                <input id="assocunit2" name="assocunit2" type="text" placeholder="Unit2" class="input mbsub intp" placeholder="Assoc Unit2"><br>
            
              <strong>Assoc Unit3:</strong>
              <input id="assocunit3" name="assocunit3" type="text" placeholder="Unit3" class="input mbsub intp" placeholder="Assoc Unit3"><br>
           
              <strong>Voltage:</strong>
                <input id="voltage" name="voltage" type="text" class="input mbsub intp" placeholder="Voltage"><br>
          
              <strong>Status:</strong>
            <select id="status" name="status" class="input mbsub sel"
              style="background-color:#D3D3D3;">
                <option value='Availabe'>Availabe</option>
                <option value='In Use'>In Use</option>
                <option value='In Repair'>In Repair</option>
                <option value='Reserved for Emergency'>Reserved for Emergency</option>
            </select><br>
                   
              <strong>Switch Type:</strong>
              <input id="switchtype" name="switchtype" type="text" class="input mbsub intp" placeholder="Switch Type"><br>
           
              <strong>High Side Equipment:</strong>
              <input id="highsideequipment" name="highsideequipment" type="text" class="input mbsub intp" placeholder="High Side Equipment"><br>
             
              <strong>Low Side Equipment:</strong>
                <input id="lowsideequipment" name="lowsideequipment" type="text" class="input mbsub intp"  placeholder="Low Side Equipment"><br>
                
              <strong>Equipment #:</strong>
                <input id="equipmentno" name="equipmentno" type="text" class="input mbsub intp" placeholder="Equipment #"><br>

              <strong>Storage Facility:</strong>
                <input id="storagefacility" name="storagefacility" type="text" class="input mbsub intp" placeholder="Storage Facility"><br>
            
              <strong>Voltage Configuration:</strong>
                <input id="voltageconfiguration" name="voltageconfiguration" type="text"class="input mbsub intp" placeholder="Voltage Configuration"><br>

              <strong>Rental Company:</strong>
                <input id="rentalcompnay" name="rentalcompnay" type="text" class="input intp"style="background-color:#D3D3D3;" placeholder="Rental Company"><br>
              
             <input type='hidden' name='qry_type' value='new'>
              
			  <center>
			   <input onclick='validateForm();' type='button' style="margin-bottom:8px; height:16px; width:70px; font-size:10px;" value="Add Tracker" > 
			   	<input onclick='add_form_close();' style="margin-bottom:8px; height:16px; width:50px; font-size:10px;" type='button' value='Close' >
</div>