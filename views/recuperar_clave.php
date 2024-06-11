<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recuperar Clave</title>
    <link rel="icon" type="image/x-icon" href="../Resources/images/ECU911.png" />
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">

    <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="../includes/login.php" class="h1"><b>SIS ECU</b>911</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">No recuerdas tu contraseña? Digita el correo registrado, se enviar un correo con tu contraseña.</p>
                <form action="../includes/_functions.php" method="post">
                    <div class="input-group mb-3">
                        <input type="text" name="correo" id="correo" class="form-control" placeholder="Ingresa tu correo institucional" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" name="accion" value="solicitar_recuperacion">
                            <button type="submit" class="btn btn-success swalDefaultSuccess" id="enviarBtn">Enviar correo </button>
                        </div>
                    </div>
                </form>
                <p class="mt-3 mb-1">
                    <a href="../includes/login.php">Inicio de sesion</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->
    <!-- jQuery -->
    <script src="../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.min.js"></script>
    <script src="../plugins/sweetalert2/sweetalert2.min.js"></script>

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

    <script>
        document.getElementById("enviarBtn").addEventListener("click", function(event) {
            event.preventDefault(); // Evitar el envío automático del formulario
            this.disabled = true;
            this.innerHTML = "Enviando...";

            // Enviar el formulario manualmente
            this.form.submit();
        });
    </script>
</body>

</html>