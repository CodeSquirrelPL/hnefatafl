<?php
		require_once "php/functions/phpHeader.php";

		if ($rezultat = @$polaczenie->query("SELECT id FROM challenges WHERE challenged=".$_SESSION['id']." AND received='0000-00-00 00:00:00'"))
		$_SESSION['challenges']=$rezultat->num_rows;
		else $_SESSION['challenges']=0;
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

	<title>Hnefatafl - twój profil</title>

	<meta name="description" content="Hnafatafl - szachy wikingów" />
	<meta name="keywords" content="hnefatafl, szachy wikingów, wikingowie, szachy" />

<link rel="stylesheet" href="css/main.css" type="text/css" />
<link rel="stylesheet" href="css/logout.css" type="text/css" />
<link rel="stylesheet" media="(min-width: 1199px)" href="css/maxi.css" type="text/css" />
<link rel="stylesheet" media="(max-width: 1200px) and (min-width: 800px)" href="css/midi.css" type="text/css" />
<link rel="stylesheet" media="(max-width: 800px)" href="css/mini.css" type="text/css" />

	<script>	if (typeof XMLHttpRequest == "undefined") {
		XMLHttpRequest = function() {
				//IE wykorzystuje biblioteki ActiveX do tworzenia obiektu XMLHttpRequest
				return new ActiveXObject(
						//IE5 używa innego obektu XMLHTTP niż IE6 i wyższe
						navigator.userAgent.indexOf("MSIE 5") >=0 ? "Microsoft.XMLHTTP" : "Msxml2.XMLHTTP"
				);
		}
}</script>

	<script src="extras/jquery.js"></script>
	<script src="js/account.js"></script>


</head>

<body onload="zxc()">
<div id="container">
<nav class="userbar">

<?php

require_once "php/functions/userbar.php";

?>

</nav>
	<header>
	<h1>Hnefatafl</h1>
	<h6>Twój profil</h6>
	</header>

	<nav class="menu">
		<a href="graj" class="menu__button">Zagraj przy jednym komputerze</a>
		<a href="zasady-gry" class="menu__button">Zasady</a>
	</nav>
	<div id="content">

<?php
	if (isset($_SESSION['message'])) echo '<div class="message">'.$_SESSION['message']."</div>";

/************************************* trwające rozgrywki - wyświetlanie **********************************************/

	echo '<a id="games"><h3>Trwające rozgrywki</h3>';

	$result = @$polaczenie->query(sprintf("SELECT * FROM games WHERE (id_black='%s' OR id_white='%s') AND date_finish='0000-00-00 00:00:00' ORDER BY date_begin DESC", $_SESSION['id'], $_SESSION['id']));
	if ($result->num_rows>0)
	{
echo<<<END
	<table role="presentation"  align="center" border="1">
		<tr>
			<td><h4>Data rozpoczęcia</h4></td><td><h4>Przeciwnik</h4></td><td><h4>Ruchy</h4></td><td><h4>Akcja</h4></td>
		</tr>
END;

		for ($i=0; $i<$result->num_rows; $i++)
		{
			$row = $result->fetch_assoc();
			echo '<tr style="height: 3em"><td>'.$row['date_begin']."</td><td>";
					if ($_SESSION['id']==$row['id_black'])
					{
				$rezultat = @$polaczenie->query("SELECT login, color FROM users WHERE id=".$row['id_white']);
				$rezultat = $rezultat->fetch_assoc();

							if ($rezultat['color']!="") $color='<span style="color: '.$rezultat['color'].';">';
							else $color='<span>';

				echo '<a href="user.php?id='.$row['id_white'].'">'.$color.$rezultat['login']."</span></a> (białe)";
					}
					else
					{
				$rezultat = @$polaczenie->query("SELECT login, color FROM users WHERE id=".$row['id_black']);
				$rezultat = $rezultat->fetch_assoc();

							if ($rezultat['color']!="") $color='<span style="color: '.$rezultat['color'].';">';
							else $color='<span>';

				echo '<a  href="user.php?id='.$row['id_black'].'">'.$color.$rezultat['login']."</span></a> (czarne)";
					}
			echo '</td><td>'.$row['move'].'</a>';
			echo '</td><td><a href="game.php?game='.$row['id'].'"><button>Graj</button></a></td>';

			echo "</td></tr>";
		}

	echo "</table>";
	}
	else echo "Brak rozgrywek do wyświetlenia";

/***************************** nowe wiadomości - wyświetlanie ***************************************************/

	echo '</br></br><hr/><a id="challenges"></a><h3>Nowe wiadomości</h3>';


/***************************** wyzwania otrzymane - wyświetlanie ***************************************************/

	echo '</br></br><hr/><a id="challenges"></a><h3>Wyzwania</h3>';

	$result = @$polaczenie->query(sprintf("SELECT * FROM challenges WHERE challenged='%s' AND received='0000-00-00 00:00:00' ORDER BY date DESC", $_SESSION['id']));
	echo "<h4>Otrzymane</h4>";
	if ($result->num_rows>0)
	{
echo<<<END
	<table role="presentation"  align="center" border="1">
		<tr>
			<td><h4>Data wysłania</h4></td><td><h4>Przeciwnik</h4></td><td><h4>Wybór kolorów</h4></td><td><h4>Akcja</h4></td>
		</tr>
END;

		for ($i=0; $i<$result->num_rows; $i++)
		{
			$row = $result->fetch_assoc();
			echo '<tr style="height: 3em"><td>'.$row['date']."</td><td>";
			$rezultat = @$polaczenie->query("SELECT login, color FROM users WHERE id=".$row['challenging']);
			$rezultat = $rezultat->fetch_assoc();
					if ($rezultat['color']!="") $color='<span style="color: '.$rezultat['color'].';">';
					else $color='<span>';
			echo '<a href="user.php?id='.$row['challenging'].'">'.$color.$rezultat['login']."</span></a></td>";
			echo '<td>';

			if ($row['colors']=="choice") echo "należy do ciebie";
			else if ($row['colors']=="white") echo "białe są twoje";
			else if ($row['colors']=="black") echo "czarne są twoje";
			else echo "losowy";
			echo '</td>';
			echo '<td><a href="nowa_gra.php?challenge='.$row['id'].'"><button>Przyjmij</button></a> | <button id="reject">Odrzuć</button>';
			echo "</td></tr>";
		}

	echo "</table>";
	}
	else echo "Brak wyzwań do wyświetlenia";

/************************************* wyzwania wysłane - wyświetlanie **********************************************/

	$result = @$polaczenie->query(sprintf("SELECT * FROM challenges WHERE challenging='%s' AND received='0000-00-00 00:00:00' ORDER BY date DESC", $_SESSION['id']));

	echo "<h4>Wysłane</h4>";

	if ($result->num_rows>0)
	{
echo<<<END
	<table role="presentation" class="table-wide" align="center" border="1">
		<tr>
			<td><h4>Data wysłania</h4></td><td><h4>Przeciwnik</h4></td><td><h4>Status</h4></td><td><h4>Akcja</h4></td>
		</tr>
END;

		for ($i=0; $i<$result->num_rows; $i++)
		{
			$row = $result->fetch_assoc();
			echo '<tr style="height: 3em"><td>'.$row['date']."</td><td>";
			$rezultat = @$polaczenie->query("SELECT login, color FROM users WHERE id=".$row['challenged']);
			$rezultat = $rezultat->fetch_assoc();
					if ($rezultat['color']!="") $color='<span style="color: '.$rezultat['color'].';">';
					else $color='<span>';
			echo '<a href="user.php?id='.$row['challenged'].'">'.$color.$rezultat['login']."</span></a></td><td>";

			if ($row['received']=="0000-00-00 00:00:00")
			echo "Oczekiwanie";
			else if ($row['game']==0)
			echo "Odrzucone";
			else echo "Przyjęto";

			echo "</td><td><button>Anuluj wyzwanie</button>";
			echo "</td></tr>";
		}

	echo "</table>";
	}
	else echo "Brak wyzwań do wyświetlenia";

/************************************* profil - wyświetlanie **********************************************/

	echo "</br><hr/><h3>Profil</h3>";

	$result = @$polaczenie->query(sprintf("SELECT * FROM users WHERE id='%s'", $_SESSION['id']));
	$result = $result->fetch_assoc();

	echo "<p><b>Login</b>: ".$_SESSION['login']."</p>";
	if ($result['email'])
	{
		$email = $result['email'];
echo <<<EOL
		<p><b>Adres e-mail</b>: $email </p>
		<button id='email_show' onclick='show_form("email")'>Zmień adres e-mail</button>
EOL;
		unset($email);
	}
	else echo <<<EOL
	<p>Brak adresu e-mail.</p>

EOL;
?>

	<?php
	echo "<p><b>Data rejestracji</b>: ".$result['joined']."</p>";
	?>

	<button id='passwd_show' onclick='show_form("passwd")'>Zmień hasło</button>

	<form id="passwd_form" style="display: none;" method="POST" action="php/account/changePasswd.php">
		<p>Wpisz swoje obecne hasło</p>
		<div id="oldPassMsg"></div>
		<input id="old" type="password" onblur="verify_passwd(this.value)"></input>
		<p>Wpisz nowe hasło</p>
		<div id="pass1Msg"></div>
		<input id="pass1" name="pass1" type="password"></input>
		<p>Wpisz nowe hasło ponownie</p>
		<div id="pass2Msg"></div>
		<input id="pass2" name="pass2" type="password"></input>
		<p><input id="passButton" type="button" value="Zmień hasło" onclick="validatePasswdForm(passwd_form)"/></p>
	</form>


<?php

/************************************* wyniki - wyświetlanie **********************************************/

	echo "</br></br><hr/><h3>Wyniki</h3>";

	$result = @$polaczenie->query("SELECT * from games WHERE (id_black=".$_SESSION['id']." OR id_white=".$_SESSION['id'].") AND date_finish!='0000-00-00 00:00:00' ORDER BY date_finish DESC");

	if ($result && $result->num_rows>0)
	{
?>
	<h4>Rozegrane partie</h4>
	<table role="presentation"  align="center" border="1">
		<tr>
			<td><h4>Data</h4></td><td><h4>Przeciwnik</h4></td><td><h4>Wynik</h4></td>
		</tr>
<?php

	for ($i=0; $i<$result->num_rows; $i++)
	{
		$row = $result->fetch_assoc();
		echo '<tr style="height: 3em"><td>'.$row['date_finish']."</td><td>";
		if ($_SESSION['id']==$row['id_black'])
		{
	$rezultat = @$polaczenie->query("SELECT login, color FROM users WHERE id=".$row['id_white']);
	$rezultat = $rezultat->fetch_assoc();
			if ($rezultat['color']!="") $color='<span style="color: '.$rezultat['color'].';">';
			else $color='<span>';
	echo '<a href="user.php?id='.$row['id_white'].'">'.$color.$rezultat['login']."</span></a> (białe)";
		}
		else
		{
	$rezultat = @$polaczenie->query("SELECT login, color FROM users WHERE id=".$row['id_black']);
	$rezultat = $rezultat->fetch_assoc();
			if ($rezultat['color']!="") $color='<span style="color: '.$rezultat['color'].';">';
			else $color='<span>';
	echo '<a href="user.php?id='.$row['id_black'].'">'.$color.$rezultat['login']."</span></a> (czarne)";
		}
		echo "</td><td>";
		if ($_SESSION['id']==$row['winner'])
		{
			echo "Zwycięstwo";
		}
		else echo "Przegrana";
		echo "</td></tr>";
	}

	echo "</table>";
	}
	else echo "Brak wyników do wyświetlenia";
	if ($result) $result->free_result();
	unset($_SESSION['message']);

	echo "</br><hr/><h3>Szukaj użytkowników</h3>";

	$polaczenie->close();

?>

		<form action="wyniki_wyszukiwania.php" method="POST">
			<label><input type="checkbox" name="online" value="1"/> szukaj tylko wśród zalogowanych</label>
			<p>Login lub fragment loginu poszukiwanego użytkownika</p>
			<p><input type="text" name="login"/></p>
			<input type="submit" value="szukaj"/>
		</form>

	</div>

	<footer>© Copyright 2017-2019 Paulina Filipiak</footer>

</div>
</body>
</html>
