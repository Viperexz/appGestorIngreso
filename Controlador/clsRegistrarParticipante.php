<?php
require_once 'clsManejoDatos.php'; // Asegúrate de incluir la clase clsManejoDatos

class clsRegistrarParticipante {
    private $conexion;
    private $manejoDatos;

    public function __construct() {
        $this->manejoDatos = new \Controlador\clsManejoDatos();
        $this->conexion = $this->manejoDatos->getConexion();
    }

    public function registrar($nombre, $apellidos, $cedula, $fechaNacimiento, $correo, $telefono) {
        $nombre = $this->conexion->real_escape_string($nombre);
        $apellidos = $this->conexion->real_escape_string($apellidos);
        $cedula = $this->conexion->real_escape_string($cedula);
        $fechaNacimiento = $this->conexion->real_escape_string($fechaNacimiento);
        $correo = $this->conexion->real_escape_string($correo);
        $telefono = $this->conexion->real_escape_string($telefono);

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['Nombre'];
    $apellidos = $_POST['Apellidos'];
    $cedula = $_POST['Cedula'];
    $fechaNacimiento = $_POST['FN'];
    $correo = $_POST['Correo'];
    $telefono = $_POST['Telefono'];

    if (empty($nombre) || empty($apellidos) || empty($cedula) || empty($fechaNacimiento) || empty($correo) || empty($telefono)) {
        echo "Todos los campos son obligatorios. Por favor, complete todos los campos.";
    } else {
        $registrador = new clsRegistrarParticipante();
        $registrador->registrar($nombre, $apellidos, $cedula, $fechaNacimiento, $correo, $telefono);
    }
}
?>
