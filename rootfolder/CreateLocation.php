<?php
    require_once 'DBInfo.php';
    require_once 'functions.php';

    $inData = getRequestInfo();

    # Contact Book User registration information stored as variables.
    #$event_ID = date("Y/m/d");
    $address = $inData["address"];
    #$time = date('m-d-Y H:i');
    $loc_name = $inData["loc_name"];
    $longitude = $inData["longitude"];
    $latitude = $inData["latitude"];
    
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
    { $stmt = $conn->prepare("SELECT * FROM locations WHERE loc_name =?");
        $stmt->bind_param("s", $loc_name);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        if (isset($row['loc_name']))
		{
			returnWithError("Location name is already taken.");
		}
        else{
            $stmt = $conn->prepare("INSERT INTO locations ( loc_name, address, longitude, latitude) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $loc_name, $address, $longitude, $latitude);
            $stmt->execute();
	   #$sid = $stmt->insert_id;   #check this one need to get UID
	    returnWithInfo($loc_name);
            $stmt->close();
            $conn->close();
        }
			
    }	

function returnWithInfo( $loc_name )
	{
		$retValue = '{"Location Name": ' . $loc_name . ',"error":""}';
		sendResultInfoAsJson( $retValue );
	}

?>