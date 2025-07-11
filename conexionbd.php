<?php
$host = 'localhost';
$dbname = 'nombre_bd';
$user = 'usuario';
$password = 'contraseña';

try {
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, 
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    
    $pdo = new PDO($dsn, $user, $password, $options);
    echo "Conexión exitosa con PDO";
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
