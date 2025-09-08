<?php 
    require_once __DIR__ . './../../database/db.php';

    $method = $_SERVER['REQUEST_METHOD'];
    $data = $_GET;

    $inData = getRequestInfo();

    $pdo = db();

    if (!isset($inData["search_term"]) || !isset($inData["user_id"])) {
        returnWithError("search_term or user_id missing from incomming packet.");
        return;
    }

    if (empty($inData["search_term"]) || empty($inData["user_id"])) {
        returnWithError("search_term or user_id is empty.");
        return;
    }

    returnWithInfo(searchByFirstName($pdo, $inData["search_term"], $inData["user_id"]));


    function searchByFirstName( $pdo, $searchTerm, $userId ) {
        $searchResults = "";

        $queryResults = $pdo->query(
            "SELECT * FROM contacts WHERE ("
                . "first_name LIKE '" . $searchTerm . "%' "
                . "OR last_name LIKE '" . $searchTerm . "%' "
                . "OR email LIKE '" . $searchTerm . "%' "
                . "OR phone LIKE '" . $searchTerm . "%' "
            . ") AND user_id = " . $userId .";"
        );
        foreach ($queryResults as $row) {

            $line = "{"
            . "\"id\": \"" . $row["id"] . "\", "
            . "\"first_name\": \"" . $row["first_name"] . "\", "
            . "\"last_name\": \"" . $row["last_name"] . "\", "
            . "\"email\": \"" . $row["email"] . "\", "
            . "\"phone\": \"" . $row["phone"] . "\", "
            . "\"created_at\": \"" . $row["created_at"] . "\", "
            . "\"updated_at\": \"" . $row["updated_at"] . "\" "
            . "}";
            $searchResults .= $line . "," . PHP_EOL;
        }

        $searchResults = substr($searchResults, 0, -2) . PHP_EOL;

        return $searchResults;
    }


	function getRequestInfo()
	{
		return json_decode(file_get_contents('php://input'), true);
	}

	function sendResultInfoAsJson( $obj )
	{
		header('Content-type: application/json');
		echo $obj;
	}
	
	function returnWithError( $err )
	{
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}
	
	function returnWithInfo( $searchResults )
	{
		$retValue = '{"results":[' . $searchResults . '],"error":""}';
		sendResultInfoAsJson( $retValue );
	}

?>