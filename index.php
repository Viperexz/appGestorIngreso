<?php
require_once './Controlador/clsManejoDatos.php';

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

$sql = "INSERT INTO participantes (parCedula, parNombre, parFechaNacimiento, parTelefono, parCorreo)
VALUES ('$cedula','$nombre + $apellidos',  '$fechaNacimiento',  '$telefono','$correo')";

if ($this->manejoDatos->ejecutar($sql)) {
// Registro exitoso, redirige a la página anterior con un mensaje de éxito
header("Location: index.php?mensaje=exito");
exit;
} else {
// Error en el registro, redirige a la página anterior con un mensaje de error
header("Location: index.php?mensaje=error");
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


<!DOCTYPE html>
<html>
<head>
    <link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet"/>
    <link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.2/moment.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="Recursos/css/register.css">
    <title>Registro al evento</title>
</head>
<body>
<div class="container" id="advanced-search-form">
    <h2>Registre sus datos</h2>
    <form id="registro-form" method="POST" action="">
        <div class="form-group">
            <label for="Nombre">Nombres</label>
            <input type="text" class="form-control" placeholder="Nombres" id="Nombre" name="Nombre" required>
        </div>
        <div class="form-group">
            <label for="Apellidos">Apellidos</label>
            <input type="text" class="form-control" placeholder="Apellidos" id="Apellidos" name="Apellidos" required>
        </div>
        <div class="form-group">
            <label for="Cedula">Cedula</label>
            <input type="text" class="form-control" placeholder="Cedula" id="Cedula" name="Cedula" required>
        </div>
        <div class="form-group">
            <label>Fecha de nacimiento</label>
            <div class='input-group date' id='datetimepicker1'>
                <input type='text' class="form-control" placeholder="Fecha nacimiento" id="FN" name="FN" required>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
            <script type="text/javascript">
                $(function () {
                    $('#datetimepicker1').datetimepicker();
                });
            </script>
        </div>
        <div class="form-group">
            <label for="Correo">Correo</label>
            <input type="email" class="form-control" placeholder="Correo" id="Correo" name="Correo" required>
        </div>
        <div class="form-group">
            <label for="Telefono">Telefono</label>
            <input type="tel" class="form-control" placeholder="Telefono" id="Telefono" name="Telefono" required>
        </div>
        <div class="clearfix"></div>
        <button type="submit" class="btn btn-primary btn-responsive" id="search">Registrar</button>
    </form>
    <script>
        // Función para obtener los parámetros de la URL
        function getUrlParameter(name) {
            name = name.replace(/[[]/, '\\[').replace(/[\]]/, '\\]');
            var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
            var results = regex.exec(location.search);
            return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
        }

        // Verifica si hay un mensaje de éxito en la URL y muestra una notificación
        var mensaje = getUrlParameter('mensaje');
        if (mensaje === 'exito') {
            alert('Registro exitoso. ¡Gracias por registrarte!');
        } else if (mensaje === 'error') {
            alert('Error en el registro. Por favor, inténtalo de nuevo.');
        }
    </script>


</div>
</body>
</html>



<