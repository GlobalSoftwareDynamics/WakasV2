<?php
include('session.php');
include('declaracionFechas.php');
include ('funciones.php');
if(isset($_SESSION['login'])){

    if(isset($_POST['crearOP'])){
        $aux = 0;
        $aux1=0;
        $result = mysqli_query($link,"SELECT * FROM OrdenProduccion");
        $aux = mysqli_num_rows($result);

        $aux++;
        $idOrdProd = "OP".$aux;
        $result = mysqli_query($link,"SELECT * FROM ConfirmacionVenta WHERE idContrato = '{$_POST['idConfirmacionVenta']}'");
        while ($fila = mysqli_fetch_array($result)){
            $fechacreacion = (string)$fila['fecha'];
            $fechadespacho = (string)$fila['shipdate'];
        }

        $query = mysqli_query($link,"INSERT INTO OrdenProduccion(idOrdenProduccion, idContrato, idEmpleado, fechaCreacion, fechaDespacho) VALUES ('{$idOrdProd}','{$_POST['idConfirmacionVenta']}','{$_SESSION['user']}','{$fechacreacion}','{$fechadespacho}')");

        $queryPerformed = "INSERT INTO OrdenProduccion(idOrdenProduccion, idContrato, idEmpleado, fechaCreacion, fechaDespacho) VALUES ({$idOrdProd},{$_POST['idConfirmacionVenta']},{$_SESSION['user']},{$fechacreacion},{$fechadespacho})";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','OrdenProduccion','{$queryPerformed}')");

        $result = mysqli_query($link,"SELECT * FROM ConfirmacionVentaProducto WHERE idContrato='{$_POST['idConfirmacionVenta']}' ORDER BY idProducto ASC, idTalla ASC");
        while ($fila = mysqli_fetch_array($result)){

            $cantidadlote = $fila['cantidad'];

            $result1 = mysqli_query($link,"SELECT * FROM Producto WHERE idProducto = '{$fila['idProducto']}'");
            while ($fila1 = mysqli_fetch_array($result1)){
                $nombremat = $fila1['codificacionMaterial'];

                $result2 = mysqli_query($link,"SELECT * FROM TipoProducto WHERE idTipoProducto = '{$fila1['idTipoProducto']}'");
                while ($fila2 = mysqli_fetch_array($result2)){
                    $tamanolote = $fila2['tamanoLote'];

                    $aux2=0;
                    for ($i=0;$cantidadlote > 0;$i++) {
                        if (($cantidadlote) > $fila2['tamanoLote']) {
                            $aux1++;
                            $idlote = $idOrdProd . "LT" . $aux1;
                            $cantidadlote1 = $fila2['tamanoLote'];

                            $query = mysqli_query($link,"INSERT INTO Lote(idLote, idConfirmacionVentaProducto,idOrdenProduccion, idEstado, cantidad, material, posicion) VALUES ('{$idlote}','{$fila['idConfirmacionVentaProducto']}','{$idOrdProd}','6','{$cantidadlote1}','{$nombremat}','{$aux1}')");

                            $queryPerformed = "INSERT INTO Lote(idLote, idConfirmacionVentaProducto,idOrdenProduccion, idEstado, cantidad, material, posicion) VALUES ({$idlote},{$fila['idConfirmacionVentaProducto']},{$idOrdProd},6,{$cantidadlote1},{$nombremat},{$aux1})";

                            $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','Lote','{$queryPerformed}')");

                        } else {
                            $aux1++;
                            $idlote = $idOrdProd . "LT" . $aux1;

                            $query = mysqli_query($link,"INSERT INTO Lote(idLote, idConfirmacionVentaProducto,idOrdenProduccion, idEstado, cantidad, material, posicion) VALUES ('{$idlote}','{$fila['idConfirmacionVentaProducto']}','{$idOrdProd}','1','{$cantidadlote}','{$nombremat}','{$aux1}')");

                            $queryPerformed = "INSERT INTO Lote(idLote, idConfirmacionVentaProducto,idOrdenProduccion, idEstado, cantidad, material, posicion) VALUES ({$idlote},{$fila['idConfirmacionVentaProducto']},{$idOrdProd},1,{$cantidadlote},{$nombremat},{$aux1})";

                            $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','Lote','{$queryPerformed}')");

                        }
                        $cantidadlote = $cantidadlote - $tamanolote;
                        $aux2++;
                    }
                }
            }

            $query = mysqli_query($link,"UPDATE ConfirmacionVentaProducto SET estado = 6 WHERE idConfirmacionVentaProducto = '{$fila['idConfirmacionVentaProducto']}'");

            $queryPerformed = "UPDATE ConfirmacionVentaProducto SET estado = 6 WHERE idConfirmacionVentaProducto = {$fila['idConfirmacionVentaProducto']}";

            $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','UPDATE','ConfirmacionVentaProducto','{$queryPerformed}')");

            $query = mysqli_query($link, "UPDATE ConfirmacionVenta SET idEstado = 4 WHERE idContrato = '{$_POST['idConfirmacionVenta']}'");

            $queryPerformed = "UPDATE ConfirmacionVenta SET idEstado = 4 WHERE idContrato = '{$_POST['idConfirmacionVenta']}'";

            $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','UPDATE','Emitir CV','{$queryPerformed}')");

        }
    }else{
        $idOrdProd = $_POST['idOrdenProduccion'];
    }

    /*if(isset($_POST['ordenprodform'])){
        $aux = 0;
        $result = selectTable("OrdenProduccion");
        while($fila = mysql_fetch_array($result)){
            $aux++;
        }
        date_default_timezone_set('America/Lima');
        $aux++;
        $idOrdProd="OP".$aux;
        $result1=selectTableWhere('ConfirmacionVenta','idContrato',"'".$_POST['contrato']."'");
        while ($fila=mysql_fetch_array($result1)){
            $fechacreacion=date('m/d/Y');
            $fechadespacho=(string)$fila['shipdate'];
        }

        $result2="INSERT INTO ordenproduccion(idOrdenProduccion, idContrato, idEmpleado, fechaCreacion, fechaDespacho) VALUES ('".$idOrdProd."','".$_POST['contrato']."','".$idempleado."','".$fechacreacion."','".$fechadespacho."')";
        $agregar=mysql_query($result2);
        if ( !empty( $error = mysql_error() ) ) {
            echo 'Mysql error '. $error ."<br />\n";
        }
        $aux1 = 0;
        $result1=selectTableWhere('Talla','idcodificacionTalla',"'".$_POST['idcodificacionTalla']."'");
        while ($fila2=mysql_fetch_array($result1)){
            if(isset($_POST[$fila2['idTalla']])&&$_POST[$fila2['idTalla']]){
                $result4="SELECT * FROM confirmacionventaproducto WHERE idContrato='".$_POST['contrato']."' AND idProducto='".$_POST['producto']."' AND idColor='".$_POST['color']."' AND idTalla='".$fila2['idTalla']."' ORDER BY idProducto ASC, idColor ASC, idTalla DESC";
                $result5=mysql_query($result4);
                while ($fila1=mysql_fetch_array($result5)){
                    $cantidadrestante=$fila1['cantidad']-$fila1['cantidadop'];
                    if ($cantidadrestante<$_POST[$fila2['idTalla']]){
                        echo "<div class='container'><span class='alert alert-danger col-sm-8 col-sm-offset-2'>La cantidad ingresada es inválida.</span></div><hr>";
                    }else {
                        $material=selectTableWhere('Material','idMaterial',"'".$fila1['idMaterial']."'");
                        while ($fila6=mysql_fetch_array($material)){
                            $nombremat=$fila6['material'];
                        }
                        $result6=selectTableWhere('Producto','idProducto',"'".$fila1['idProducto']."'");
                        $cantidadlote=$_POST[$fila2['idTalla']];
                        settype($cantidadlote,"integer");
                        while ($fila5=mysql_fetch_array($result6)){
                            $result8=selectTableWhere('TipoProducto','idTipoProducto',"'".$fila5['idTipoProducto']."'");
                            while ($fila4=mysql_fetch_array($result8)){
                                $tamanolote=$fila4['tamanoLote'];
                                $aux2=0;
                                for ($i=0;$cantidadlote > 0;$i++) {
                                    if (($cantidadlote) > $fila4['tamanoLote']) {
                                        $aux1++;
                                        $idlote = $idOrdProd . "LT" . $aux1;
                                        $cantidadlote1 = $fila4['tamanoLote'];
                                        settype($cantidadlote1,"integer");
                                        $agreglote = "INSERT INTO Lote(idLote, idOrdenProduccion, idProducto, idColor, idTalla, cantidad, material, estado, posicion) VALUES ('" . $idlote . "','" . $idOrdProd . "','" . $fila1['idProducto'] . "','" . $fila1['idColor'] . "','" . $fila1['idTalla'] . "','" . $cantidadlote1 . "','" . $nombremat . "','1','".$aux1."')";
                                        $agregarlote1 = mysql_query($agreglote);
                                    } else {
                                        $aux1++;
                                        $idlote = $idOrdProd . "LT" . $aux1;
                                        $agreglote = "INSERT INTO Lote(idLote, idOrdenProduccion, idProducto, idColor, idTalla, cantidad, material, estado, posicion) VALUES ('" . $idlote . "','" . $idOrdProd . "','" . $fila1['idProducto'] . "','" . $fila1['idColor'] . "','" . $fila1['idTalla'] . "','" . $cantidadlote . "','" . $nombremat . "','1','".$aux1."')";
                                        $agregarlote1 = mysql_query($agreglote);
                                    }
                                    $cantidadlote = $cantidadlote - $tamanolote;
                                    $aux2++;
                                }
                            }
                        }
                        $cantidadactual=$fila1['cantidadop']+$_POST[$fila2['idTalla']];
                        $actualizar="UPDATE confirmacionventaproducto SET cantidadop = '".$cantidadactual."' WHERE idContrato='".$_POST['contrato']."' AND idProducto='".$_POST['producto']."' AND idColor='".$_POST['color']."' AND idTalla='".$fila2['idTalla']."'";
                        $query=mysql_query($actualizar);
                        $resta=$fila1['cantidad']-$cantidadactual;
                        if($resta==0){
                            $actualizar1="UPDATE confirmacionventaproducto SET estado = '0' WHERE idContrato='".$_POST['contrato']."' AND idProducto='".$_POST['producto']."' AND idColor='".$_POST['color']."' AND idTalla='".$fila2['idTalla']."'";
                            $query1=mysql_query($actualizar1);
                        }
                    }
                }
            }
        }
    }*/

    include('header.php');
    include('navbarAdmin.php');
    ?>

    <?php
    $result = mysqli_query($link,"SELECT * FROM OrdenProduccion WHERE idOrdenProduccion = '{$idOrdProd}'");
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
    ?>
    <section class="container">
        <div class="card">
            <div class="card-header card-inverse card-info">
                <i class="fa fa-cog"></i>
                Orden de Producción
                <div class="float-right">
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Acciones
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <form method="post">
                                <input type="hidden" name="idConfirmacionVenta" value="<?php echo $_POST['idConfirmacionVenta'];?>" readonly>
                                <input type="hidden" name="codifTalla" value="<?php echo $_POST['codifTalla'];?>" readonly>
                                <input type="hidden" name="idOrdenProduccion" value="<?php echo $idOrdProd;?>" readonly>
                                <input type="submit" formaction="gestionOP.php" value="Listado de OP" class="dropdown-item">
                                <input type="submit" name="nuevaObs" formaction="nuevaObservacionOP.php" value="Agregar Observaciones" class="dropdown-item">
                                <input type="submit" name="tarjetas" formaction="crearTarjetas.php" value="Descargar Tarjetas" class="dropdown-item">
                                <input type="submit" name="pdf" value="Descargar PDF" class="dropdown-item" formaction="detalleOPPDF.php">
                            </form>
                        </div>
                    </div>
                </div>
                <span class="float-right">&nbsp;&nbsp;&nbsp;&nbsp;</span>
            </div>
            <div class="card-block">
                <div class="spacer20"></div>
                <div class="row datosCV">
                    <div class="col-7">
                        <div class="row">
                            <div class="col-3">
                                <p><b>Nro. de Órden:</b></p>
                            </div>
                            <div class="col-9">
                                <p><?php echo $idOrdProd;?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <p><b>Contrato:</b></p>
                            </div>
                            <div class="col-9">
                                <p><?php echo $idContrato;?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <p><b>Cliente:</b></p>
                            </div>
                            <div class="col-9">
                                <p><?php echo $cliente;?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="row">
                            <div class="col-4">
                                <p><b>Fecha de Creación:</b></p>
                            </div>
                            <div class="col-8">
                                <p><?php echo $fechacreacion;?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <p><b>Creado Por:</b></p>
                            </div>
                            <div class="col-8">
                                <p><?php echo $creador;?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <p><b>Fecha de Envío:</b></p>
                            </div>
                            <div class="col-8">
                                <p><?php echo $fechadespacho;?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="spacer20"></div>
                <div class="row">
                    <div class="col-12">
                        <table class="table text-center">
                            <thead id="theadborder">
                            <tr>
                                <th class="text-center">Lote</th>
                                <th class="text-center">idLote</th>
                                <th class="text-center">idProducto</th>
                                <th class="text-center">Material</th>
                                <th class="text-center">Color</th>
                                <th class="text-center">Talla</th>
                                <th class="text-center">Cantidad</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $aux3=1;
                            $result = mysqli_query($link,"SELECT * FROM Lote WHERE idOrdenProduccion ='{$idOrdProd}' ORDER BY posicion ASC");
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
                                    echo "
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
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="spacer20"></div>
                <div class="row">
                    <div class="col-12">
                        <table class="table table-bordered text-justify">
                            <tbody>
                            <tr>
                                <td><p><b>Observaciones:</b></p><p><?php echo $observacion;?></p></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php

    include('footer.php');
}
?>