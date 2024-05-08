<?php
include "../includes/_db.php";
session_start();
error_reporting(0);

$validar = $_SESSION['correo'];

if( $validar == null || $validar == ''){

    header("Location: ./includes/login.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/fontawesome-all.min.css">
    <link rel="stylesheet" href="../css/estilo.css">
    <link rel="stylesheet" href="../css/es.css">
    <link rel="stylesheet" href="../css/index.css">
    <title>Usuarios</title>
</head>

<body>
    <div class="container is-fluid">
        <div class="tabla-container">
        <form >    
        <table>
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
          <td>
            <select name="estrategicos" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="compromisos" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="operatividad" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="ausentismo" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="cumplimiento" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="incumplimiento" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="comunicacion" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
        </tr>
        <tr>
          <td></td>
          <td>Babahoyo</td>
          <td>
            <select name="estrategicos" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="compromisos" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="operatividad" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="ausentismo" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="cumplimiento" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="incumplimiento" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="comunicacion" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
        </tr>
        <tr>
          <td></td>
          <td>Cuenca</td>
          <td>
            <select name="estrategicos" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="compromisos" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="operatividad" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="ausentismo" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="cumplimiento" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="incumplimiento" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="comunicacion" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
        </tr>
        <tr>
          <td></td>
          <td>Esmeraldas</td>
          <td>
            <select name="estrategicos" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="compromisos" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="operatividad" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="ausentismo" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="cumplimiento" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="incumplimiento" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="comunicacion" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
        </tr>
        <tr>
          <td></td>
          <td>Loja</td>
          <td>
            <select name="estrategicos" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="compromisos" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="operatividad" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="ausentismo" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="cumplimiento" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="incumplimiento" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="comunicacion" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
        </tr>
        <tr>
          <td></td>
          <td>Macas</td>
          <td>
            <select name="estrategicos" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="compromisos" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="operatividad" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="ausentismo" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="cumplimiento" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="incumplimiento" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="comunicacion" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
        </tr>
        <tr>
          <td></td>
          <td>Machala</td>
          <td>
            <select name="estrategicos" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="compromisos" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="operatividad" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="ausentismo" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="cumplimiento" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="incumplimiento" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="comunicacion" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
        </tr>
        <tr>
          <td></td>
          <td>Nueva Loja</td>
          <td>
            <select name="estrategicos" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="compromisos" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="operatividad" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="ausentismo" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="cumplimiento" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="incumplimiento" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="comunicacion" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
        </tr>
        <tr>
          <td></td>
          <td>Portoviejo</td>
          <td>
            <select name="estrategicos" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="compromisos" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="operatividad" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="ausentismo" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="cumplimiento" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="incumplimiento" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="comunicacion" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
        </tr>
        <tr>
          <td></td>
          <td>Quito</td>
          <td>
            <select name="estrategicos" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="compromisos" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="operatividad" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="ausentismo" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="cumplimiento" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="incumplimiento" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="comunicacion" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
        </tr>
        <tr>
        <td></td>
          <td>Riobamba</td>
          <td>
            <select name="estrategicos" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="compromisos" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="operatividad" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="ausentismo" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="cumplimiento" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="incumplimiento" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="comunicacion" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
        </tr>
        <tr>
          <td></td>
          <td>Samborondón</td>
          <td>
            <select name="estrategicos" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="compromisos" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="operatividad" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="ausentismo" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="cumplimiento" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="incumplimiento" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="comunicacion" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
        </tr>
        <tr>
          <td></td>
          <td>San Cristóbal</td>
          <td>
            <select name="estrategicos" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="compromisos" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="operatividad" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="ausentismo" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="cumplimiento" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="incumplimiento" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="comunicacion" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
        </tr>
        <tr>
          <td></td>
          <td>Santo Domingo</td>
          <td>
            <select name="estrategicos" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="compromisos" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="operatividad" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="ausentismo" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="cumplimiento" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="incumplimiento" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="comunicacion" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
        </tr>
        <tr>
          <td></td>
          <td>Tulcán</td>
          <td>
            <select name="estrategicos" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="compromisos" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="operatividad" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="ausentismo" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="cumplimiento" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="incumplimiento" id="lang">
              <option value="20%">20%</option>
              <option value="19%">19%</option>
              <option value="18%">18%</option>
              <option value="17%">17%</option>
              <option value="16%">16%</option>
              <option value="15%">15%</option>
              <option value="14%">14%</option>
              <option value="13%">13%</option>
              <option value="12%">12%</option>
              <option value="11%">11%</option>
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
          <td>
            <select name="comunicacion" id="lang">
              <option value="10%">10%</option>
              <option value="9%">9%</option>
              <option value="8%">8%</option>
              <option value="7%">7%</option>
              <option value="6%">6%</option>
              <option value="5%">5%</option>
              <option value="4%">4%</option>
              <option value="3%">3%</option>
              <option value="2%">2%</option>
              <option value="1%">1%</option>
            </select>
          </td>
        </tr>
      </table>
      </form>
        </div>
    </div>
</body>

</html>
