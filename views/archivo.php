<div class="col-md-6">
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
</div>