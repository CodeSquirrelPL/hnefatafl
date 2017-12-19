<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']) || ($_SESSION['zalogowany']==false))
	{
		header('Location: enter.php');
		exit();
	}
	
	if (!isset($_GET['game']))
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

	
	$result = @$polaczenie->query(sprintf("SELECT id_black, id_white FROM games WHERE id='%s'", $_GET['game']));
	$game = $result->fetch_assoc();
	$result->free_result();
	
	if ($game['id_white']==$_SESSION['id'])
	{
		$winner = $game['id_black'];
	}
	else if ($game['id_black']==$_SESSION['id'])
	{
		$winner = $game['id_white'];
	}
	else exit();

	@$polaczenie->query(sprintf("UPDATE games SET winner='%s' WHERE id='%s'", $winner, $_GET['game']));
	
	$_SESSION['message']="Poddałeś_aś grę.";
	
	header('Location: game.php?game='.$_GET['game']);

?>
