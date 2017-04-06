<? session_start();
session_destroy();
if($_SESSION['samlNameId']!='')
{
	header("location: webauth.php");
}
else
{
	header("location: index.php");
}
 ?>}
