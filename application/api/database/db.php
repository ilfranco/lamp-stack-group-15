<?php
function db(): PDO {
    static $pdo = null;
    if ($pdo) return $pdo;

    $dsn  = getenv('DB_DSN');
    $user = getenv('DB_USER');
    $pass = getenv('DB_PASS');

    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
    return $pdo;
}
?>