<?php
include('session.php');
include('declaracionFechas.php');
include ('funciones.php');
if(isset($_SESSION['login'])){

    include('header.php');
    include('navbarAdmin.php');
    ?>

    <div class="spacer35"></div>
    <section class="container">
    <section class="container">
        <div class="card">
            <div class="card-header card-inverse card-info">
                <i class="fa fa-shopping-cart"></i>
                Confirmación de Venta
                <div class="float-right">
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Acciones
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <form method="post">
                                <input type="hidden" name="idConfirmacionVenta" value="<?php echo $_POST['idConfirmacionVenta'];?>" readonly>
                                <input type="hidden" name="codifTalla" value="<?php echo $_POST['codifTalla'];?>" readonly>
                                <input type="submit" formaction="gestionCV.php" value="Listado de CV" class="dropdown-item">
                                <input type="submit" name="crearOP" value="Crear Orden de Producción" class="dropdown-item" formaction="detalleOP.php">
                                <input type="submit" name="pdf" value="Descargar PDF" class="dropdown-item" formaction="detalleCVPDF.php">
                            </form>
                        </div>
                    </div>
                </div>
                <span class="float-right">&nbsp;&nbsp;&nbsp;&nbsp;</span>
            </div>
            <div class="card-block">
                <div class="spacer20"></div>
                <div class="row">
                    <div class="col-7 datosCV">
                        <p><b>For:</b></p>
                        <?php
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
                            echo "<p>{$fila['nombreCompleto']}</p>";
                            echo "<p>{$direccion}</p>";
                            echo "<p>{$ciudad}</p>";
                            echo "<p>{$pais}</p>";
                        }
                        ?>
                    </div>
                    <div class="col-5 datosCV">
                        <?php
                        $result = mysqli_query($link,"SELECT * FROM ConfirmacionVenta WHERE idContrato = '{$_POST['idConfirmacionVenta']}'");
                        while ($fila = mysqli_fetch_array($result)){
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
                        ?>
                        <div class="row">
                            <div class="col-4">
                                <p><b>Our Shipment:</b></p>
                            </div>
                            <div class="col-8">
                                <p><?php echo $idContrato;?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <p><b>Date:</b></p>
                            </div>
                            <div class="col-8">
                                <p><?php echo $fechaContrato;?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <p><b>Your Reference:</b></p>
                            </div>
                            <div class="col-8">
                                <p><?php echo $codigoCliente;?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <p><b>Incoterm:</b></p>
                            </div>
                            <div class="col-8">
                                <p><?php echo $incoterm;?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <p><b>Payment:</b></p>
                            </div>
                            <div class="col-8">
                                <p><?php echo $metodo;?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <p><b>Via:</b></p>
                            </div>
                            <div class="col-8">
                                <p><?php echo $via;?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <p><b>Shipment:</b></p>
                            </div>
                            <div class="col-8">
                                <p><?php echo $fechaEnvio;?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="spacer15"></div>
                <div class="row">
                    <div class="col-12">
                        <p>With reference to our fax/e-mail exchange we are pleased to confirm our sale to you as follows:</p>
                    </div>
                </div>
                <div class="spacer15"></div>
                <div class="row">
                    <div class="col-12">
                        <table class="table table-bordered text-center">
                            <thead>
                            <tr>
                                <th>Our Code</th>
                                <th>Your Code</th>
                                <th>Material</th>
                                <th>Color</th>
                                <?php
                                $result = mysqli_query($link,"SELECT * FROM Talla WHERE idcodificacionTalla = '{$_POST['codifTalla']}' ORDER BY indice ASC");
                                while ($fila = mysqli_fetch_array($result)){
                                    echo "
                                    <th>".$fila['descripcion']."</th>
                                ";
                                }
                                ?>
                                <th>Total</th>
                                <th>Price (USD)</th>
                                <th>Total (USD)</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ProdActual="ninguno";
                            $ColorActual="ninguno";
                            $inicio=0;
                            $sumafinal=0;
                            $sumafinalprod=0;
                            $result1 = mysqli_query($link,"SELECT * FROM ConfirmacionVentaProducto WHERE idContrato ='{$_POST['idConfirmacionVenta']}' ORDER BY idProducto ASC");
                            while ($fila1 = mysqli_fetch_array($result1)){
                                if(($ProdActual == $fila1['idProducto'])&&($ColorActual == $fila1['idCombinacionesColor'])) {
                                    echo "</tr>";
                                }else{
                                    echo "<tr>";
                                    echo "
                                                <td>".$fila1['idProducto']."</td>
                                                <td>".$fila1['codigoCliente']."</td>
                                        ";
                                    $result2 = mysqli_query($link,"SELECT * FROM Producto WHERE idProducto = '{$fila1['idProducto']}'");
                                    while ($fila2=mysqli_fetch_array($result2)){
                                        echo "
                                                <td>".$fila2['codificacionMaterial']."</td>
                                            ";
                                    }
                                    $result2 = mysqli_query($link,"SELECT * FROM CombinacionesColor WHERE idCombinacionesColor = '{$fila1['idCombinacionesColor']}'");
                                    while ($fila2=mysqli_fetch_array($result2)){
                                        echo "
                                                <td>".$fila2['descripcion']."</td>
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
                                                $cant= mysqli_query($link,"SELECT * FROM ConfirmacionVentaProducto WHERE idProducto='{$fila1['idProducto']}' AND idContrato='{$_POST['idConfirmacionVenta']}' AND idCombinacionesColor='{$fila1['idCombinacionesColor']}' AND idTalla='{$value1}'");
                                                while ($filacant = mysqli_fetch_array($cant)){
                                                    echo "<td>".$filacant['cantidad']."</td>";
                                                }
                                            }
                                        }
                                        if ($encontrado == false){
                                            echo "<td></td>";
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
                                    echo "
                                                            <td>{$suma }</td>
                                                            <td>{$fila1['precio']}</td>
                                                        ";
                                    $totalusd = $suma * $fila1['precio'];
                                    echo "
                                                            <td>$ {$totalusd}</td>
                                                        ";
                                    $sumafinal = $sumafinal + $totalusd;
                                    $sumafinalprod = $sumafinalprod + $suma;
                                }
                            }
                            echo "
                            <tr>
                                <td>Total<td>
                                <td></td>
                                <td></td>";
                            $result1 = mysqli_query($link,"SELECT * FROM Talla WHERE idcodificacionTalla = '{$_POST['codifTalla']}'");
                            while ($fila1 = mysqli_fetch_array($result1)){
                                echo "
                                    <td></td>
                                ";
                            }
                            echo "
                                <td>".$sumafinalprod."</td>
                                <td></td>
                                <td>$ ".$sumafinal."</td>
                            </tr>
                    ";
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="spacer15"></div>
                <div class="row">
                    <div class="col-12">
                        <p>In the event of prevention of shipment in whole or in part by reason of prohibition of export, local strike, political disturbance, riot, war,
                            civil conmotion or any other cause whatsoever amounting to force majeure, the seller may extent the period until the operation of the cause preventing
                            shipment has ceased or consider the contract void to the extent to which shipment has not been affected, such right to consider the contract void
                            being valid throughout the period of prevention. The certificate of the Arequipa Chamber of Comerce shall be final and binding.</p>
                        <p>Any dispute or diference araising out of this contract shall be settled by arbitration. The competent body to conduct the arbitration shall be
                            the Arequipa...</p>
                        <p>Thank you for this new order we remain,</p>
                    </div>
                    <div class="col-12">
                        <p>Countersigned</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php

    include('footer.php');
}
?>