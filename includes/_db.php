<?php
$host = 'localhost';
$port = '5435';
$dbname = 'SIS';
$user = 'postgres';
$password = 'p.123456';

$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";

try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Conexión exitosa!";
} catch (PDOException $e) {
    die("Error al conectar: " . $e->getMessage());
}
?>
