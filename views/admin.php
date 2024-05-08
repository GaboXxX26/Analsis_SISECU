<?php

include "../includes/_db.php";
session_start();
error_reporting(0);

$validar = $_SESSION['correo'];

if ($validar == null || $validar == '') {

  header("Location: ./includes/login.php");
  die();
}

?>
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">DataTable with minimal features & hover style</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example2" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Correo</th>
                <th>Telefono</th>
                  <th>DNI</th>
                  <th>Genero</th>
                  <th>Dirección</th>
                  <th>Fecha de Nacimiento</th>
                  <th>Contraseña</th> 
                <th>Rol</th>
                <th>Centro</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
              // Consulta SQL para obtener todos los usuarios
              $consulta = "SELECT u.id, u.nombre, u.apellido, u.correo, u.telefono, u.dni, u.genero, u.direccion, u.fecha_nacimiento, u.password, p.rol, c.nombre_pro FROM public.user as u
                LEFT Join permisos as p ON u.rol_id = p.id
                LEFT JOIN centro as c ON c.id_centro=u.id_centro";

              $stmt = $pdo->query($consulta);

              // Comprobar si hay resultados
              if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  echo "<tr>";
                  echo "<td>" . $row['nombre'] . "</td>";
                  echo "<td>" . $row['apellido'] . "</td>";
                  echo "<td>" . $row['correo'] . "</td>";
                  echo "<td>" . $row['telefono'] . "</td>";
                  echo "<td>" . $row['dni'] . "</td>";
                  echo "<td>" . $row['genero'] . "</td>";
                  echo "<td>" . $row['direccion'] . "</td>";
                  echo "<td>" . $row['fecha_nacimiento'] . "</td>";
                  echo "<td>" . $row['password'] . "</td>";
                  echo "<td>" . $row['rol'] . "</td>";
                  echo "<td>" . $row['nombre_pro'] . "</td>";
                  echo '<td>
                        <a  href="editar_user.php?id=' . $row['id'] . '">Editar
                        </a>
                        <a href="eliminar_user.php?id=' . $row['id'] . '">
                        </i>Eliminar </a>
                      </td>';
                  echo "</tr>\n";
                }
              } else {
              ?>
                <tr class="text-center">
                  <td colspan="16">No existen registros</td>
                </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
        </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->
</div>