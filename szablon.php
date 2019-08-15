<?php

	session_start();

	if (!isset($_SESSION['zalogowany']) || ($_SESSION['zalogowany']==false))
	{
		header('Location: enter.php');
		exit();
	}

	require_once "php/functions/connect.php";

	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

		if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
		exit();
	}

	$rezultat = @$polaczenie->query("SELECT id FROM challenges WHERE challenged=".$_SESSION['id']." AND received='0000-00-00 00:00:00'");
	$_SESSION['challenges']=$rezultat->num_rows;
	$rezultat = @$polaczenie->query("SELECT id FROM games WHERE (id_black='".$_SESSION['id']."' OR id_white='".$_SESSION['id']."') AND date_finish='0000-00-00 00:00:00'");
	$_SESSION['games']=$rezultat->num_rows;
	$rezultat->free_result();

?>


<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Hnefatafl - szablon</title>

	<meta name="description" content="Hnafatafl - szachy wikingów" />
	<meta name="keywords" content="hnefatafl, szachy wikingów, wikingowie, szachy" />

	<link rel="stylesheet" href="css/main.css" type="text/css" />
<link rel="stylesheet" media="(min-width: 1199px)" href="css/maxi.css" type="text/css" />
<link rel="stylesheet" media="(max-width: 1200px) and (min-width: 800px)" href="css/midi.css" type="text/css" />
<link rel="stylesheet" media="(max-width: 800px)" href="css/mini.css" type="text/css" />
	<script src="register.js"></script>

</head>

<body>
<div id="container">
<nav class="userbar">
	<?php

		require_once "php/functions/userbar.php";

	?>
	</nav>
	<header>
	<h1>Hnefatafl</h1>
	<h6></h6>
	</header>

	<nav class="menu">
		<a href="index.php" class="menu__button">Zagraj przy jednym komputerze</a>
		<a href="rules.php" class="menu__button">Zasady</a>

		<div class="empty"></div>
	</nav>
	<div id="content">

		Tu wpisz jakiś tekst

	</div>

	<footer>© Copyright 2017-2019 Paulina Filipiak</footer>

</div>
</body>
</html>
