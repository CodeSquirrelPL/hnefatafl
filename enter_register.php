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
	
	<title>Hnefatafl - logowanie</title>
	
	<meta name="description" content="Hnafatafl - szachy wikingów" />
	<meta name="keywords" content="hnefatafl, szachy wikingów, wikingowie, szachy" />
	
	<link rel="stylesheet" href="style.css" type="text/css" />
	<script src="register.js"></script>
	
</head>

<body>
<div id="container">
	<!--
	<div id="userbar">
		<a href="login.php">Zaloguj się</a> lub <a href="register.php">zarejestruj</a>, żeby zagrać przez sieć
	</div>
	-->
	<div id="header">
	<h1>Hnefatafl</h1>
	<h6>logowanie</h6>
	</div>
	
	<div id="bar">
		<a href="index.php"><div class="menu">Zagraj przy jednym komputerze</div></a>
		<a href="rules.php"><div class="menu">Zasady</div></a>
		
		<div class="empty"></div>
	</div>
	
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
	
	<div id="footer">© Copyright 2017-2019 Paulina Filipiak</div>

</div>

</body>
</html>
