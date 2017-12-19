<?php

	session_start();
	
	require_once "connect.php";
	
	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	
		if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
		exit();
	}
	
	$x = 0;
	
	for ($i=0; $i<11; $i++)
	{
		for ($j=0; $j<11; $j++)
		{
			$x++;
			$board[$i][$j] = $x;
		}
	}

$query = "INSERT INTO settings VALUES (NULL, ".$board[5][5].", ";
$query = $query.$board[3][5].", ";
$query = $query.$board[4][4].", ";
$query = $query.$board[4][5].", ";
$query = $query.$board[4][6].", ";
$query = $query.$board[5][3].", ";
$query = $query.$board[5][4].", ";
$query = $query.$board[5][6].", ";
$query = $query.$board[5][7].", ";
$query = $query.$board[6][4].", ";
$query = $query.$board[6][5].", ";
$query = $query.$board[6][6].", ";
$query = $query.$board[7][5].", ";
$query = $query.$board[0][3].", ";
$query = $query.$board[0][4].", ";
$query = $query.$board[0][5].", ";
$query = $query.$board[0][6].", ";
$query = $query.$board[0][7].", ";
$query = $query.$board[1][5].", ";
$query = $query.$board[3][0].", ";
$query = $query.$board[4][0].", ";
$query = $query.$board[5][0].", ";
$query = $query.$board[5][1].", ";
$query = $query.$board[6][0].", ";
$query = $query.$board[7][0].", ";
$query = $query.$board[3][10].", ";
$query = $query.$board[4][10].", ";
$query = $query.$board[5][9].", ";
$query = $query.$board[5][10].", ";
$query = $query.$board[6][10].", ";
$query = $query.$board[7][10].", ";
$query = $query.$board[9][5].", ";
$query = $query.$board[10][3].", ";
$query = $query.$board[10][4].", ";
$query = $query.$board[10][5].", ";
$query = $query.$board[10][6].", ";
$query = $query.$board[10][7].")";
	
	echo $query;
	
	$result = $polaczenie->query(sprintf($query));
	echo $result;

?>
