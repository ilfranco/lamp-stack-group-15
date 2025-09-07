<?php 
    require_once __DIR__ . './../../database/db.php';

    $method = $_SERVER['REQUEST_METHOD'];
    $data = $_GET;

    $inData = getRequestInfo();

    $pdo = db();

    $required_input = ["id"];

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

    $queryResults = $pdo->query(
        "DELETE FROM contacts WHERE id = '" . $inData["id"] . "';"
    );
    if (!$queryResults->rowCount()) {
        sendResultInfoAsJson( '{"success":"false","error":"Could not find id."}' );
    } else {
        sendResultInfoAsJson( '{"success":"true","error":""}' );
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

?>