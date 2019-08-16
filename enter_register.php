<?php

	session_start();

	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		header('Location: account.php');
		exit();
	}
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Hnefatafl - logowanie</title>

	<meta name="description" content="Hnafatafl - szachy wikingów" />
	<meta name="keywords" content="hnefatafl, szachy wikingów, wikingowie, szachy" />

	<link rel="stylesheet" href="css/main.css" type="text/css" />
<link rel="stylesheet" href="css/logout.css" type="text/css" />
<link rel="stylesheet" media="(min-width: 1199px)" href="css/maxi.css" type="text/css" />
<link rel="stylesheet" media="(max-width: 1200px) and (min-width: 800px)" href="css/midi.css" type="text/css" />
<link rel="stylesheet" media="(max-width: 800px)" href="css/mini.css" type="text/css" />
	<script src="register.js"></script>

</head>

<body>
<div id="container">
	<!--
	<nav class="userbar">
		<a href="login.php">Zaloguj się</a> lub <a href="register.php">zarejestruj</a>, żeby zagrać przez sieć
	</nav>
	-->
	<header>
	<h1>Hnefatafl</h1>
	<h6>logowanie</h6>
	</header>

	<nav class="menu">
		<a href="graj" class="menu__button">Zagraj przy jednym komputerze</a>
		<a href="zasady-gry" class="menu__button">Zasady</a>

		
	</nav>

	<div id="content">
		Aby zagrać przez sieć, zaloguj się lub zarejestruj
		</br></br>
		<hr />
		<h4>Logowanie</h4>
		<form action="login.php" method="post">
<?php
			if (isset($_SESSION['errorlogin']))
			echo '<div class="error">'.$_SESSION['errorlogin'].'</div>';
?>
			<p>Login
			<input type="text" name="login"></input></p>
			<p>Hasło
			<input type="password" name="pass"></input></p>
			<input type="submit" value="Zaloguj"></input>
		</form>

		</br>
		<hr />
		<h4>Nie masz jeszcze konta? Załóż je tutaj</h4>
		<form action="login.php" method="post">
<?php
			if (isset($_SESSION['errorlogin']))
			echo '<div class="error">'.$_SESSION['errorlogin'].'</div>';
?>
			<p>Login
			<input type="text" name="login"></input></p>
			<p>Hasło
			<input type="password" name="pass"></input></p>
			<p>Powtórz hasło
			<input type="password" name="pass"></input></p>
			<p>Adres e-mail
			<input type="text" name="pass"></input></p>
			<input type="submit" value="Załóż konto"></input>
		</form>

		</br>
		<hr />
		</br>
	</div>

	<footer>© Copyright 2017-2019 Paulina Filipiak</footer>

</div>

</body>
</html>
