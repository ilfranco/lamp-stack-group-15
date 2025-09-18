<?php 
    require_once __DIR__ . './../../database/db.php';

    $method = $_SERVER['REQUEST_METHOD'];
    $data = $_GET;

    $inData = getRequestInfo();

    session_start();

    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        returnWithError("Not authenticated");
        exit;
    }

    $pdo = db();

    if (!isset($inData["page_index"]) || !isset($inData["contacts_per_page"]) || !isset($inData["search_term"]) || !isset($inData["user_id"])) {
        returnWithError("search_term, user_id, page_index, or contacts_per_page missing from incomming packet.");
        return;
    }

    if (empty($inData["search_term"]) || empty($inData["contacts_per_page"]) || empty($inData["user_id"])) {
        returnWithError("search_term, contacts_per_page, or user_id is empty.");
        return;
    }


    returnWithInfo(
        searchByFirstName(
            $pdo, $inData["search_term"], $inData["user_id"],
            $inData["page_index"], $inData["contacts_per_page"]
        ),
        getPagesAmount(
            $pdo, $inData["search_term"], $inData["contacts_per_page"],
            $inData["user_id"]
        )
    );

    function getPagesAmount($pdo, $searchTerm, $contactsPerPage, $userId) {
        $amtContacts = $pdo->query(
            "SELECT COUNT(*) FROM contacts WHERE ("
                . "first_name LIKE '" . $searchTerm . "%' "
                . "OR last_name LIKE '" . $searchTerm . "%' "
                . "OR email LIKE '" . $searchTerm . "%' "
                . "OR phone LIKE '" . $searchTerm . "%' "
            . ") AND user_id = " . $userId ." ORDER BY first_name ASC;"
        )->fetchColumn();
        $pagesAmt = (int)($amtContacts / $contactsPerPage);
        if ($amtContacts % $contactsPerPage != 0) {
            $pagesAmt++;
        }
        return $pagesAmt;
    }

    function searchByFirstName( $pdo, $searchTerm, $userId, $pageIndex, $contactsPerPage ) {
        $searchResults = "";

        $offset = $pageIndex * $contactsPerPage;

        $queryResults = $pdo->query(
            "SELECT * FROM contacts WHERE ("
                . "first_name LIKE '" . $searchTerm . "%' "
                . "OR last_name LIKE '" . $searchTerm . "%' "
                . "OR email LIKE '" . $searchTerm . "%' "
                . "OR phone LIKE '" . $searchTerm . "%' "
            . ") AND user_id = " . $userId ." ORDER BY first_name ASC "
            . "LIMIT " . $contactsPerPage . " OFFSET " . $offset . ";"
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
	
	function returnWithInfo( $searchResults, $totalPages )
	{
		$retValue = '{"results":[' . $searchResults . '], "total_pages": "' . $totalPages . '", "error":""}';
		sendResultInfoAsJson( $retValue );
	}

?>