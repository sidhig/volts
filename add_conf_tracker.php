<? include_once('connect.php'); 
  session_start(); 
if ($result = $conn->query("select * from devicedetails where DeviceIMEI = '".$_REQUEST['imei']."'")) { 
        $obj = $result->fetch_object();
  }
  ?>
<script>
function delete_file(){
   $.post("delete_file.php",{},
	   function(data) {
	});
}
var myVar;
var myVar1;
var my_Var;
function read() {
	$('#trac_info_tab input[type="text"]').val('');
    $('#dtc_report,#report_ing_on,#idle,#report_ing_off,#towing_alert,#motion_alert ').val(0);
    
    $("#img1").attr("src","image/grey.png");
	$("#img2").attr("src","image/grey.png");
	$("#img3").attr("src","image/grey.png");
    $("#Config").attr('disabled', 'disabled');
    $('#send_msg').show();
    delete_file();

	$.post("sendmessage_t.php",{phone:$('#DevicePhone').val().trim(),message:'XT:1008,14079862428'},
		     function(data) { //alert(data);
		var count_my_Var = 0;
	    my_Var =setInterval(function(){
	    	count_my_Var++;
			$.ajax({
	                    		   
					   	type: "POST",
						url: "assetsdata_tracker.php",
						data: "",
					    error: function()
					    {
					        //alert('file not exists');
					    },
				success: function(data)
				{
						//alert(data);
					    	clearInterval(my_Var);
					    	//alert(data);
					    	delete_file();
                             $('#send_msg').hide();
                             $('#qury_sttg').show();
					$.post("sendmessage_t.php",{phone:$('#DevicePhone').val().trim(),message:'XT:1003'},
								function(data) {/**/
									/*alert(data);*/
						var count_myVar1 = 0;
				        myVar1 =setInterval(function(){
				        		count_myVar1++;
							$.ajax({
					               url:'assetsdata_tracker.php',
								    type:'post',
								    data:'',
							    error: function()
							    {
							        //alert('file not exists');
							    },
							  success: function(data)
							    {
							    	     clearInterval(myVar1);
					    	            //alert(data);
				                	     $('#msg').html(data);
					      			     var msg2 = document.getElementById("msg").value;
					        			 var res1 = msg2.split(",");
					           		 	if(res1.length==8) {
												document.getElementById("meid").value = res1[0].replace(/[$]/g, "");
												//if(res[1]!=undefined)
												document.getElementById("port").value = res1[2];
												//if(res[2]!=undefined)
												document.getElementById("ip_dns").value = res1[3];
												//if(res[3]!=undefined)
												document.getElementById("mobile").value = res1[4];
												
												$("#protocol option[value=" + res1[5] + "]").prop("selected",true);
												document.getElementById("dce").value = res1[6];
												document.getElementById("dct").value = res1[7][0];
										    }
										    else if(res1.length==9) 
										    {
                                                document.getElementById("meid").value = res1[0].replace(/[$]/g, "");
												document.getElementById("port").value = res1[2];
												document.getElementById("ip_dns").value = res1[3];
												document.getElementById("mobile").value = res1[7];
												var tu = res1[8].replace(/[#]/g, "");
												$("#protocol option[value=" + tu + "]").prop("selected",true);
												document.getElementById("apn").value = res1[6];
										   }
					           		
						                     delete_file();
						                     $('#qury_sttg').hide();
										     $('#inter_settg').show();
	                                        $.post("sendmessage_t.php",{phone:$('#DevicePhone').val().trim(),message:'XT:3050'},
											function(data) {
													/*alert(data);/**/
												var count_myVar = 0;
												myVar =setInterval(function()
												{       count_myVar++;
													$.ajax({
													    url:'assetsdata_tracker.php',
													    type:'post',
													    data:'',
													    error: function()
													    {
													        //alert('file not exists');
													    },
													    success: function(data)
													    {
													    	clearInterval(myVar);
													    	//alert(data);
													    	$('#msg1').html(data);
													       	var msg1 = document.getElementById("msg1").value;
											         			var res = msg1.split(",");  
											         			if(res.length == 29){
											         		       	document.getElementById("meid").value = res[0].replace(/[$]/g, '');
																	document.getElementById("ing_on_report_rate").value = res[2];
																	$("#report_ing_on option[value=" + res[3] + "]").prop("selected",true);
																	document.getElementById("ing_off_report_rate").value = res[4];
																	$("#report_ing_off option[value=" + res[5] + "]").prop("selected",true);
																	//document.getElementById("dtc_interval").value = Math.round(res[6]);
																	document.getElementById("speed").value = res[7];
																	document.getElementById("rpm").value = res[8];
																	document.getElementById("mileage").value = res[9];
																	document.getElementById("acceleration").value = res[10];
																	document.getElementById("deceleration").value = res[11];
																	document.getElementById("battery").value = res[12];
																	document.getElementById("heartbeat").value = res[14];
																	$("#idle option[value=" + res[16] + "]").prop("selected",true);
																	$("#towing_alert option[value=" + res[17] + "]").prop("selected",true);
																	$("#motion_alert option[value=" + res[22] + "]").prop("selected",true);
								
																}
																else if(res.length==21)
																{
																	document.getElementById("meid").value = res[0].replace(/[$]/g, '');
																	document.getElementById("ing_on_report_rate").value = res[2];
																	$("#report_ing_on option[value=" + res[3] + "]").prop("selected",true);   
																	document.getElementById("ing_off_report_rate").value = res[4];
																	$("#report_ing_off option[value=" + res[5] + "]").prop("selected",true);
																	//document.getElementById("dtc_interval").value = res[6];
																	document.getElementById("speed").value = res[7];
																	document.getElementById("mileage").value = res[8];
																	document.getElementById("acceleration").value = res[9];
																	document.getElementById("deceleration").value = res[10];
																	document.getElementById("battery").value = res[11];
																	document.getElementById("heartbeat").value = res[15];
																	$("#idle option[value=" + res[19] + "]").prop("selected",true);
																	$("#towing_alert option[value=" + 0 + "]").prop("selected",true);// not sure
																	$("#motion_alert option[value=" + 0 + "]").prop("selected",true);// not sure
																}
																	
																	delete_file();
														            $('#inter_settg').hide();
                                                                        $('#current_settg').show();
					                                                    $.post("sendmessage_t.php",{phone:$('#DevicePhone').val().trim(),message:'XT:3052'},
															             function(data) {
																	      /*alert(data);/* */
																	      var count_my_Var1 = 0;
																			my_Var1 =setInterval(function()
																			{       count_my_Var1++;
																				$.ajax({
																				    url:'assetsdata_tracker.php',
																				    type:'post',
																				    data:'',
																				    error: function()
																				    {
																				        //alert('file not exists');
																				    },
																				    success: function(data)
																				    {
																				    clearInterval(my_Var1);
																				     $('#msg2').html(data);
																				     var msg5 = document.getElementById("msg2").value;
											         								 var res5 = msg5.split(",");
																				    $('#dtc_report').val(res5[13]);
																				      //$("#dtc_report option[value=" + data[13] + "]").prop("selected",true);
				                                                                      document.getElementById("dtc_interval").value = Math.round(res5[14]);
				                                                                      $('#Config').removeAttr("disabled");
																			   		  delete_file();
																		     		  $('#current_settg').hide();
																		
																				    } 
																				});
		if(count_my_Var1 == 5){
			clearInterval(my_Var1);
			$('#current_settg').hide();
			alert("TImeout !!!. Please read again.");
		}
						                                                    }, 5000); 
						                                                     
					                                                    });     //3052 end

	                                                    }
	                                                    
	                                                });
		if(count_myVar == 12){
			clearInterval(myVar);
			$('#inter_settg').hide();
			alert("TImeout !!!. Please read again.");
		}
	                                            }, 5000);
	                                        });     //3050 end
					            }
				            });

		if(count_myVar1 == 12){
			clearInterval(myVar1);
			$('#qury_sttg').hide();
			alert("TImeout !!!. Please read again.");
		}
			            }, 5000);
		            });     //1003 end
				}
			});
	if(count_my_Var == 12){
		clearInterval(my_Var);
		$('#send_msg').hide();
		alert("TImeout !!!. Please read again.");
	}	
		}, 5000);
	});     //1008 end
}
function myStopFunction() {
	clearInterval(my_Var);
    clearInterval(myVar);
    clearInterval(myVar1);
}
</script>
  <center>
<div style='background:white; font-size: 1.2rem;width: 79%; border-radius: 15px; padding: 5px; border: 2px solid #969090;'>
    <form id='add_conf_tracker' name="add_conf_tracker">
	 	<h1 style="font-size:2.2rem;"><b>Tracker Configuration</b></h1>
	 	<textarea id='msg' style="display:none;"></textarea>
	 	<textarea id='msg1' style="display:none;"></textarea>
	 	<textarea id='msg2' style="display:none;"></textarea>
	 	<div id='send_msg' style="color:red; clear: both; display:none;"><img src="image/spinner.gif" width="20px">SMS Number Setting...</div>
	 	<div id='qury_sttg' style="color:red; clear: both; display:none;"><img src="image/spinner.gif" width="20px">Network settings...</div>
	 	<div id='inter_settg' style="color:red; clear: both; display:none;"><img src="image/spinner.gif" width="20px">Interval and threshold settings...</div>
	 	<div id='Configure_settg' style="color:red; clear: both; display:none;"><img src="image/spinner.gif" width="20px">Configure Port,IP address, Username, Password, APN, SMS number, Protocol and DNS interval...</div>
	 	<div id='cmd_settg' style="color:red; clear: both; display:none;"><img src="image/spinner.gif" width="20px">settings commands for intervals/thresholds...</div>
	 	<div id='current_settg' style="color:red; clear: both; display:none;"><img src="image/spinner.gif" width="20px">current interval and threshold settings...</div>
	 	<div id='Diagt_settg' style="color:red; clear: both; display:none;"><img src="image/spinner.gif" width="20px">Setting Diagnostic Trouble Code...</div>
	    <table style="width: 53vw;margin-bottom:1vh;">
			<tr>
				<td style=""><strong>Name : </strong><?=($obj->DeviceName)?></td>
				<td><strong>MEID DEC : </strong> <?=($obj->DeviceIMEI)?></td>
				<td><strong>Phone : </strong><?=($obj->DevicePhone)?></td>
				<input type="hidden" name="DevicePhone" id="DevicePhone" value="<?=($obj->DevicePhone)?>">
			<tr>
	    </table >
	    <input type="button" class="btn btn-warning" value="READ" style="height:5vh;color:black;margin-bottom:1vh;" onclick='read();'>
	    <table id="trac_info_tab" style="width:69vw;">
		    <tr>      
	            <td><strong class="stg">Tracker Type :</strong></td>
	            <td>
	                <select id="devicetype" name="devicetype" class="sel" style="">
					<option>Xirgo OBDII</option>
	                </select>
	               <!--  <input id="devicetype" name="devicetype" type="text" class="intp" placeholder="Device Type"> -->
	            </td>
	            <td>
	              	<strong class="stg">Heartbeat (Min) :</strong>
	              </td>
	              <td>
	              	<input id="heartbeat" name="heartbeat" type="text" class="intp" placeholder="Heartbeat">
	              </td>
	             
	        </tr>
	        <tr>
	               <td >
	              	<strong class="stg">MEID DEC :</strong>
	              </td>
	              <td>
	              	<input id="meid" name="meid" type="text" class="intp" placeholder="MEID" value=''>
	              </td>
	              <td>
	              	<strong class="stg">Report Ignition On :</strong>
	              </td>
	              <td>
	              	<!-- <input id="report_ing_on" name="report_ing_on" type="text" class="intp" placeholder="Report Ignition On" value=''> -->
	              	<select id="report_ing_on" name="report_ing_on" class="intp">
	              		<option value='0'>Disabled</option>
	              		<option value='1'>Enabled</option>
	              	</select>
	              </td>
	              
	        
	             
	        </tr>
	        <tr>
	        	 <td >
	              	<strong class="stg">IP/DNS :</strong>
	              </td>
	              <td>
	              	<input id="ip_dns" name="ip_dns" type="text" class="intp" placeholder="IP/DNS">
	              </td>
	               <td>
	              	<strong class="stg">Ignition On Reporting Rate (Min) :</strong>
	              </td>
	              <td>
	              	<input id="ing_on_report_rate" name="ing_on_report_rate" type="text" class="intp" placeholder="Ignition On Reporting Rate" value=''>
	              </td>

	              
	             
	        </tr>
	        <tr > <td >
	              	<strong class="stg">Port :</strong>
	              </td>
	              <td>
	              	<input id="port" name="port" type="text"  class="intp" placeholder="Port" value=''>
	              </td>
	              <td>
	              	<strong class="stg">Report Ignition Off :</strong>
	              </td>
	              <td>
	              	<!-- <input id="report_ing_off" name="report_ing_off" type="text" class="intp" placeholder="Report Ignition Off" value=''> -->
	              	<select id="report_ing_off" name="report_ing_off" class="intp">
	              		<option value='0'>Disabled</option>
	              		<option value='1'>Enabled</option>
	              	</select>
	              </td>
	        
	              
	             
	        </tr>
	        <tr > 
	         <td>
	              	<strong class="stg">Protocol :</strong>
	              </td>
	              <td>
	              	<!-- <input id="protocol" name="protocol" type="text"  class="intp" placeholder="Protocol" value=''> -->
	              	<select id="protocol" name="protocol" class="intp">
	              		<!-- <option value='1'>TCP</option> -->
	              		<option value='2'>UDP</option>
	              	</select>
	              </td>
                 <td>
	              	<strong class="stg">Ignition Off Reporting Rate (Min) :</strong>
	              </td>
	              <td>
	              	<input id="ing_off_report_rate" name="ing_off_report_rate" type="text" class="intp" placeholder="Ignition Off Reporting Rate" value=''>
	              </td>
                  <input type="hidden" id='ddd'>
	              
	              
	        </tr>
	        <tr > 
	        	   <td>
	              	<strong class="stg">Speed (MPH) :</strong>
	              </td>
	              <td>
	              	<input id="speed" name="speed" type="text" class="intp" placeholder="Speed" value=''>
	              </td>

	              <td>
	              	<strong class="stg">DTC Reporting :</strong>
	              </td>
	              <td>
	              <!-- 	<input id="dtc_report" name="dtc_report" type="text" class="intp" placeholder="DTC Reporting" > -->
	              	<select id="dtc_report" name="dtc_report" class="intp">
	              		<option value='0'>Disabled</option>
	              		<option value='1'>Enabled</option>
	              	</select>
	              </td>
	              
	              
	             
	             
	        </tr>
	        <tr > <td>
	              	<strong class="stg">Acceleration (MPH/Sec) :</strong>
	              </td>
	              <td>
	              	<input id="acceleration" name="acceleration" type="text" class="intp" placeholder="Acceleration">
	              </td>

	              <td>
	              	<strong class="stg">DTC Interval (Hrs) :</strong>
	              </td>
	              <td>
	              	<input id="dtc_interval" name="dtc_interval" type="text" class="intp" placeholder="DTC Interval">
	              </td>
	              
	              
	              
	        </tr>
	        <tr >  <td>
	              	<strong class="stg">Deceleration (MPH/Sec) :</strong>
	              </td>
	              <td>
	              	<input id="deceleration" name="deceleration" type="text" class="intp" placeholder="Deceleration">
	              </td>
	               <td>
	              	<strong class="stg">Towing Alert :</strong>
	              </td>
	              <td>
	              	<!-- <input id="towing_alert" name="towing_alert" type="text" class="intp" placeholder="Towing Alert"> -->
	              	<select id="towing_alert" name="towing_alert" class="intp">
	              		<option value='0'>Disabled</option>
	              		<option value='1'>Enabled</option>
	              	</select>
	              </td> 
	              
	              
	        </tr>
	        <tr > 
	        	  <td>
	              	<strong class="stg">RPM :</strong>
	              </td>
	              <td>
	              	<input id="rpm" name="rpm" type="text" class="intp" placeholder="RPM">
	              </td>
	              <td>
	              	<strong class="stg">Motion Alert :</strong>
	              </td>
	              <td>
	              	<!-- <input id="motion_alert" name="motion_alert" type="text" class="intp" placeholder="Motion Alert"> -->
	              	<select id="motion_alert" name="motion_alert" class="intp">
	              		<option value='0'>Disabled</option>
	              		<option value='1'>Enabled</option>
	              	</select>
	              </td>
	              
	              
	              
	        </tr>
	        <tr >  <td>
	              	<strong class="stg">Idle :</strong>
	              </td>
	              <td>
	              	<!-- <input id="idle" name="idle" type="text" class="intp" placeholder="Idle"> -->
	              	<select id="idle" name="idle" class="intp">
	              		<option value='0'>Disabled</option>
	              		<option value='1'>Enabled</option>
	              	</select>
	              </td>
	              
	              
	             
	              
	        </tr>
	        <tr > <td>
	              	<strong class="stg">Battery (VDC) :</strong>
	              </td>
	              <td>
	              	<input id="battery" name="battery" type="text" class="intp" placeholder="Battery">
	              </td>

	             
	              
	        </tr>
	        <tr > <td>
	              	<strong class="stg">Mileage :</strong>
	              </td>
	              <td>
	              	<input id="mileage" name="mileage" type="text" class="intp" placeholder="Mileage">
	              </td>
	             <input id="mobile" name="mobile" type="hidden" class="intp" placeholder="Mileage">
	             <input id="dce" name="dce" type="hidden" class="intp" placeholder="Mileage">
	             <input id="dct" name="dct" type="hidden" class="intp" placeholder="Mileage">
	             <input id="apn" name="apn" type="hidden" class="intp" placeholder="Mileage">
	        </tr>
	        <tr>
            
	        </tr>
	    </table>
	    <table style="width:10vw;">
	    	<tr>
	    		<th ><img id='img1' src="image/grey.png"></th>
	    		<th ><img id='img2' src='image/grey.png'></th>
	    		<th ><img id='img3' src='image/grey.png'></th>
	    		<!-- <th ><img id='img4' src='image/grey.png'></th> -->
	    	</tr>	
	    </table></br>	
        <input onclick='config_msg();' type='button'  value="Config" id='Config' class="btn btn-primary" style="margin-bottom:1vh;height:5vh;">
        <a onclick='$("#trip_sheet_div").hide();$("#trip_sheet_div").html("");myStopFunction();' >
        	<input type="button" class="btn btn-primary" value="Close" style="margin-bottom:1vh;height:5vh;">
        </a><br>
       <!--  <textarea id='abc'></textarea> -->
    </from>
</div>
</center>
<script>
var myVar2;
var myVar3;
var myVar4;
function config_msg(){
	$("#img1").attr("src","image/grey.png");
	$("#img2").attr("src","image/grey.png");
	if($('#port').val()=='' && $('#ip_dns').val()=='' && $('#acceleration').val()=='' && $('#deceleration').val()=='')
	{
		alert('Please fill all flields');
	}
	else
	{
			$('#Configure_settg').show();
				 var ntw = $('#msg').val();
		 var ntw_hidn = ntw.split(","); 
		if(ntw_hidn.length==8)
		{
		  netwk = $('#port').val()+','+$('#ip_dns').val()+','+$('#mobile').val()+','+$('#protocol').val()+','+$('#dce').val()+','+$('#dct').val();
           //alert(netwk);
		}
		else if(ntw_hidn.length==9){
         netwk =$('#port').val()+','+$('#ip_dns').val()+','+''+','+''+','+$('#apn').val()+','+$('#mobile').val()+','+$('#protocol').val();
         //alert(netwk);
		}
			$("#img1").attr("src","image/yellow.png");

		$.post("sendmessage_t.php",{phone:$('#DevicePhone').val().trim(),message:'XT:1010,'+netwk},
		function(data) {	/**/
		 	//alert(data);
		 	var count_myVar2 = 0;
		 	myVar2 =setInterval(function(){    
		 		count_myVar2++;   
		        $.ajax({
				    url:'assetsdata_tracker.php',
				    type:'post',
				    data:'',
				    error: function()
				    {
				        //alert('file not exists');
				    },
				    success: function(data)
				    {
				    	//alert(data);
				    	clearInterval(myVar2);
				    	var acc = $('#msg1').val();
		                          var res_hidn = acc.split(",");  
		                          //var last_val = res_hidn[28];


		                          if(res_hidn.length==29) {
		                          var message = $('#ing_on_report_rate').val()+','+$('#report_ing_on').val()+','+$('#ing_off_report_rate').val()+','+$('#report_ing_off').val()+','+$('#dtc_interval').val()+','+$('#speed').val()+','+$('#rpm').val()+','+$('#mileage').val()+','+$('#acceleration').val()+','+$('#deceleration').val()+','+$('#battery').val()+','+
								      res_hidn[13]+','+$('#heartbeat').val()+','+res_hidn[15]+','+$('#idle').val()+','+$('#towing_alert').val()+','+res_hidn[18]+','+res_hidn[19]+','+res_hidn[20]+','+res_hidn[21]+','+$('#motion_alert').val()+','+res_hidn[23]+','+res_hidn[24]+','+res_hidn[25]+','+res_hidn[26]+','+res_hidn[27]+','+res_hidn[28].replace(/##/g, "");

								  }
								  else if(res_hidn.length==21){
                                     var message = $('#ing_on_report_rate').val()+','+$('#report_ing_on').val()+','+$('#ing_off_report_rate').val()+','+$('#report_ing_off').val()+','+$('#dtc_interval').val()+','+$('#speed').val()+','+$('#mileage').val()+','+$('#acceleration').val()+','+$('#deceleration').val()+','+$('#battery').val()+','+
								      res_hidn[12]+','+res_hidn[13]+','+res_hidn[14]+','+$('#heartbeat').val()+','+res_hidn[16]+','+res_hidn[17]+','+res_hidn[18]+','+$('#idle').val()+','+0+','+0+','+0+','+0+','+0+','+res_hidn[20].replace(/##/g, "");
								  }
						 	var result = data.split(","); 
						 	//alert(message);
				    	      delete_file();
						 	if(result.length!=3)
						 	{       
						 		    $('#Configure_settg').hide();
						 		    $("#img1").attr("src","image/green.png");
						 		    $('#cmd_settg').show();
								 	
								$.post("sendmessage_t.php",{phone:$('#DevicePhone').val().trim(),message:'XT:3040,'+message},
								function(data) {/**/
								 // alert(data); 
								 var count_myVar3 = 0;
								  var messg = $('#dtc_report').val()+','+$('#dtc_interval').val();
								    myVar3 =setInterval(function(){  
								    	count_myVar3++;
								        $.ajax({
										    url:'assetsdata_tracker.php',
										    type:'post',
										    data:'',
										    error: function()
										    {
										        //alert('file not exists');
										    },
										    success: function(data)
										    {
										    	//alert(data);
										    	clearInterval(myVar3);
												 	var rsp_msg =  data.split(",");  
												 	if(rsp_msg.length!=3)
												 	{
												 	  $("#img2").attr("src","image/green.png");
												    }
												    else
												    {
												      	$("#img2").attr("src","image/red2.png");
												      	//$('#cmd_settg').hide();
												    }
												      delete_file();
												     $('#cmd_settg').hide();
												     $("#img3").attr("src","image/yellow.png"); 
                                                      $('#Diagt_settg').show(); 
                                                      $.post("sendmessage_t.php",{phone:$('#DevicePhone').val().trim(),message:'XT:3027,'+messg},
								                          function(data) {/**/
								                          	var count_myVar4 = 0;
                                                            myVar4 =setInterval(function(){  
                                                            	count_myVar4++;
														        $.ajax({
																    url:'assetsdata_tracker.php',
																    type:'post',
																    data:'',
																    error: function()
																    {
																        //alert('file not exists');
																    },
																    success: function(data)
																    {
																    	//alert(data);
																    	clearInterval(myVar4);
																		 	var data_msg =  data.split(",");  
																		 	if(data_msg.length!=3)
																		 	{
																		 	  $("#img3").attr("src","image/green.png");
																		    }
																		    else
																		    {
																		      	$("#img3").attr("src","image/red2.png");
																		      	//$('#cmd_settg').hide();
																		    }
																		      delete_file();
																		     $('#Diagt_settg').hide();
																		    
														             } 
														        });
	if(count_myVar4 == 12){
		clearInterval(myVar4);
		 $('#Diagt_settg').hide();
		alert("TImeout !!!. Please config again.");
	}
									                        }, 5000); 

								                         });       //3027 end

										    }
										});
	if(count_myVar3 == 12){
		clearInterval(myVar3);
		$('#cmd_settg').hide();
		alert("TImeout !!!. Please config again.");
	}
									}, 5000);
								});     //3040 end

								$("#img2").attr("src","image/yellow.png");

						    }
						    else
						    {
						      	$("#img1").attr("src","image/red2.png");
						        $('#Configure_settg').hide();
						    }
						     
				    }
				});
	if(count_myVar2 == 12){
		clearInterval(myVar2);
		$('#Configure_settg').hide();
		alert("TImeout !!!. Please config again.");
	}
			}, 5000);
		});      //1010 end
	}
}
</script>