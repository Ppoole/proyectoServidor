<?php

function entradaDB($tabla, $valores){
try {
    $mbd = new PDO('mysql:host=localhost;dbname=phoneapp', "root", "");
    $extraInter = "";
    for($i=1;$i<count($valores);$i++){
        $extraInter=$extraInter.',?';
    }

    $campos="";
    $contenido=[];
    

    foreach($valores as $campo=>$valor){
        $campos=$campos .',' . $campo;
        
        array_push($contenido,$valor);
    }
    $campos=ltrim($campos,',');

    

    $sql = "INSERT INTO $tabla" ."(". $campos .")". "VALUES (?".$extraInter.")";
    
    $stmt= $mbd->prepare($sql);



    $stmt->execute($contenido);


    //foreach($mbd->query('SELECT * from persona') as $fila) {
    //    print_r($fila);
    //}


    $mbd = null;
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}}


function sacarTelefonos(){
    try {

        include "telefono.php";
        $mbd = new PDO('mysql:host=localhost;dbname=phoneapp', "root", "");
        
    
        $sql = "SELECT tel, codPer from telefono";
    
        
        $stmt= $mbd->prepare($sql);
    
    
    
        $stmt->execute();
    
    
        //foreach($mbd->query('SELECT * from persona') as $fila) {
        //    print_r($fila);
        //}
    
    
        $result = $stmt->fetchAll(PDO::FETCH_CLASS, "Telefono");
        return $result;
        $sth = null;
        $mbd = null;
    } catch (PDOException $e) {
        print "¡Error!: " . $e->getMessage() . "<br/>";
        die();
    }



}

function sacarNotas($tel){
    try {
    include "nota.php";
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
