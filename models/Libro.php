<?php

namespace Model;

class Libro extends ActiveRecord {
    //Base de datos
    protected static $tabla = 'libros';
    protected static $columnasDB = ['id_libro', 'nombre', 'autor', 'editorial', 'isbn', 'descripcion', 'precio', 'id_genero', 'id_usuario_vende'];

    //Atributos
    public $id_libro;
    public $nombre;
    public $autor;
    public $editorial;
    public $isbn;
    public $descripcion;
    public $precio;
    public $id_genero;
    public $id_usuario_vende;

    //Constructor
    public function __construct($args = []) {
        $this->id_libro         = $args['id_libro']         ?? null;
        $this->nombre           = $args['nombre']           ?? '';
        $this->autor            = $args['autor']            ?? '';
        $this->editorial        = $args['editorial']        ?? '';
        $this->isbn             = $args['isbn']             ?? '';
        $this->descripcion      = $args['descripcion']      ?? '';
        $this->precio           = $args['precio']           ?? '';
        $this->id_genero        = $args['id_genero']        ?? null;
        $this->id_usuario_vende = $args['id_usuario_vende'] ?? null;
    }

    public function validar() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El nombre del libro es obligatorio';
        }
        if(!$this->autor) {
            self::$alertas['error'][] = 'El autor del libro es obligatorio';
        }
        if(!$this->editorial) {
            self::$alertas['error'][] = 'La editorial del libro es obligatoria';
        }
        if(!$this->descripcion) {
            self::$alertas['error'][] = 'La descripción del libro es obligatoria';
        }
        if(!$this->precio) {
            self::$alertas['error'][] = 'El precio del libro es obligatorio';
        }
        if(!$this->id_genero) {
            self::$alertas['error'][] = 'El género del libro es obligatorio';
        }

        return self::$alertas;
    }
}