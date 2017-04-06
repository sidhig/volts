<?php
print_r($_POST);
		
		  session_start();
		  error_reporting(0);
		  /*if(!isset($_SESSION['LOGIN_STATUS'])){
			  header('location:login.php');
		  }*/

	 include_once('connect.php');
    $array = $_POST;
    $array_val=array_values($array)[1];
    
	 ?>
	 <script>
	 $(document).ready(function(){alert(data);
	 	var end_date = '<? echo $array_val; ?>' ;
       $.ajax({
       	type:'post',
		url:'new_schedule_from_cal.php',
		data:"end_date="+end_date,
       });
	 });
	

	 </script>





