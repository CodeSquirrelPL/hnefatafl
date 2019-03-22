<?php

  require_once "../functions/phpHeader.php";

  if (!isset($_POST['pass']) || !isset($_POST['email']) || !isset($_SESSION['id']) || !isset($_SESSION['login'])) {echo "coś nie stykło"; exit();}

  require_once "../functions/verifyPass.php";

    if (verifyPassword($_POST['pass'], $_SESSION['login']==0, $polaczenie))
    {
      $_SESSION['message'] = "Wpisano nieprawidłowe hasło lub wystąpił problem z serwerem";
      header('Location: ../../account.php');
      exit();
    }
    else
  {
    unset($_SESSION['error_pass']);
    $email=mysqli_real_escape_string($polaczenie,$_POST['email']);
    @$polaczenie->query(sprintf("UPDATE users SET email = '%s' WHERE users.id = '%s'", $email, $_SESSION['id']));
    $polaczenie->close();
    $_SESSION['message']="<p>Do konta o id ".$_SESSION['id']." przypisano adres e-mail ".$email."</p>";
    unset($_POST['pass']);
    unset($_POST['email']);
    unset($email);
    header('Location: ../../account.php');
    exit();
}

 ?>
