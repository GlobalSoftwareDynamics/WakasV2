<?php
include('session.php');
include('declaracionFechas.php');
include ('funciones.php');
require_once __DIR__ . '/lib/mpdf/mpdf.php';

if(isset($_SESSION['login'])){
    ?>

    <?php
    $html .='
            <html lang="es">
                <head>
                    <meta charset="utf-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1">    
                    <title>Reporte de Producción OP</title>
                    <link href="css/bootstrap.css" rel="stylesheet">
                    <link href="css/Formatospdf.css" rel="stylesheet">
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
                </head>
                <body class="portrait">
    ';
    $result =  mysqli_query($link,"SELECT * FROM Lote WHERE idOrdenProduccion = '{$_POST['idOrdenProduccion']}'");
    while ($fila = mysqli_fetch_array($result)){
        $result1 = mysqli_query($link,"SELECT * FROM OrdenProduccion WHERE idOrdenProduccion = '{$fila['idOrdenProduccion']}'");
        while ($fila1 = mysqli_fetch_array($result1)){
            $idContrato = $fila1['idContrato'];
        }
    }
    $html .='
                    <div class="row">
                        <div class="descladoizquierdoCV">
                            <table>
                                <tbody>
                                    <tr>
                                        <th class="text-left">Orden de Producción:</th>
                                        <td class="text-left">'.$_POST['idOrdenProduccion'].'</td>
                                    </tr>
                                    <tr>
                                        <th class="text-left">Contrato:</th>
                                        <td class="text-left">'.$idContrato.'</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="spacer10"></div>
                        <table>
                            <tbody>
                                <tr>
                                    <th class="text-left">Avance de la Orden de Producción:</th>
                                </tr>
                            </tbody>
                        </table>
                        <div class="spacer10"></div>
                            <table class="tabla text-center">
                                <thead id="theadborder">
                                <tr>
                                    <th>Lote</th>
                                    <th>Producto</th>
                                    <th>Talla</th>
                                    <th>Colores</th>
                                    <th>Cantidad</th>
                                    <th>Avance</th>
                                </tr>
                                </thead>
                                <tbody>
                ';
                $avanceOrden = 0;
                $aux = 0;
                $result = mysqli_query($link,"SELECT * FROM Lote WHERE idOrdenProduccion = '{$_POST['idOrdenProduccion']}'");
                while ($fila = mysqli_fetch_array($result)){
                    $result1 = mysqli_query($link,"SELECT * FROM ConfirmacionVentaProducto WHERE idConfirmacionVentaProducto = '{$fila['idConfirmacionVentaProducto']}'");
                    while ($fila1 = mysqli_fetch_array($result1)){
                        $producto = $fila1['idProducto'];
                        $result2 = mysqli_query($link,"SELECT * FROM CombinacionesColor WHERE idCombinacionesColor = '{$fila1['idCombinacionesColor']}'");
                        while ($fila2 = mysqli_fetch_array($result2)){
                            $combinacionColor = $fila2['descripcion'];
                        }
                        $result2 = mysqli_query($link,"SELECT * FROM Talla WHERE idTalla = '{$fila1['idTalla']}'");
                        while ($fila2 = mysqli_fetch_array($result2)){
                            $talla = $fila2['descripcion'];
                        }
                        $result2 = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idProducto = '{$fila1['idProducto']}'");
                        while ($fila2 = mysqli_fetch_array($result2)){
                            $result3 = mysqli_query($link,"SELECT idProducto, COUNT(DISTINCT indice) AS cantidadProcesos FROM PCPSPC WHERE idProducto = '{$fila1['idProducto']}'");
                            while ($fila3 = mysqli_fetch_array($result3)){
                                $cantidadTotal = $fila3['cantidadProcesos']*$fila['cantidad'];
                            }
                        }
                        $result2 = mysqli_query($link,"SELECT SUM(cantidad) as cantidad FROM EmpleadoLote WHERE idLote = '{$fila['idLote']}'");
                        while ($fila2 = mysqli_fetch_array($result2)){
                            $cantidadAvance = $fila2['cantidad'];
                        }
                        $porcentajeAvance = ($cantidadAvance/$cantidadTotal)*100;
                        $porcentajeAvance = round($porcentajeAvance,2);
                    }
                    $html .="<tr>";
                    $html .="<td>{$fila['idLote']}</td>";
                    $html .="<td>{$producto}</td>";
                    $html .="<td>{$talla}</td>";
                    $html .="<td>{$combinacionColor}</td>";
                    $html .="<td>{$fila['cantidad']}</td>";
                    $html .="<td>{$porcentajeAvance} %</td>";
                    $html .="</tr>";

                    $avanceOrden += $porcentajeAvance;
                    $aux++;
                }
                $avanceOrden = $avanceOrden/$aux;
                $avanceOrden = round($avanceOrden,2);
    $html .='
                                </tbody>
                            </table>
                    <div class="spacer10"></div>
                    <table>
                        <tbody>
                            <tr>
                                <th class="text-right">% de Avance Total:</th>
                                <td class="text-left">'.$avanceOrden.' %</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="spacer10"></div>
                    <table>
                        <tbody>
                            <tr>
                                <th class="text-left">Colaboradores Involucrados:</th>
                            </tr>
                        </tbody>
                    </table>
                    <div class="spacer10"></div>
                        <table class="tabla text-center">
                            <thead id="theadborderB">
                            <tr>
                                <th>DNI</th>
                                <th>Nombre</th>
                                <th>% Contribución</th>
                            </tr>
                            </thead>
                            <tbody>
    ';
                $result = mysqli_query($link,"SELECT COUNT(*) AS cantidad FROM EmpleadoLote WHERE idLote IN (SELECT idLote FROM Lote WHERE idOrdenProduccion = '{$_POST['idOrdenProduccion']}')");
                while ($fila = mysqli_fetch_array($result)){
                    $cantidadProcesos = $fila['cantidad'];
                }
                $result = mysqli_query($link,"SELECT idEmpleado, COUNT(*) AS cantidad FROM EmpleadoLote WHERE idLote IN (SELECT idLote FROM Lote WHERE idOrdenProduccion = '{$_POST['idOrdenProduccion']}')");
                while ($fila = mysqli_fetch_array($result)){
                    $result1 = mysqli_query($link,"SELECT * FROM Empleado WHERE idEmpleado = '{$fila['idEmpleado']}'");
                    while ($fila1 = mysqli_fetch_array($result1)){
                        $nombre = $fila1['nombres']." ".$fila1['apellidos'];
                    }
                    $participacion = ($fila['cantidad']/$cantidadProcesos)*100;
                    $participacion = round($participacion,2);
                    $html .="<tr>";
                    $html .="<td>{$fila['idEmpleado']}</td>";
                    $html .="<td>{$nombre}</td>";
                    $html .="<td>{$participacion} %</td>";
                    $html .="</tr>";
                }
    $html .="
                        </tbody>
                    </table>
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
                    <h4>Reporte de Producción</h4>
                    <h5>'.$_POST['idOrdenProduccion'].'</h5>
                </div>
            </div>
        </header>
    ';
    $htmlfooter ='
          <div class="footer">
                <span style="font-size: 10px;">Waka-s Textiles Finos SAC. </span>
                                   
                                 
                              
                <span style="font-size: 10px">© 2017 by Global Software Dynamics.Visítanos en <a target="GSD" href="http://www.gsdynamics.com/">GSDynamics.com</a></span>
          </div>
    ';
    $nombredearchivo="ReporteProduccion".$_POST['idOrdenProduccion'].'.pdf';
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