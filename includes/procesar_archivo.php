<?php
require '../vendor/autoload.php'; // Incluir el autoload de Composer

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $archivo = $_FILES["excelfile"]["tmp_name"];

    if (empty($archivo)) {
        echo "No se ha seleccionado ningún archivo.";
    } else {
        $spreadsheet = IOFactory::load($archivo);
        $sheet = $spreadsheet->getActiveSheet();

        $startRow = 3; // Fila inicial
        $startColumn = 'C'; // Columna inicial
        $endColumn = 'I';  //Columna Final
        $endRow = 18; // Fila final

        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        for ($row = $startRow; $row <= $endRow; $row++) {
            for ($col = $startColumn; $col <= $endColumn; $col++) {
                $cellValue = $sheet->getCell($col . $row)->getValue();
                $cellValue = $cellValue * 100;
                // Utiliza $cellValue como desees
                echo "Fila: $row, Columna: $col, Valor: $cellValue<br>";
            }
        }
    }
}
