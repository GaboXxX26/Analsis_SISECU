<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "_db.php";
session_start();

if (isset($_POST['registrar_centro'])) {
    $num_centros = 16;

    try {
        // Preparar la consulta de inserción
        $consulta_insert = "INSERT INTO public.registros(id_registro, id_centro, conve_stra, comp_insti, opera_cam, ausentimo, mobile_locator, dispoci, com_estra, created_at)
                            VALUES (uuid_generate_v4(), :id_centro, :conve_stra, :comp_insti, :opera_cam, :ausentimo, :mobile_locator, :dispoci, :com_estra, NOW())";
        $stmt_insert = $pdo->prepare($consulta_insert);

        // Preparar la consulta de verificación
        $consulta_verificar = "SELECT COUNT(*) FROM public.registros WHERE id_centro = :id_centro AND DATE_TRUNC('month', created_at) = DATE_TRUNC('month', CURRENT_DATE)";
        $stmt_verificar = $pdo->prepare($consulta_verificar);

        for ($i = 1; $i <= $num_centros; $i++) {
            $id_centro = $_POST['id_centro_' . $i];
            $conve_stra = $_POST['conve_stra_' . $i];
            $comp_insti = $_POST['comp_insti_' . $i];
            $opera_cam = $_POST['opera_cam_' . $i];
            $ausentimo = $_POST['ausentimo_' . $i];
            $mobile_locator = $_POST['mobile_locator_' . $i];
            $dispoci = $_POST['dispoci_' . $i];
            $com_estra = $_POST['com_estra_' . $i];

            // Verificar si ya existe un registro para el centro en el mes actual
            $stmt_verificar->execute(['id_centro' => $id_centro]);
            $existe_registro = $stmt_verificar->fetchColumn();

            if ($existe_registro == 0) {
                // No existe registro para el centro en el mes actual, proceder con la inserción
                $stmt_insert->execute([
                    'id_centro' => $id_centro,
                    'conve_stra' => $conve_stra,
                    'comp_insti' => $comp_insti,
                    'opera_cam' => $opera_cam,
                    'ausentimo' => $ausentimo,
                    'mobile_locator' => $mobile_locator,
                    'dispoci' => $dispoci,
                    'com_estra' => $com_estra
                ]);
            } else {
                // Ya existe un registro para el centro en el mes actual, mostrar mensaje de advertencia
                echo "<script>alert('Ya existe un registro para el centro $id_centro en el mes actual.'); window.history.back();</script>";
            }
        }

        // Alerta de éxito (usando JavaScript)
        echo "<script>
        alert('Registros guardados correctamente.');
        setTimeout(function() {";

        $rol_id = $_SESSION['rol_id'];
        $paginas_redireccion = [
            'add38db6-1687-4e57-a763-a959400d9da2' => 'user.php',
            'e17a74c4-9627-443c-b020-23dc4818b718' => 'lector.php',
            'ad2e8033-4a14-40d6-a999-1f1c6467a5e6' => 'analista.php'
        ];

        if (array_key_exists($rol_id, $paginas_redireccion)) {
            echo "window.location.href = '../views/" . $paginas_redireccion[$rol_id] . "';";
        } else {
            echo "window.location.href = '../views/acceso_denegado.php';";
        }

        echo "}, 1000); 
    </script>";
    } catch (PDOException $e) {
        // Manejo de errores en la inserción
        echo "<script>alert('Error al guardar los registros: " . $e->getMessage() . "'); window.history.back();</script>";
        // Opcional: registrar el error en un archivo de registro
    }
}

