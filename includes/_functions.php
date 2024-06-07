<?php
include "_db.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

use PHPMailer\PHPMailer\PHPMailer;

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
        case 'actualizar_registro';
            actualizar_registro();
            break;
    }
}

function editar_registro()
{
    global $pdo;
    extract($_POST);

    // Verificar si se proporcionaron nuevas contraseñas
    $key = "gt2513$%dhSDH^Whas@!@GDYEU!@&Dhahdihede#$#AhsahwDE#$#"; // Reemplaza con una clave realmente segura

    // Verificar si se proporcionaron nuevas contraseñas
    if (!empty($_POST['nueva_password']) && !empty($_POST['confirmar_password'])) {
        // Validar que las nuevas contraseñas coincidan
        if ($_POST['nueva_password'] !== $_POST['confirmar_password']) {
            echo "<script>alert('Las nuevas contraseñas no coinciden.');</script>";
            return; // Salir de la función si no coinciden
        }

        // Encriptar la nueva contraseña con AES-256-CBC
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encryptedPassword = openssl_encrypt($_POST['nueva_password'], 'aes-256-cbc', $key, 0, $iv);
        $encryptedPassword = base64_encode($encryptedPassword . '::' . $iv); // Combinar contraseña y IV

        // Actualizar la contraseña en la base de datos (usando el valor encriptado)
        $consultaPassword = "UPDATE public.user SET password = :encryptedPassword WHERE id = :id";
        $stmtPassword = $pdo->prepare($consultaPassword);
        $stmtPassword->execute(['encryptedPassword' => $encryptedPassword, 'id' => $_POST['id']]);
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
    echo "<script>window.location.href = '../views/user.php?section=editar';</script>";
}

/**
 * Function to desactivate a record from the database.
 *
 * This function updates the 'estado' column of the 'user' table to 'Inactivo' for the specified ID.
 * After deleting the record, it redirects the user to the 'user.php' page.
 *
 * @return void
 */
function eliminar_registro()
{
    global $pdo;
    $id = $_POST['id'];
    $consulta = "UPDATE public.user SET estado = 'Inactivo' WHERE id = :id";

    $stmt = $pdo->prepare($consulta);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    echo "<script>alert('Usuario desactivado exitosamente.');</script>";
    echo "<script>window.location.href = '../views/user.php?section=elimniar';</script>";
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

    $key = "gt2513$%dhSDH^Whas@!@GDYEU!@&Dhahdihede#$#AhsahwDE#$#";
    // Reemplaza con una clave realmente segura
    try {
        // Consulta para obtener el hash de la contraseña y el IV
        $consulta = "SELECT password, rol_id FROM public.user WHERE correo = :correo"; // Obtener también el rol_id
        $stmt = $pdo->prepare($consulta);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->execute();
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si el correo existe
        if ($fila) {
            // Obtener la contraseña encriptada y el IV
            list($encryptedPassword, $iv) = explode('::', base64_decode($fila['password']), 2);

            // Desencriptar la contraseña
            $decryptedPassword = openssl_decrypt($encryptedPassword, 'aes-256-cbc', $key, 0, $iv);

            // Verificar si la contraseña es correcta
            if ($decryptedPassword === $password_ingresada) {
                $_SESSION['correo'] = $correo;

                // Redireccionar según el rol_id (manteniendo la estructura original)
                if ($fila['rol_id'] == 'add38db6-1687-4e57-a763-a959400d9da2') { // Admin
                    header('Location: ../views/user.php');
                } elseif ($fila['rol_id'] == 'e17a74c4-9627-443c-b020-23dc4818b718') { // Usuario
                    header('Location: ../views/user.php');
                } elseif ($fila['rol_id'] == 'ad2e8033-4a14-40d6-a999-1f1c6467a5e6') { // Analista de Datos
                    header('Location: ../views/user.php');
                }
            } else {
                $_SESSION['error_login'] = "Usuario o contraseña incorrectos.";
                header('Location: ../includes/login.php');
            }
        } else {
            $_SESSION['error_login'] = "Usuario o contraseña incorrectos.";
            header('Location: ../includes/login.php');
        }
    } catch (PDOException $e) {
        echo "Error en el inicio de sesión: " . $e->getMessage();
        // Es buena práctica registrar el error en un log para depuración
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

            $key = "gt2513$%dhSDH^Whas@!@GDYEU!@&Dhahdihede#$#AhsahwDE#$#";

            list($encryptedPassword, $iv) = explode('::', base64_decode($usuario['password']), 2); // Desencriptar la contraseña
            $password = openssl_decrypt($encryptedPassword, 'aes-256-cbc', $key, 0, $iv); 

            $asunto = "Recuperacion de clave del Cuadro de Mando y Gestion";
            $mensaje = "Tu clave es: " . $password;

            // Configuracion del srservidor SMTP
            $mail = new PHPMailer(false);
            $mail->isSMTP();
            $mail->Host = 'MAIL02ECU911.ecu911.int';  // Reemplaza con tu servidor SMTP (ej: smtp.gmail.com)
            $mail->SMTPAuth = false;
            $mail->Username = 'ecu911\proyectos';
            $mail->Password = 'R3p0$1+0r103cu9ii';
            $mail->SMTPAutoTLS = false;
            $mail->SMTPSecure = false;  // O 'ssl' si es necesario
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
            echo "<script>window.location.href = '../includes/login.php';</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Error al recuperar contraseña: " . $e->getMessage() . "');</script>";
    }
}

function actualizar_registro()
{
    global $pdo; 

    // Verificar si se recibieron datos
    if (
        isset($_POST['id_registro']) &&
        isset($_POST['conve_stra']) &&
        isset($_POST['comp_insti']) &&
        isset($_POST['opera_cam']) &&
        isset($_POST['ausentimo']) &&
        isset($_POST['mobile_locator']) &&
        isset($_POST['dispoci']) &&
        isset($_POST['com_estra']) &&
        count($_POST['id_registro']) === count($_POST['conve_stra'])
    ) {
        // Iterar sobre los registros
        foreach ($_POST['id_registro'] as $index => $id_registro) {
            // Obtener los valores de los campos para este registro
            $conve_stra = $_POST['conve_stra'][$index];
            $comp_insti = $_POST['comp_insti'][$index];
            $opera_cam = $_POST['opera_cam'][$index];
            $ausentimo = $_POST['ausentimo'][$index];
            $mobile_locator = $_POST['mobile_locator'][$index];
            $dispoci = $_POST['dispoci'][$index];
            $com_estra = $_POST['com_estra'][$index];
            $sql = "UPDATE registros SET 
                conve_stra = :conve_stra,
                comp_insti = :comp_insti,
                opera_cam = :opera_cam,
                ausentimo = :ausentimo,
                mobile_locator = :mobile_locator,
                dispoci = :dispoci,
                com_estra = :com_estra
            WHERE id_registro = :id_registro";
            $stmt = $pdo->prepare($sql);
            // Vincular los parámetros
            $stmt->bindParam(':conve_stra', $conve_stra);
            $stmt->bindParam(':comp_insti', $comp_insti);
            $stmt->bindParam(':opera_cam', $opera_cam);
            $stmt->bindParam(':ausentimo', $ausentimo);
            $stmt->bindParam(':mobile_locator', $mobile_locator);
            $stmt->bindParam(':dispoci', $dispoci);
            $stmt->bindParam(':com_estra', $com_estra);
            $stmt->bindParam(':id_registro', $id_registro);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Registro actualizado con éxito
            } else {
                // Error al actualizar el registro
                echo "<script>alert('Error al actualizar el registro con ID: $id_registro');</script>";
            }
        }

        echo "<script>alert('Registros actualizados exitosamente.');;
        setTimeout(function() {";

        $rol_id = $_SESSION['rol_id'];
        $paginas_redireccion = [
            'add38db6-1687-4e57-a763-a959400d9da2' => 'user.php',
            'e17a74c4-9627-443c-b020-23dc4818b718' => 'lector.php',
            'ad2e8033-4a14-40d6-a999-1f1c6467a5e6' => 'analista.php'
        ];

        if (array_key_exists($rol_id, $paginas_redireccion)) {
            echo "window.location.href = '../views/" . $paginas_redireccion[$rol_id] . "';";
        } else {
            echo "window.location.href = '../views/acceso_denegado.php';";
        }

        echo "}, 1000); 
        </script>";
    }
}
