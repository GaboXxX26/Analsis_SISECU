
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "_db.php";
session_start();

if (isset($_POST['registrar_centro'])) {
    $num_centros = 16; // Número total de centros

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
    // Redirección basada en roles
    $rol_id = $_SESSION['rol_id']; // Obtener el rol del usuario de la sesión

    // Definir páginas de redirección por rol (puedes ajustar esto según tus necesidades)
    $paginas_redireccion = [
        'add38db6-1687-4e57-a763-a959400d9da2' => 'user.php',  // Rol de administrador
        'e17a74c4-9627-443c-b020-23dc4818b718' => 'lector.php',   // Rol de lector
        'ad2e8033-4a14-40d6-a999-1f1c6467a5e6' => 'analista.php' // Rol de analista
    ];

    // Verificar si el rol del usuario está definido en el arreglo y redireccionar
    if (array_key_exists($rol_id, $paginas_redireccion)) {
        header('Location: ../views/' . $paginas_redireccion[$rol_id]);
        exit; // Importante: detener la ejecución del script después de la redirección
    } else {
        // Redirigir a una página de error si el rol no está definido
        header('Location: ../views/error.php'); 
        exit; // Detener la ejecución
    }

}
