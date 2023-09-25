<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['qrData'])) {
    // Procesar los datos del código QR aquí
    $qrData = $_POST['qrData'];
    echo "Datos del código QR procesados: $qrData";
    exit; // Detiene la ejecución después de procesar los datos
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/instascan/1.0.1/instascan.min.js"></script>

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
                        <h1>Escáner de Códigos QR</h1>
                        <video id="qr-video" width="100%" height="auto"></video>
                        <div id="qr-result"></div>

                        <script>
                            const videoElement = document.getElementById('qr-video');
                            const qrResult = document.getElementById('qr-result');

                            const scanner = new Instascan.Scanner({ video: videoElement });

                            scanner.addListener('scan', function (content) {
                                qrResult.textContent = 'Contenido del código QR: ' + content;

                                // Envía el resultado al servidor PHP en el mismo archivo mediante un formulario oculto
                                const form = document.createElement('form');
                                form.method = 'POST';
                                form.action = '';
                                const input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = 'qrData';
                                input.value = content;
                                form.appendChild(input);
                                document.body.appendChild(form);
                                form.submit();
                            });

                            Instascan.Camera.getCameras().then(function (cameras) {
                                if (cameras.length > 0) {
                                    scanner.start(cameras[0]);
                                } else {
                                    console.error('No se encontraron cámaras disponibles.');
                                }
                            }).catch(function (error) {
                                console.error('Error al acceder a la cámara:', error);
                            });
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