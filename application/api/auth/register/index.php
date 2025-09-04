<?php 
    require_once __DIR__ . './../../database/db.php';

    header('Content-Type: application/json');

    $method = $_SERVER['REQUEST_METHOD'];

    $raw = file_get_contents("php://input");
    $data = json_decode($raw, true);

    // This will display the data in the browsers network tab. 
    // Just click on the latest network request/response and click on preview.
    //echo json_encode($data);


$pdo = db(); // your db() helper returns a PDO

header('Access-Control-Allow-Origin: http://localhost');            // adjust for your frontend
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); echo json_encode(['error'=>'Use POST']); exit; }

// Accept JSON or form data
$ct   = $_SERVER['CONTENT_TYPE'] ?? '';
$body = (stripos($ct, 'application/json') !== false)
  ? (json_decode(file_get_contents('php://input'), true) ?? [])
  : $_POST;

$first = trim($body['firstName'] ?? '');
$last  = trim($body['lastName'] ?? '');
$email = strtolower(trim($body['email'] ?? ''));
$pass  = (string)($body['password'] ?? '');

// Basic validation
if (!$first || !$last || !$email || !$pass) {
  http_response_code(400);
  echo json_encode(['error' => 'firstName, lastName, email, password required']);
  exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  http_response_code(400); echo json_encode(['error'=>'invalid email']); exit;
}
if (strlen($pass) < 8) {
  http_response_code(400); echo json_encode(['error'=>'password too short']); exit;
}

try {
  // Enforce unique email
  $exists = $pdo->prepare('SELECT 1 FROM users WHERE email = ?');
  $exists->execute([$email]);
  if ($exists->fetchColumn()) {
    http_response_code(409); echo json_encode(['error'=>'email already registered']); exit;
  }

  // Insert user
  $hash = password_hash($pass, PASSWORD_BCRYPT);
  $ins = $pdo->prepare(
    'INSERT INTO users (first_name, last_name, email, password_hash) VALUES (?,?,?,?)'
  );
  $ins->execute([$first, $last, $email, $hash]);

  echo json_encode(['ok'=>true, 'user'=>[
    'id' => (int)$pdo->lastInsertId(),
    'firstName' => $first,
    'lastName'  => $last,
    'email'     => $email
  ]]);
} catch (PDOException $e) {
  // You can log $e->getMessage() for debugging
  http_response_code(500);
  echo json_encode(['error' => 'database error']);
}


?>