<?php

	session_start();

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Hnefatafl - gorące pośladki</title>

	<meta name="description" content="Hnafatafl - szachy wikingów" />
	<meta name="keywords" content="hnefatafl, szachy wikingów, wikingowie, szachy" />

	<link rel="stylesheet" href="style.css" type="text/css" />
	<script src="game.js"></script>

</head>

<body onload="rysuj_plansze()">
<div id="container">
	<div id="userbar">
<?php

	if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany']==true)
	echo '<div id="login"><a href="account.php" title="Ustawienia profilu">'.$_SESSION['login'].'</a></div><div class="user"><a href="account.php#games">rozgrywki: '.$_SESSION['games'].'</a></div><div class="user"><a href="account.php#challenges">wyzwania: '.$_SESSION['challenges'].'</a></div><div class="user"><a href="logout.php">wyloguj</a></div> <div class="empty"></div>';
	else echo	'<a href="enter.php">Zaloguj się lub zarejestruj</a>, żeby zagrać przez sieć';

?>
	</div>
	<div id="header">
	<h1>Hnefatafl</h1>
	<h6>tryb "gorących pośladków"</h6>
	</div>

	<div id="bar">
		<a href="enter.php"><div class="menu">Graj przez sieć</div></a>
		<a href="rules.html"><div class="menu">Zasady</div></a>
		<a href="about.html"><div class="menu">O grze</div></a>
		<div class="empty"></div>
	</div>

	<div id="game">

	<div id="current_player" class="width: 100%;">czarne</div>

	<div class="side" id="left">
		<div class="side_header">Zbite królewskie piony</div>
		<div class="zbite" id="side_1">
		</div>
	</div>

	<div id="board">
	<p>Coś się rozjechało - tu powinna być plansza</p>
	</div>

	<div class="side" id="right">
		<div class="side_header">Zbite piony buntowników</div>
		<div class="zbite" id="side_0">
		</div>
	</div>

	<div class="empty"></div>

</div>

	<div id="footer">napisane przez Pyrę dla ludzi / written by Potato for people</div>

</div>
</body>
</html>
