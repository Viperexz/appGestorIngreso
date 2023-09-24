<?php

namespace Modelo;
class Administrador {
    private $admCedula;
    private $admUsuario;
    private $admContrasena;

    public function getCedula() {
        // Implementa la lógica para obtener la cédula
        return $this->admCedula;
    }

    public function getUsuario() {
        // Implementa la lógica para obtener el usuario
        return $this->admUsuario;
    }

    public function getContrasena() {
        // Implementa la lógica para obtener la contraseña
        return $this->admContrasena;
    }

    public function setCedula($cedula) {
        // Implementa la lógica para establecer la cédula
        $this->admCedula = $cedula;
    }

    public function setUsuario($usuario) {
        // Implementa la lógica para establecer el usuario
        $this->admUsuario = $usuario;
    }

    public function setContrasena($contrasena) {
        // Implementa la lógica para establecer la contraseña
        $this->admContrasena = $contrasena;
    }

    // Si necesitas una relación con la clase Qr, debes agregarla aquí
    // Ejemplo: public $qr;
}
?>
