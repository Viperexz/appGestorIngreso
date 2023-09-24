<?php
require_once 'clsManejoDatos.php';

class clsLogin {
    private $manejoDatos;

    public function __construct() {
        // Inicializa la instancia de clsManejoDatos
        $this->manejoDatos = new \Controlador\clsManejoDatos();
}

public function autenticar($username, $password) {
// Realiza la autenticación aquí
$consulta = "SELECT * FROM administrador WHERE admUsuario = '$username' AND admContrasena = '$password'";
$resultados = $this->manejoDatos->consultar($consulta);

if (count($resultados) === 1) {
header("Location: mainpage.html");
exit();
} else {
// La autenticación falló
return false;
}
}

public function cerrarConexion() {
// Cierra la conexión con la base de datos
$this->manejoDatos->cerrarConexion();
}
}

// Uso de la clase
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$username = $_POST['username'];
$password = $_POST['password'];

// Crea una instancia de Autenticacion
$autenticacion = new Autenticacion('tu_host', 'tu_usuario_bd', 'tu_contraseña_bd', 'tu_base_de_datos');

// Intenta autenticar al usuario
if ($autenticacion->autenticar($username, $password)) {
// La autenticación es exitosa, puedes redirigir a una página de inicio o realizar otras acciones.
header("Location: mainpage.php");
exit();
} else {
// La autenticación falló, puedes mostrar un mensaje de error.
echo "Autenticación fallida. Por favor, inténtalo de nuevo.";
}

// Cierra la conexión con la base de datos
$autenticacion->cerrarConexion();
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

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administrador</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../Recursos/css/login.css">
    <style>
        /* Estilos para los mensajes de advertencia */
        .aviso {
            color: red;
            display: none;
        }
    </style>
    <script>
        function validarFormulario() {
            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;

            // Mensajes de advertencia
            var avisoUsername = document.getElementById("aviso-username");
            var avisoPassword = document.getElementById("aviso-password");

            // Restablece los mensajes de advertencia a su estado inicial
            avisoUsername.style.display = "none";
            avisoPassword.style.display = "none";

            if (username === "") {
                avisoUsername.style.display = "block";
                return false; // Evita que el formulario se envíe si username está vacío.
            }

            if (password === "") {
                avisoPassword.style.display = "block";
                return false; // Evita que el formulario se envíe si password está vacío.
            }
        }
    </script>
</head>

<body>
<div class="container" id="log-in-form">
    <div class="heading">
        <h1>Bienvenido Administrador</h1>
    </div>
    <form action="../Controlador/clsLogin.php" method="POST" onsubmit="return validarFormulario();"> <!-- Agregado onsubmit para llamar a la función de validación -->
        <div class="form-group">
            <input type="text" class="form-control" id="username" name="username" placeholder="Usuario">
            <div id="aviso-username" class="aviso">Este campo es obligatorio</div> <!-- Mensaje de advertencia para username -->
        </div>
        <div class="form-group">
            <input type="password" class="form-control" id="pwd" name="password" placeholder="Contraseña">
            <div id="aviso-password" class="aviso">Este campo es obligatorio</div> <!-- Mensaje de advertencia para password -->
        </div>
        <div class="form-group form-group-btn">
            <button type="submit" class="btn btn-success btn-lg">Log In</button>
        </div>
        <div class="clearfix"></div>
    </form>
</div>
</body>

</html>
