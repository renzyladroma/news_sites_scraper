<?php

	set_time_limit(0);

	$servername = "";
	$username = "";
	$password = "";
	$dbname = "";

	$connection = new mysqli($servername, $username, $password, $dbname);
	mysqli_set_charset($connection,"utf8");

?>

