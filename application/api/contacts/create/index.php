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

    $contactId = (int)$pdo->lastInsertId();

	sendResultInfoAsJson([
        'ok'      => true,
        'contact' => [
            'id'         => $contactId,
            'user_id'    => (int)$inData['user_id'],
            'first_name' => $inData['first_name'],
            'last_name'  => $inData['last_name'],
            'email'      => $inData['email'],
            'phone'      => $inData['phone'],
        ],
        'error' => ''
    ]);

	function getRequestInfo()
	{
		return json_decode(file_get_contents('php://input'), true);
	}

	function sendResultInfoAsJson($obj)
    {
    header('Content-Type: application/json');
    echo is_string($obj) ? $obj : json_encode($obj);
    }
	
	function returnWithError( $err )
	{
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}

?>