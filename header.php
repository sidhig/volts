<? session_start(); 
//echo $_SESSION['LOGIN_main_role'];
?>
<html lang="en">
<head>
  <title>VOLTS</title>
  <link rel="image icon" type="image/png" sizes="160x160" href="image/icon.png">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="css/bootstrap-multiselect.css"> 
  <link rel="stylesheet" href="css/style.css"> 
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css">
  <script src="js/bootstrap-multiselect.js"></script>

  <script>
    $(document).ready(function() {
      $('#opco,#primary,#group').multiselect({
        includeSelectAllOption: true,
        selectAllText: 'All',
         numberDisplayed: 1
      }); 
      $('#dept').multiselect({
        includeSelectAllOption: true,
        selectAllText: 'All',
         numberDisplayed: 0
      }); 
      
      $('#poi,#eqp').multiselect({
        includeSelectAllOption: true,
        selectAllText: 'All',
         numberDisplayed: 0
      }); 
      $("#dyn_back").draggable ({
        axis : "y"
      });
   /* $("#uni_back").on("click",function() {
      if(backarray[backarray.length-1] != $("#city").val()){
        myarray.push($("#city").val());
      }
        alert(myarray);
    });*/

      $("#dyn_back").on("click",function() {
    if(backarray.length>1){
      backarray.pop();
    }
        if(backarray.length==1){
      $('#dyn_back').hide('slide', { direction: 'left' }, 1000);
    }
        view_change(backarray[backarray.length-1]);
    $("#sel_view").val(backarray[backarray.length-1]);
    });
 
    $("#sel_view").change(function(){
      $('#dyn_back').show('slide', { direction: 'left' }, 1000);
      view_change($("#sel_view option:selected").text());
      if(backarray[backarray.length-1] != $("#sel_view option:selected").text()){
            backarray.push($("#sel_view option:selected").text());
            }
    });

  
    function wait_for_filter(){
      setTimeout(function(){
       imei_arr = [];//alert(LocationData);
             initialize_both(LocationData,substationData); 
      },1500);
    } 
    
    $('#opco').change(function(){
      var comp_id = $(this).val();
      if(comp_id != null){
         comp_id = comp_id.join();
        $.post('head_filt_qry.php',{for:'company',comp_id:comp_id},function(data){
          //alert(data);
          $('#data').html('');
          $('#data').html(data);
        });
      }else{
        $('#primary option').each(function(index, option) {
          $(option).remove();
        });
        $('#primary').multiselect('rebuild');
        $('#group option').each(function(index, option) {
          $(option).remove();
        });
        $('#group').multiselect('rebuild');
        $('#dept option').each(function(index, option) {
          $(option).remove();
        });
        $('#dept').multiselect('rebuild');
      }
       wait_for_filter();
    });
    
    $('#primary').change(function(){
      var sec_id = $(this).val();
      if(sec_id != null){
         sec_id = sec_id.join();
      
      $.post('head_filt_qry.php',{for:'section',comp_id:$("#opco").val().join(),sec_id:sec_id},function(data){
        //alert(data);
        $('#data').html('');
        $('#data').html(data);
      });
      }else{
        $('#group option').each(function(index, option) {
          $(option).remove();
        });
        $('#group').multiselect('rebuild');
        $('#dept option').each(function(index, option) {
          $(option).remove();
        });
        $('#dept').multiselect('rebuild');
 
      }
      wait_for_filter();
      
    });
    

      $('#group').change(function(){
      var bu_id = $(this).val();
      if(bu_id != null){
         bu_id = bu_id.join();
  
      $.post('head_filt_qry.php',{for:'bu',comp_id:$("#opco").val().join(),sec_id:$("#primary").val().join(),bu_id:bu_id},function(data){
        //alert(data);
        $('#data').html('');
        $('#data').html(data);
      });
      }else{
        $('#dept option').each(function(index, option) {
          $(option).remove();
        });
        $('#dept').multiselect('rebuild');

      }
      wait_for_filter();
    });
    
    $('#dept').change(function(){
     var loc_id = $(this).val();
      if(loc_id != null){
         loc_id = loc_id.join();
     
      $.post('head_filt_qry.php',{for:'location',comp_id:$("#opco").val().join(),sec_id:$("#primary").val().join(),bu_id:$("#group").val().join(),loc_id:loc_id},function(data){
        //alert(data);
        $('#data').html('');
        $('#data').html(data);
      }); 
      }
       wait_for_filter();
    });  
      


   $('#poi').change(function() 
     {
          savedMapZoom=map.getZoom(); 
          mapCentre=map.getCenter(); 
          mapLat=mapCentre.lat(); 
          mapLng=mapCentre.lng();
        //imei_arr = [];
        $("#d_map").val('');
        $('#poi_spinner').show();
       // alert($('#poi').val());
        if($('#poi').val()!=null)
      {
        if(substationData==null){
        $.ajax({
           type: "POST",
           url: "substations.php",
           data: '',
           cache: false,
           success: function(result){
           substationData = $.parseJSON(result);
           set_center_map();
           
           initialize_single(LocationData,substationData);
           $('#poi_spinner').hide(); 
           }
          });
        }
        else
        {
            substfinalarray = filter_eqptype($('#poi').val(),substationData,4);
           // set_center_map();
          
             initialize_single(LocationData,substationData);
             $('#poi_spinner').hide(); 
        }
          }
      else
      {
                   // set_center_map();
                     initialize_single(LocationData,substationData);
                 $('#poi_spinner').hide(); 
         }
         
      });

});

</script>

<script>
$(document).ready(function(){
  $("#d_map").attr('disabled', 'disabled');
$('#clear_searchtext').click(function(){
  is_search = false;
   initialize_both(LocationData,substationData);
   imei_arr = [];//for zoom one
    $('.multiselect').removeAttr("disabled");
    $("#d_map").val('');
  $('#clear_searchtext').hide();
});

$('#sel_type').change(function()
     {
      
      $("#d_map").val('');
    $("#d_map").attr('disabled', 'disabled');
      $('.multiselect').removeAttr("disabled");
      $('#clear_searchtext').hide();
              
      if($('#sel_type option:selected').val()=='POI')
      {
        if(substationData == null)
          {
               $.ajax({
                 type: "POST",
                 url: "substations.php",
                 data: '',
                 cache: false,
                 success: function(result){
                 substationData = $.parseJSON(result);
         $("#d_map").removeAttr("disabled");
                  
                 }
                });
          }
          $('#type_spinner').show();
            if(copy_poi_opt == ""){
                $.post( "sch_type.php",{type:'POI'},function(data) {
                 copy_poi_opt = data;
                $("#mapdev").html(data);
                $('#type_spinner').hide();
                $("#d_map").removeAttr("disabled");
                });
        }
        else
        {
          $("#mapdev").html(copy_poi_opt);
          $('#type_spinner').hide();
       $("#d_map").removeAttr("disabled");
        }
      }
    
    
        
    if($('#sel_type option:selected').val()=='Equipment Type'){
         $('#type_spinner').show();
              if(copy_equip_opt==""){
                $.post( "sch_type.php",{type:'Equipment'},function(result) {
                 eqp_data = $.parseJSON(result);
                 //alert(eqp_data);
                 
                  for(var i = 0; i < eqp_data.length; i++)
                  options += '<option value="'+eqp_data[i]+'" />';
                copy_equip_opt = options;
                //alert(copy_equip_opt);
                  document.getElementById('mapdev').innerHTML = options;
                 //document.getElementById('poidev').innerHTML = options; 
                  $('#type_spinner').hide();
           $("#d_map").removeAttr("disabled");
        
                }); 
              }
              else
          {  //alert(copy_opt);
                //options += '<option value="'+eqp_data[i]+'" />';
                document.getElementById('mapdev').innerHTML = copy_equip_opt;
                //$('#poidev').show();
                $('#type_spinner').hide();
         $("#d_map").removeAttr("disabled");
          } 
      
    }
     if($('#sel_type option:selected').val()=='Driver name'){
      $('#type_spinner').show();
      if(copy_driv_opt==""){
            $.post( "sch_type.php",{type:'Driver'},function(data) {
              //alert(data);
              copy_driv_opt=data;
             $("#mapdev").html(data);
             $('#type_spinner').hide();
        $("#d_map").removeAttr("disabled");
            });
          }else{
             $("#mapdev").html(copy_driv_opt);
             $('#type_spinner').hide();
        $("#d_map").removeAttr("disabled");
          }
       
    }
    if($('#sel_type option:selected').val()=='Unit'){
      $('#type_spinner').show();
      if(copy_unit_opt==""){
            $.post( "sch_type.php",{type:'unit'},function(data) {
              //alert(data);
              copy_unit_opt=data;
             $("#mapdev").html(data);
             $('#type_spinner').hide();
        $("#d_map").removeAttr("disabled");
            });
        }else{
             $("#mapdev").html(copy_unit_opt);
             $('#type_spinner').hide();
        $("#d_map").removeAttr("disabled");
        }
     
    }
    if($('#sel_type option:selected').val()=='Crew'){
      $('#type_spinner').show();
      if(copy_crew_opt==""){
            $.post( "sch_type.php",{type:'crew'},function(data) {
              //alert(data);
              copy_crew_opt=data;
             $("#mapdev").html(data);
             $('#type_spinner').hide();
        $("#d_map").removeAttr("disabled");
            });
          }else{
             $("#mapdev").html(copy_crew_opt);
             $('#type_spinner').hide();
        $("#d_map").removeAttr("disabled");
          }
       
    }
if($('#sel_type option:selected').val()=='Tag#'){
      $('#type_spinner').show();
       if(copy_tag_opt==""){
            $.post( "sch_type.php",{type:'tag'},function(data) {
              //alert(data);
              copy_tag_opt=data;
             $("#mapdev").html(data);
             $('#type_spinner').hide();
        $("#d_map").removeAttr("disabled");
            });
          }else{
             $("#mapdev").html(copy_tag_opt);
             $('#type_spinner').hide();
        $("#d_map").removeAttr("disabled");
          }
       
    }


});



 $("#d_map").on("input", function(){
      show_custom = 1; 
        is_search = true;
    if($("#d_map").val()!=''){

     //multiselect dropdown-toggle btn btn-default
       $('.multiselect').attr('disabled', 'disabled');
         $('#clear_searchtext').show();//sel_type
         if($('#sel_type option:selected').val()=='Equipment Type'){

            var test_arr = new Array();
            test_arr[0] = $("#d_map").val();
             initialize_both(filter_veh_search(test_arr[0],LocationData),substationData);
          }
          else if($('#sel_type option:selected').val()=='Driver name'){

            var test_arr = new Array();
            test_arr[0] = $("#d_map").val();
            filterdata_search = filter_eqptype(test_arr,LocationData,24);
            //sites_Search = filterdata_search[0];
             initialize_both(filterdata_search,substationData);
          }
         else if($('#sel_type option:selected').val()=='Unit#'){
            var test_arr = new Array();
            test_arr[0] = $("#d_map").val();
            filterdata_search = filter_eqptype(test_arr,LocationData,41);
            //sites_Search = filterdata_search[0];
            initialize_both(filterdata_search,substationData);
            //map.setCenter(new google.maps.LatLng(sites_Search[3], sites_Search[4]));
            //map.setZoom(19);
          }
          else if($('#sel_type option:selected').val()=='Crew'){
            var test_arr = new Array();
            test_arr[0] = $("#d_map").val();
            filterdata_search = filter_eqptype(test_arr,LocationData,42);
            //alert(filterdata_search);
            //sites_Search = filterdata_search[0];
            initialize_both(filterdata_search,substationData);
           // map.setCenter(new google.maps.LatLng(sites_Search[3], sites_Search[4]));
            //map.setZoom(21);
          }
          else if($('#sel_type option:selected').val()=='Tag'){
            var test_arr = new Array();
            test_arr[0] = $("#d_map").val();
            filterdata_search = filter_eqptype(test_arr,LocationData,49);
           //sites_Search = filterdata_search[0];
            initialize_both(filterdata_search,substationData);
            //alert(sites_Search);
            //map.setCenter(new google.maps.LatLng(sites_Search[3], sites_Search[4]));
            //map.setZoom(21);
          }
          else if($('#sel_type option:selected').val()=='POI')
          {
            if(substationData==null)
            {
        
                $.ajax({
                     type: "POST",
                     url: "substations.php",
                     data: '',
                     cache: false,
                     success: function(result){
                      substationData = $.parseJSON(result);
                      var test_arr = new Array();
                      test_arr[0] = $("#d_map").val();
                      filterdata_search = filter_eqptype(test_arr,substationData,1);
                      if(filterdata_search.length>0)
                      {
                       initialize_poi(filterdata_search);
                        //initialize(LocationData);
                      }
                      sites_Search = filterdata_search[0];
                      map.setCenter(new google.maps.LatLng(sites_Search[2], sites_Search[3]));
                      map.setZoom(19);
                     }
                  });

            }
            else
            {

              var test_arr = new Array();
              test_arr[0] = $("#d_map").val();
              filterdata_search = filter_eqptype(test_arr,substationData,1);
              if(filterdata_search.length>0)
              {
                       initialize_poi(filterdata_search);
              }
              sites_Search = filterdata_search[0];
              map.setCenter(new google.maps.LatLng(sites_Search[2], sites_Search[3]));
              map.setZoom(19);

            }
           
          }
        }
        else
        { 
         $('.multiselect').removeAttr("disabled");
          $('#clear_searchtext').hide();
      var sec = []; 
      $('#primary :selected').each(function(i, selected){ 
        sec[i] = $(selected).text(); 
      });
      var bu = []; 
      $('#group :selected').each(function(i, selected){ 
        bu[i] = $(selected).text(); 
      });
      var loc = []; 
      $('#dept :selected').each(function(i, selected){ 
        loc[i] = $(selected).text(); 
      });
      
               /*initialize(
                    filter_eqptype($('#eqp').val(),
                      filter_eqptype(loc,
                        filter_eqptype(sec,
                          filter_eqptype(bu,filter_eqptype(wrkgrp,
                            LocationData,51),26),28),29),21)
                    ); */
               initialize_both(LocationData,substationData);
                  if($('#poi').val()!=null && substationData!=null)
                    initialize_poi(filter_eqptype($('#poi').val(),substationData,4));
                    //initialize_both(LocationData,substationData);

        }
        
    });
});
</script>
  <style>
  body{
    background-color: #d6dce2;
  }
      footer {
      color:black;
     padding-top: 1vh;
     padding-bottom: 3vh;
      background-color: white;
      border: 1px solid #BBBBBB;
      width:98%;
    }
    
    .navbar-inverse {
    background-color: white;
    border: 1px solid #BBBBBB;
    width:98%;
    margin-top: .2vh;
    margin-bottom: 0vh;
    /*height: 15vh;*/
     }
.container{
   
    margin-bottom: .3vh;
    width:98%;
  
    background-color:white;
    padding-top: 8px;
    padding-bottom: 8px;
    padding-left: 8px;
    padding-right: 8px;
    border: 1px solid #BBBBBB;
  }
  .navbar-nav>li>a {
    padding-top: 3px;
    padding-bottom: 4px;
}
.btn {
    display: inline-block;
    padding: 0px 11px;
    }
 .form-control {
  height: 25px;
  padding: 3px 6px; 
 }   
 
.container-fluid>.navbar-header{
      margin-top: 1vh;
    }
/*select[multiple], select[size] {
    height: 16px!important;
}*/
.multiselect-container>li>a>label{
      height:auto;
    }
  .multiselect-container{
      max-height: 50vh;
    overflow: auto;
  }
   /*.container-fluid
{ 
min-height:14vh;
}*/
    label.checkbox:hover{
color:black;
    }
     label.checkbox{
color:black;
background-color: #D9DDE0;
    }
    .navbar-inverse .navbar-nav .open .dropdown-menu>.active>a, .navbar-inverse .navbar-nav .open .dropdown-menu>.active>a:focus, .navbar-inverse .navbar-nav .open .dropdown-menu>.active>a:hover{
     background-color: #9d9d9d;
    }
  </style>
</head>
<body>

<center><nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
       <img src="image/icon.png" style="float:left;width:27px;height:26px;font-size:2vw;margin-top:.5vh;" align="center">&nbsp;<b style="font-size:1.8rem;">VOLTS<b>
    </div>  
    
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a style=""></a></li>
        <li><a style="color:black;margin-top:1vh;font-size:1.6rem;"><b><? echo"User: " .$_SESSION['LOGIN_name']  ;?></b></a></li>
        <li><a href="logout.php" style="color:black;margin-top:1vh;font-size:1.6rem;background-color: #FFFF04;" id="a1" class="btn btn-primary"><b>Logout</b></a></li>
      </ul><br>
      
      <ul class="nav navbar-nav">

        <li><a style="color:black;font-size:1.2rem;"><b>Company</b>
    <select name="opco" id="opco" multiple="multiple" size="1" >
              <?  
                  $sql = $conn->query("SELECT * from role_opco where if('".$_SESSION['ROLE_opco']."'='0',1,id in (".$_SESSION['ROLE_opco'].")) order by name asc");
                  while($obj = $sql->fetch_object()){
              ?>
                  <option value="<?=$obj->id?>" selected ><?=$obj->name?></option>
              <?   } 
              ?>
            </select>

        </a></li>
        <li><a style="color:black;margin-left:4vh;font-size:1.2rem;"><b>Section</b>
      <select name="" id="primary" multiple="multiple" size="1" >
              <?  
                  $sql = $conn->query("SELECT * from role_primary where if('".$_SESSION['ROLE_primary']."'='0',1,id in (".$_SESSION['ROLE_primary'].")) order by name asc");
                  while($obj = $sql->fetch_object()){
              ?>
                  <option value="<?=$obj->id?>" selected ><?=$obj->name?></option>
              <?   } 
              ?>
            </select>
        </a></li>
        <li>
          <a style="color:black;margin-left:4vh;font-size:1.2rem;"><b>Business Unit</b>
      <select name="" id="group" multiple="multiple" size="1" >
              <?  
                  $sql = $conn->query("SELECT * from role_group where if('".$_SESSION['ROLE_group']."'='0',1,id in (".$_SESSION['ROLE_group'].")) order by name asc");
                  while($obj = $sql->fetch_object()){
              ?>
                  <option value="<?=$obj->id?>" selected ><?=$obj->name?></option>
              <?   } 
              ?>
            </select>
           
          </a>   
        </li>     
          <li style="min-width:8vw;">
          <a style="color:black;margin-left:4vh;font-size:1.2rem;"><b>Location</b>
      <select name="" id="dept" multiple="multiple" size="1" >
              <?  
                  $sql = $conn->query("SELECT * from role_dept where if('".$_SESSION['ROLE_dept']."'='0',1,id in (".$_SESSION['ROLE_dept'].")) order by name asc");
                  while($obj = $sql->fetch_object()){
              ?>
                  <option value="<?=$obj->id?>" selected ><?=$obj->name?></option>
              <?   } 
              ?>
            </select>
            
          </a>   
        </li>
       <!-- <li style="min-width:8vw;">
          <a style="color:black;font-size:1.2rem;margin-left:4vh;"><b>Workgroup</b>
            <select name="" id="workgroup" multiple="multiple" size="1" >
             <?  
                 /* $sql = $conn->query("SELECT * from tbl_workgroup where if('".$_SESSION['ROLE_wrokgroup']."'='0',1,id in (".$_SESSION['ROLE_wrokgroup'].")) order by name asc
");
                  while($obj = $sql->fetch_object()){
              ?>
                <option value="<?=$obj->id?>" selected ><?=$obj->name?></option>
                <?   } */
              ?>
              
            </select>
          </a>   
        </li>            
        <li >-->
          </ul>
      <ul class="nav navbar-nav" style="margin-bottom: 0vh;">
        <li>
          <a style="color:black;font-size:1.2rem;margin-left:2vw;"><b>Equipment</b>
      <select name="" id="eqp" multiple="multiple" size="1" >
              <?  
                  $sql = $conn->query("SELECT * from tbl_eqptype where if('".$_SESSION['ROLE_eqp']."'='0',1,id in (".$_SESSION['ROLE_eqp'].")) order by eq_name asc");
                  while($obj = $sql->fetch_object()){
              ?>
                  <option selected ><?=$obj->eq_name?></option>
              <?   } 
              ?>
            </select>
          </a>
        </li>    
        <li >
         <a style="color:black;margin-left: 1vw;font-size:1.2rem;margin-right: 3vw;">POIs 
          <select id="poi" multiple="multiple" size="1">
<?php
       $result = $conn->query("select * from substation_more group by `type` order by `type`");
       while($substation = $result->fetch_object())
       {
       ?>
       <option value="<?=$substation->type?>" ><?=$substation->type?></option>
      <?  }  ?>
          </select><image id='poi_spinner' src="image/loading.gif" style='display:none;' width="7%"></a>  
        </li>
        <li style="min-width:15vw;    margin-left: -3vw;">
        <a>
          <label class="control-label col-sm-1 text-left"  style=" width:18%;font-size:1.2rem;padding-right: 33px;padding-left: 0px;color:black;">View</label>
            <select id="sel_view" class="form-control" style="padding:0px 11px;width:75%;color:black;font-size:1.2rem;font-weight:normal;">
              <?  
                  $sql = $conn->query("(SELECT * from role_view where if('".$_SESSION['ROLE_view']."'='0',1,id in (".$_SESSION['ROLE_view'].")) )  order by name asc");
                  while($obj = $sql->fetch_object()){
              ?>
                  <option <? if($obj->name=='Map'){?>selected<? } ?> ><?=$obj->name?></option>
              <?   } 
              ?>
            </select>
        </a>
        </li>
        <li style="font-size:1.4rem;margin-top: .5vh;">Filter</li>
        <li style="min-width:15vw;">
        <a><label class="control-label col-sm-1 text-left"  style=" width:18%;font-size:1.2rem;padding-right: 33px;padding-left: 0px;color:black;">By</label>
            <select name="sel_type" id="sel_type" class="form-control" style="padding:0px 11px;width:75%;color:black;font-size:1.2rem;font-weight:normal;">
                 <option >Type</option>
                 <option >Equipment Type</option>
                 <option >Driver name</option>
                 <option >Unit</option>
                 <option >Crew</option>
                 <option >Tag#</option>
                 <option >Work Group</option>
            </select>
        </a>
        </li>
        <li style="margin-left:0vw;">
          <label class="control-label col-sm-1 text-left"  style=" width:18%;font-size:1.2rem;padding-right: 0px;padding-left: 0px;padding-top: .8vh;color:black;">For</label>  
          <div class="col-sm-2" style="width: 82%;margin-top:.3vh;padding-right: 0px;padding-left: 0px;margin-left: -1vw;"> 
          <input id="d_map" type="text" class="form-control" list="mapdev" placeholder="" style="width: 83%;font-size:1.2rem;">
         
       <span><image id='type_spinner' src="image/loading.gif" style='float:right;width:8%;margin-top:-3vh;display:none;' ><image id='clear_searchtext' src="image/error.png" style='float:right;width:8%;margin-top:-3vh;display:none;'></span>
      </div>
    <datalist id="mapdev">
      <!-- <option value='<?=$eqp_data?>' /> -->
    </datalist>
     <span id="poidev" style="display:none;">
      <?=$eqp_data?>
    <!--  <?if($all_eqp=='Equipment'){?>
           
           <option value='<?=$all_data?>' />
              
          
  <?}?>
 -->
    </span>
    
    </center>  
<span id="data" style="display:none;"></span>
<div class="container" style="margin-top: .1vh;">
                  
