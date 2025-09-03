<?php 
    require_once __DIR__ . './../../database/db.php';

    header('Content-Type: application/json');

    $method = $_SERVER['REQUEST_METHOD'];

    $raw = file_get_contents("php://input");
    $data = json_decode($raw, true);

    // This will display the data in the browsers network tab. 
    // Just click on the latest network request/response and click on preview.
    echo json_encode($data);

?>