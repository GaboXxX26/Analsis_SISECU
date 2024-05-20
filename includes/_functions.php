<?php
include "_db.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

if (isset($_POST['accion'])) {
    switch ($_POST['accion']) {

        case 'editar_registro':
            editar_registro();
            break;

        case 'eliminar_registro':
            eliminar_registro();
            break;

        case 'acceso_user':
            acceso_user();
            break;

        case 'solicitar_recuperacion';
            solicitar_recuperacion();
            break;
    }
}

function editar_registro()
{
    global $pdo;
    extract($_POST);

    // Verificar si se proporcionaron nuevas contraseñas
    if (!empty($_POST['nueva_password']) && !empty($_POST['confirmar_password'])) {

        // Validar que las nuevas contraseñas coincidan
        if ($_POST['nueva_password'] !== $_POST['confirmar_password']) {
            echo "<script>alert('Las nuevas contraseñas no coinciden.');</script>";
            return; // Salir de la función si no coinciden
        }

        // Hashear la nueva contraseña
        $nueva_password_hash = password_hash($_POST['nueva_password'], PASSWORD_BCRYPT);

        // Actualizar la contraseña en la base de datos
        $consulta = "UPDATE public.user SET password = :password_hash WHERE id = :id";
        $stmt = $pdo->prepare($consulta);
        $stmt->execute(['password_hash' => $nueva_password_hash, 'id' => $_POST['id']]);
    }

    // Actualizar los demás campos
    $consulta = "UPDATE public.user SET nombre = :nombre, apellido = :apellido, correo = :correo, telefono = :telefono, dni = :dni, genero = :genero, direccion = :direccion, fecha_nacimiento = :fecha_nacimiento, rol_id = :rol_id, id_centro = :id_centro, estado = :estado WHERE id = :id";
    $stmt = $pdo->prepare($consulta);
    $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    $stmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
    $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
    $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
    $stmt->bindParam(':dni', $dni, PDO::PARAM_STR);
    $stmt->bindParam(':genero', $genero, PDO::PARAM_STR);
    $stmt->bindParam(':direccion', $direccion, PDO::PARAM_STR);
    $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento, PDO::PARAM_STR);
    $stmt->bindParam(':rol_id', $rol_id, PDO::PARAM_STR);
    $stmt->bindParam(':id_centro', $id_centro, PDO::PARAM_STR);
    $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT); // Asumiendo que el ID es un entero

    $stmt->execute();

    echo "<script>alert('Usuario actualizado exitosamente.');</script>";
    echo "<script>window.location.href = '../views/user.php';</script>";
}

function eliminar_registro()
{
    global $pdo;
    $id = $_POST['id'];
    $consulta = "UPDATE public.user SET estado = 'Inactivo' WHERE id = :id";

    $stmt = $pdo->prepare($consulta);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    header('Location: ../views/user.php');
}

// function acceso_user()
// {
//     global $pdo;
//     $correo = $_POST['correo'];
//     $password = $_POST['password'];
//     session_start();
//     $_SESSION['correo'] = $correo;

//     $consulta = "SELECT * FROM public.user WHERE correo=:correo AND password=:password";
//     $stmt = $pdo->prepare($consulta);
//     $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
//     $stmt->bindParam(':password', $password, PDO::PARAM_STR);
//     $stmt->execute();
//     $filas = $stmt->fetch(PDO::FETCH_ASSOC);

//     if($filas['rol_id'] == 'add38db6-1687-4e57-a763-a959400d9da2'){ //admin

//         header('Location: ../views/user.php');

//     }else if($filas['rol_id'] == 'e17a74c4-9627-443c-b020-23dc4818b718'){//Usuario
//         header('Location: ../views/lector.php');
//     }
//     else if($filas['rol_id'] == 'ad2e8033-4a14-40d6-a999-1f1c6467a5e6'){//Analista de Datos
//         header('Location: ../views/analista.php');

//     }else{
//         $_SESSION['error_login'] = 'Usuario o contraseña incorrectos';
//         header('Location: ../includes/login.php');
//     }
// }

function acceso_user()
{
    global $pdo;
    $correo = $_POST['correo'];
    $password_ingresada = $_POST['password'];  // Cambiamos el nombre de la variable
    session_start();

    try {
        // Consulta para obtener el hash de la contraseña
        $consulta = "SELECT * FROM public.user WHERE correo = :correo";
        $stmt = $pdo->prepare($consulta);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->execute();
        $filas = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si el correo existe y si la contraseña es correcta
        if ($filas && password_verify($password_ingresada, $filas['password'])) {
            $_SESSION['correo'] = $correo; // Ahora es seguro almacenar el correo

            // Redireccionar según el rol
            if ($filas['rol_id'] == 'add38db6-1687-4e57-a763-a959400d9da2') { // Admin
                header('Location: ../views/user.php');
            } elseif ($filas['rol_id'] == 'e17a74c4-9627-443c-b020-23dc4818b718') { // Usuario
                header('Location: ../views/lector.php');
            } elseif ($filas['rol_id'] == 'ad2e8033-4a14-40d6-a999-1f1c6467a5e6') { // Analista de Datos
                header('Location: ../views/analista.php');
            }
        } else {
            $_SESSION['error_login'] = "<script>alert(''Usuario o contraseña incorrectos'.');</script>";
            header('Location: ../includes/login.php');
        }
    } catch (PDOException $e) {
        echo "Error en el inicio de sesión: " . $e->getMessage();
    }
}

function solicitar_recuperacion()
{
    global $pdo;
    $correo = $_POST['correo'];

    try {
        $consulta = "SELECT password FROM public.user WHERE correo = :correo";
        $stmt = $pdo->prepare($consulta);
        $stmt->execute(['correo' => $correo]);
        $usuario = $stmt->fetch();

        if ($usuario) {
            $password = password_hash($usuario['password'], PASSWORD_DEFAULT); //decencriptar la clave, NORMA POCO SEGURA

            $asunto = "Recuperación de contraseña";
            $mensaje = "Tu contraseña es: " . $password;

            // Configuracion del srservidor SMTP
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = '10.121.6.211'; // Reemplaza con tu servidor SMTP (ej: smtp.gmail.com)
            $mail->SMTPAuth = true;
            $mail->Username = 'ecu911\\proyectos'; // Reemplaza con tu correo electrónico
            $mail->Password = 'R3p0$1+0r103cu9ii'; // Reemplaza con tu contraseña de correo
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // O 'ssl' si es necesario
            $mail->Port = 25;

            // Configuración del mensaje
            $mail->setFrom('ecu911.team.proyectos@ecu911.gob.ec', 'SIS ECU 911'); // Reemplaza con tus datos
            $mail->addAddress($correo);
            $mail->Subject = $asunto;
            $mail->Body = $mensaje;

            // Enviar el correo
            if ($mail->send()) {
                echo "<script>alert('Correo electrónico enviado con tu contraseña.');</script>";
                echo "<script>window.location.href = '../includes/login.php';</script>";
            } else {
                echo "<script>alert('Error al enviar el correo: {$mail->ErrorInfo}');</script>";
            }
        } else {
            // El correo electrónico no existe
            echo "<script>alert('El correo electrónico no está registrado.');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Error al recuperar contraseña: " . $e->getMessage() . "');</script>";
    }
}
