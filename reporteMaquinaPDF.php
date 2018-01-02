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
    $result = mysqli_query($link,"SELECT * FROM Maquina WHERE descripcion = '{$_POST['idMaquina']}'");
    while ($fila = mysqli_fetch_array($result)){
        $maquina = $fila['descripcion'];
        $idMaquina = $fila['idMaquina'];
    }
    $html .='
    <div class="row">
        <div class="col-7">
            <div class="row">
                <div class="col-4">
                    <p><b>Máquina:</b></p>
                </div>
                <div class="col-8">
                    <p>'.$maquina.'</p>
                </div>
            </div>
        </div>
        <div class="col-5">
            <div class="row">
                <div class="col-4">
                    <p><b>Fecha Inicio:</b></p>
                </div>
                <div class="col-8">
                    <p>'.$_POST['fechaInicio'].'</p>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <p><b>Fecha Fin:</b></p>
                </div>
                <div class="col-8">
                    <p><'.$_POST['fechaFin'].'</p>
                </div>
            </div>
        </div>
    </div>
    <div class="spacer10"></div>
    <div class="row">
        <div class="col-12">
            <h6 class="text-left"><b>Registro de Operaciones:</b></h6>
        </div>
        <div class="spacer10"></div>
        <div class="col-12" style="height: 400px; overflow-y: auto;">
            <table class="table text-center">
                <thead>
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
        </div>
        <div class="spacer20"></div>
        <div class="col-12">
            <h6 class="text-left"><b>Tiempo de Operación: </b>'.$tiempoOperacionHrs.' Hrs.</h6>
        </div>
    </div>
    <div class="spacer10"></div>
    <div class="row">
        <div class="col-12">
            <h6 class="text-left"><b>Registro de Tiempos Muertos de Máquina:</b></h6>
        </div>
        <div class="spacer10"></div>
        <div class="col-12">
            <table class="table text-center">
                <thead>
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
                $HorasWakas1 = round($HorasWakas,0,PHP_ROUND_HALF_DOWN);
                $HorasWakas2 = $tiempoActividadMuerta-($HorasWakas1*60);
                $HorasFinalE = $HorasWakas1.":".$HorasWakas2;
    $html .='
                </tbody>
            </table>
        </div>
        <div class="spacer20"></div>
        <div class="col-12">
            <h6 class="text-left"><b>Tiempo Muerto de Máquina: </b>'.$HorasFinalE.' Hrs.</h6>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            ';
            $MinutosFinalTrabajo = explode(":",$tiempoOperacionHrs);
            $MinutosFinalTrabajo = ($MinutosFinalTrabajo[0]*60) + $MinutosFinalTrabajo[1];

            $MinutosFinalActividadMuerta = explode(":",$HorasFinalE);
            $MinutosFinalActividadMuerta = ($MinutosFinalActividadMuerta[0]*60) + $MinutosFinalActividadMuerta[1];

            $productividad =(($MinutosFinalTrabajo-$MinutosFinalActividadMuerta)/$MinutosFinalTrabajo)*100;
            $productividad = round($productividad,2);
    $html .='
            <h6 class="text-left"><b>% Referencial de Productividad de Máquina: </b>'.$productividad.' %</h6>
        </div>
    </div>';
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