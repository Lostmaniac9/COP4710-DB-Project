<?php
    require_once 'DBInfo.php';
    require_once 'functions.php';

    $inData = getRequestInfo();

    # Contact Book User registration information stored as variables.
    #$event_ID = isset($inData["event_ID"]);
    $foreign_RSO_ID = $inData["foreign_RSO_ID"];
    //$username =  $inData["username"];         #date('m-d-Y H:i');
    $loc_name = isset($inData["loc_name"]);
    $event_name = isset($inData["event_name"]);
    //$foreign_uni_ID = $inData["foreign_uni_ID"];
    
    $searchResult = "";
    $resultCount = 0;
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
        $searchResult .= '"results" : ['; //THIS IS EXTREMELY INAPPROPRITAELY NAMED
        $stmt = $conn->prepare("SELECT * FROM users P, roster E WHERE ( foreign_RSO_ID = ? AND P.foreign_RSO_ID = E.roster_RSO_ID AND P.UID = E.roster_UID)");
        $stmt->bind_param("s", $foreign_RSO_ID);
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc())
        {
            $searchResult .= '{';
            $searchResult .= '"UID" : "' . $row["UID"] . '", ';
            $searchResult .= '"username" : "' . $row["username"] . '" ';
            $searchResult .= '}';
            $resultCount++;


            while($row = $result->fetch_assoc())
            {
                if($resultCount > 0)
                {
                    $searchResult .= ",";
                }
                $resultCount++;
                $searchResult .= '{';
                    $searchResult .= '"UID" : "' . $row["UID"] . '", ';
                    $searchResult .= '"username" : "' . $row["username"] . '" ';
                $searchResult .= '}';
            }
            $searchResult .= ']';
            returnWithInfo($searchResult);
        }

        else
        {
            returnWithInfo2();
        }
        $stmt->close();

        $conn->close();

    }


    # obtain the login information based on the input parameters and send information
    # as JSON element.
    function returnWithInfo2()
    {
        $retValue = '{ "error" : "No Results Match"}';
        sendResultInfoAsJson($retValue);
    }

    function returnWithInfo($searchResult)
    {
        $retValue = '{'. $searchResult .', "error" : ""}';
        sendResultInfoAsJson($retValue);
    }
?>