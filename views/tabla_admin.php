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

// Obtener el mes y año seleccionados
$selectedMonth = isset($_GET['month']) ? $_GET['month'] : date('m');
$selectedYear = isset($_GET['year']) ? $_GET['year'] : date('Y');

// Consulta SQL para obtener todos los usuarios filtrados por mes y año
$consulta = "SELECT c.nombre_centro, r.conve_stra, r.comp_insti, r.opera_cam, r.ausentimo, r.mobile_locator, r.dispoci, r.com_estra 
             FROM public.registros AS r 
             LEFT JOIN centro AS c ON c.id_centro = r.id_centro
             WHERE EXTRACT(MONTH FROM r.created_at) = :selectedMonth
             AND EXTRACT(YEAR FROM r.created_at) = :selectedYear
             ORDER BY c.nombre_centro";

$stmt = $pdo->prepare($consulta);
$stmt->execute(['selectedMonth' => $selectedMonth, 'selectedYear' => $selectedYear]);
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
    <option value="../centros/san.php">San Cristóbal</option>
    <option value="../centros/santo.php">Santo Domingo</option>
    <option value="../centros/tulcan.php">Tulcán</option>
  </select>
</div>
<br>
  <div class="container mt-5">
    <h2 class="mb-4">Filtrar Registros por Mes y Año</h2>
    <form id="filterForm" class="mb-4" action="" method="GET"> <div class="form-group">
            <label for="monthSelect">Seleccione un mes:</label>
            <select id="monthSelect" name="month" class="form-control">
                <?php 
                // Generación dinámica de opciones para los meses
                for ($i = 1; $i <= 12; $i++) {
                    $month = str_pad($i, 2, '0', STR_PAD_LEFT);
                    $selected = ($selectedMonth == $month) ? 'selected' : '';
                    echo "<option value='$month' $selected>" . date('F', mktime(0, 0, 0, $i, 1)) . "</option>"; 
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="yearSelect">Seleccione un año:</label>
            <select id="yearSelect" name="year" class="form-control">
                <?php
                // Generación dinámica de opciones para los años (desde el año actual hasta 2000)
                for ($year = date('Y'); $year >= 2000; $year--) {
                    $selected = ($selectedYear == $year) ? 'selected' : '';
                    echo "<option value='$year' $selected>$year</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Filtrar</button>
    </form>
</div>


  <table id="example2" class="table table-bordered table-hover table-responsive">
    <thead>
      <tr>
        <th>Datos Generales</th>
        <th colspan="2">Indicadores de Gestión (20%)</th>
        <th colspan="3">Indicadores de Gestión Operativa (100%)</th>
        <th colspan="2">Indicadores de Gestión de Calidad (30%)</th>
      </tr>
      <tr>
        <th>Centro</th>
        <th>% de Convenios Estratégicos Reportados (10%)</th>
        <th>% de Compromisos institucionales cumplidos (10%)</th>
        <th>% de Operatividad de cámaras (20%)</th>
        <th>% de Ausentismo Operativo (20%)</th>
        <th>% de Cumplimiento Mobile Locator (10%)</th>
        <th>Incumplimiento de disposiciones (20%)</th>
        <th>Comunicación Estratégica (10%)</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch()) {
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
        echo "<tr class='text-center'><td colspan='8'>No existen registros</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>