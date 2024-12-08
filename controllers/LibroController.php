<?php 

namespace Controllers;

use MVC\Router;
use Model\Libro;
use Model\Generos;
use Model\Seccion;

class LibroController {
    public static function crear(Router $router) {
        //Verificamos que el ususario esté autenticado
        if(!is_auth()) {
            header('Location: /login');
        }
        $alertas = [];
        $nombre_libro = '';
        $autor        = '';
        $editorial    = '';
        $isbn         = '';
        $descripcion  = '';
        $precio       = '';
        $id_genero    = '';

        //Obtenemos las variables de sesión
        $id_usuario = $_SESSION['id_usuario'];
        $nombre = $_SESSION['nombre'];

        //Obtenemos todas las secciones
        $secciones = Seccion::all('id_seccion', 'ASC');

        //Obtenemos todos los géneros
        $generos = Generos::all('nombre', 'ASC');

        //Creamos una instancia de Libro
        $libro = new Libro();

        //Validamos la información del formulario
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $libro->sincronizar($_POST);
            $alertas = $libro->validar();
            
            if(empty($alertas)) {
                //Si no hay alertas -> hemos pasado la validación
                //Asignamo el id del usuario a la propiedad id_usuario_vende
                $libro->id_usuario_vende = $id_usuario;

                //Guardamos el libro en la base de datos
                $resultado = $libro->guardar('id_libro');
                if($resultado) {
                    Libro::setAlerta('exito', 'Libro publicado correctamente');
                }
            } else {
                //Recuperamos los valores pasados para mantenerlos en el formulario
                $nombre_libro = $_POST['nombre'];
                $autor        = $_POST['autor'];
                $editorial    = $_POST['editorial'];
                $isbn         = $_POST['isbn'];
                $descripcion  = $_POST['descripcion'];
                $precio       = $_POST['precio'];
                $id_genero    = $_POST['id_genero'];
            }
        }

        $alertas = Libro::getAlertas();

        $router->render('dash/crear-libro', [
            'titulo'       => 'Publicar Libro',
            'nombre'       => $nombre,
            'secciones'    => $secciones,
            'generos'      => $generos,
            'alertas'      => $alertas,
            'nombre_libro' => $nombre_libro,
            'autor'        => $autor,
            'editorial'    => $editorial,
            'isbn'         => $isbn,
            'descripcion'  => $descripcion,
            'precio'       => $precio,
            'id_genero'    => $id_genero,
        ]);
    }

    public static function catalogo(Router $router) {
        //Verificamos que el ususario esté autenticado
        if(!is_auth()) {
            header('Location: /login');
        }

        //Obtenemos las variables de sesión
        $id_usuario = $_SESSION['id_usuario'];
        $nombre = $_SESSION['nombre'];

        //Obtenemos todas las secciones
        $generos = Generos::all('id_genero', 'ASC');
        
        /* CODIGO REEMPLAZADO POR LA API
        //Obtenemos todos los libros
        $libros = Libro::all('autor', 'ASC');
        foreach ($libros as &$libro) {
            $genero = Generos::find('id_genero', $libro->id_genero);
            $libro->nombre_genero = $genero ? $genero->nombre : 'Desconocido';
        }*/

        $router->render('dash/catalogo', [
            'titulo'    => 'Catálogo',
            'nombre'    => $nombre,
            'generos'   => $generos,
            //'libros'    => $libros
        ]);
    }

    public static function ficha(Router $router) {
        //Verificamos que el ususario esté autenticado
        if(!is_auth()) {
            header('Location: /login');
        }

        //Obtenemos las variables de sesión
        $id_usuario = $_SESSION['id_usuario'];
        $nombre = $_SESSION['nombre'];

        //Obtenemos todas las secciones
        $generos = Generos::all('id_genero', 'ASC');

        //Recuperamos el libro
        if(isset($_GET['id'])) {
            $id_libro = $_GET['id'];

            $libro = Libro::find('id_libro', $id_libro);
            
            //Si no existe el libro, redirigimos al catálogo
            if(!$libro) {
                header('Location: /libros/catalogo');
                return;
            }

            $genero = Generos::find('id_genero', $libro->id_genero);
            $libro->genero = $genero ? $genero->nombre : 'Desconocido';
        } else {
            header('Location: /libros/catalogo');
            return;
        }

        $router->render('dash/libro-ficha', [
            'titulo' => 'Ficha del Libro',
            'nombre' => $nombre,
            'generos' => $generos,
            'libro' => $libro
        ]);
    }

    /**
     * Método estatico que devuelve un JSON con todos los libros.
     */
    public static function getLibros() {
        if(!is_auth()) {
            header('Location: /login');
        }
        //Obtenemos todos los libros
        $libros = Libro::all('autor', 'ASC');

        //Obtenemos los géneros para completar el objeto de cada libri
        $generos = Generos::all('id_genero', 'ASC');

        //Recorremos el array de libros y creamos la propiedad con el nombre del género
        if(!empty($libros)) {
            foreach($libros as $libro) {
                //Obtenemos el objeto género que coincida con el id_genero del libro
                $genero = array_filter($generos, function($gen) use ($libro) {
                    return $gen->id_genero == $libro->id_genero;
                });

                //Obtenemos el primer elemento del array, ahora genero será un objeto
                $genero = reset($genero);

                //Asignamos la propiedad
                $libro->nombre_genero = $genero ? $genero->nombre : 'Desconocido';
            }

            //Construimos la respuesta
            $respuesta = [
                'tipo' => 'exito',
                'libros' => $libros
            ];
        } else {
            $respuesta = [
                'tipo' => 'error',
                'mensaje' => 'No hay libros disponibles'
            ];
        }

        //Enviamos la respuesta
        header('Content-Type: application/json');
        echo json_encode($respuesta);
        return;
    }
}