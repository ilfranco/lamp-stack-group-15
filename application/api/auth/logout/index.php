<?php
header('Content-Type: application/json');
session_start();
$_SESSION = [];
session_destroy();
header('Location: /');
?>