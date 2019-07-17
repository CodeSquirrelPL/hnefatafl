<?php

	session_start();

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Hnefatafl - graj z komputerem</title>

	<meta name="description" content="Hnafatafl - szachy wikingów" />
	<meta name="keywords" content="hnefatafl, szachy wikingów, wikingowie, szachy" />

	<link rel="stylesheet" href="style.css" type="text/css" />
	<script src="game.js"></script>
	<script src="js/aiGameSettings.js"></script>
	<script src="js/ai.js"></script>
</head>

<body onload="rysuj_plansze()">
<div id="container">
	<div id="userbar">
<?php

	require_once "php/functions/userbar.php";

?>
	</div>
	<div id="header" onclick="countMoves(1)">
	<h1>Hnefatafl</h1>
	<h6>gra przeciwko niesprawnemu AI</h6>
	</div>

	<div id="bar">
		<a href="enter.php"><div class="menu">Graj przez sieć</div></a>
		<a href="rules.php"><div class="menu">Zasady</div></a>
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

	<div id="footer">© Copyright 2017-2019 Paulina Filipiak</div>

</div>
</body>
</html>
