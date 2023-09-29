<?php
/**session_start();
 * if (!isset($_SESSION['username'])) {
 * // Si el usuario no ha iniciado sesión, mostrar un mensaje de notificación
 * $mensaje = "Debe iniciar sesión para acceder a esta página.";
 * header("Location: login.php?mensaje=error");
 * }**/

if (isset($_GET['mensaje']) && $_GET['mensaje'] === 'error') {
    // Muestra el mensaje de error aquí, por ejemplo, en un div con formato
    echo '<div class="alert alert-danger">No se encontro su cedula. </div>';
}
require_once '../Controlador/clsManejoDatos.php';

class clsConsultas
{

    private $manejoDatos;

    public function __construct()
    {
        $this->manejoDatos = new \Controlador\clsManejoDatos();
        $this->conexion = $this->manejoDatos->getConexion();
    }

    public function consultarSql($prmCedula)
    {
        $cedula = $this->conexion->real_escape_string($prmCedula);
        $sql = "SELECT parnombre,qrvalido FROM participante WHERE parcedula = '$cedula'";
        // Realizamos la consulta
        $resultadoConsulta = $this->manejoDatos->consultar($sql);

        if (count($resultadoConsulta) > 0) {
            // Obtenemos el valor de qrValido desde el primer resultado
            $qrValido = $resultadoConsulta[0]["qrvalido"];
            $parNombre = $resultadoConsulta[0]["parnombre"];
            header("Location: consultar.php?mensaje=encontrado&Nombre=$parNombre&Cedula=$prmCedula&qrValido=$qrValido");
        } else {
            header("Location: consultar.php?mensaje=error");
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $qrResult = $_POST['inCedula'];
    $consultSql = new clsConsultas();
    $consultSql->consultarSql($qrResult);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barra Superior</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../Recursos/css/mainpage.css">
</head>
<body>
<!-- Barra superior con Bootstrap Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <!-- Nombre de la aplicación a la izquierda -->
        <a class="navbar-brand" href="#">Gestion de ingreso - <?php echo isset($_SESSION['username']) ?></a>

        <!-- Botón desplegable en dispositivos móviles -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menú de navegación -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="mainpage.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="escaner.php">Escaner</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="consultar.php">Ayuda</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row">
        <h1> Consultas: </h1>
    </div>
    <div class="row">
        <div class="col-md-6">
            <form id="ConsultaCedula" action="" method="POST">
                <input type="text" id="inCedula" name="inCedula">
                <input type="submit" value="Consultar cedula">
            </form>
        </div>
    </div>
    <div class="row"
    <div class="col-md-6">
        <table border="1px">
            <tr>
                <th>Cedula</th>
                <th>Nombre</th>
                <th>Codigo valido?</th>
            </tr>
            <?php
            if (
                isset($_GET['Nombre']) &&
                isset($_GET['qrValido']) &&
                isset($_GET['Cedula']) &&
                $_GET['mensaje'] === 'encontrado'
            ) {
                $nombre = $_GET['Nombre'];
                $qrValido = $_GET['qrValido'];
                $cedula = $_GET['Cedula'];
                // Your code for handling these variables goes here
            }
            echo "<tr>";
            echo "<td>" . $cedula . "</td>"; // Cedula
            echo "<td>" . $nombre . "</td>"; // Nombre
            echo "<td>" . $qrValido . "</td>"; // Código válido
            echo "</tr>"


            ?>

        </table>
    </div>
</div>
</div>

<!-- Scripts de Bootstrap y jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>