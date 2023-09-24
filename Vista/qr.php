<?php
// Definir los dos parámetros que deseas codificar en el QR
$parametro1 = "Valor1";
$parametro2 = "Valor2";

// Combinar los dos parámetros en una cadena si es necesario
$datos = $parametro1 . " | " . $parametro2;

// Directorio donde se guardará el archivo QR
$dir = 'qrcodes/';

// Nombre del archivo QR
$archivoQR = $dir . 'qr_parametros.png';

// Verificar si el directorio existe; si no, créalo
if (!is_dir($dir)) {
    mkdir($dir, 0755, true); // Establece permisos de escritura adecuados (0755)
}

// Crear el código QR
if (QRcode::png($datos, $archivoQR)) {
    echo 'El código QR se ha generado correctamente.';
} else {
    echo 'Hubo un problema al generar el código QR.';
}

// Verificar si la extensión GD está habilitada
if (extension_loaded('gd')) {
    echo 'La extensión GD está habilitada en PHP.';
} else {
    echo 'La extensión GD no está habilitada en PHP.';
}


?>
