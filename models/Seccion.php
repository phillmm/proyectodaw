<?php

namespace Model;

class Seccion extends ActiveRecord {
    //Base de datos
    protected static $tabla = 'conf_secciones';
    protected static $columnasDB = ['id_seccion', 'nombre'];

    //Atributos
    public $id_seccion;
    public $nombre;

    //Constructor
    public function __construct($args = []) {
        $this->id_seccion = $args['id_seccion'] ?? null;
        $this->nombre     = $args['nombre']     ?? '';
    }
}