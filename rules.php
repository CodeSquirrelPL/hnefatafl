<?php

	session_start();

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Hnefatafl - zasady rozgrywki</title>

	<meta name="description" content="Hnafatafl - szachy wikingów - zasady rozgrywki" />
	<meta name="keywords" content="hnefatafl, szachy wikingów, wikingowie, szachy" />

	<link rel="stylesheet" href="css/main.css" type="text/css" />
<link rel="stylesheet" media="(min-width: 1199px)" href="css/maxi.css" type="text/css" />
<link rel="stylesheet" media="(max-width: 1200px) and (min-width: 800px)" href="css/midi.css" type="text/css" />
<link rel="stylesheet" media="(max-width: 800px)" href="css/mini.css" type="text/css" />

</head>

<body>
<div id="container">
	<div id="userbar">
	<?php

	require_once "php/functions/userbar.php";

	?>
	</div>
	<a href="index.php">
	<div id="header">
	<h1>Hnefatafl</h1>
	<h6>Zasady gry</h6>
	</div>
	</a>

	<div id="bar">
		<a href="index.php"><div class="menu">Graj przy jednym komputerze</div></a>
		<a href="enter.php"><div class="menu">Graj przez sieć</div></a>
		<div class="empty"></div>
	</div>

	<div id="content">
	<h3>Zasady rozgrywki</h3>
	<p>Na tej stronie możesz zagrać w hnefatafl według zasad kopenhaskich (o innych wariantach hnefatafl przeczytasz <a href="http://tafl.cyningstan.com/pages/1298/hnefatafl-variants" target="_blank">tutaj</a>).</p>
	<p>Gracze mają odmienne cele - białe mają doprowadzić króla na jedno z czterech bezpiecznych miejsc (tronów) w rogach planszy, czarne - pojmać króla poprzez otoczenie go z wszystkich czterech stron (lub trzech, jeśli z czwartej znajduje się krawędź planszy lub pole środkowe).</p>
	<p>Pionki i król poruszają się jak wieża w szachach - tylko w linii prostej, o dowolną ilość pól, równolegle do krawędzi planszy; nie można "przeskakiwać" nad innymi figurami ani umieszczać figur na zajętym polu.</p>
	<p>Na pięciu tronach, znajdujących się w rogach i na środku planszy, może stawać tylko król. Pionki mogą przeskoczyć nad środkowym tronem.</p>
	Bicie odbywa się przez:
		<ul>
			<li>
				oskrzydlenie wrażego pionka z dwóch przeciwnych stron równolegle do krawędzi planszy,</br>
				<div class="example">
					<div class="square"><img src="img/white.png"/></div>
					<div class="square"><img src="img/black.png"/></div>
					<div class="square"><img src="img/white.png"/></div>
					<div class="empty"></div>

				</div>
				czarny zostanie zbity
			</li>
			<br>
			<li>
				przyparcie do tronu (tylko jeśli jest pusty) - jeśli pionek stoi przy tronie, można go zbić, ustawiając swój pionek po przeciwnej od tronu stronie
				<div class="example">
				<div class="square" style="background-image: url(img/throne.png)"></div>
				<div class="square"><img src="img/white.png"/></div>
				<div class="square"><img src="img/black.png"/></div>
				<div class="empty"></div>

				</div>
				biały zostanie zbity
			</li>
		</ul>

	<p>Charakterystyczna dla zasad kopenhaskich jest zasada "muru z tarcz" (shieldwall) - rząd pionków stojących przy brzegu planszy można zbić przez otoczenie ich z każdej strony tak, by nie miały gdzie się ruszyć.</p>
	<p>Gra kończy się przegraną gracza, jeśli nie ma możliwości wykonania żadnego ruchu.</p>
	<p>Król bije tak samo, jak inne pionki. Możliwe jest zbicie kilka figur naraz.</p>
	<p>Nie ma ruchów "samobójczych" - jeśli gracz ustawi pionek między dwiema figurami drugiego gracza lub między tronem a obcą figurą, nie traci tego pionka.</p>
	<p>Król może zwyciężyć przez stworzenie "twierdzy" przy krawędzi planszy - linii pionków, których zbiecie w tej pozycji jest niemożliwe, chroniącej króla przed pojmaniem, ale umożliwiającej mu poruszanie się wewnątrz. Natomiast jeśli król i jego obrońcy zostaną otoczeni przez przeciwnika tak, że żaden z nich nie będzie mógł dosięgnąć krawędzi planszy, przegrywają.</p>
	<p><a href="index.php">Czarne zaczynają.</a></p>
	</div>

	<div id="footer">© Copyright 2017-2019 Paulina Filipiak</div>

</div>
</body>
</html>
