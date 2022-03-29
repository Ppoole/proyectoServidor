<?php
session_start();
?>


  <?php

  include "conexion.php"; {



    $notas = sacarNotas($_POST['not']);
    $texto = "";
    
    $texto .= '<table border="1">';
    if (!empty($notas)){
    $texto .= '<tr class="cabecera"><td>Creador</td><td>Fecha</td><td id="contenido">Contenido</td><td>Detalles</td><td>Peligrosidad</td><td>Impacto</td><td>Completada</td></tr>';
    }
    foreach ($notas as $nota) {
      $texto .= '<tr>';
      //$texto .= '<td>' . $nota->tel . '</td>';
      $texto .= '<td>' . sacarUsuario($nota->creador) . '</td>';
      $texto .= '<td>' . $nota->fecha . '</td>';
      $texto .= '<td id="contenido">' . $nota->contenido . '</td>';

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

    if (isset($_SESSION['tel'])){
      $texto .= "<form action=\"pagNota.php\" target=\"_blank\" method=\"post\"><input type=\"submit\" name=\"modificar\" value=\"Nueva Nota\" /></form>";
      }
    echo $texto;
  }
  ?>
