<?php
	require '/home/guelphseven/password.php';

	if (!isset($_GET['bill']))
	{
		echo ("Invalid bill specified!");
		exit();
	}
	$id=$_GET['bill'];
	if (!ctype_digit($id))
	{
		echo ("Invalid bill specified!");
		exit();
	}

	$mysql=mysql_connect('localhost', 'billing', $MYSQL_PASS);
	if (!$mysql || !mysql_select_db('billing', $mysql))
	{
		echo ("There's something wrong with the database!");
		exit();
	}

	$res=mysql_query("select billName, total, dueDate from bills where id=$id;", $mysql);
	if (mysql_num_rows($res)!=1)
	{
		echo ("Invalid bill specified!");
		exit();
	}
	$billName=mysql_result($res, 0, "billName");
	$total=mysql_result($res, 0, "total");
	$dueDate=mysql_result($res, 0, "dueDate");
	echo ("$billName\n$total\n$dueDate\n");

	$res=mysql_query("select name, email, amount from debtors where id=$id");
	for ($i=0; $i<mysql_num_rows($res); $i++)
	{
		$debtorName[$i]=mysql_result($res, $i, "name");
		$debtorEmail[$i]=mysql_result($res, $i, "email");
		$amount[$i]=mysql_result($res, $i, "amount");
		echo ($debtorName[$i]." ".$debtorEmail[$i]." ".$amount[$i]."\n");
	}

?>
