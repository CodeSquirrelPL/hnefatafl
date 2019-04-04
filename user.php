<?php

	session_start();

	require_once "connect.php";

	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

		if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
		exit();
	}

	if (isset($_GET['id'])) $id = $_GET['id'];
	else {
		header('Location: account.php');
		exit();
	}

	//if ($id==1)
	//{header('Location: pyra.php'); exit();}

	$user = @$polaczenie->query(sprintf("SELECT * FROM users WHERE id='%s'", $id));
	if ($user->num_rows==0)	{
		echo "Użytkownik o podanym id nie istnieje.";
		exit();
	}
	$user = $user->fetch_assoc();


	if (isset($_SESSION['zalogowany']))
	{
	$rezultat = @$polaczenie->query("SELECT id FROM challenges WHERE challenged=".$_SESSION['id']." AND received='0000-00-00 00:00:00'");
	$_SESSION['challenges']=$rezultat->num_rows;
	$rezultat = @$polaczenie->query("SELECT id FROM games WHERE (id_black='".$_SESSION['id']."' OR id_white='".$_SESSION['id']."') AND date_finish='0000-00-00 00:00:00'");
	$_SESSION['games']=$rezultat->num_rows;
	$rezultat->free_result();	}

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Hnefatafl - profil użytkownika <?php echo $user['login'];?></title>
	<meta name="description" content="Hnafatafl - szachy wikingów" />
	<meta name="keywords" content="hnefatafl, szachy wikingów, wikingowie, szachy" />

	<link rel="stylesheet" href="style.css" type="text/css" />
	<script src="extras/jquery.js"></script>

	<?php
		echo '<script>var user_id = '.$user['id'].'; var login = "'.$user['login'].'";</script>';
	?>

	<script>

	function hide_form()
	{
		$("#challenge").html('<img src="img/miecze2.png" onclick="show_form();"/><br/>Rzuć wyzwanie użytkownikowi '+ login);
	}

	function show_form()
	{
		var form = '<img src="img/miecze2.png" onclick="hide_form();"/><br/>Rzucasz wyzwanie użytkownikowi '+ login;
		form += '<form action="challenge.php?id='+ user_id +'" method="POST">';
		form += '<p><label><input type="radio" name="colors" value="random"/> losowy wybór kolorów</label></p>';
		form += '<p><label><input type="radio" name="colors" value="black"/> zaczynasz czarnymi</label></p>';
		form += '<p><label><input type="radio" name="colors" value="white"/> zaczynasz białymi</label></p>';
		form += '<p><label><input type="radio" name="colors" value="choice"/> ' + login + ' wybiera kolor pionków</label></p>';
		form += '<input type="submit" value="Rzuć wyzwanie"/></form>';

		$("#challenge").html(form);

		document.getElementById("challenge").setAttribute("onclick", "");
		document.getElementById("challenge").setAttribute("style", "cursor: auto");
	}

	</script>

</head>

<body>
<div id="container">
<div id="userbar">
<?php
	if (!isset($_SESSION['zalogowany']) || ($_SESSION['zalogowany']==false))
	echo '<a href="enter.php">Zaloguj się lub zarejestruj</a>, żeby zagrać przez sieć';
	else
	echo '<div id="login"><a href="account.php" title="Ustawienia profilu">'.$_SESSION['login'].'</a></div><div class="user"><a href="account.php#games">rozgrywki: '.$_SESSION['games'].'</a></div><div class="user"><a href="account.php#challenges">wyzwania: '.$_SESSION['challenges'].'</a></div><div class="user"><a href="logout.php">wyloguj</a></div> <div class="empty"></div>';
?>

	</div>
	<div id="header">
	<h1>Hnefatafl</h1>

<?php
	if ($_SESSION['id']==$_GET['id'])
	echo '<h6>Podgląd twojego profilu</h6>';
 ?>
	</div>

	<div id="bar">
		<a href="index.php"><div class="menu">Zagraj przy jednym komputerze</div></a>
		<a href="rules.php"><div class="menu">Zasady</div></a>
		<a href="about.php"><div class="menu">O grze</div></a>
		<div class="empty"></div>
	</div>
	<div id="content">

<?php

	if (isset($_SESSION['message']))
	{
		echo '<div class="message">'.$_SESSION['message'].'</div>';
		unset($_SESSION['message']);
	}

	if (!isset($_SESSION['zalogowany']) || ($_SESSION['zalogowany']==false))
	echo '<a href="enter.php"><div class="interakcja"><img src="img/miecze2.png"/><br/>Zaloguj się lub zarejestruj, by rzucić wyzwanie użytkownikowi '.$user['login'].'</div></a>';
	else if ($_SESSION['id']!=$_GET['id'])	{


		$rezultat = @$polaczenie->query("SELECT id FROM challenges WHERE received='0000-00-00 00:00:00' AND challenged=".$_SESSION['id']." AND challenging=".$id);
		if ($rezultat->num_rows>0) echo '<div class="inactive" id="challenge""><img src="img/miecze2.png"/><br/>Ta osoba rzuciła ci już wyzwanie. Przyjmij je lub odrzuć.</div>';
		else {

			$rezultat = @$polaczenie->query("SELECT id FROM challenges WHERE received='0000-00-00 00:00:00' AND challenged=".$id." AND challenging=".$_SESSION['id']);
			if ($rezultat->num_rows>0) echo '<div class="inactive" id="challenge""><img src="img/miecze2.png"/><br/>Dopóki ta osoba nie przyjmie lub nie odrzuci twojego poprzedniego wyzwania, nie możesz jej wysłać kolejnego.</div>';
			else echo '<div class="interakcja" id="challenge" onclick="show_form()"><img src="img/miecze2.png"/><br/>Rzuć wyzwanie użytkownikowi '.$user['login'].'</div>';
		}

		$rezultat->free_result();





		}

	echo '<h2>'.$user['login'].'</h2>';
	echo '<span style="color: ';
	if ($user['online']) echo '#00CC00;">online';
	else echo '#FF6666;">offline';
	echo '</span>';
	echo "<p><b>Data rejestracji</b>: ".$user['joined']."</p>";
	echo "<p><b>Ostatnia wizyta</b>: ".$user['last_visit']."</p>";

	echo "<br/><hr/></br>";

	$result = @$polaczenie->query("SELECT * from games WHERE (id_black=".$id." OR id_white=".$id.") AND date_finish!='0000-00-00 00:00:00' ORDER BY date_finish DESC");
	echo "<h3>Rozegrane partie</h3>";
	if ($result->num_rows>0)
	{
echo<<<END
	<table class="table" align="center" border="1">
		<tr>
			<td><h4>Data</h4></td><td><h4>Przeciwnik</h4></td><td><h4>Wynik</h4></td>
		</tr>
END;

	for ($i=0; $i<$result->num_rows; $i++)
	{
		$row = $result->fetch_assoc();
		echo '<tr style="height: 3em"><td>'.$row['date_finish']."</td><td>";
		if ($id==$row['id_black'])
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
		if ($id==$row['winner'])
		{
			echo "Zwycięstwo";
		}
		else echo "Przegrana";
		echo "</td></tr>";
	}

	echo "</table>";
	}
	else echo "Brak wyników do wyświetlenia";
	$result->free_result();
	unset($_SESSION['message']);

?>

	</div>

	<div id="footer">napisane przez Pyrę dla ludzi / written by Potato for people</div>

</div>
</body>
</html>
<?php
	$polaczenie->close();
?>
