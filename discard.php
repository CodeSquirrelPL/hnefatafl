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

	
	$result = @$polaczenie->query(sprintf("SELECT "));
	$challenge = $result->fetch_assoc();
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

	@$polaczenie->query(sprintf("UPDATE challenges SET received=CURRENT_TIME, colors=NULL"));
	
	$_SESSION['message']="Odrzuciłeś_aś wyzwanie";
	
	header('Location: account.php);

?>
