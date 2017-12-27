<?php
include('session.php');
include('declaracionFechas.php');
include('funciones.php');
if(isset($_SESSION['login'])){
    include('header.php');
    include('navbarAdmin.php');

    ?>

    <script>
        $(function () {
            $('[data-toggle="popover"]').popover()
        })
    </script>

    <section class="container">
        <div class="card">
            <div class="card-header card-inverse card-info">
                <i class="fa fa-line-chart"></i>
                Reporte de Producción
                <div class="float-right">
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Acciones
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <form method="post">
                                <?php
                                if(isset($_POST['generarReporte'])){
                                    if (isset($_POST['idConfirmacionVenta'])){
                                        echo "<input type='hidden' name='idConfirmacionVenta' value='{$_POST['idConfirmacionVenta']}'>";
                                    }
                                    if (isset($_POST['idOrdenProduccion'])){
                                        echo "<input type='hidden' name='idOrdenProduccion' value='{$_POST['idOrdenProduccion']}'>";
                                    }
                                    if (isset($_POST['idLote'])&&!empty($_POST['idLote'])){
                                        echo "<input type='hidden' name='idLote' value='{$_POST['idLote']}'>";
                                    }
                                    echo "<input type='hidden' name='fechaInicio' value='{$_POST['fechaInicio']}'>";
                                    echo "<input type='hidden' name='fechaFin' value='{$_POST['fechaFin']}'>";
                                }
                                ?>
                                <input class="dropdown-item" type="submit" name="pdf" formaction="#" value="Descargar PDF">
                            </form>
                        </div>
                    </div>
                </div>
                <span class="float-right">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                <span class="float-right">
                    <button href="#collapsed" class="btn btn-light btn-sm" data-toggle="collapse">Mostrar Opciones</button>
                </span>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="col-12">
                        <div id="collapsed" class="collapse">
                            <form class="form-inline justify-content-center" method="post" action="#">
                                <label class="sr-only" for="fechaCV">Fecha CV</label>
                                <input type="date" class="form-control mt-2 mb-2 mr-2" id="fechaCV" name="fechaCV" onchange="getContratoReporte(this.value)" data-toggle="popover" data-trigger="focus" title="Fecha de Confirmación de Venta" data-content="Filtra las opciones contenidas en el Campo 'Confirmación de Venta' según la fecha seleccionada." data-placement="top">
                                <label class="sr-only" for="idConfirmacionVenta">Confirmación de Venta</label>
                                <select class="form-control mt-2 mb-2 mr-2" id="idConfirmacionVenta" name="idConfirmacionVenta" onchange="getOrdenProduccionReporte(this.value)">
                                    <option disabled selected>Confirmación de Venta</option>
                                    <?php
                                    $aux = 0;
                                    $result = mysqli_query($link,"SELECT * FROM ConfirmacionVenta ORDER BY fecha DESC");
                                    while ($fila = mysqli_fetch_array($result)){
                                        if ($aux < 20){
                                            echo "<option value='{$fila['idContrato']}'>{$fila['idContrato']} - {$fila['fecha']}</option>";
                                        }else{

                                        }
                                        $aux++;
                                    }
                                    ?>
                                </select>
                                <label class="sr-only" for="idOrdenProduccion">Orden de Producción</label>
                                <select class="form-control mt-2 mb-2 mr-2" id="idOrdenProduccion" name="idOrdenProduccion" onchange="getLoteReporte(this.value)">
                                    <option disabled selected>Orden de Producción</option>
                                    <?php
                                    $aux = 0;
                                    $result = mysqli_query($link,"SELECT * FROM OrdenProduccion ORDER BY fechaCreacion DESC");
                                    while ($fila = mysqli_fetch_array($result)){
                                        if ($aux < 10){
                                            echo "<option value='{$fila['idOrdenProduccion']}'>{$fila['idOrdenProduccion']} - {$fila['fechaCreacion']}</option>";
                                        }else{

                                        }
                                        $aux++;
                                    }
                                    ?>
                                </select>
                                <label class="sr-only" for="idLote">Lote</label>
                                <div id="loteOrden">
                                    <input type="text" class="form-control mt-2 mb-2 mr-2" id="idLote" name="idLote" placeholder="Lote">
                                </div>
                                <label class="sr-only" for="fechaInicio">Fecha Inicio</label>
                                <input type="date" class="form-control mt-2 mb-2 mr-2" id="fechaInicio" name="fechaInicio" placeholder="Fecha Inicio" data-toggle="popover" data-trigger="focus" title="Fecha de Inicio" data-content="Determina la Fecha de Inicio para el Reporte." data-placement="top" required>
                                <label class="sr-only" for="fechaFin">Fecha Fin</label>
                                <input type="date" class="form-control mt-2 mb-2 mr-2" id="fechaFin" name="fechaFin" placeholder="Fecha Fin" data-toggle="popover" data-trigger="focus" title="Fecha de Fin" data-content="Determina la Fecha de Fin para el Reporte." data-placement="top" required>
                                <input type="submit" class="btn btn-primary" value="Generar" style="padding-left:28px; padding-right: 28px;" name="generarReporte">
                            </form>
                        </div>
                        <div class="spacer10"></div>
                        <div style="width: 100%; border-top: 1px solid lightgrey;"></div>
                    </div>
                </div>
                <div class="spacer20"></div>
                <?php
                if (isset($_POST['generarReporte'])&&$_POST['fechaInicio']>$_POST['fechaFin']){
                    echo "<p class='text-center'>La fecha de Inicio de Reporte es mayor a la Fecha de Fin de Reporte. Revise la información ingresada y vuelva a intentar.</p>";
                }else{
                    if(isset($_POST['generarReporte'])&&isset($_POST['idConfirmacionVenta'])&&empty($_POST['idOrdenProduccion'])&&empty($_POST['idLote'])){
                        echo $_POST['idConfirmacionVenta'];
                    }elseif (isset($_POST['generarReporte'])&&isset($_POST['idOrdenProduccion'])&&empty($_POST['idLote'])){
                        echo $_POST['idOrdenProduccion'];
                    }elseif (isset($_POST['generarReporte'])&&isset($_POST['idLote'])){
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
                        ?>
                        <div class="row">
                            <div class="col-7">
                                <div class="row">
                                    <div class="col-4">
                                        <p><b>Lote:</b></p>
                                    </div>
                                    <div class="col-8">
                                        <p><?php echo $_POST['idLote'];?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <p><b>Orden de Producción:</b></p>
                                    </div>
                                    <div class="col-8">
                                        <p><?php echo $idOrdenProduccion;?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <p><b>Contrato:</b></p>
                                    </div>
                                    <div class="col-8">
                                        <p><?php echo $idContrato;?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="row">
                                    <div class="col-6">
                                        <p><b>Producto:</b></p>
                                    </div>
                                    <div class="col-6">
                                        <p><?php echo $idProducto;?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p><b>Talla:</b></p>
                                    </div>
                                    <div class="col-6">
                                        <p><?php echo $talla;?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p><b>Combinación de Colores:</b></p>
                                    </div>
                                    <div class="col-6">
                                        <p><?php echo $combinacionColor;?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="spacer20"></div>
                        <div class="row">
                            <div class="col-12">
                                <h6 class="text-left"><b>Avance del Lote:</b></h6>
                            </div>
                            <div class="spacer10"></div>
                            <div class="col-12">
                                <table class="table text-center">
                                    <thead>
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
                                    <?php
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
                                        }
                                        $result1 = mysqli_query($link,"SELECT * FROM SubProceso WHERE idProcedimiento = '{$fila['idProcedimiento']}'");
                                        while ($fila1 = mysqli_fetch_array($result1)){
                                            $procedimiento = $fila1['descripcion'];
                                        }
                                        $result1 = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE idComponente IN (SELECT idComponente FROM ProductoComponentesPrenda WHERE idComponenteEspecifico = '{$fila['idComponenteEspecifico']}')");
                                        while ($fila1 = mysqli_fetch_array($result1)){
                                            $componente = $fila1['descripcion'];
                                        }
                                        $fecha = explode("|",$fila['fecha']);
                                        echo "<tr>";
                                        echo "<td>{$fecha[0]} - {$fecha[1]}</td>";
                                        echo "<td>{$nombre}</td>";
                                        echo "<td>{$componente}</td>";
                                        echo "<td>{$procedimiento}</td>";
                                        echo "<td>{$maquina}</td>";
                                        echo "<td>{$fila['cantidad']}</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="spacer10"></div>
                            <div class="col-12">
                                <?php
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
                                echo "<p><b>Porcentaje de Avance del Lote:</b> {$porcentajeAvance}%</p>";
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </section>

    <?php
    include('footer.php');
}
?>
