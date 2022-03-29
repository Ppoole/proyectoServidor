<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todas las notas</title>
    <link rel="stylesheet" href="tablas.css">
    <style>
        body {
            background-color: #ffcc66;
        }

        input[type=submit] {
            background-color: #996600;
            color: #ffcc66;
        }
    </style>
</head>

<body>
    <?php

    include "controller/conexion.php";

    echo ("<script>window.addEventListener(\"focus\", function(event) {
  
    location.reload();
  

})</script>");

    echo("<script>function cambiarCompletada(chkbox) {

        if (chkbox.checked == true) { //Si la estamos completando.
          xhttp = new XMLHttpRequest();
          xhttp.open('POST', 'controller/marcaHecha.php');
          xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
          let datos = 'codNota=' + chkbox.name + '&nuevoValor=' + 1;
          xhttp.send(datos);
        } else {
          xhttp = new XMLHttpRequest();
          xhttp.open('POST', 'controller/marcaHecha.php');
          xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
          let datos = 'codNota=' + chkbox.name + '&nuevoValor=' + 0;
          xhttp.send(datos);
        }
      }</script>");

    if (isset($_POST['codPer'])) {
        $notas = sacarTodasNotas($_POST['codPer']); //vacio para todas, 'p' para pendientes, un codPer para las de una persona.
    } elseif (isset($_POST['soloPendientes'])) {
        $notas = sacarTodasNotas('p'); //Sacar solo las pendientes.
        echo "<form action=\"todasNotas.php\" method=\"post\"><input type=\"submit\" value=\"Mostrar todas.\" /></form>";
    } else {
        echo "<form action=\"todasNotas.php\" method=\"post\"><input type=\"submit\" name=\"soloPendientes\" value=\"Mostrar solo pendientes.\" /></form>";
        $notas = sacarTodasNotas();
    }
    $texto = "";


    $texto .= '<table border="1">';
    $texto .= '<tr class="cabecera"><td>Creador</td><td>Fecha</td><td id="contenido">Contenido</td><td>Detalles</td><td>Peligrosidad</td><td>Impacto</td><td>Completada</td></tr>';
    foreach ($notas as $nota) {
        $texto .= '<tr>';
        $texto .= '<td>' . $nota->tel . '</td>';
        $texto .= '<td>' . sacarUsuario($nota->creador) . '</td>';
        $texto .= '<td>' . $nota->fecha . '</td>';
        $texto .= '<td>' . $nota->contenido . '</td>';

        $texto .= '<td>' . '<span title="' . $nota->detalles . '">Detalles</span></td>';
        $texto .= '<td>' . $nota->peligrosidad . '</td>';
        $texto .= '<td>' . $nota->impacto . '</td>';

        if ($nota->completada == 1) {
            $texto .= "<td><input type=\"checkbox\" name=\"" . $nota->codNota . "\" onchange=\"cambiarCompletada(this)\" checked></td>";
        } else {
            $texto .= "<td><input type=\"checkbox\" name=\"" . $nota->codNota . "\" onchange=\"cambiarCompletada(this)\"></td>";
        }

        $texto .= '<td><form method="post" action="pagNota.php"
              target="_blank">
            <input type="hidden" name="codNota" value=' . $nota->codNota . '>
            <input type="hidden" name="creador" value=' . $nota->creador . '>
            <input type="hidden" name="fecha" value=' . $nota->fecha . '>
            <input type="hidden" name="contenido" value=' . "'" . $nota->contenido . "'" . '>
            <input type="hidden" name="peligrosidad" value=' . $nota->peligrosidad . '>
            <input type="hidden" name="impacto" value=' . $nota->impacto . '>
            <input type="hidden" name="detalles" value=' . "'" . $nota->detalles . "'" . '>
            <input type="hidden" name="completada" value=' . $nota->completada . '>
            <input type="submit" name="modificar" value="Modificar"> 
            </form></td>';
        $texto .= '</tr>';
    }
    $texto .= '</table>';
    echo $texto;

    ?>
</body>

</html>