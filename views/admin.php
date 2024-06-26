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
<div class="card-body">
  <h1> Tabla de usuarios registrados en el sistema</h1>
  <table id="example1" class="table table-bordered table-striped  table-responsive">
    <thead>
      <tr>
        <th>Estado</th>
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
      $consulta = "SELECT u.estado, u.id, u.nombre, u.apellido, u.correo, p.rol, c.nombre_centro FROM public.user as u
        LEFT Join permisos as p ON u.rol_id = p.id
        LEFT JOIN centro as c ON c.id_centro=u.id_centro 
        WHERE u.estado = 'Activo'";

      $stmt = $pdo->query($consulta);

      // Comprobar si hay resultados
      if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          echo "<tr>";
          echo "<td>" . $row['estado'] . "</td>";
          echo "<td>" . $row['nombre'] . "</td>";
          echo "<td>" . $row['apellido'] . "</td>";
          echo "<td>" . $row['correo'] . "</td>";
          echo "<td>" . $row['nombre_centro'] . "</td>";
          echo "<td>" . $row['rol'] . "</td>";
          echo '<td>        
          <a class="btn btn-app" href="javascript:void(0);" onclick="loadContent(\'editar_user.php?id=' . $row['id'] . '\')"> 
          <i class="fas fa-edit"></i>Editar</a>
          <a class="btn btn-app" href="javascript:void(0);" onclick="loadContent(\'eliminar_user.php?id=' . $row['id'] . '\')">
          <i class="fas fa-trash"></i> Desactivar </a>
        </td>';
          echo "</tr>\n";
        }
      } else {

      ?>
        <tr class=" text-center">
    <td colspan="16">No existen registros</td>
    </tr>
  <?php
      }
  ?>
  </tbody>
  </table>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  function loadContent(url) {
    fetch(url)
      .then(response => response.text())
      .then(data => {
        document.getElementById('content-container').innerHTML = data;
      })
      .catch(error => console.error('Error:', error));
  }

  window.addEventListener('load', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const section = urlParams.get('section');

    if (section === 'parametro') {
      loadContent('parametro.php');
    } else if (section === 'nuevo usuario') {
      loadContent('index.php');
    } else if (section === 'editar') {
      loadContent('admin.php');
    } else if (section === 'elimniar') {
      loadContent('admin.php');
    }

  });
</script>