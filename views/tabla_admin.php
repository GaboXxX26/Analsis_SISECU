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

  header("Location: ./includes/login.php");
  die();
}
?>

<div class="card-header">
  <h3 class="card-title">Tabla de Indicadores SIS ECU911</h3>
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
    ORDER BY nombre_centro";

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

<!-- <form action="../includes/procesar_centro.php" method="POST">
  <table id="example2" class="table table-bordered table-hover table-responsive">
    <tr>
      <th colspan="2">Datos Generales</th>
      <th colspan="2">Indicadores de Gestión (20%)</th>
      <th colspan="3">
        Indicadores de Gestión Operativa (100%)
      </th>
      <th colspan="2">
        Indicadores de Gestión de Calidad (30%)
      </th>
    </tr>
    <tr>
      <th>Fecha</th>
      <th>registros</th>
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
    <tr>
      <td></td>
      <td>
        <input type="hidden" id="id_centro_1" name="id_centro_1" class="form-control" value="ef48298f-cedf-4718-aa67-b097c80ef23b" style="width: 100%;">
        <span>Ambato</span>
      </td>
      <td>
        <input id=" conve_stra_1" name="conve_stra_1" type="number" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      <td>
        <input type="number" id="comp_insti_1" name="comp_insti_1" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      <td>
        <input type="number" id="opera_cam_1" name="opera_cam_1" class="form-control " style="width: 100%;" min="0" max="20" step="0.1" readonly>
      </td>
      <td>
        <input type="number" id="ausentimo_1" name="ausentimo_1" class="form-control " style="width: 100%;" min="0" max=20" step="0.1" readonly>
      </td>
      <td>
        <input type="number" id=" mobile_locator_1" name="mobile_locator_1" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      <td>
        <input type="number" id="dispoci_1" name="dispoci_1" class="form-control " style="width: 100%;" min="0" max="20" step="0.1" readonly>
      </td>
      <td>
        <input type="number" id="com_estra_1" name="com_estra_1" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>
        <input type="hidden" id="id_centro_2" name="id_centro_2" class="form-control" value="e1420c15-5f78-4815-8f27-c4df1793bc21" style="width: 100%;">
        <samp>Babahoyo</samp>
      </td>

      <td>
        <input id=" conve_stra_2" name="conve_stra_2" type="number" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>

      <td>
        <input type="number" id="comp_insti_2" name="comp_insti_2" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>

      <td>
        <input type="number" id="opera_cam_2" name="opera_cam_2" class="form-control " style="width: 100%;" min="0" max="20" step="0.1" readonly>
      </td>
      
      <td>
        <input type="number" id="ausentimo_2" name="ausentimo_2" class="form-control " style="width: 100%;" min="0" max=20" step="0.1" readonly>
      </td>
      
      <td>
        <input type="number" id=" mobile_locator_2" name="mobile_locator_2" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      
      <td>
        <input type="number" id="dispoci_2" name="dispoci_2" class="form-control " style="width: 100%;" min="0" max="20" step="0.1" readonly>
      </td>
      
      <td>
        <input type="number" id="com_estra_2" name="com_estra_2" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>
        <input type="hidden" id="id_centro_3" name="id_centro_3" class="form-control" value="664f5ba3-84e3-40f9-afc3-2fc1a152f88b" style="width: 100%;">
        <samp>Cuenca</samp>

      </td>
      <td>
        <input id=" conve_stra_3" name="conve_stra_3" type="number" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      <td>
        <input type="number" id="comp_insti_3" name="comp_insti_3" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="opera_cam_3" name="opera_cam_3" class="form-control " style="width: 100%;" min="0" max="20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="ausentimo_3" name="ausentimo_3" class="form-control " style="width: 100%;" min="0" max=20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id=" mobile_locator_3" name="mobile_locator_3" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="dispoci_3" name="dispoci_3" class="form-control " style="width: 100%;" min="0" max="20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="com_estra_3" name="com_estra_3" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>
        <input type="hidden" id="id_centro_4" name="id_centro_4" class="form-control" value="e9003437-c828-465a-b0ec-b50f7395a2b2" style="width: 100%;">
        Esmeraldas
      </td>
      <td>
        <input id=" conve_stra_4" name="conve_stra_4" type="number" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      <td>
        <input type="number" id="comp_insti_4" name="comp_insti_4" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="opera_cam_4" name="opera_cam_4" class="form-control " style="width: 100%;" min="0" max="20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="ausentimo_4" name="ausentimo_4" class="form-control " style="width: 100%;" min="0" max=20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id=" mobile_locator_4" name="mobile_locator_4" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="dispoci_4" name="dispoci_4" class="form-control " style="width: 100%;" min="0" max="20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="com_estra_4" name="com_estra_4" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>
        <input type="hidden" id="id_centro_5" name="id_centro_5" class="form-control" value="141ef0a0-4102-4f44-99bd-59e52d314e8c" style="width: 100%;">
        Ibarra
      </td>
      <td>
        <input id=" conve_stra_5" name="conve_stra_5" type="number" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      <td>
        <input type="number" id="comp_insti_5" name="comp_insti_5" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="opera_cam_5" name="opera_cam_5" class="form-control " style="width: 100%;" min="0" max="20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="ausentimo_5" name="ausentimo_5" class="form-control " style="width: 100%;" min="0" max=20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id=" mobile_locator_5" name="mobile_locator_5" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="dispoci_5" name="dispoci_5" class="form-control " style="width: 100%;" min="0" max="20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="com_estra_5" name="com_estra_5" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>
        <input type="hidden" id="id_centro_6" name="id_centro_6" class="form-control " value="ed587387-5f05-4b86-8bdc-db81d95d5acf" style="width: 100%;">
        Loja
      </td>
      <td>
        <input id=" conve_stra_6" name="conve_stra_6" type="number" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      <td>
        <input type="number" id="comp_insti_6" name="comp_insti_6" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="opera_cam_6" name="opera_cam_6" class="form-control " style="width: 100%;" min="0" max="20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="ausentimo_6" name="ausentimo_6" class="form-control " style="width: 100%;" min="0" max=20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id=" mobile_locator_6" name="mobile_locator_6" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="dispoci_6" name="dispoci_6" class="form-control " style="width: 100%;" min="0" max="20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="com_estra_6" name="com_estra_6" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>
        <input type="hidden" id="id_centro_7" name="id_centro_7" class="form-control " value="833397ec-c152-40e0-8a3b-536455dd1982" style="width: 100%;">
        Machala
      </td>
      <td>
        <input id=" conve_stra_7" name="conve_stra_7" type="number" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      <td>
        <input type="number" id="comp_insti_7" name="comp_insti_7" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="opera_cam_7" name="opera_cam_7" class="form-control " style="width: 100%;" min="0" max="20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="ausentimo_7" name="ausentimo_7" class="form-control " style="width: 100%;" min="0" max=20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id=" mobile_locator_7" name="mobile_locator_7" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="dispoci_7" name="dispoci_7" class="form-control" style="width: 100%;" min="0" max="20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="com_estra_7" name="com_estra_7" class="form-control" style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>
        <input type="hidden" id="id_centro_8" name="id_centro_8" class="form-control" value="bc5d1e12-acf0-4771-8d91-8e0fe7d3cf71" style="width: 100%;">
        Macas
      </td>
      <td>
        <input id=" conve_stra_8" name="conve_stra_8" type="number" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      <td>
        <input type="number" id="comp_insti_8" name="comp_insti_8" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="opera_cam" name="opera_cam_8" class="form-control " style="width: 100%;" min="0" max="20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="ausentimo_8" name="ausentimo_8" class="form-control " style="width: 100%;" min="0" max=20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id=" mobile_locator_8" name="mobile_locator_8" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="dispoci_8" name="dispoci_8" class="form-control " style="width: 100%;" min="0" max="20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="com_estra_8" name="com_estra_8" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>
        <input type="hidden" id="id_centro_9" name="id_centro_9" class="form-control" value="2dbf73c0-17f0-44c3-bf3e-6cffe40264d1" style="width: 100%;">
        Nueva Loja
      </td>
      <td>
        <input id=" conve_stra_9" name="conve_stra_9" type="number" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      <td>
        <input type="number" id="comp_insti_9" name="comp_insti_9" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="opera_cam_9" name="opera_cam_9" class="form-control " style="width: 100%;" min="0" max="20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="ausentimo_9" name="ausentimo_9" class="form-control " style="width: 100%;" min="0" max=20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id=" mobile_locator_9" name="mobile_locator_9" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="dispoci_9" name="dispoci_9" class="form-control " style="width: 100%;" min="0" max="20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="com_estra_9" name="com_estra_9" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>
        <input type="hidden" id="id_centro_10" name="id_centro_10" class="form-control" value="42a9c5de-2fa9-47cb-9707-a6bade35fdc5" style="width: 100%;">
        Portoviejo
      </td>
      <td>
        <input id=" conve_stra_10" name="conve_stra_10" type="number" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      <td>
        <input type="number" id="comp_insti_10" name="comp_insti_10" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="opera_cam_10" name="opera_cam_10" class="form-control " style="width: 100%;" min="0" max="20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="ausentimo_10" name="ausentimo_10" class="form-control " style="width: 100%;" min="0" max=20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id=" mobile_locator_10" name="mobile_locator_10" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="dispoci_10" name="dispoci_10" class="form-control " style="width: 100%;" min="0" max="20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="com_estra_10" name="com_estra_10" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>
        <input type="hidden" id="id_centro_11" name="id_centro_11" class="form-control" value="e3eb2897-7999-4418-bd04-d0a33e3a84f6" style="width: 100%;">
        Quito
      <td>
        <input id=" conve_stra_11" name="conve_stra_11" type="number" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      <td>
        <input type="number" id="comp_insti_11" name="comp_insti_11" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="opera_cam_11" name="opera_cam_11" class="form-control " style="width: 100%;" min="0" max="20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="ausentimo_11" name="ausentimo_11" class="form-control " style="width: 100%;" min="0" max=20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id=" mobile_locator_11" name="mobile_locator_11" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="dispoci_11" name="dispoci_11" class="form-control " style="width: 100%;" min="0" max="20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="com_estra_11" name="com_estra_11" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>
        <input type="hidden" id="id_centro_12" name="id_centro_12" class="form-control" value="caba5421-1581-49db-a4c2-2a8c3b39d238" style="width: 100%;">
        Riobamba
      </td>
      <td>
        <input id=" conve_stra_12" name="conve_stra_12" type="number" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      <td>
        <input type="number" id="comp_insti_12" name="comp_insti_12" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="opera_cam_12" name="opera_cam_12" class="form-control " style="width: 100%;" min="0" max="20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="ausentimo_12" name="ausentimo_12" class="form-control " style="width: 100%;" min="0" max=20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id=" mobile_locator_12" name="mobile_locator_12" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="dispoci_12" name="dispoci_12" class="form-control " style="width: 100%;" min="0" max="20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="com_estra_12" name="com_estra_12" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>
        <input type="hidden" id="id_centro_13" name="id_centro_13" class="form-control" value="054c93ab-fc9c-435f-bf6b-0dabcf4cce5e" style="width: 100%;">
        Samborondón
      </td>
      <td>
        <input id=" conve_stra_13" name="conve_stra_13" type="number" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      <td>
        <input type="number" id="comp_insti_13" name="comp_insti_13" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="opera_cam_13" name="opera_cam_13" class="form-control " style="width: 100%;" min="0" max="20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="ausentimo_13" name="ausentimo_13" class="form-control " style="width: 100%;" min="0" max=20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id=" mobile_locator_13" name="mobile_locator_13" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="dispoci_13" name="dispoci_13" class="form-control " style="width: 100%;" min="0" max="20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="com_estra_13" name="com_estra_13" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>
        <input type="hidden" id="id_centro_14" name="id_centro_14" class="form-control" value="525c8421-6961-47fd-a630-1819594c9ecc" style="width: 100%;">
        San Cristóbal
      </td>
      <td>
        <input id=" conve_stra_14" name="conve_stra_14" type="number" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      <td>
        <input type="number" id="comp_insti_14" name="comp_insti_14" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="opera_cam_14" name="opera_cam_14" class="form-control " style="width: 100%;" min="0" max="20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="ausentimo_14" name="ausentimo_14" class="form-control " style="width: 100%;" min="0" max=20" step="0.1" readonly>
      </td>
      <td>
        <input type="number" id=" mobile_locator_14" name="mobile_locator_14" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="dispoci_14" name="dispoci_14" class="form-control " style="width: 100%;" min="0" max="20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="com_estra_14" name="com_estra_14" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>
        <input type="hidden" id="id_centro_15" name="id_centro_15" class="form-control" value="1fb38bb6-59bc-4272-8e08-0dcbf43516dc" style="width: 100%;">
        Santo Domingo
      <td>
        <input id=" conve_stra_15" name="conve_stra_15" type="number" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      <td>
        <input type="number" id="comp_insti_15" name="comp_insti_15" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="opera_cam_15" name="opera_cam_15" class="form-control " style="width: 100%;" min="0" max="20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="ausentimo_15" name="ausentimo_15" class="form-control " style="width: 100%;" min="0" max=20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id=" mobile_locator_15" name="mobile_locator_15" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="dispoci_15" name="dispoci_15" class="form-control " style="width: 100%;" min="0" max="20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="com_estra_15" name="com_estra_15" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>
        <input type="hidden" id="id_centro_16" name="id_centro_16" class="form-control" value="c9ffaf46-4ba8-4515-aac7-58bdc923f197" style="width: 100%;">
        Tulcán
      </td>
      <td>
        <input id=" conve_stra_16" name="conve_stra_16" type="number" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      <td>
        <input type="number" id="comp_insti_16" name="comp_insti_16" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="opera_cam_16" name="opera_cam_16" class="form-control " style="width: 100%;" min="0" max="20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="ausentimo_16" name="ausentimo_16" class="form-control " style="width: 100%;" min="0" max=20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id=" mobile_locator_16" name="mobile_locator_16" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="dispoci_16" name="dispoci_16" class="form-control " style="width: 100%;" min="0" max="20" step="0.1" readonly>
      </td>
      </td>
      <td>
        <input type="number" id="com_estra_16" name="com_estra_16" class="form-control " style="width: 100%;" min="0" max="10" step="0.1" readonly>
      </td>
      </td>
    </tr>
    <tr>
      <td colspan="9"><input type="submit" class="btn btn-block bg-gradient-success btn-sm" value="Subir" name="registrar_centro"></td>
    </tr>
  </table>
</form> -->