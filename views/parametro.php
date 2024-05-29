<?php
require_once '../includes/_db.php';
session_start();
error_reporting(0);
?>
<div class="card-header">
    <h2 class="mb-4 car ">Escala de calificaciones</h2>
</div>
<!-- <div class="card-body table-responsive p-0">
    <form action="../includes/para.php" method="POST">
        <table class="table table-hover text-nowrap" id="dynamicTable">
            <tr>
                <th>Parametro</th>
                <th>Color</th>
                <th>Propiedades</th>
            </tr>
            <?php for ($i = 1; $i <= 4; $i++) : ?>
                <tr>
                    <td><input type="number" id="parametro_<?php echo $i; ?>" name="parametro_<?php echo $i; ?>" class="form-control"></td>
                    <td><input type="color" id="color_<?php echo $i; ?>" name="color_<?php echo $i; ?>" class="form-control"></td>
                    <td><input type="text" id="nombre_<?php echo $i; ?>" name="nombre_<?php echo $i; ?>" class="form-control"></td>
                </tr>
            <?php endfor; ?>
        </table>
        <input type="submit" value="Guardar" class="btn btn-success" name="parametros">
    </form>
</div> -->
<div class="card-body table-responsive p-0">
    <form action="../includes/para.php" method="POST">
        <table class="table table-hover text-nowrap" id="dynamicTable">
            <tr>
                <th>Parametro</th>
                <th></th>
                <th></th>
                <th>Propiedades</th>
            </tr>
            <?php
            // ... (código para establecer la conexión a la base de datos $pdo)
            global $pdo;
            $consulta = "SELECT * FROM public.parametros";
            $stmt = $pdo->query($consulta);

            $parametroAnterior = 100; // Valor inicial para el primer parámetro

            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $parametroActual = $row['parametro'];
                    if ($parametroAnterior == 100) {
                        $textoLabel = "{$parametroActual}% a 100%";
                    } else {
                        $textoLabel = "{$parametroActual}% a {$parametroAnterior}% ";
                    }

                    echo "<tr>";
                    echo "<td><input type='number' class='form-control' name='parametro_{$row['id']}' value='" . $row['parametro'] . "' min='0' max='100' ></td>";
                    echo "<td><label >$textoLabel</label></td>";
                    echo "<td><input type='color' class='form-control' name='color_{$row['id']}' value='" . $row['color'] . "'></td>";
                    echo "<td><label >{$row['nombre']}</label></td>";
                    echo "</tr>\n";

                    $parametroAnterior = $parametroActual; // Actualizar para el siguiente parámetro
                }
            }
            ?>
        </table>

        <input type="submit" value="Guardar" class="btn btn-success" name="guardar">
    </form>

</div>