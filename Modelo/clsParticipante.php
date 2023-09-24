<?php

namespace Modelo;
class Participante {
    private $parCedula;
    private $parNombre;
    private $parFechaNacimiento;
    private $parTelefono;
    private $parCorreo;
    public $qr = array(); // Se utiliza un array en lugar de una colección HashSet en PHP

    public function __construct() {
        // Constructor
    }

    public function getCedula() {
        // Implementa la lógica para obtener la cédula
        return $this->parCedula;
    }

    public function getNombre() {
        // Implementa la lógica para obtener el nombre
        return $this->parNombre;
    }

    public function getFechaNacimiento() {
        // Implementa la lógica para obtener la fecha de nacimiento
        return $this->parFechaNacimiento;
    }

    public function getTelefono() {
        // Implementa la lógica para obtener el teléfono
        return $this->parTelefono;
    }

    public function getCorreo() {
        // Implementa la lógica para obtener el correo
        return $this->parCorreo;
    }

    public function getQr() {
        return $this->qr;
    }

    public function setQr($newQr) {
        $this->removeAllQr();
        foreach ($newQr as $qr) {
            $this->addQr($qr);
        }
    }

}
?>
