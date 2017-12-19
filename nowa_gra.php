<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']) || ($_SESSION['zalogowany']==false))
	{
		header('Location: enter.php');
		exit();
	}
	
	if (!isset($_GET['challenge']))
	exit();
	
	require_once "connect.php";
	
	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	
		if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
		exit();
	}
	
	$result = @$polaczenie->query(sprintf("SELECT * FROM challenges WHERE id='%s'", $_GET['challenge']));
	$result = $result->fetch_assoc();
	
	if ($result['challenged']!=$_SESSION['id'])
	{
		$_SESSION['message']="Nieładnie, nieładnie to próbować przyjąć wyzwanie za kogoś innego!";
		header('Location: account.php');
		exit();
	}
	
	@$polaczenie->query("UPDATE challenges SET received=CURRENT_TIME WHERE id=".$_GET['challenge']);
	
	if ($result['colors']!="choice")
	{
		@$polaczenie->query("INSERT INTO settings VALUES (NULL, '60', '38', '48', '49', '50', '58', '59', '61', '62', '70', '71', '82', '72', '3', '4', '5', '6', '7', '16', '33', '56', '87', '65', '54', '43', '44', '55', '64', '66', '77', '76', '104', '114', '115', '116', '117', '113')");
		//wstawiam do tabeli "settings" nowy rekord, wypełniam go ustawieniami początkowymi
		$setting_id = $polaczenie->insert_id;
	//nieprzypisanie settingu oznacza, że wybór kolorów pozostawiono drugiej stronie
	}
	else $setting_id = 0;
	$query = "INSERT INTO games VALUES (NULL, ";
	
	if ($result['colors']=="random")
	{
	//losowanie przydziału kolorów
		$colors = rand()%2;
		if ($colors) $query = $query.$result['challenging'].", ".$result['challenged'];
		else $query = $query.$result['challenged'].", ".$result['challenging'];
	}
	else if ($result['colors']=="black")
	{
		$query = $query.$result['challenged'].", ".$result['challenging'];
	}
	else
	{
		$query = $query.$result['challenging'].", ".$result['challenged'];
	}
	
	$query = $query.", CURRENT_TIME, '0000-00-00 00:00:00', 0, ".$result['id'].", ".$setting_id.", 0)";
	//wstawiam nowy rekord do tabeli "games": id, biały gracz, czarny gracz, czas rozpoczęcia, czas zakończenia, id wyzwania, id ustawienia figur, wykonanych ruchów:0 
	@$polaczenie->query($query);
	header('Location: game.php?game='.$polaczenie->insert_id);
	unset($result);
?>
