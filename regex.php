<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>regex</title>

	<meta name="description" content="Hnafatafl - szachy wikingów" />
	<meta name="keywords" content="hnefatafl, szachy wikingów, wikingowie, szachy" />

	<link rel="stylesheet" href="css/main.css" type="text/css" />
<link rel="stylesheet" media="(min-width: 1199px)" href="css/maxi.css" type="text/css" />
<link rel="stylesheet" media="(max-width: 1200px) and (min-width: 800px)" href="css/midi.css" type="text/css" />
<link rel="stylesheet" media="(max-width: 800px)" href="css/mini.css" type="text/css" />
	<script src="js/functions/regex.js"></script>

</head>

<body>
<div id="container">
	<!--
	<nav id="userbar">
		<a href="login.php">Zaloguj się</a> lub <a href="register.php">zarejestruj</a>, żeby zagrać przez sieć
	</nav>
	-->
	<header>
	<h1>ćwiczenia z używania regeksów</h1>
	</header>

	<div id="content">

		<form id="rejestracja" method="post">

		<p>tekst</p>
		<p id="tekst"></p>
		<input type="text" name="tekst"></input>
		<br />
		<br />
		</form>
		<button id="send" onclick='check(test)'>Sprawdź dane</button>


	</div>

	<footer>© Copyright 2017-2019 Paulina Filipiak</footer>

</div>
</body>
</html>
