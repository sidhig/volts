<?session_start();
 include_once('connect.php');?>
   <script src="js/bootstrap-multiselect.js"></script>
   <link rel="stylesheet" href="css/bootstrap-multiselect.css"> 

<?
function csv($asd){
    $return = '';
    foreach($asd as $val){
      if($val == 0){ 
        $return = '0';
      } 
    }
    if($asd == ''){
      return '-1';
    }
    else if($return != '0'){
      $qwe = implode(',',$asd);
      return $qwe;
    }else{
      return $return;
    }
}



$obj_main = $conn->query("SELECT  * FROM `tbl_role` where id='".$_POST['role_name']."' ")->fetch_object();
?>

 <script>
        var opco_data= new Array();
        var opco_id= new Array();
        var primary_data= new Array();
        var primary_id= new Array();
        var group_data= new Array();
        var group_id= new Array();
        var department_data= new Array();
        var department_id= new Array();
        var workgroup_data= new Array();
        var workgroup_id= new Array();
        var equipment_data= new Array();
        var equipment_id= new Array();
        var view_data= new Array();
        var view_id= new Array();
        var report_data= new Array();
        var report_id= new Array();
        var emf_data= new Array();
        var emf_id= new Array();
 </script>
<style>
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
<script>
    $(document).ready(function() {
      $('#opco_role,#primary_role,#group_role').multiselect({
        includeSelectAllOption: true,
        selectAllText: 'All',
         numberDisplayed: 0
      }); 
      $('#dept_role,#view_role,#report_role').multiselect({
        includeSelectAllOption: true,
        selectAllText: 'All',
         numberDisplayed: 0
      }); 
      $('#eqp_role,#emf_role').multiselect({
        includeSelectAllOption: true,
        selectAllText: 'All',
         numberDisplayed: 0
      }); 
     $('#work_group').multiselect({
        includeSelectAllOption: true,
        selectAllText: 'All',
         numberDisplayed: 0
      }); 
});

 


 
$('#eqp_role,#view_role,#report_role,#emf_role,#work_group').change(function() { //alert(equipment_data);

  var view_str = $(this).val();
  var values = new Array('Activity Search','Dispatch');
  if(view_str.indexOf( 'Map' ) != -1){
    $('#view_role').multiselect('select', values);
  }else{
    $('#view_role').multiselect('deselect', values);
  }

    //$("#work_group,#eqp_role,#view_role,#report_role,#emf_role").multiselect('enable');
    $('#work_tab').empty();
    $("#work_tab").append("<tr><td><center><b>Workgroup</b></center></td></tr>");

    var work_var;
    $('#work_group :selected').each(function(i, selected){ 
       var i=$.inArray($(selected).text(), workgroup_data); 
       work_var = i;
        var j=workgroup_id[i];
     
      $("#work_tab").append("<tr><td><input type='checkbox' style='display:none;' checked='checked' name='workgroup[]' value='"+j+"'>"+$(selected).text()+"</td></tr>");
    });
    if((work_var == '' || work_var == null) && work_var != '0'){
      $("#eqp_role,#view_role,#report_role,#emf_role").multiselect('disable'); 
      $("#eqp_tab tr:not(:eq(0))").hide();
       $("#view_tab tr:not(:eq(0))").hide(); 
       $("#report_tab tr:not(:eq(0))").hide(); 
       $("#emf_tab tr:not(:eq(0))").hide();
    }
    else
    {

    $("#eqp_role,#view_role,#report_role,#emf_role").multiselect('enable');
    $('#eqp_tab').empty();
    $("#eqp_tab").append("<tr><td><center><b>Equipment</b></center></td></tr>");

    var eqp_var;
    $('#eqp_role :selected').each(function(i, selected){ 
       var i=$.inArray($(selected).text(), equipment_data); 
       eqp_var = i;
        var j=equipment_id[i];
     
      $("#eqp_tab").append("<tr><td><input type='checkbox' style='display:none;' checked='checked' name='equipment[]' value='"+j+"'>"+$(selected).text()+"</td></tr>");
    });
    if((eqp_var == '' || eqp_var == null) && eqp_var != '0'){
      $("#view_role,#report_role,#emf_role").multiselect('disable'); 
       $("#view_tab tr:not(:eq(0))").hide(); 
       $("#report_tab tr:not(:eq(0))").hide(); 
       $("#emf_tab tr:not(:eq(0))").hide();
    }else{
      $("#view_role,#report_role,#emf_role").multiselect('enable');
    $('#view_tab').empty();
    $("#view_tab").append("<tr><td><center><b>View</b></center></td></tr>");
    var view_var;
    $('#view_role :selected').each(function(i, selected){ 
      var i=$.inArray($(selected).text(), view_data);
      view_var =i;
      var j=view_id[i];
      $("#view_tab").append("<tr><td><input type='checkbox' style='display:none;' checked='checked' name='view[]' value='"+j+"'>"+$(selected).text()+"</td></tr>");

    });
    if((view_var == '' || view_var == null) && view_var != '0'){
      $("#report_role,#emf_role").multiselect('disable'); 
       $("#report_tab tr:not(:eq(0))").hide(); 
       $("#emf_tab tr:not(:eq(0))").hide();
    }else{
       $("#report_role,#emf_role").multiselect('enable'); 
    $('#report_tab').empty();
    $("#report_tab").append("<tr><td><center><b>Report</b></center></td></tr>");
    var report_var;
    $('#report_role :selected').each(function(i, selected){ 
      var i=$.inArray($(selected).text(), report_data);
      report_var = i;
       var j=report_id[i];
      $("#report_tab").append("<tr><td><input type='checkbox' style='display:none;' checked='checked' name='report[]' value='"+j+"'>"+$(selected).text()+"</td></tr>");
    });
    if((report_var == '' || report_var == null) && report_var != '0'){
      $("#emf_role").multiselect('disable'); 
       $("#emf_tab tr:not(:eq(0))").hide();
    }else{
      $("#emf_role").multiselect('enable');
    $('#emf_tab').empty();
    $("#emf_tab").append("<tr><td><center><b>Emf</b></center></td></tr>");
    $('#emf_role :selected').each(function(i, selected){ 
      var i=$.inArray($(selected).text(), emf_data);
      var j=emf_id[i];
      $("#emf_tab").append("<tr><td><input type='checkbox' style='display:none;' checked='checked' name='emf[]' value='"+(++i)+"'>"+$(selected).text()+"</td></tr>");
    });
  }
  }
  }
  }
});



$('#opco_role').change(function() { 
    $('#opco_tab').empty();
    $("#opco_tab").append("<tr><td><center><b>Company</b></center></td></tr>");
    var opco_var;
    $('#opco_role :selected').each(function(i, selected){ 
      var i=$.inArray($(selected).text(), opco_data); 
      opco_var=i;
      var j=opco_id[i];
      $("#opco_tab").append("<tr><td><input type='checkbox' style='display:none;' checked='checked' name='opco[]' value='"+j+"'>"+$(selected).text()+"</td></tr>");
    });
   
    if((opco_var == '' || opco_var == null) && opco_var != '0'){
      //$("option:selected").removeAttr("selected");
      $("#primary_role,#group_role,#dept_role").multiselect('disable');
      $("#eqp_role,#view_role,#report_role,#emf_role,#work_group").multiselect('disable');
      //$("#primary_role,#group_role,#dept_role").multiselect('rebuild');
       $("#primary_tab tr:not(:eq(0))").hide(); 
       $("#group_tab tr:not(:eq(0))").hide();
       $("#dept_tab tr:not(:eq(0))").hide();
       $("#work_tab tr:not(:eq(0))").hide(); 
       $("#eqp_tab tr:not(:eq(0))").hide(); 
       $("#view_tab tr:not(:eq(0))").hide(); 
       $("#report_tab tr:not(:eq(0))").hide(); 
       $("#emf_tab tr:not(:eq(0))").hide(); 
    }else{ 
      var comp_id = $(this).val();
      if(comp_id != null){
         comp_id = comp_id.join();
      }
      $.post('role_filt_qry.php',{for:'company',comp_id:comp_id},function(data){
        //alert(data);
        $('#role_data').html('');
        $('#role_data').html(data);
      });
      
       $("#eqp_tab tr:not(:eq(0))").show(); 
       $("#view_tab tr:not(:eq(0))").show(); 
       $("#report_tab tr:not(:eq(0))").show(); 
       $("#emf_tab tr:not(:eq(0))").show();
       //$("#work_tab tr:not(:eq(0))").show(); 
     //$("input:checkbox").prop('checked','checked');
     //$("#primary_role,#group_role,#dept_role").multiselect('rebuild');
      $("#primary_role,#group_role,#dept_role").multiselect('enable');
      $("#eqp_role,#view_role,#report_role,#emf_role,#work_group").multiselect('enable');
    }
   });

$('#primary_role').change(function() { 
    $('#primary_tab').empty();
    $("#primary_tab").append("<tr><td><center><b>Section</b></center></td></tr>");
    var primary_var;
    $('#primary_role :selected').each(function(i, selected){ 
      var i=$.inArray($(selected).text(), primary_data);
      primary_var =i;
      var j=primary_id[i];
      $("#primary_tab").append("<tr><td><input type='checkbox' style='display:none;' checked='checked' name='primary[]' value='"+j+"'>"+$(selected).text()+"</td></tr>");
    });
    if((primary_var == '' || primary_var == null) && primary_var != '0'){
       $("#group_role,#dept_role").multiselect('disable');
      $("#work_group,#eqp_role,#view_role,#report_role,#emf_role").multiselect('disable');
       $("#group_tab tr:not(:eq(0))").hide();
       $("#dept_tab tr:not(:eq(0))").hide();
       $("#work_tab tr:not(:eq(0))").hide();  
       $("#eqp_tab tr:not(:eq(0))").hide(); 
       $("#view_tab tr:not(:eq(0))").hide(); 
       $("#report_tab tr:not(:eq(0))").hide(); 
       $("#emf_tab tr:not(:eq(0))").hide();
    }else{
      var sec_id = $(this).val();
      if(sec_id != null){
         sec_id = sec_id.join();
      }
      $.post('role_filt_qry.php',{for:'section',comp_id:$("#opco_role").val().join(),sec_id:sec_id},function(data){
        //alert(data);
        $('#role_data').html('');
        $('#role_data').html(data);
      });
      $("#group_role,#dept_role").multiselect('enable');
      $("#work_group,#eqp_role,#view_role,#report_role,#emf_role").multiselect('enable');
       $("#eqp_tab tr:not(:eq(0))").show(); 
       $("#view_tab tr:not(:eq(0))").show(); 
       $("#report_tab tr:not(:eq(0))").show(); 
       $("#emf_tab tr:not(:eq(0))").show();
}
});

$('#group_role').change(function() { 
    $('#group_tab').empty();
    $("#group_tab").append("<tr><td><center><b>Business Unit</b></center></td></tr>");
    var group_var;
    $('#group_role :selected').each(function(i, selected){ 
      var i=$.inArray($(selected).text(), group_data);
      group_var = i;
      var j=group_id[i];
      $("#group_tab").append("<tr><td><input type='checkbox' style='display:none;' checked='checked' name='group[]' value='"+j+"'>"+$(selected).text()+"</td></tr>");
    });
       if((group_var == '' || group_var == null) && group_var != '0'){
       $("#dept_role").multiselect('disable');
       $("#work_group,#eqp_role,#view_role,#report_role,#emf_role").multiselect('disable');
       $("#dept_tab tr:not(:eq(0))").hide();
       $("#work_tab tr:not(:eq(0))").hide();   
       $("#eqp_tab tr:not(:eq(0))").hide(); 
       $("#view_tab tr:not(:eq(0))").hide(); 
       $("#report_tab tr:not(:eq(0))").hide(); 
       $("#emf_tab tr:not(:eq(0))").hide();
    }else{
      var bu_id = $(this).val();
      if(bu_id != null){
         bu_id = bu_id.join();
      }
      $.post('role_filt_qry.php',{for:'bu',comp_id:$("#opco_role").val().join(),sec_id:$("#primary_role").val().join(),bu_id:bu_id},function(data){
        //alert(data);
        $('#role_data').html('');
        $('#role_data').html(data);
      });
      $("#dept_role").multiselect('enable');
       $("#work_group,#eqp_role,#view_role,#report_role,#emf_role").multiselect('enable');
       $("#eqp_tab tr:not(:eq(0))").show(); 
       $("#view_tab tr:not(:eq(0))").show(); 
       $("#report_tab tr:not(:eq(0))").show(); 
       $("#emf_tab tr:not(:eq(0))").show();
  }
});

$('#dept_role').change(function() { 
    
    $('#dept_tab').empty();
    $("#dept_tab").append("<tr><td><center><b>Location</b></center></td></tr>");
    
    var dept_var;
    $('#dept_role :selected').each(function(i, selected){ 
    var i=$.inArray($(selected).text(), department_data);
    dept_var = i;
    var j=department_id[i];
      $("#dept_tab").append("<tr><td><input type='checkbox' style='display:none;' checked='checked' name='department[]' value='"+j+"'>"+$(selected).text()+"</td></tr>");
    });
    if((dept_var == '' || dept_var == null) && dept_var != '0'){
      $("#work_group,#eqp_role,#view_role,#report_role,#emf_role").multiselect('disable');
       $("#work_tab tr:not(:eq(0))").hide();
       $("#eqp_tab tr:not(:eq(0))").hide(); 
       $("#view_tab tr:not(:eq(0))").hide(); 
       $("#report_tab tr:not(:eq(0))").hide(); 
       $("#emf_tab tr:not(:eq(0))").hide();
    }else{
      var loc_id = $(this).val();
      if(loc_id != null){
         loc_id = loc_id.join();
      }
      $.post('role_filt_qry.php',{for:'location',comp_id:$("#opco_role").val().join(),sec_id:$("#primary_role").val().join(),bu_id:$("#group_role").val().join(),loc_id:loc_id},function(data){
        //alert(data);
        $('#role_data').html('');
        $('#role_data').html(data);
      });
      $("#work_group,#eqp_role,#view_role,#report_role,#emf_role").multiselect('enable');
       $("#eqp_tab tr:not(:eq(0))").show(); 
       $("#view_tab tr:not(:eq(0))").show(); 
       $("#report_tab tr:not(:eq(0))").show(); 
       $("#emf_tab tr:not(:eq(0))").show();
  }
});
</script>

<script type="text/javascript">

function validateEmail(x) {
    var atpos = x.indexOf("@");
    var dotpos = x.lastIndexOf(".");
    if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) {
        //alert("Not a valid e-mail address");
        return true;
    }else{
      return false;
    }
}
$(document).ready(function() {
/*$('#edit_role').click(function(){
 $("#trip_sheet_div").load("view_role.php"); 
    $("#trip_sheet_div").show();
});
*/

  $("#save").click(function(){
    //$('#loader').show();
     if($("#rolename").val() == ''){
        alert('Please Fill Name');
        $("#rolename").focus();
        
      }else if(validateEmail($("#emailid").val())){
        alert('Please Fill Email');
        $("#emailid").focus();
        
      }else
      if ($("#role_name").val() == ''){
        alert('Please Fill username');
        $("#role_name").focus();
        
      }
      else if ($("#role_pass").val() == ''){
        alert('Please Fill Password');
        $("#role_pass").focus();
        
      }
      else if ($("#roleview").val() == '-1'){
        alert('Please Fill Role');
        $("#roleview").focus();
        
      }

    //alert($("#view").val());
  /*if ($("#role").val() =="")
    {
      alert('Please enter a role.');
       $("#role").focus()
  }else{*/
      //$("#add_role").submit();
      //alert(); 
      else{
      $('#spinner').show(); 
       $.ajax({
                type: 'post',
                url: 'user_query.php',
                data:$('#add_role').serialize() ,
                success: function (data) {
                  alert(data);
                  //$('#tap').html(data);
                  $('#spinner').hide();
                  $("#trip_sheet_div").html("");
                  $("#trip_sheet_div").hide();  
                  $("#user_role").load('manage_role.php');
                  //manage_role();
                }
              }); 
    }
  });
  });
  
  </script>

<style>
body{
   background-color: #d6dce2;
}
th{
  text-align: center;
}
.container{
width:92vw;
background-color: white;
margin-top: 1vh;
margin-bottom: 1vh; 
padding-right: 9px;
    padding-left: 15px;
}
.list{
  width:15vw;
}
.intp{
  border-radius: 4px;
  height: 4vh;
  margin-bottom: 1vh;
  margin-left: 1vw;
  width:15vw;
  border:1px solid #D3D3D3;
}
.col-sm-12{
padding-right: 5px;
padding-left: 0px;
}
@media only screen and (max-width: 768px) {
   
    .list{
        width: 100%;
    }
    .col-sm-12{
        width: 100%;

    }
}

</style>
<div style='background:white; font-size: 1.3rem;width: 100%; border-radius: 15px; padding: 5px; border: 2px solid #969090;'>
<div class="container" >
<h1 style="font-size:2.2rem;width: 50vw;"><b>Add Details</b></h1><h1 style="margin-top: -4.5vh;float:right;font-size:2.2rem;width: 60vw;"><b>Preferences</b></h1>
<div id='spinner' style="color:red; clear: both; display:none;"><img src="image/spinner.gif" width="20px">Please wait...</div>
<button onclick='$("#trip_sheet_div").hide();$("#trip_sheet_div").html("");$("#new_user").show();
                     $("#new_role").show();' style="position: absolute; left: 5vw;">Back</button>
<!--   <input type="button"  id="edit_role" value="Edit Role" style="height:25px;margin-top:19px;"> -->
   <div style="color:red;font-size:17px;margin-bottom:-13px;">
  <div class="colm" style="margin-top:2vh;">
  
    <form name="addrole" action="add_role.php" id="add_role" method="POST" >
       <center>
       <table>
        <tr>
          <td>
   <table style="font-size:small;">
                      <tr>
                            <td><strong class="stg">Name:</strong></td>
                            <td><input id="rolename" name="rolename" type="text" class="intp" placeholder="Name">
                            </td>
                      </tr>
					  <tr>
                            <td><strong class="stg">NTID:</strong></td>
                            <td><input id="ntid" name="ntid" type="text" class="intp" placeholder="NTID">
                            </td>
                      </tr>
                      <tr>
                            <td><strong class="stg">Email:</strong></td>
                            <td><input id="emailid" name="emailid" type="text" class="intp" placeholder="Email">
                            </td>
                      </tr>
                      <tr>
                          <td><strong class="stg">Username:</strong></td>
                          <td><input type='hidden' name='qry_type_role' value='addrole'>
                            <input id="role_name" name="role_uname" type="text" class="intp" style="background-color:#D3D3D3;" placeholder="Username" autocomplete="new-username">
                          </td>
                      </tr>
                      <tr>
                            <td><strong class="stg">Password:</strong></td>
                            <td><input id="role_pass" name="role_pass" type="password" class="intp" placeholder="Password" autocomplete="new-password">
                            </td>
                      </tr>
                      
                      <tr>      
                          <td><strong class="stg">Role:</strong></td>
                          <td>
                              <select id="roleview" name="roleview" class="intp" style="background-color:#D3D3D3;">  
                                <option value='1'>Admin</option>
                                <option value='2'>View olny</option>
                                <option value='3'>Normal</option>
                                <option value='4'>Scheduler Admin</option>
                                <option value='5'>Schedule user</option>
                                 
                              </select>   <input type='hidden' id="add" name ="qry_type" value="new" > 
                          </td>
                      </tr>          
                      <br> </table>
                  </td>
          <td style='padding-left: 48px;'>        
         <table style="font-size:small;border-collapse: inherit;border-spacing: 20px;margin-left: 5vw;">
      <tr>
      <td><b>Company</b></td>
      <td style='padding:7px;'>
      <select  id="opco_role" multiple="multiple" size="1" >
                  <?  
                      $sql = $conn->query("SELECT * from role_opco where if('".$_SESSION['ROLE_opco']."'='0',1,id in (".$_SESSION['ROLE_opco'].")) order by name asc");
                      while($obj = $sql->fetch_object()){
                  ?>
                      <option  value="<?=$obj->id?>" selected ><?=$obj->name?></option>
                  <?   } 
                  ?>
                </select>
      </td>
      <td style='padding-left: 2vw;'><b>Section</b></td>
      <td style='padding:7px;'>
      <select id="primary_role" multiple="multiple" size="1" >
                  <?  
                      $sql = $conn->query("SELECT * from role_primary where if('".$_SESSION['ROLE_primary']."'='0',1,id in (".$_SESSION['ROLE_primary'].")) order by name asc");
                      while($obj = $sql->fetch_object()){
                  ?>
                      <option  value="<?=$obj->id?>" selected ><?=$obj->name?></option>
                  <?   } 
                  ?>
                </select>
      </td>
      </tr>
      <tr>
      <td><b>Business Unit</b></td>
      <td style='padding:7px;'>
      <select  id="group_role" multiple="multiple" size="1" >
                  <?  
                      $sql = $conn->query("SELECT * from role_group where if('".$_SESSION['ROLE_group']."'='0',1,id in (".$_SESSION['ROLE_group'].")) order by name asc");
                      while($obj = $sql->fetch_object()){
                  ?>
                      <option  value="<?=$obj->id?>" selected ><?=$obj->name?></option>
                  <?   } 
                  ?>
                </select>
      </td>
      <td style='padding-left: 2vw;'><b>Location</b></td>
      <td style='padding:7px;'>
      <select  id="dept_role" multiple="multiple" size="1" >
                  <?  
                      $sql = $conn->query("SELECT * from role_dept where if('".$_SESSION['ROLE_dept']."'='0',1,id in (".$_SESSION['ROLE_dept'].")) order by name asc");
                      while($obj = $sql->fetch_object()){
                  ?>
                      <option  value="<?=$obj->id?>" selected ><?=$obj->name?></option>
                  <?   } 
                  ?>
                </select>
      </td>
  </tr>
  <tr>
    <td><b>Workgroup</b></td>
      <td style='padding:7px;'>
      <select  id="work_group" multiple="multiple" size="1" >
                  <?  
                      $sql = $conn->query("SELECT * from tbl_workgroup where if('".$_SESSION['ROLE_wrokgroup']."'='0',1,id in (".$_SESSION['ROLE_wrokgroup'].")) order by name asc");
                      while($obj = $sql->fetch_object()){
                  ?>
                      <option  value="<?=$obj->id?>" selected ><?=$obj->name?></option>
                  <?   } 
                  ?>
                </select>
      </td>
      <td style='padding-left: 2vw;'><b>Equipment</b></td>
      <td style='padding:7px;'>
      <select  id="eqp_role" multiple="multiple" size="1" >
                  <?  
                      $sql = $conn->query("SELECT * from tbl_eqptype where if('".$_SESSION['ROLE_eqp']."'='0',1,id in (".$_SESSION['ROLE_eqp'].")) order by eq_name asc");
                      while($obj = $sql->fetch_object()){
                  ?>
                      <option  selected ><?=$obj->eq_name?></option>
                  <?   } 
                  ?>
                </select>
      </td>
      
      </tr>
      <tr>
        <td><b>View</b></td>
      <td style='padding:7px;'>
      <select id="view_role"  multiple="multiple" size="1">
                  <?  
                      $sql = $conn->query("(SELECT * from role_view where if('".$_SESSION['ROLE_view']."'='0',1,id in (".$_SESSION['ROLE_view'].")) )order by name asc");
                      while($obj = $sql->fetch_object()){
                  ?>
                      <option  <?if(trim($obj->name) == "Dispatch" || trim($obj->name) == "Activity Search"){ echo "disabled";}?> selected><?=$obj->name?></option>
                  <?   } 
                  ?>
                </select>
      </td>
      <td style='padding-left: 2vw;'><b>Report</b></td>
      <td style='padding:7px;'>
      <select id="report_role"  multiple="multiple" size="1">
                  <?  
                      $sql = $conn->query("SELECT * from role_report where if('".$_SESSION['ROLE_view']."'='0',1,id in (".$_SESSION['ROLE_view'].")) order by name asc");
                      while($obj = $sql->fetch_object()){
                  ?>
                      <option  selected><?=$obj->name?></option>
                  <?   } 
                  ?>
                </select>
      </td>
      
  </tr>
  <tr>

    <td><b>Emf</b></td>
      <td style='padding:7px;'>
      <select id="emf_role"  multiple="multiple" size="1">
              <?  
                  $sql = $conn->query("SELECT * from role_emf where if('".$_SESSION['ROLE_view']."'='0',1,id in (".$_SESSION['ROLE_view'].")) order by name asc");
                  while($obj = $sql->fetch_object()){
              ?>
                  <option selected><?=$obj->name?></option>
              <?   } 
              ?>
            </select>
      </td>
  </tr> 
</table>
</td>
</tr>
</table>
  <input type='button' id="save" value='Save' class="btn btn-primary" style="height:5vh;width:20vw;margin-top: 3vh;">
</center>
<!--  <center>
      <div class="col-sm-12" style="width:100%;margin-top:4vh;margin-bottom: 18vh;">
    <div style="/*float:left;border: 1px solid black;*/"> -->  

    <center>
<table class="table" style="border:1px solid black;border-collapse: initial;margin-top: 7vw;">
<tr>
<td>
    <table class="table" id="opco_tab" style="border:1px solid black;border-collapse: initial;font-size:smaller;">
      <tr><th>Company</th></tr>     
        <? $sql = "SELECT * from role_opco";
         if ($result = $conn->query($sql)) { 
              while($obj = $result->fetch_object()){
               ?>
               <script>
                opco_data.push("<?=$obj->name?>");
                opco_id.push("<?=$obj->id?>");
               </script>
              <tr style="text-align:left;">
            <td>
            <input type="checkbox" name="opco[]" style='display:none;' checked="checked" value="<?=($obj->id)?>"><?=($obj->name)?></td>
        </tr>
            <?}} ?>
        </table>  
   <!--  </div> 
   
    <div style="/*float:left;border: 1px solid black;*/">-->
    </td><td>
      <table class="table" id="primary_tab" style="border:1px solid black;border-collapse: initial;font-size:smaller;">
      <tr><th>Section</th></tr>
         <? $sql = "SELECT * from role_primary";
         if ($result = $conn->query($sql)) { 
              while($obj = $result->fetch_object()){ ?>
              <script>
                primary_data.push("<?=$obj->name?>");
                primary_id.push("<?=$obj->id?>");
               </script>
              <tr style="text-align:left;">
            <td> <input type="checkbox" name="primary[]" style='display:none;'  checked="checked" value="<?=($obj->id)?>"><?=($obj->name)?></td>
        </tr>
            <?}}?>
        </table>  
   <!--  </div>
  
    <div style="/*float:left;border: 1px solid black;*/"> -->
    </td><td>
      <table class="table" id="group_tab" style="border:1px solid black;border-collapse: initial;font-size:smaller;">
      <tr><th>Business Unit</th></tr>
         <? $sql = "SELECT * from role_group";
         if ($result = $conn->query($sql)) { 
              while($obj = $result->fetch_object()){ ?>
                <script>
                group_data.push("<?=$obj->name?>");
                group_id.push("<?=$obj->id?>");
               </script>
              <tr style="text-align:left;">
            <td><input type="checkbox" name="group[]" style='display:none;'  checked="checked" value="<?=($obj->id)?>"><?=($obj->name)?></td>
        </tr>
            <?}}?>
        </table>  
    <!-- </div>
    
    <div style="/*float:left;border: 1px solid black;*/"> -->
    </td>
    <td>
      <table id="dept_tab" class="table" style="border:1px solid black;border-collapse: initial;font-size:smaller;">
      <tr><th>Location</th></tr>
         <? $sql = "SELECT * from role_dept";
         if ($result = $conn->query($sql)) { 
              while($obj = $result->fetch_object()){ ?>
                <script>
                department_data.push("<?=$obj->name?>");
                department_id.push("<?=$obj->id?>");
               </script>
              <tr style="text-align:left;">
            <td><input type="checkbox" name="department[]" style='display:none;'  checked="checked" value="<?=($obj->id)?>"><?=($obj->name)?></td>
        </tr>
            <?}}?>
        </table>  
   <!--  </div>
   
    <div style="/*float:left;border: 1px solid black;*/"> -->
    </td>
    <td>
      <table id="work_tab" class="table" style="border:1px solid black;border-collapse: initial;font-size:smaller;">
      <tr><th>Workgroup</th></tr>
         <? $sql = "SELECT * from tbl_workgroup";
         if ($result = $conn->query($sql)) { 
              while($obj = $result->fetch_object()){ ?>
                <script>
                workgroup_data.push("<?=$obj->name?>");
                workgroup_id.push("<?=$obj->id?>");
               </script>
              <tr style="text-align:left;">
            <td><input type="checkbox" name="workgroup[]" style='display:none;'  checked="checked" value="<?=($obj->id)?>"><?=($obj->name)?></td>
        </tr>
            <?}}?>
        </table>  
   <!--  </div>
   
    <div style="/*float:left;border: 1px solid black;*/"> -->
    </td>
    <td>
      <table id="eqp_tab" class="table" style="border:1px solid black;border-collapse: initial;font-size:smaller;">
      <tr><th>Equipment</th></tr>
         <? $sql = "SELECT * from tbl_eqptype";
         if ($result = $conn->query($sql)) { 
              while($obj = $result->fetch_object()){ ?>
                <script>
                equipment_data.push("<?=($obj->eq_name)?>");
                equipment_id.push("<?=$obj->id?>");
               </script>
              <tr style="text-align:left;">
            <td><input type="checkbox" name="equipment[]" style='display:none;' checked="checked" value="<?=($obj->id)?>"><?=($obj->eq_name)?></td>
        </tr>
            <?}}?>
        </table>  
   <!--  </div>
   
    <div style="/*float:left;border: 1px solid black;*/"> -->
    </td><td>
      <table id="view_tab" class="table" style="border:1px solid black;border-collapse: initial;font-size:smaller;">
      <tr><th>View</th></tr>
         <? $sql = "SELECT * from role_view ";
         if ($result = $conn->query($sql)) { 
              while($obj = $result->fetch_object()){ ?>
               <script>
                view_data.push("<?=($obj->name)?>");
                view_id.push("<?=($obj->id)?>");
               </script> 
              <tr style="text-align:left;">
            <td><input type="checkbox" name="view[]" style='display:none;' checked="checked" value="<?=($obj->id)?>"><?=($obj->name)?></td>
        </tr>
            <?}}?>
        </table>  
    <!-- </div>
   
    <div style="/*float:left;border: 1px solid black;*/"> -->
    </td><td>
      <table id="report_tab"  class="table" style="border:1px solid black;border-collapse: initial;font-size:smaller;">
      <tr><th>Report</th></tr>
         <? $sql = "SELECT * from role_report";
         if ($result = $conn->query($sql)) { 
              while($obj = $result->fetch_object()){ ?>
                 <script>
                report_data.push("<?=($obj->name)?>");
                report_id.push("<?=($obj->id)?>");
               </script> 
              <tr style="text-align:left;">
            <td><input type="checkbox" name="report[]" style='display:none;' checked="checked" value="<?=($obj->id)?>"><?=($obj->name)?></td>
        </tr>
            <?}}?>
        </table>
 <!-- </div>
 <div style="/*float:left;border: 1px solid black;*/"> -->
 </td><td>
      <table class="table" id="emf_tab" style="border:1px solid black;border-collapse: initial;font-size:smaller;">
      <tr><th>Emf</th></tr>
         <? $sql = "SELECT * from role_emf";
         if ($result = $conn->query($sql)) { 
              while($obj = $result->fetch_object()){ ?>
                 <script>
                emf_data.push("<?=($obj->name)?>");
                emf_id.push("<?=($obj->id)?>");
               </script> 
              <tr style="text-align:left;">
            <td><input type="checkbox" name="emf[]" style='display:none;' checked="checked" value="<?=($obj->id)?>"><?=($obj->name)?></td>
        </tr>
            <?}}?>
        </table>
        </td><td>
        </tr>
        </table>
        <!-- <textarea id='tap'></textarea> -->
        </center>
<!--  </div>
 </div> -->
 </form>
 <span id="role_data" style="display:none;"></span>
</div>

