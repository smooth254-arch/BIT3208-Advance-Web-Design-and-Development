<?php
// Configuration for PHP helpers. NODE_API_URL can be provided via environment variable or defaults to localhost:3000
$node = getenv('NODE_API_URL') ?: 'http://localhost:3000';
$node = rtrim($node, '/');
define('NODE_API_URL', $node);

?>
