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
	
	//	'game_end.php?game='+game+'&winner='+winner+'&setting='+setting
	
	echo 'game over. the winner is: '.$_GET['winner'];
	
	$polaczenie->query("UPDATE games SET winner=".$_GET['winner']);

?>
