<?php 
    require_once __DIR__ . './../database/db.php';

    $method = $_SERVER['REQUEST_METHOD'];
    // At this point $uri should be /register ^ /login ^ /authorize.
?>