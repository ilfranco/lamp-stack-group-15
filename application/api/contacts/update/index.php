<?php 
    require_once __DIR__ . './../../database/db.php';

    $method = $_SERVER['REQUEST_METHOD'];
    $data = $_GET;

    $inData = getRequestInfo();

    $pdo = db();

    $required_input = ["id"];

    if (!isset($inData["id"])) {
        returnWithError("Field 'id' is missing from packet.");
        return;
    }
    if (empty($inData["id"])) {
        returnWithError("Field 'id' cannot be empty.");
        return;
    }

    $optional_fields = ["first_name", "last_name", "email", "phone"];

    $update_values_sql = "";
    foreach ($optional_fields as $input) {
        if (!isset($inData[$input])) {
            continue;
        }
        if (empty($inData[$input])) {
            returnWithError($input . " cannot be empty.");
            return;
        }
        if ($input == "phone" && !preg_match("/^[0-9]+$/", $inData["phone"])) {
            returnWithError("Phone must contain only chars 0-9.");
            return;
        }

        $update_values_sql .= $input . " = '" . $inData[$input] . "', ";
    }

    $update_values_sql = substr($update_values_sql, 0, -2) . " ";

    $queryResults = $pdo->query(
        "UPDATE contacts SET " . $update_values_sql . "WHERE id = " . $inData["id"] . ";"
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
