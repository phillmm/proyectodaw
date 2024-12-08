<?php 
namespace Controllers;

use Model\Usuario;
use MVC\Router;

class LoginController {
    /**
     * Método estático que sirve para gestionar el inicio de sesión en la aplicación.
     */
    public static function login(Router $router) {
        //Array para contener las alertas que pasaremos a la vista
        $alertas = [];

        /*
        // Prueba de caja negra: Simulamos diferentes escenarios de prueba
        $testCases = [
            //['email' => 'correo@correo.eue', 'pass' => '1234567'], // Correo y pass erróneo
            //['email' => 'correo@correo.eu', 'pass' => 'contraseña_incorrecta'], // Contraseña incorrecta
            //['email' => 'correo@correo.eu', 'pass' => '123456'] // Correcto
            //['email' => 'correo@correo', 'pass' => 'contraseña_incorrecta'], // Email no válido
        ];

        foreach ($testCases as $case) {
            $_POST['email'] = $case['email'];
            $_POST['pass'] = $case['pass'];
        }

        $_SERVER['REQUEST_METHOD'] = 'POST';
        */
        
        //Verificamos si se ha enviado la info por el formulario de acceso
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);

            //Validamos la contraseña del usuario
            $alertas = $usuario->validarLogin();

            //Verificamos si hay alertas
            if(empty($alertas)) {
                //No hay alertas -> se ha superado la validación
                //Comprobamos que el usuario exista en la BBDD
                $usuario = Usuario::where('email', $usuario->email);

                //Si el usuario no existe pasamos alerta
                if(!$usuario || !$usuario->confirmado) {
                    Usuario::setAlerta('error', 'El usuario no existe o no está activado');
                } else {
                    //Validación de la contraseña
                    if(password_verify($_POST['pass'], $usuario->pass)) {
                        //El usuario existe -> iniciamos sesión
                        session_start();
    
                        //Guardamos las credenciales del usuario en variables de sesión
                        $_SESSION['id_usuario'] = $usuario->id_usuario;
                        $_SESSION['nombre']     = $usuario->nombre;
                        $_SESSION['apellidos']  = $usuario->apellidos;
                        $_SESSION['email']      = $usuario->email;
                        $_SESSION['admin']      = $usuario->admin;
                        $_SESSION['login']      = true;
    
                        //Redireccionamos al interior de la aplicación
                        header('Location: /dash/home');
                        return; //cortamos la ejecución del script
                    } else {
                        Usuario::setAlerta('error', 'Contraseña incorrecta');
                    }
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/login', [
            'alertas' => $alertas,
            'titulo' => 'Login'
        ]);
    }

    public static function logout() {
        session_start();
        $_SESSION = [];
        //session_destroy();
        header('Location: /login');
    }

    /**
     * Método estático que sirve para redirigir a la página de login.
     * Método temporal para evitar errores de rutas no definidas.
     */
    public static function redirect() {
        header('Location: /login');
    }

    public static function crear(Router $router) {
        $alertas = [];
        $usuario = new Usuario();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();
            $existeUsuario = Usuario::where('email', $usuario->email);

            if(empty($alertas)) {
                //No hay alertas -> se ha superado la validación
                //Verificamos si el usuario ya existe
                if($existeUsuario) {
                    Usuario::setAlerta('error', 'El usuario ya está registrado');
                } else {
                    //El usuario no existe -> lo creamos en la BBDD
                    //Hashear el pass
                    $usuario->hashPass();

                    //Eliminar el atributo pass2
                    unset($usuario->pass2);

                    //Creamos un token para validar la cuenta
                    $usuario->crearToken();

                    //Guardamos el usuario en la BBDD
                    $resultado = $usuario->guardar('id_usuario');

                    //Mandamos mail de confirmación
                    /*
                        Lógica de PHPMailer para el envío del mail
                    */

                    if($resultado) {
                        //Redirigimos a la página de confirmación
                        self::mensaje($router, 'Usuario creado correctamente. Revisa tu correo para activar tu cuenta.');
                    } else {
                        self::mensaje($router, 'Se produjo un error en la creación del usuario. Inténtalo de nuevo.');
                    }
                }
            }

        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/crear-cuenta', [
            'titulo' => 'Crear cuenta',
            'alertas' => $alertas
        ]);
    }

    public static function mensaje(Router $router, $mensaje = '-1') {
        if($mensaje === '-1') {
            header('Location: /login');
        }

        $router->render('auth/mensaje', [
            'titulo' => 'Mensaje',
            'mensaje' => $mensaje
        ]);
    }

    public static function confirmar(Router $router) {
        if(!isset($_GET['token'])) {
            header('Location: /login');
        }
        $token = $_GET['token'];
        $alertas = [];

        $usuario = Usuario::where('token', $token);

        if(empty($usuario)) {
            Usuario::setAlerta('error', 'Token no válido');
        } else {
            //Confirmar la cuenta
            $usuario->confirmado = 1;
            $usuario->token = null;
            unset($usuario->pass2);
            $resultado = $usuario->guardar('id_usuario', $usuario->id_usuario);

            if($resultado) {
                Usuario::setAlerta('exito', 'Cuenta confirmada correctamente');
            } else {
                Usuario::setAlerta('error', 'Error al confirmar la cuenta');
            }

        }

        $alertas = Usuario::getAlertas();

        //Render a la vista
        $router->render('auth/confirmar', [
            'titulo' => 'Confirmación de cuenta',
            'alertas' => $alertas
        ]);
    }
}