<?php
include "../includes/_db.php";
session_start();
error_reporting(0);

$validar = $_SESSION['correo'];

if ($validar == null || $validar == '') {

  header("Location: ./includes/login.php");
  die();
}
?>
<form>
  <table id="example2" class="table table-bordered table-hover table-responsive">
    <tr>
      <th class="datos-generales" colspan="2">Datos Generales</th>
      <th class="indicadoresG" colspan="2">Indicadores de Gestión (20%)</th>
      <th class="indicadoresO" colspan="3">
        Indicadores de Gestión Operativa (50%)
      </th>
      <th class="indicadoresC" colspan="2">
        Indicadores de Gestión de Calidad (30%)
      </th>
    </tr>
    <tr>
      <th class="datos-generales">Fecha</th>
      <th class="datos-generales">Centro</th>
      <th class="indicadoresG">
        % de Convenios Estratégicos Reportados (10%)
      </th>
      <th class="indicadoresG">
        % de Compromisos institucionales cumplidos (10%)
      </th>
      <th class="indicadoresO">% de Operatividad de cámaras (20%)</th>
      <th class="indicadoresO">% de Ausentismo Operativo (20%)</th>
      <th class="indicadoresO">% de Cumplimiento Mobile Locator (10%)</th>
      <th class="indicadoresC">Incumplimiento de disposiciones (20%)</th>
      <th class="indicadoresC">Comunicación Estratégica (10%)</th>
    </tr>
    <tr>
      <td></td>
      <td>Ambato</td>
      <td> <input type="text" class="form-control" id="exampleInputEmail1"></td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>Babahoyo</td>
      <td> <input type="text" class="form-control" id="exampleInputEmail1"></td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>Cuenca</td>
      <td> <input type="text" class="form-control" id="exampleInputEmail1"></td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>Esmeraldas</td>
      <td> <input type="text" class="form-control" id="exampleInputEmail1"></td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>Ibarra</td>
      <td> <input type="text" class="form-control" id="exampleInputEmail1"></td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>Loja</td>
      <td> <input type="text" class="form-control" id="exampleInputEmail1"></td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>Macas</td>
      <td> <input type="text" class="form-control" id="exampleInputEmail1"></td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>Machala</td>
      <td> <input type="text" class="form-control" id="exampleInputEmail1"></td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>Nueva Loja</td>
      <td> <input type="text" class="form-control" id="exampleInputEmail1"></td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>Portoviejo</td>
      <td> <input type="text" class="form-control" id="exampleInputEmail1"></td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>Quito</td>
      <td> <input type="text" class="form-control" id="exampleInputEmail1"></td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>Riobamba</td>
      <td> <input type="text" class="form-control" id="exampleInputEmail1"></td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>Samborondón</td>
      <td> <input type="text" class="form-control" id="exampleInputEmail1"></td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>San Cristóbal</td>
      <td> <input type="text" class="form-control" id="exampleInputEmail1"></td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>Santo Domingo</td>
      <td> <input type="text" class="form-control" id="exampleInputEmail1"></td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>Tulcán</td>
      <td> <input type="text" class="form-control" id="exampleInputEmail1"></td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
      <td>
      <input type="text" class="form-control" id="exampleInputEmail1"></td>
      </td>
    </tr>
  </table>
  <button type="submit" class="btn btn-block bg-gradient-success btn-sm">Actualizar</button>
</form>