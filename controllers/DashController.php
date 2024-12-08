<?php 

namespace Controllers;

use Model\Generos;
use Model\Hero;
use Model\Seccion;
use MVC\Router;

class DashController {
    public static function index(Router $router) {
        if(!is_auth()) {
            header('Location: /login');
        }
        
        $id_usuario = $_SESSION['id_usuario'];
        $nombre = $_SESSION['nombre'];

        //Obtenemos todas los generos
        $generos = Generos::all('id_genero', 'ASC');

        //Obtememos las imágenes activas para el bloque hero
        $heroes = Hero::whereMultiple('activo', '1');

        $router->render('dash/home', [
            'titulo'    => 'Home',
            'nombre'    => $nombre,
            'generos'   => $generos,
            'heroes'    => $heroes
        ]);
    }
}