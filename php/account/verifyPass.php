<?php

	session_start();

	if (!isset($_SESSION['zalogowany']) || ($_SESSION['zalogowany']==false))
	{
		header('Location: http://localhost/hnefatafl/enter.php');
		exit();
	}

	require_once "../functions/connect.php";

	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

		if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
		exit();
	}
//powyższe znajduje się w pliku phpHeader

if (!isset($_SESSION['login']) || !isset($_POST['pass'])) exit();   //dopracować reakcję na błąd


$pass=$_POST['pass'];
$pass=htmlentities($pass, ENT_QUOTES, "UTF-8");
$pass=mysqli_real_escape_string($polaczenie, $pass);

if($rezultat = @$polaczenie->query(sprintf("SELECT pass FROM users WHERE login='%s' LIMIT 1", $_SESSION['login'])))
{
  $rezultat=$rezultat->fetch_assoc();
  if (password_verify($pass, $rezultat['pass'])) echo "1";
  else echo "0";
}
else echo "zxc";

 ?>
