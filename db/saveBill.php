<?php
require '/home/guelphseven/password.php';
$jsonVar = json_decode(stripslashes($_POST['data']),true);
$billName = $jsonVar['billName'];
$userName = $jsonVar['billMaker'];
$email = $jsonVar['makerEmail'];
$total = $jsonVar['total'];
$dueDate = $jsonVar['duedate'];

$link = mysql_connect('localhost','billing',$MYSQL_PASS);
$db_selected = mysql_select_db('billing',$link);

$dateParts = split('/',$dueDate);
$dueDate = $dateParts[2] . $dateParts[0] . $dateParts[1];

$result = mysql_query("INSERT INTO bills VALUES ('','$billName','$userName','$email','$total',$dueDate)");

if(!$result){
	die("Error: " . mysql_error());	
}

$result = mysql_query("SELECT id FROM bills WHERE billName = '$billName' AND userName='$userName' AND email='$email'");

if(!$result){
	die("Error: " . mysql_error());
}

$id = mysql_fetch_array($result);

$people = $jsonVar['people'];

foreach($people as $p){
	$name = $p['name'];
	$email = $p['email'];
	$total = $p['total'];
	$result = mysql_query("INSERT INTO debtors VALUES ($id[0],'$name','$email','$total')");
	if(!$result){
		die("Error: " . mysql_error());
	}
}

/*if(count($people) > 1){
	for($i=0; $i < count($people);$i++){
		$result = mysql_query("INSERT INTO debtors VALUES ($id[0],'$name[$i]','$email[$i]','$total[$i]')");
		if(!$result){
			die("Error: " . mysql_error());	
		}
	}
}*/
header('HTTP/1.0 200 OK');
?>
