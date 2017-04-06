<?php

  session_start();
  error_reporting(0);
   include_once('connect.php');
   ini_set("max_execution_time", 5000);
 
$mbval='';
date_default_timezone_set("EST5EDT"); 
$filename = date('YmdHis').".csv";

if( $_REQUEST["csv_string"]!='' & isset($_REQUEST["create_for"]) )
{
 file_put_contents("csvreport/".$filename,$_REQUEST["csv_string"]);
 echo "csvreport/".$filename;



if( $_REQUEST["email"]!='' & $_REQUEST["csv_string"]!='' )
{

require_once "Mail.php";
require_once 'Mail/mime.php';

$body  = $_REQUEST["create_for"]." Report";
$subject = $_REQUEST["create_for"]." Report";
$usermail = $_REQUEST["email"];
$reciept = @$_POST["reciept"];
$isMail  = @$_POST["isMail"];


error_reporting(0);
 


  $from = "NO_REPLY_VOLTS<noreply.volts@gmail.com>";
    
        $host = "ssl://smtp.gmail.com";
        $port = "465";
        $username = "noreply.volts@gmail.com";  //<> give errors
        $password = "saurabhlew";

        $headers = array ('From' => $from,
          'To' => $usermail,
          'Subject' => $subject);
        $smtp = @Mail::factory('smtp',
          array ('host' => $host,
            'port' => $port,
            'auth' => true,
            'username' => $username,
            'password' => $password));
    
  $mime = new Mail_mime($crlf);
  $mime->setTXTBody($body);
  $mime->setHTMLBody($body);
  $str = "csvreport/".$filename;
  $mime->addAttachment($str, 'text/plain');
  $body = $mime->get();
  $headers = $mime->headers($headers);

        $mail = $smtp->send($usermail, $headers, $body);
 
   if (@PEAR::isError($mail)) 
   {
          echo($mail->getMessage() );
      } 
   else
   {
  // echo $_REQUEST["filename"];
        // echo("Email successfully sent! to ".$_REQUEST["email"]);
      }
	 
}
}

?>

