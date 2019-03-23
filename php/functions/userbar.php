<?php

  if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany']==true)
{
  if (!isset($_SESSION['games'])) $_SESSION['games'] = 0;
  if (isset($_SESSION['gameid'])) $link = 'game.php?game='.$_SESSION['gameid'];
  else $link = 'account.php#games';
	echo '<div id="login"><a href="account.php" title="Ustawienia profilu">'.$_SESSION['login'].'</a></div><div class="user"><a href="'.$link.'">rozgrywki: '.$_SESSION['games'].'</a></div><div class="user"><a href="account.php#challenges">wyzwania: '.$_SESSION['challenges'].'</a></div><div class="user"><a href="logout.php">wyloguj</a></div> <div class="empty"></div>';
}
	else echo	'<a href="enter.php">Zaloguj się lub zarejestruj</a>, żeby zagrać przez sieć';

  ?>
