<? include 'connect.php';
session_start();

/*error_reporting(1);
 print_r($_SESSION);
print_r($_POST);*/
$err ="";

if(!empty($_POST)){
$sql = "SELECT 
tbl_role_user.username,
tbl_role_user.role as 'mainrole',
tbl_role_user.name,
tbl_role_user.adminuser,
tbl_role_user.emailid,
tbl_role.opco,
tbl_role.primary,
tbl_role.group,
tbl_role.equipment,
tbl_role.department,
tbl_role.workgroup,
tbl_role.view,
tbl_role.report,
if(tbl_role_user.view = 0,'superadmin',if(tbl_role_user.view = 1,'admin',if(tbl_role_user.view = 3,'normal',if(tbl_role_user.view = 2,'view Only',if(tbl_role_user.view = 4,'Scheduler Admin',if(tbl_role_user.view = 5,'Schedule user',''))) ) ) ) as role,
if(tbl_role_user.view = 2,'0','1')  as can_edit
 FROM `tbl_role_user` left join tbl_role on tbl_role_user.role = tbl_role.role_name where username='".$_POST['uname']."' AND password ='".$_POST['password']."'";
$result = $conn->query($sql);

  if ($result->num_rows > 0) {

        $obj = $result->fetch_object();
          $_SESSION['LOGIN_user']    = $obj->username;
          $_SESSION['LOGIN_STATUS']   = $obj->adminuser;
          $_SESSION['ROLE_group']  = $obj->group;
          $_SESSION['ROLE_opco']   = $obj->opco;
          $_SESSION['ROLE_primary']  = $obj->primary;
          $_SESSION['ROLE_dept']   = $obj->department;
          $_SESSION['ROLE_eqp']   = $obj->equipment;
          $_SESSION['ROLE_view']   = $obj->view;
          $_SESSION['ROLE_report']   = $obj->report;
          $_SESSION['ROLE_can_edit']   = $obj->can_edit;
          $_SESSION['LOGIN_role']   = $obj->role;
          $_SESSION['LOGIN_name']   = $obj->name;
          $_SESSION['LOGIN_email']   = $obj->emailid;
          $_SESSION['ROLE_wrokgroup']= $obj->workgroup;
          $_SESSION['LOGIN_main_role']=$obj->mainrole;
			   if($obj->role=='Schedule user'){
				  header('location:tmc_schedule.php');
			   }
			   else if($obj->role=='alexa_user'){
				  header('location:alexa_map.php');
			  }
			  else if($obj->role=='tracker_user'){
				  header('location:user_add_tracker_mobile.php');
			  }
			   else{
				  header('location:home.php');
			  }
}
  else
  {
    $err="1";
  }
  //unset($_POST);
 $conn->close();   
}else
{
  $err ="";
}
/*if($_SESSION["LOGIN_user"]!=''){
	//header("location: home.php");
}*/
?> 

<html>
<head>
  <title>Volts</title>
  <link rel="image icon" type="image/png" href="image/icon.png">
<style type="text/css">
body{
   background: url(image/bgmap.png); 
}
</style>
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery.min.1.12.0.js"></script>

<script type="text/javascript">
  function validateForm() {
    if ($("#uname").val().trim() == "") {
      $("#uname").css('border','1px solid red');
      $("#uname").focus();
      if ($("#password").val().trim() == "")
        $("#password").css('border','2px solid red');
    }     
   else if ($("#password").val().trim() == "") {
        $("#password").css('border','2px solid red');
        $("#password").focus();
    }
    else{    
      $("#spinner").show();
      $("#myform").submit();
    }
  }

  $(document).ready(function(){
    $("#uname").focus();
      $("#uname").on('input',function(e){
         $("#uname").css('border','1px solid #CCC');
          $("#error").hide();
        });
      $("#password").on('input',function(e){
         $("#password").css('border','1px solid #CCC');
          $("#error").hide();
      });
  });


</script>
</head>
<body>

  <center><div id='login_form' style="  height:320px; padding:10px;  margin-top:50px;  " >
<form  id='myform' method="POST" class="form-horizontal"   >
<div class="container" style="width:55vw;border: 2px solid #000000;background-color:white;">
       
  <div style="width: 27%;">
   <img src="image/icon.png" style="float:left;width:27px;height:26px;font-size:2vw;" alt='Logo' ><h1 style="font-size:2.2vw;"><b>VOLTS</b></h1>
  </div>
 <table >
 
      <tr>
        <td><b>Username:&nbsp;</b></td>
        <td>
        <input style="display:none" type="text" name="uname"/>
        <input type="text" class="form-control" id="uname" name="uname" style="width:18vw;margin-bottom: 1vh;" value="<?=$_POST['uname']?>">
        </td>
      </tr>
   
    
      <tr>
        <td ><b>Password:</b></td>
        <td>
        <input style="display:none" type="password" name="password"/>
        <input type="password" class="form-control" id="password" name="password" value="" style="width:18vw;">
         </td>
       </tr>
  </table><br/>    
     
  
  <center><input type="button" class="btn btn-primary" id="login" value="Log In" onclick="validateForm()">
  <img id='spinner' src="image/loading.gif" style='display:none;width=7%;margin-left:1vh;' ></center>
  
  
  <div class="form-group">        
          <label class="control-label col-sm-1" style=" width: 67%;font-size:1.2vw;">Copyright &copy; 2016-2017 <a href="#" title="Volts" target="blank">VOLTS</a>. </label>     
  </div> 
  <div id="error" style=" <?  if($err!='1'){ echo "display:none;"; }?> width:86%; height:60px; top:5px; color:red;"> 
    <h5 style="width: 107%;">Please enter valid username & password</h5>
  </div>  
</div>    
</form>
</div>
</center> 
<script type="text/javascript">
$('#uname,#password').on('keypress', function (e) {
  if (e.which == 13) {
   validateForm();
    return false;    //<---- Add this line onclick="validateForm()"
  }
});
</script>
</body>
</html>

  
  
  
  
  



  
 
  



    





  
  
  
  



