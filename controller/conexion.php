<?php
/** Esta función recibe una tabla y unos valores como array asociativo, y por su propia cuenta prepara y ejecuta una inserción preparada. **/
function entradaDB($tabla, $valores){
try {
    $mbd = new PDO('mysql:host=localhost;dbname=phoneapp', "root", ""); //Un login, evidentemente necesitaré mejorar la seguridad.
    $extraInter = "";
    for($i=1;$i<count($valores);$i++){ //Creamos un array con tantas ',?' como valores por encima de uno haya en el array.
        $extraInter=$extraInter.',?';
    }
    $campos="";
    $contenido=[];
    foreach($valores as $campo=>$valor){ //llenamos un array simple con los valores a insertar
        $campos=$campos .',' . $campo;
        
        array_push($contenido,$valor);
    }
    $campos=ltrim($campos,',');
    $sql = "INSERT INTO $tabla" ."(". $campos .")". "VALUES (?".$extraInter.")";
    
    $stmt= $mbd->prepare($sql);
    $stmt->execute($contenido); //ejecutamos la consulta.
    $mbd = null;
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}}
/** Esta función funciona como la anterior, recibiendo una tabla, un valor por el que buscar, y un array de valores que cambiar.  **/
function updateDB($tabla,$nomId, $id, $valores){
    try {
        $mbd = new PDO('mysql:host=localhost;dbname=phoneapp', "root", "");
        $campos="";
        $contenido=[];
        foreach($valores as $campo=>$valor){
            $campos=$campos . $campo . "=?,"; //Llenamos la consulta con los valores que queremos cambiar y los campos.
            
            array_push($contenido,$valor);
        }

        $campos=rtrim($campos,',');
        $sql = "UPDATE $tabla SET " . $campos . " WHERE ".$nomId."=".$id;
        $stmt= $mbd->prepare($sql);
        $stmt->execute($contenido); //Y ejecutamos la consulta.
        $mbd = null;
    } catch (PDOException $e) {
        print "¡Error!: " . $e->getMessage() . "<br/>";
        die();
    }}

/** Una función sencilla que retorna todos los teléfonos de la tabla teléfono como objetos de la clase Telefono. La usaremos para guardarlos, y no tener que acceder a la base de datos
 * cada vez que ocurre una llamada telefónica  **/
function sacarTelefonos(){
    try {

        include "../models/telefono.php";
        $mbd = new PDO('mysql:host=localhost;dbname=phoneapp', "root", "");
        $sql = "SELECT tel, codPer from telefono";
        $stmt= $mbd->prepare($sql);    
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_CLASS, "Telefono");
        return $result;
        $sth = null;
        $mbd = null;
    } catch (PDOException $e) {
        print "¡Error!: " . $e->getMessage() . "<br/>";
        die();
    }



}

/** Un query que retorna todas las notas asociadas a un teléfono como objetos de la clase Nota. Un select sencillo  **/
function sacarNotas($tel){
    try {
    include "../models/nota.php";
    $mbd = new PDO('mysql:host=localhost;dbname=phoneapp', "root", "");
    $sql = "SELECT codNota, creador, fecha, peligrosidad, impacto, completada, tel, contenido, detalles from nota where tel=?";
    $stmt= $mbd->prepare($sql);
    $stmt->execute(array($tel));
    $result = $stmt->fetchAll(PDO::FETCH_CLASS, "Nota");
    return $result;
    }catch (PDOException $e) {
        print "¡Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}

/** Esta función es un query triple. Con la opcion por defecto, 'n', sencillamente saca todas las notas que hay.
 * Con la opción extra 'p', sólo aquellas que no están completadas.
 * Y finalmente, si se añade im código de persona, saca absolutamente todas las notas de todos los telefonos vinculados con una persona. 
 * Atención, porque la consulta tiene subconsulta y es durilla.  **/
function sacarTodasNotas($opt='n'){
    try {
    include realpath("C:/xampp/htdocs/proyecto/models/nota.php");
    $mbd = new PDO('mysql:host=localhost;dbname=phoneapp', "root", "");
        
    
    if ($opt=='n'){
    $sql = "SELECT codNota, creador, fecha, peligrosidad, impacto, completada, tel, contenido, detalles from nota";
    $stmt= $mbd->prepare($sql);
    $stmt->execute();
    }
    else if ($opt=='p'){
    $sql = "SELECT codNota, creador, fecha, peligrosidad, impacto, completada, tel, contenido, detalles from nota where completada=0";
    $stmt= $mbd->prepare($sql);
    $stmt->execute();
    }
    else{
    $sql = "SELECT codNota, creador, fecha, peligrosidad, impacto, completada, tel, contenido, detalles from nota where tel in(select tel from telefono where codPer=?)";
    $stmt= $mbd->prepare($sql);
    $stmt->execute(array($opt));
    }
    

    $result = $stmt->fetchAll(PDO::FETCH_CLASS, "Nota");
    return $result;
    }catch (PDOException $e) {
        print "¡Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}

/** Otra función de subconsultas,esta vez todas las personas asociadas a un teléfono. Generalmente esto debe ser una sola persona, pero hay usos
 * posibles para más. **/
function sacarPersona($tel){
    try {
    include "../models/persona.php";
    $mbd = new PDO('mysql:host=localhost;dbname=phoneapp', "root", "");
        
    

    $sql = "SELECT codPer, nombre, detalles from persona where codPer=(SELECT codPer from telefono where tel=?)";
    $stmt= $mbd->prepare($sql);
    $stmt->execute(array($tel));

    $result = $stmt->fetchAll(PDO::FETCH_CLASS, "Persona");
    return $result;
    }catch (PDOException $e) {
        print "¡Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}

/** Para poder asociar una persona recientemente creada a un número, cuando el codPer es auto incremento, es necesario saber por dónde va dicho auto-incremento**/
function sacarCodPer(){
    try {
    
    $mbd = new PDO('mysql:host=localhost;dbname=phoneapp', "root", "");

    $sql = "SELECT MAX(codPer) FROM persona";
    $stmt= $mbd->prepare($sql);
    $stmt->execute();

    return $stmt->fetchColumn();
    }catch (PDOException $e) {
        print "¡Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}
/** Consulta con subconsulta para obtener todos los emails relacionados con una persona, sabiendo que email se vincula a telefono, no a persona. **/
function sacarEmails($codPer){
    try {
        include "../models/email.php";
        $mbd = new PDO('mysql:host=localhost;dbname=phoneapp', "root", "");
    
        $sql = "SELECT codMail, mail, tel from email where tel in (select tel from telefono where codPer=?);";
        $stmt= $mbd->prepare($sql);
        $stmt->execute(array($codPer));
    
        $result = $stmt->fetchAll(PDO::FETCH_CLASS, "Email");
        return $result;
        }catch (PDOException $e) {
            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
        }
}

/** Obtiene el código de persona asociado a un nombre. **/
function comprobarNombre($nombre){
    try {
    
    $mbd = new PDO('mysql:host=localhost;dbname=phoneapp', "root", "");

    $sql = "SELECT (codPer) FROM persona where nombre=?";
    $stmt= $mbd->prepare($sql);
    $stmt->execute(array($nombre));


    return $stmt->fetchColumn();
    }catch (PDOException $e) {
        print "¡Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}

function comprobarPassword($nomUsu, $conUsu){
    $mbd = new PDO('mysql:host=localhost;dbname=phoneapp', "root", "");
    $sql = "SELECT codUsu, nomUsu, conUsu FROM usuario WHERE nomUsu = ?";
    $stmt = $mbd->prepare($sql);
    $stmt->execute(array($nomUsu));
    $datos = $stmt->fetch(PDO::FETCH_ASSOC);
    if($datos !== false){
        
        $passBien = password_verify($conUsu, $datos['conUsu']);
        if($passBien){
            
            $_SESSION['validado']=TRUE;
            header("location: apli.php");
        }
        else{
            echo ("Datos mal.");
        }
    }
    else{
        echo ("Datos mal.");
    }

}

function sacarUsuario($codUsu){
    $mbd = new PDO('mysql:host=localhost;dbname=phoneapp', "root", "");
    $sql = "SELECT nomUsu FROM usuario WHERE codUsu = ?";
    $stmt = $mbd->prepare($sql);
    $stmt->execute(array($codUsu));
    
    return $stmt->fetchColumn();
    

}
?>