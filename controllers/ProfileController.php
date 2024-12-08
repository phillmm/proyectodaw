<?php

namespace Controllers;

use MVC\Router;
use Model\Usuario;

class ProfileController {
    public static function index(Router $router) {
        if(!is_auth()) {
            header('Location: /login');
        }

        $alertas = [];

        //Recuperamos el ID del usuario identificado
        $id_usuario = $_SESSION['id_usuario'];
        $nombre = $_SESSION['nombre']; //Nombre que se muestra en la barra superior

        //Cremos una instancia de Usuario
        $usuario = Usuario::find('id_usuario', $id_usuario);

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Verificamos si estamos actualizando nombre o contraseña
            $act_nom = isset($_POST['nom_ape']) ? $_POST['nom_ape'] : "0";
            $new_pass = isset($_POST['new_pass']) ? $_POST['new_pass'] : "0";

            if($act_nom == "1" && $new_pass == "0") {
                //Recuperamos los valores
                $nombre_act     = isset($_POST['nombre']) ? $_POST['nombre'] : "";
                $apellidos_act  = isset($_POST['apellidos']) ? $_POST['apellidos'] : "";
                
                //Asignamos los valores
                $usuario->nombre    = $nombre_act;
                $usuario->apellidos = $apellidos_act;
    
                //Validamos
                $alertas = $usuario->validarActualizar();
    
                if(empty($alertas)) {
                    //Hemos pasado la validación y actualizamos datos
                    $resultado = $usuario->actualizar('id_usuario', $id_usuario);
    
                    if($resultado) {
                        $_SESSION['nombre'] = $nombre_act;
                        Usuario::setAlerta('exito', 'Cambios guardados correctamente');
                    } else {
                        Usuario::setAlerta('error', 'No se pudieron guardar los cambios');
                    }
                }
            } elseif($act_nom == "0" && $new_pass == "1") {
                //Recuperamos los valores
                $pass_act   = isset($_POST['pass'])  ? $_POST['pass']  : "";
                $pass2_act  = isset($_POST['pass2']) ? $_POST['pass2'] : "";

                //Asignamos los valores
                $usuario->pass  = $pass_act;
                $usuario->pass2 = $pass2_act;

                //Validamos
                $alertas = $usuario->validarActualizarPass();

                if(empty($alertas)) {
                    //Hemos pasado la validación y actualizamos datos
                    $usuario->hashPass();   //Hasheamos la contraseña
                    unset($usuario->pass2); //Eliminamos el atributo pass2

                    $resultado = $usuario->actualizar('id_usuario', $id_usuario);

                    if($resultado) {
                        Usuario::setAlerta('exito', 'Contraseña actualizada correctamente');
                    } else {
                        Usuario::setAlerta('error', 'No se pudo actualizar la contraseña');
                    }
                }
            } 
        }

        $alertas = Usuario::getAlertas();

        $router->render('user/profile', [
            'titulo'    => 'Perfil',
            'nombre'    => $nombre,
            'usuario'   => $usuario,
            'profile'   => true,
            'alertas'   => $alertas
        ]);
    }
}