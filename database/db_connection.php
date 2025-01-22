<?php
require_once __DIR__ . '/../vendor/autoload.php';

// Load .env variables
if (!file_exists(dirname(__DIR__) . '/.env'))
{
    die("Error: .env file not found in " . dirname(__DIR__));
}

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

// Set content type
header('Content-Type: text/plain; charset=UTF-8');

// Get credentials from .env
$host = $_ENV['DB_HOST'];
$dbname = $_ENV['DB_NAME'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];

// Connect to MySQL
try {
    $db = new mysqli($host, $username, $password, $dbname);
} catch (\Throwable $th) {
    $db = new mysqli($host, $username, $password);
}

if ($db->connect_error) 
{
    die("Database connection failed: " . $db->connect_error);
}
?>