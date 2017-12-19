<?php

	session_start();

	if (!isset($_SESSION['zalogowany']) || ($_SESSION['zalogowany']==false))
	{
		header('Location: enter.php');
		exit();
	}

	if (!isset($_GET['id']))
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

	$result = @$polaczenie->query(sprintf("SELECT id FROM challenges WHERE challenging='%s' AND challenged='%s'", $_SESSION['id'], $_GET['id']));

	$result = $result->num_rows;

	if ($result==0)
	{
		if (@$polaczenie->query(sprintf("INSERT INTO challenges VALUES (NULL, '%s', '%s', CURRENT_TIME, '0000-00-00 00:00:00', '%s')", $_SESSION['id'], $_GET['id'], $_POST['colors'])))
		{
		$_SESSION['message'] = "Wyzwanie zostało wysłane.";
		header('Location: user.php?id='.$_GET['id']);
		}
		else echo "ERROR";
	}
	else
	{
		$_SESSION['message'] = "Nie możesz wysłać następnego wyzwania do tego samego użytkownika, zanim poprzednie nie zostanie przyjęte lub odrzucone.";
		header('Location: user.php?id='.$_GET['id']);
	}
?>
