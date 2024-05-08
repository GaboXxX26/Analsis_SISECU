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
<div class="card-header">
  <h3 class="card-title">Tabla de Usuarios registrados en el Sistema</h3>
</div>
<table id="example2" class="table table-bordered table-hover table-responsive">
  <thead>
    <tr>
      <th>Cedula</th>
      <th>Nombre</th>
      <th>Apellido</th>
      <th>Correo</th>
      <th>Centro</th>
      <th>Rol</th>
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
        echo "<td>" . $row['dni'] . "</td>";
        echo "<td>" . $row['nombre'] . "</td>";
        echo "<td>" . $row['apellido'] . "</td>";
        echo "<td>" . $row['correo'] . "</td>";
        echo "<td>" . $row['nombre_pro'] . "</td>";
        echo "<td>" . $row['rol'] . "</td>";
        echo '<td>
              <a class="btn btn-app" href="editar_user.php?id=' . $row['id'] . '" > 
              <i class="fas fa-edit"></i>Editar</a>
              <a class="btn btn-app" href="eliminar_user.php?id=' . $row['id'] . '">
              <i class="fas fa-users"></i> Desactivas </a>
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
