<?php
include "../includes/_db.php";
session_start();
error_reporting(0);

$validar = $_SESSION['correo'];

if ($validar == null || $validar == '') {

    header("Location: ../includes/login.php");
    die();
}
// Verificar si el usuario está activo
$query = "	SELECT  estado FROM public.user WHERE correo = :correo";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':correo', $validar);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario || $usuario['estado'] != 'Activo') {
    // El usuario no existe o no está activo
    // Redirigir a una página de error o mostrar un mensaje
    header("Location: ../views/acceso_denegado.php");
    die();
}
$query = "SELECT rol_id FROM public.user WHERE correo = :correo";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':correo', $validar);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

$_SESSION['rol_id'] = $usuario['rol_id'];

// Definir permisos por rol
$permisos = [
    'add38db6-1687-4e57-a763-a959400d9da2' => ['user.php', 'eliminar_user.php', 'editar_user.php', 'tabla_admin.php'],
    'e17a74c4-9627-443c-b020-23dc4818b718' => ['lector.php', 'tabla_admin.php'],
    'ad2e8033-4a14-40d6-a999-1f1c6467a5e6' => ['analista.php']

];

// Verificar si el usuario tiene permiso para la página actual
$pagina_actual = basename($_SERVER['PHP_SELF']); // Obtiene el nombre del archivo actual
if (!in_array($pagina_actual, $permisos[$_SESSION['rol_id']])) {
    header("Location: ../views/acceso_denegado.php"); // O redirige a la página adecuada
    die();
}
?>

<?php

session_start();
error_reporting(0);

// Verificar si el usuario está autenticado
if (!isset($_SESSION['correo']) || empty($_SESSION['correo'])) {
    header("Location: ../includes/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Usuarios</title>
    <link rel="icon" type="image/x-icon" href="../Resources/images/ECU911.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-6 offset-sm-3">
                <div class="alert alert-danger text-center">
                    <p>¿Desea desactivar el Usuario?</p>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <form action="../includes/_functions.php" method="POST">
                            <input type="hidden" name="accion" value="eliminar_registro">
                            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                            <input type="submit" name="" value="Desactivar" class=" btn btn-danger">
                            <a href="user.php" class="btn btn-success">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>