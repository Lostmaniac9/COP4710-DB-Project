<?php
    require_once 'DBInfo.php';
    require_once 'functions.php';

    $inData = getRequestInfo();

    # Contact Book User registration information stored as variables.
    $event_ID = $inData["event_ID"];
    $com_event_ID = isset($inData["com_event_ID"]);
    $text =  isset($inData["text"]);         #date('m-d-Y H:i');
    $timestamp = isset($inData["timestamp"]);
    $rating = isset($inData["rating"]);
    #$event_name = isset($inData["event_name"]);
    
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
        $searchResult .= '"results" : ['; #SELECT * FROM public_events P, events E WHERE P.event_ID = E.event_ID
        $stmt = $conn->prepare("SELECT longitude,latitude FROM locations L, events E WHERE event_ID = ? AND E.loc_name = L.loc_name") ;
        $stmt->bind_param("s",  $event_ID);
        #$stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc())
        {
            $searchResult .= '{';
            $searchResult .= '"longitude" : "' . $row["longitude"] . '", ';
            $searchResult .= '"latitude" : "' . $row["latitude"] . '" ';
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
                    $searchResult .= '"longitude" : "' . $row["longitude"] . '", ';
                    $searchResult .= '"latitude" : "' . $row["latitude"] . '" ';
                $searchResult .= '}';
            }
            $searchResult .= ']';
            returnWithInfo($searchResult);
        }

        else
        {
            returnWithError("No Results Match");
        }
        $stmt->close();

        $conn->close();

    }


    # obtain the login information based on the input parameters and send information
    # as JSON element.
    function returnWithInfo($searchResult)
    {
        $retValue = '{'. $searchResult .', "error" : ""}';
        sendResultInfoAsJson($retValue);
    }
?>