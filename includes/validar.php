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

        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        $consulta = "INSERT INTO public.user (id, nombre, apellido, correo, telefono, dni, genero, direccion, fecha_nacimiento, password, rol_id, id_centro, estado) 
        VALUES (uuid_generate_v4(), :nombre, :apellido, :correo, :telefono, :dni, :genero, :direccion, :fecha_nacimiento, :password_hash,:rol_id, :id_centro, :estado)";


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
            'password_hash' => $password_hash,
            'rol_id' => $rol_id,
            'id_centro' => $id_centro,
            'estado' => $estado
        ]);

        header('Location: ../views/user.php');
    }
}
