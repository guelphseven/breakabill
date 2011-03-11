<?php
require_once '/home/guelphseven/password.php';
require_once "lib.php";
session_start();
if (!isset($_SESSION['username']))
{
	//not logged in!
	exit();
}

$jsonVar = json_decode(stripslashes($_POST['data']),true);
$billName = $jsonVar['billName'];
$billAmount = $jsonVar['billAmount'];
$userName = $jsonVar['billMaker'];
$email = $jsonVar['makerEmail'];
$total = $jsonVar['total'];
$dueDate = $jsonVar['duedate'];

$link = mysql_connect('localhost','billing',$MYSQL_PASS);
$db_selected = mysql_select_db('billing',$link);

$dateParts = split('/',$dueDate);
$dueDate = $dateParts[2] . $dateParts[0] . $dateParts[1];

$debtors = $jsonVar['people'];

saveBill($_SESSION['userid'], $billName, $billAmount, $total, $dueDate, $debtors);
header('HTTP/1.0 200 OK');
?>
