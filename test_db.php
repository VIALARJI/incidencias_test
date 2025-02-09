<?php

require_once __DIR__ . '/database.php';

try {
    echo "Conexión exitosa a la base de datos.\n";

    // Obtener las tablas de la base de datos
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

    if ($tables) {
        echo "Tablas en la base de datos:\n";
        foreach ($tables as $table) {
            echo " - $table\n";
        }
    } else {
        echo "No hay tablas en la base de datos.\n";
    }
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage() . "\n";
    exit(1);
}
