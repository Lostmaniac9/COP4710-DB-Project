<?php
    require_once 'DBInfo.php';
    require_once 'functions.php';

    $inData = getRequestInfo();

    # Contact Book User registration information stored as variables.
    #$event_ID = date("Y/m/d");
    $com_UID = $inData["com_UID"];
    $com_event_ID = $inData["com_event_ID"];
    
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
        $stmt = $conn->prepare("DELETE FROM comments WHERE `com_UID` = ? AND `com_event_ID` = ?");
        $stmt->bind_param("ss", $com_UID, $com_event_ID);
        $stmt->execute();
        #returnWithInfo( $row['com_UID'],  $row['com_event_ID'] );
        returnWithError("Deletion Successful");
        $stmt->close();
        $conn->close();
    }
function returnWithInfo( $com_UID, $com_event_ID )
	{
		$retValue = '{"User": ' . $com_UID . ',"Deleted comment on Event":' . $com_event_ID . ',"error":""}';
		sendResultInfoAsJson( $retValue );
	}

?>