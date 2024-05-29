<!-- <div class="wrapper">
    
    <div class="content-wrapper">

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">

                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title">Ambato</h3>

                            </div>
                            <div class="card-body">
                                <canvas id="myDoughnutChart" style="
                        min-height: 250px;
                        height: 250px;
                        max-height: 250px;
                        max-width: 100%;
"></canvas>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
    
        </section>

    </div>
</div> -->
<?php
include "../includes/_db.php";

$consulta = "SELECT c.nombre_centro, 
SUM(r.conve_stra) AS suma_conve_stra, 
SUM(r.comp_insti) AS suma_comp_insti,
SUM(r.opera_cam) AS suma_opera_cam,
SUM(r.ausentimo) AS suma_ausentimo,
SUM(r.mobile_locator) AS suma_mobile_locator,
SUM(r.dispoci) AS suma_dispoci,
SUM(r.com_estra) AS suma_com_estra,
COUNT(*) AS num_repeticiones
FROM public.registros AS r 
LEFT JOIN centro as c ON c.id_centro = r.id_centro
GROUP BY c.nombre_centro
ORDER BY c.nombre_centro";
$stmt = $pdo->query($consulta);

// Encabezados de la tabla modificados
?>
<table id="example2" class="table table-bordered table-hover table-responsive">
    <thead>
        <tr>
            <th>Centro</th>
            <th>Gestión Interinstitucional (20%)</th>
            <th>Gestión Operativa (50%)</th>
            <th>Gestión Estratégica (30%)</th>
            <th>Total Cumplimiento de Gestión (100%)</th>
        </tr>
    </thead>
    <tbody>
        <?php
        require_once '../includes/_db.php';

        // Obtener los parámetros ordenados por valor descendente
        $consulta_parametros = "SELECT parametro, color FROM public.parametros ORDER BY parametro DESC";
        $stmt_parametros = $pdo->query($consulta_parametros);
        $parametros = $stmt_parametros->fetchAll(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row['nombre_centro'] . "</td>";

                // Calcular los promedios sin multiplicar por los porcentajes
                $promedio_gestion = ($row['suma_conve_stra'] + $row['suma_comp_insti']) / $row['num_repeticiones'];
                $promedio_operativa = ($row['suma_opera_cam'] + $row['suma_ausentimo'] + $row['suma_mobile_locator']) / $row['num_repeticiones'];
                $promedio_calidad = ($row['suma_dispoci'] + $row['suma_com_estra']) / $row['num_repeticiones'];

                $promedio_gestion_formatted = number_format($promedio_gestion, 2);
                $promedio_operativa_formatted = number_format($promedio_operativa, 2);
                $promedio_calidad_formatted = number_format($promedio_calidad, 2);

                echo "<td>" . $promedio_gestion_formatted . "</td>";
                echo "<td>" . $promedio_operativa_formatted . "</td>";
                echo "<td>" . $promedio_calidad_formatted . "</td>";

                // Calcular la suma total del centro
                $suma_total_centro = $promedio_gestion + $promedio_operativa + $promedio_calidad;

                // Aplicar color de fondo según el valor del total
                $color_fondo = '';
                foreach ($parametros as $index => $parametro) {
                    if ($index == 0 && $suma_total_centro >= $parametro['parametro']) {
                        $color_fondo = $parametro['color'];
                        break;
                    } elseif (isset($parametros[$index + 1])) {
                        if ($suma_total_centro < $parametro['parametro'] && $suma_total_centro >= $parametros[$index + 1]['parametro']) {
                            $color_fondo = $parametros[$index + 1]['color'];
                            break;
                        }
                    } elseif ($index == count($parametros) - 1 && $suma_total_centro < $parametro['parametro']) {
                        $color_fondo = $parametro['color'];
                        break;
                    }
                }

                echo "<td style='background-color: " . $color_fondo . "'>" . number_format($suma_total_centro, 2) . "</td>";
                echo "</tr>\n";
            }
        } else {
        ?>
            <tr class="text-center">
                <td colspan="5">No existen registros</td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>