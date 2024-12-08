<?php
namespace Model;

use Dotenv\Parser\Value;

#[\AllowDynamicProperties]
class ActiveRecord {
    //Base de datos
    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];

    //Array para alertas
    protected static $alertas = [];
    
    //Definir la conexión a la BD - includes/database.php
    public static function setDB($database) {
        self::$db = $database;
    }

    /**
     * Método para crear nuevas alertas.
     * @param string $tipo parámetro para indicar el tipo de alerta, y estilos CSS que se le aplicarán,
     * 'exito' para alertas correctas, 'error' para mensajes de fallo.
     * @param string $mensaje parámetro con el mensaje que se quiere mostrar por pantalla. 
     */
    public static function setAlerta($tipo, $mensaje) {
        static::$alertas[$tipo][] = $mensaje;
    }

    /**
     * Método que devuelve el array de alertas con todas las alertas alamacenadas.
     */
    public static function getAlertas() {
        return static::$alertas;
    }

    // Validación que se hereda en modelos
    public function validar() {
        static::$alertas = [];
        return static::$alertas;
    }

    
    /**
     * Método para consultar la base de datos y obtener resultados.
     * 
     * @param string $query La consulta SQL que se desea ejecutar.
     * @return array Un array de objetos que representan los registros obtenidos de la base de datos.
     */
    public static function consultarSQL($query) {
        // Consultar la base de datos
        $resultado = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        // liberar la memoria
        $resultado->free();

        // retornar los resultados
        return $array;
    }

    
    /**
     * Método protegido para crear un objeto a partir de un registro de la base de datos.
     * 
     * @param array $registro Un array asociativo que representa un registro de la base de datos,
     * donde las claves son los nombres de las propiedades del objeto y los valores son los datos correspondientes.
     * 
     * @return static Devuelve una instancia del objeto creado con los atributos del registro.
     */
    protected static function crearObjeto($registro) {
        $objeto = new static;

        foreach($registro as $key => $value ) {
            if(property_exists( $objeto, $key  )) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    // Identificar y unir los atributos de la BD
    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    // Sanitizar los datos antes de guardarlos en la BD
    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach($atributos as $key => $value ) {
            $sanitizado[$key] = is_null($value) ? null : self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    // Sincroniza BD con Objetos en memoria
    public function sincronizar($args=[]) { 
        foreach($args as $key => $value) {
          if(property_exists($this, $key) && !is_null($value)) {
            $this->$key = $value;
          }
        }
    }

    // Registros - CRUD
    /**
     * Función para guardar un nuevo regirsto en la base de datos. Si el registro ya existe, se actualiza.
     * @param string $columna nombre de la columna con el id del registro. Por defecto se pasa 'id'.
     * @return boolean Devuelve true si el registro se ha guardado o actualizado correctamente, false en caso contrario.
     */
    public function guardar($columna = 'id', $valor = '') {
        $resultado = '';
        if(!is_null($this->$columna)) {
            // actualizar
            $resultado = $this->actualizar($columna, $valor);
        } else {
            // Creando un nuevo registro
            $resultado = $this->crear();
        }
        return $resultado;
    }

    /**
     * Método que entrega todos los registros de la tabla.
     * @param string $id columna por la que se realiza la ordenación, si no se indica nada usa 'id'.
     * @param string $orden criterio de ordenación de los registros, si no se indica nada usa 'DESC'.
     */
    public static function all($id = 'id', $orden = 'DESC') {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY $id $orden";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busca un registro por su id
    public static function find($columna, $id) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE $columna = $id";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    // Obtener Registros con cierta cantidad
    public static function get($limite) {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id DESC LIMIT $limite" ;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Paginar los registros
    // Offset -> permite saltar cierta cantidad de registros e ignorarlos para tener la paginación
    public static function paginar($reg_por_pagina, $offset) {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id DESC LIMIT $reg_por_pagina OFFSET $offset" ;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    /**
     * Método estático que obtiene un único registro de la base de datos a partir de una columna y valor.
     * @param string $columna Columna de la base de datos en la que se va a realizar la búsqueda.
     * @param string $valor Valor a partir del cual se realizará la búsqueda.
     * @return - datos del registro buscado.
     */
    public static function where($columna, $valor) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE $columna = '$valor'";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado) ;
    }

    /**
     * Método estático que obtiene todos los registros de la base de datos que coinciden con el criterio establecido.
     * @param string $columna Columna de la base de datos en la que se va a realizar la búsqueda.
     * @param string $valor Valor a partir del cual se realizará la búsqueda.
     * @return - datos del registro buscado.
     */
    public static function whereMultiple($columna, $valor) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE $columna = '$valor'";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    //Retornar los registros por un orden
    public static function ordenar($columna, $orden) {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY $columna $orden ";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    //Retornar por orden y con un límite
    public static function ordenarLimite($columna, $orden, $limite) {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY $columna $orden LIMIT $limite";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busqueda Where con múltiples opciones
    public static function whereArray($array = []) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE ";
        foreach($array as $key => $value) {
            if($key == array_key_last($array)) {
                $query .= " $key = '$value'";
            } else {
                $query .= " $key = '$value' AND ";
            }
        }
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Traer un total de registros
    public static function total($columna = '', $valor = '') {
        $query = "SELECT COUNT(*) FROM " . static::$tabla;

        if($columna) {
            $query .= " WHERE $columna = $valor";
        }

        $resultado = self::$db->query($query);
        $total = $resultado->fetch_array();
        return array_shift($total);
    }

    // Total de registros con un Array Where
    public static function totalArray($array = []) {
        $query = "SELECT COUNT(*) FROM " . static::$tabla . " WHERE ";

        foreach($array as $key => $value) {
            if($key == array_key_last($array)) {
                $query .= " $key = '$value'";
            } else {
                $query .= " $key = '$value' AND ";
            }
        }

        $resultado = self::$db->query($query);
        $total = $resultado->fetch_array();
        return array_shift($total);
    }

    // crea un nuevo registro
    public function crear() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Insertar en la base de datos
        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES ( "; 
        $query .= join(", ", array_map(function($value) {
                    return is_null($value) ? 'NULL' : "'" . $value . "'";
                  }, array_values($atributos)));
        $query .= " ) ";

        //debuguear($query); // Descomentar si no te funciona algo

        // Resultado de la consulta
        $resultado = self::$db->query($query);
        return [
           'resultado' =>  $resultado,
           'id' => self::$db->insert_id
        ];
    }

    /**
     * Método que permite actualizar un registro en la base de datos.
     * @param string $columna Nombre de la columna en la que se va a realizar la actualización.
     * @param string $valor Valor identificativo de la columna en la que se va a realizar la actualización.
     * @return boolean Devuelve true si la actualización se ha realizado correctamente, false en caso contrario.
     */
    public function actualizar($columna, $valor) {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Iterar para ir agregando cada campo de la BD
        $valores = [];
        foreach($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        // Consulta SQL
        $query = "UPDATE " . static::$tabla ." SET ";
        $query .=  join(', ', $valores );
        $query .= " WHERE $columna = '" . self::$db->escape_string($valor) . "' ";
        $query .= " LIMIT 1 "; 
        //debuguear($query);

        // Actualizar BD
        $resultado = self::$db->query($query);
        return $resultado;
    }

    // Eliminar un Registro por su ID
    public function eliminar() {
        $query = "DELETE FROM "  . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);
        return $resultado;
    }
}