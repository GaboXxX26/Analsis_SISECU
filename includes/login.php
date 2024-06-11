<!DOCTYPE html>
<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="../Resources/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Cuadro Mando y Gestion</title>
    <meta name="description" content="" />
    <link rel="icon" type="image/x-icon" href="../Resources/images/ECU911.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../Resources/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="../Resources/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../Resources/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../Resources/css/demo.css" />
    <link rel="stylesheet" href="../Resources/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../Resources/vendor/css/pages/page-auth.css" />
    <script src="../Resources/vendor/js/helpers.js"></script>
    <script src="../Resources/js/config.js"></script>
</head>

<body>
    <!-- Content -->
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card">
                    <img class="img-login" src="../Resources/images/ECU911.png" />
                    <h1 class="custom-heading red-first-letter text-center">CMG</h1>
                    <br />
                    <h2 class="custom-heading text-center">
                        <span class="red-first-letter">C</span>uadro
                        <span class="red-first-letter">M</span>ando y
                        <span class="red-first-letter">G</span>estión
                    </h2>
                    <h2 class="custom-heading text-gray text-center">INICIAR SESION</h2>
                    <div class="card-body">
                        <form id="formAuthentication" class="mb-3" action="_functions.php" method="POST">
                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo:</label><br>
                                <input type="text" name="correo" id="correo" class="form-control" placeholder="Ingresa tu correo institucional" required>
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label for="password" class="form-label">Contraseña:</label><br>
                                    <a href="../views/recuperar_clave.php">
                                        <small>¿Has olvidado la contraseña?</small>
                                    </a>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password" aria-describedby="password" require />
                                    <input type="hidden" name="accion" value="acceso_user">
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide fa-regular fa-eye"></i></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember-me" />
                                    <label class="form-check-label" for="remember-me"> Recordar </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="submit" class="btn btn-primary d-grid w-100s swalDefaultSuccess" value="Ingresar">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../Resources/vendor/libs/jquery/jquery.js"></script>
    <script src="../Resources/vendor/libs/popper/popper.js"></script>
    <script src="../Resources/vendor/js/bootstrap.js"></script>
    <script src="../Resources/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../Resources/vendor/js/menu.js"></script>
    <script src="../Resources/js/main.js"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script>
        $(function() {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 10000
            });

            $('.swalDefaultSuccess').click(function() {
                Toast.fire({
                    icon: 'success',
                    title: 'Correo electrónico enviado con tu contraseña.'
                })
            });

        });
    </script>
</body>

</html>