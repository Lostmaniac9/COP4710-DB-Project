<?php
    require_once 'DBInfo.php';
    require_once 'functions.php';

    $inData = getRequestInfo();

    # Contact Book User registration information stored as variables.
    $com_UID = $inData["com_UID"];
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
        $stmt = $conn->prepare("SELECT * FROM comments WHERE com_UID = ?") ;
        $stmt->bind_param("s",  $com_UID);
        #$stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc())
        {
            $searchResult .= '{';
            $searchResult .= '"com_UID" : "' . $row["com_UID"] . '", ';
            $searchResult .= '"com_event_ID" : "' . $row["com_event_ID"] . '", ';
            $searchResult .= '"text" : "' . $row["text"] . '", ';
            $searchResult .= '"rating" : "' . $row["rating"] . '" ';
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
                    $searchResult .= '"com_UID" : "' . $row["com_UID"] . '", ';
                    $searchResult .= '"com_event_ID" : "' . $row["com_event_ID"] . '", ';
                    $searchResult .= '"text" : "' . $row["text"] . '", ';
                    $searchResult .= '"rating" : "' . $row["rating"] . '" ';
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