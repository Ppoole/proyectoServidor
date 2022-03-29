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
if ($encontrado){
    $todasNotas=sacarNotas($_GET['cod']);
}
echo json_encode(array('tel'=>$telefono, 'notas'=>$todasNotas));


