<?php

	session_start();

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Hnefatafl - zagraj online - gorące krzesło</title>

	<meta name="description" content="Hnafatafl - szachy wikingów. Zagraj online w hnefatafl, przy jednym komputerze lub przez sieć!" />
	<meta name="keywords" content="hnefatafl, szachy wikingów, wikingowie, szachy" />

	<link rel="stylesheet" href="css/main.css" type="text/css" />
	<link rel="stylesheet" href="css/logout.css" type="text/css" />
	<link rel="stylesheet" media="(min-width: 1199px)" href="css/maxi.css" type="text/css" />
	<link rel="stylesheet" media="(max-width: 1200px) and (min-width: 800px)" href="css/midi.css" type="text/css" />
	<link rel="stylesheet" media="(max-width: 800px)" href="css/mini.css" type="text/css" />
	<script src="extras/jquery.js"></script>
	<script src="js/game_common.js"></script>
	<script src="js/game.js"></script>

</head>

<body onload="rysuj_plansze()">
<div id="container">
	<nav class="userbar">
<?php

	require_once "php/functions/userbar.php";

?>
	</nav>

	<header>
	<h1>Hnefatafl</h1>
	<h6>tryb "gorące krzesło"</h6>
	</header>

	<nav class="menu">
		<a href="logowanie" class="menu__button">Graj przez sieć</a>
		<a href="rules.php" class="menu__button">Zasady</a>
	</nav>

	<div id="game">

	<div id="current_player">czarne</div>

	<div class="side" id="left">
		<div class="side_header">Zbite królewskie piony</div>
		<div class="zbite" id="side_1">
		</div>
	</div>

	<div id="board">
	<p>ładowanie planszy...</p>
	</div>

	<div class="side" id="right">
		<div class="side_header">Zbite piony buntowników</div>
		<div class="zbite" id="side_0">
		</div>
	</div>

</div>

	<footer>© Copyright 2017-2022 Nikita Filipiak</footer>

</div>
</body>
</html>
