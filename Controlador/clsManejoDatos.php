<?php

namespace Controlador;

use mysqli;
use mysqli_sql_exception;

class clsManejoDatos {
    private $conexion;

    // Constructor que establece la conexión con la base de datos
    public function __construct() {

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $this->conexion = new mysqli("localhost", "wwparc", "534R541%l", "wwparc_appgesingreso");
} catch (mysqli_sql_exception $e) {
    // Imprime el mensaje de error en la consola del navegador
    $error_message = $e->getMessage();
    echo "<script>console.error('$error_message');</script>";

    // También puedes registrar el error en el registro de errores del servidor web
    error_log("Error en la conexión MySQLi: $error_message");

    }}


    // Método para ejecutar consultas SELECT
    public function consultar($sql) {
        $resultado = $this->conexion->query($sql);

        if (!$resultado) {
            die("Error en la consulta: " . $this->conexion->error);
        }

        $datos = array();
        while ($fila = $resultado->fetch_assoc()) {
            $datos[] = $fila;
        }

        return $datos;
    }

    // Método para ejecutar consultas INSERT, UPDATE y DELETE
    public function ejecutar($sql) {
        try {
            if ($this->conexion->query($sql) === TRUE) {
                return true;
            } else {
                return false;
            }
        } catch (mysqli_sql_exception $excepcion) {
            // Maneja la excepción aquí, puedes mostrar un mensaje de error, registrar el error, etc.
            echo "Error en la ejecución de la consulta: " . $excepcion->getMessage();
            return false;
        }
    }


    // Método para cerrar la conexión con la base de datos
    public function cerrarConexion() {
        $this->conexion->close();
    }
    public function getConexion() {
        return $this->conexion;
    }
}
?>
