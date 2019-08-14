<?php
	
	session_start();
	
	
	
	require_once "php/functions/connect.php";
	
	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	
		if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
		exit();
	}
	
	$polaczenie->query("UPDATE users SET online=0 WHERE id=".$_SESSION['id']);
	
	session_unset();
	
	$polaczenie->close();
	
	header('Location: index.php');
	
?>
