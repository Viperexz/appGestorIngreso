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
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../Recursos/css/register.css">
    <title>Registro al evento</title>
</head>
<body>
<div class="container" id="advanced-search-form">
    <h2>Se registraron sus datos!</h2>
    <div class="row">
        <div class="col-md-6">
            <?php
            if (isset($_GET['Cedula'])) {
                $cedula = $_GET['Cedula'];

                // Utiliza $cedula para generar el código QR
                require_once 'phpqrcode/qrlib.php';

                // Ruta donde deseas guardar el archivo QR
                $archivoQR = "qrcodes/mi_qr.png";

                // Genera el código QR
                QRcode::png($cedula, $archivoQR, QR_ECLEVEL_L);

                // Muestra el QR en la página
                echo '<img src="' . $archivoQR . '" alt="Código QR">';
            } else {
                echo "No se proporcionó la variable 'Cedula' para generar el código QR.";
            }
            ?>


        </div>
        <div class="col-md-6">
            <h3> Se registraron tus datos correctmente. El QR se envio a tu correo</h3>
            <h1>

            </h1>
            <h4> Recuerda que presentarlo en el evento.</h4>
        </div>
    </div>
</div>
</body>
</html>
