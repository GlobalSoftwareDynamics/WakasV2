<?php
require_once __DIR__ . '/lib/mpdf/mpdf.php';

include('session.php');
include('funciones.php');
if(isset($_SESSION['login'])){

    $html='
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/Formatospdf.css" rel="stylesheet">
    </head>
    <body class="landscape">
                <div class="row">
                    <div class="descladoizquierdoCV">
                        <p style="font-weight: bold">For:</p>';
    $result = mysqli_query($link,"SELECT * FROM Contacto WHERE idContacto IN (SELECT idContacto FROM ConfirmacionVenta WHERE idContrato = '{$_POST['idConfirmacionVenta']}')");
    while ($fila = mysqli_fetch_array($result)){
        $result1 = mysqli_query($link,"SELECT * FROM Direccion WHERE idDireccion = '{$fila['idDireccion']}'");
        while ($fila1 = mysqli_fetch_array($result1)){
            $result2 = mysqli_query($link,"SELECT * FROM Ciudad WHERE idCiudad = '{$fila1['idCiudad']}'");
            while ($fila2 = mysqli_fetch_array($result2)){
                $result3 = mysqli_query($link,"SELECT * FROM Pais WHERE idPais = '{$fila2['idPais']}'");
                while ($fila3 = mysqli_fetch_array($result3)){
                    $direccion = $fila1['direccion'];
                    $ciudad = $fila2['nombre'];
                    $pais = $fila3['pais'];
                }
            }
        }
        $html .="<p>{$fila['nombreCompleto']}</p>";
        $html .="<p>{$direccion}</p>";
        $html .="<p>{$ciudad}</p>";
        $html .="<p>{$pais}</p>";
    }
    $html .='
                    </div>
                    <div class="descladoderechoCV">';
    $result = mysqli_query($link,"SELECT * FROM ConfirmacionVenta WHERE idContrato = '{$_POST['idConfirmacionVenta']}'");
    while ($fila = mysqli_fetch_array($result)){
        switch($fila['moneda']){
            case 1:
                $simbolo = "S/.";
                $denominacion = "SOLES";
                break;
            case 2:
                $simbolo = "$";
                $denominacion = "USD";
                break;
            case 3:
                $simbolo = "€";
                $denominacion = "EURO";
                break;
        }
        $result1 = mysqli_query($link,"SELECT * FROM Incoterms WHERE idIncoterm = '{$fila['idIncoterm']}'");
        while ($fila1 = mysqli_fetch_array($result1)){
            $incoterm = $fila1['descripcion'];
        }
        $result1 = mysqli_query($link,"SELECT * FROM Via WHERE idVia = '{$fila['idVia']}'");
        while ($fila1 = mysqli_fetch_array($result1)){
            $via = $fila1['descripcion'];
        }
        $result1 = mysqli_query($link,"SELECT * FROM MetodoPago WHERE idMetodoPago = '{$fila['idMetodoPago']}'");
        while ($fila1 = mysqli_fetch_array($result1)){
            $metodo = $fila1['descripcion'];
        }
        $idContrato = $fila['idContrato'];
        $fechaContrato = $fila['fecha'];
        $fechaEnvio = $fila['shipdate'];
        $codigoCliente = $fila['reference'];
    }
    $html .='
                        <table>
                            <tbody>
                                <tr>
                                    <th>Our Shipment:</th>
                                    <td>'.$idContrato.'</td>
                                </tr>
                                <tr>
                                    <th>Date:</th>
                                    <td>'.$fechaContrato.'</td>
                                </tr>
                                <tr>
                                    <th>Your Reference:</th>
                                    <td>'.$codigoCliente.'</td>
                                </tr>
                                <tr>
                                    <th>Incoterm:</th>
                                    <td>'.$incoterm.'</td>
                                </tr>
                                <tr>
                                    <th>Payment:</th>
                                    <td>'.$metodo.'</td>
                                </tr>
                                <tr>
                                    <th>Via:</th>
                                    <td>'.$via.'</td>
                                </tr>
                                <tr>
                                    <th>Shipment:</th>
                                    <td>'.$fechaEnvio.'</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="spacer5"></div>
                <div class="row">
                    <div class="parrafotabla">
                        <p>With reference to our fax/e-mail exchange we are pleased to confirm our sale to you as follows:</p>
                    </div>
                </div>
                <div class="spacer15"></div>
                <div class="row">
                    <div class="col-12">
                        <table class="tabla text-center">
                            <thead id="theadborder">
                            <tr>
                                <th>Our Code</th>
                                <th>Your Code</th>
                                <th>Material</th>
                                <th>Color</th>';
    $result = mysqli_query($link,"SELECT * FROM Talla WHERE idcodificacionTalla = '{$_POST['codifTalla']}' ORDER BY indice ASC");
    while ($fila = mysqli_fetch_array($result)){
        $html .="
                                        <th>".$fila['descripcion']."</th>
                                    ";
    }
    $html .='
                                <th>Total</th>
                                <th>Price '.$denominacion.'</th>
                                <th>Total '.$denominacion.'</th>
                            </tr>
                            </thead>
                            <tbody>';
    $ProdActual="ninguno";
    $ColorActual="ninguno";
    $inicio=0;
    $sumafinal=0;
    $sumafinalprod=0;
    $result1 = mysqli_query($link,"SELECT * FROM ConfirmacionVentaProducto WHERE idContrato ='{$_POST['idConfirmacionVenta']}' ORDER BY idProducto ASC");
    while ($fila1 = mysqli_fetch_array($result1)){
        if(($ProdActual == $fila1['idProducto'])&&($ColorActual == $fila1['idCombinacionesColor'])) {
            $html .="</tr>";
        }else{
            $html .="<tr>";
            $html .="
                                                <td>".$fila1['idProducto']."</td>
                                                <td>".$fila1['codigoCliente']."</td>
                                        ";
            $result2 = mysqli_query($link,"SELECT * FROM Producto WHERE idProducto = '{$fila1['idProducto']}'");
            while ($fila2=mysqli_fetch_array($result2)){
                $html .="
                                                <td>".$fila2['codificacionMaterial']."</td>
                                            ";
            }
            $result2 = mysqli_query($link,"SELECT * FROM CombinacionesColor WHERE idCombinacionesColor = '{$fila1['idCombinacionesColor']}'");
            while ($fila2=mysqli_fetch_array($result2)){
                $html .="
                                                <td>".nl2br($fila2['descripcion'])."</td>
                                            ";
            }
            $tallas1=array();
            $tallas2=array();
            $indice1=0;
            $indice2=0;
            $result2 = mysqli_query($link,"SELECT * FROM Talla WHERE idcodificacionTalla = '{$_POST['codifTalla']}' ORDER BY indice ASC");
            while ($fila2 = mysqli_fetch_array($result2)) {
                $tallas1[$indice1] = $fila2['idTalla'];
                $indice1++;
            }
            $talla = mysqli_query($link,"SELECT * FROM ConfirmacionVentaProducto WHERE idProducto = '{$fila1['idProducto']}' AND idContrato = '{$_POST['idConfirmacionVenta']}' AND idCombinacionesColor = '{$fila1['idCombinacionesColor']}'");
            while ($fila2 = mysqli_fetch_array($talla)){
                $tallas2[$indice2]=$fila2['idTalla'];
                $indice2++;
            }
            foreach ($tallas1 as $value1) {
                $encontrado=false;
                foreach ($tallas2 as $value2) {
                    if ($value1 == $value2){
                        $encontrado=true;
                        $cant= mysqli_query($link,"SELECT * FROM ConfirmacionVentaProducto WHERE idProducto='{$fila1['idProducto']}' AND idContrato ='{$_POST['idConfirmacionVenta']}' AND idCombinacionesColor = '{$fila1['idCombinacionesColor']}' AND idTalla = '{$value1}'");
                        while ($filacant = mysqli_fetch_array($cant)){
                            $html .="<td>".$filacant['cantidad']."</td>";
                        }
                    }
                }
                if ($encontrado == false){
                    $html .="<td></td>";
                }
            }
            $ProdActual=$fila1['idProducto'];
            $ColorActual=$fila1['idCombinacionesColor'];
            $numproductos=array();
            $indice=0;
            $result3 = mysqli_query($link,"SELECT * FROM ConfirmacionVentaProducto WHERE idProducto = '{$fila1['idProducto']}' AND idContrato = '{$_POST['idConfirmacionVenta']}' AND idCombinacionesColor = '{$fila1['idCombinacionesColor']}'");
            while ($fila3 = mysqli_fetch_array($result3)) {
                $numproductos[$indice] = $fila3['cantidad'];
                $indice++;
            }
            $suma = array_sum($numproductos);
            $html .="
                                                            <td>{$suma }</td>
                                                            <td>{$simbolo} {$fila1['precio']}</td>
                                                        ";
            $totalusd = $suma * $fila1['precio'];
            $html .="
                                                            <td>{$simbolo} {$totalusd}</td>
                                                        ";
            $sumafinal = $sumafinal + $totalusd;
            $sumafinalprod = $sumafinalprod + $suma;
        }
    }
    $html .="
                            <tr>
                                <td style='border-top: 1px solid black'>Total<td>
                                <td></td>
                                <td></td>
                                <td></td>";
    $result1 = mysqli_query($link,"SELECT * FROM Talla WHERE idcodificacionTalla = '{$_POST['codifTalla']}'");
    while ($fila1 = mysqli_fetch_array($result1)){
        $html .="
                                    <td></td>
                                ";
    }
    $html .="
                                <td style='border-top: 1px solid black'>{$sumafinalprod}</td>
                                <td style='border-top: 1px solid black'>{$simbolo} {$sumafinal}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class='spacer5'></div>
                <div class='row'>
                    <div class='parrafofinal'>
                        <p>In the event of prevention of shipment in whole or in part by reason of prohibition of export, local strike, political disturbance, riot, war,
                            civil conmotion or any other cause whatsoever amounting to force majeure, the seller may extent the period until the operation of the cause preventing
                            shipment has ceased or consider the contract void to the extent to which shipment has not been affected, such right to consider the contract void
                            being valid throughout the period of prevention. The certificate of the Arequipa Chamber of Comerce shall be final and binding.</p>
                        <p>Any dispute or diference araising out of this contract shall be settled by arbitration. The competent body to conduct the arbitration shall be
                            the Arequipa...</p>
                        <p>Thank you for this new order we remain,</p>
                    </div>
                    <div class='parrafofinal'>
                        <p>Countersigned</p>
                    </div>
                </div>
        </body>
    ";

    $htmlheader='
        <header>
            <div id="descripcionbrand">
                <img style="margin-top: 5px" width="auto" height="60" src="img/WakasNavbar.png"/>
            </div>
            <div id="tituloreporte">
                <div class="titulo">
                    <h4 style="margin-top: 15px">Confirmation of Sale</h4>
                    <h5></h5>
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

    $nombrearchivo=$_POST['idConfirmacionVenta'].'.pdf';
    $mpdf = new mPDF('','A4-L',0,'','15',15,35,35,6,6);

// Write some HTML code:
    $mpdf->SetHTMLHeader($htmlheader);
    $mpdf->SetHTMLFooter($htmlfooter);
    $mpdf->WriteHTML($html);

// Output a PDF file directly to the browser
    $mpdf->Output($nombrearchivo,'D');
}else{
    include('sessionError.php');
}
?>