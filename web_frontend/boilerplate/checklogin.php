<?php
	require_once "../../db/lib.php";

	startSQLConnection();
	$info = checkLogin($_POST['username'], $_POST['password']);
	if ($info != false)
	{
		session_start();
		$_SESSION['username'] = $info['username'];
		$_SESSION['userid'] = $info['id'];
		$_SESSION['name'] = $info['name'];
		$_SESSION['email'] = $info['email'];
		$_SESSION['userhash'] = md5( $info['username'] . $_SESSION['password'] );
		header("Location: home.php");
		echo "Logged in";
	}
	else
	{
		echo "401 - Unauthorized";
		httpDeath(401);
	}
?>