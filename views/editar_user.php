<?php
require_once '../includes/_db.php';
session_start();
if (!isset($_SESSION['correo'])) {
    header("Location: ../includes/login.php");
    die();
}

$id = $_GET['id'];

$consulta = "SELECT * FROM public.user WHERE id = :id";
$stmt = $pdo->prepare($consulta);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros</title>
    <link rel="stylesheet" href="../css/fontawesome-all.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/es.css">
</head>

<body id="page-top">
    <form  action="../includes/_functions.php" method="POST">
        <div id="login" >
            <div class="container">
                <div id="login-row" class="row justify-content-center align-items-center">
                    <div id="login-column" class="col-md-6">
                        <div id="login-box" class="col-md-12">
                            <br>
                            <br>
                            <h3 class="text-center">Editar usuario</h3>
                            <div class="form-group">
                                    <label for="nombre" class="form-label">Nombre:</label>
                                    <input type="text"  id="nombre" name="nombre" class="form-control" value="<?php echo $usuario['nombre'];?>"required>
                                </div>

                                <div class="form-group">
                                    <label for="apellido" class="form-label">Apellido:</label>
                                    <input type="text"  id="apellido" name="apellido" class="form-control" value="<?php echo $usuario['apellido'];?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="username">Correo:</label><br>
                                    <input type="email" name="correo" id="correo" class="form-control" placeholder="" value="<?php echo $usuario['correo'];?>">
                                </div>

                                <div class="form-group">
                                    <label for="telefono" class="form-label">Telefono:</label>
                                    <input type="tel"  id="telefono" name="telefono" class="form-control" value="<?php echo $usuario['telefono'];?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="dni" class="form-label">Cedula:</label>
                                    <input type="text"  id="dni" name="dni" class="form-control" value="<?php echo $usuario['dni'];?>" >
                                </div>
                                <div class="form-group">
                                    <label for="genero" class="form-label">Genero:</label>
                                        <select id="genero" name="genero" <?php echo $usuario['genero'];?>>
                                            <option value="Masculino">Masculino</option>
                                            <option value="Femenino">Femenino</option>
                                            <option value="Otro">Otro</option>
                                        </select>
                                </div>
                                <div class="form-group">
                                    <label for="direccion" class="form-label">Dirrecion:</label>
                                    <input type="text"  id="direccion" name="direccion" class="form-control" value="<?php echo $usuario['direccion'];?>" >
                                </div>
                                <div class="form-group">
                                    <label for="fecha_nacimiento" class="form-label">Dirrecion:</label>
                                    <input type="date"  id="fecha_nacimiento" name="fecha_nacimiento" class="form-control" value="<?php echo $usuario['fecha_nacimiento'];?>" >
                                </div>
                                <div class="form-group">
                                    <label for="password">Contraseña:</label><br>
                                    <input type="password" name="password" id="password" class="form-control" value="<?php echo $usuario['password'];?>" required>   
                                </div>
                                <div class="form-group">
                                    <label for="rol_id" class="form-label">Rol:</label>
                                    <select id="rol_id" name="rol_id" required>
                                        <option value="ad2e8033-4a14-40d6-a999-1f1c6467a5e6">Analista de datos</option>
                                        <option value="add38db6-1687-4e57-a763-a959400d9da2">Administrador</option>
                                        <option value="e17a74c4-9627-443c-b020-23dc4818b718">Usuario</option>
                                    </select>

                                </div>
                                <div class="form-group">
                                <label for="id_centro" class="form-label">Centro ECU911:</label>
                                    <select id="id_centro" name="id_centro" required>
                                        <option value="ef48298f-cedf-4718-aa67-b097c80ef23b">Ambato</option>
                                        <option value="664f5ba3-84e3-40f9-afc3-2fc1a152f88b">Cuenca</option>
                                        <option value="ed587387-5f05-4b86-8bdc-db81d95d5acf">Loja</option>
                                        <option value="e9003437-c828-465a-b0ec-b50f7395a2b2">Esmeraldas</option>
                                        <option value="e3eb2897-7999-4418-bd04-d0a33e3a84f6">Quito</option>
                                        <option value="e1420c15-5f78-4815-8f27-c4df1793bc21">Babahoyo</option>
                                        <option value="caba5421-1581-49db-a4c2-2a8c3b39d238">Riobamba</option>
                                        <option value="c9ffaf46-4ba8-4515-aac7-58bdc923f197">Tulcán</option>
                                        <option value="833397ec-c152-40e0-8a3b-536455dd1982">Machala</option>
                                        <option value="525c8421-6961-47fd-a630-1819594c9ecc">San Cristóbal</option>
                                        <option value="42a9c5de-2fa9-47cb-9707-a6bade35fdc5">Portoviejo</option>
                                        <option value="2dbf73c0-17f0-44c3-bf3e-6cffe40264d1">Nueva Loja</option>
                                        <option value="1fb38bb6-59bc-4272-8e08-0dcbf43516dc">Santo Domingo</option>
                                        <option value="054c93ab-fc9c-435f-bf6b-0dabcf4cce5e">Samborondón</option>
                                    </select>
                                    <input type="hidden" name="accion" value="editar_registro">
                                    <input type="hidden" name="id" value="<?php echo $id;?>">
                            </div>

                           <br>
                                <div class="mb-3">        
                                    <button type="submit" class="btn btn-success" >Editar</button>
                                    <a href="user.php" class="btn btn-danger">Cancelar</a>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>
</html>