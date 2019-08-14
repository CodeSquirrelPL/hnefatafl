<?php

	session_start();

	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		header('Location: account.php');
		exit();
	}

	require_once "php/functions/connect.php";

	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

		if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
		exit();
	}

		$login = mysqli_real_escape_string($polaczenie,$_POST['login']);
		$result = @$polaczenie->query(sprintf("SELECT id FROM users WHERE login='%s'", $login));
		$result = $result->fetch_assoc();

		if ($result['num_rows']>0)
		{
			$_SESSION['error_login']="Login jest już zajęty.";
			header('Location: enter.php');
			unset($login);
			unset($result);
			exit();
		}
		else
		{
			unset($_SESSION['error_login']);
		}

		if ($_POST['pass1']!=$_POST['pass2'])
		{
			$_SESSION['error_pass']="Wpisano dwa różne hasła";
			header('Location: enter.php');
			exit();
		}
		else
		{
			unset($_SESSION['error_pass']);
			$pass=mysqli_real_escape_string($polaczenie,$_POST['pass1']);
		}

		if(isset($login) && isset($pass))
		@$polaczenie->query(sprintf('INSERT INTO users VALUES (NULL,"%s","%s", "","",CURRENT_TIME,CURRENT_TIME,"",1)',  $login, password_hash($pass, PASSWORD_DEFAULT)));
		$_SESSION['message']="<p>Konto zostało utworzone</p>";
		$_SESSION['login']=$login;
		$_SESSION['id']=mysqli_insert_id($polaczenie);
		$polaczenie->close();
		$_SESSION['zalogowany']=true;
		header('Location: account.php');


?>
