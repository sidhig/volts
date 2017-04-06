<?
include_once('connect.php'); 
$result = $conn->query("select * from devicedetails where DeviceIMEI = '".$_REQUEST['imei']."'");
$obj = $result->fetch_object();
//print_r($obj);
$str = '';
foreach($obj as $val){
	$str.=$val.',';
}
echo rtrim($str,',');
?>