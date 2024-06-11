<?php
include "../includes/_db.php";
session_start();
error_reporting(0);
$validar = $_SESSION['correo'];

if ($validar == null || $validar == '') {

  header("Location: ../includes/login.php");
  die();
}
// Verificar si el usuario está activo
$query = "	SELECT  estado FROM public.user WHERE correo = :correo";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':correo', $validar);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario || $usuario['estado'] != 'Activo') {
  // El usuario no existe o no está activo
  // Redirigir a una página de error o mostrar un mensaje
  header("Location: ../views/acceso_denegado.php");
  die();
}
$query = "SELECT rol_id FROM public.user WHERE correo = :correo";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':correo', $validar);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

$_SESSION['rol_id'] = $usuario['rol_id'];

// Definir permisos por rol
$permisos = [
  'add38db6-1687-4e57-a763-a959400d9da2' => ['user.php', 'eliminar_user.php', 'editar_user.php', 'tabla_admin.php', 'historico.php', 'comparativo.php'],
  'e17a74c4-9627-443c-b020-23dc4818b718' => ['lector.php', 'tabla_admin.php'],
  'ad2e8033-4a14-40d6-a999-1f1c6467a5e6' => ['analista.php']
];

// Obtener el mes, año, trimestre, rango de fechas y centro seleccionados
$selectedMonth = isset($_GET['month']) ? $_GET['month'] : '';
$selectedYear = isset($_GET['year']) ? $_GET['year'] : date('Y');
$selectedTrimestre = isset($_GET['trimestre']) ? $_GET['trimestre'] : '';
$selectedCentro = isset($_GET['centro']) ? $_GET['centro'] : 'ef48298f-cedf-4718-aa67-b097c80ef23b';
$selectedRango = isset($_GET['filterType']) && $_GET['filterType'] == 'rango';
$fechaInicio = $selectedRango && isset($_GET['fechaInicio']) ? $_GET['fechaInicio'] : '';
$fechaFin = $selectedRango && isset($_GET['fechaFin']) ? $_GET['fechaFin'] : '';

// Construir la consulta SQL con condiciones opcionales
$consulta = "SELECT r.id_registro,c.nombre_centro, r.conve_stra, r.comp_insti, r.opera_cam, r.ausentimo, r.mobile_locator, r.dispoci, r.com_estra, TO_CHAR(r.created_at, 'TMMonth') AS mes_creado
                FROM public.registros AS r 
                LEFT JOIN centro AS c ON c.id_centro = r.id_centro
                WHERE r.id_centro = :selectedCentro";
$params = [
  'selectedCentro' => $selectedCentro
];

// Agregar filtros según el tipo seleccionado
if (!empty($_GET['filterType'])) {
  if ($_GET['filterType'] == 'mensual' && $selectedMonth != '') {
    $consulta .= " AND EXTRACT(MONTH FROM r.created_at) = :selectedMonth AND EXTRACT(YEAR FROM r.created_at) = :selectedYear";
    $params['selectedMonth'] = $selectedMonth;
    $params['selectedYear'] = $selectedYear;
  } elseif ($_GET['filterType'] == 'trimestral' && $selectedTrimestre != '') {
    $consulta .= " AND EXTRACT(QUARTER FROM r.created_at) = :selectedTrimestre AND EXTRACT(YEAR FROM r.created_at) = :selectedYear";
    $params['selectedTrimestre'] = $selectedTrimestre;
    $params['selectedYear'] = $selectedYear;
  } elseif ($_GET['filterType'] == 'rango' && !empty($fechaInicio) && !empty($fechaFin)) {
    // Convertir las fechas a timestamp with time zone
    $fechaInicio .= ' 00:00:00'; // Agregar hora, minuto y segundo de inicio del día
    $fechaFin .= ' 23:59:59';   // Agregar hora, minuto y segundo de fin del día
    $consulta .= " AND r.created_at BETWEEN :fechaInicio AND :fechaFin";
    $params['fechaInicio'] = $fechaInicio;
    $params['fechaFin'] = $fechaFin;
  }
} else {
  $consulta .= " AND EXTRACT(YEAR FROM r.created_at) = EXTRACT(YEAR FROM CURRENT_TIMESTAMP)"; // Usar CURRENT_TIMESTAMP
}

$consulta .= " ORDER BY r.created_at";

$stmt = $pdo->prepare($consulta);
$stmt->execute($params);

$query_rol = "SELECT rol FROM permisos WHERE id = :id";
$stmt_rol = $pdo->prepare($query_rol);
$stmt_rol->bindParam(':id', $_SESSION['rol_id']);
$stmt_rol->execute();
$rol = $stmt_rol->fetch(PDO::FETCH_ASSOC)['rol'];

$query_nombre_apellido = "SELECT nombre, apellido FROM public.user WHERE correo = :correo";
$stmt_nombre_apellido = $pdo->prepare($query_nombre_apellido);
$stmt_nombre_apellido->bindParam(':correo', $validar);
$stmt_nombre_apellido->execute();
$datos_usuario = $stmt_nombre_apellido->fetch(PDO::FETCH_ASSOC);

$nombre_usuario = $datos_usuario['nombre'];
$apellido_usuario = $datos_usuario['apellido'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Administrador</title>
  <link rel="icon" type="image/x-icon" href="../Resources/images/ECU911.png" />
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="../plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="../dist/img/ECU911.png" alt="ECU911" height="60" width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">Inicio</a>
        </li>

      </ul>
      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->

        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
      </ul>
      <div class="card-title">
        <a class="btn btn-block bg-gradient-danger" href="../includes/_sessions/cerrarSesion.php">Cerrar sesión</a>
      </div>
    </nav>
    <!-- /.navbar -->
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="user.php" class="brand-link">
        <img src="../dist/img/ECU911.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">SIS ECU 911</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <br>
        <div>
          <div class="info">
            <label class="d-block" style="color: #a6abb4; text-align: center; font-weight: normal;"><?php echo $nombre_usuario . " " . $apellido_usuario; ?></label>
            <label class="d-block" style="color:#a6abb4; text-align:center; "> <?php echo $rol; ?></label>
          </div>
        </div>
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
            <?php
            // Obtener el ID de rol del usuario de la sesión
            $rol_id = $_SESSION['rol_id'];

            // Definir las opciones de navegación según el rol
            switch ($rol_id) {
              case 'add38db6-1687-4e57-a763-a959400d9da2': // Administrador
            ?>
                <li class="nav-item">
                  <a href="./user.php" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                      Inicio
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-chart-pie"></i>
                    <p>
                      Usuario
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="#" class="nav-link" onclick="loadContent('admin.php')">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Usuarios</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="#" class="nav-link" onclick="loadContent('index.php')">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Nuevo usuario</p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item">
                  <a href="tabla_admin.php" class="nav-link">
                    <i class="nav-icon fas fa-table"></i>
                    <p>Registros</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="./obervaciones.php" class="nav-link">
                    <i class="nav-icon fas fa-book"></i>
                    <p>Observaciones</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link " onclick="loadContent('archivo.php')">
                    <i class="nav-icon far fa-plus-square"></i>
                    <p>Cargar Excel</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link " onclick="loadContent('parametro.php')">
                    <i class="nav-icon fas fa-table"></i>
                    <p>Parametrizacion</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-chart-pie"></i>
                    <p>
                      Estadisticas
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="./historico.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Historico</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="./comparativo.php" class="nav-link" id="historico-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Comparativo</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="./resultado.php" class="nav-link ">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Resultado</p>
                      </a>
                    </li>
                  </ul>
                </li>
              <?php
                break;
              case 'e17a74c4-9627-443c-b020-23dc4818b718': // Visualizador
              ?>
                <li class="nav-item">
                  <a href="./user.php" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                      Inicio
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="./obervaciones.php" class="nav-link">
                    <i class="nav-icon fas fa-book"></i>
                    <p>Observaciones</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-chart-pie"></i>
                    <p>
                      Estadisticas
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="./historico.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Historico</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="./comparativo.php" class="nav-link" id="historico-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Comparativo</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="./resultado.php" class="nav-link ">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Resultado</p>
                      </a>
                    </li>
                  </ul>
                </li>
              <?php
                break;
              case 'ad2e8033-4a14-40d6-a999-1f1c6467a5e6': // Analista de datos
              ?>

                <li class="nav-item">
                  <a href="./user.php" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                      Inicio
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="tabla_admin.php" class="nav-link">
                    <i class="nav-icon fas fa-table"></i>
                    <p>Registros</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="./obervaciones.php" class="nav-link">
                    <i class="nav-icon fas fa-book"></i>
                    <p>Observaciones</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link " onclick="loadContent('archivo.php')">
                    <i class="nav-icon far fa-plus-square"></i>
                    <p>Cargar Excel</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link " onclick="loadContent('parametro.php')">
                    <i class="nav-icon fas fa-table"></i>
                    <p>Parametrizacion</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-chart-pie"></i>
                    <p>
                      Estadisticas
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="./historico.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Historico</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="./comparativo.php" class="nav-link" id="historico-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Comparativo</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="./resultado.php" class="nav-link ">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Resultado</p>
                      </a>
                    </li>
                  </ul>
                </li>
              <?php
                break;
              default:
                // No se encontró un rol válido
              ?>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-exclamation-circle"></i>
                    <p>
                      Rol no válido
                    </p>
                  </a>
                </li>
            <?php
            }
            ?>

          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <br>
    <div class="content-wrapper">
      <!-- /.content-header -->
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="container mt-5" id="filter-container">
                    <form id="filterForm" class="mb-4" method="GET">
                      <h2 class="mb-4">Filtro de registros por centro</h2>
                      <div class="form-group">
                        <label for="centroSelect">Seleccione un centro:</label>
                        <select id="centroSelect" name="centro" class="form-control" required>
                          <option value="">Seleccione un centro</option>
                          <?php
                          $queryCentros = "SELECT id_centro, nombre_centro FROM centro";
                          $stmtCentros = $pdo->query($queryCentros);

                          while ($rowCentro = $stmtCentros->fetch(PDO::FETCH_ASSOC)) {
                            $selected = ($selectedCentro == $rowCentro['id_centro']) ? 'selected' : '';
                            echo "<option value='{$rowCentro['id_centro']}' $selected>{$rowCentro['nombre_centro']}</option>";
                          }
                          ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="filterTypeSelect">Seleccione tipo de filtro:</label>
                        <select id="filterTypeSelect" name="filterType" class="form-control">
                          <option value="">Seleccione un filtro</option>
                          <option value="mensual" <?php if (empty($_GET['filterType']) || $_GET['filterType'] == 'mensual') ?>>Mensual</option>
                          <option value="trimestral" <?php if (!empty($_GET['filterType']) && $_GET['filterType'] == 'trimestral') ?>>Trimestral</option>
                          <option value="rango" <?php if (!empty($_GET['filterType']) && $_GET['filterType'] == 'rango') ?>>Rango de fechas</option>
                        </select>
                      </div>
                      <div id="filtrosAdicionales" class="form-group">
                      </div>
                      <button type="submit" class="btn btn-primary">Filtrar</button>
                    </form>
                    <form action="../includes/_functions.php" method="POST">
                      <table id="example1" class="table table-bordered table-striped table-responsive">
                        <thead>
                          <tr>
                            <th colspan="2">Datos Generales</th>
                            <th colspan="2">Indicadores de Gestión Interinstitucional (20%)</th>
                            <th colspan="3">Indicadores de Gestión Operativa (50%)</th>
                            <th colspan="2">Indicadores de Gestión de Calidad (30%)</th>
                          </tr>
                          <tr>
                            <th>Mes</th>
                            <th>Centro</th>
                            <th>% de Convenios Estratégicos Reportados (10%)</th>
                            <th>% de Compromisos institucionales cumplidos (10%)</th>
                            <th>% de Operatividad de cámaras (20%)</th>
                            <th>% de Ausentismo Operativo (20%)</th>
                            <th>% de Cumplimiento Mobile Locator (10%)</th>
                            <th>% Incumplimiento de disposiciones (20%)</th>
                            <th>% Comunicación Estratégica (10%)</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          if ($stmt->rowCount() > 0) {
                            while ($row = $stmt->fetch()) {
                              echo "<tr>";
                              echo "<td>" . $row['mes_creado'] . "</td>";
                              echo "<td>" . $row['nombre_centro'] . "</td>";
                              // Campos con nombres de array y valores precargados
                              echo "<input type='hidden' name='id_registro[]' value='" . $row['id_registro'] . "'>";
                              echo "<td><input type='number' style='background-color:transparent; border:none' name='conve_stra[]' value='" . $row['conve_stra'] . "' min='0' max='10' step='0.01' ></td>";
                              echo "<td><input type='number' style='background-color:transparent; border:none' name='comp_insti[]' value='" . $row['comp_insti'] . "' min='0' max='100' step='0.01'></td>";
                              echo "<td><input type='number' style='background-color:transparent; border:none' name='opera_cam[]' value='" . $row['opera_cam'] . "' min='0' max='100' step='0.01'></td>";
                              echo "<td><input type='number' style='background-color:transparent; border:none' name='ausentimo[]' value='" . $row['ausentimo'] . "' min='0' max='100' step='0.01'></td>";
                              echo "<td><input type='number' style='background-color:transparent; border:none'name='mobile_locator[]' value='" . $row['mobile_locator'] . "' min='0' max='100' step='0.01'></td>";
                              echo "<td><input type='number' style='background-color:transparent; border:none' name='dispoci[]' value='" . $row['dispoci'] . "' min='0' max='100' step='0.01'></td>";
                              echo "<td><input type='number' style='background-color:transparent; border:none' name='com_estra[]' value='" . $row['com_estra'] . "' min='0' max='100'step='0.01'></td>";

                              echo "</tr>\n";
                            }
                          } else {
                            echo "<tr class='text-center'><td colspan='9'>No existen registros</td></tr>";
                          }
                          ?>
                        </tbody>
                      </table>
                      <input type="hidden" name="accion" value="actualizar_registro">
                      <button type="submit" class="btn btn-primary">Editar</button>
                    </form>
                  </div>
                  <div id="content-container"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <strong>Copyright &copy; 2024 <a href="https://www.ecu911.gob.ec/" target="_blank">Sistema Integrado de Seguridad ECU 911</a>.</strong>
      Todos los derechos reservados.
    </footer>
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
  </div>
  <!-- ./wrapper -->
  <!-- jQuery -->
  <script src="../plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="../plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="../plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="../plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <script src="../plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="../plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="../plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="../plugins/moment/moment.min.js"></script>
  <script src="../plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="../plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../dist/js/adminlte.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="../dist/js/demo.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="../dist/js/pages/dashboard.js"></script>
  <!-- DataTables  & Plugins -->
  <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="../plugins/jszip/jszip.min.js"></script>
  <script src="../plugins/pdfmake/pdfmake.min.js"></script>
  <script src="../plugins/pdfmake/vfs_fonts.js"></script>
  <script src="../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="../plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  <!-- Page specific script -->
  <script>
    function checkContent() {
      var contentContainer = document.getElementById('content-container');
      var filterContainer = document.getElementById('filter-container');
      var chartContainer = document.getElementById('chart-container');

      if (contentContainer.innerHTML.trim() !== '') {
        filterContainer.style.display = 'none';
        chartContainer.style.display = 'none';
      } else {
        filterContainer.style.display = 'block';
        chartContainer.style.display = 'block';
      }
    }

    // Call checkContent when the page loads
    window.onload = checkContent;

    // Call checkContent whenever the content of the content-container changes
    var contentContainerObserver = new MutationObserver(checkContent);
    contentContainerObserver.observe(document.getElementById('content-container'), {
      childList: true,
      subtree: true
    });

    // Show filter and chart when "Historico" is clicked
    document.getElementById('historico-link').addEventListener('click', function() {
      document.getElementById('filter-container').style.display = 'block';
      document.getElementById('chart-container').style.display = 'block';
    });
  </script>
  <script>
    $(function() {
      $("#example1").DataTable({
        "responsive": false,
        "lengthChange": true,
        "autoWidth": true,
        "scrollX": true,

      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
  </script>
  <script>
    document.getElementById('filterTypeSelect').addEventListener('change', function() {
      var filtrosAdicionales = document.getElementById('filtrosAdicionales');

      // Limpia el contenido del contenedor
      filtrosAdicionales.innerHTML = '';

      if (this.value === 'trimestral') {
        // Agrega los selectores de trimestre y año
        filtrosAdicionales.innerHTML = `
            <label for="trimestreSelect">Seleccione un trimestre:</label>
            <select id="trimestreSelect" name="trimestre" class="form-control">
                <option value="1">Trimestre 1</option>
                <option value="2">Trimestre 2</option>
                <option value="3">Trimestre 3</option>
                <option value="4">Trimestre 4</option>
            </select>
            <label for="yearSelect">Seleccione un año:</label>
            <select id="yearSelect" name="year" class="form-control" required>
                <?php
                $currentYear = date('Y');
                for ($year = $currentYear; $year >= 2000; $year--) {
                  echo "<option value=\"$year\"" . ($selectedYear == $year ? ' selected' : '') . ">$year</option>";
                }
                ?>
            </select>
        `;
      } else if (this.value === 'mensual') { // Agrega esta condición
        // Agrega los selectores de mes y año
        filtrosAdicionales.innerHTML = `
            <label for="monthSelect">Seleccione un mes:</label>
            <select id="monthSelect" name="month" class="form-control">
                <option value="" selected>Seleccione un mes</option>
                <option value="01" <?= $selectedMonth == '01' ? 'selected' : '' ?>>Enero</option>
                <option value="02" <?= $selectedMonth == '02' ? 'selected' : '' ?>>Febrero</option>
                <option value="03" <?= $selectedMonth == '03' ? 'selected' : '' ?>>Marzo</option>
                <option value="04" <?= $selectedMonth == '04' ? 'selected' : '' ?>>Abril</option>
                <option value="05" <?= $selectedMonth == '05' ? 'selected' : '' ?>>Mayo</option>
                <option value="06" <?= $selectedMonth == '06' ? 'selected' : '' ?>>Junio</option>
                <option value="07" <?= $selectedMonth == '07' ? 'selected' : '' ?>>Julio</option>
                <option value="08" <?= $selectedMonth == '08' ? 'selected' : '' ?>>Agosto</option>
                <option value="09" <?= $selectedMonth == '09' ? 'selected' : '' ?>>Septiembre</option>
                <option value="10" <?= $selectedMonth == '10' ? 'selected' : '' ?>>Octubre</option>
                <option value="11" <?= $selectedMonth == '11' ? 'selected' : '' ?>>Noviembre</option>
                <option value="12" <?= $selectedMonth == '12' ? 'selected' : '' ?>>Diciembre</option>
            </select>
            <label for="yearSelect">Seleccione un año:</label>
            <select id="yearSelect" name="year" class="form-control" required>
                <?php
                $currentYear = date('Y');
                for ($year = $currentYear; $year >= 2000; $year--) {
                  echo "<option value=\"$year\"" . ($selectedYear == $year ? ' selected' : '') . ">$year</option>";
                }
                ?>
            </select>
        `;
      } else if (this.value === 'rango') {
        // Agrega los campos de rango de fechas
        filtrosAdicionales.innerHTML = `
            <label for="fechaInicio">Fecha de inicio:</label>
            <input type="date" id="fechaInicio" name="fechaInicio" class="form-control" value="<?= $fechaInicio ?>">

            <label for="fechaFin">Fecha de fin:</label>
            <input type="date" id="fechaFin" name="fechaFin" class="form-control" value="<?= $fechaFin ?>">
        `;
      }

    });
  </script>
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

      if (section === 'registro') {
        loadContent('tabla_admin.php');
      }
    });
  </script>
</body>

</html>