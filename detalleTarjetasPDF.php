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
                    <title>Tarjeta</title>
                    <link href="css/bootstrap.css" rel="stylesheet">
                    <link href="css/Formatospdf.css" rel="stylesheet">
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
                    <script src="lib/barcode/JsBarcode.all.min.js"></script>
                </head>
                <body class="tarjetalote">
    ';
    $result = mysqli_query($link,"SELECT * FROM Lote WHERE idOrdenProduccion='".$_POST['idOrdenProduccion']."' ORDER BY posicion");
    while ($fila = mysqli_fetch_array($result)){
        $result1 = mysqli_query($link,"SELECT * FROM ConfirmacionVentaProducto WHERE idConfirmacionVentaProducto = '{$fila['idConfirmacionVentaProducto']}'");
        while ($fila1 = mysqli_fetch_array($result1)){
            $result2 = mysqli_query($link,"SELECT * FROM Producto WHERE idProducto = '{$fila1['idProducto']}'");
            while ($fila2 = mysqli_fetch_array($result2)){
                $descripcion = substr($fila2['descripcionGeneral'],0,25);
            }
            $bar=$fila['idLote'];
            $html .='        
                <section class="container" style="height: 15.2cm; width: 10cm;">
                        <div class="row">
                            <div class="col-12">
                                <img width="3cm" height="70" src="img/WakasNavbar.png" class="izquierda">
                                <img width="180" height="70" src="barcodes/'.$_POST['idOrdenProduccion'].'/'.$bar.'.png" class="derecha">
                            </div>
                        </div>
                        <div class="spacer15"></div>
                        <div class="row">
                            <div class="col-12">
                                <table>
                                    <tbody>
                                        <tr class="tarjetacont">
                                            <td class="columnaizquierda1">idLote</td>
                                            <td>'.$fila['idLote'].'</td>
                                        </tr>
                                        <tr class="tarjetacont">
                                            <td class="columnaizquierda1">idModelo</td>
                                            <td>'.$fila1['idProducto'].' - '.$descripcion.'</td>
                                        </tr>
                                        <tr class="tarjetacont">
                                            <td class="columnaizquierda1">Material</td>
                                            <td>'.$fila['material'].'</td>
                                        </tr>
                                        <tr class="tarjetacont">
                                            <td class="columnaizquierda1">Combinación</td>
                                            ';
            $result2 = mysqli_query($link,"SELECT * FROM CombinacionesColor WHERE idCombinacionesColor = '{$fila1['idCombinacionesColor']}'");
            while($fila2 = mysqli_fetch_array($result2)){
                $html .='
						<td>'.$fila2['descripcion'].'</td>';
            }
            $html .='
                                        </tr>
                                        <tr class="tarjetacont">
                                            <td class="columnaizquierda1">Talla</td>
             ';
            $result2 = mysqli_query($link,"SELECT * FROM Talla WHERE idTalla = '{$fila1['idTalla']}'");
            while ($fila2 = mysqli_fetch_array($result2)){
                $html .='<td>'.$fila2['descripcion'].'</td>';
            }
            $html .='                               
                                        </tr>
                                        <tr class="tarjetacont">
                                            <td class="columnaizquierda1">Cantidad</td>
                                            <td>'.$fila['cantidad'].'</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="spacer5"></div>
                        <div class="row">
                            <div class="col-12">
                                <table>
                                    <tbody>
            ';
            $result2 = mysqli_query($link,"SELECT * FROM TallaMedida WHERE idProducto = '{$fila1['idProducto']}' AND idTalla = '{$fila1['idTalla']}'");
            while ($fila2 = mysqli_fetch_array($result2)){
                $result3 = mysqli_query($link,"SELECT * FROM Medida WHERE idMedida = '{$fila2['idMedida']}'");
                while ($fila3 = mysqli_fetch_array($result3)){
                    $html .='
                        <tr class="tarjetacont">
                            <td class="columnaizquierda">'.$fila2['idMedida'].': '.$fila3['descripcion'].'</td>
                            <td class="columnaderecha">'.$fila2['valor'].'</td>
                        </tr>
                    ';
                }
            }
            $html .='
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="spacer5"></div>
                        <div class="cuadrobservacion" style="font-size: 10px">
                            <p class="columnaizquierda1">OBSERVACIONES</p>
                            <p>'.$_POST['observacion'].'</p>
                        </div>
                </section>
            ';
        }
    }
    $html .='
        </body>
    </html>
    ';
    $nombrearchivo='Tarjetas'.$_POST['idOrdenProduccion'].'.pdf';
    $mpdf = new mPDF('utf8',array(102,153),0,'',3,3,3,3,6,6);
// Write some HTML code:
    $mpdf->WriteHTML($html);
// Output a PDF file directly to the browser
    $mpdf->Output($nombrearchivo,'D');
    ?>

    <?php
}else{
    echo "Usted no está autorizado para ingresar a esta sección. Por favor vuelva a la página de inicio de sesión e identifíquese.";
}
?>