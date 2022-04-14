<?php
    require_once 'DBInfo.php';
    require_once 'functions.php';

    $inData = getRequestInfo();

    # Contact Book User registration information stored as variables.
    #$DateCreated = date("Y/m/d");
    #$FirstName = $inData["FirstName"];
    #$LastName = $inData["LastName"];
    $username = $inData["username"];
    $password = $inData["password"];
    
    #$Email = $inData["Email"];


    #$conn = $db;
    $conn = new mysqli($serverName, $dBUsername, $dBPassword, $dBName);
    if( $conn->connect_error )
    {
		returnWithError( $conn->connect_error );
    }

    # Query the database to insert the registered user into the Users table if
	# validation constraints are met or else return an error
    else
    {
		$stmt = $conn->prepare("SELECT * FROM users WHERE username =? OR password =?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        if (isset($row['username']) && isset($row['password']))
		{
			returnWithError("Username and Password already exists.");
		}
        else if (isset($row['password']))
		{
			returnWithError("Password already exists.");
		}
        else if (isset($row['username'] ))
		{
			returnWithError("Username already exists.");
		}
		else
        {
			$stmt = $conn->prepare("INSERT INTO users ( username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();
	   $sid = $stmt->insert_id;   #check this one need to get UID
	    returnWithInfo($sid);
            $stmt->close();
            $conn->close();

		}
	}

function returnWithInfo( $sid )
	{
		$retValue = '{"newUserID":' . $sid . ',"error":""}';
		sendResultInfoAsJson( $retValue );
	}
?>