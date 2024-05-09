<?php
include "_db.php";

if (isset($_POST['accion'])) {
    switch ($_POST['accion']) {
        //casos de registros
        case 'editar_registro':
            editar_registro();
            break;

        case 'eliminar_registro':
            eliminar_registro();
            break;

        case 'acceso_user':
            acceso_user();
            break;
    }
}

function editar_registro()
{
    global $pdo;
    extract($_POST);
    $consulta = "UPDATE public.user SET nombre = :nombre, apellido = :apellido, correo = :correo, telefono = :telefono, dni = :dni, genero = :genero, direccion = :direccion, fecha_nacimiento = :fecha_nacimiento, password = :password , rol_id = :rol_id, id_centro = :id_centro, estado= :estado WHERE id = :id";
    $stmt = $pdo->prepare($consulta);
    $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    $stmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
    $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
    $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
    $stmt->bindParam(':dni', $dni, PDO::PARAM_STR);
    $stmt->bindParam(':genero', $genero, PDO::PARAM_STR);
    $stmt->bindParam(':direccion', $direccion, PDO::PARAM_STR);
    $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento, PDO::PARAM_STR);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    $stmt->bindParam(':rol_id', $rol_id, PDO::PARAM_STR);
    $stmt->bindParam(':id_centro', $id_centro, PDO::PARAM_STR);
    $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    $stmt->execute();

    header('Location: ../views/user.php');
}

function eliminar_registro()
{
    global $pdo;
    $id = $_POST['id'];
    $consulta = "DELETE FROM public.user WHERE id = :id";

    $stmt = $pdo->prepare($consulta);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    header('Location: ../views/user.php');
}

function acceso_user()
{
    global $pdo;
    $correo = $_POST['correo'];
    $password = $_POST['password'];
    session_start();
    $_SESSION['correo'] = $correo;

    $consulta = "SELECT * FROM public.user WHERE correo=:correo AND password=:password";
    $stmt = $pdo->prepare($consulta);
    $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    $stmt->execute();
    $filas = $stmt->fetch(PDO::FETCH_ASSOC);

    if($filas['rol_id'] == 'add38db6-1687-4e57-a763-a959400d9da2'){ //admin

        header('Location: ../views/user.php');

    }else if($filas['rol_id'] == 'e17a74c4-9627-443c-b020-23dc4818b718'){//Usuario
        header('Location: ../views/lector.php');
    }
    else if($filas['rol_id'] == 'ad2e8033-4a14-40d6-a999-1f1c6467a5e6'){//Analista de Datos
        header('Location: ../views/analista.php');

    }else{
        $_SESSION['error_login'] = 'Usuario o contraseña incorrectos';
        header('Location: ../includes/login.php');
    }
}