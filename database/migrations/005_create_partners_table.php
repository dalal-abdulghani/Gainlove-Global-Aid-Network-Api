<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config/config.php';

use App\Core\Database;

$db = Database::getInstance();

try {
    $db->exec("
        CREATE TABLE IF NOT EXISTS partners (
            id INT AUTO_INCREMENT PRIMARY KEY,
            image VARCHAR(255) NOT NULL
        )
    ");
    echo " Partners table created successfully.\n";
} catch (Exception $e) {
    die("Partners table creation failed: " . $e->getMessage());
}
