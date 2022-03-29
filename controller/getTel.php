<?php
include "conexion.php";

$telefonos=sacarTelefonos();
$encontrado=false;
$telefono="nuevo";
$todasNotas="";
foreach ($telefonos as $tels){
    if ($tels->tel==$_GET['cod']){
    $telefono= $tels->codPer;
    $encontrado=true;
}}

echo ($telefono);


