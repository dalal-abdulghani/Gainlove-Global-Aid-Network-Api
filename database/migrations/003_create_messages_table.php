<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config/config.php';

use App\Core\Database;

$db = Database::getInstance();

try {
    $db->exec("
        CREATE TABLE IF NOT EXISTS messages (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            phone VARCHAR(20),
            email VARCHAR(100),
            question TEXT
        )
    ");
    echo "Messages table created successfully.\n";
} catch (Exception $e) {
    die("Messages table creation failed: " . $e->getMessage());
}
