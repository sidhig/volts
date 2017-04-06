<?
 include_once('connect.php');
?>

<script src="js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<script>
$(document).ready(function() {
    $('#disp_his_data').DataTable( {
        //"scrollY":        "200px",
        "scrollCollapse": true,
        "paging":         true,
        order: [[ 0, 'desc' ], [ 0, 'asc' ]]

          } );
} );

function back_to_dispatch(){
	$('#dispatch_history').hide();
    $('#dispatch_view').show();
}
</script>

<style>
    #disp_his_data_info{
        display: none;
    }
    #disp_his_data_filter{
    	/*margin-right: 3vw;
    	display:none;*/
    }
    /*#example_paginate{
    	display: none;
    }*/
</style>
<button onclick='back_to_dispatch();' style="margin-right: 92vw;margin-bottom: 4vh;">Back</button>
<table id="disp_his_data" class="display" border="1" style="margin-top:3vh;">
		<thead>
	<tr><th>From</th><th>TO</th><th>Phone No.</th><th>Message</th><th>Time</th><th>POI Name</th><th>Address</th><th>Location</th></tr>
</thead>
<tbody style="font-size:1.2rem;">
<?
		  $qry = mysql_query("select * from `dispatch_details` order by `id` desc");

		  while($row = mysql_fetch_array($qry)){
if($row['is_poi'] =='0'){
	$add_str=$row['address'].','.$row['city'].','.$row['state'].','.$row['zip'];
}else{
	$add_str='';
}
		  	?>

<tr>
<th><?=$row['from']?></th>
<th><?=$row['name']?></th>
<th><?=$row['phone']?></th>
<th><?=$row['message']?></th>
<th><?=DATE_FORMAT(date_create($row['time']),'m-d-Y h:i A')?></th>
<th><?=$row['poi']?></th>
<th><?=$add_str?></th>
<th><center><a target="_blank" href="http://maps.google.com/?q=<?=$row['location']?>"><img src="image/activity_search_icon.png" style="height: 5vh;"></a></center></th>
</tr>
<? }
?>
</tbody>
</table>
