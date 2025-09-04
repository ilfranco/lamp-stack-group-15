<?php 
    require_once __DIR__ . './../../database/db.php';

    $pdo = db();  

    header('Content-Type: application/json');

    //$method = $_SERVER['REQUEST_METHOD'];

    //$raw = file_get_contents("php://input");
    //$data = json_decode($raw, true);

    // This will display the data in the browsers network tab. 
    // Just click on the latest network request/response and click on preview.
    //echo json_encode($data);
    

header('Access-Control-Allow-Origin: http://localhost');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); echo json_encode(['error'=>'Use POST']); exit; }

$ct   = $_SERVER['CONTENT_TYPE'] ?? '';
$data = (stripos($ct,'application/json') !== false)
  ? json_decode(file_get_contents('php://input'), true) ?? []
  : $_POST;

$email = strtolower(trim($data['email'] ?? ''));
$pass  = $data['password'] ?? '';

if (!$email || !$pass) { http_response_code(400); echo json_encode(['error'=>'email and password required']); exit; }

if (!isset($pdo)) {
  http_response_code(500);
  echo json_encode(['error' => 'DB not initialized (pdo missing)']);
  exit;
}


$stmt = $pdo->prepare('SELECT id, first_name, last_name, email, password_hash FROM users WHERE email = ?');
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user || !password_verify($pass, $user['password_hash'])) {
  http_response_code(401);
  echo json_encode(['error' => 'invalid credentials']);
  exit;
}

echo json_encode(['ok' => true, 'user' => [
  'id' => $user['id'],
  'firstName' => $user['first_name'],
  'lastName' => $user['last_name'],
  'email' => $user['email'],
]]);



?>