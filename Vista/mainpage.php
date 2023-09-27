<?php
/*
if (!isset($_SESSION['usuario'])) {
    // Si el usuario no ha iniciado sesión, mostrar un mensaje de notificación
    $mensaje = "Debe iniciar sesión para acceder a esta página.";
    header("Location: login.php");
}
// Comprobar si la variable de sesión 'usuario' está definida
if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
}*/
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barra Superior</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../Recursos/css/mainpage.css">
</head>
<body>
<!-- Barra superior con Bootstrap Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <!-- Nombre de la aplicación a la izquierda -->
        <a class="navbar-brand" href="#">Gestion de ingreso - <?php echo isset($_SESSION['usuario']) ?></a>

        <!-- Botón desplegable en dispositivos móviles -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menú de navegación -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Escaner</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Ayuda</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Contenido principal -->
<div class="container">
    <div class="row">
        <h1> Bienvenido al panel administrativo. </h1>
    </div>
    <div class="row">
        <p>Recuerda que aqui podras escanear los codigos QR de los interesados del evento. Una vez escaneado el codigo quedara INVALIDADO. </p>
    </div>
    <div class="row">
        <div class="col-md-6">
            <p>Aqui podras iniciar el escaner. Recuerda validar la informacion que aparece.</p>
            <button type="button"  href="#" class="btn btn-primary">Escaner QR</button>
        </div>
        <div class="col-md-6">
            <p> Podras encontrar una guia rapida de como usar la app.</p>
            <button type="button"  href="#" class="btn btn-primary">Ayuda</button>
        </div>
    </div>


</div>

<!-- Scripts de Bootstrap y jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
