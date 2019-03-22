<?php

  require_once "../functions/phpHeader.php";

  if (!isset($_POST['pass1']) || !isset($_POST['pass2'])) {echo "coś nie stykło"; header('Location: ../../account.php'); exit();}

  if ($_POST['pass1']!=$_POST['pass2'])
  {
    $_SESSION['error_pass']="Wpisano dwa różne hasła";
    header('Location: ../../account.php');
    exit();
  }
  else
  {
    unset($_SESSION['error_pass']);
    $pass=mysqli_real_escape_string($polaczenie,$_POST['pass1']);
    @$polaczenie->query(sprintf("UPDATE users SET pass = '%s' WHERE users.id = '%s'", password_hash($pass, PASSWORD_DEFAULT), $_SESSION['id']));
    $polaczenie->close();
    $_SESSION['message']="<p>Hasło zostało zmienione dla konta o id ".$_SESSION['id']."</p>";
    unset($_POST['pass1']);
    unset($_POST['pass2']);
    header('Location: ../../account.php');}

 ?>
