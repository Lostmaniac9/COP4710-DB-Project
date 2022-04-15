<?php
    require_once 'DBInfo.php';
    require_once 'functions.php';

    $inData = getRequestInfo();

    # Contact Book User registration information stored as variables.
    #$event_ID = date("Y/m/d");
    #$uni_ID = $inData["uni_ID"];
    #$timestamp = date('H:i');
    $uni_superadmin_ID = $inData["uni_superadmin_ID"];
    $name = $inData["name"];
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
    { $stmt = $conn->prepare("SELECT * FROM university WHERE uni_superadmin_ID = ? OR name =?");
        $stmt->bind_param("ss", $uni_superadmin_ID, $name);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        if (isset($row['name']) || isset($row['uni_superadmin_ID']))
		{
			returnWithError("University name is already taken or superadmin has already made a university.");
		}
        else{
            $stmt = $conn->prepare("INSERT INTO university (  uni_superadmin_ID, name) VALUES (  ?, ?)");
            $stmt->bind_param("ss",  $uni_superadmin_ID, $name);
            $stmt->execute();
	        $sid = $stmt->insert_id;   #check this one need to get UID
	        returnWithInfo($sid, $uni_superadmin_ID );
            $stmt->close();
            $conn->close();
        }
        
			
    }	

function returnWithInfo( $sid, $uni_superadmin_ID )
	{
		$retValue = '{"uniID": ' . $sid . ',"superAdminID":' . $uni_superadmin_ID . ',"error":""}';
		sendResultInfoAsJson( $retValue );
	}

?>