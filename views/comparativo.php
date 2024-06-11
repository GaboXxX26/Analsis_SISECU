<?php
include "../includes/_db.php";
session_start();
error_reporting(0);


// Obtener los filtros seleccionados
// Obtener los filtros seleccionados
$selectedCentros = isset($_GET['centros']) ? $_GET['centros'] : [];
$selectedCentro = isset($_GET['centro']) ? $_GET['centro'] : '';
$fechaInicio = isset($_GET['fechaInicio']) ? $_GET['fechaInicio'] : '';
$fechaFin = isset($_GET['fechaFin']) ? $_GET['fechaFin'] : '';

// Obtener el nombre del centro seleccionado
$nombreCentro = '';
if (!empty($selectedCentro)) {
    $queryCentroNombre = "SELECT nombre_centro FROM centro WHERE id_centro = ?";
    $stmtCentroNombre = $pdo->prepare($queryCentroNombre);
    $stmtCentroNombre->execute([$selectedCentro]);
    if ($stmtCentroNombre->rowCount() > 0) {
        $nombreCentro = $stmtCentroNombre->fetchColumn();
    }
}

// Construir la consulta SQL con condiciones opcionales
$consulta = "SELECT TO_CHAR(r.created_at, 'TMMonth') AS nombre_mes, r.id_registro, c.nombre_centro, r.conve_stra, r.comp_insti, r.opera_cam, r.ausentimo, r.mobile_locator, r.dispoci, r.com_estra, TO_CHAR(r.created_at, 'MM') AS mes_creado
                FROM public.registros AS r 
                LEFT JOIN centro AS c ON c.id_centro = r.id_centro 
                WHERE 1=1 ";
$params = [];

// Aplicar filtros dinámicamente
if (!empty($selectedCentros)) {
    $placeholders = implode(',', array_fill(0, count($selectedCentros), '?'));
    $consulta .= " AND r.id_centro IN ($placeholders)";
    $params = array_merge($params, $selectedCentros);
} elseif (!empty($selectedCentro)) {
    $consulta .= " AND r.id_centro = ?";
    $params[] = $selectedCentro;
}

if (!empty($fechaInicio) && !empty($fechaFin)) {
    $fechaInicio .= ' 00:00:00';
    $fechaFin .= ' 23:59:59';
    $consulta .= " AND r.created_at BETWEEN ? AND ?";
    $params[] = $fechaInicio;
    $params[] = $fechaFin;
}

$consulta .= " ORDER BY r.created_at";  // Añadir ordenamiento al final de la consulta

// Preparar y ejecutar la consulta
$stmt = $pdo->prepare($consulta);
$stmt->execute($params);

// Procesar los resultados de la consulta para generar los datos de los gráficos
$datosGrafica = [];
$nombresMeses = [];
$promediosGestion = [];
$promediosOperativa = [];
$promediosCalidad = [];

if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $mes = $row['nombre_mes'];
        $centro = $row['nombre_centro'];

        if (!isset($datosGrafica[$centro])) {
            $datosGrafica[$centro] = [
                'nombre' => $centro,
                'gestion' => [],
                'operativa' => [],
                'calidad' => []
            ];
        }

        $promedio_gestion = ($row['conve_stra'] + $row['comp_insti']);
        $promedio_operativa = ($row['opera_cam'] + $row['ausentimo'] + $row['mobile_locator']);
        $promedio_calidad = ($row['dispoci'] + $row['com_estra']);

        if (!in_array($mes, $nombresMeses)) {
            $nombresMeses[] = $mes;
        }

        $datosGrafica[$centro]['gestion'][$mes] = number_format($promedio_gestion, 2);
        $datosGrafica[$centro]['operativa'][$mes] = number_format($promedio_operativa, 2);
        $datosGrafica[$centro]['calidad'][$mes] = number_format($promedio_calidad, 2);
    }
}

// Convertir los valores de cada centro en un formato adecuado para los gráficos
foreach ($datosGrafica as &$centro) {
    foreach (['gestion', 'operativa', 'calidad'] as $tipo) {
        $valores = [];
        foreach ($nombresMeses as $mes) {
            $valores[] = isset($centro[$tipo][$mes]) ? $centro[$tipo][$mes] : 0;
        }
        $centro[$tipo] = $valores;
    }
}

// Generar el gráfico solo si hay datos
$hayFiltrosIngresados = !empty($selectedCentros) || !empty($selectedCentro) || (!empty($fechaInicio) && !empty($fechaFin));

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
                <!-- Sidebar user panel (optional) -->
                <br>
                <div>
                    <div class="info">
                        <label class="d-block" style="color: #a6abb4; text-align: center; font-weight: normal;"><?php echo $nombre_usuario . " " . $apellido_usuario; ?></label>

                        <label class="d-block" style="color:#a6abb4; text-align:center; "> <?php echo $rol; ?></label>
                    </div>
                </div>
                <!-- Sidebar Menu -->
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
                                    <br>

                                    <h1> Filtro comparativo de centros</h1>
                                    <?php
                                    $hayFiltrosIngresados = !empty($_GET['tipoFiltro']) || !empty($_GET['fechaInicio']) || !empty($_GET['fechaFin']) || !empty($_GET['centro']);
                                    ?>
                                    <div class="col-md-3" id="filter-container">
                                        <form id="filterForm" class="mb-2" method="GET">
                                            <div class="form-group">
                                                <label for="centroSelect" style>Seleccione maximo 7 centros:</label>
                                                <div class="form-check">
                                                    <?php
                                                    // Realizar la consulta para obtener los centros
                                                    $queryCentros = "SELECT id_centro, nombre_centro FROM centro";
                                                    $stmtCentros = $pdo->query($queryCentros);

                                                    // Iterar sobre los resultados y generar los checkboxes
                                                    while ($rowCentro = $stmtCentros->fetch(PDO::FETCH_ASSOC)) {
                                                        // Determinar si el checkbox debe estar marcado
                                                        $checked = in_array($rowCentro['id_centro'], $selectedCentros) ? 'checked' : '';
                                                        echo "<input type='checkbox' id='centroSelect_{$rowCentro['id_centro']}' name='centros[]' value='{$rowCentro['id_centro']}' $checked>";
                                                        echo "<label for='centroSelect_{$rowCentro['id_centro']}'> {$rowCentro['nombre_centro']}</label><br>";
                                                    }
                                                    ?>
                                                </div>
                                                <label for="fechaInicio">Fecha de inicio:</label>
                                                <input type="date" id="fechaInicio" name="fechaInicio" class="form-control" value="<?= isset($_GET['fechaInicio']) ? $_GET['fechaInicio'] : '' ?>">
                                                <label for="fechaFin">Fecha de fin:</label>
                                                <input type="date" id="fechaFin" name="fechaFin" class="form-control" value="<?= isset($_GET['fechaFin']) ? $_GET['fechaFin'] : '' ?>">
                                            </div>
                                            <div id="filtrosAdicionales" class="form-group">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Filtrar</button>
                                            <?php if ($hayFiltrosIngresados) : ?>
                                                <button type="button" class="btn btn-secondary" onclick="limpiarFiltros()">Limpiar filtros</button>
                                            <?php endif; ?>
                                        </form>
                                    </div>
                                    <div id="chart-container">
                                        <div class="col-md-12">
                                            <div class="card card-success">
                                                <div class="card-header">
                                                    <h3 class="card-title">Indicadores Gestion Interinstitucional 20% </h3>
                                                    <div class="card-tools">
                                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="chart">
                                                        <canvas id="gestionChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card card-success">
                                                <div class="card-header">
                                                    <h3 class="card-title">Indicadores de gestion operativa (50%)</h3>
                                                    <div class="card-tools">
                                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="chart">
                                                        <canvas id="calidadChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card card-success">
                                                <div class="card-header">
                                                    <h3 class="card-title"> Indicadores de calidad (30%)</h3>
                                                    <div class="card-tools">
                                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="chart">
                                                        <canvas id="operativaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
    <!-- /.control-sidebar -->
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
        document.addEventListener('DOMContentLoaded', (event) => {
            const checkboxes = document.querySelectorAll('input[type="checkbox"][name="centros[]"]');
            const maxSelections = 7;

            const updateCheckboxes = () => {
                const selectedCount = document.querySelectorAll('input[type="checkbox"][name="centros[]"]:checked').length;
                checkboxes.forEach(box => {
                    if (!box.checked && selectedCount >= maxSelections) {
                        box.disabled = true;
                    } else {
                        box.disabled = false;
                    }
                });
            };

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateCheckboxes);
            });

            // Inicialización para bloquear casillas si ya hay 7 seleccionadas al cargar la página
            updateCheckboxes();
        });
    </script>
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
    <?php if ($hayFiltrosIngresados) : ?>
        <script>
            $(function() {
                var nombresMeses = <?php echo json_encode($nombresMeses); ?>;
                var datosGrafica = <?php echo json_encode(array_values($datosGrafica)); ?>;
                var colores = ['rgba(255, 0, 0, 0.5)', 'rgba(0, 255, 0, 0.5)', 'rgba(0, 0, 255, 0.5)', 'rgba(255, 165, 0, 0.5)', 'rgba(75, 0, 130, 0.5)', 'rgba(255, 255, 0, 1)', 'rgba(255, 0, 255, 1)']; // Añadir más colores si hay más centros

                function crearGrafico(canvasId, tipo) {
                    var datasets = [];

                    datosGrafica.forEach(function(centro, index) {
                        datasets.push({
                            label: centro.nombre,
                            backgroundColor: colores[index % colores.length],
                            borderColor: colores[index % colores.length].replace('0.5', '1'),
                            borderWidth: 1,
                            data: centro[tipo],
                            fill: false,
                            lineTension: 0
                        });
                    });

                    var chartData = {
                        labels: nombresMeses,
                        datasets: datasets
                    };

                    var chartCanvas = $('#' + canvasId).get(0).getContext('2d');
                    var chartOptions = {
                        responsive: true,
                        maintainAspectRatio: false,
                        datasetFill: false,
                        scales: {
                            xAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    };

                    new Chart(chartCanvas, {
                        type: 'bar',
                        data: chartData,
                        options: chartOptions
                    });
                }

                crearGrafico('gestionChart', 'gestion');
                crearGrafico('operativaChart', 'operativa');
                crearGrafico('calidadChart', 'calidad');
            });

            function limpiarFiltros() {
                // Limpiar los valores de los input type date
                document.getElementById('fechaInicio').value = '';
                document.getElementById('fechaFin').value = '';

                // Limpiar los checkboxes
                var checkboxes = document.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = false;
                });
            }
        </script>
    <?php endif; ?>
</body>

</html>