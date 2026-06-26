<?php
// Simple Node API client used by PHP pages to fetch data from the Node backend.
include_once __DIR__ . DIRECTORY_SEPARATOR . 'config.php';

function fetch_node_shoes($url = null) {
    $base = defined('NODE_API_URL') ? NODE_API_URL : 'http://localhost:3000';
    if ($url === null) $url = $base . '/api/shoes';
    $opts = [
        'http' => [
            'method' => 'GET',
            'header' => "Accept: application/json\r\n",
            'timeout' => 5,
        ],
    ];
    $context = stream_context_create($opts);
    $result = @file_get_contents($url, false, $context);
    if ($result === false) {
        return null;
    }
    $data = json_decode($result, true);
    if (!is_array($data)) return null;
    return $data;
}

?>
