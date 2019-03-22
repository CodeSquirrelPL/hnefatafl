<?php

	function verifyPassword($pass, $login, $polaczenie)
  {
    if (!isset($pass) || !isset($login)) return 0;

      $pass=htmlentities($pass, ENT_QUOTES, "UTF-8");
      $pass=mysqli_real_escape_string($polaczenie, $pass);

    if($rezultat = @$polaczenie->query(sprintf("SELECT pass FROM users WHERE login='%s' LIMIT 1", $login)))
      {
        $rezultat=$rezultat->fetch_assoc();
        if (password_verify($pass, $rezultat['pass'])) return 1;
        else return 0;
      }
  }

 ?>
