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
                    <title>Reporte de Personal</title>
                    <link href="css/bootstrap.css" rel="stylesheet">
                    <link href="css/Formatospdf.css" rel="stylesheet">
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
                </head>
                <body class="portrait">
    ';
    $result = mysqli_query($link,"SELECT * FROM Empleado WHERE idEmpleado = '{$_POST['idEmpleado']}'");
    while ($fila = mysqli_fetch_array($result)){
        $nombreCompleto = $fila['nombres']." ".$fila['apellidos'];
    }
    $html .='
    <div class="row">
        <div class="descladoizquierdo">
            <table>
                <tbody>
                    <tr>
                        <th class="text-left">DNI:</th>
                        <td class="text-left">'.$_POST['idEmpleado'].'</td>
                    </tr>
                    <tr>
                        <th class="text-left">Nombre Completo:</th>
                        <td class="text-left">'.$nombreCompleto.'</td>
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
                        <th class="text-left">Registro de Ingresos y Salidas:</th>
                    </tr>
                </tbody>
            </table>
        <div class="spacer10"></div>
            <table class="tabla text-center">
                <thead id="theadborder">
                <tr>
                    <th>Fecha</th>
                    <th>Ingreso</th>
                    <th>Salida</th>
                    <th>Tiempo de Trabajo</th>
                </tr>
                </thead>
                <tbody>
                ';
                $tiempoTotalIntervalo = 0;
                $result = mysqli_query($link,"SELECT * FROM RegistroIngresoSalida WHERE idEmpleado = '{$_POST['idEmpleado']}' AND fecha >= '{$_POST['fechaInicio']}' AND fecha <= '{$_POST['fechaFin']}'");
                while ($fila = mysqli_fetch_array($result)){
                    $a = new DateTime($fila['horaSalida']);
                    $b = new DateTime($fila['horaIngreso']);
                    $interval = $a->diff($b);

                    $tiempoTotal = $interval->format("%H:%I");

                    $html .="<tr>";
                    $html .="<td>{$fila['fecha']}</td>";
                    $html .="<td>{$fila['horaIngreso']}</td>";
                    $html .="<td>{$fila['horaSalida']}</td>";
                    $html .="<td>{$tiempoTotal}</td>";
                    $html .="</tr>";

                    $tiempoExplode = explode(":",$tiempoTotal);
                    $MinutosWakas = ($tiempoExplode[0]*60)+$tiempoExplode[1];

                    $tiempoTotalIntervalo = $tiempoTotalIntervalo + $MinutosWakas;
                }
                $HorasWakas = $tiempoTotalIntervalo/60;
                $HorasWakas1 = floor($HorasWakas);
                $HorasWakas2 = $tiempoTotalIntervalo-($HorasWakas1*60);
                $HorasFinalE = $HorasWakas1.":".$HorasWakas2;
    $html .='
                <tr>
                    <th>Total Horas Trabajadas</th>
                    <td></td>
                    <td></td>
                    <td>'.$HorasFinalE.' Hrs.</td>
                </tr>
                </tbody>
            </table>
    <div class="spacer10"></div>
            <table>
                <tbody>
                    <tr>
                        <th class="text-left">Registro de Actividades Realizadas:</th>
                    </tr>
                </tbody>
            </table>
        <div class="spacer10"></div>
            <table class="tabla text-center">
                <thead id="theadborderB">
                <tr>
                    <th>Fecha y Hora</th>
                    <th>Lote</th>
                    <th>Componente</th>
                    <th>Procedimiento</th>
                    <th>Cantidad</th>
                    <th>Tiempo Estándar (min)</th>
                </tr>
                </thead>
                <tbody>
                ';
                $tiempoTotalTrabajado = 0;
                $result = mysqli_query($link,"SELECT * FROM EmpleadoLote WHERE idEmpleado = '{$_POST['idEmpleado']}' AND fecha >= '{$_POST['fechaInicio']}' AND fecha <= '{$_POST['fechaFin']}' ORDER BY fecha DESC");
                while ($fila = mysqli_fetch_array($result)){
                    $result1 = mysqli_query($link,"SELECT * FROM SubProceso WHERE idProcedimiento = '{$fila['idProcedimiento']}'");
                    while ($fila1 = mysqli_fetch_array($result1)){
                        $procedimiento = $fila1['descripcion'];
                    }
                    $result1 = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE idComponente IN (SELECT idComponente FROM ProductoComponentesPrenda WHERE idComponenteEspecifico = '{$fila['idComponenteEspecifico']}')");
                    while ($fila1 = mysqli_fetch_array($result1)){
                        $componente = $fila1['descripcion'];
                    }
                    if ($fila['idProcedimiento']>5){
                        $result1 = mysqli_query($link,"SELECT * FROM PCPSPC WHERE idComponenteEspecifico = '{$fila['idComponenteEspecifico']}' AND idSubProcesoCaracteristica IN (SELECT idSubProcesoCaracteristica FROM SubProcesoCaracteristica WHERE idCaracteristica = '11') AND valor = '{$fila['idProcedimiento']}'");
                        while ($fila1 = mysqli_fetch_array($result1)){
                            $result2 = mysqli_query($link,"SELECT * FROM PCPSPC WHERE idComponenteEspecifico = '{$fila['idComponenteEspecifico']}' AND indice = '{$fila1['indice']}' AND idSubProcesoCaracteristica IN (SELECT idSubProcesoCaracteristica FROM SubProcesoCaracteristica WHERE idCaracteristica = '7')");
                            while ($fila2 = mysqli_fetch_array($result2)){
                                $tiempo = $fila2['valor'];
                            }
                        }
                    }else{
                        $result1 = mysqli_query($link,"SELECT * FROM PCPSPC WHERE idComponenteEspecifico = '{$fila['idComponenteEspecifico']}' AND idSubProcesoCaracteristica IN (SELECT idSubProcesoCaracteristica FROM SubProcesoCaracteristica WHERE idProcedimiento = '{$fila['idProcedimiento']}' AND idCaracteristica = '7')");
                        while ($fila1 = mysqli_fetch_array($result1)){
                            $tiempo = $fila1['valor'];
                        }
                    }

                    $html .="<tr>";
                    $html .="<td>{$fila['fecha']}</td>";
                    $html .="<td>{$fila['idLote']}</td>";
                    $html .="<td>{$componente}</td>";
                    $html .="<td>{$procedimiento}</td>";
                    $html .="<td>{$fila['cantidad']}</td>";
                    $html .="<td>{$tiempo} min</td>";
                    $html .="</tr>";

                    $tiempoComponente = $fila['cantidad'] * $tiempo;
                    $tiempoTotalTrabajado = $tiempoTotalTrabajado + $tiempoComponente;
                }
                $HorasWakas3 = $tiempoTotalTrabajado/60;
                $HorasWakas4 = floor($HorasWakas3);
                $HorasWakas5 = $tiempoTotalTrabajado-($HorasWakas4*60);
                $HorasFinalT = $HorasWakas4.":".$HorasWakas5;
    $html .='
                </tbody>
            </table>
    <div class="spacer10"></div>
            <table>
                <tbody>
                    <tr>
                        <th class="text-left">Registro de Tiempo Muerto:</th>
                    </tr>
                </tbody>
            </table>
        <div class="spacer10"></div>
            <table class="tabla text-center">
                <thead id="theadborderC">
                <tr>
                    <th>Fecha</th>
                    <th>Actividad Muerta</th>
                    <th>Descripción</th>
                    <th>Tiempo</th>
                </tr>
                </thead>
                <tbody>
                ';
                $tiempoTotalActividadMuerta = 0;
                $result = mysqli_query($link,"SELECT * FROM EmpleadoActividadMuerta WHERE idEmpleado = '{$_POST['idEmpleado']}' AND fecha >= '{$_POST['fechaInicio']}' AND fecha <= '{$_POST['fechaFin']}'");
                while ($fila = mysqli_fetch_array($result)){
                    $result1 = mysqli_query($link,"SELECT * FROM ActividadMuerta WHERE idActividadMuerta = '{$fila['idActividadMuerta']}'");
                    while ($fila1 = mysqli_fetch_array($result1)){
                        $actvidadMuerta = $fila1['descripcion'];
                    }
                    $html .="<tr>";
                    $html .="<td>{$fila['fecha']}</td>";
                    $html .="<td>{$actvidadMuerta}</td>";
                    $html .="<td>{$fila['descripcion']}</td>";
                    $html .="<td>{$fila['tiempo']}</td>";
                    $html .="</tr>";

                    $tiempoTotalActividadMuerta = $tiempoTotalActividadMuerta + $fila['tiempo'];
                }
                $HorasWakas6 = $tiempoTotalActividadMuerta/60;
                $HorasWakas7 = floor($HorasWakas6);
                $HorasWakas8 = $tiempoTotalActividadMuerta-($HorasWakas7*60);
                $HorasFinalAM = $HorasWakas7.":".$HorasWakas8;
    $html .='
                <tr>
                    <th>Total Horas Muertas</th>
                    <td></td>
                    <td></td>
                    <td>'.$HorasFinalAM.' Hrs.</td>
                </tr>
                </tbody>
            </table>
    <div class="spacer10"></div>
    <div class="row">
    ';
            /*$MinutosFinalEstancia = explode(":",$HorasFinalE);
            $MinutosFinalEstancia = ($MinutosFinalEstancia[0]*60) + $MinutosFinalEstancia[1];

            $MinutosFinalTrabajo = explode(":",$HorasFinalT);
            $MinutosFinalTrabajo = ($MinutosFinalTrabajo[0]*60) + $MinutosFinalTrabajo[1];

            $MinutosFinalActividadMuerta = explode(":",$HorasFinalAM);
            $MinutosFinalActividadMuerta = ($MinutosFinalActividadMuerta[0]*60) + $MinutosFinalActividadMuerta[1];

            $productividad =(($MinutosFinalTrabajo-$MinutosFinalActividadMuerta)/$MinutosFinalEstancia)*100;
            $productividad = round($productividad,2);*/
    /*$html .='
            <table>
                <tbody>
                    <tr>
                        <th class="text-left">% Referencial de Productividad de Trabajador:</th>
                        <td class="text-right">'.$productividad.' %</td>
                    </tr>
                </tbody>
            </table>';*/
    $html .='
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
                    <h4>Reporte de Personal</h4>
                    <h5>'.$_POST['idEmpleado'].'</h5>
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
    $nombredearchivo="ReportePersonal".$_POST['idEmpleado'].'.pdf';
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