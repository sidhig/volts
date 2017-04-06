
<?
  session_start();
   date_default_timezone_set('US/Eastern');
 include_once('connect.php');
?>
<style>
.font{
font-size:1.2rem;
width:5vw; 
}
.font_lable{
font-size:1.2rem;
width: 10vw;" 
}
</style>
<script>
$('#imeidl,#imeidld').multiselect({
  enableCaseInsensitiveFiltering:true,
  includeSelectAllOption: true,
           enableFiltering:true,
       numberDisplayed: 2
});

$('#imeidl').change(function(){ 
  $('#imeidld').each(function() {
      $(this).multiselect('deselect', $(this).val());
  });
});

$('#imeidld').change(function(){ 
  $('#imeidl').each(function() {
      $(this).multiselect('deselect', $(this).val());
  });
});
</script>
  <!--<script src="js/jquery.min.js"></script>
  <script src="//cdn.jsdelivr.net/webshim/1.14.5/polyfiller.js"></script>
<script>
    webshims.setOptions('forms-ext', {types: 'date'});
webshims.polyfill('forms forms-ext');
</script>-->
<script>
  <? include_once('setmarkerhistory.php'); ?></script>
<center>
 <table width="95%" border='0' cellpadding="10">
 <tr>
 <th class="font" style='text-align: left;  width: 12%;' >Start Date: <input type="date" class="form-control font_lable" id="sdate" value="<?=date('Y-m-d', strtotime("-1 day"))?>" style="width: 11vw;"> 
 </th>
 <th class="font" style='text-align: left; width: 12%;' >Start Time: <input type="time" class="form-control font_lable" id="stime" value='<?=date("H:i", strtotime("-24 hour"))?>' style="width: 9vw;"> 
 </th>
 <th class="font" style='text-align: left; width: 12%;' >End Date: <input type="date" class="form-control font_lable"  id="edate" value="<?=date('Y-m-d')?>" style="width: 11vw;"> 
 </th>
 <th class="font" style='text-align: left; width: 12%;' >End Time: <input type="time" class="form-control font_lable" id="etime" value="<?=date('H:i')?>" style="width: 9vw;"> 
 </th>
 <th class="font" style='text-align: left; width: 12%;'> Equip:<br/> <!--<input id="imeidl" class="form-control font_lable" class="form-control" type="text" list="dldev" style="width: 9vw;"/>-->
 <select id = "imeidl"  class="form-control" multiple="multiple">
 <!--<datalist id="dldev">-->
   <?php
    $result = "select DeviceName ,deviceimei from devicedetails where UserName = 'GPC' and CASE WHEN (select dept  as eqpval  from roletable where username = '".$_SESSION['LOGIN_user']."') = 'All' THEN 1 ELSE (select dept from roletable where username = '".$_SESSION['LOGIN_user']."') like CONCAT('%', department, '%')  END and  CASE WHEN (select `group`  as eqpval  from roletable where username = '".$_SESSION['LOGIN_user']."') = 'All' THEN 1 ELSE (select `group` from roletable where username = '".$_SESSION['LOGIN_user']."') like CONCAT('%', `group`, '%')  END order by DeviceName";
     $result = $conn->query($result);
     while($vehicle = $result->fetch_object())
     {
     ?>
     <!--<option data-value="<?//=$vehicle->deviceimei?>" value="<?//=$vehicle->DeviceName?>" ></option>-->
   <option value="<?=$vehicle->deviceimei?>"><?=$vehicle->DeviceName?></option>
    <?  }  ?>
     <!--</datalist>-->
 </th>
 <th class="font" style='text-align: left; width: 12%;'> Driver:<br/> <!--<input id="imeidld" class="form-control font_lable" type="text" list="dldevd" style="width: 9vw;" />
<datalist id="dldevd">-->
<select id="imeidld" class="form-control" multiple="multiple">
   <?php
     $result ="select concat(driver_name ,'(',DeviceName,')') as DeviceName ,deviceimei from devicedetails where UserName = 'GPC' and CASE WHEN (select dept  as eqpval  from roletable where username = '".$_SESSION['LOGIN_user']."') = 'All' THEN 1 ELSE (select dept from roletable where username = '".$_SESSION['LOGIN_user']."') like CONCAT('%', department, '%')  END and  CASE WHEN (select `group`  as eqpval  from roletable where username = '".$_SESSION['LOGIN_user']."') = 'All' THEN 1 ELSE (select `group` from roletable where username = '".$_SESSION['LOGIN_user']."') like CONCAT('%', `group`, '%')  END order by DeviceName";
     $result = $conn->query($result);
     while($vehicle = $result->fetch_object())
     {
     ?>
     <!--<option data-value="<?=$vehicle->deviceimei?>" value="<?=$vehicle->DeviceName?>" ></option>-->
   <option value="<?=$vehicle->deviceimei?>"><?=$vehicle->DeviceName?></option>
    <?  }  ?>
     <!--</datalist>-->
 </th>
 <th style='text-align: left; width: 10%;'><input id="hisdeviceimei" type="hidden" />&nbsp;<br> <input type="button" id="go_btn" value="Go" style="background-color: #4CAF50; 
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;">
 </th>

  <script>
     var history_val = false;
     var ispaused = false;
     var isnext   = false;
     var isprevious  = false;
     var isstartover = false;
     var ishistoryrunning = false;
     var speed_anim = 600;
     var isstartend = false;
     var isbreadcrumps= false;
    


function initializehis(siteshistory,issingle) 
    {
    // document.getElementById("historybut").style.display = 'block';
     ispaused = false;
    history_val = true; 
    var centerMap = new google.maps.LatLng(siteshistory[0][2], siteshistory[0][3]); 
    var zoomval = map.getZoom();
    var centerMap = map.getCenter();
    var myMapType = map.getMapTypeId();
    
    var myOptions =
    {
     zoom: zoomval,
     center: centerMap,
     mapTypeId: myMapType
    }
  var test = new Array();
     map = new google.maps.Map(document.getElementById("map-canvas1"), myOptions);
    setMarkershistory(map, siteshistory,true,issingle,false);
    infowindow = new google.maps.InfoWindow({
      content: "loading..."
     });

    var bikeLayer = new google.maps.BicyclingLayer();
    bikeLayer.setMap(map);
    //alert("Updating Map");
   }



   
$('#bread:checkbox').change(function() {
if($(this).is(":checked")) 
{
  isbreadcrumps = true;
}
else
{
  isbreadcrumps = false;
}

});
   function speed_change(a)
{
 if(a==0){ speed_anim = 100; }
 else if(a==1){ speed_anim = 400; }
 else if(a==2){ speed_anim = 800; }
}



$( "#go_btn").on('click', function() {
  //alert($('#imeidl').val());
 if($('#imeidl').val() == null && $('#imeidld').val() == null)
 {
  alert('Please select valid Driver/Equip');
 }
 else
 {  if($('#imeidl').val() != null){
      var veh_imei = String($('#imeidl').val());
    }else{
      var veh_imei = String($('#imeidld').val());
    }
  var imei_arr = veh_imei.split(',');
  var str = '';
  for(var i=0;i< imei_arr.length;i++){
    str += "'"+imei_arr[i]+"',";
  }
  //alert(str.replace(/,\s*$/, ""));
  isstartend = true;//alert(veh_imei);
  document.getElementById("dev_det").innerHTML='<strong><img src="image/spinner.gif" width="20px">Please wait while getting history...</strong>';
  $.post( "vehicle_history_qry.php",{ imei:str.replace(/,\s*$/, ""), start: $("#sdate").val()+" "+$("#stime").val(), end: $("#edate").val()+" "+$("#etime").val() },function(data) {  
  siteshistory = $.parseJSON(data);
  //alert(siteshistory);
  if(siteshistory=='')
   { 
     document.getElementById("dev_det").innerHTML="<span style='color:red;' >No History Found.</span>";
   }
   else 
   {
    // $("#map-canvas1").html(siteshistory);
     //alert(siteshistory);
     initializehis(siteshistory,false);
     $('#pause_but').attr('src', "image/pause.png");
   }
 
  });
 }
});


function pause_resume() 
{

  ispaused = !ispaused; 
  if (ispaused)
  {
    $('#pause_but').attr('src', "image/play.png");
  }
  else
  {
    $('#pause_but').attr('src', "image/pause.png");
  }

}


function start_resume()
{
  isstartover = true;
  ispaused = false; 
  $('#pause_but').css('src', "image/pause.png");
  
}

function start_next()
{

  ispaused = true;
  isnext = true;
  if (ispaused)
  {
    $('#pause_but').attr('src', "image/play.png");
  }
}

function start_prv()
{
  

  ispaused = true;
  isprevious = true;
  if (ispaused)
  {
    $('#pause_but').attr('src', "image/play.png");
  }
  else
  {
    $('#pause_but').attr('src', "image/pause.png");
  }
}

  </script>
 <th class="font" style='text-align: center; width: 12%;'>
  <div id="historybut" style="width:6vw; height: 6vh; margin-top:3vh;" >
    <img id="prv_but" style="width:1.6vw; cursor:pointer;" src = 'image/prev.png' onclick="start_prv();" > 
    <img id="pause_but" style="width:1.6vw; cursor:pointer;" src = 'image/pause.png' onclick="pause_resume();" > 
    <img id="next_but" style="width:1.6vw; cursor:pointer;" src = 'image/next.png' onclick="start_next();" >
  </div>
 </th>
 <th class="font">Speed: <input type="range" value="" min="0" max="2" onchange="speed_change(this.value);"> 
  <div> <input id="bread" type="checkbox" > Breadcrumbs</div>
 </th>
 </tr>
 <tr style='text-align: center; width: 5%;'><td colspan="9" align="center"><span id="dev_det" style="background-color: #FFFFFF; 
    border: none;
    color: black;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;"><!--<strong>Please wait while getting history...</strong>--></span></td>
 </tr>
 </table>
 <div id="map-canvas1" style="min-height:62vh!important;"></div>
 </center>