<?php
		require_once 'DBInfo.php';
		require_once 'functions.php';

		$inData = getRequestInfo();

		# Contact Book login information stored as variables
		$UID = 0;
		$username = "";

		# establish connection to MySQL server to access database and handle failed
		# connection error case
		$conn = new mysqli($serverName, $dBUsername, $dBPassword, $dBName);
		if( $conn->connect_error )
		{
			returnWithError( $conn->connect_error );
		}

		# Load the SQL query into a variable and append the corresponding parameters
		# and return information if Login is valid based on returned row or else return an error
		else
		{
			$stmt = $conn->prepare("SELECT a_UID, username FROM admins WHERE username=? AND password =?");
			$stmt->bind_param("ss", $inData["username"], $inData["password"]);
			$stmt->execute();
			$result = $stmt->get_result();

			if( $row = $result->fetch_assoc()  )
			{
				returnWithInfo( $row['username'],  $row['a_UID'] );
			}
			else
			{
				returnWithError("Incorrect Information Inputted");
			}

			$stmt->close();
			$conn->close();
		}

		# obtain the login information based on the input parameters and send information
		# as JSON element.
		function returnWithInfo( $username, $UID )
		{
			$retValue = '{"ID":' . $UID . ',"Welcome,":"' . $username . '","error":""}';
			sendResultInfoAsJson( $retValue );
		}