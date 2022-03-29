<?php
class Nota {
    public $codNota;
    public $creador;
    public $fecha;
    public $peligrosidad;
    public $impacto;
    public $completada;
    public $tel;
    public $contenido;
    public $detalles;

    public function marcarCompletada(){
        $completada=1;
    }
}

?>