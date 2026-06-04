<?php
// Simple PHP JSON API for week 3
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');
    exit;
}

$shoes = [
    ['id' => 1, 'name' => 'Versache', 'price' => 'Ksh 4,500'],
    ['id' => 2, 'name' => 'Airforce 1 Custom', 'price' => 'Ksh 3,200'],
    ['id' => 3, 'name' => 'Classic Loafers', 'price' => 'Ksh 5,000'],
];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode($shoes, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $body = file_get_contents('php://input');
    $data = json_decode($body, true);
    if (!$data) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid JSON']);
        exit;
    }
    // echo back created item (no persistence in this simple example)
    $data['id'] = count($shoes) + 1;
    http_response_code(201);
    echo json_encode(['created' => $data], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

http_response_code(405);
echo json_encode(['error' => 'Method not allowed']);

?>
