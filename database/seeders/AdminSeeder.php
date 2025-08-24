<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config/config.php';

use App\Core\Database;

$db = Database::getInstance();

$stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute(['admin']);
$exists = $stmt->fetch();

if (!$exists) {
    $password = password_hash("123", PASSWORD_BCRYPT);
    $stmt = $db->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'admin')");
    $stmt->execute(['admin', $password]);
    echo " Admin user created (username: admin, password: 123)\n";
} else {
    echo "Admin user already exists.\n";
}
