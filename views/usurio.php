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

<!-- <!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/fontawesome-all.min.css">
    <link rel="stylesheet" href="../css/estilo.css">
    <link rel="stylesheet" href="../css/es.css">
    <link rel="stylesheet" href="../css/index.css">
    <title>Usuarios</title>
</head>

<div class="container is-fluid">

  <div class="col-xs-12"> -->
      <table class="table table-striped table-dark  table_responsive" id= "table_id" >
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
          </tr>
        </thead>
        <tbody>
          <?php
          // Consulta SQL para obtener todos los usuarios
          $consulta = "SELECT u.id, u.nombre, u.apellido, u.correo, u.telefono, u.dni, u.genero, u.direccion, u.fecha_nacimiento, u.password, p.rol FROM public.user as u
          LEFT Join permisos as p ON u.rol_id = p.id";
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