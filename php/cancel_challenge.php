<?php

session_start();

if (!isset($_SESSION['zalogowany']) || ($_SESSION['zalogowany']==false))
{
  header('Location: ../../hnefatafl/enter.php');
  exit();
}

require_once "functions/connect.php";

$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

  if ($polaczenie->connect_errno!=0)
{
  echo "Error: ".$polaczenie->connect_errno;
  exit();
}


	if (!isset($_GET['challenge']))
	{
		header('Location: account.php');
		exit();
	}

  echo $_GET['challenge']."zz ";

	$result = @$polaczenie->query(sprintf("SELECT challenging, received FROM challenges WHERE id='%s'", $_GET['challenge']));

	if ($result->num_rows==0)
	{
      echo "W bazie nie ma wyzwania o podanym id";
      exit();     }
	else if ($result->num_rows==1)
	{
      $result=$result->fetch_assoc();

      if ($result['challenging']!=$_SESSION['id'])  {
        echo "wyzwanie o podanym id zostało rzucone przez inną osobę";
        exit();      }
      else if ($result['received']=='0000-00-00 00:00:00')  {
          if (@$polaczenie->query(sprintf("DELETE FROM challenges WHERE id='%s'", $_GET['challenge']))) {
            $_SESSION['message']="Wyzwanie zostało anulowane";  }
          else $_SESSION['message']="Anulowanie wyzwania nie powiodło się";
        header('Location: /hnefatafl/account.php');
        exit();   }

      }
  else echo "ERROR";
  exit();
?>
