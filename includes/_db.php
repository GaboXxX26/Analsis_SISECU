<?php
$host = 'localhost';
$port = '5432';
$dbname = 'SIS';
$user = 'postgres';
$password = 'cmg.2024';

$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";

try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Conexión exitosa!";
} catch (PDOException $e) {
    die("Error al conectar: " . $e->getMessage());
}
?>
