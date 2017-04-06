<?php
error_reporting(0);
include_once('Mail.php');
  

$subject = 'mhghghghjghghjg' ;
$body = "hello";
$usermail = 'diamondsaurabh@gmail.com'
  $from = "noreply.volts@gmail.com";
    
        $host = "ssl://smtp.gmail.com";
        $port = "465";
        $username =  "noreply.volts@gmail.com"; //<> give errors
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
       $mail = $smtp->send($usermail, $headers, $body);
 
   if (@PEAR::isError($mail)) {
          echo ("<p>" . $mail->getMessage() . "</p>");
         } else {
         //echo ("<p>Message successfully sent!</p>");
         }

?>
