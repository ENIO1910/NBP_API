<?php
declare(strict_types=1);

$configPath = __DIR__ . '/../config/config.php';
$config = require $configPath;


$dbConfig = $config['db'];

$host = $dbConfig['host'];
$database = $dbConfig['database'];
$user = $dbConfig['user'];
$password = $dbConfig['password'];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    var_dump('udało się');

} catch (PDOException $e) {
    echo 'Błąd połączenia z bazą danych: ' . $e->getMessage();
}

