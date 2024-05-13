<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "_db.php";

if (isset($_POST['registrar_centro'])) {
    $num_centros = 1; // Número total de centros

    // Preparar la consulta para insertar los datos de los centros
    $consulta = "INSERT INTO public.registros(id_registro, id_centro, conve_stra, comp_insti, opera_cam, ausentimo, mobile_locator, dispoci, com_estra)
                 VALUES (uuid_generate_v4(), :id_centro, :conve_stra, :comp_insti, :opera_cam, :ausentimo, :mobile_locator, :dispoci, :com_estra)";

    $stmt = $pdo->prepare($consulta);

    // Iterar sobre cada centro y ejecutar la consulta con los datos correspondientes
    for ($i = 1; $i <= $num_centros; $i++) {
        $id_centro = $_POST['id_centro_' . $i];
        $conve_stra = $_POST['conve_stra_' . $i];
        $comp_insti = $_POST['comp_insti_' . $i];
        $opera_cam = $_POST['opera_cam_' . $i];
        $ausentimo = $_POST['ausentimo_' . $i];
        $mobile_locator = $_POST['mobile_locator_' . $i];
        $dispoci = $_POST['dispoci_' . $i];
        $com_estra = $_POST['com_estra_' . $i];

        $stmt->execute([
            'id_centro' => $id_centro,
            'conve_stra' => $conve_stra,
            'comp_insti' => $comp_insti,
            'opera_cam' => $opera_cam,
            'ausentimo' => $ausentimo,
            'mobile_locator' => $mobile_locator,
            'dispoci' => $dispoci,
            'com_estra' => $com_estra
        ]);
    }

    header('Location: ../views/user.php');
}

// if (isset($_POST['registrar_centro'])) {
//     if (
//         strlen($_POST['id_centro']) >= 1
//         &&strlen($_POST['conve_stra']) >= 1
//         && strlen($_POST['comp_insti']) >= 1
//         && strlen($_POST['opera_cam']) >= 1
//         && strlen($_POST['ausentimo']) >= 1
//         && strlen($_POST['mobile_locator']) >= 1
//         && strlen($_POST['dispoci']) >= 1
//         && strlen($_POST['com_estra']) >= 1
//     ) {
//         $id_centro=trim($_POST['id_centro']);
//         $conve_stra = trim($_POST['conve_stra']);
//         $comp_insti = trim($_POST['comp_insti']);
//         $opera_cam = trim($_POST['opera_cam']);
//         $ausentimo = trim($_POST['ausentimo']);
//         $mobile_locator = trim($_POST['mobile_locator']);
//         $dispoci = trim($_POST['dispoci']);
//         $com_estra = trim($_POST['com_estra']);

//         $consulta="INSERT INTO public.registros(id_registro, id_centro,conve_stra,comp_insti,opera_cam,ausentimo,mobile_locator,dispoci,com_estra)
//         VALUES (uuid_generate_v4(),:id_centro,:conve_stra,:comp_insti,:opera_cam,:ausentimo,:mobile_locator,:dispoci,:com_estra)";

//         $stmt = $pdo->prepare($consulta);
//         $stmt->execute([
//             'id_centro'=>$id_centro,
//             'conve_stra' => $conve_stra,
//             'comp_insti' => $comp_insti,
//             'opera_cam' => $opera_cam,
//             'ausentimo' => $ausentimo,
//             'mobile_locator' => $mobile_locator,
//             'dispoci' => $dispoci,
//             'com_estra' => $com_estra
//         ]);

//         header('Location: ../views/user.php');
//     }
// }
