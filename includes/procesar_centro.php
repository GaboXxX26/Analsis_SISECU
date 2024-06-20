<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "_db.php";

if (isset($_POST['registrar_centro'])) {
    $num_centros = 16;

    try {
        // Preparar la consulta de inserción
        $consulta_insert = "INSERT INTO public.registros( id_centro, conve_stra, comp_insti, opera_cam, ausentimo, mobile_locator, dispoci, com_estra, obv_conve_stra, obv_comp_insti, obv_opera_cam, obv_ausentimo, obv_mobile_locator, obv_dispoci, obv_com_estra, created_at)
                            VALUES (:id_centro, :conve_stra, :comp_insti, :opera_cam, :ausentimo, :mobile_locator, :dispoci, :com_estra, :obv_conve_stra, :obv_comp_insti, :obv_opera_cam, :obv_ausentimo, :obv_mobile_locator, :obv_dispoci, :obv_com_estra, NOW())";
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
            $obv_conve_stra = $_POST['observacion_obv_conve_stra_' . $i];
            $obv_comp_insti = $_POST['observacion_obv_comp_insti_' . $i];
            $obv_opera_cam = $_POST['observacion_obv_opera_cam_' . $i];
            $obv_ausentimo = $_POST['observacion_obv_ausentimo_' . $i];
            $obv_mobile_locator = $_POST['observacion_obv_mobile_locator_' . $i];
            $obv_dispoci = $_POST['observacion_obv_dispoci_' . $i];
            $obv_com_estra = $_POST['observacion_obv_com_estra_' . $i];

            // Verificar si ya existe un registro para el centro en el mes actual
            $stmt_verificar->execute(['id_centro' => $id_centro]);
            $existe_registro = $stmt_verificar->fetchColumn();

            if ($existe_registro == 0) {

                $stmt_insert->execute([
                    'id_centro' => $id_centro,
                    'conve_stra' => $conve_stra,
                    'comp_insti' => $comp_insti,
                    'opera_cam' => $opera_cam,
                    'ausentimo' => $ausentimo,
                    'mobile_locator' => $mobile_locator,
                    'dispoci' => $dispoci,
                    'com_estra' => $com_estra,
                    'obv_conve_stra' => $obv_conve_stra,
                    'obv_comp_insti' => $obv_comp_insti,
                    'obv_opera_cam' => $obv_opera_cam,
                    'obv_ausentimo' => $obv_ausentimo,
                    'obv_mobile_locator' => $obv_mobile_locator,
                    'obv_dispoci' => $obv_dispoci,
                    'obv_com_estra' => $obv_com_estra
                ]);
            } else {

                echo "<script>alert('Ya existe un registro para el centro $id_centro en el mes actual.'); window.history.back();</script>";
            }
        }

        // Alerta de éxito (usando JavaScript)
        echo "<script>window.location.href = '../views/user.php';</script>";
    } catch (PDOException $e) {

        echo "<script>alert('Error al guardar los registros: " . $e->getMessage() . "'); window.history.back();</script>";
    }
}
