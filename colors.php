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
	
	if (!isset($_GET['adv_id']))
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
	
	@$polaczenie->query("INSERT INTO settings VALUES (NULL, '60', '38', '48', '49', '50', '58', '59', '61', '62', '70', '71', '82', '72', '3', '4', '5', '6', '7', '16', '33', '56', '87', '65', '54', '43', '44', '55', '64', '66', '77', '76', '104', '114', '115', '116', '117', '113')");
	//wstawiam do tabeli "settings" nowy rekord, wypełniam go ustawieniami początkowymi
	$setting_id = $polaczenie->insert_id;
	
	if ($_POST['color']=="white")
	{
		$white = $_SESSION['id'];
		$black = $_GET['adv_id'];
	}
	else
	{
		$black = $_SESSION['id'];
		$white = $_GET['adv_id'];
	}
	
	$query = "UPDATE games SET id_black=".$black.", id_white=".$white.", setting=".$setting_id." WHERE id=".$_GET['game'];

	@$polaczenie->query($query);
	
	header('Location: game.php?game='.$_GET['game']);
?>
