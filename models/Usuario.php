<?php

namespace Model;

/**
 * Clase responsable de representar a los usuarios del sistema.
 */
class Usuario extends ActiveRecord {
    //Base de datos
    protected static $tabla = 'conf_usuarios';
    protected static $columnasDB = ['id_usuario', 'nombre', 'apellidos', 'email', 'pass', 'token', 'admin', 'confirmado'];

    //Atributos
    public $id_usuario;
    public $nombre;
    public $apellidos;
    public $email;
    public $pass;
    public $pass2; //Parámetro auxiliar para validaciones, no llega a BBDD.
    public $token;
    public $admin;
    public $confirmado;

    //Constructor
    public function __construct($args = [])
    {
        $this->id_usuario   = $args['id_usuario']   ?? null;
        $this->nombre       = $args['nombre']       ?? '';
        $this->apellidos    = $args['apellidos']    ?? '';
        $this->email        = $args['email']        ?? '';
        $this->pass         = $args['pass']         ?? '';
        $this->pass2        = $args['pass2']        ?? '';
        $this->token        = $args['token']        ?? '';
        $this->admin        = $args['admin']        ?? 0;
        $this->confirmado   = $args['confirmado']   ?? 0;
    }

    /**
     * Validación de las credenciales de acceso introduciadas por el ususario. Genera alertas para pasar por pantalla.
     * @return array $alertas con las alertas generadas en la validación del login.
     */
    public function validarLogin() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no válido';
        }
        if(!$this->pass) {
            self::$alertas['error'][] = 'La contraseña es obligatoria';
        }

        return self::$alertas;
    }

    public function validarNuevaCuenta() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }

        if(!$this->apellidos) {
            self::$alertas['error'][] = 'Los apellidos son obligatorios';
        }

        if(!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }

        if(!$this->pass) {
            self::$alertas['error'][] = 'El password es obligatorio';
        }

        if($this->pass && strlen($this->pass) < 6) {
            self::$alertas['error'][] = 'El password debe contener al menos 6 caractéres';
        }

        if($this->pass !== $this->pass2) {
            self::$alertas['error'][] = 'Los passwords no coinciden';
        }

        return self::$alertas;
    }

    public function validarActualizar() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }
        if(!$this->apellidos) {
            self::$alertas['error'][] = 'Los apellidos son obligatorios';
        }

        return self::$alertas;
    }

    public function validarActualizarPass() {
        if(!$this->pass) {
            self::$alertas['error'][] = 'La contraseña es obligatoria';
        }
        if(!$this->pass2) {
            self::$alertas['error'][] = 'La confirmación de la contraseña es obligatoria';
        }
        if($this->pass && strlen($this->pass) < 6) {
            self::$alertas['error'][] = 'El password debe contener al menos 6 caractéres';
        }
        if($this->pass !== $this->pass2) {
            self::$alertas['error'][] = 'Los passwords no coinciden';
        }
        return self::$alertas;
    }

    /**
     * Hashea el password del usuario.
     */
    public function hashPass() : void {
        $this->pass = password_hash($this->pass, PASSWORD_BCRYPT);
    }

    /**
     * Crea un token para la validación de la cuenta de usuario.
     */
    public function crearToken() : void {
        $this->token = uniqid();
    }
}
