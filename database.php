<?php

$envPath = __DIR__ . '/.env';

if (file_exists($envPath)) {
    $envVars = parse_ini_file($envPath, false, INI_SCANNER_RAW);
    foreach ($envVars as $key => $value) {
        $_ENV[$key] = $_ENV[$key] ?? $value;
    }
} else {
    die("Error: No se encontró el archivo .env ($envPath).");
}

foreach (['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASSWORD'] as $var) {
    if (empty($_ENV[$var])) {
        die("Error: Falta la variable '$var' en .env.");
    }
}

try {
    $pdo = new PDO(
        "mysql:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_NAME']};charset=utf8mb4",
        $_ENV['DB_USER'],
        $_ENV['DB_PASSWORD']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->query("SELECT 1"); // Prueba la conexión
} catch (PDOException $e) {
    $logPath = __DIR__ . '/logs/error.log';
    if (!file_exists(dirname($logPath))) {
        mkdir(dirname($logPath), 0755, true);
    }
    error_log('[' . date('Y-m-d H:i:s') . '] DB Error: ' . $e->getMessage() . PHP_EOL, 3, $logPath);
    die("Error de conexión. Inténtelo más tarde.");
}

return $pdo;
