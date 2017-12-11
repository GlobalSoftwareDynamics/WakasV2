<?php
include('session.php');
include('declaracionFechas.php');
include ('funciones.php');
require_once __DIR__ . '/lib/mpdf/mpdf.php';

if(isset($_SESSION['login'])){
    ?>

    <?php
    $html='
            <html lang="es">
                <head>
                    <meta charset="utf-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1">    
                    <title>Confirmación de Venta</title>
                    <link href="css/bootstrap.css" rel="stylesheet">
                    <link href="css/Formatospdf.css" rel="stylesheet">
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
                </head>
                <body class="portrait">
    ';

    $result = mysqli_query($link,"SELECT * FROM OrdenProduccion WHERE idOrdenProduccion = '{$_POST['idOrdenProduccion']}'");
    while ($fila = mysqli_fetch_array($result)){
        $idContrato = $fila['idContrato'];
        $fechacreacion = $fila['fechaCreacion'];
        $fechadespacho = $fila['fechaDespacho'];
        $observacion = $fila['Observacion'];
        $result1 = mysqli_query($link,"SELECT * FROM ConfirmacionVenta WHERE idContrato = '{$idContrato}'");
        while ($fila1 = mysqli_fetch_array($result1)){
            $result2 = mysqli_query($link,"SELECT * FROM Cliente WHERE idCliente IN (SELECT idCliente FROM Contacto WHERE idContacto = '{$fila1['idContacto']}')");
            while ($fila2 = mysqli_fetch_array($result2)){
                $cliente = $fila2['nombre'];
            }
        }
        $result1 = mysqli_query($link,"SELECT * FROM Empleado WHERE idEmpleado = '{$fila['idEmpleado']}'");
        while ($fila1 = mysqli_fetch_array($result1)){
            $creador = $fila1['nombres']." ".$fila1['apellidos'];
        }
    }
    $html .="
                <div class='row'>
                    <div class='descladoizquierdo'>
                        <table>
                            <tbody>
                                <tr>
                                    <th class='text-left'>Nro. de Órden:</th>
                                    <td class='text-left'>{$_POST['idOrdenProduccion']}</td>
                                </tr>
                                <tr>
                                    <th class='text-left'>Contrato:</th>
                                    <td class='text-left'>{$idContrato}</td>
                                </tr>
                                <tr>
                                    <th class='text-left'>Cliente:</th>
                                    <td class='text-left'>{$cliente}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class='descladoderecho'>
                        <table>
                            <tbody>
                                <tr>
                                    <th class='text-left'>Fecha de Creación:</th>
                                    <td class='text-left'>{$fechacreacion}</td>
                                </tr>
                                <tr>
                                    <th class='text-left'>Creado Por:</th>
                                    <td class='text-left'>{$creador}</td>
                                </tr>
                                <tr>
                                    <th class='text-left'>Fecha de Envío:</th>
                                    <td class='text-left'>{$fechadespacho}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class='spacer20'></div>
                <div class='row'>
                    <div class='col-12'>
                        <table class='tabla text-center'>
                            <thead id='theadborder'>
                            <tr>
                                <th class='text-center'>Lote</th>
                                <th class='text-center'>idLote</th>
                                <th class='text-center'>idProducto</th>
                                <th class='text-center'>Material</th>
                                <th class='text-center'>Color</th>
                                <th class='text-center'>Talla</th>
                                <th class='text-center'>Cantidad</th>
                            </tr>
                            </thead>
                            <tbody>";
                            $aux3=1;
                            $result = mysqli_query($link,"SELECT * FROM Lote WHERE idOrdenProduccion ='{$_POST['idOrdenProduccion']}' ORDER BY posicion ASC");
                            while ($fila = mysqli_fetch_array($result)){
                                $result1 = mysqli_query($link,"SELECT * FROM ConfirmacionVentaProducto WHERE idConfirmacionVentaProducto = '{$fila['idConfirmacionVentaProducto']}'");
                                while ($fila1 = mysqli_fetch_array($result1)){
                                    $result2 = mysqli_query($link,"SELECT * FROM CombinacionesColor WHERE idCombinacionesColor = '{$fila1['idCombinacionesColor']}'");
                                    while ($fila2 = mysqli_fetch_array($result2)){
                                        $color = $fila2['descripcion'];
                                    }
                                    $result2 = mysqli_query($link,"SELECT * FROM Talla WHERE idTalla = '{$fila1['idTalla']}'");
                                    while ($fila2 = mysqli_fetch_array($result2)){
                                        $talla = $fila2['descripcion'];
                                    }
                                    $html .= "
                                        <tr>
                                            <td>{$aux3}</td>
                                            <td>{$fila['idLote']}</td>
                                            <td>{$fila1['idProducto']}</td>
                                            <td>{$fila['material']}</td>
                                            <td>{$color}</td>
                                            <td>{$talla}</td>
                                            <td>{$fila['cantidad']}</td>
                                        </tr>
                                    ";
                                }
                                $aux3++;
                            }
    $html .="
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class='spacer15'></div>
                <div class='row'>
                    <div class='observacionop'>
                         <p style='font-weight: bold'>Observaciones:</p>
                         <p>{$observacion}</p>
                    </div>
                </div>
    ";
    $html .='
        </body>
    </html>
    ';

    $htmlheader='
        <header>
            <div id="descripcionbrand">
                <img style="margin-top: 10px" width="auto" height="60" src="img/WakasNavbar.png"/>
            </div>
            <div id="tituloreporte">
                <div class="titulo">
                    <h4>Orden de Producción</h4>
                    <h5>'.$_POST['idOrdenProduccion'].'</h5>
                </div>
            </div>
        </header>
    ';
    $htmlfooter='
          <div class="footer">
                <span style="font-size: 10px;">Waka-s Textiles Finos SAC. </span>
                                   
                                 
                              
                <span style="font-size: 10px">© 2017 by Global Software Dynamics.Visítanos en <a target="GSD" href="http://www.gsdynamics.com/">GSDynamics.com</a></span>
          </div>
    ';
    $nombredearchivo=$_POST['idOrdenProduccion'].'.pdf';
    $mpdf = new mPDF('','A4',0,'','15',15,35,35,6,6);

// Write some HTML code:
    $mpdf->SetHTMLHeader($htmlheader);
    $mpdf->SetHTMLFooter($htmlfooter);
    $mpdf->WriteHTML($html);

// Output a PDF file directly to the browser
    $mpdf->Output($nombredearchivo,'D');
    ?>

    <?php
}else{
    echo "Usted no está autorizado para ingresar a esta sección. Por favor vuelva a la página de inicio de sesión e identifíquese.";
}
?>