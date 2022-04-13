<?php
    require_once 'DBInfo.php';
    require_once 'functions.php';

    $inData = getRequestInfo();

    # Contact Book User registration information stored as variables.
    $event_ID = $inData["event_ID"];
    #$desc1 = $inData["desc1"];
    #$time =  $inData["time"];         #date('m-d-Y H:i');
    #$loc_name = $inData["loc_name"];
    #$event_name = $inData["event_name"];
    $approved = 0;
    $pri_admin_ID = $inData["pri_admin_ID"]; #which admin approved event
    $pri_superadmin_ID = "1";
    
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
        $stmt = $conn->prepare("SELECT * FROM private_events WHERE event_ID =?"); //THERE NEEDS TO BE AN EVENT FIRST FOR THIS SCRIPT TO WORK
        $stmt->bind_param("s", $event_ID); //check above line
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        if (isset($row['event_ID']))
		{
			returnWithError("Event is already made.");
		}
		else
        {  
			$stmt = $conn->prepare("INSERT INTO private_events ( event_ID, pri_admin_ID,pri_superadmin_ID) VALUES (?,?,?)");
            $stmt->bind_param("sss",  $event_ID,$pri_admin_ID,$pri_superadmin_ID);
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