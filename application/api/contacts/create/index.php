<?php 
    require_once __DIR__ . './../../database/db.php';

    $method = $_SERVER['REQUEST_METHOD'];
    $data = $_GET;

    $inData = getRequestInfo();

    $pdo = db();

    $required_input = ["user_id", "first_name", "last_name", "email", "phone"];

    foreach ($required_input as $input) {
        if (!isset($inData[$input])) {
            returnWithError($input . " is missing from packet.");
            return;
        }
        if (empty($inData[$input])) {
            returnWithError($input . " cannot be empty.");
            return;
        }
    }

    if (!preg_match("/^[0-9]+$/", $inData["phone"])) {
        returnWithError("Phone must contain only chars 0-9.");
        return;
    }


    $queryResults = $pdo->query(
        "INSERT INTO contacts (user_id, first_name, last_name, email, phone) "
        . "values (" . $inData["user_id"] . ", '" . $inData["first_name"]
        . "', '" . $inData["last_name"] . "', '" . $inData["email"] . "', '"
        . $inData["phone"] . "');"
    );

	sendResultInfoAsJson( '{"success":"true","error":""}' );

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

?>