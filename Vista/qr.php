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
    <link rel="stylesheet" type="text/css" href="../Recursos/css/qr.css">
    <title>Registro al evento</title>
</head>
<body>
<div class="container" id="advanced-search-form">
    <h2>Se registraron sus datos!</h2>
    <div class="row">
        <div class="col-md-6">
            <?php
            if (isset($_GET['Nombre']) && isset($_GET['Apellidos']) && isset($_GET['Cedula'])) {
                $nombre = $_GET['Nombre'];
                $apellidos = $_GET['Apellidos'];
                $cedula = $_GET['Cedula'];

                // Utiliza $cedula para generar el código QR
                require_once '../phpqrcode/qrlib.php';

                // Ruta donde deseas guardar el archivo QR
                $archivoQR = "qrcodes/$cedula.png";

                // Tamaño personalizado para el código QR (por ejemplo, 300x300 píxeles)
                $tamaño = 150;

                // Genera el código QR con el tamaño personalizado
                QRcode::png($cedula, $archivoQR, QR_ECLEVEL_L, $tamaño);

                // Muestra el QR en la página
                echo '<img src="' . $archivoQR . '" alt="Código QR" width="' . $tamaño . '" height="' . $tamaño . '">';
            } else {
                echo "No se proporcionaron los datos necesarios para generar el código QR.";
            }
            ?>
        </div>
        <div class="col-md-4">
            <h3> Se registraron tus datos correctamente, <?php echo $nombre . ' ' . $apellidos; ?>. El QR se envió a tu correo</h3>
            <h4> Recuerda presentarlo en el evento.</h4>
        </div>
    </div>
</div>
</body>
</html>
