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

    $inData["user_id"] = $_SESSION["user_id"];

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