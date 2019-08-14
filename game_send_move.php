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

	require_once "php/functions/connect.php";

	$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

		if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
		exit();
	}

	echo $_GET['a'].' ('.$_GET['counter'].') na '.$_GET['b'].' ustawienie: '.$_GET['setting'].'gra: '.$_GET['game'];

	$result = $polaczenie->query(sprintf("SELECT * FROM settings WHERE id='%s'", $_GET['setting']));
	$result = $result->fetch_assoc();

	if ($_GET['counter']==3)
	{
		for ($i=1; $i<25; $i++)
		{
			if ($result['black'.$i]==$_GET['a'])
			{
				$polaczenie->query("UPDATE settings SET black".$i."=".$_GET['b']." WHERE id=".$_GET['setting']);
				$polaczenie->query("UPDATE games SET move=move+1 WHERE id=".$_GET['game']);
				$i=25;
			}
		}
	}

	else if ($_GET['counter']==2)
	{
		for ($i=1; $i<13; $i++)
		{
			if ($result['white'.$i]==$_GET['a'])
			{
				$polaczenie->query("UPDATE settings SET white".$i."=".$_GET['b']." WHERE id=".$_GET['setting']);
				$polaczenie->query("UPDATE games SET move=move+1 WHERE id=".$_GET['game']);
				$i=13;
			}
		}
	}

	else if ($_GET['counter']==1)
	{
		if ($result['king']==$_GET['a'])
		$polaczenie->query("UPDATE settings SET king=".$_GET['b']." WHERE id=".$_GET['setting']);
		$polaczenie->query("UPDATE games SET move=move+1 WHERE id=".$_GET['game']);
	}
?>
