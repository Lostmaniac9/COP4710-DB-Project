<?php
	# server/database information
	$serverName = "localhost";
	$dBUsername = "root";
	$dBPassword = "AchillesHeel";
	$dBName = "project_db";

	#establish connection to MySQL server
	$conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName);

	# error message if script is not able to connect with the server
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
?>