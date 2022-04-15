<?php
    require_once 'DBInfo.php';
    require_once 'functions.php';

    $inData = getRequestInfo();

    # Contact Book User registration information stored as variables.
    #$event_ID = isset($inData["event_ID"]);
    $UID = $inData["UID"];
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
        $searchResult .= '"results" : ['; // UNION 
        $stmt = $conn->prepare("SELECT E.event_ID FROM users P, rso_events R, events E WHERE ( UID = ? AND (P.foreign_RSO_ID = R.foreign_rso_ID AND R.event_ID = E.event_ID))UNION  (SELECT E.event_ID FROM public_events P, events E WHERE P.event_ID = E.event_ID ) UNION (SELECT E.event_ID FROM users P, private_events T, events E WHERE ( UID = ? AND (P.foreign_uni_ID = T.foreign_uni_ID AND T.event_ID = E.event_ID))) ORDER BY event_ID");
        $stmt->bind_param("ss", $UID,  $UID);
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc())
        {
            $searchResult .= '{';
                $searchResult .= '"event_ID" : "' . $row["event_ID"] . '" ';
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
                    $searchResult .= '"event_ID" : "' . $row["event_ID"] . '" ';
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