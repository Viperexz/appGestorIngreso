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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>

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
                        <video id="scanner" style="width: 100%; height: auto;"></video>
                        <div id="result"></div>

                        <script>
                            let scanning = true; // Variable de control

                            Quagga.init({
                                inputStream: {
                                    name: "Live",
                                    type: "LiveStream",
                                    target: document.querySelector("#scanner")
                                },
                                decoder: {
                                    readers: ["code_128_reader", "ean_reader", "ean_8_reader", "code_39_reader", "code_39_vin_reader", "codabar_reader", "upc_reader", "upc_e_reader", "i2of5_reader", "2of5_reader", "code_93_reader"]
                                }
                            });

                            Quagga.onDetected(function(result) {
                                if (scanning) {
                                    const code = result.codeResult.code;
                                    document.querySelector("#result").textContent = "Código de barras detectado: " + code;

                                    // Envía el resultado al servidor PHP en el mismo archivo mediante un formulario oculto
                                    const form = document.createElement('form');
                                    form.method = 'POST';
                                    form.action = '';
                                    const input = document.createElement('input');
                                    input.type = 'hidden';
                                    input.name = 'barcodeData';
                                    input.value = code;
                                    form.appendChild(input);
                                    document.body.appendChild(form);
                                    form.submit();

                                    scanning = false; // Detener el escaneo
                                }
                            });

                            Quagga.start();
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