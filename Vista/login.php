<?php
// Inicia la sesión si aún no se ha iniciado
require_once '../Controlador/clsManejoDatos.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['mensaje']) && $_GET['mensaje'] === 'error') {
    // Muestra el mensaje de error aquí, por ejemplo, en un div con formato
    echo '<div class="alert alert-danger">Debe iniciar sesión para acceder a esta página.</div>';
}
class clsLogin
{
    private $manejoDatos;
    public function __construct()
    {
        $this->manejoDatos = new \Controlador\clsManejoDatos();
        $this->conexion = $this->manejoDatos->getConexion();
    }
    public function Autenticacion($username, $password)
    {
        $Usuario = $this->conexion->real_escape_string($username);
        $Contra = $this->conexion->real_escape_string($password);
        $consulta = "SELECT * FROM administrador WHERE admusuario = '$Usuario' AND admcontrasena = '$Contra'";
        $resultados = $this->manejoDatos->consultar($consulta);

        if (count($resultados) === 1) {
            // Inicia la sesión y guarda la información del usuario
            session_start();
            $_SESSION['username'] = $username;
            // Redirige al usuario a la página principal
            header("Location: mainpage.php");
            exit();
        } else {

            // La autenticación falló, puedes mostrar un mensaje de error.
            $mensajeError = "Autenticación fallida. Por favor, inténtalo de nuevo.";
            header("Location: login.php?mensaje=error");
            return $mensajeError; // Devuelve el mensaje de error
        }
    }
    public function cerrarConexion()
    {
        // Cierra la conexión con la base de datos
        $this->manejoDatos->cerrarConexion();
    }
}
// Uso de la clase
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Crea una instancia de Autenticacion
    $autenticacion = new clsLogin();

    // Intenta autenticar al usuario
    $resultadoAutenticacion = $autenticacion->Autenticacion($username, $password);

    if (is_string($resultadoAutenticacion)) {
        // La autenticación falló, muestra el mensaje de error en la misma página
        echo $resultadoAutenticacion;

    }

    // Cierra la conexión con la base de datos
    $autenticacion->cerrarConexion();
}
?>


<!DOCTYPE html>
<html>

<head>
    <link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet"/>
    <link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css"
          rel="stylesheet"/>
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

</head>

<body>
<div class="container" id="log-in-form">
    <div class="heading">
        <h1>Bienvenido Administrador</h1>
    </div>
    <div class="container" id="advanced-search-form">
        <form action="" method="POST" onsubmit="return validarFormulario();">
            <!-- Agregado onsubmit para llamar a la función de validación -->
            <div class="form-group">
                <input type="text" class="form-control" id="username" name="username" placeholder="Usuario">
                <div id="aviso-username" class="aviso">Este campo es obligatorio</div>
                <!-- Mensaje de advertencia para username -->
            </div>
            <div class="form-group">
                <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña">
                <div id="aviso-password" class="aviso">Este campo es obligatorio</div>
                <!-- Mensaje de advertencia para password -->
            </div>
            <div class="form-group form-group-btn">
                <button type="submit" class="btn btn-success btn-lg">Log In</button>
            </div>
            <div class="clearfix"></div>
        </form>
    </div>

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
</div>
</body>


</html>
