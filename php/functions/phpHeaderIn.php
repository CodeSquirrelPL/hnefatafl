<?php

	session_start();

	if (isset($_SESSION['zalogowany']) && ($_SESSION['zalogowany']==true))
	{
		header('Location: ../../account.php');
		exit();
	}

	require_once "connect.php";

	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

		if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
		exit();
	}

?>
