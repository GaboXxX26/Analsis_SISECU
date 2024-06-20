<?php
include "../includes/_db.php";
session_start();
error_reporting(0);

?>
<form action="../includes/validar.php" method="POST">
    <div id="login">
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <br>
                        <h3 class="text-center">Registro de nuevo usuario</h3>
                        <div class="form-group">
                            <label for="nombre" class="form-label">Nombre: </label>
                            <input type="text" id="nombre" name="nombre" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="apellido" class="form-label">Apellido:</label>
                            <input type="text" id="apellido" name="apellido" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Correo:</label><br>
                            <input type="email" name="correo" id="correo" class="form-control" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="telefono" class="form-label">Telefono:</label>
                            <input type="text" id="telefono" name="telefono" class="form-control" required pattern="\d{10}" title="El telefono debe contener exactamente 10 dígitos">
                        </div>
                        <div class="form-group">
                            <label for="dni" class="form-label">Cedula:</label>
                            <input type="text" id="dni" name="dni" class="form-control" required pattern="\d{10}" title="La cedula debe contener exactamente 10 dígitos">
                        </div>
                        <div class="form-group">
                            <label for="genero" class="form-label">Género:</label>
                            <select id="genero" name="genero" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" required>
                                <option value="" disabled selected>Seleccione una opción</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="direccion" class="form-label">Direccion:</label>
                            <input type="text" id="direccion" name="direccion" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento:</label>
                            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña:</label><br>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="rol_id" class="form-label">Rol:</label>
                            <select id="rol_id" name="rol_id" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" required>
                                <option value="" disabled selected>Seleccione una opción</option>
                                <option value="ad2e8033-4a14-40d6-a999-1f1c6467a5e6">Analista de datos</option>
                                <option value="add38db6-1687-4e57-a763-a959400d9da2">Administrador</option>
                                <option value="e17a74c4-9627-443c-b020-23dc4818b718">Visualizador</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="id_centro" class="form-label">Centro ECU911:</label>
                            <select id="id_centro" name="id_centro" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" required>
                                <option value="" disabled selected>Seleccione una opción</option>
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
                                <option value="141ef0a0-4102-4f44-99bd-59e52d314e8c">Ibarra</option>
                            </select>
                        </div>
                        <input type="hidden" id="estado" name="estado" value="Activo">
                        <div class="mb-3">
                            <input type="submit" value="Guardar" class="btn btn-success" name="registrar">
                            <a href="../views/user.php" class="btn btn-danger">Cancelar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>