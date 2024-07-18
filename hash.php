<?php
require_once 'funcs.php';

$pdo = db_conn();

$stmt = $pdo->query('SELECT id, lpw FROM users');

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $hashed_password = password_hash($row['lpw'], PASSWORD_DEFAULT);
    
    $update = $pdo->prepare('UPDATE users SET lpw = :hashed_password WHERE id = :id');
    $update->execute([
        ':hashed_password' => $hashed_password,
        ':id' => $row['id']
    ]);
}

echo "All passwords have been hashed.";