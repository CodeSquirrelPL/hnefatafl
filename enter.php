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

	<title>Hnefatafl - logowanie - zagraj przez sieć!</title>

	<meta name="description" content="Hnafatafl - szachy wikingów. Zaloguj się, żeby zagrać w hnefatafl przez internet!" />
	<meta name="keywords" content="hnefatafl, szachy wikingów, wikingowie, szachy" />

	<link rel="stylesheet" href="css/main.css" type="text/css" />
<link rel="stylesheet" href="css/logout.css" type="text/css" />
<link rel="stylesheet" media="(min-width: 1199px)" href="css/maxi.css" type="text/css" />
<link rel="stylesheet" media="(max-width: 1200px) and (min-width: 800px)" href="css/midi.css" type="text/css" />
<link rel="stylesheet" media="(max-width: 800px)" href="css/mini.css" type="text/css" />
	<script src="js/komunikaty_rejestracja_pl.js"></script>
	<script src="js/functions/passEmailValidation.js" type="text/javascript"></script>
	<script src="js/register.js"></script>
	<script src="js/register.js"></script>
	<script src="extras/jquery.js" type="text/javascript"></script>
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
			unset($_SESSION['errorlogin']);
?>
			<p>Login
			<input type="text" name="login"></input></p>
			<p>Hasło
			<input type="password" name="pass"></input></p>
			<input type="submit" value="Zaloguj"></input>
		</form>

		</br>
		<hr />

		<h3>Rejestracja</h3>

		<form id="rejestracja" method="POST" action="register.php">
<?php
		if (isset($_SESSION['error_login']))
		echo '<div class="error">'.$_SESSION['error_login'].'</div>';
?>
		<h4>Login</h4><!--(może składać się z liter alfabetu łacińskiego, cyfr, kropek, myślników oraz podkreślników, przynajmniej 4, najwyżej 64 znaków)-->
		<p id="login_msg" class="warning"></p>
		<input type="text" name="login" id="nick"></input></br>
<?php
		if (isset($_SESSION['error_pass']))
		echo '<div class="error">'.$_SESSION['error_pass'].'</div>';
		unset ($_SESSION['error_pass']);
?>
		<h4>Hasło</h4>
		<!--musi zawierać małą i dużą literę, cyfrę i być nie krótsze niż 6 znaków-->
		<p id="pass_msg" class="warning"></p>
		<input type="password" name="pass1" id="pass1" class="input"></input>
		<h4>Podaj hasło ponownie</h4>
		<p id="pass2_msg" class="warning"></p>
		<input type="password" name="pass2" id="pass2"></input>
		<h4>Adres e-mail</h4>(opcjonalnie)<!-- - podanie adresu pozwoli na odzyskanie konta po utracie hasła)--></p>
		<p id="email_msg" class="warning"></p>
		<input type="email" name="email"></input>
		<p>Zakładając konto, zgadzasz się na zasady opisane w <a target="_blank" href="terms.php">tym dokumencie</a><!--Uwaga. Ponieważ nie mogę zagwarantować jego bezpieczeństwa, czat w grze nie jest przeznaczony do przesyłania prywatnych czy intymnych informacji. Twoje konto może zostać usunięte po okresie nieobecności dłuższym niż trzy miesiące. Przesyłanie obraźliwych, wulgarnych czy nawołujących do przemocy treści grozi usunięciem konta. Korzystasz z serwisu na własną odpowiedzialność.--></p>
		<p id="czekaj"></p>
		</form>
		<noscript>rejestracja nie jest możliwa, gdyż twoja przeglądarka nie obsługuje JavaScriptu. Włącz obsługę JavaScriptu i odśwież stronę, by się zarejestrować</noscript>
		<button id="send" onclick='check(rejestracja)'>Załóż konto</button>

	</div>

	<div id="submit"></div>

	</div>

	<footer>© Copyright 2017-2019 Paulina Filipiak</footer>

</div>

</body>
</html>
