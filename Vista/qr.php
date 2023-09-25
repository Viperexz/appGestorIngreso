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
            if (isset($_GET['Nombre']) && isset($_GET['Apellidos']) && isset($_GET['Cedula'])&& isset($_GET['Correo'])) {
                $nombre = $_GET['Nombre'];
                $apellidos = $_GET['Apellidos'];
                $cedula = $_GET['Cedula'];

                // Utiliza $cedula para generar el código QR
                require_once '../phpqrcode/qrlib.php';

                // Ruta donde deseas guardar el archivo QR
                $archivoQR = "qrcodes/$cedula.png";

                // Tamaño personalizado para el código QR (por ejemplo, 300x300 píxeles)
                $tamaño = 300;

                // Genera el código QR con el tamaño personalizado
                QRcode::png($cedula, $archivoQR, QR_ECLEVEL_L, $tamaño);

                // Muestra el QR en la página
                echo '<img src="' . $archivoQR . '" alt="Código QR" width="' . $tamaño . '" height="' . $tamaño . '">';
            } else {
                echo "No se proporcionaron los datos necesarios para generar el código QR.";
            }

            $correoDestino = $_GET['Correo'];

            // Asunto del correo electrónico
            $asunto = "Código QR";

            // Mensaje del correo electrónico
            $mensaje = "Hola $nombre $apellidos,\n\nAdjunto encontrarás tu código QR.";

            // Cabecera del correo electrónico
            $cabecera = "From: wwparc@parchefest.co";
            $cabecera .= "\r\nMIME-Version: 1.0";
            $cabecera .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-" . md5(time()) . "\"";

            // Contenido del correo electrónico (archivo adjunto)
            $contenidoCorreo = "--PHP-mixed-" . md5(time()) . "\r\n";
            $contenidoCorreo .= "Content-Type: multipart/alternative; boundary=\"PHP-alt-" . md5(time()) . "\"\r\n\r\n";
            $contenidoCorreo .= "--PHP-alt-" . md5(time()) . "\r\n";
            $contenidoCorreo .= "Content-Type: text/plain; charset=\"utf-8\"\r\n";
            $contenidoCorreo .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
            $contenidoCorreo .= $mensaje . "\r\n\r\n";
            $contenidoCorreo .= "--PHP-alt-" . md5(time()) . "--\r\n\r\n";
            $contenidoCorreo .= "--PHP-mixed-" . md5(time()) . "\r\n";
            $contenidoCorreo .= "Content-Type: application/octet-stream; name=\"codigo_qr.png\"\r\n";
            $contenidoCorreo .= "Content-Transfer-Encoding: base64\r\n";
            $contenidoCorreo .= "Content-Disposition: attachment\r\n\r\n";
            $contenidoCorreo .= chunk_split(base64_encode(file_get_contents($archivoQR))) . "\r\n";
            $contenidoCorreo .= "--PHP-mixed-" . md5(time()) . "--";

            // Envía el correo electrónico
            if (mail($correoDestino, $asunto, $contenidoCorreo, $cabecera)) {
                echo "<h3>Se registraron tus datos correctamente, $nombre $apellidos.</h3>";
                echo "<h4>El código QR se envió a tu correo electrónico.</h4>";
            } else {
                echo "<h3>Error al enviar el correo electrónico.</h3>";
            }


            ?>
        </div>
        <div class="col-md-4">
            <h3> Se registraron tus datos correctamente, <?php echo $nombre . ' ' . $apellidos; ?></h3>
            <h3>El QR se envió a tu correo</h3>
            <h4> Recuerda presentarlo en el evento.</h4>
        </div>
    </div>
</div>
</body>
</html>
