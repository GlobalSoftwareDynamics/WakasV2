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
                    <title>Reporte de Máquina</title>
                    <link href="css/bootstrap.css" rel="stylesheet">
                    <link href="css/Formatospdf.css" rel="stylesheet">
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
                </head>
                <body class="portrait">
    ';
    $result = mysqli_query($link,"SELECT * FROM Maquina WHERE descripcion = '{$_POST['idMaquina']}'");
    while ($fila = mysqli_fetch_array($result)){
        $maquina = $fila['descripcion'];
        $idMaquina = $fila['idMaquina'];
    }
    $html .='
    <div class="row">
        <div class="descladoizquierdo">
            <table>
                <tbody>
                    <tr>
                        <th class="text-left">Máquina:</th>
                        <td class="text-left">'.$maquina.'</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="descladoderecho">
            <table>
                <tbody>
                    <tr>
                        <th class="text-left">Fecha Inicio:</th>
                        <td class="text-left">'.$_POST['fechaInicio'].'</td>
                    </tr>
                    <tr>
                        <th class="text-left">Fecha Fin:</th>
                        <td class="text-left">'.$_POST['fechaFin'].'</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="spacer10"></div>
            <table>
                <tbody>
                    <tr>
                        <th class="text-left">Registro de Operaciones:</th>
                    </tr>
                </tbody>
            </table>
        <div class="spacer10"></div>
            <table class="tabla text-center">
                <thead id="theadborder">
                <tr>
                    <th>Fecha</th>
                    <th>Operador</th>
                    <th>Lote</th>
                    <th>Producto</th>
                    <th>Componente</th>
                    <th>Procedimiento</th>
                    <th>Cantidad</th>
                </tr>
                </thead>
                <tbody>
                ';
                $result = mysqli_query($link,"SELECT * FROM EmpleadoLote WHERE idMaquina = '{$idMaquina}' AND fecha >= '{$_POST['fechaInicio']}' AND fecha <= '{$_POST['fechaFin']}' ORDER BY fecha DESC");
                while ($fila = mysqli_fetch_array($result)){
                    $result1 = mysqli_query($link,"SELECT * FROM SubProceso WHERE idProcedimiento = '{$fila['idProcedimiento']}'");
                    while ($fila1 = mysqli_fetch_array($result1)){
                        $procedimiento = $fila1['descripcion'];
                    }
                    $result1 = mysqli_query($link,"SELECT * FROM Empleado WHERE idEmpleado = '{$fila['idEmpleado']}'");
                    while ($fila1 = mysqli_fetch_array($result1)){
                        $nombre = $fila1['nombres']." ".$fila1['apellidos'];
                    }
                    $result1 = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE idComponente IN (SELECT idComponente FROM ProductoComponentesPrenda WHERE idComponenteEspecifico = '{$fila['idComponenteEspecifico']}')");
                    while ($fila1 = mysqli_fetch_array($result1)){
                        $componente = $fila1['descripcion'];
                    }
                    $result1 = mysqli_query($link,"SELECT * FROM ConfirmacionVentaProducto WHERE idConfirmacionVentaProducto IN (SELECT idConfirmacionVentaProducto FROM Lote WHERE idLote = '{$fila['idLote']}')");
                    while ($fila1 = mysqli_fetch_array($result1)){
                        $producto = $fila1['idProducto'];
                    }
                    $html .="<tr>";
                    $html .="<td>{$fila['fecha']}</td>";
                    $html .="<td>{$nombre}</td>";
                    $html .="<td>{$fila['idLote']}</td>";
                    $html .="<td>{$producto}</td>";
                    $html .="<td>{$componente}</td>";
                    $html .="<td>{$procedimiento}</td>";
                    $html .="<td>{$fila['cantidad']}</td>";
                    $html .="</tr>";
                }
                $flag = false;
                $aux = 0;
                $fechaBandera = "";
                $result1 = mysqli_query($link,"SELECT DISTINCT fecha FROM EmpleadoLote WHERE idMaquina = '{$idMaquina}' AND fecha >= '{$_POST['fechaInicio']}' AND fecha <= '{$_POST['fechaFin']}' ORDER BY fecha DESC");
                while ($fila1 = mysqli_fetch_array($result1)){
                    if ($flag == false){
                        $fecha = explode(" ",$fila1['fecha']);
                        $fechaBandera = $fecha[0];
                        $aux++;
                        $flag = true;
                    }else{
                        $fecha1 = explode(" ",$fila1['fecha']);
                        if ($fechaBandera == $fecha1[0]){
                            $flag = true;
                        }else{
                            $flag = false;
                        }
                    }
                }
                $tiempoOperacionHrs = 16 * $aux;
                $tiempoOperacionHrs = $tiempoOperacionHrs.":00";

    $html .='
                </tbody>
            </table>
        <div class="spacer10"></div>
            <table>
                <tbody>
                    <tr>
                        <th class="text-left">Tiempo de Operación:</th>
                        <td class="text-right">'.$tiempoOperacionHrs.' Hrs.</td>
                    </tr>
                </tbody>
            </table>
    <div class="spacer10"></div>
            <table>
                <tbody>
                    <tr>
                        <th class="text-left">Registro de Tiempos Muertos de Máquina:</th>
                    </tr>
                </tbody>
            </table>
        <div class="spacer10"></div>
            <table class="tabla text-center">
                <thead id="theadborderB">
                <tr>
                    <th>Fecha</th>
                    <th>Operador</th>
                    <th>Actividad Muerta</th>
                    <th>Descripción</th>
                    <th>Tiempo</th>
                </tr>
                </thead>
                <tbody>
                ';
                $tiempoActividadMuerta = 0;
                $result = mysqli_query($link,"SELECT * FROM EmpleadoActividadMuerta WHERE idMaquina = '{$idMaquina}' AND fecha >= '{$_POST['fechaInicio']}' AND fecha <= '{$_POST['fechaFin']}' ORDER BY fecha DESC");
                while ($fila = mysqli_fetch_array($result)){
                    $result1 = mysqli_query($link,"SELECT * FROM Empleado WHERE idEmpleado = '{$fila['idEmpleado']}'");
                    while ($fila1 = mysqli_fetch_array($result1)){
                        $nombre = $fila1['nombres']." ".$fila1['apellidos'];
                    }
                    $result1 = mysqli_query($link,"SELECT * FROM ActividadMuerta WHERE idActividadMuerta = '{$fila['idActividadMuerta']}'");
                    while ($fila1 = mysqli_fetch_array($result1)){
                        $actividadMuerta = $fila1['descripcion'];
                    }
                    $html .="<tr>";
                    $html .="<td>{$fila['fecha']}</td>";
                    $html .="<td>{$nombre}</td>";
                    $html .="<td>{$actividadMuerta}</td>";
                    $html .="<td>{$fila['descripcion']}</td>";
                    $html .="<td>{$fila['tiempo']} Min</td>";
                    $html .="</tr>";

                    $tiempoActividadMuerta = $tiempoActividadMuerta + $fila['tiempo'];
                }
                $HorasWakas = $tiempoActividadMuerta/60;
                $HorasWakas1 = floor($HorasWakas);
                $HorasWakas2 = $tiempoActividadMuerta-($HorasWakas1*60);
                $HorasFinalE = $HorasWakas1.":".$HorasWakas2;
    $html .='
                </tbody>
            </table>
        <div class="spacer10"></div>
            <table>
                <tbody>
                    <tr>
                        <th class="text-left">Tiempo Muerto de Máquina:</th>
                        <td class="text-right">'.$HorasFinalE.' Hrs.</td>
                    </tr>
                </tbody>
            </table>
            <div class="spacer10"></div>
    <div class="row">
    ';
            $MinutosFinalTrabajo = explode(":",$tiempoOperacionHrs);
            $MinutosFinalTrabajo = ($MinutosFinalTrabajo[0]*60) + $MinutosFinalTrabajo[1];

            $MinutosFinalActividadMuerta = explode(":",$HorasFinalE);
            $MinutosFinalActividadMuerta = ($MinutosFinalActividadMuerta[0]*60) + $MinutosFinalActividadMuerta[1];

            $productividad =(($MinutosFinalTrabajo-$MinutosFinalActividadMuerta)/$MinutosFinalTrabajo)*100;
            $productividad = round($productividad,2);
    $html .='
            <table>
                <tbody>
                    <tr>
                        <th class="text-left">% Referencial de Productividad de Máquina:</th>
                        <td class="text-right">'.$productividad.' %</td>
                    </tr>
                </tbody>
            </table>
    </div>
    ';
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
                    <h4>Reporte de Máquina</h4>
                    <h5>'.$_POST['idMaquina'].'</h5>
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
    $nombredearchivo="ReporteMaquina".$_POST['idMaquina'].'.pdf';
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