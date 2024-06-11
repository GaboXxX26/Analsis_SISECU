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

                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            if (isset($_FILES["excelfile"]) && $_FILES["excelfile"]["error"] === UPLOAD_ERR_OK) {
                                $archivo = $_FILES["excelfile"]["tmp_name"];
                                $spreadsheet = IOFactory::load($archivo);

                                // Procesar las hojas
                                $sheet1 = $spreadsheet->getSheetByName('Valores');
                                $sheet2 = $spreadsheet->getSheetByName('Observaciones');

                                // Validación de la primera hoja
                                $validacionExitosa = true;
                                $erroresValidacion = [];

                                try {
                                    // Validar celdas vacías después de la columna I en la primera hoja
                                    $highestRow1 = $sheet1->getHighestRow();
                                    $highestColumn1 = $sheet1->getHighestColumn();

                                    for ($row = 3; $row <= $highestRow1; $row++) {
                                        for ($col = 'J'; $col <= $highestColumn1; $col++) {
                                            $valorCelda = $sheet1->getCell($col . $row)->getValue();
                                            if (!empty($valorCelda)) {
                                                $erroresValidacion[] = "Error: Se encontraron datos después de la columna I en la celda " . $col . $row;
                                                throw new Exception("Error: Se encontraron datos después de la columna I.");
                                            }
                                            // Validación adicional (ejemplo: verificar si la celda contiene un valor específico)
                                            if ($valorCelda !== null && $valorCelda !== 'valor_esperado') {
                                                $erroresValidacion[] = "Error: El valor en la celda " . $col . $row . " no es el esperado.";
                                                throw new Exception("Error: El valor en la celda " . $col . $row . " no es el esperado.");
                                            }
                                        }
                                    }

                                    // Validar orden de los centros en la primera hoja
                                    $centrosEsperados = ['Ambato', 'Babahoyo', 'Cuenca', 'Esmeraldas', 'Ibarra', 'Loja', 'Macas', 'Machala', 'Nueva Loja', 'Portoviejo', 'Quito', 'Riobamba', 'Samborondón', 'San Cristóbal', 'Santo Domingo', 'Tulcán'];
                                    $centrosEncontrados = [];
                                    for ($row = 3; $row <= 18; $row++) {
                                        $centrosEncontrados[] = $sheet1->getCell('B' . $row)->getValue();
                                    }

                                    if ($centrosEncontrados !== $centrosEsperados) {
                                        $erroresValidacion[] = "Error: El orden de los centros no es el esperado.";
                                        throw new Exception("Error: El orden de los centros no es el esperado.");
                                    }
                                } catch (Exception $e) {
                                    $validacionExitosa = false;
                                }

                                echo '<input type="hidden" id="validacion-exitosa" value="' . ($validacionExitosa ? 'true' : 'false') . '">';
                                echo '<input type="hidden" id="errores-validacion" value="' . htmlentities(json_encode($erroresValidacion)) . '">';

                                // Validación básica del archivo (puedes agregar más validaciones)
                                if ($highestRow1 < 3 || $highestColumn1 < 'I') {
                                    echo "El archivo Excel no tiene el formato esperado.";
                                } else {
                                    // Obtener los nombres de los centros desde la primera hoja (asumiendo que están en la columna B)
                                    $centros = [];
                                    for ($row = 3; $row <= $highestRow1; $row++) {
                                        $nombreCentro = $sheet1->getCell('B' . $row)->getValue();
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

                                    // Mapeo de celdas a campos del formulario para la segunda hoja
                                    $celdasObservaciones = [
                                        'C' => 'obv_conve_stra',
                                        'D' => 'obv_comp_insti',
                                        'E' => 'obv_opera_cam',
                                        'F' => 'obv_ausentimo',
                                        'G' => 'obv_mobile_locator',
                                        'H' => 'obv_dispoci',
                                        'I' => 'obv_com_estra',
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

                                    // Procesar la segunda hoja
                                    $sheet2 = $spreadsheet->getSheetByName('Observaciones');

                                    // Mapeo de celdas a campos del formulario para la segunda hoja
                                    $celdasObservaciones = [
                                        'C' => 'obv_conve_stra',
                                        'D' => 'obv_comp_insti',
                                        'E' => 'obv_opera_cam',
                                        'F' => 'obv_ausentimo',
                                        'G' => 'obv_mobile_locator',
                                        'H' => 'obv_dispoci',
                                        'I' => 'obv_com_estra',
                                    ];

                                    // Obtener los datos de la segunda hoja
                                    $datosObservaciones = [];
                                    $highestRow2 = $sheet2->getHighestRow();
                                    for ($row = 3; $row <= $highestRow2; $row++) { // Cambiado a $row = 3
                                        $observacion = [];
                                        foreach ($celdasObservaciones as $col => $campo) {
                                            $observacion[$campo] = $sheet2->getCell($col . $row)->getValue();
                                        }
                                        $datosObservaciones[] = $observacion;
                                    }

                                    // Generar el formulario HTML
                                    echo '<h2 class="mb-4">Indicadores y Observaciones desde el excel</h2>';
                                    echo '<label for="centroSelect">Verifique que los datos sean correctos:</label>';
                                    echo '<form action="./procesar_centro.php" method="POST" id="formTabla">';
                                    echo '<input type="hidden" name="num_centros" value="' . count($centros) . '">';

                                    echo '<table id="example2" class="table table-bordered table-hover table-responsive">';
                                    echo '<thead>';
                                    echo '<tr>';
                                    echo '<th>Centro</th>';
                                    echo '<th>% de Convenios Estratégicos Reportados (10%)</th>';
                                    echo '<th>% de Compromisos institucionales cumplidos (10%)</th>';
                                    echo '<th>% de Operatividad de cámaras (20%)</th>';
                                    echo '<th>% de Ausentismo Operativo (20%)</th>';
                                    echo '<th>% de Cumplimiento Mobile Locator (10%)</th>';
                                    echo '<th>% Incumplimiento de disposiciones (20%)</th>';
                                    echo '<th>Comunicación Estratégica (10%)</th>';
                                    echo '<th>% de Convenios Estratégicos Reportados (10%) - Observaciones</th>';
                                    echo '<th>% de Compromisos institucionales cumplidos (10%) - Observaciones</th>';
                                    echo '<th>% de Operatividad de cámaras (20%) - Observaciones</th>';
                                    echo '<th>% de Ausentismo Operativo (20%) - Observaciones</th>';
                                    echo '<th>% de Cumplimiento Mobile Locator (10%) - Observaciones</th>';
                                    echo '<th>% Incumplimiento de disposiciones (20%) - Observaciones</th>';
                                    echo '<th>Comunicación Estratégica (10%) - Observaciones</th>';
                                    echo '</tr>';
                                    echo '</thead>';

                                    echo '<tbody>';
                                    for ($i = 0; $i < count($centros); $i++) {
                                        $rowIndex = $i + 3;
                                        $sufijo = '_' . ($i + 1);
                                        $idCentro = $idsCentros[$i];

                                        echo '<tr>';
                                        echo "<td>{$centros[$i]}</td>";

                                        echo "<input type='hidden' name='id_centro{$sufijo}' value='{$idCentro}'>";

                                        foreach ($celdasBase as $col => $campoBase) {
                                            $celda = $col . $rowIndex;
                                            $campo = $campoBase . $sufijo;

                                            $valor = $sheet1->getCell($celda)->getValue();
                                            if (is_numeric($valor)) {
                                                $valor = floatval($valor) * 100;
                                            }
                                            echo "<td><input type='number' class='form-control' name='{$campo}' value='{$valor}' min='0' max='100' step='0.01' style='width: 100%;'></td>";
                                        }

                                        foreach ($celdasObservaciones as $col => $campo) {
                                            $valor = $datosObservaciones[$i][$campo];
                                            echo "<td>{$valor}</td>";

                                            // Nombre correcto para el campo oculto
                                            $campoHidden = "observacion_" . $campo . "_" . ($i + 1); // Corregido el sufijo
                                            echo "<input type='hidden' name='{$campoHidden}' value='{$valor}'>";
                                        }

                                        echo '</tr>';
                                    }

                                    echo '</tbody>';
                                    echo '</table>';

                                    echo '<input type="submit" class="btn btn-block bg-gradient-success" name="registrar_centro" value="Subir información">';
                                    echo '<a class="btn btn-block bg-gradient-danger" href="javascript:void(0);" onclick="history.back();">Cancelar</a>';
                                    echo '</form>';
                                }
                            } else {
                                echo "Error al subir el archivo.";
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const validacionExitosa = document.getElementById('validacion-exitosa').value === 'true';
            if (!validacionExitosa) {
                const errores = JSON.parse(document.getElementById('errores-validacion').value);
                alert('Error en la validación del archivo:\n' + errores.join('\n'));
                // Redirigir a la página anterior
                history.back();
            }
        });
    </script>


</body>

</html>