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

    $id = (int)$inData["id"];

    // ensure the contact exists -------------------------------------
    $chk = $pdo->prepare('SELECT 1 FROM contacts WHERE id = ?');
    $chk->execute([$id]);
    if (!$chk->fetchColumn()) {
        http_response_code(404);                 // optional, nicer for clients
        returnWithError("Contact with id {$id} not found.");
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

        // Append to SQL string
        $update_values_sql .= $input . " = '" . $inData[$input] . "', ";
    }

    if ($update_values_sql === '') {
        returnWithError("At least one of first_name, last_name, email, phone must be provided.");
        return;
    }

    // Remove trailing comma and space, if any
    $update_values_sql = substr($update_values_sql, 0, -2) . " ";

    $queryResults = $pdo->query(
        "UPDATE contacts SET " . $update_values_sql . "WHERE id = " . $id . ";"
    );

    // Fetch the updated row and return it
$rowStmt = $pdo->prepare(
    'SELECT id, user_id, first_name, last_name, email, phone, created_at, updated_at
       FROM contacts
      WHERE id = ?
      LIMIT 1'
);
$rowStmt->execute([$id]);
$row = $rowStmt->fetch(PDO::FETCH_ASSOC);

	sendResultInfoAsJson(json_encode([
    'success' => 'true',
    'contact' => [
        'id'         => (int)$row['id'],
        'user_id'    => (int)$row['user_id'],
        'first_name' => $row['first_name'],
        'last_name'  => $row['last_name'],
        'email'      => $row['email'],
        'phone'      => $row['phone'],
        'created_at' => $row['created_at'],
        'updated_at' => $row['updated_at'],
    ],
    'error' => ''
]));

	function sendResultInfoAsJson( $obj )
	{
		header('Content-type: application/json');
		echo $obj;
	}
    function getRequestInfo()
	{
		return json_decode(file_get_contents('php://input'), true);
	}
	
	function returnWithError( $err )
	{
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}

?>
