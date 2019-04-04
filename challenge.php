<?php

	require_once "php/functions/phpHeader.php";


	if (!isset($_GET['id']))
	{
		header('Location: account.php');
		exit();
	}

	if ($_GET['id']==$_SESSION['id'])
	{
		$_SESSION['message'] = "Nie możesz wysłać wyzwania sobie.";
		header('Location: account.php');
		exit();
	}


	$result = @$polaczenie->query(sprintf("SELECT id FROM challenges WHERE received='0000-00-00 00:00:00' AND ((challenging='%s' AND challenged='%s') OR (challenging='%s' AND challenged='%s'))", $_SESSION['id'], $_GET['id'], $_GET['id'], $_SESSION['id']));

	$result = $result->num_rows;

	if ($result==0)
	{
		if (@$polaczenie->query(sprintf("INSERT INTO challenges VALUES (NULL, '%s', '%s', CURRENT_TIME, '0000-00-00 00:00:00', '%s', '0')", $_SESSION['id'], $_GET['id'], $_POST['colors'])))
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
