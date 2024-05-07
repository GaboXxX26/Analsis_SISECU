<?php

include "../includes/_db.php";
session_start();
error_reporting(0);

$validar = $_SESSION['correo'];

if( $validar == null || $validar == ''){

    header("Location: ./includes/login.php");
    die();
}

?>
<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.7/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/datatables.css" rel="stylesheet">
<link href="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.0.7/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/b-print-3.0.2/datatables.css" rel="stylesheet">
<link href="https://cdn.datatables.net/v/dt/dt-2.0.7/datatables.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/v/dt/dt-2.0.7/datatables.js"></script>


    <title>Usuarios</title>
</head>
<body>
      <table class="table_responsive" id="table_id" >
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
                  echo "<td>".$row['nombre']."</td>";
                  echo "<td>".$row['apellido']."</td>";
                  echo "<td>".$row['correo']."</td>";
                  echo "<td>".$row['telefono']."</td>";
                  echo "<td>".$row['dni']."</td>";
                  echo "<td>".$row['genero']."</td>";
                  echo "<td>".$row['direccion']."</td>";
                  echo "<td>".$row['fecha_nacimiento']."</td>";
                  echo "<td>".$row['password']."</td>";
                  echo "<td>".$row['rol']."</td>";
                  echo "<td>".$row['nombre_pro']."</td>";
                  echo '<td>
                  <a  href="editar_user.php?id='.$row['id'].'">Editar
                  </a>
                  <a href="eliminar_user.php?id='.$row['id'].'">
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

      <script>
        $(document).ready(function() {
          $('.table_responsive').DataTable();
        });
      </script>

<!-- </body>
</html> -->

