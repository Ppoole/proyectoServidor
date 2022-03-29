<?php
session_start();
?>
<?php

include 'conexion.php';

if(isset($_POST['codNota'])&&isset($_POST['nuevoValor']))
{
    updateDB('nota','codNota',$_POST['codNota'],array("completada" => $_POST['nuevoValor']));
}

?>