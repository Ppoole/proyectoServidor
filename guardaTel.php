<?php
session_start();
include "conexion.php";
if(isset($_POST['tel']))
{   
    $nuevoTel=array('tel'=>$_POST['tel'], 'codPer'=>1);
    entradaDB('telefono', $nuevoTel);
}
?>