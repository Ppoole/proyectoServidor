<?php
    include("conexion.php");

    


        echo ("<script>
        window.addEventListener('load', () => {
        document.querySelector('#submit').addEventListener('click', (evt) => {
              
            
            let x=document.querySelector('#ceroNuevePel').value;
            if (x >= 10 || x < 0){
                evt.preventDefault();
                alert('La peligrosidad ha de estar entre cero y nueve');
            }
            let y= document.querySelector('#ceroNueveIm').value;
            if (y >= 10 || y < 0){
                evt.preventDefault();
                alert('El impacto ha de estar entre cero y nueve');
            }

        })
        })</script>");

    if (isset($_POST['action'])) {
        if ($_POST['codNota'] == "NUEVANOTA") {
            if ($_SESSION['tel']!=""){
            $nota = array("creador" => '1', "fecha" =>  $_POST['fecha'], "peligrosidad" => $_POST['peligrosidad'], "impacto" => $_POST['impacto'], "completada" => "0", "tel" => $_SESSION['tel'], "contenido" => $_POST['contenido'], "detalles" => $_POST['detalles']);
            entradaDB("nota", $nota);
            echo ("<h1>Nota guardada</h1>");
            }
            else{
                echo("<h1>Por favor, no intentes crear una nota para teléfono en blanco. Está feo.</h1>");
            }
        } else {
            $nota = array("creador" => '1', "fecha" =>  $_POST['fecha'], "peligrosidad" => $_POST['peligrosidad'], "impacto" => $_POST['impacto'], "completada" => "0", "tel" => $_SESSION['tel'], "contenido" => $_POST['contenido'], "detalles" => $_POST['detalles']);
            updateDB("nota", "codNota", $_POST['codNota'], $nota);
            echo ("<h1>Nota modificada</h1>");
        }
    }




    if (isset($_POST['modificar'])) {
        echo ("<form action='' method='post'>");
        if (isset($_POST['codNota'])) {
            echo "<input name='codNota' value=" .  $_POST['codNota'] . " hidden></input> ";
        } else {
            echo "<input name='codNota' value=" . 'NUEVANOTA'  . " hidden></input> ";
        }

        if (isset($_POST['creador'])) {
            echo "<input name='creador' value=" . $_POST['creador'] . " hidden></input> ";
        } else {
            echo "<input name='creador' value=" . 'NUEVOCREADOR' . " hidden></input> "; //Necesita desarrollo
        }
        echo "<p>Telefono</p><p>Resumen</p><p>Detalles</p><p>Peligrosidad</p><p>Impacto</p><p>Guardar</p>";
        if (isset($_POST['tel'])) {

           
            echo "<input name='tel' value=". "'". $_POST['tel']. "'" . " disabled></input> ";
        } else {
            echo "<input name='tel' value=". "'" . $_SESSION['tel']. "'". "disabled></input> ";
        }

        if (isset($_POST['fecha'])) {
            echo "<input name='fecha' value=" . $_POST['fecha'] . " hidden></input>";
        } else {
            echo "<input name='fecha' value=" . date('Y/m/d') . " hidden></input>";
        }

        if (isset($_POST['contenido'])) {
            echo "<input name='contenido' value=" . "'" . $_POST['contenido'] . "'" . "></input>";
        } else {
            echo "<input name='contenido' value='Resume aquí la nota'></input>";
        }

        if (isset($_POST['detalles'])) {
            echo "<textarea name='detalles'>" . $_POST['detalles'] . "</textarea>";
        } else {
            echo "<textarea name='detalles'>" . "Escribe aquí los detalles de la nota." . "</textarea>";
        }



        if (isset($_POST['peligrosidad'])) {
            echo "<input type='number' id='ceroNuevePel' name='peligrosidad' value=" . $_POST['peligrosidad'] . "></input>";
        } else {
            echo "<input type='number' id='ceroNuevePel' name='peligrosidad'></input>";
        }

        if (isset($_POST['impacto'])) {
            echo "<input type='number' id='ceroNueveIm' name='impacto' value=" . $_POST['impacto'] . "></input>";
        } else {
            echo "<input type='number' id='ceroNueveIm' name='impacto'></input>";
        }

        echo (" <input type='submit' name='action' id='submit' value='Guardar' />");

        echo ("</form>");
    }
    ?>