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
                    <title>Reporte de Producción Lote</title>
                    <link href="css/bootstrap.css" rel="stylesheet">
                    <link href="css/Formatospdf.css" rel="stylesheet">
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
                </head>
                <body class="portrait">
    ';
    $result =  mysqli_query($link,"SELECT * FROM Lote WHERE idLote = '{$_POST['idLote']}'");
    while ($fila = mysqli_fetch_array($result)){
        $idOrdenProduccion = $fila['idOrdenProduccion'];
        $result1 = mysqli_query($link,"SELECT * FROM ConfirmacionVentaProducto WHERE idConfirmacionVentaProducto = '{$fila['idConfirmacionVentaProducto']}'");
        while ($fila1 = mysqli_fetch_array($result1)){
            $idProducto = $fila1['idProducto'];
            $idContrato = $fila1['idContrato'];
            $result2 = mysqli_query($link,"SELECT * FROM CombinacionesColor WHERE idCombinacionesColor = '{$fila1['idCombinacionesColor']}'");
            while ($fila2 = mysqli_fetch_array($result2)){
                $combinacionColor = $fila2['descripcion'];
            }
            $result2 = mysqli_query($link,"SELECT * FROM Talla WHERE idTalla = '{$fila1['idTalla']}'");
            while ($fila2 = mysqli_fetch_array($result2)){
                $talla = $fila2['descripcion'];
            }
        }
    }
    $html .='
    
    <div class="row">
        <div class="descladoizquierdo">
            <table>
                <tbody>
                    <tr>
                        <th class="text-left">Lote:</th>
                        <td class="text-left">'.$_POST['idLote'].'</td>
                    </tr>
                    <tr>
                        <th class="text-left">Orden de Producción:</th>
                        <td class="text-left">'.$idOrdenProduccion.'</td>
                    </tr>
                    <tr>
                        <th class="text-left">Contrato</th>
                        <td class="text-left">'.$idContrato.'</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="descladoderecho">
            <table>
                <tbody>
                    <tr>
                        <th class="text-left">Producto:</th>
                        <td class="text-left">'.$idProducto.'</td>
                    </tr>
                    <tr>
                        <th class="text-left">Talla:</th>
                        <td class="text-left">'.$talla.'</td>
                    </tr>
                    <tr>
                        <th class="text-left">Colores:</th>
                        <td class="text-left">'.$combinacionColor.'</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="spacer10"></div>
        <table>
            <thead>
                <tr>
                    <th>Avance del Lote:</th>
                </tr>
            </thead>
        </table>
        <div class="spacer10"></div>
            <table class="tabla text-center">
                <thead id="theadborder">
                <tr>
                    <th>Fecha - Hora</th>
                    <th>Colaborador</th>
                    <th>Componente</th>
                    <th>Procedimiento</th>
                    <th>Máquina</th>
                    <th>Cantidad</th>
                </tr>
                </thead>
                <tbody>
                ';
                $result = mysqli_query($link,"SELECT * FROM EmpleadoLote WHERE idLote = '{$_POST['idLote']}' ORDER BY fecha DESC");
                while ($fila = mysqli_fetch_array($result)){
                    $result1 = mysqli_query($link,"SELECT * FROM Empleado WHERE idEmpleado = '{$fila['idEmpleado']}'");
                    while ($fila1 = mysqli_fetch_array($result1)){
                        $nombre = $fila1['nombres']." ".$fila1['apellidos'];
                    }
                    if ($fila['idMaquina'] != NULL){
                        $result1 = mysqli_query($link,"SELECT * FROM Maquina WHERE idMaquina = '{$fila['idMaquina']}'");
                        while ($fila1 = mysqli_fetch_array($result1)){
                            $maquina = $fila1['descripcion'];
                        }
                    }else{
                        $maquina = "";
                    }
                    $result1 = mysqli_query($link,"SELECT * FROM SubProceso WHERE idProcedimiento = '{$fila['idProcedimiento']}'");
                    while ($fila1 = mysqli_fetch_array($result1)){
                        $procedimiento = $fila1['descripcion'];
                    }
                    $result1 = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE idComponente IN (SELECT idComponente FROM ProductoComponentesPrenda WHERE idComponenteEspecifico = '{$fila['idComponenteEspecifico']}')");
                    while ($fila1 = mysqli_fetch_array($result1)){
                        $componente = $fila1['descripcion'];
                    }
                    $html .="<tr>";
                    $html .="<td>{$fila['fecha']}</td>";
                    $html .="<td>{$nombre}</td>";
                    $html .="<td>{$componente}</td>";
                    $html .="<td>{$procedimiento}</td>";
                    $html .="<td>{$maquina}</td>";
                    $html .="<td>{$fila['cantidad']}</td>";
                    $html .="</tr>";
                }
    $html .='
                </tbody>
            </table>
        <div class="spacer5"></div>
    ';
            $result = mysqli_query($link,"SELECT * FROM Lote WHERE idLote = '{$_POST['idLote']}'");
            while ($fila = mysqli_fetch_array($result)){
                $result1 = mysqli_query($link,"SELECT * FROM ConfirmacionVentaProducto WHERE idConfirmacionVentaProducto = '{$fila['idConfirmacionVentaProducto']}'");
                while ($fila1 = mysqli_fetch_array($result1)){
                    $result2 = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idProducto = '{$fila1['idProducto']}'");
                    while ($fila2 = mysqli_fetch_array($result2)){
                        $result3 = mysqli_query($link,"SELECT idProducto, COUNT(DISTINCT indice) AS cantidadProcesos FROM PCPSPC WHERE idProducto = '{$fila1['idProducto']}'");
                        while ($fila3 = mysqli_fetch_array($result3)){
                            $cantidadTotal = $fila3['cantidadProcesos']*$fila['cantidad'];
                        }
                    }
                }
            }
            $result = mysqli_query($link,"SELECT SUM(cantidad) as cantidad FROM EmpleadoLote WHERE idLote = '{$_POST['idLote']}'");
            while ($fila = mysqli_fetch_array($result)){
                $cantidadAvance = $fila['cantidad'];
            }
            $porcentajeAvance = ($cantidadAvance/$cantidadTotal)*100;
            $porcentajeAvance = round($porcentajeAvance,2);
    $html .="
        <table>
            <thead>
                <tr>
                    <th class='text-right'>Porcentaje de Avance del Lote:</th>
                    <td class='text-left'>{$porcentajeAvance} %</td>
                </tr>
            </thead>
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
                    <h5>'.$_POST['idLote'].'</h5>
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
    $nombredearchivo="ReporteProduccion".$_POST['idLote'].'.pdf';
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