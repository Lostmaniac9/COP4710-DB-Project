<?php
    require_once 'DBInfo.php';
    require_once 'functions.php';

    $inData = getRequestInfo();

    # Contact Book User registration information stored as variables.
    $roster_UID = $inData["roster_UID"];
    #$desc1 = $inData["desc1"];
    #$time =  $inData["time"];         #date('m-d-Y H:i');
    #$loc_name = $inData["loc_name"];
    #$event_name = $inData["event_name"];
    $approved = 0;
    $roster_RSO_ID = $inData["roster_RSO_ID"]; #which admin approved event
    #$pri_superadmin_ID = "1";
    
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
			$stmt = $conn->prepare("INSERT INTO roster ( roster_UID, roster_RSO_ID) VALUES (?,?)");
            $stmt->bind_param("ss",  $roster_UID,$roster_RSO_ID);
            $stmt->execute();
	        //$sid = $stmt->insert_id;   #check this one need to get UID
	        returnWithInfo($roster_UID, $roster_RSO_ID );
            $stmt->close();
            $conn->close();
	
    }
    function returnWithInfo( $roster_UID, $roster_RSO_ID )
	{
		$retValue = '{"UserID": ' . $roster_UID . ',"RSOID":' . $roster_RSO_ID . ',"error":""}';
		sendResultInfoAsJson( $retValue );
	}

?>