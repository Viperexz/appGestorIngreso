<?php
require_once 'clsManejoDatos.php'; // Asegúrate de incluir la clase clsManejoDatos

class clsRegistrarParticipante {
    private $conexion;
    private $manejoDatos;

    // Constructor que establece la conexión con la base de datos
    public function __construct() {
        $this->manejoDatos = new clsManejoDatos();
        $this->conexion = $this->manejoDatos->getConexion();
    }

    // Método para registrar un participante en la base de datos
    public function registrar($nombre, $apellidos, $cedula, $fechaNacimiento, $correo, $telefono) {
        // Escapar los valores para evitar inyección SQL
        $nombre = $this->conexion->real_escape_string($nombre);
        $apellidos = $this->conexion->real_escape_string($apellidos);
        $cedula = $this->conexion->real_escape_string($cedula);
        $fechaNacimiento = $this->conexion->real_escape_string($fechaNacimiento);
        $correo = $this->conexion->real_escape_string($correo);
        $telefono = $this->conexion->real_escape_string($telefono);

        // Consulta SQL para insertar los datos en la tabla "participantes"
        $sql = "INSERT INTO participantes (nombre, apellidos, cedula, fecha_nacimiento, correo, telefono) 
                VALUES ('$nombre', '$apellidos', '$cedula', '$fechaNacimiento', '$correo', '$telefono')";

        if ($this->manejoDatos->ejecutar($sql)) {
            header("Location: registro.html?mensaje=exito");
            exit;
        } else {
            header("Location: registro.html?mensaje=error");
            exit;
        }
    }
}
?>
