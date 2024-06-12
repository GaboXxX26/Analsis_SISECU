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
    'e17a74c4-9627-443c-b020-23dc4818b718' => ['user.php', 'tabla_admin.php',  'historico.php', 'comparativo.php'],
    'ad2e8033-4a14-40d6-a999-1f1c6467a5e6' => ['user.php', 'historico.php', 'comparativo.php']

];

// Verificar si el usuario tiene permiso para la página actual
$pagina_actual = basename($_SERVER['PHP_SELF']); // Obtiene el nombre del archivo actual
if (!in_array($pagina_actual, $permisos[$_SESSION['rol_id']])) {
    header("Location: ../views/acceso_denegado.php"); // O redirige a la página adecuada
    die();
}

// Obtener los filtros seleccionados del formulario
$selectedCentro = isset($_GET['centro']) ? $_GET['centro'] : '';
$tipoFiltro = isset($_GET['tipoFiltro']) ? $_GET['tipoFiltro'] : '';
$anio = isset($_GET['anio']) ? $_GET['anio'] : '';
$mes = isset($_GET['mes']) ? $_GET['mes'] : '';
$trimestre = isset($_GET['trimestre']) ? $_GET['trimestre'] : '';
$fechaInicio = isset($_GET['fechaInicio']) ? $_GET['fechaInicio'] : '';
$fechaFin = isset($_GET['fechaFin']) ? $_GET['fechaFin'] : '';

// Obtener el nombre del centro seleccionado
$nombreCentro = '';
if (!empty($selectedCentro) && $selectedCentro != 'todos') {
    $queryCentroNombre = "SELECT nombre_centro FROM centro WHERE id_centro = :selectedCentro";
    $stmtCentroNombre = $pdo->prepare($queryCentroNombre);
    $stmtCentroNombre->execute(['selectedCentro' => $selectedCentro]);
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
if (!empty($selectedCentro) && $selectedCentro != 'todos') {
    $consulta .= " AND r.id_centro = :selectedCentro";
    $params['selectedCentro'] = $selectedCentro;
}

switch ($tipoFiltro) {
    case 'mensual':
        if (!empty($anio) && !empty($mes)) {
            $consulta .= " AND EXTRACT(YEAR FROM r.created_at) = :anio AND EXTRACT(MONTH FROM r.created_at) = :mes";
            $params['anio'] = $anio;
            $params['mes'] = $mes;
        }
        break;
    case 'trimestral':
        if (!empty($trimestre)) {
            $consulta .= " AND EXTRACT(QUARTER FROM r.created_at) = :trimestre";
            $params['trimestre'] = $trimestre;
        }
        break;
    case 'rango':
        if (!empty($fechaInicio) && !empty($fechaFin)) {
            $fechaInicio .= ' 00:00:00';
            $fechaFin .= ' 23:59:59';
            $consulta .= " AND r.created_at BETWEEN :fechaInicio AND :fechaFin";
            $params['fechaInicio'] = $fechaInicio;
            $params['fechaFin'] = $fechaFin;
        }
        break;
}

// Ordenar por fecha de creación
$consulta .= " ORDER BY r.created_at";  // Añadir ordenamiento al final de la consulta

// Prepare and execute the query
$stmt = $pdo->prepare($consulta);
$stmt->execute($params);

$datosGrafica = [];
$nombresMeses = [];
$promediosGestion = [];
$promediosOperativa = [];
$promediosCalidad = [];
$totalesCumplimiento = [];

$total_gestion = 0;
$total_operativa = 0;
$total_calidad = 0;
$total_cumplimiento_gestion = 0;
$total_centros = 0;

if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $mes = $row['nombre_mes'];
        if (!isset($datosGrafica[$mes])) {
            $datosGrafica[$mes] = [
                'nombre_mes' => $row['nombre_mes'],
                'promedio_gestion' => 0,
                'promedio_operativa' => 0,
                'promedio_calidad' => 0
            ];
        }

        $promedio_gestion = ($row['conve_stra'] + $row['comp_insti']);
        $promedio_operativa = ($row['opera_cam'] + $row['ausentimo'] + $row['mobile_locator']);
        $promedio_calidad = ($row['dispoci'] + $row['com_estra']);

        $promedio_gestion_formatted = number_format($promedio_gestion, 2);
        $promedio_operativa_formatted = number_format($promedio_operativa, 2);
        $promedio_calidad_formatted = number_format($promedio_calidad, 2);

        $suma_total_centro = $promedio_gestion + $promedio_operativa + $promedio_calidad;
        $nombresMeses[] = $row['nombre_mes'];
        $totalesCumplimiento[] = number_format($suma_total_centro, 2);
        $promediosGestion[] = $promedio_gestion_formatted;
        $promediosOperativa[] = $promedio_operativa_formatted;
        $promediosCalidad[] = $promedio_calidad_formatted;

        // Sumar los promedios al total nacional
        $total_gestion += $promedio_gestion;
        $total_operativa += $promedio_operativa;
        $total_calidad += $promedio_calidad;
        $total_cumplimiento_gestion += $suma_total_centro;
        $total_centros++;
    }

    // Calcular los promedios nacionales
    $promedio_nacional_gestion = $total_gestion / $total_centros;
    $promedio_nacional_operativa = $total_operativa / $total_centros;
    $promedio_nacional_calidad = $total_calidad / $total_centros;
    $promedio_nacional_cumplimiento_gestion = $total_cumplimiento_gestion / $total_centros;

    // Formatear los promedios nacionales para los gráficos
    $promNacionalGestion = number_format($promedio_nacional_gestion, 2);
    $promNacionalOperativa = number_format($promedio_nacional_operativa, 2);
    $promNacionalCalidad = number_format($promedio_nacional_calidad, 2);
    $promNacionalCumplimiento = number_format($promedio_nacional_cumplimiento_gestion, 2);
}

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
            </div>
        </aside>
        <br>
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <?php
                                    $hayFiltrosIngresados = !empty($_GET['tipoFiltro']) || !empty($_GET['fechaInicio']) || !empty($_GET['fechaFin']) || !empty($_GET['centro']);
                                    ?>
                                    <div id="filter-container">
                                        <h2>Histórico individual de los centros nacionales</h2>
                                        <div class="col-md-3">
                                            <form id="filterForm" class="mb-2" method="GET">
                                                <div class="form-group">
                                                    <label for="centroSelect">Seleccione un centro:</label>
                                                    <select id="centroSelect" name="centro" class="form-control" required>
                                                        <option value="">Seleccione un centro</option>
                                                        <option value="todos" <?php echo isset($_GET['centro']) && $_GET['centro'] == 'todos' ? 'selected' : ''; ?>>Nacional</option>
                                                        <?php
                                                        $queryCentros = "SELECT id_centro, nombre_centro FROM centro";
                                                        $stmtCentros = $pdo->query($queryCentros);
                                                        $selectedCentro = isset($_GET['centro']) ? $_GET['centro'] : '';

                                                        while ($rowCentro = $stmtCentros->fetch(PDO::FETCH_ASSOC)) {
                                                            $isSelected = $rowCentro['id_centro'] == $selectedCentro ? 'selected' : '';
                                                            echo "<option value='{$rowCentro['id_centro']}' $isSelected>{$rowCentro['nombre_centro']}</option>";
                                                        }
                                                        ?>
                                                    </select>

                                                    <label for="tipoFiltro">Tipo de filtro:</label>
                                                    <select id="tipoFiltro" name="tipoFiltro" class="form-control" required onchange="mostrarFiltros()">
                                                        <option value="">Seleccione el tipo de filtro</option>
                                                        <option value="mensual" <?php echo isset($_GET['tipoFiltro']) && $_GET['tipoFiltro'] == 'mensual' ? 'selected' : ''; ?>>Anual</option>
                                                        <option value="trimestral" <?php echo isset($_GET['tipoFiltro']) && $_GET['tipoFiltro'] == 'trimestral' ? 'selected' : ''; ?>>Trimestral</option>
                                                        <option value="rango" <?php echo isset($_GET['tipoFiltro']) && $_GET['tipoFiltro'] == 'rango' ? 'selected' : ''; ?>>Rango de fechas</option>
                                                    </select>

                                                    <div id="filtroMensual" style="display: none;">
                                                        <label for="anio">Seleccione el año:</label>
                                                        <select id="anio" name="anio" class="form-control">
                                                            <option value="">Seleccione un año </option>
                                                            <?php
                                                            $currentYear = date("Y");
                                                            for ($i = $currentYear; $i >= 2000; $i--) {
                                                                echo "<option value='$i'>$i</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>

                                                    <div id="filtroTrimestral" style="display: none;">
                                                        <label for="trimestre">Seleccione el trimestre:</label>
                                                        <select id="trimestre" name="trimestre" class="form-control">
                                                            <option value="">Seleccione un trimestre </option>
                                                            <option value="1">Primer trimestre (Enero - Marzo)</option>
                                                            <option value="2">Segundo trimestre (Abril - Junio)</option>
                                                            <option value="3">Tercer trimestre (Julio - Septiembre)</option>
                                                            <option value="4">Cuarto trimestre (Octubre - Diciembre)</option>
                                                        </select>
                                                    </div>

                                                    <div id="filtroRangoFechas" style="display: none;">
                                                        <label for="fechaInicio">Fecha de inicio:</label>
                                                        <input type="date" id="fechaInicio" name="fechaInicio" class="form-control" value="<?php echo isset($_GET['fechaInicio']) ? $_GET['fechaInicio'] : ''; ?>">

                                                        <label for="fechaFin">Fecha de fin:</label>
                                                        <input type="date" id="fechaFin" name="fechaFin" class="form-control" value="<?php echo isset($_GET['fechaFin']) ? $_GET['fechaFin'] : ''; ?>">
                                                    </div>
                                                </div>

                                                <button type="submit" class="btn btn-primary" id="filterButton">Filtrar</button>

                                                <?php if ($hayFiltrosIngresados) : ?>
                                                    <button type="button" class="btn btn-secondary" onclick="limpiarFiltros()">Limpiar filtros</button>
                                                <?php endif; ?>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-md-10" id="individualChartContainer" style="display: none;">
                                        <div class="card card-success">
                                            <div class="card-header">
                                                <h3 class="card-title">Resultados <?php echo !empty($nombreCentro) ? " - Centro " . htmlspecialchars($nombreCentro) : ''; ?></h3>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="chart">
                                                    <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="nationalChartContainer" style="display: none;">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="card card-success" style="height:25rem;">
                                                    <div class="card-header">
                                                        <h3 class="card-title">Interinstitucional(20%)</h3>
                                                        <div class="card-tools">
                                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                                <i class="fas fa-minus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="chart">
                                                            <canvas id="intChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                                            <h2 class="text-center"><?php echo $promNacionalGestion; ?>%</h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card card-success" style="height:25rem;">
                                                    <div class="card-header">
                                                        <h3 class="card-title">Operativa(50%)</h3>
                                                        <div class="card-tools">
                                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                                <i class="fas fa-minus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="chart">
                                                            <canvas id="opeChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                                            <h1 class="text-center"><?php echo $promNacionalOperativa; ?>%</h1>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card card-success" style="height:25rem;">
                                                    <div class="card-header">
                                                        <h3 class="card-title ">Estratégica(30%)</h3>
                                                        <div class="card-tools">
                                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                                <i class="fas fa-minus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="chart">
                                                            <canvas id="estraChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                                            <h2 class="text-center"><?php echo $promNacionalCalidad; ?>%</h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="card card-success">
                                                <div class="card-header">
                                                    <h3 class="card-title">Total Nacional (100%)</h3>
                                                    <div class="card-tools">
                                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card-body" id="chart-container">
                                                    <div class="chart">
                                                        <canvas id="nacionalChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                                        <h2 class="text-center"><?php echo $promNacionalCumplimiento; ?>%</h2>
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
    </div>
    <footer class="main-footer">
        <strong>Copyright &copy; 2024 <a href="https://www.ecu911.gob.ec/" target="_blank">Sistema Integrado de Seguridad ECU 911</a>.</strong>
        Todos los derechos reservados.
    </footer>
    <aside class="control-sidebar control-sidebar-dark">
    </aside>
    </div>
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
        document.addEventListener('DOMContentLoaded', function() {
            const filterForm = document.getElementById('filterForm');
            const filterButton = document.getElementById('filterButton');
            const centroSelect = document.getElementById('centroSelect');
            const individualChartContainer = document.getElementById('individualChartContainer');
            const nationalChartContainer = document.getElementById('nationalChartContainer');

            function toggleCharts() {
                const selectedCentro = centroSelect.value;
                if (selectedCentro === 'todos') {
                    individualChartContainer.style.display = 'none';
                    nationalChartContainer.style.display = 'block';
                } else if (selectedCentro !== '') {
                    individualChartContainer.style.display = 'block';
                    nationalChartContainer.style.display = 'none';
                } else {
                    individualChartContainer.style.display = 'none';
                    nationalChartContainer.style.display = 'none';
                }
            }

            // Call the function on form submit
            filterForm.addEventListener('submit', function(event) {
                event.preventDefault();
                toggleCharts();
                filterForm.submit(); // Submit the form after handling the chart visibility
            });

            // Call the function on page load to set initial visibility
            toggleCharts();
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
        function mostrarFiltros() {
            const tipoFiltro = document.getElementById('tipoFiltro').value;
            document.getElementById('filtroMensual').style.display = (tipoFiltro === 'mensual') ? 'block' : 'none';
            document.getElementById('filtroTrimestral').style.display = (tipoFiltro === 'trimestral') ? 'block' : 'none';
            document.getElementById('filtroRangoFechas').style.display = (tipoFiltro === 'rango') ? 'block' : 'none';
        }

        // Llamar a la función mostrarFiltros al cargar la página para mantener el estado de los filtros visibles según el valor seleccionado previamente
        document.addEventListener('DOMContentLoaded', mostrarFiltros);
    </script>
    <?php if ($hayFiltrosIngresados) : ?>
        <script>
            $(function() {
                var areaChartData = {
                    labels: <?php echo json_encode($nombresMeses); ?>,
                    datasets: [{
                        label: 'Gestión Interinstitucional (20%)',
                        backgroundColor: 'rgba(255, 0, 0, 0.5)',
                        borderColor: 'rgba(255, 0, 0, 1)',
                        borderWidth: 1,
                        data: <?php echo json_encode($promediosGestion); ?>,
                        fill: false,
                        lineTension: 0
                    }, {
                        label: 'Gestión Operativa (50%)',
                        backgroundColor: 'rgba(0, 255, 0, 0.5)',
                        borderColor: 'rgba(0, 255, 0, 1)',
                        borderWidth: 1,
                        data: <?php echo json_encode($promediosOperativa); ?>,
                        fill: false,
                        lineTension: 0
                    }, {
                        label: 'Calidad del Servicio (30%)',
                        backgroundColor: 'rgba(0, 0, 255, 0.5)',
                        borderColor: 'rgba(0, 0, 255, 1)',
                        borderWidth: 1,
                        data: <?php echo json_encode($promediosCalidad); ?>,
                        fill: false,
                        lineTension: 0
                    }]
                };

                var barChartCanvas = $('#barChart').get(0).getContext('2d');
                var barChartData = $.extend(true, {}, areaChartData);
                var temp0 = areaChartData.datasets[0];
                var temp1 = areaChartData.datasets[1];
                var temp2 = areaChartData.datasets[2];
                barChartData.datasets[0] = temp0;
                barChartData.datasets[1] = temp1;
                barChartData.datasets[2] = temp2;

                var barChartOptions = {
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

                new Chart(barChartCanvas, {
                    type: 'line',
                    data: barChartData,
                    options: barChartOptions
                });
            });
            // Configuración para cuando se seleccionan varios centros
            var barChartDataComparacion = {
                labels: <?php echo json_encode($nombresMeses); ?>,
                datasets: [
                    <?php foreach ($datosGrafica as $dato) { ?> {
                            label: '<?php echo $dato['nombre_centro']; ?>',
                            backgroundColor: 'rgba(<?php echo rand(0, 255); ?>, <?php echo rand(0, 255); ?>, <?php echo rand(0, 255); ?>, 0.5)',
                            borderColor: 'rgba(<?php echo rand(0, 255); ?>, <?php echo rand(0, 255); ?>, <?php echo rand(0, 255); ?>, 1)',
                            borderWidth: 1,
                            data: [<?php echo implode(',', [$dato['promedio_gestion'], $dato['promedio_operativa'], $dato['promedio_calidad']]); ?>],
                            fill: false,
                            lineTension: 0
                        },
                    <?php } ?>
                ]
            };

            var barChartCanvasComparacion = $('#barChartComparacion').get(0).getContext('2d');
            var barChartOptionsComparacion = {
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

            new Chart(barChartCanvasComparacion, {
                type: 'line',
                data: barChartDataComparacion,
                options: barChartOptionsComparacion
            });

            function limpiarFiltros() {
                // Limpiar los valores de los input type date
                document.getElementById('fechaInicio').value = '';
                document.getElementById('fechaFin').value = '';
                document.getElementById('tipoFiltro').value = '';
                document.getElementById('anio').value = '';
                document.getElementById('trimestre').value = '';

                // Limpiar la selección del centro
                document.getElementById('centroSelect').selectedIndex = 0;
            }
        </script>
        <script>
            $(function() {
                var datosAnilloGestion = {
                    labels: ['Gestión Interinstitucional 20%', ''], // Solo una etiqueta
                    datasets: [{
                        data: [<?php echo $promNacionalGestion; ?>, 20 - <?php echo $promNacionalGestion; ?>], // Valor real y valor restante
                        backgroundColor: ['#19DFD3', 'rgba(0, 0, 0, 0)'], // Color para la gestión y transparente para el resto
                        hoverBackgroundColor: ['#19DFD3', 'rgba(0, 0, 0, 0)'], // Color para el hover

                    }]
                };

                // Opciones del gráfico
                var opcionesAnillo = {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutoutPercentage: 75,
                    rotation: -Math.PI,
                    circumference: Math.PI
                };

                // Crear el gráfico de anillo en el canvas #intChart
                new Chart(document.getElementById('intChart'), {
                    type: 'doughnut',
                    data: datosAnilloGestion, // Usar los datos específicos de gestión
                    options: opcionesAnillo
                });
            });
        </script>
        <script>
            $(function() {
                var datosAnilloGestion = {
                    labels: ['Gestión Operativa 50%', ''], // Solo una etiqueta
                    datasets: [{
                        data: [<?php echo $promNacionalOperativa; ?>, 50 - <?php echo $promNacionalOperativa; ?>], // Solo un valor
                        backgroundColor: ['#19DFD3 ', 'rgba(0, 0, 0, 0)'], // Color para la gestión y transparente para el resto
                        hoverBackgroundColor: ['#19DFD3', 'rgba(0, 0, 0, 0)'], // Color para el hover
                    }]
                };

                // Opciones del gráfico
                var opcionesAnillo = {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutoutPercentage: 75,
                    rotation: -Math.PI,
                    circumference: Math.PI,
                };

                // Crear el gráfico de anillo en el canvas #intChart
                new Chart(document.getElementById('opeChart'), {
                    type: 'doughnut',
                    data: datosAnilloGestion, // Usar los datos específicos de gestión
                    options: opcionesAnillo
                });
            });
        </script>
        <script>
            $(function() {
                var datosAnilloGestion = {
                    labels: ['Gestión Estrategica 30%'], // Solo una etiqueta
                    datasets: [{
                        data: [<?php echo $promNacionalCalidad; ?>, 30 - <?php echo $promNacionalCalidad; ?>], // Solo un valor
                        backgroundColor: ['#19DFD3 ', 'rgba(0, 0, 0, 0)'], // Color para la gestión y transparente para el resto
                        hoverBackgroundColor: ['#19DFD3', 'rgba(0, 0, 0, 0)'], // Color para el hover

                    }]
                };

                // Opciones del gráfico
                var opcionesAnillo = {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutoutPercentage: 75,
                    rotation: -Math.PI,
                    circumference: Math.PI
                };

                // Crear el gráfico de anillo en el canvas #intChart
                new Chart(document.getElementById('estraChart'), {
                    type: 'doughnut',
                    data: datosAnilloGestion, // Usar los datos específicos de gestión
                    options: opcionesAnillo
                });
            });
        </script>
        <script>
            $(function() {
                var datosAnilloGestion = {
                    labels: ['Total Nacional (100%)'], // Solo una etiqueta
                    datasets: [{
                        data: [<?php echo $promNacionalCumplimiento; ?>, 100 - <?php echo $promNacionalCumplimiento; ?>], // Solo un valor
                        backgroundColor: ['#19DFD3', 'rgba(0, 0, 0, 0)'], // Color para la gestión y transparente para el resto
                        hoverBackgroundColor: ['#19DFD3', 'rgba(0, 0, 0, 0)'], // Color para el hover
                    }]
                };

                // Opciones del gráfico
                var opcionesAnillo = {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutoutPercentage: 75,
                    rotation: -Math.PI,
                    circumference: Math.PI
                };

                // Crear el gráfico de anillo en el canvas #intChart
                new Chart(document.getElementById('nacionalChart'), {
                    type: 'doughnut',
                    data: datosAnilloGestion, // Usar los datos específicos de gestión
                    options: opcionesAnillo
                });
            });
        </script>
    <?php endif; ?>
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

</body>

</html>