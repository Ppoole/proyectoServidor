<?php

include "conexion.php"; 

    
    
    $persona = sacarPersona($_POST['not']);
    $texto = "";

    if($persona[0]->codPer != 1){

    $emails=sacarEmails($persona[0]->codPer);


    $texto .= '<p> <span class="bold">Nombre:</span> ' . $persona[0]->nombre . '</p>';
    $texto .= '<p> <span class="bold">Detalles:</span> ' . $persona[0]->detalles . '</p>';
    





    $texto .= '<td><form method="post" action="pagPersona.php" target="_blank">
                <input type="hidden" name="telefono" value='  . $_POST['not'] .  '>
                <input type="hidden" name="nombre" value=' . "'" . $persona[0]->nombre . "'" . '>
              
                <input type="hidden" name="detalles" value=' . "'" . $persona[0]->detalles . "'" . '>
                <input type="hidden" name="codPer" value=' . $persona[0]->codPer . '>
                <input type="submit" name="modificar" value="Editar"> 
                </form></td>';
    

    

foreach ($emails as $email) {
    $texto .='<p>Correo: '.  $email->mail.'</p>';
}


$texto .= "<form action=\"todasNotas.php\" method=\"post\">
<input type=\"hidden\" name=\"codPer\" value=\""  . $persona[0]->codPer .  "\">
<input type=\"submit\" class=\"enLinea\" value=\"Mostrar todas las notas de esta persona.\" /></form>";

$texto .= "<form action=\"todasNotas.php\" method=\"post\">

<input type=\"submit\" class=\"enLinea\" value=\"Mostrar todas las notas de todos.\" /></form>";


}
else{

    $texto .= '<td><form method="post" action="pagPersona.php" target="_blank">
                <input type="hidden" name="telefono" value='  . $_POST['not'] .  '>
                <input type="hidden" name="nombre" value="nuevo">
              
                <input type="hidden" name="detalles" value=' . "'" . $persona[0]->detalles . "'" . '>
                <input type="hidden" name="codPer" value=' . $persona[0]->codPer . '>
                <input type="submit" name="modificar" value="Añadir nueva persona."> 
                </form></td>';

    $texto .= "<form action=\"todasNotas.php\" method=\"post\">

<input type=\"submit\" class=\"enLinea\" value=\"Mostrar todas las notas de todos.\" /></form>";
}
echo $texto;