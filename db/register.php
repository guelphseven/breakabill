<?php
	require_once "lib.php";
	if (!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['confirm']))
	{
		httpDeath(400);
		exit();
	}
	
	if ($_POST['password'] != $_POST['confirm'])
	{
		header("Location: register.php");
		exit();
	}
	startSQLConnection();
	registerUser($_POST['username'], $_POST['password']);
	//stopSQLConnection();
	
	header("Location: ../web_frontend/boilerplate/login.php");
?>