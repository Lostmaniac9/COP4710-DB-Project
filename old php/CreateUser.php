<?php
    require_once 'DBHandler.php';
    require_once 'functions.php';

    $inData = getRequestInfo();

    # Contact Book User registration information stored as variables.
    $DateCreated = date("Y/m/d");
    $FirstName = $inData["FirstName"];
    $LastName = $inData["LastName"];
    $UserName = $inData["UserName"];
    $Password = $inData["Password"];
    $Email = $inData["Email"];


    # establish connection to MySQL server to access database and handle failed
    # connection error case
    $conn = new mysqli($serverName, $dBUsername, $dBPassword, $dBName);
    if( $conn->connect_error )
    {
		returnWithError( $conn->connect_error );
    }

    # Query the database to insert the registered user into the Users table if
	# validation constraints are met or else return an error
    else
    {
		$stmt = $conn->prepare("SELECT * FROM Users WHERE UserName =?");
        $stmt->bind_param("s", $UserName);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        if ($UserName == $row["UserName"])
		{
			returnWithError("Username already exists.");
		}
		else
        {
			$stmt = $conn->prepare("INSERT INTO Users (DateCreated, FirstName, LastName, UserName, Password, Email) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $DateCreated, $FirstName, $LastName, $UserName, $Password, $Email);
            $stmt->execute();
	   $sid = $stmt->insert_id;
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
