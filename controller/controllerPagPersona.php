<?php
    include("conexion.php");

    if (isset($_POST['guaDetalles'])) {
        
        if ($_POST['codPer'] == 1) {
            $persona = array("nombre" => $_POST['nombre'], "detalles" =>   $_POST['detalles']);
            entradaDB("persona", $persona);
            $nuevaPer = array("codPer" => sacarCodPer());
            updateDB("telefono", "tel", $_POST['telefono'], $nuevaPer);
            echo ("<h1>Datos guardados</h1>");
            
        } 
        
        else {
            
            $persona = array("nombre" => $_POST['nombre'], "detalles" =>   $_POST['detalles']);
            updateDB("persona", "codPer", $_POST['codPer'], $persona);
            echo ("<h1>Datos actualizados</h1>");
            
            
        }
    }

    if (isset($_POST['action'])) {
        $codPerPrevia=comprobarNombre($_POST['nombre']);
        if ($_POST['codPer'] == 1) {
            if ($codPerPrevia == "") {

                $persona = array("nombre" => $_POST['nombre'], "detalles" =>   $_POST['detalles']);
                entradaDB("persona", $persona);

                $nuevaPer = array("codPer" => sacarCodPer());

                updateDB("telefono", "tel", $_POST['telefono'], $nuevaPer);
                echo ("<h1>Datos guardados</h1>");
            } else {
                echo ("<h3>La persona " . $_POST['nombre'] . " ya existe. Añadir el número a la persona?");
                echo ("<form action='' method='post'>");
                    echo "<input name='codPer' value=" .  $codPerPrevia . " hidden></input> ";
                    echo "<input name='telefono' value=" .  $_POST['telefono'] . " hidden></input> ";
                    echo "<input name='nombre' value=" . "'" . $_POST['nombre'] . "'" . " hidden></input>";
                    echo "<textarea name='detalles'>" . $_POST['detalles'] . " hidden</textarea>";
                echo (" <input type='submit' name='sobreescribir' id='submit' value='Si' />");
                echo ("</form>");
            }
        } 
        
        else {
            if($codPerPrevia == ""){
            $persona = array("nombre" => $_POST['nombre'], "detalles" =>   $_POST['detalles']);
            updateDB("persona", "codPer", $_POST['codPer'], $persona);
            echo ("<h1>Datos actualizados</h1>");
            }
            else{
                echo ("<h3>La persona " . $_POST['nombre'] . " ya existe. Añadir el número a la persona?");
                echo ("<form action='' method='post'>");
                    echo "<input name='codPer' value=" .  $codPerPrevia . " hidden></input> ";
                    echo "<input name='telefono' value=" .  $_POST['telefono'] . " hidden></input> ";
                    echo "<input name='nombre' value=" . "'" . $_POST['nombre'] . "'" . "></input>";
                    echo "<textarea name='detalles'>" . $_POST['detalles'] . "</textarea>";
                echo (" <input type='submit' name='sobreescribir' id='submit' value='Si' />");
                echo ("</form>");
            }
        }
    }

    if (isset($_POST['nuevoMail'])){
        $email = array("mail" => $_POST['email'], "tel"=>$_POST['telefono']);
        entradaDB("email", $email);
        echo ("<h1>Correo añadido.</h1>");
    }

    if (isset($_POST['sobreescribir'])) {
        $nuevaPer = array("codPer" => $_POST['codPer']);
        updateDB("telefono", "tel", $_POST['telefono'], $nuevaPer);
        echo ("<h1>Número Reasignado</h1>");
    }

    if (isset($_POST['modificar'])) {
        if ($_POST['telefono']!=""){
        echo ("<form action='' method='post'>");
        echo "<p>Nombre</p><p>Detalles</p><p>Añadir Correo.</p>";


        if (isset($_POST['codPer'])) {
            echo "<input name='codPer' value=" .  $_POST['codPer'] . " hidden></input> ";
        } else {
            echo "<input name='codPer' value=" . 1  . " hidden></input> ";
        }


        if (isset($_POST['telefono'])) {
            echo "<input name='telefono' value=" .  $_POST['telefono'] . " hidden></input> ";
        } else {
            echo "esto no deberia pasar";
            echo "<input name='telefono' value=" . 1  . " hidden></input> ";
        }


        
        if (isset($_POST['nombre'])) {
            echo "<input name='nombre' value=" . "'" . $_POST['nombre'] . "'" . "></input>";
        } else {
            echo "<input name='nombre' value='Introduce el nombre'></input>";
        }

        
        if (isset($_POST['detalles'])) {
            echo "<textarea name='detalles'>" . $_POST['detalles'] . "</textarea>";
        } else {
            echo "<textarea name='detalles'>" . "Escribe aquí los detalles de la persona." . "</textarea>";
        }


        echo "<input name='email'></input>";
        echo ("<input type='submit' name='action' id='submit' value='Guardar Nombre' />");
        echo ("<input type='submit' name='guaDetalles' id='submit' value='Guardar Detalles' />");
        echo ("<input type='submit' name='nuevoMail' id='submit' value='Añadir Correo' />");
        echo ("</form>");
    }
    else{
        echo("<h1>Por favor, no intentes asignar un valor al teléfono en blanco. Está feo.</h1>");
    }
    }
