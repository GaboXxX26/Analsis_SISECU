<!-- /**
 * FILEPATH: /c:/xampp/htdocs/Analsis_SISECU/views/tabla_admin.php
 *
 * This file displays a table of indicators for SIS ECU911.
 * It includes a check for session validation and redirects to the login page if the session is not valid.
 * The table displays various indicators related to general data, management, operational performance, and quality management.
 * The data is fetched from the database and displayed in the table rows.
 * If there are no records in the database, a message indicating the absence of records is displayed.
 *
 * @package Analsis_SISECU
 * @subpackage views
 */ -->
<?php
include "../includes/_db.php";
session_start();
error_reporting(0);

$validar = $_SESSION['correo'];

if ($validar == null || $validar == '') {

  header("Location: ../includes/login.php");
  die();
}
?>

<div class="card-header">
  <h3 class="card-title">Tabla de Indicadores SIS ECU911</h3>
</div>
<div class="btn-group btn-group-toggle" data-toggle="buttons">
  <label class="btn  btn-outline-danger btn-sm">
    <input type="radio" name="options" id="option1" onclick="loadContent('../views/tabla_admin.php')"> Todos
  </label>
  <label class="btn  btn-outline-danger btn-sm">
    <input type="radio" name="options" id="option1" onclick="loadContent('../centros/ambato.php')"> Ambato
  </label>
  <label class="btn  btn-outline-danger btn-sm">
    <input type="radio" name="options" id="option2" onclick="loadContent('../centros/babhoyo.php')"> Babahoyo
  </label>
  <label class="btn  btn-outline-danger btn-sm">
    <input type="radio" name="options" id="option3" onclick="loadContent('../centros/cuenca.php')"> Cuenca
  </label>
  <label class="btn  btn-outline-danger btn-sm">
    <input type="radio" name="options" id="option3" onclick="loadContent('../centros/Esmeraldas.php')"> Esmeraldas
  </label>
  <label class="btn  btn-outline-danger btn-sm">
    <input type="radio" name="options" id="option3" onclick="loadContent('../centros/ibarra.php')"> Ibarra
  </label>
  <label class="btn  btn-outline-danger btn-sm">
    <input type="radio" name="options" id="option3" onclick="loadContent('../centros/loja.php')"> Loja
  </label>
  <label class="btn  btn-outline-danger btn-sm">
    <input type="radio" name="options" id="option3" onclick="loadContent('../centros/macas.php')"> Macas
  </label>
  <label class="btn  btn-outline-danger btn-sm">
    <input type="radio" name="options" id="option3" onclick="loadContent('../centros/machala.php')"> Machala
  </label>
</div>
<br>
<div class="btn-group btn-group-toggle" data-toggle="buttons">
  <br>
  <label class="btn  btn-outline-danger btn-sm">
    <input type="radio" name="options" id="option3" onclick="loadContent('../centros/nuva.php')"> Nueva Loja
  </label>
  <label class="btn  btn-outline-danger btn-sm">
    <input type="radio" name="options" id="option3" onclick="loadContent('../centros/porto.php')"> Portoviejo
  </label>
  <label class="btn  btn-outline-danger btn-sm">
    <input type="radio" name="options" id="option3" onclick="loadContent('../centros/quito.php')"> Quito
  </label>
  <label class="btn  btn-outline-danger btn-sm">
    <input type="radio" name="options" id="option3" onclick="loadContent('../centros/rio.php')"> Riobamba
  </label>
  <label class="btn  btn-outline-danger btn-sm">
    <input type="radio" name="options" id="option3" onclick="loadContent('../centros/sambo.php')"> Samborondón
  </label>
  <label class="btn  btn-outline-danger btn-sm">
    <input type="radio" name="options" id="option3" onclick="loadContent('../centros/san.php')"> San Cristóbal
  </label>
  <label class="btn  btn-outline-danger btn-sm">
    <input type="radio" name="options" id="option3" onclick="loadContent('../centros/santo.php')"> Santo Domingo
  </label>
  <label class="btn  btn-outline-danger btn-sm">
    <input type="radio" name="options" id="option3" onclick="loadContent('../centros/tulcan.php')"> Tulcán
  </label>
</div>
<br>
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
    order by nombre_centro";

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