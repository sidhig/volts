<?
			include_once('connect.php');
			session_start();
?>
<style>
div.scroll {
   background: #fff;height: 60vh;
    overflow-y: scroll;
    /*width: 88%;
    min-height: 45vh;*/
    
    border: rgba(116, 111, 111, 0.37) 2px solid;
    /*padding: 1vh;
    border-radius: 5px;*/
}
</style>
<style>
.ui-datepicker-trigger{
    width: 4vw;
	margin: 1vw;
	margin-top: -155px;
}
.wrapper_date1 {
    position: relative;
    width: 70px;
    height: 70px;
    overflow: hidden;
	margin-top: 0px;
    margin-left: 135PX;
	FLOAT:left;
}
.date_image {
    border: 0;
    width: 70px;
    height: 70px;
    line-height: 24px;
    position: absolute;
    top: 0;
    left: 0;
    background: #fff;
    box-sizing: border-box;
}
.picker_text {
    width: 200px;
    height: 70px;
    font-size: 999px;
    opacity: 0;
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
	cursor:pointer;
}

</style>
<?
if($_REQUEST['date_pic']!=''){
	$i=0;
     $next=date('Y-m-d', strtotime('+1 day', strtotime($_REQUEST['date_pic'])));
 $result = $conn->query("select count(*) as 'offset' from tbl_camera_data where pic_url is not null and date(ADDTIME(created,'0 7:00:00'))>='".$next."' and camid='".$_REQUEST['camid']."'")->fetch_assoc();



	//$result = $conn->query("select count(*) as 'offset' from tbl_camera_data where pic_url is not null and date(ADDTIME(created,'0 7:00:00'))>='".$_REQUEST['date_pic']."' and camid='".$_REQUEST['camid']."'")->fetch_assoc();
	$offset = $result['offset'];

	$result = $conn->query("select *,(ADDTIME(created,'0 7:00:00')) as 'created_new' from tbl_camera_data where pic_url is not null and date(ADDTIME(created,'0 7:00:00'))='".$_REQUEST['date_pic']."' and camid='".$_REQUEST['camid']."' order by id desc");
	?>
	<center>
<div style='background:white; font-size: 1.2rem; width: 50vw;
    min-height: 50vh;
    border: #746F6F 1px solid;
    background-color: white;
    border-radius: 4px;
    padding: 1vw;'>
 <table width="100%" style="table-layout:fixed;margin-bottom: 1vh;">
    <tr>
    	<th style='text-align:left;width: 30%;'><input onclick='$("#camera_his_div,#wait_msg_history").hide(); $("#camera_his_div").html(""); $(".picker_text").val("") ' type="button" value="Back" /></th>
    	<th style='text-align:center;width: 33%;'>History <br><strong>Date: </strong><?=date('m-d-Y',strtotime($_REQUEST['date_pic']))?></th>
    	<td style='text-align:right;width: 33%;'>
			<div class="wrapper_date1"><!--value='<?=date('Y-m-d',strtotime($image['new_created']))?>'-->
			<? $max_pic_date = $conn->query("select max(ADDTIME(created,'0 7:00:00')) as 'max_date' ,min(ADDTIME(created,'0 7:00:00')) as 'min_date' from tbl_camera_data where pic_url is not null and camid='".$_REQUEST['camid']."'")->fetch_assoc();
		    ?>
				<img class="date_image" src="image/calendar.jpg" >
				<input class="picker_text" 
					max='<?=date('Y-m-d',strtotime($max_pic_date['max_date']))?>' 
					min='<?=date('Y-m-d',strtotime($max_pic_date['min_date']))?>' 
					onchange='$("#wait_msg_list").show(); get_image_list("<?=$_REQUEST['poi_id']?>","<?=$_REQUEST['camid']?>","",this.value);' 
					type="date">
			</div>
		</td>
    </tr>
 </table>
	<div class="scroll" >
	<table class="table table-hover" style=''>
	<tr ><!--<th >#</th><th style="text-align:center;">Image</th><th style="text-align:right;padding-right:1vw;">Created</th></tr>-->
	<?
	if($result->num_rows>0){
	while($obj = $result->fetch_object()){
	++$i;	//echo $row['created_new'].'<br>';
?>
		
      <td style="text-align:center;width: 33%;background: url('image/spinner.gif') no-repeat center;background-size: 5%;">
		<img src="../Campics/<?=$obj->pic_url?>" width="50%" style='cursor:pointer;border:1px solid #746F6F;' onclick="$('#wait_msg_list').show(); view_poi_image('<?=$_REQUEST['poi_id']?>','<?=$_REQUEST['camid']?>',<?=$offset++?>,'');"><br><?=date('h:i:s A',strtotime($obj->created_new))?></td>
	  <? if($i%3==0){ ?> </tr> <tr><? } ?>
<?
	}} else{ ?>
<td colspan='3'>No Image Found on this date.</td></tr>
	<? } ?>
</table>
</div>
	<?
} ?>
<span id='wait_msg_list' style='display:none; color:red;' ><img src='image/spinner.gif' width='16px' > Please wait while we get the picture</span>
</div>
</center>