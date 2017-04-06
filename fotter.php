</div>
   
<footer class="container-fluid text-center" style="margin-top:.2vh;border: 1px solid #BBBBBB;height:3vh;font-size:.8vw;">  
   <center>
    <span id='count' onclick="$('#piechart').toggle(); drawChart();" style="width:8%; float: left;border: 1px solid white; cursor:pointer;background-color: rgba(16, 150, 24, 0.55);"></span>

<script type="text/javascript" src="js/date.js"></script>
	 <script>
     function ShowLocalDate()
     {
		 var localdate= new Date().toString("MM-dd-yyyy hh:mm tt");
		 //return "<b>As of : </b>"+localdate;
		 $('#currentDate').html("<b>As of : </b>"+localdate);
     }
    
     </script>
     <span id="currentDate" style='margin-left: 12%;'> 
     
     <script>
        ShowLocalDate();

        setInterval(function(){
          ShowLocalDate();
        },60000);
	   </script>
     </span>
   <!--fotter section start--> 
 
     <span style="float:right; margin-bottom:0px;">Copyright &copy; 2016-2017 
       <a href="#" title="VOLTS" target="blank" style="color:black;">VOLTS</a>. 
       All rights reserved.
     </span></center>
</footer>
<? mysqli_close($conn); ?>
</body>
</html>