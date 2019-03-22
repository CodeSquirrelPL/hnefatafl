<?php
	session_start();

	header('Content-Type: application/json');

	require_once "php/functions/connect.php";

	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

	if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
		exit();
	}

//sprawdź, czy zmienne login i email są ustawione - DO POPRAWY KURWA

	function checkDatabase($connection, $table, $row, $input)
	{
		$result = @$connection->query(sprintf("SELECT id FROM ".$table." WHERE ".$row."='%s' LIMIT 1", mysqli_real_escape_string($connection,$input)));

		if (mysqli_num_rows($result)>0)
		{
			return 0;
		}
		else
		{
			return 1;
		}
	}

	$response = checkDatabase($polaczenie, "users", $_GET['inputType'], $_GET['input']);

	unset($_GET['input']);
	unset($_GET['inputType']);
	echo $response;

	exit();
?>
