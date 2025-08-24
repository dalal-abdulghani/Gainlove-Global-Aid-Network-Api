<?php
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

define("DB_HOST", $_ENV['DB_HOST']);
define("DB_NAME", $_ENV['DB_NAME']);
define("DB_USER", $_ENV['DB_USER']);
define("DB_PASS", $_ENV['DB_PASS']);
define("JWT_SECRET", $_ENV['JWT_SECRET']);
define("APP_ENV", $_ENV['APP_ENV']);
define("APP_DEBUG", $_ENV['APP_DEBUG']);
define("APP_URL", $_ENV['APP_URL']);
