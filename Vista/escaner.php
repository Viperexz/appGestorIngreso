<?php
session_start();
if (!isset($_SESSION['username'])) {
    // Si el usuario no ha iniciado sesión, mostrar un mensaje de notificación
    $mensaje = "Debe iniciar sesión para acceder a esta página.";
    header("Location: login.php?mensaje=error");
    exit; // Añade esta línea para evitar que el código se ejecute más allá de este punto
}

if (isset($_GET['mensaje']) && $_GET['mensaje'] === 'error') {
    // Muestra el mensaje de error aquí, por ejemplo, en un div con formato
    echo '<div class="alert alert-danger">No se encontro su cedula. </div>';
}

if (isset($_GET['mensaje']) && $_GET['mensaje'] === 'error2') {
    // Muestra el mensaje de error aquí, por ejemplo, en un div con formato
    echo '<div class="alert alert-danger">Error al actualizar</div>';
}

if (isset($_GET['mensaje']) && $_GET['mensaje'] === 'error1') {
    // Muestra el mensaje de error aquí, por ejemplo, en un div con formato
    echo '<div class="alert alert-danger">Codigo no valido </div>';
}


if (isset($_GET['Nombre']) && $_GET['mensaje'] === 'UsuarioValidado') {
    $nombre = $_GET['Nombre'];
    // Muestra el mensaje de éxito aquí con un identificador único
    echo '<div id="exitoAlert" class="alert alert-success">El código se validó exitosamente, bienvenido ' . $nombre . '</div>';
}
require_once '../Controlador/clsManejoDatos.php';

class clsVerificarQr
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
            if ($qrValido == "1") {
                $this->actualizarCodigo($cedula, $parNombre);
                exit;
            } elseif ($qrValido == "2") {
                header("Location: escaner.php?mensaje=error1");
            } else {
                header("Location: escaner.php?mensaje=error");
            }
        }
    }

    public function actualizarCodigo($cedula, $prmNombre)
    {
        $varCedula = $this->conexion->real_escape_string($cedula);
        $sql = "UPDATE participante SET qrValido = 0 WHERE parCedula = '$varCedula'";

        if ($this->manejoDatos->consultar($sql)) {
            // La actualización se realizó con éxito
            header("Location: escaner.php?mensaje=UsuarioValidado&Nombre=$prmNombre");
        } else {
            header("Location: escaner.php?mensaje=error2");
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $qrResult = $_POST['input-dato'];
    $consultSql = new clsVerificarQr();
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
                    <a class="nav-link" href="#">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="escaner.php">Escaner</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ayuda.php">Ayuda</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<main class="col bg-faded py-3 flex-grow-1">
    <h2>Escaner: </h2>
    <div class="container">
        <div class="row">
            <!-- Primera columna -->
            <div class="col-md-6">
                <p>
                <div id="video-container">
                    <video id="qr-video" style="max-width: 100%;" playsinline></video>
                </div>

                <b>Cedula consultada.</b>
                <span id="cam-qr-result">None</span>
                <form id="miFormulario" action="" method="POST">
                    <input type="text" id="input-dato" name="input-dato">
                    <input type="submit" value="Confirmar Cedula.">
                </form>

                </p>

                <div id="ventanaEmergente" class="modal">
                    <div class="modal-contenido">
                        <span class="cerrar" id="cerrarVentanaEmergente">&times;</span>
                        <div id="errorAlertContent"></div>
                    </div>
                </div>
            </div>
            <!-- Segunda columna -->
        </div>
    </div>
</main>
</div>
</div>
</body>
</html>
<script type="module">
    import QrScanner from "../qr-scanner-master/qr-scanner.min.js";

    const video = document.getElementById('qr-video');
    const videoContainer = document.getElementById('video-container');
    const camHasCamera = document.getElementById('cam-has-camera');
    const camQrResult = document.getElementById('cam-qr-result');
    const txtCedula = document.getElementById('input-dato');
    const camList = document.getElementById('environment');
    const camQrResultTimestamp = document.getElementById('cam-qr-result-timestamp');


    function setResult(label, inputElement, result) {
        console.log(result.data);
        label.textContent = result.data;
        inputElement.value = result.data;
    }

    const scanner = new QrScanner(video, result => setResult(camQrResult, txtCedula, result), {
        onDecodeError: error => {
            camQrResult.textContent = error;
            camQrResult.style.color = 'inherit';
        },
        highlightScanRegion: true,
        highlightCodeOutline: true,
    });

    scanner.start().then(() => {
        updateFlashAvailability();
        // List cameras after the scanner started to avoid listCamera's stream and the scanner's stream being requested
        // at the same time which can result in listCamera's unconstrained stream also being offered to the scanner.
        // Note that we can also start the scanner after listCameras, we just have it this way around in the demo to
        // start the scanner earlier.
        QrScanner.listCameras(true).then(cameras => cameras.forEach(camera => {
            const option = document.createElement('option');
            option.value = camera.id;
            option.text = camera.label;
            camList.add(option);
        }));
    });

    QrScanner.hasCamera().then(hasCamera => camHasCamera.textContent = hasCamera);

    // for debugging
    window.scanner = scanner;
    document.getElementById('scan-region-highlight-style-select').addEventListener('change', (e) => {
        videoContainer.className = e.target.value;
        scanner._updateOverlay(); // reposition the highlight because style 2 sets position: relative
    });
    document.getElementById('show-scan-region').addEventListener('change', (e) => {
        const input = e.target;
        const label = input.parentNode;
        label.parentNode.insertBefore(scanner.$canvas, label.nextSibling);
        scanner.$canvas.style.display = input.checked ? 'block' : 'none';
    });

    function mostrarMensajeEnVentanaEmergente(mensaje) {
        var ventanaEmergente = document.getElementById('ventanaEmergente');
        var mensajeAlertContent = document.getElementById('mensajeAlertContent');

        mensajeAlertContent.innerHTML = mensaje;
        ventanaEmergente.style.display = 'block';
    }

    // Verificar si existe el elemento de error en la página
    var errorAlert = document.getElementById('errorAlert');
    if (errorAlert) {
        // Obtener el contenido del elemento de error
        var errorContent = errorAlert.innerHTML;

        // Mostrar el mensaje de error en la ventana emergente
        mostrarMensajeEnVentanaEmergente(errorContent);
    }

    // Verificar si existe el elemento de éxito en la página
    var exitoAlert = document.getElementById('exitoAlert');
    if (exitoAlert) {
        // Obtener el contenido del elemento de éxito
        var exitoContent = exitoAlert.innerHTML;

        // Mostrar el mensaje de éxito en la ventana emergente
        mostrarMensajeEnVentanaEmergente(exitoContent);
    }

    // Cerrar la ventana emergente al hacer clic en el botón de cerrar
    var cerrarVentanaEmergente = document.getElementById('cerrarVentanaEmergente');
    cerrarVentanaEmergente.addEventListener('click', function () {
        ventanaEmergente.style.display = 'none';
    });

    // Cerrar la ventana emergente al hacer clic en el botón de cerrar


</script>

<style>
    div {
        margin-bottom: 16px;
    }

    #video-container {
        line-height: 0;
    }

    #video-container.example-style-1 .scan-region-highlight-svg,
    #video-container.example-style-1 .code-outline-highlight {
        stroke: #64a2f3 !important;
    }

    #video-container.example-style-2 {
        position: relative;
        width: max-content;
        height: max-content;
        overflow: hidden;
    }

    #video-container.example-style-2 .scan-region-highlight {
        border-radius: 30px;
        outline: rgba(0, 0, 0, .25) solid 50vmax;
    }

    #video-container.example-style-2 .scan-region-highlight-svg {
        display: none;
    }

    #video-container.example-style-2 .code-outline-highlight {
        stroke: rgba(255, 255, 255, .5) !important;
        stroke-width: 15 !important;
        stroke-dasharray: none !important;
    }

    #flash-toggle {
        display: none;
    }

    hr {
        margin-top: 32px;
    }

    input[type="file"] {
        display: block;
        margin-bottom: 16px;
    }
</style>
</body>
</html>

