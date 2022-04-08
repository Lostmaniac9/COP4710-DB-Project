<?php
    require_once 'DBInfo.php';
    require_once 'functions.php';

    $inData = getRequestInfo();

    # Contact Book User registration information stored as variables.
    #$event_ID = date("Y/m/d");
    $desc1 = $inData["desc1"];
    $time =  $inData["time"];         #date('m-d-Y H:i');
    $loc_name = $inData["loc_name"];
    $event_name = $inData["event_name"];
    
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
        $stmt = $conn->prepare("SELECT * FROM events WHERE time =?");
        $stmt->bind_param("s", $time);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        if (isset($row['time']))
		{
			returnWithError("Time is already taken.");
		}
		else
        {   
			$stmt = $conn->prepare("INSERT INTO events ( desc1, time, loc_name, event_name) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $desc1, $time, $loc_name, $event_name);
            $stmt->execute();
	        $sid = $stmt->insert_id;   #check this one need to get UID
	        returnWithInfo($sid);
            $stmt->close();
            $conn->close();
	}
    }
function returnWithInfo( $sid )
	{
		$retValue = '{"EventID":' . $sid . ',"error":""}';  
		sendResultInfoAsJson( $retValue );
	}

?>