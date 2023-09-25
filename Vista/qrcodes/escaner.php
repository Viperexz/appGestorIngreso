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
    <script src="https://cdn.jsdelivr.net/npm/jsqr@1.3.1/dist/jsQR.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <title>Escaner </title>
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
                        <video id="qr-video" width="100%" height="auto"></video>
                        <button id="scan-button">Escanear QR</button>
                        <div id="qr-result"></div>

                        <script>
                            const videoElement = document.getElementById('qr-video');
                            const scanButton = document.getElementById('scan-button');
                            const qrResult = document.getElementById('qr-result');

                            scanButton.addEventListener('click', () => {
                                navigator.mediaDevices.getUserMedia({ video: true })
                                    .then((stream) => {
                                        videoElement.srcObject = stream;
                                        videoElement.play();

                                        const canvas = document.createElement('canvas');
                                        canvas.width = videoElement.videoWidth;
                                        canvas.height = videoElement.videoHeight;
                                        const context = canvas.getContext('2d');
                                        context.drawImage(videoElement, 0, 0, canvas.width, canvas.height);
                                        const imageData = context.getImageData(0, 0, canvas.width, canvas.height);

                                        const code = jsQR(imageData.data, imageData.width, imageData.height);
                                        if (code) {
                                            qrResult.textContent = 'Contenido del código QR: ' + code.data;

                                            // Envía el resultado al servidor PHP utilizando AJAX
                                            $.ajax({
                                                type: 'POST',
                                                url: '', // Deja esto en blanco para enviar la solicitud al mismo archivo
                                                data: { qrData: code.data },
                                                success: function(response) {
                                                    console.log('Respuesta del servidor:', response);
                                                },
                                                error: function(error) {
                                                    console.error('Error al enviar datos al servidor:', error);
                                                }
                                            });
                                        } else {
                                            qrResult.textContent = 'No se encontró ningún código QR.';
                                        }
                                    })
                                    .catch((error) => {
                                        console.error('Error al acceder a la cámara: ', error);
                                    });
                            });
                        </script>

                        <?php
                        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['qrData'])) {
                            // Procesa el resultado del código QR en PHP
                            $qrData = $_POST['qrData'];
                            echo "<p>Datos del código QR procesados en PHP: $qrData</p>";
                        }
                        ?>
                        </script>
                    </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
</body>
</html>