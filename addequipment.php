<? session_start();
include_once ('connect.php');
//print_r($_POST);
error_reporting(0);
		if(!empty($_POST)){
		 $sql = "select * from roletable where username= '".$_POST['username']."' and password = '".$_POST['password']."'"; 
		 $result = mysql_query($sql);
		   if(mysql_num_rows($result)>0){
			$obj = mysql_fetch_assoc($result);
			 $_SESSION['LOGIN_user']    = $obj['username'];
			 $_SESSION['LOGIN_STATUS']  = $obj['adminuser'];
			 $_SESSION['LOGIN_group']  = $obj['group'];
			 $_SESSION['LOGIN_opco']  = $obj['opco'];
			 $_SESSION['LOGIN_primary']  = $obj['primary'];
			 $_SESSION['LOGIN_dept']  = $obj['dept'];
			 $_SESSION['LOGIN_view']  = $obj['view'];
			 $_SESSION['LOGIN_report']   = $obj['reports'];
			 $_SESSION['LOGIN_role']   = $obj['role'];
			 $_SESSION['LOGIN_name']    = $obj['username']; 
			 if($obj['role'] == 'tracker_user'){
			 header('location:user_add_tracker_mobile.php');
			 }else{
			header('location:../volts/home.php');
			 }
			 
		  }else{
			$err ='<span style="font-size:1.5rem; color:red;">User Name and Password Invalid.</span>';
		  }
}//if post set
?>
<html>

<head>
  <title>VOLTS</title>
  <link rel="image icon" type="image/png" sizes="160x160" href="image/icon.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script>
$(document).ready(function() { 
 /* $("#trackertype").change(function(){
      if($("#trackertype option:selected").text()=='Wired'){
        $("#odometer").show();
      }  
      else{
        $("#odometer").hide(); 
      }
  });*/
  $("#login").click(function() {
      if ($("#username").val().trim() == ''){
        alert('Please enter Username');
		$("#username").focus();
        return false;
      }
      else if ($("#password").val().trim() == ''){
        alert('Please enter password');
		$("#password").focus();
        return false;
      }else {
		$("#myForm").submit();
	  }
  });
   
});
</script>


<style>
body{
  background-color: #d6dce2;
}
td{
  padding-bottom: 2vh;
  padding-right: 1vw;
  text-align: center;
  font-size:3.4rem;
}

</style>

  
<script type="text/javascript">

</script>

  </head>


  <body>
    <center><div class="cont" style="background-color:white;width:95vw;margin-top:.5vh;margin-bottom:.5vh;border: 1px solid #BBBBBB;padding-bottom: 1vh;">

    <center><div style="width: 2%;margin-top: 2vh;">
   <img src="image/icon.png" style="float:left;width:12vw;font-size:4.2vw;" align="center"></div></center><br><center><h1 style="font-size:5.2vw;width: 12%"><b>VOLTS<b></h1></center><br>
<div class="container" style="width:80%;line-height:20px;padding:10px;
    background-color:white;width:80%; ">

<center>
<?=$err?>

<form name="myForm" method="POST" action="addequipment.php"  id="myForm" >
<input type='hidden' value='new' name='type' >
<TABLE BORDER="0" >
    
  
  <tr>
  <td style=""><strong>Username:</strong><br>
    <input type="text" name='username'  id='username' class="form-control" style="width:80vw;font-size: 3.8rem;height: 7rem;">
      </td>
  </tr>  

<tr>
   <td style=""><strong>Password:</strong><br>
    <input type="password" name='password' id='password' class="form-control" style="width:80vw;font-size: 3.8rem;height: 7rem;"> 
      
    </td>

</tr>

</TABLE>

 <br>
   
    
 <center><input type="button" class="btn btn-primary" name="Save" id="login" value="Login" style="width:15vw;font-size:3.8rem;"></center>


</form></center>

</div>
</div></center>
<center><div style="background-color:white;width:95vw;border: 1px solid #BBBBBB; padding-top: .5vh;padding-bottom:.5vh;font-size:2.1rem;font-weight: normal;">
 <? //include_once('fotter.php'); ?>

<span>Copyright © 2015-2016 
					  <a href="#" title="VOLTS" target="blank">VOLTS</a>. 
					  All rights reserved.
				 </span>
</div></center>
</body>
</html>