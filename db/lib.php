<?php
require_once "/home/guelphseven/password.php";
function httpDeath($code) {
	$table = array(
		200 => "OK",
		400 => "Bad Request",
		401 => "Unauthorized",
		404 => "Not Found",
		503 => "Service Unavailable"
	);

	header("HTTP/1.0 $code $table[$code]");
	exit();
}
function isValidUsername($username) {
	if(!ctype_alnum($username) || strlen($username) < 4 || strlen($username) > 20) {
		return false;
	}

	return true;
}
function startSQLConnection() {
	global $MYSQL_PASS;
	if(mysql_connect('localhost', 'billing', $MYSQL_PASS)) {
		if(mysql_select_db('billing')) {
			return true;
		}
	}
	return false;
}

function findOpenBills($user)
{
	$query = "SELECT * FROM bills WHERE user_id = $user";
	$result = mysql_query($query);
	if ($result)
	{
		$bills = array();
		while($row = mysql_fetch_assoc($result))
		{
			$bills[] = $row;
		}
		return $bills;
	}
	
	return false;
	
}

function getBillByID($billid)
{
	$query = "SELECT * FROM bills WHERE bill_id=$billid;";
	$result = mysql_query($query);
	if ($result)
	{
		$bill = mysql_fetch_assoc($result);
		$bill['people'] = array();
		mysql_free_result($result);
		$query = "SELECT * FROM debtors WHERE bill_id = $billid;";
		$result = mysql_query($query);
		
		if ($result)
		{
			while ($row = mysql_fetch_assoc($result))
			{
				$bill['people'][] = $row;
			}
		}
	}
	
	return $bill;
}

function checkLogin($username, $password)
{
	$hash = md5($username.$password);
	$query = "SELECT * FROM users WHERE username='$username' AND hash='$hash';";
	//echo $query;
	$result = mysql_query($query);

	if ($result)
	{
		if (mysql_num_rows($result) < 1)
		{
			return false;
		}
		$results = mysql_fetch_assoc($result);
		return $results;
	}
	return false;
}

function insertDebtor($bill, $name, $email, $amount)
{
	$query = "INSERT INTO debtors (bill_id, name, email, amount) VALUES ($bill, '$name', '$email', '$amount');";
	mysql_query($query);
	
	return true;
}
function saveBill($user, $billName, $billAmount, $ownerAmount, $dueDate, $debtors)
{
	$query = "INSERT INTO bills (user_id, billName, billAmount, ownerAmount, dueDate) VALUES ($user, '$billName', '$billAmount', '$ownerAmount', '$dueDate');";
	$result = mysql_query($query);
	/*
	$query = "SELECT LAST_INSERT_ID();";
	$result = mysql_query($query);
	$number = mysql_fetch_array($result, MYSQL_NUM);
	print_r($number);
	*/
	$billid = mysql_insert_id();
	foreach ($debtors as $debtor)
	{
		insertDebtor($billid, $debtor['name'], $debtor['email'], $debtor['total']);
	}
	
	return true;
}

function deleteBill($billid)
{
	$query = "DELETE FROM bills WHERE id = $billid;";
	mysql_query($query);
	
	return true;
}

function registerUser($username, $password)
{
	$hash = md5($username.$password);
	$query = "INSERT INTO users (username, hash) VALUES ('$username', '$hash');";
	$result = mysql_query($query);
	print_r($result);
	
	return true;
}
?>