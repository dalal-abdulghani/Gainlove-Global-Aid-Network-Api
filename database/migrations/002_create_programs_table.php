<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config/config.php';

use App\Core\Database;

$db = Database::getInstance();

try {
    $db->exec("
        CREATE TABLE IF NOT EXISTS programs (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            description TEXT,
            image VARCHAR(255)
        )
    ");
    echo "Programs table created successfully.\n";
} catch (Exception $e) {
    die("Programs table creation failed: " . $e->getMessage());
}
