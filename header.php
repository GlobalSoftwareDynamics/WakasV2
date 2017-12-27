<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Wakas Textiles Finos</title>

    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="apple-touch-icon-precomposed" href="favicon152.png">
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="favicon152.png">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="favicon144.png">
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="favicon120.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="favicon114.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="favicon72.png">
    <link rel="apple-touch-icon-precomposed" href="favicon57.png">
    <link rel="icon" href="favicon32.png" sizes="32x32">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="css/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">

    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <script src="lib/barcode/JsBarcode.all.min.js"></script>

    <?php

    if($_SERVER['REQUEST_URI'] == '/WakasV2/nuevaCV_DatosGenerales.php'){
        $arrayClientes = autocompletarEstadoActivo("Cliente","nombre",$link)

        ?>
        <script>
            $( function() {
                $( "#cliente" ).autocomplete({
                    source: <?php echo $arrayClientes?>
                });
            } );
        </script>
        <?php
    }

    if($_SERVER['REQUEST_URI'] == '/WakasV2/nuevaCV_Productos.php'){
        $arrayProductos = autocompletarEstadoActivo("Producto","idProducto",$link)

        ?>
        <script>
            $( function() {
                $( "#idProducto" ).autocomplete({
                    source: <?php echo $arrayProductos?>
                });
            } );
        </script>
        <?php
    }

    if($_SERVER['REQUEST_URI'] == '/WakasV2/reportePersonal.php'){
        $arrayProductos = autocompletarEstadoActivo("Empleado","idEmpleado",$link);
        $arrayProductos1 = autocompletarEstadoActivoDoble("Empleado","nombres","apellidos",$link);
        ?>
        <script>
            $( function() {
                $( "#idEmpleado" ).autocomplete({
                    source: <?php echo $arrayProductos?>
                });
            } );
        </script>

        <script>
            $( function() {
                $( "#nombreEmpleado" ).autocomplete({
                    source: <?php echo $arrayProductos1?>
                });
            } );
        </script>
        <?php
    }

    ?>
</head>

<body>