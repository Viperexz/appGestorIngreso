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
    <h2>Registre sus datos</h2>
    <form id="registro-form">
        <div class="form-group">
            <label for="Nombre">Nombres</label>
            <input type="text" class="form-control" placeholder="Nombres" id="Nombre">
            <div class="alert alert-danger mt-2" style="display: none;" id="nombreError">Este campo es obligatorio.</div>
        </div>
        <div class="form-group">
            <label for="Apellidos">Apellidos</label>
            <input type="text" class="form-control" placeholder="Apellidos" id="Apellidos">
            <div class="alert alert-danger mt-2" style="display: none;" id="apellidosError">Este campo es obligatorio.</div>
        </div>
        <div class="form-group">
            <label for="Cedula">Cedula</label>
            <input type="text" class="form-control" placeholder="Cedula" id="Cedula">
            <div class="alert alert-danger mt-2" style="display: none;" id="cedulaError">Este campo es obligatorio.</div>
        </div>
        <div class="form-group">
            <label>Fecha de nacimiento</label>
            <div class='input-group date' id='datetimepicker1'>
                <input type='text' class="form-control" placeholder="Fecha nacimiento" id="FN" />
                <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
            </div>
            <script type="text/javascript">
                $(function () {
                    $('#datetimepicker1').datetimepicker();
                });
            </script>
            <div class="alert alert-danger mt-2" style="display: none;" id="fechaError">Este campo es obligatorio.</div>
        </div>
        <div class="form-group">
            <label for="Correo">Correo</label>
            <input type="text" class="form-control" placeholder="Correo" id="Correo">
            <div class="alert alert-danger mt-2" style="display: none;" id="correoError">Este campo es obligatorio.</div>
        </div>
        <div class="form-group">
            <label for="Telefono">Telefono</label>
            <input type="text" class="form-control" placeholder="Telefono" id="Telefono">
            <div class="alert alert-danger mt-2" style="display: none;" id="telefonoError">Este campo es obligatorio.</div>
        </div>
        <div class="clearfix"></div>
        <button type="button" class="btn btn-primary btn-responsive" id="search"></span>Registrar</button>
    </form>
</div>

<script>
    $(document).ready(function() {
        $("#search").click(function() {
            // Obtén los valores de los campos
            var nombre = $("#Nombre").val();
            var apellidos = $("#Apellidos").val();
            var cedula = $("#Cedula").val();
            var correo = $("#Correo").val();
            var telefono = $("#Telefono").val();
            var fechanacimiento = $("#FN").val();

            // Verifica y muestra avisos para campos vacíos
            if (nombre === "") {
                $("#nombreError").show();
            } else {
                $("#nombreError").hide();
            }

            if (apellidos === "") {
                $("#apellidosError").show();
            } else {
                $("#apellidosError").hide();
            }

            if (cedula === "") {
                $("#cedulaError").show();
            } else {
                $("#cedulaError").hide();
            }

            if (correo === "") {
                $("#correoError").show();
            } else {
                $("#correoError").hide();
            }

            if (telefono === "") {
                $("#telefonoError").show();
            } else {
                $("#telefonoError").hide();
            }

            if (fechanacimiento === "") {
                $("#fechaError").show();
            } else {
                $("#fechaError").hide();
            }
            // Verifica si todos los campos están llenos antes de enviar el formulario
            if (nombre === "" || apellidos === "" || cedula === "" || correo === "" || telefono === "") {
                alert("Todos los campos son obligatorios. Por favor, complete todos los campos.");
            } else {
                // Si todos los campos están llenos, puedes enviar el formulario aquí
                // $("#registro-form").subm
                // it();
            }
        });
    });
</script>
</body>
</html>
