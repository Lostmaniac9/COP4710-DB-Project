<?php
    require_once 'DBInfo.php';
    require_once 'functions.php';

    $inData = getRequestInfo();

    # Contact Book User registration information stored as variables.
    #$event_ID = date("Y/m/d");
    #$uni_ID = $inData["uni_ID"];
    #$timestamp = date('H:i');
    $RSO_admin_ID = $inData["RSO_admin_ID"];
    //$name = $inData["name"];
    $active = 1;
    #$timestamp = $inData["latitude"];
    
    #$Email = $inData["Email"];


    #$conn = $db;
    $conn = new mysqli($serverName, $dBUsername, $dBPassword, $dBName);
    if( $conn->connect_error )
    {
		returnWithError( $conn->connect_error );
    }

    //CHECK IF YOU'RE SUPPOSED TO BE ABLE TO MAKE MULTIPLE UNIVERSITIES THROUGH 1 SUPERADMIN ACC

    # Query the database to insert the registered user into the Users table if
	# validation constraints are met or else return an error
    else
    { 
            $stmt = $conn->prepare("INSERT INTO rsos ( RSO_admin_ID, active) VALUES ( ?, ?)");
            $stmt->bind_param("ss",  $RSO_admin_ID, $active);
            $stmt->execute();
	        $sid = $stmt->insert_id;   #check this one need to get UID
	        returnWithInfo($sid, $RSO_admin_ID );
            $stmt->close();
            $conn->close();
        
			
    }	

function returnWithInfo( $sid, $uni_superadmin_ID )
	{
		$retValue = '{"RSO_ID": ' . $sid . ',"AdminID":' . $uni_superadmin_ID . ',"error":""}';
		sendResultInfoAsJson( $retValue );
	}

?>