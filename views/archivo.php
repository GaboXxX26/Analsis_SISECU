<div class="col-md-6">
    <div class="card card-primary">
        <form action="../includes/procesar_archivo.php" method="post" enctype="multipart/form-data">
            <div class="card-body">
                <div class="form-group">
                    <label for="formFile" class="form-label">Seleciona un archivo excel:</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" id="excelfile" name="excelfile" accept=".xls, .xlsx" required>
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