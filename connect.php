<?
 error_reporting(0);
$conn = new mysqli('localhost', 'root', '', "xirgo");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
   } 
   else
   {
		$conn->query("set time_zone = '-5:00' ");
   }

?>

<?

$user_name = "root";
$password = "";
$database = "xirgo";
$server = "localhost";

$db_handle = mysql_connect($server, $user_name, $password);
$db_found = mysql_select_db($database, $db_handle);

mysql_query("set time_zone = '-5:00' ");

?>