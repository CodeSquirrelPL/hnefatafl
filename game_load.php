<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']) || ($_SESSION['zalogowany']==false))
	{
		header('Location: enter.php');
		exit();
	}
	
	if (!isset($_GET['game']))
	{
		header('Location: user.php');
		exit();
	}
	
	require_once "php/functions/connect.php";
	
	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	
		if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
		exit();
	}
	
	

?>
