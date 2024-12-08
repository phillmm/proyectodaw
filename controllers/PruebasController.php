<?php 
namespace Controllers;
use MVC\Router;
use Model\Libro;
use Model\Usuario;

class PruebasController {
    public static function libros(Router $router) {
        //Identificación de la clase y el método
        $clase = 'Libro';
        $metodo = 'constructor';

        //Argumentos para el constructor
        $args = [
            'id_libro' => 1,
            'nombre' => 'Rojo, Blanco y Sangre Azul',
            'autor' => 'Casey McQuinston',
            'editorial' => 'Molino',
            'isbn' => '9788427235151',
            'descripcion' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'precio' => 15.99,
            'id_genero' => 9,
            'id_usuario_vende' => 1
        ];

        //Instanciación de la clase
        $libro = new Libro($args);

        // Verificar que los atributos se asignen correctamente
        try {
            assert($libro->id_libro === 1);
            assert($libro->nombre === 'Rojo, Blanco y Sangre Azul');
            assert($libro->autor === 'Casey McQuinston');
            assert($libro->editorial === 'Molino');
            assert($libro->isbn === '9788427235151');
            assert($libro->descripcion === 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.');
            assert($libro->precio === 15.99);
            assert($libro->id_genero === 9);
            assert($libro->id_usuario_vende === 1);
            
            $mensaje = "Todas las pruebas han sido exitosas!";
        } catch (\AssertionError $e) {
            $mensaje = "Error en: " . $e->getMessage();
        }

        $router->render('tests/test', [
            'titulo' => 'Pruebas LibrosController',
            'mensaje' => $mensaje,
            'clase' => $clase,
            'metodo' => $metodo
        ]);
    }

    public static function usuarios(Router $router) {

        //Identificación de la clase y el método
        $claseUsuario = 'Usuario';
        $metodoUsuario = 'constructor';

        //Argumentos para el constructor
        $argsUsuario = [
            'id_usuario' => 1,
            'nombre' => 'Juan',
            'apellidos' => 'Pérez',
            'email' => 'juan.perez@example.com',
            'pass' => 'contraseña123',
            'token' => 'token123',
            'admin' => 0,
            'confirmado' => 1
        ];

        //Instanciación de la clase
        $usuario = new Usuario($argsUsuario);

        // Verificar que los atributos se asignen correctamente
        try {
            assert($usuario->id_usuario === 1);
            assert($usuario->nombre === 'Juan');
            assert($usuario->apellidos === 'Pérez');
            assert($usuario->email === 'juan.perez@example.com');
            assert($usuario->pass === 'contraseña123');
            assert($usuario->token === 'token123');
            assert($usuario->admin === 0);
            assert($usuario->confirmado === 1);
            
            $mensajeUsuario = "Todas las pruebas han sido exitosas para Usuario!";
        } catch (\AssertionError $e) {
            $mensajeUsuario = "Error en: " . $e->getMessage();
        }

        // Renderizar el resultado de la prueba
        $router->render('tests/test', [
            'titulo' => 'Pruebas UsuarioController',
            'mensaje' => $mensajeUsuario,
            'clase' => $claseUsuario,
            'metodo' => $metodoUsuario
        ]);
    }

    public static function validarLibro(Router $router) {
        //Identificación de la clase y el método
        $claseLibro = 'Libro';
        $metodoLibro = 'validar';

        //Argumentos para el constructor
        $argsLibro = [
            'id_libro' => 1,
            'nombre' => 'El Gran Gatsby',
            // 'autor' => 'F. Scott Fitzgerald',
            // 'editorial' => 'Scribner',
            // 'isbn' => '9780743273565',
            'descripcion' => 'Una novela sobre el sueño americano.',
            'precio' => 10.99,
            'id_genero' => 1,
            'id_usuario_vende' => 1
        ];

        //Instanciación de la clase
        $libro = new Libro($argsLibro);

        //Validar el libro
        $alertas = $libro->validar();

        //Verificar que no haya alertas
        try {
            assert(empty($alertas), "Se encontraron errores de validación: " . implode(", ", $alertas));
            $mensajeLibro = "La validación del libro fue exitosa!";
        } catch (\AssertionError $e) {
            $mensajeLibro = "Error en: " . $e->getMessage();
        }

        $alertas = Libro::getAlertas();

        // Renderizar el resultado de la prueba
        $router->render('tests/test', [
            'titulo' => 'Pruebas LibroController',
            'mensaje' => $mensajeLibro,
            'clase' => $claseLibro,
            'metodo' => $metodoLibro,
            'alertas' => $alertas
        ]);
    }
}