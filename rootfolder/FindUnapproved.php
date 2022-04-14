<?php
    require_once 'DBInfo.php';
    require_once 'functions.php';

    $inData = getRequestInfo();

    # Contact Book User registration information stored as variables.
    #$event_ID = isset($inData["event_ID"]);
    $desc1 = isset($inData["desc1"]);
    $time =  isset($inData["time"]);         #date('m-d-Y H:i');
    $loc_name = isset($inData["loc_name"]);
    $event_name = isset($inData["event_name"]);
    
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
        $searchResult .= '"results" : [';
        $query = "SELECT * FROM public_events P, events E WHERE P.event_ID = E.event_ID AND approved = 0";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc())
        {
            $searchResult .= '{';
            $searchResult .= '"event_ID" : "' . $row["event_ID"] . '", ';
            $searchResult .= '"desc1" : "' . $row["desc1"] . '", ';
            $searchResult .= '"time" : "' . $row["time"] . '", ';
            $searchResult .= '"loc_name" : "' . $row["loc_name"] . '", ';
            $searchResult .= '"event_name" : "' . $row["event_name"] . '", ';
            $searchResult .= '"approved" : "' . $row["approved"] . '" ';
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
                    $searchResult .= '"event_ID" : "' . $row["event_ID"] . '", ';
                    $searchResult .= '"desc1" : "' . $row["desc1"] . '", ';
                    $searchResult .= '"time" : "' . $row["time"] . '", ';
                    $searchResult .= '"loc_name" : "' . $row["loc_name"] . '", ';
                    $searchResult .= '"event_name" : "' . $row["event_name"] . '", ';
                    $searchResult .= '"approved" : "' . $row["approved"] . '" ';
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