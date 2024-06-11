<?php
require_once '../includes/_db.php';
session_start();
error_reporting(0);
?>
<div class="card-header">
    <h2 class="mb-4 car ">Escala de calificaciones</h2>
</div>
<div class="card-body">
    <div class="card-body table-responsive p-0">
        <form action="../includes/para.php" method="POST">
            <table class="table table-hover text-nowrap" id="dynamicTable">
                <tr>
                    <th>Parámetro</th>
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

                // Valores predefinidos para la columna "Propiedades"
                $propiedades = ["Alto", "Plan mejora", "Bajo", "Deficiente"];
                $propiedadIndex = 0;

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
                        echo "<td><label>{$propiedades[$propiedadIndex]}</label></td>"; // Agrega la columna "Propiedades"

                        echo "</tr>\n";

                        $parametroAnterior = $parametroActual;
                        $propiedadIndex++;
                        if ($propiedadIndex >= count($propiedades)) {
                            $propiedadIndex = 0;
                        }
                    }
                }
                ?>
            </table>
            <input type="submit" value="Guardar" class="btn btn-success" name="guardar">
        </form>
    </div>
</div>