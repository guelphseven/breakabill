<?php

require_once "Mail.php";
require "/home/guelphseven/password.php";

$total=$_POST["total"];
$date=$_POST['date'];
$recipient=$_POST['recipient'];
$recipName=$_POST['name'];
$amount=$_POST['amount'];

$num=count($recipient);
$debtor=$_POST['debtor'];

$from = "Bill Payments <guelphseven@gmail.com>";
$subject = "Payment owed to $debtor";
$host = "ssl://smtp.gmail.com";
$port = "465";
$username="guelphseven@gmail.com";
$password=$MYSQL_PASS;

$smtp=MAIL::factory('smtp', array('host' => $host, 
	'port' => $port,
	'auth' => true,
	'username' => $username,
	'password' => $password));

for ($i=0; $i<$num; $i++)
{
	$body="A bill of $total has been split $num ways. You owe a portion of ".$amount[$i]." which is due on $date. The amount should be made payable to ".$debtor.".";
	$to = $recipName[$i].' <'.$recipient[$i].'>';
	$headers=array('From' => $from, 
		'To' => $to, 
		'Subject' => $subject);
	
	$mail = $smtp->send($to, $headers, $body);

	if (PEAR::isError($mail))
		echo ($mail->getMessage());
}


?>
