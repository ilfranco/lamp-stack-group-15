<?php 
    require_once __DIR__ . './../database/db.php';

    $method = $_SERVER['REQUEST_METHOD'];
    // At this point $uri should be /contacts ^ /create ^ /read ^ /update ^ /delete
?>
