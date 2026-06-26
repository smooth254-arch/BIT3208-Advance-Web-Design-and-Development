<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'backend-php' . DIRECTORY_SEPARATOR . 'node_client.php';

$data = fetch_node_shoes('http://localhost:3000/api/shoes');
if ($data === null) {
    echo "NODE_FETCH: failed\n";
    exit(1);
}
echo "NODE_FETCH: success\n";
echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";

?>
