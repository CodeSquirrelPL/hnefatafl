INSERT INTO challenges VALUES (NULL, 1, 2, CURRENT_TIME, '0000-00-00 00:00:00', 0)
<?php
if (@$polaczenie->query(sprintf("INSERT INTO challenges VALUES (NULL, '%s', '%s', CURRENT_TIME, '0000-00-00 00:00:00', '%s'", $_SESSION['id'], $_GET['id'], $_POST['colors']))))
?>

<?php

if (@$polaczenie->query(sprintf("INSERT INTO challenges VALUES (NULL, '%s', '%s', CURRENT_TIME, '0000-00-00 00:00:00', '%s'", $_SESSION['id'], $_GET['id'], $_POST['colors'] ) ) ) )






if (@$polaczenie->query($challengeQuery))

		{
		$_SESSION['message'] = "Wyzwanie zostało wysłane.";
		header('Location: user.php?id='.$_GET['id']);
		}
		else





$challengeQuery = sprintf("INSERT INTO challenges VALUES (NULL, '%s', '%s', CURRENT_TIME, '0000-00-00 00:00:00', '%s'", $_SESSION['id'], $_GET['id'], $_POST['colors']))








$challengeQuery = sprintf("INSERT INTO challenges VALUES (NULL, '%s', '%s', CURRENT_TIME, '0000-00-00 00:00:00', '%s')", $_SESSION['id'], $_GET['id'], $_POST['colors']);
echo $challengeQuery;










 ?>
