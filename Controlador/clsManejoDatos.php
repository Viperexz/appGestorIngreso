<?php

namespace Controlador;


use mysqli;

class clsManejoDatos {
    private $conexion;

    // Constructor que establece la conexión con la base de datos
    public function __construct() {
        $this->conexion = new mysqli("127.0.0.1", "wwparc", "534R541%l", "wwparc_appgesingreso");

        if ($this->conexion->connect_error) {
            die("Error en la conexión a la base de datos: " . $this->conexion->connect_error);
        }
    }

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
        if ($this->conexion->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    // Método para cerrar la conexión con la base de datos
    public function cerrarConexion() {
        $this->conexion->close();
    }
}
?>
