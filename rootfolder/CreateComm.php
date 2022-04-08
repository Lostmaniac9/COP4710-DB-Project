<?php
    require_once 'DBInfo.php';
    require_once 'functions.php';

    $inData = getRequestInfo();

    # Contact Book User registration information stored as variables.
    #$event_ID = date("Y/m/d");
    $com_UID = $inData["com_UID"];
    $timestamp = date('H:i');
    $com_event_ID = $inData["com_event_ID"];
    $text = $inData["text"];
    #$timestamp = $inData["latitude"];
    
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
            $stmt = $conn->prepare("INSERT INTO comments (  com_UID,com_event_ID, text, timestamp) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss",  $com_UID,$com_event_ID, $text, $timestamp);
            $stmt->execute();
	        #$sid = $stmt->insert_id;   #check this one need to get UID
	        returnWithInfo($com_UID, $com_event_ID );
            $stmt->close();
            $conn->close();
        
			
    }	

function returnWithInfo( $com_UID, $com_event_ID )
	{
		$retValue = '{"User": ' . $com_UID . ',"Commented on Event":' . $com_event_ID . ',"error":""}';
		sendResultInfoAsJson( $retValue );
	}

?>