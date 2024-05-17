<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

session_start();
error_reporting(0);

$validar = $_SESSION['correo'];

if ($validar == null || $validar == '') {

    header("Location: ./includes/login.php");
    die();
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Procesar Excel a Formulario</title>
    <link rel="icon" type="image/x-icon" href="../Resources/images/ECU911.png" />
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">

                        <?php
                        // require '../vendor/autoload.php';

                        // use PhpOffice\PhpSpreadsheet\IOFactory;

                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            if (isset($_FILES["excelfile"]) && $_FILES["excelfile"]["error"] === UPLOAD_ERR_OK) {
                                $archivo = $_FILES["excelfile"]["tmp_name"];
                                $spreadsheet = IOFactory::load($archivo);
                                $sheet = $spreadsheet->getActiveSheet();

                                // Validación básica del archivo (puedes agregar más validaciones)
                                $highestRow = $sheet->getHighestRow();
                                $highestColumn = $sheet->getHighestColumn();

                                if ($highestRow < 3 || $highestColumn < 'I') {
                                    echo "El archivo Excel no tiene el formato esperado.";
                                } else {
                                    // Obtener los nombres de los centros desde la segunda fila (asumiendo que están en la columna B)
                                    $centros = [];
                                    for ($row = 3; $row <= $highestRow; $row++) {
                                        $nombreCentro = $sheet->getCell('B' . $row)->getValue();
                                        if (!empty($nombreCentro)) {
                                            $centros[] = $nombreCentro;
                                        }
                                    }

                                    // Mapeo de celdas a campos del formulario
                                    $celdasBase = [
                                        'C' => 'conve_stra',
                                        'D' => 'comp_insti',
                                        'E' => 'opera_cam',
                                        'F' => 'ausentimo',
                                        'G' => 'mobile_locator',
                                        'H' => 'dispoci',
                                        'I' => 'com_estra',
                                    ];

                                    // IDs de los centros (ajústalos según tus datos)
                                    $idsCentros = [
                                        'ef48298f-cedf-4718-aa67-b097c80ef23b',
                                        'e1420c15-5f78-4815-8f27-c4df1793bc21',
                                        '664f5ba3-84e3-40f9-afc3-2fc1a152f88b',
                                        'e9003437-c828-465a-b0ec-b50f7395a2b2',
                                        '141ef0a0-4102-4f44-99bd-59e52d314e8c',
                                        'ed587387-5f05-4b86-8bdc-db81d95d5acf',
                                        'bc5d1e12-acf0-4771-8d91-8e0fe7d3cf71',
                                        '833397ec-c152-40e0-8a3b-536455dd1982',
                                        '2dbf73c0-17f0-44c3-bf3e-6cffe40264d1',
                                        '42a9c5de-2fa9-47cb-9707-a6bade35fdc5',
                                        'e3eb2897-7999-4418-bd04-d0a33e3a84f6',
                                        'caba5421-1581-49db-a4c2-2a8c3b39d238',
                                        '054c93ab-fc9c-435f-bf6b-0dabcf4cce5e',
                                        '525c8421-6961-47fd-a630-1819594c9ecc',
                                        '1fb38bb6-59bc-4272-8e08-0dcbf43516dc',
                                        'c9ffaf46-4ba8-4515-aac7-58bdc923f197'
                                    ];

                                    // Generar el formulario HTML
                                    echo '<form action="./procesar_centro.php" method="POST" id="formTabla">';
                                    echo '<input type="hidden" name="num_centros" value="' . count($centros) . '">';

                                    // Tabla con estilos Bootstrap
                                    // Contenedor para que la tabla sea responsiva
                                    echo '<table id="example2" class="table table-bordered table-hover table-responsive">';
                                    echo '<thead>'; // Encabezado de la tabla
                                    echo '<tr>';
                                    echo '<th>Centro</th>';
                                    echo '<th>% de Convenios Estratégicos Reportados (10%)</th>';
                                    echo '<th>% de Compromisos institucionales cumplidos (10%)</th>';
                                    echo '<th>% de Operatividad de cámaras (20%)</th>';
                                    echo '<th>% de Ausentismo Operativo (20%)</th>';
                                    echo '<th>% de Cumplimiento Mobile Locator (10%)</th>';
                                    echo '<th>% Incumplimiento de disposiciones (20%)</th>';
                                    echo '<th>Comunicación Estratégica (10%)</th>';
                                    echo '</tr>';
                                    echo '</thead>'; // Fin del encabezado

                                    echo '<tbody>'; // Cuerpo de la tabla
                                    for ($i = 0; $i < count($centros); $i++) {
                                        $rowIndex = $i + 3; // Fila correspondiente en el Excel
                                        $sufijo = '_' . ($i + 1); // Generar sufijo _1, _2, etc.
                                        $idCentro = $idsCentros[$i]; // Obtener el ID del centro correspondiente

                                        echo '<tr>';
                                        echo "<td>{$centros[$i]}</td>";

                                        // Campo oculto para el ID del centro
                                        echo "<input type='hidden' name='id_centro{$sufijo}' value='{$idCentro}'>";

                                        foreach ($celdasBase as $col => $campoBase) {
                                            $celda = $col . $rowIndex;
                                            $campo = $campoBase . $sufijo;

                                            $valor = $sheet->getCell($celda)->getValue();
                                            if (is_numeric($valor)) {
                                                $valor = floatval($valor) * 100;
                                            }
                                            echo "<td><input type='number' class='form-control' name='{$campo}' value='{$valor}' min='0' max='100' step='0.01' style='width: 100%;' readonly></td>";
                                        }

                                        echo '</tr>';
                                    }

                                    echo '</tbody>'; // Fin del cuerpo de la tabla
                                    echo '</table>';

                                    echo '<input type="submit" class="btn btn-block bg-gradient-success " name="registrar_centro" value="Subir informacion">';
                                    echo '</form>';
                                }
                            }
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- DataTables  & Plugins -->
    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": false,
            });
        });
    </script>
</body>
</html>