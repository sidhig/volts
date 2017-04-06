<?

//$_POST(data);
// $_POST(data);

			include_once('connect.php');
			session_start();
			/* if(!isset($_SESSION['LOGIN_STATUS'])){
			  header('location:login.php');
		  }*/
		 //   $val = $_POST['unit'];
		 // print_r($val);

		  ?>
		   <button onclick="back_to_list();" style="position: absolute; left: 2vw;margin-top: -1vh;">Back</button>
		    <h3>Mobile <?=$_POST['unit'];?></h3>



<style>

.Red{background-color:#FF0033;}
.Green{background-color:#47E647;}
.Yellow{background-color:yellow;}
.White{background-color:white;}
.antiquewhite{background-color:antiquewhite;}
</style>
<script>
$("select").change(function(){
    var origBGColor=$(this).attr("class");
    
    $(this).removeClass($(this).attr('class'))
           .addClass($(":selected",this).attr('class'));
    
     
});
</script>

<script src="js/jquery.dataTables.min.js">
</script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
   
    <script>
$(document).ready(function() {
    $('#example').DataTable( {
        //"scrollY":        "200px",
        "scrollCollapse": true,
        "paging":         false,
        order: [[ 0, 'desc' ], [ 0, 'asc' ]]

          } );
} );
    </script>
    <style>
    #example_info{
        display: none;
    }
    #example_filter{
    	margin-right: 3vw;
    }
    /*#example_paginate{
    	display: none;
    }*/
    </style>
<!-- <strong>
Status: <select class="abc" id="filter_status" onchange="filter_sch($(this).val(),$('#tbl_sch'));" style="width:9vw;">
				<option class="White" value = ''>All</option>
				<option class="Yellow" id="Pending" style="">Pending</option>
				<option class="Green" style="">Approved</option>
				<option class="White">Completed</option>
				<option value='Delete' class="Red" style="">Deleted</option>
				<option class="antiquewhite">In Review</option>
       </select>
</strong>
	 -->

<? 
 // if($date_print<=$today_date){

 //   alert("Already Scheduled / Unable To Scedule On This Date");
 //   add_schedule_form();
 //  else{
 //  alert("Scheduled  On This Date");
   
 //  }
 // }

 
 	//echo "hlo";

	$today_date = date("Y-m-d"); 
	//echo "$today_date";
	date_format(date_create($today_date),"m/d/Y");
	 $month = substr($today_date,5,2);
	 $year = substr($today_date,0,4);
    if($_POST['month']!='' & $_POST['year']!=''){ $month = $_POST['month']; $year = $_POST['year']; }
	//$dateObj   = DateTime::createFromFormat('!m', $month);
	//$monthName = $dateObj->format('F');
	//$monthName = date_format(date_create($today_date),"!m");
	$monthName = DateTime::createFromFormat('!m', $month)->format('F');
	//$monthName = date('F', mktime(0, 0, 0, $month, 10));
	$qry = mysql_query("select unit as search from eqp_schedule where unit != '' group by unit union all select loc_need as search from eqp_schedule where loc_need != '' group by loc_need");
?>
<input type="hidden" id="cal_month" value="<?=$month?>"><input type="hidden" id="cal_year" value="<?=$year?>">

<image id="prev_month" src="image/map/l.png" width="25px" style="cursor:pointer"> <span style="font-weight: 900; font-size: large;"><?=$monthName?>-<?=$year?> </span><image  id="next_month" src="image/map/r.png" width="25px" style="cursor:pointer"><br>
<strong>
view: <select id="filter_status" onchange="filter_input(this.value)" style="font-size:1.2rem; height:3.5vh;">
    <option value="">All</option>
    <option>Unit#</option>
    <option>Location</option>
    <option>Status</option>
  </select>
<input class="all" id="sch_search" list='search_dl'  autocomplete='off' style="font-size:1.2rem;"/>
<datalist  class="all" id='search_dl'>
<?  while($row = mysql_fetch_array($qry)){ ?>
<option><?=$row['search']?></option>
<? } ?>
</datalist>
<select class="status"  style="display:none;font-size:1.2rem;">
 <option>select</option>
<option value="Approved">Approved</option>
<option value="Completed">Completed</option>
<option value="Pending">Pending</option>
</select>

</strong>
<?

function build_calendar($month,$year) {
     // Create array containing abbreviations of days of week.
    $daysOfWeek = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');

     // What is the first day of the month in question?
     $firstDayOfMonth = mktime(0,0,0,$month,1,$year);

     // How many days does this month contain?
     $numberDays = date('t',$firstDayOfMonth);

     // Retrieve some information about the first day of the
     // month in question.
     $dateComponents = getdate($firstDayOfMonth);

     // What is the name of the month in question?
     $monthName = $dateComponents['month'];

     // What is the index value (0-6) of the first day of the
     // month in question.
     $dayOfWeek = $dateComponents['wday'];

     // Create the table tag opener and day headers

     $calendar = "<table class='calendar' width='100%' border='1' style='font-size:13px; table-layout: fixed;'>";
    // $calendar .= "<caption>$monthName $year</caption>";
     $calendar .= "<tr>";

     // Create the calendar headers

     foreach($daysOfWeek as $day) {
          $calendar .= "<th class='header' style='font-size:14px; text-align:center;'>".$day."</th>";
     } 

     // Create the rest of the calendar

     // Initiate the day counter, starting with the 1st.

     $currentDay = 01;

     $calendar .= "</tr><tr>";

     // The variable $dayOfWeek is used to
     // ensure that the calendar
     // display consists of exactly 7 columns.

     if ($dayOfWeek > 0) { 
          $calendar .= "<th colspan='$dayOfWeek'>&nbsp;</th>"; 
     }
     
     $month = str_pad($month, 2, "0", STR_PAD_LEFT);
  
     while ($currentDay <= $numberDays) {

          // Seventh column (Saturday) reached. Start a new row.

          if ($dayOfWeek == 7) {

               $dayOfWeek = 0;
               $calendar .= "</tr><tr>";

          }
          
          $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
          //echo "$currentDayRel";
          $date = $year."-".$month."-".$currentDayRel;
         //echo "$date";
		  $date_print = $month."-".$currentDayRel."-".$year;
      // echo "$date_print";
      
       $qry = mysql_query("select if(devicedetails.driver_name = '',devicedetails.DeviceName,concat(devicedetails.DeviceName,'(',devicedetails.driver_name,')') ) as driver ,eqp_schedule.* from eqp_schedule left join devicedetails on eqp_schedule.eqp_imei = devicedetails.DeviceIMEI where  start_date <= '$date' and end_date >= '$date'  and (eqp_schedule.unit = '".$_POST['unit']."' || eqp_schedule.unit = '".$_POST['unit']."A' || eqp_schedule.unit = '".$_POST['unit']."B' || eqp_schedule.unit = '".$_POST['unit']."C' )");

        print_r(mysql_num_rows($qry));
      
      if (mysql_num_rows($qry)<=0 && $date >= Date('Y-m-d')) {
        
        //echo "$qry";
        $calendar .= "<td class='day' rel='$date' height='60px' align='center'>
          
      <strong><a class='new_sch'style='cursor:pointer;' onclick='add_schedule_form(\"$date\")'>".$date_print."</a></strong>";
       }else{
       
          $calendar .= "<td class='day' rel='$date' height='60px' align='center'>
		  <strong><a class='new_sch'style='cursor:pointer;' onclick='alert(&quot;Already Scheduled / Unable To Scedule On This Date.&quot;)'>".$date_print."</a></strong>";
                
          }

		  while($row = mysql_fetch_array($qry)){
									 if( $row['status']=='Pending'){ $background='#FF0033'; }
									else if( $row['status']=='Approved'){ $background='#FF0033'; }
									else if( $row['status']=='Deny'){ $background='#FF0033'; }
									else if( $row['status']=='Delete'){ $background='#FF0033'; }
									else{ $background='white'; }
								
                    
                
	   if($_SESSION['ROLE_can_edit']){ 
		    $calendar .="<div class='sch_list' title='Click here for update this schedule' style='background:$background; width:95%; border:1px black solid; cursor:pointer;' onclick='edit_sch(".$row['id'].")'>".strtoupper($row['unit'])."(".strtoupper($row['loc_need']).")</div>";
	    }else{
		     $calendar .="<div class='sch_list' style='background:$background; width:95%; border:1px black solid; cursor:pointer;' >".strtoupper($row['unit'])."(".strtoupper($row['loc_need']).")</div>";
	    }
	 }
			$calendar .="</td>";
          // Increment counters
 
          $currentDay++;
          $dayOfWeek++;

     
      

 }

     // Complete the row of the last week in month, if necessary

     if ($dayOfWeek != 7) { 
     
          $remainingDays = 7 - $dayOfWeek;
          $calendar .= "<th colspan='$remainingDays'>&nbsp;</th>"; 

     }
     
     $calendar .= "</tr>";

     $calendar .= "</table>";

     return $calendar;

	}//build_cal close

 
// <? //if close
echo $date_print;
echo build_calendar($month,$year);
	?>
  <script>
//   $("#filter_status").change(function() {
//   if ($(this).data('options') == undefined) {
//     /*Taking an array of all options-2 and kind of embedding it on the select1*/
//     $(this).data('options', $('#status option').clone());
//   }
//   var id = $(this).val();
//   var options = $(this).data('options').filter('[value=' + id + ']');
//   $('#status').html(options);
// });
function filter_input(txt){
  if(txt == 'Status'){
  //alert('hlo');
    $(".all").hide();
    $(".status").show();
  }else{
    $(".all").show();
    $(".status").hide();
  }
}

$(".status").change(function(){
 
  $('.sch_list').hide();
  var txt = $('.status').val();
  $('.sch_list:contains("'+txt+'")').show();
  if(txt==''){
    $('.sch_list').show();
  }
});
// $("#filter_sch").keyup(function() {
//   $('').hide();
//   var txt1 = $('').val();
//   $('.search:contains("'+txt1+'")').show();
//   if(txt==''){
//     $('.search').show();
//   }
  
// });
</script>
	<script>
  // var date_selected= <? echo $date_print ?>;
  
  function add_schedule_form(start_date){ 
    
    
      // var abc= <? echo $date_print ?>;
      $("#loading_spinner").show();
      var unit = "<?=$_POST['unit']?>";
      $.post('new_schedule_from_cal.php',{unit:unit,start_date:start_date},function(data){//alert(data);
          $('#schedule_abbr').hide();
          $("#sch_view_div").empty();
          $("#sch_view_div").html(data);
          $('#sch_view_div').show();
          $("#loading_spinner").hide();
      });
      //$("#schedule_month").load("new_sch_cal.php");
      
}


function edit_sch(id){ 
    
     $("#loading_spinner").show();
    $.post( "edit_schedule_from_cal.php",{ edit_id: id },function(data) {
          $('#schedule_abbr').hide();
          $("#sch_view_div").empty();
          $("#sch_view_div").html(data);
          $('#sch_view_div').show();
          $("#loading_spinner").hide();
          });
          
}

$("#sch_search").on('change', function() {//sch_list
	$('.sch_list').hide();
	var txt = $('#sch_search').val().toUpperCase();
	$('.sch_list:contains("'+txt+'")').show();
	if(txt==''){
		$('.sch_list').show();
	}
	//alert($("#sch_search").val());
});

$("#sch_search").on('keyup', function() {//sch_list
	$('.sch_list').hide();
	var txt = $('#sch_search').val().toUpperCase();
	$('.sch_list:contains("'+txt+'")').show();
	if(txt==''){
		$('.sch_list').show();
	}
	//alert($("#sch_search").val());
});
 var val="<?=$_POST['unit']?>";
$("#prev_month").on('click', function() {
	$("#loading_indicator").show();
	prev_month = $("#cal_month").val()-1;

  //<?php echo $prev_month; ?>
	year = $("#cal_year").val();
	if(prev_month==0){ 
    prev_month=12; year = year-1; }
	$.post( "events_calendar.php",{ unit:val, month: prev_month, year: year,view: 'Calendar' },function(data) {//alert("ho");
		$("#schedule_abbr").empty();
		$("#schedule_abbr").html(data);
		$("#loading_indicator").hide();
		});
});
$("#next_month").on('click', function() {
	$("#loading_indicator").show();
	next_month = parseInt($("#cal_month").val())+1;
	year = parseInt($("#cal_year").val());
	if(next_month==13){ next_month=1; year = year+1; }
	$.post( "events_calendar.php",{unit:val, month: next_month, year: year,view: 'Calendar'  },function(data) {//alert("hlo");
		$("#schedule_abbr").empty();
		$("#schedule_abbr").html(data);
		$("#loading_indicator").hide();
		});
});
function back_to_list(){
     $("#schedule_abbr").empty();
     $("#schedule_abbr").load('Schedule_Calendar.php');
}




	</script>