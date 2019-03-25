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

	require_once "connect.php";

	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

		if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
		exit();
	}

	$result = $polaczenie->query("SELECT winner AND date_finish FROM games WHERE id=".$_GET['game']);
	$result = $result->fetch_assoc();
	if ($result['winner']==0 || $result['date_finish']) exit();

	$polaczenie->query("UPDATE games SET date_finish=CURRENT_TIME");
?>
