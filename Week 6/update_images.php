<?php
require_once 'db.php';

$updates = [
  [1, 'https://images.unsplash.com/photo-1460353581641-37baddab0fa2?w=200'],
  [2, 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=200'],
  [3, 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?w=200']
];

foreach($updates as [$id, $img]) {
  $stmt = $conn->prepare('UPDATE products SET image = ? WHERE id = ?');
  $stmt->bind_param('si', $img, $id);
  $stmt->execute();
  $stmt->close();
  echo "Updated product $id\n";
}

echo "Done! All 3 existing products now have real image URLs.\n";
$conn->close();
?>
