<?
include_once('connect.php');
session_start();
$result = $conn->query("select count(*) as 'updated_rows',pic_status from tbl_camera_data where camid='".$_REQUEST['camid']."' and ADDTIME(created,'0 7:00:00') > '".$_REQUEST['max_date']."' order by id desc");
$status = $result->fetch_assoc();
echo $status['updated_rows'].','.$status['pic_status'];
?>