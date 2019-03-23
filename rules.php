<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Hnefatafl - zasady rozgrywki</title>

	<meta name="description" content="Hnafatafl - szachy wikingów - zasady rozgrywki" />
	<meta name="keywords" content="hnefatafl, szachy wikingów, wikingowie, szachy" />

	<link rel="stylesheet" href="style.css" type="text/css" />

</head>

<body>
<div id="container">

	<a href="index.php">
	<div id="header">
	<h1>Hnefatafl</h1>
	<h6>Zasady gry</h6>
	</div>
	</a>

	<div id="bar">
		<a href="index.php"><div class="menu">Graj przy jednym komputerze</div></a>
		<a href="enter.php"><div class="menu">Graj przez sieć</div></a>
		<a href="about.php"><div class="menu">O grze</div></a>
		<div class="empty"></div>
	</div>

	<div id="content">
	<h3>Zasady rozgrywki</h3>
	<p>Istnieje wiele wariantów zasad. Zdecydowałam się na te, które wydają mi się najbardziej sensowne i które przetestowałam. Jest to wersja rozwojowa - prawdopodobnie zmodyfikuję ją, jeśli uda mi się uzyskać wiarygodne informacje na temat historycznych reguł gry.</p>
	<p>Gracze mają odmienne cele - białe mają doprowadzić króla na jedno z czterech bezpiecznych miejsc (tronów) w rogach planszy, czarne - zabić króla poprzez otoczenie go z wszystkich czterech stron (lub trzech, jeśli znajdzie się przy krawędzi planszy).</p>
	<p>Ruch odbywa się tylko w linii prostej, o dowolną ilość pól; nie można "przeskakiwać" nad figurami.</p>
	<p>Na pięciu "tronach", znajdujących się w rogach i na środku planszy, może stawać tylko król i tylko król może przez środkowy tron przejechać.</p>
	Bicie odbywa się przez:
		<ul>
			<li>
				obejście wrażego pionka z dwóch przeciwnych stron,</br>
				<div class="example">
					<div class="square"><img src="img/white.png"/></div>
					<div class="square"><img src="img/black.png"/></div>
					<div class="square"><img src="img/white.png"/></div>
					<div class="empty"></div>

				</div>
				czarny zostanie zbity
			</li>
			<li>
				"przyparcie" do tronu (tylko, jeśli jest pusty) - jeśli pionek stoi przy tronie, można go zbić, ustawiając swój pionek po przeciwnej od tronu stronie
				<div class="example">
				<div class="square" style="background-image: url(img/throne.png)"></div>
				<div class="square"><img src="img/white.png"/></div>
				<div class="square"><img src="img/black.png"/></div>
				<div class="empty"></div>

				</div>
				biały zostanie zbity
			</li>
		</ul>
	<p>Król bije tak samo, jak inne pionki. Można zbić kilka figur naraz.</p>
	<p>Nie ma ruchów "samobójczych" - jeśli gracz wstawi pionek między dwie figury drugiego gracza lub między tron i obcą figurę, nie traci tego pionka.</p>
	</div>

	<div id="footer">napisane przez Pyrę dla ludzi / written by Potato for people</div>

</div>
</body>
</html>