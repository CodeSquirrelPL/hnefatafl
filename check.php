<?php

	session_start();
	
	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		header('Location: account.php');
		exit();
	}

	require_once "connect.php";

	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
		exit();
	}
	
	
	if ($_GET['check']=='key')
	{
		$result = @$polaczenie->query("SELECT content FROM others WHERE id='1'");
		$result = $result->fetch_assoc();
		$key = $result['content'];
		
		if ($key!=$_POST['key'])
		{
			$_SESSION['error_key'] = "Podano niewłaściwy klucz";
			header('Location: enter.php');
			exit();
		}
			else
			unset($_SESSION['error_key']);
	}
	
	else if ($_GET['check']=='login')
	{
		if (!isset($_GET['login']))
		{
		header('Location: account.php');
		exit();
		}
		
		$login = $_GET['login'];
		$result = @$polaczenie->query(sprintf("SELECT id FROM users WHERE login='%s'", mysqli_real_escape_string($polaczenie,$login)));
		$result = $result->fetch_assoc();
		
		echo $login;
		/*
		if ($result['num_rows']>0)
		{
			echo 1;
		}
		else
		{
			echo 0;
		}*/
	}
	
	else if ($_GET['check']=='pass')
	{	
		if (isset($_GET['pass']) && isset($_GET['pass']))
		{
			if ($_POST['pass']!=$_POST['pass2'])
			{
				$_SESSION['error_pass']="Wpisano dwa różne hasła";
				header('Location: enter.php');
				exit();
			}
			else
			{
				unset($_SESSION['error_pass']);
				$pass=$_POST['pass'];
			}
		}
		else	{	header('Location: account.php');	exit();	}
	}
	else if ($_GET['check']=='test')
	{
		echo "t";
	}
	else 
	{
		header('Location: account.php');
		exit();
	}
	
	
?>
