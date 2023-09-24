<?php
require_once './Controlador/clsManejoDatos.php';

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
