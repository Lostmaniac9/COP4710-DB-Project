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
    $approved = 1;
    #$pub_admin_ID = $inData["pub_admin_ID"];
    #$pub_superadmin_ID = "1";
    
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
    { #UPDATE `public_events` SET `approved` = '1' WHERE `public_events`.`event_ID` = 10
        $stmt = $conn->prepare("UPDATE public_events SET approved = '1' WHERE public_events.event_ID = ? ");
        $stmt->bind_param("s",  $event_ID);
        $stmt->execute();
        $stmt->close();
        returnWithError("");
	}
    
function returnWithInfo( $sid )
	{
		$retValue = '{"EventID":' . $sid . ',"error":""}';  
		sendResultInfoAsJson( $retValue );
	}

?>