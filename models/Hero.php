<?php

namespace Model;

/**
 * Clase responsable de representar a los bloques de imágenes hero.
 */
class Hero extends ActiveRecord {
    //Base de datos
    protected static $tabla = 'conf_hero';
    protected static $columnasDB = ['id_hero', 'foto', 'titulo', 'descripcion', 'activo', 'url'];

    //Atributos
    public $id_hero;
    public $foto;
    public $titulo;
    public $descripcion;
    public $activo;
    public $url;

    //Constructor
    public function __construct($args = [])
    {
        $this->id_hero      = $args['id_hero']      ?? null;
        $this->foto         = $args['foto']         ?? '';
        $this->titulo       = $args['titulo']       ?? '';
        $this->descripcion  = $args['descripcion']  ?? '';
        $this->activo       = $args['activo']       ?? '';
        $this->url          = $args['url']          ?? '#';
    }
}