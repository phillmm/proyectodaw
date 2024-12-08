<?php 

namespace Model;

class Generos extends ActiveRecord {
    //Base de datos 
    protected static $tabla = 'generos';
    protected static $columnasDB = ['id_genero', 'nombre'];

    //Atributos
    public $id_genero;
    public $nombre;

    //Constructor
    public function __construct($args = []) {
        $this->id_genero = $args['id_genero'] ?? null;
        $this->nombre    = $args['nombre']    ?? '';
    }
}