<?php

	require_once 'php/functions/phpHeaderIn.php';

	{
		$login=$_POST['login'];
		$login=htmlentities($login, ENT_QUOTES, "UTF-8");
		$pass=$_POST['pass'];
		$pass=htmlentities($pass, ENT_QUOTES, "UTF-8");
		$pass=mysqli_real_escape_string($polaczenie, $pass);

		if($rezultat = @$polaczenie->query(sprintf("SELECT * FROM users WHERE login='%s' LIMIT 1", mysqli_real_escape_string($polaczenie, $login))));
		{
			$ilu = $rezultat->num_rows;
			$rezultat=$rezultat->fetch_assoc();
			if ($ilu>0 && password_verify($pass, $rezultat['pass']))
			{
				unset($_SESSION['errorlogin']);

				$_SESSION['id']=$rezultat['id'];
				$_SESSION['login']=$rezultat['login'];
				$rezultat = @$polaczenie->query("SELECT id FROM challenges WHERE challenged=".$_SESSION['id']." AND received='0000-00-00 00:00:00'");
				$_SESSION['challenges']=$rezultat->num_rows;
				$rezultat = @$polaczenie->query("SELECT id FROM games WHERE (id_black='".$_SESSION['id']."' OR id_white='".$_SESSION['id']."') AND date_finish='0000-00-00 00:00:00'");
				$_SESSION['games']=$rezultat->num_rows;
				$rezultat=$rezultat->fetch_assoc();
				if ($_SESSION['games']==1) $_SESSION['gameid']=$rezultat['id'];
				@$polaczenie->query("UPDATE users SET last_visit=CURRENT_TIME, online=1 WHERE id=".$_SESSION['id']);
				$_SESSION['zalogowany']=true;
				header('Location: account.php');
			}
			else
			{
				$_SESSION['errorlogin'] = "Nieprawidłowy login lub hasło";
				header('Location: enter.php');
			}
		}
		$polaczenie->close();
	}
?>
