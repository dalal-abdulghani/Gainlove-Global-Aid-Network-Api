<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config/config.php';

use App\Core\Database;

$db = Database::getInstance();

try {
    $db->exec("
        CREATE TABLE IF NOT EXISTS news (
            id INT AUTO_INCREMENT PRIMARY KEY,
            image VARCHAR(255),
            date DATE,
            title VARCHAR(255) NOT NULL
        )
    ");
    echo " News table created successfully.\n";
} catch (Exception $e) {
    die("News table creation failed: " . $e->getMessage());
}
