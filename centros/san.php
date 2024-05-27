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
  <h3 class="card-title">Tabla de Indicadores SIS ECU911</h3>
</div>
<div class="btn-group btn-group-toggle" data-toggle="buttons">
  <label for=""> Selecione el centro para ver los registros</label>
  <select aria-label=".form-select-sm example" class="form-control select2" style="width: 100%;" onchange="loadContent(this.value)">
    <option value="../views/tabla_admin.php">Todos</option>
    <option value="../centros/ambato.php">Ambato</option>
    <option value="../centros/babhoyo.php">Babahoyo</option>
    <option value="../centros/cuenca.php">Cuenca</option>
    <option value="../centros/esmeraldas.php">Esmeraldas</option>
    <option value="../centros/ibarra.php">Ibarra</option>
    <option value="../centros/loja.php">Loja</option>
    <option value="../centros/macas.php">Macas</option>
    <option value="../centros/machala.php">Machala</option>
    <option value="../centros/nueva.php">Nueva Loja</option>
    <option value="../centros/porto.php">Portoviejo</option>
    <option value="../centros/quito.php">Quito</option>
    <option value="../centros/rio.php">Riobamba</option>
    <option value="../centros/sambo.php">Samborondón</option>
    <option value="../centros/san.php" selected>San Cristóbal</option>
    <option value="../centros/santo.php" >Santo Domingo</option>
    <option value="../centros/tulcan.php">Tulcán</option>
  </select>
</div>
<table id="example2" class="table table-bordered table-hover table-responsive">
  <thead>
    <tr>
    <tr>
      <th>Datos Generales</th>
      <th colspan="2">Indicadores de Gestión (20%)</th>
      <th colspan="3">
        Indicadores de Gestión Operativa (100%)
      </th>
      <th colspan="2">
        Indicadores de Gestión de Calidad (30%)
      </th>
    </tr>
    <tr>
      <th>Centro</th>
      <th>
        % de Convenios Estratégicos Reportados (10%)
      </th>
      <th>
        % de Compromisos institucionales cumplidos (10%)
      </th>
      <th>% de Operatividad de cámaras (20%)</th>
      <th>% de Ausentismo Operativo (20%)</th>
      <th>% de Cumplimiento Mobile Locator (10%)</th>
      <th>Incumplimiento de disposiciones (20%)</th>
      <th>Comunicación Estratégica (10%)</th>
    </tr>
  </thead>
  <tbody>
    <?php
    /**
     * This script retrieves data from the "registros" table and displays it in a table format.
     * It fetches the following columns from the "registros" table: nombre_centro, conve_stra, comp_insti, opera_cam, ausentimo, mobile_locator, dispoci, com_estra.
     * It also performs a left join with the "centro" table to retrieve the "nombre_centro" column from it.
     * The retrieved data is displayed row by row in an HTML table.
     * If there are no records in the "registros" table, a message indicating the absence of records is displayed.
     */

    // Consulta SQL para obtener todos los usuarios
    $consulta = "SELECT c.nombre_centro, r.conve_stra, r.comp_insti, r.opera_cam, r.ausentimo, r.mobile_locator, r.dispoci,r.com_estra FROM public.registros AS r 
    Left Join centro as c ON c.id_centro=r.id_centro
    where nombre_centro='San Cristóbal'";

    $stmt = $pdo->query($consulta);

    if ($stmt->rowCount() > 0) {
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $row['nombre_centro'] . "</td>";
        echo "<td>" . $row['conve_stra'] . "</td>";
        echo "<td>" . $row['comp_insti'] . "</td>";
        echo "<td>" . $row['opera_cam'] . "</td>";
        echo "<td>" . $row['ausentimo'] . "</td>";
        echo "<td>" . $row['mobile_locator'] . "</td>";
        echo "<td>" . $row['dispoci'] . "</td>";
        echo "<td>" . $row['com_estra'] . "</td>";
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
  function loadContent(url) {
    fetch(url)
      .then(response => response.text())
      .then(data => {
        document.getElementById('content-container').innerHTML = data;
      })
      .catch(error => console.error('Error:', error));
  }
</script>