<?php
include "./includes/_db.php";
session_start();
error_reporting(0);

// Obtener el mes, año, trimestre, rango de fechas y centro seleccionados
$selectedMonth = isset($_GET['month']) ? $_GET['month'] : '';
$selectedYear = isset($_GET['year']) ? $_GET['year'] : date('Y');
$selectedTrimestre = isset($_GET['trimestre']) ? $_GET['trimestre'] : '';
$selectedCentro = isset($_GET['centro']) ? $_GET['centro'] : 'ef48298f-cedf-4718-aa67-b097c80ef23b';
$selectedRango = isset($_GET['filterType']) && $_GET['filterType'] == 'rango';
$fechaInicio = $selectedRango && isset($_GET['fechaInicio']) ? $_GET['fechaInicio'] : '';
$fechaFin = $selectedRango && isset($_GET['fechaFin']) ? $_GET['fechaFin'] : '';

// Construir la consulta SQL con condiciones opcionales
$consulta = "SELECT r.id_registro,c.nombre_centro, r.conve_stra, r.comp_insti, r.opera_cam, r.ausentimo, r.mobile_locator, r.dispoci, r.com_estra,TO_CHAR(r.created_at, 'TMMonth') AS mes_creado 
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

$consulta .= " ORDER BY c.nombre_centro";

$stmt = $pdo->prepare($consulta);
$stmt->execute($params);
?>

<div class="container mt-5">
    <h2 class="mb-4">Filtrar Registros por Mes, Año, Trimestre y Centro</h2>
    <form id="filterForm" class="mb-4" method="GET">
        <div class="form-group">
            <label for="centroSelect">Seleccione un centro:</label>
            <select id="centroSelect" name="centro" class="form-control" required>
                <option value="" disabled selected>Seleccione una centro </option>
                <option value="ef48298f-cedf-4718-aa67-b097c80ef23b" <?php echo ($usuario['id_centro'] == 'ef48298f-cedf-4718-aa67-b097c80ef23b') ? 'selected' : ''; ?>>Ambato</option>
                <option value="664f5ba3-84e3-40f9-afc3-2fc1a152f88b" <?php echo ($usuario['id_centro'] == '664f5ba3-84e3-40f9-afc3-2fc1a152f88b') ? 'selected' : ''; ?>>Cuenca</option>
                <option value="ed587387-5f05-4b86-8bdc-db81d95d5acf" <?php echo ($usuario['id_centro'] == 'ed587387-5f05-4b86-8bdc-db81d95d5acf') ? 'selected' : ''; ?>>Loja</option>
                <option value="e9003437-c828-465a-b0ec-b50f7395a2b2" <?php echo ($usuario['id_centro'] == 'e9003437-c828-465a-b0ec-b50f7395a2b2') ? 'selected' : ''; ?>>Esmeraldas</option>
                <option value="e3eb2897-7999-4418-bd04-d0a33e3a84f6" <?php echo ($usuario['id_centro'] == 'e3eb2897-7999-4418-bd04-d0a33e3a84f6') ? 'selected' : ''; ?>>Quito</option>
                <option value="e1420c15-5f78-4815-8f27-c4df1793bc21" <?php echo ($usuario['id_centro'] == 'e1420c15-5f78-4815-8f27-c4df1793bc21') ? 'selected' : ''; ?>>Babahoyo</option>
                <option value="caba5421-1581-49db-a4c2-2a8c3b39d238" <?php echo ($usuario['id_centro'] == 'caba5421-1581-49db-a4c2-2a8c3b39d238') ? 'selected' : ''; ?>>Riobamba</option>
                <option value="c9ffaf46-4ba8-4515-aac7-58bdc923f197" <?php echo ($usuario['id_centro'] == 'c9ffaf46-4ba8-4515-aac7-58bdc923f197') ? 'selected' : ''; ?>>Tulcán</option>
                <option value="833397ec-c152-40e0-8a3b-536455dd1982" <?php echo ($usuario['id_centro'] == '833397ec-c152-40e0-8a3b-536455dd1982') ? 'selected' : ''; ?>>Machala</option>
                <option value="525c8421-6961-47fd-a630-1819594c9ecc" <?php echo ($usuario['id_centro'] == '525c8421-6961-47fd-a630-1819594c9ecc') ? 'selected' : ''; ?>>San Cristóbal</option>
                <option value="42a9c5de-2fa9-47cb-9707-a6bade35fdc5" <?php echo ($usuario['id_centro'] == '42a9c5de-2fa9-47cb-9707-a6bade35fdc5') ? 'selected' : ''; ?>>Portoviejo</option>
                <option value="2dbf73c0-17f0-44c3-bf3e-6cffe40264d1" <?php echo ($usuario['id_centro'] == '2dbf73c0-17f0-44c3-bf3e-6cffe40264d1') ? 'selected' : ''; ?>>Nueva Loja</option>
                <option value="1fb38bb6-59bc-4272-8e08-0dcbf43516dc" <?php echo ($usuario['id_centro'] == '1fb38bb6-59bc-4272-8e08-0dcbf43516dc') ? 'selected' : ''; ?>>Santo Domingo</option>
                <option value="054c93ab-fc9c-435f-bf6b-0dabcf4cce5e" <?php echo ($usuario['id_centro'] == '054c93ab-fc9c-435f-bf6b-0dabcf4cce5e') ? 'selected' : ''; ?>>Samborondón</option>
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
    <form action="./includes/_functions.php" method="POST">
    <table id="example1" class="table table-bordered table-striped table-responsive ">
        <thead>
            <tr>
                <th colspan="2">Datos Generales</th>
                <th colspan="2">Indicadores de Gestión (20%)</th>
                <th colspan="3">Indicadores de Gestión Operativa (100%)</th>
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
                    echo "<td><input type='number' name='conve_stra[]' value='" . $row['conve_stra'] . "' min='0' max='100' step='0.01'></td>";
                    echo "<td><input type='number' name='comp_insti[]' value='" . $row['comp_insti'] . "' min='0' max='100' step='0.01'></td>";
                    echo "<td><input type='number' name='opera_cam[]' value='" . $row['opera_cam'] . "' min='0' max='100' step='0.01'></td>";
                    echo "<td><input type='number' name='ausentimo[]' value='" . $row['ausentimo'] . "' min='0' max='100' step='0.01'></td>";
                    echo "<td><input type='number' name='mobile_locator[]' value='" . $row['mobile_locator'] . "' min='0' max='100' step='0.01'></td>";
                    echo "<td><input type='number' name='dispoci[]' value='" . $row['dispoci'] . "' min='0' max='100' step='0.01'></td>";
                    echo "<td><input type='number' name='com_estra[]' value='" . $row['com_estra'] . "' min='0' max='100'step='0.01'></td>";

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