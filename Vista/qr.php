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
            require '../PHPMailer/src/PHPMailer.php';
            require '../PHPMailer/src/SMTP.php';
            if (isset($_GET['Nombre']) && isset($_GET['Apellidos']) && isset($_GET['Cedula']) && isset($_GET['Correo'])) {
                $nombre = $_GET['Nombre'];
                $apellidos = $_GET['Apellidos'];
                $cedula = $_GET['Cedula'];
                $correoDestino = $_GET['Correo'];

                // Utiliza $cedula para generar el código QR
                require_once '../phpqrcode/qrlib.php';

                // Ruta donde deseas guardar el archivo QR
                $archivoQR = "qrcodes/$cedula.png";

                // Tamaño personalizado para el código QR (por ejemplo, 150x150 píxeles)
                $tamaño = 150;

                // Genera el código QR con el tamaño personalizado
                QRcode::png($cedula, $archivoQR, QR_ECLEVEL_L, $tamaño);

                // Incluye la biblioteca PHPMailer
                require 'PHPMailer/PHPMailer.php';
                require 'PHPMailer/SMTP.php';

                // Crea una instancia de PHPMailer
                $mail = new PHPMailer\PHPMailer\PHPMailer();

                // Configura el servidor SMTP
                $mail->isSMTP();
                $mail->Host = 'mail.parchefest.co '; // Cambia esto al servidor SMTP correcto
                $mail->SMTPAuth = true;
                $mail->Username = '_mainaccount@parchefest.co'; // Cambia esto a tu correo
                $mail->Password = '534R541%l'; // Cambia esto a tu contraseña
                $mail->SMTPSecure = 'tls';
                $mail->Port = 465;

                // Configura el correo electrónico
                $mail->setFrom('wwparc@parchefest.co', 'Parchefest'); // Cambia esto a tu nombre y correo
                $mail->addAddress($correoDestino, $nombre); // Agrega el destinatario y su nombre
                $mail->Subject = 'Código QR';
                $mail->Body = "Hola $nombre $apellidos,\n\nAdjunto encontrarás tu código QR.";

                // Adjunta el código QR al correo
                $mail->addAttachment($archivoQR, 'codigo_qr.png');

                // Envía el correo electrónico
                if ($mail->send()) {
                    echo "<h3>Se registraron tus datos correctamente, $nombre $apellidos.</h3>";
                    echo "<h4>El código QR se envió a tu correo electrónico.</h4>";
                } else {
                    echo "<h3>Error al enviar el correo electrónico.</h3>";
                }
            }
            ?>

        </div>
    </div>
</div>
</body>
</html>
