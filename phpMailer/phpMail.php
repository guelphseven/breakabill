<?php

require_once "Mail.php";
require "/home/guelphseven/password.php";

$jsonVar=json_decode(stripslashes($_POST['data']),true);
$billName=$jsonVar['billName'];
$total=$jsonVar['billAmount'];
$date=$jsonVar['duedate'];
$people=$jsonVar['people'];
$debtor=$jsonVar['billMaker'];
$debtorAmount=$jsonVar['total'];
$debtorEmail=$jsonVar['makerEmail'];


$num=count($people);
for ($i=0; $i<$num; $i++)
{
	$recipient[$i]=$people[$i]['email'];
	$recipName[$i]=$people[$i]['name'];
	$amount[$i]=$people[$i]['total'];
	$percent[$i]=$amount[$i]/$total*100;
}

$creatorBody="Hello $debtor,\n\nThank you for choosing Break A Bill!\n\nYour bill has been created with the following debts due on $date:\n\n";
$creatorBody.="$debtor: \$$debtorAmount\n";

$from = "Bill Payments <guelphseven@gmail.com>";
$subject = "Break A Bill: Payment owed to $debtor";
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
	$body="Hello $recipName[$i],you have been included on a bill \"$billName\"!\n\n  $debtor wants you to know that you owe \$$amount[$i] which is $percent[$i]% of \$$total. The payment has been made due on $date. The amount should be made payable to $debtor.\n\nKind regards, the Split A Bill team\n";
	$creatorBody.="$recipName[$i]:  \$$amount[$i]\n";
	$to = $recipName[$i].' <'.$recipient[$i].'>';
	$headers=array('From' => $from, 
		'To' => $to, 
		'Subject' => $subject);
	

	$mail = $smtp->send($to, $headers, $body);
	if (PEAR::isError($mail))
		echo ($mail->getMessage());
}

$creatorBody.="\nKind regards, the Split A Bill team\n";
$subject="Break A Bill: \"$billName\" distributed";
$to=$debtorEmail;
$headers=array('From' => $from, 
	'To' => $to, 
	'Subject' => $subject);
	$mail = $smtp->send($to, $headers, $body);
	if (PEAR::isError($mail))
		echo ($mail->getMessage());
?>
