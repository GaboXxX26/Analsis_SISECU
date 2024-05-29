<?php
include("./_db.php");
session_start();
error_reporting(0);

global $pdo;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['guardar'])) {
    // ... (verificación de conexión a la base de datos)

    // Obtener los parámetros dinámicamente
    $consulta = "SELECT id FROM public.parametros";
    $stmt = $pdo->query($consulta);

    $parametroAnterior = 100;

    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id = $row['id'];
            $parametro = $_POST["parametro_$id"];
            $color = $_POST["color_$id"];
            $nombre = $_POST["nombre_$id"];

            // Preparar la consulta SQL para actualizar los datos
            $sql = "UPDATE public.parametros SET parametro = :parametro, color = :color, nombre = :nombre WHERE id = :id";
            $update_stmt = $pdo->prepare($sql);
            $update_stmt->bindParam(':parametro', $parametro);
            $update_stmt->bindParam(':color', $color);
            $update_stmt->bindParam(':nombre', $nombre);
            $update_stmt->bindParam(':id', $id);

            // Ejecutar la consulta
            if (!$update_stmt->execute()) {
                echo "Error al actualizar el registro con ID $id: " . implode(", ", $update_stmt->errorInfo()) . "<br>";
            }
        }
    }
    header('Location: ../views/user.php?section=parametro');
}
