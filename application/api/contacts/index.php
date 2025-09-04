<?php 
    require_once __DIR__ . './../database/db.php';

    header('Content-Type: application/json');

    $method = $_SERVER['REQUEST_METHOD'];

    $data = $_GET;

    // This will display the data in the browsers network tab. 
    // Just click on the latest network request/response and click on preview.
    echo json_encode($data);

?>