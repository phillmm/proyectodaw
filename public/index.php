<?php

use MVC\Router;
use Controllers\DashController;
use Controllers\LibroController;
use Controllers\LoginController;
use Controllers\ProfileController;
use Controllers\PruebasController;

require_once __DIR__ . '/../includes/app.php';

$router = new Router();

//Redirecciones
$router->get('/', [LoginController::class, 'redirect']);

//Iniciar sesión
$router->get('/login', [LoginController::class, 'login']);
$router->post('/login', [LoginController::class, 'login']);

//Crear cuenta
$router->get('/crear-cuenta', [LoginController::class, 'crear']);
$router->post('/crear-cuenta', [LoginController::class, 'crear']);

//Confirmacion de cuenta
$router->get('/mensaje', [LoginController::class, 'mensaje']);
$router->get('/confirmar', [LoginController::class, 'confirmar']);

//Cerrar sesion
$router->get('/logout', [LoginController::class, 'logout']);

//Interior de la aplicación
$router->get('/dash/home',          [DashController::class, 'index']);
$router->get('/libros/crear',       [LibroController::class, 'crear']);
$router->post('/libros/crear',      [LibroController::class, 'crear']);
$router->get('/libros/catalogo',    [LibroController::class, 'catalogo']);
$router->get('/libro/ficha',        [LibroController::class, 'ficha']);

//API
$router->get('/api/libros',     [LibroController::class, 'getLibros']);

//Perfil del usuario
$router->get('/perfil',     [ProfileController::class, 'index']);
$router->post('/perfil',     [ProfileController::class, 'index']);

//Pruebas
$router->get('/pruebas/libros',             [PruebasController::class, 'libros']);
$router->get('/pruebas/usuarios',           [PruebasController::class, 'usuarios']);
$router->get('/pruebas/validar-libro',      [PruebasController::class, 'validarLibro']);

$router->comprobarRutas();