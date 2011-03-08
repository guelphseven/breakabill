<?php
 
require '/home/guelphseven/password.php';
$billName = "Cocane";
$userName = "Chris Statham";
$email = "cstatham@uoguelph.ca";
$total = "100";
$dueDate = "10-3-2011";

$link = mysql_connect('localhost','billing',$MYSQL_PASS);
$db_selected = mysql_select_db('billing',$link);
$dueDate = strtotime($dueDate);
$result = mysql_query("INSERT INTO bills VALUES ('','$billName','$userName','$email','$total',$dueDate)");

if(!$result){
	die("Error: " . mysql_error());	
}

$result = mysql_query("SELECT id FROM bills WHERE billName = '$billName'");

if(!$result){
	die("Error: " . mysql_error());
}

$id = mysql_fetch_array($result);
//$debtor = $_POST['debtorName'];
//$email = $_POST['debtorEmail'];
//$amounts = $_POST['amount'];

$debtor = array("Charlie Sheen","Robin Williams");
$email = array("spyman40@gmail.com","chris@statham.ca");
$amount = array("50","50");

for($i=0; $i < count($debtor);$i++){
	$result = mysql_query("INSERT INTO debtors VALUES ('$id[0]','$debtor[$i]','$email[$i]','$amount[$i]')");
	
	if(!$result){
		die("Error: " . mysql_error());	
	}
}

?>
