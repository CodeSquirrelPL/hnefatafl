<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']) || ($_SESSION['zalogowany']==false))
	{
		header('Location: enter.php');
		exit();
	}
	
	/*if (!isset($_GET['game']))
	{
		header('Location: user.php');
		exit();
	}*/
	
	require_once "connect.php";
	
	$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
	
		if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
		exit();
	}
	
	//$_GET['where'], $_GET['counter'], $_GET['setting'];
	
	$result = $polaczenie->query(sprintf("SELECT * FROM settings WHERE id='%s'", $_GET['setting']));
	$result = $result->fetch_assoc();
	
	if ($_GET['counter']==3)
	{	
		for ($i=1; $i<25; $i++)
		{
			if ($result['black'.$i]==$_GET['where'])
			{	
				echo $polaczenie->query("UPDATE settings SET black".$i."=0 WHERE id=".$_GET['setting']);
				$i=25;
			}
		}
	}
	else if ($_GET['counter']==2)
	{	
		for ($i=1; $i<13; $i++)
		{
			if ($result['white'.$i]==$_GET['where'])
			{
				echo $polaczenie->query("UPDATE settings SET white".$i."=0 WHERE id=".$_GET['setting']);
				$i=13;
			}
		}
	}

?>
