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

	<title>Hnefatafl - szukanie graczy</title>

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
<nav id="userbar">

<?php

	echo '<div id="login"><a href="account.php" title="Ustawienia profilu">'.$_SESSION['login'].'</a></div><div class="user"><a href="account.php#games">rozgrywki: '.$_SESSION['games'].'</a></div><div class="user"><a href="account.php#challenges">wyzwania: '.$_SESSION['challenges'].'</a></div><div class="user"><a href="logout.php">wyloguj</a></div> <div class="empty"></div>';

?>

	</nav>
	<header>
	<h1>Hnefatafl</h1>
	<h6>szukanie graczy</h6>
	</header>

	<nav class="menu">
		<a href="index.php"><div class="menu__button">Zagraj przy jednym komputerze</div></a>
		<a href="rules.php"><div class="menu__button">Zasady</div></a>

		<div class="empty"></div>
	</nav>
	<div id="content">

<form action="wyniki_wyszukiwania.php" method="POST">
<label><input type="checkbox" name="online" value="1"/> szukaj tylko wśród zalogowanych</label>
	<p>Login lub fragment loginu poszukiwanego użytkownika</p>
	<p><input type="text" name="login"/></p>
	<input type="submit" value="szukaj"/>
</form>


	<?php

	if (isset($_POST['online']))
	$rezultat = @$polaczenie->query("SELECT id, login FROM users WHERE online=1 AND login LIKE '%".mysqli_real_escape_string($polaczenie,$login)."%' ORDER BY login ASC");

	else $rezultat = @$polaczenie->query("SELECT id, login FROM users WHERE login LIKE '%".mysqli_real_escape_string($polaczenie,$login)."%' ORDER BY login ASC");

	echo '</br><table class="table" align="center" border="1"><td><h4>Wyniki wyszukiwania</h4></td></tr>';

	for ($i=$rezultat->num_rows; $i>0; $i--)
	{
		$row = $rezultat->fetch_assoc();
		echo '<tr><td><a href="user.php?id='.$row['id'].'">'.$row['login'].'</a></td></tr>';
	}

	$rezultat->free_result();

		//if (isset($_POST['online'])) echo "tylko online";
		//else echo "wśród wszystkich zarejestrowanych";
		//echo "</br> login: ".$_POST['login'];

	echo '</table>';
	?>

	</div>

	<footer>© Copyright 2017-2019 Paulina Filipiak</footer>

</div>
</body>
</html>
