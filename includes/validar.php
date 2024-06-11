<?php
include "_db.php";

if (isset($_POST['registrar'])) {

    if (
        strlen($_POST['nombre']) >= 1
        && strlen($_POST['apellido']) >= 1
        && strlen($_POST['correo']) >= 1
        && strlen($_POST['telefono']) >= 1
        && strlen($_POST['dni']) >= 1
        && strlen($_POST['genero']) >= 1
        && strlen($_POST['direccion']) >= 1
        && strlen($_POST['fecha_nacimiento']) >= 1
        && strlen($_POST['password']) >= 1
        && strlen($_POST['rol_id']) >= 1
        && strlen($_POST['id_centro']) >= 1
        && strlen($_POST['estado']) >= 1
    ) {

        $nombre = trim($_POST['nombre']);
        $apellido = trim($_POST['apellido']);
        $correo = trim($_POST['correo']);
        $telefono = trim($_POST['telefono']);
        $dni = trim($_POST['dni']);
        $genero = trim($_POST['genero']);
        $direccion = trim($_POST['direccion']);
        $fecha_nacimiento = trim($_POST['fecha_nacimiento']);
        $password = trim($_POST['password']);
        $rol_id = trim($_POST['rol_id']);
        $id_centro = trim($_POST['id_centro']);
        $estado = trim($_POST['estado']);

        // Encriptar la contraseña con AES-256-CBC
        $key = "gt2513$%dhSDH^Whas@!@GDYEU!@&Dhahdihede#$#AhsahwDE#$#"; 
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encryptedPassword = openssl_encrypt($password, 'aes-256-cbc', $key, 0, $iv);
        $encryptedPassword = base64_encode($encryptedPassword . '::' . $iv); // Combinar contraseña y IV

        $consulta = "INSERT INTO public.user (id, nombre, apellido, correo, telefono, dni, genero, direccion, fecha_nacimiento, password, rol_id, id_centro, estado) 
        VALUES (uuid_generate_v4(), :nombre, :apellido, :correo, :telefono, :dni, :genero, :direccion, :fecha_nacimiento, :encryptedPassword,:rol_id, :id_centro, :estado)";


        $stmt = $pdo->prepare($consulta);
        $stmt->execute([
            'nombre' => $nombre,
            'apellido' => $apellido,
            'correo' => $correo,
            'telefono' => $telefono,
            'dni' => $dni,
            'genero' => $genero,
            'direccion' => $direccion,
            'fecha_nacimiento' => $fecha_nacimiento,
            'encryptedPassword' => $encryptedPassword,
            'rol_id' => $rol_id,
            'id_centro' => $id_centro,
            'estado' => $estado
        ]);

        echo "<script>alert('Usuario creado exitosamente.');</script>";
        echo "<script>window.location.href = '../views/user.php?section=nuevo usuario';</script>";
    }
}
