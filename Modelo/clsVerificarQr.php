<?php

namespace Modelo;
require_once '../Controlador/clsManejoDatos.php';

class clsVerificarQr
{
    private $manejoDatos;

    public function __construct()
    {
        $this->manejoDatos = new \Controlador\clsManejoDatos();
        $this->conexion = $this->manejoDatos->getConexion();
    }

    public function consultarSql($cedula)
    {
        // Escapamos la cédula para evitar posibles inyecciones SQL
        $cedula = $this->conexion->real_escape_string($cedula);

        // Consulta SQL para obtener el valor de qrValido
        $sql = "SELECT * FROM participante WHERE parCedula = '$cedula'";

        // Realizamos la consulta
        $resultadoConsulta = $this->manejoDatos->consultar($sql);

        if ($resultadoConsulta) {
            // Comprobamos si se obtuvo algún resultado de la consulta
            if (count($resultadoConsulta) > 0) {
                // Obtenemos el valor de qrValido desde el primer resultado
                $qrValido = $resultadoConsulta[0]['qrvalido'];
                $parNombre = $resultadoConsulta[0]['parnombre']; // Cambio aquí para obtener el nombre del primer resultado
                // Verificamos si qrValido es igual a 1 o 0
                if ($qrValido == 1) {
                    $this->actualizarCodigo($cedula);
                    echo "Se encontró la cédula";
                    echo $parNombre;
                    exit;
                } elseif ($qrValido == 0) {
                    echo "El código QR no es válido.";
                    exit;
                } else {
                    // qrValido tiene un valor diferente de 0 y 1
                    // Puedes manejar otras condiciones aquí si es necesario
                }
            } else {
                // No se encontró ningún registro con la cédula dada
                // Puedes manejar esta situación de acuerdo a tus requerimientos
                echo "No se encontró ningún registro con la cédula proporcionada.";
                exit;
            }
        } else {
            // Hubo un error en la consulta SQL
            die("Error en la consulta: " . $this->conexion->error);
        }
    }

    public function actualizarCodigo($cedula)
    {
        // Escapamos la cédula para evitar posibles inyecciones SQL
        $cedula = $this->conexion->real_escape_string($cedula);

        // Consulta SQL para actualizar qrValido a 0
        $sql = "UPDATE participante SET qrValido = 0 WHERE parCedula = '$cedula'";

        // Ejecutamos la consulta de actualización
        if ($this->manejoDatos->consultar($sql)) {
            // La actualización se realizó con éxito
            echo "Valor de qrValido actualizado a 0 correctamente.";
        } else {
            // Hubo un error en la consulta SQL de actualización
            die("Error en la consulta: " . $this->conexion->error);
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'llamarFuncion' && isset($_POST['qrResult'])) {
    $qrResult = $_POST['qrResult'];
    $consultSql = new clsVerificarQr();
    $consultSql->consultarSql($qrResult);
}
?>