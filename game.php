<?php

	session_start();

	if (!isset($_SESSION['zalogowany']) || ($_SESSION['zalogowany']==false))
	{
		header('Location: enter.php');
		exit();
	}

	if (!isset($_GET['game']))
	{
		header('Location: user.php');
		exit();
	}

	require_once "connect.php";

	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

		if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
		exit();
	}

	$result = @$polaczenie->query(sprintf("SELECT * FROM games WHERE id='%s'", $_GET['game']));
	$game = $result->fetch_assoc();
	$result->free_result();

	if ($game['date_finish']!='0000-00-00 00:00:00')
	{
		header('Location: user.php');
		exit();
	}


	$rezultat = @$polaczenie->query("SELECT id FROM challenges WHERE challenged=".$_SESSION['id']." AND received='0000-00-00 00:00:00'");
	$_SESSION['challenges']=$rezultat->num_rows;
	$rezultat = @$polaczenie->query("SELECT id FROM games WHERE (id_black='".$_SESSION['id']."' OR id_white='".$_SESSION['id']."') AND date_finish='0000-00-00 00:00:00'");
	$_SESSION['games']=$rezultat->num_rows;
	$rezultat->free_result();

	if ($_SESSION['id']==$game['id_black'])
	{
		$color = 0;
		$result = @$polaczenie->query(sprintf("SELECT login FROM users WHERE id='%s'", $game['id_white']));
		$game['adversary_id'] = $game['id_white'];
		$result = $result->fetch_assoc();
		$game['adversary'] = $result['login'];
		$whiteplayer = $game['adversary'];
		$blackplayer = $_SESSION['login'];
	}
	else if ($_SESSION['id']==$game['id_white'])
	 {
	 	$color = 1;
		$result = @$polaczenie->query(sprintf("SELECT login FROM users WHERE id='%s'", $game['id_black']));
		$game['adversary_id'] = $game['id_black'];
		$result = $result->fetch_assoc();
		$game['adversary'] = $result['login'];
		$blackplayer = $game['adversary'];
		$whiteplayer = $_SESSION['login'];
	 }
	else
	{
		header('Location: user.php');
		exit();
	}

	$script="";

	if ($game['setting']!=0)
	{
		$result = @$polaczenie->query(sprintf("SELECT * FROM settings WHERE id='%s'", $game['setting']));
		$setting = $result->fetch_assoc();
		$result->free_result();

		$king[0] = ($setting['king'])%11;
		$king[1] = ($setting['king']-$setting['king']%11)/11;

		$script = 'var white = new Array(13); white[0] = ['.$king[0].', '.$king[1].']; ';

		$white[0][0]=0;
		$black[0][0]=0;

		for ($i=1; $i<13; $i++)
		{
			if ($setting['white'.$i])
			{
				$white[$i][0] = $setting['white'.$i];
				$white[$i][0] = ($setting['white'.$i])%11;
				$white[$i][1] = ($setting['white'.$i]-$setting['white'.$i]%11)/11;
			}
			else
			{
				$white[$i][0] = 0;
				$white[$i][1] = 0;
			}
			$script = $script.'white['.$i.'] = ['.$white[$i][0].', '.$white[$i][1].']; ';
		}

		$script = $script.'var black = new Array(24); ';

		for ($i=0; $i<24; $i++)
		{
			if ($setting['black'.($i+1)])
			{
				$black[$i][0] = $setting['black'.($i+1)];
				$black[$i][0] = ($setting['black'.($i+1)])%11;
				$black[$i][1] = ($setting['black'.($i+1)]-$setting['black'.($i+1)]%11)/11;
			}
			else
			{
				$black[$i][0] = 0;
				$black[$i][1] = 0;
			}
			$script = $script.'black['.$i.'] = ['.$black[$i][0].', '.$black[$i][1].']; ';
		}

		$script = $script.'var color = '.$color.'; '.'var move = '.$game['move'].'; var setting='.$game['setting'].'; var game='.$game['id'].'; var id_black='.$game['id_black'].'; var id_white='.$game['id_white'].'; var players = ["'.$blackplayer.' (czarne)", "'.$whiteplayer.' (białe)"]; ';
	}
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Hnefatafl - gra z <?php echo $game['adversary'].' id gry: '.$game['id'];?></title>

	<meta name="description" content="Hnafatafl - szachy wikingów" />
	<meta name="keywords" content="hnefatafl, szachy wikingów, wikingowie, szachy" />

	<link rel="stylesheet" href="style.css" type="text/css" />
	<?php echo '<script>'.$script.'	if (typeof XMLHttpRequest == "undefined") {
    XMLHttpRequest = function() {
        //IE wykorzystuje biblioteki ActiveX do tworzenia obiektu XMLHttpRequest
        return new ActiveXObject(
            //IE5 używa innego obektu XMLHTTP niż IE6 i wyższe
            navigator.userAgent.indexOf("MSIE 5") >=0 ? "Microsoft.XMLHTTP" : "Msxml2.XMLHTTP"
        );
    }
}</script>';
	if ($game['winner']==0) echo '<script src="game_ajax.js"></script>';
	else echo '<script src="dead_board.js"></script>';
 ?>
</head>

<?php
if ($game['setting']!=0) echo '<body onload="rysuj_plansze()" onunload="alert'."('Na pewno chcesz opuścić //stronę?')".'">';
else echo '<body>';
?>
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
	<h6>gra z <?php echo '<a href="user.php?id='.$game['adversary_id'].'">'.$game['adversary'].'</a>'; ?></h6>
	</div>

	<div id="bar">
		<a href="enter.php"><div class="menu">Graj przez sieć</div></a>
		<a href="rules.php"><div class="menu">Zasady</div></a>
		<a href="about.php"><div class="menu">O grze</div></a>
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
	<?php
		if ($game['setting']==0) echo '<h3>Wybór koloru pionków pozostawiono tobie. Grasz białymi czy czarnymi?</h3><form action="colors.php?game='.$game['id'].'&adv_id='.$game['adversary_id'].'" method="POST"><p><label><input type="radio" name="color" value="black"/>czarnymi</label></p><p><label><input type="radio" name="color" value="white"/>białymi</label></p><input type="submit" value="Rozpocznij grę"></form>'
	?>
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
