<?php
	require_once "lib.php";
	
	$error = 0;
	if (!isset($_POST['password']) || !isset($_POST['username']) || !isset($_POST['name']) || !isset($_POST['email']))
	{
		$error = 1;
	}
	else if ($_POST['password'] != $_POST['confirm'])
	{
		$error = 2;
	}
	if ($error != 0)
	{
		header("Location: ../web_frontend/boilerplate/register.php");
		exit();
	}

	startSQLConnection();
	registerUser($_POST['username'], $_POST['password'], $_POST['name'], $_POST['email']);
	//stopSQLConnection();
	
	header("Location: ../web_frontend/boilerplate/login.php");
?>