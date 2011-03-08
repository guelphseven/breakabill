<?php
/* */
$billName = "Cocane";
$userName = "Chris Statham";
$email = "cstatham@uoguelph.ca";
$total = "100";
$dueDate = "03/01/2011";

require '/home/guelphseven/password.php';

$link = mysql_connect('127.0.0.1','billing',$MYSQL_PASS);
$db_selected = mysql_select_db('billing',$link);

$result = mysql_query("INSERT INTO bills VALUES ('$billName','$userName','$total*100','$dueDate')");

if(!mysql_query($result,$link)){
	die("Error: " . mysql_error());	
}

//$debtor = $_POST['debtorName'];
//$email = $_POST['debtorEmail'];
//$amounts = $_POST['amount'];

$debtor = "charlie";
$email = "spyman40@gmail.com";
$amount = "100";

for($i=0; $i < count($debtor);$i++){
	$result = ("INSERT INTO debtors VALUES ('$debtor[$i]','$email[$i]','$amount')");
}



?>
