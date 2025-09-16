<?php 
    require_once __DIR__ . './../../database/db.php';

    $method = $_SERVER['REQUEST_METHOD'];
    $data = $_GET;

    $inData = getRequestInfo();

    $pdo = db();

    if (!isset($inData["page_index"]) || !isset($inData["contacts_per_page"]) || !isset($inData["user_id"])) {
        returnWithError("page_index, contacts_per_page, or user_id is missing from incomming packet.");
        return;
    }

    if (empty($inData["user_id"]) || empty($inData["contacts_per_page"])) {
        returnWithError("user_id or contacts_per_page is empty.");
        return;
    }

    returnWithInfo(
        searchByPage($pdo, $inData["page_index"], $inData["contacts_per_page"], $inData["user_id"]),
        getPagesAmount($pdo, $inData["contacts_per_page"], $inData["user_id"])
    );

    function getPagesAmount($pdo, $contacts_per_page, $userId) {
        $amtContacts = $pdo->query(
            "SELECT COUNT(*) FROM contacts WHERE user_id = " . $userId . ";"
        )->fetchColumn();
        $pagesAmt = (int)($amtContacts / $contacts_per_page);
        if ($amtContacts % $contacts_per_page != 0) {
            $pagesAmt++;
        }
        return $pagesAmt;
    }

    function searchByPage($pdo, $pageIndex, $contactsPerPage, $userId) {
        $searchResults = "";

        $offset = $pageIndex * $contactsPerPage;

        $queryResults = $pdo->query(
            "SELECT * FROM contacts WHERE user_id = " . $userId
            ." ORDER BY first_name ASC LIMIT " . $contactsPerPage . " OFFSET " . $offset . ";"
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