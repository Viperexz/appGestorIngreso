<?php
// Incluir la biblioteca PHP QR Code
include('../phpqrcode/qrlib.php');

// Definir los dos parámetros que deseas codificar en el QR
$parametro1 = "1003194727";
$parametro2 = "16052023";

// Combinar los dos parámetros en una cadena si es necesario
$datos = $parametro1 . " | " . $parametro2;

// Directorio donde se guardará el archivo QR
$dir = 'qrcodes/';

// Nombre del archivo QR
$archivoQR = $dir . 'qr_parametros.png';

// Crear el código QR
QRcode::png($datos, $archivoQR);

// Mostrar la imagen del código QR en la página
echo '<img src="' . $archivoQR . '" alt="Código QR con parámetros">';
?>
