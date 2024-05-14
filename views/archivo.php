<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="card card-primary">
            <form action="../includes/procesar_archivo.php" method="post" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="form-group">
                        <label for="excelfile">Archivo Excel</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="excelfile" name="excelfile">
                                <label class="custom-file-label" for="excelfile">Elija un archivo</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Verificar</button>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </div>
    <!-- /.control-sidebar -->
    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- bs-custom-file-input -->
    <script src="../../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
    <!-- Page specific script -->
    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
    <!-- <script>
        // Obtiene el elemento de entrada de archivo y la etiqueta
        const inputFile = document.getElementById('excelfile');
        const labelFile = document.querySelector('.custom-file-label');

        // Agrega un evento "change" para cuando se selecciona un archivo
        inputFile.addEventListener('change', function() {
            // Obtiene el nombre del archivo seleccionado
            const fileName = this.files[0].name;

            // Actualiza el texto de la etiqueta con el nombre del archivo
            labelFile.textContent = fileName;
        });
    </script> -->

</body>

</html>