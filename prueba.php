<?php
include "./includes/_db.php";
session_start();
error_reporting(0);

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administrador</title>
    <link rel="icon" type="image/x-icon" href="./Resources/images/ECU911.png" />
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="./plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="./plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="./plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="./dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="./plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="./plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="./plugins/summernote/summernote-bs4.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="./plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="./plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="./plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <link rel="stylesheet" href="./plugins/dropzone/min/dropzone.min.css">

    <link rel="stylesheet" href="../../plugins/bs-stepper/css/bs-stepper.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Administrador</h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>

            <!-- /.content-header -->
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="card-header">
                                        <h3 class="card-title">Tabla de Indicadores SIS ECU911</h3>
                                    </div>
                                    <br>
                                    <div class="container mt-12">
                                        <h2 class="mb-4">Filtrar Registros por Mes, Año, Trimestre y Centro</h2>
                                        <?php
                                        $hayFiltrosIngresados = !empty($_GET['tipoFiltro']) || !empty($_GET['fechaInicio']) || !empty($_GET['fechaFin']) || !empty($_GET['centro']);
                                        ?>
                                        <div class="col-md-3">
                                            <form id="filterForm" class="mb-2" method="GET">
                                                <div class="form-group">
                                                    <label for="centroSelect">Seleccione uno o más centros:</label>
                                                    <div class="form-check">
                                                        <?php
                                                        $queryCentros = "SELECT id_centro, nombre_centro FROM centro";
                                                        $stmtCentros = $pdo->query($queryCentros);
                                                        while ($rowCentro = $stmtCentros->fetch(PDO::FETCH_ASSOC)) {
                                                            echo "<input type='checkbox' id='centroSelect_{$rowCentro['id_centro']}' name='centros[]' value='{$rowCentro['id_centro']}'>";
                                                            echo "<label for='centroSelect_{$rowCentro['id_centro']}'>{$rowCentro['nombre_centro']}</label><br>";
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
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card card-success">
                                                    <div class="card-header">
                                                        <h3 class="card-title">Indicadores Gestion 20% </h3>
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
                                                        <h3 class="card-title">Indicadores de gestion de calidad(30%)</h3>
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
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card card-success">
                                                    <div class="card-header">
                                                        <h3 class="card-title">Indicadores de gestion operativa (50%) </h3>
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
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
    </div>
    <!-- ./wrapper -->
    <!-- jQuery -->
    <script src="./plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="./plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="./plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="./plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="./plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="./plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="./plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="./plugins/moment/moment.min.js"></script>
    <script src="./plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="./plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="./plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="./plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="./dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="./dist/js/demo.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="./dist/js/pages/dashboard.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="./plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="./plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="./plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="./plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="./plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="./plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="./plugins/jszip/jszip.min.js"></script>
    <script src="./plugins/pdfmake/pdfmake.min.js"></script>
    <script src="./plugins/pdfmake/vfs_fonts.js"></script>
    <script src="./plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="./plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="./plugins/datatables-buttons/js/buttons.colVis.min.js"></script>


    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": false,
                "lengthChange": true,
                "autoWidth": true,
                "scrollX": true,
                "buttons": ["copy", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
    <?php if ($hayFiltrosIngresados) : ?>
        <script>
            $(function() {
                var nombresMeses = <?php echo json_encode($nombresMeses); ?>;
                var datosGrafica = <?php echo json_encode(array_values($datosGrafica)); ?>;
                var colores = ['rgba(255, 0, 0, 0.5)', 'rgba(0, 255, 0, 0.5)', 'rgba(0, 0, 255, 0.5)', 'rgba(255, 165, 0, 0.5)', 'rgba(75, 0, 130, 0.5)', 'rgba(255, 255, 0, 1)', 'rgba(255, 0, 255, 1)', 'rgba(0, 255, 255, 1)', 'rgba(255, 255, 255, 1)', 'rgba(0, 0, 0, 1)', 'rgba(128, 0, 0, 1)', 'rgba(128, 128, 0, 1)', 'rgba(0, 128, 0, 1)', 'rgba(128, 0, 128, 1)', 'rgba(0, 128, 128, 1)', 'rgba(192, 192, 192, 1)', 'rgba(255, 165, 0, 1)']; // Añadir más colores si hay más centros

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
                        type: 'line',
                        data: chartData,
                        options: chartOptions
                    });
                }

                crearGrafico('gestionChart', 'gestion');
                crearGrafico('operativaChart', 'operativa');
                crearGrafico('calidadChart', 'calidad');
            });

            function limpiarFiltros() {
                document.getElementById('tipoFiltro').value = '';
                document.getElementById('fechaInicio').value = '';
                document.getElementById('fechaFin').value = '';
                document.getElementById('centroSelect').value = '';
                // Aquí puedes agregar más líneas para limpiar otros filtros si es necesario
            }
        </script>
    <?php endif; ?>
</body>

</html>