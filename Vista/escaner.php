<?php
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
        $sql = "SELECT qrValido FROM participante WHERE parCedula = '$cedula'";

        // Realizamos la consulta
        $resultadoConsulta = $this->manejoDatos->consultar($sql);

        if ($resultadoConsulta) {
            // Comprobamos si se obtuvo algún resultado de la consulta
            if (count($resultadoConsulta) > 0) {
                // Obtenemos el valor de qrValido desde el primer resultado
                $qrValido = $resultadoConsulta[0]['qrValido'];

                // Verificamos si qrValido es igual a 1 o 0
                if ($qrValido == 1) {
                    actualizarCodigo($cedula);
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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['qrResult'])) {
        $qrResult = $_POST['qrResult'];
        $consultSql = new clsVerificarQr();
        $consultSql -> consultarSql($qrResult);
    } else {
        echo "No se recibieron datos válidos.";
    }
} else {
    echo "Método de solicitud no válido.";


}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->

    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->

    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <title>Menu Principal</title>
</head>
<body>
<div class="container-fluid">
    <div class="row min-vh-100 flex-column flex-md-row h-100 d-inline-block">
        <aside class="col-12 col-md-2 p-0 bg-dark flex-shrink-1 ">
            <nav class="navbar navbar-expand navbar-dark bg-dark flex-md-column flex-row align-items-start py-2">
                <div class="collapse navbar-collapse ">
                    <li class="nav-item">
                        <a class="nav-link pl-0 text-nowrap" href="#"><h4 class="font-weight-bold">Gestion Ingreso</h4></a>
                    </li>fa-bullseye
                    <li class="nav-item">
                        <a class="nav-link pl-0" href="#"><i class="fa fa-book fa-fw"></i> <span class="d-none d-md-inline">Inicio</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-0" href="#"><i class="fa fa-cog fa-fw"></i> <span class="d-none d-md-inline">Escaner</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-0" href="#"><i class="fa fa-heart codeply fa-fw"></i> <span class="d-none d-md-inline">Ayuda</span></a>
                    </li>
                    </ul>
                </div>
            </nav>
        </aside>
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

                        <b>Detected QR code: </b>
                        <span id="cam-qr-result">None</span>
                        <br>
                        </p>
                    </div>
                    <!-- Segunda columna -->
                </div>
            </div>
        </main>
    </div>
</div>
</body>
</html>

<!--<script src="../qr-scanner.umd.min.js"></script>-->
<!--<script src="../qr-scanner.legacy.min.js"></script>-->
<script type="module">
    import QrScanner from "../qr-scanner-master/qr-scanner.min.js";

    const video = document.getElementById('qr-video');
    const videoContainer = document.getElementById('video-container');
    const camHasCamera = document.getElementById('cam-has-camera');
    const camQrResult = document.getElementById('cam-qr-result');
    const camList = document.getElementById('environment');
    const camQrResultTimestamp = document.getElementById('cam-qr-result-timestamp');

    function setResult(label,result) {
        console.log(result.data);
        label.textContent = result.data;
        $.ajax({
            type: 'POST',
            url: 'tu_script_php.php', // Reemplaza 'tu_script_php.php' con la URL de tu script PHP
            data: { qrResult: result.data }, // Envía el resultado como variable POST
            success: function(response) {
                console.log('Respuesta del servidor:', response);

                // Puedes hacer algo con la respuesta del servidor si es necesario
            },
            error: function(error) {
                console.error('Error al enviar datos al servidor:', error);
            }
        });
    }

    // ####### Web Cam Scanning #######

    const scanner = new QrScanner(video, result => setResult(camQrResult,result), {
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



    // Supongamos que camQrResult contiene el resultado que deseas mostrar.
    const resultado = camQrResult.textContent;

    // Abre una ventana emergente con el resultado
    const popupWindow = window.open('', '_blank', 'width=400,height=200');
    popupWindow.document.write('<p>' + resultado + '</p>');

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

