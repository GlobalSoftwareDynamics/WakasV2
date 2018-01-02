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
                Reporte de Máquina
                <div class="float-right">
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Acciones
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <form method="post">
                                <?php
                                if(isset($_POST['generarReporte'])){
                                    echo "<input type='hidden' name='idMaquina' value='{$_POST['idMaquina']}'>";
                                    echo "<input type='hidden' name='fechaInicio' value='{$_POST['fechaInicio']}'>";
                                    echo "<input type='hidden' name='fechaFin' value='{$_POST['fechaFin']}'>";
                                }
                                ?>
                                <input class="dropdown-item" type="submit" name="pdf" formaction="reporteMaquinaPDF.php" value="Descargar PDF">
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
                                <label class="sr-only" for="idMaquina">Máquina</label>
                                <input type="text" class="form-control mt-2 mb-2 mr-2" id="idMaquina" name="idMaquina" placeholder="Máquina" required>
                                <label class="sr-only" for="fechaInicio">Fecha Inicio</label>
                                <input type="date" class="form-control mt-2 mb-2 mr-2" id="fechaInicio" name="fechaInicio" data-toggle="popover" data-trigger="focus" title="Fecha de Inicio de Reporte" data-content="Seleccione la fecha inicial para el reporte generado." data-placement="top" required>
                                <label class="sr-only" for="fechaFin">Fecha Fin</label>
                                <input type="date" class="form-control mt-2 mb-2 mr-2" id="fechaFin" name="fechaFin" data-toggle="popover" data-trigger="focus" title="Fecha de Fin de Reporte" data-content="Seleccione la fecha límite para el reporte generado." data-placement="top" required>
                                <input type="submit" class="btn btn-primary" value="Generar" style="padding-left:28px; padding-right: 28px;" name="generarReporte">
                            </form>
                        </div>
                        <div class="spacer10"></div>
                        <div style="width: 100%; border-top: 1px solid lightgrey;"></div>
                    </div>
                </div>
                <div class="spacer20"></div>
                <?php
                if(isset($_POST['generarReporte'])&&$_POST['fechaInicio']>$_POST['fechaFin']){
                    echo "
                        <div class='row'>
                            <div class='col-12'>
                                <p class='text-center'>La Fecha de Inicio de Reporte ingresada es mayor a la Fecha de Fin de Reporte. Por favor seleccione las fechas correctamente e intente de nuevo.</p>
                            </div>
                        </div>
                    ";
                }else{
                    if (isset($_POST['generarReporte'])&&isset($_POST['idMaquina'])){
                        $result = mysqli_query($link,"SELECT * FROM Maquina WHERE descripcion = '{$_POST['idMaquina']}'");
                        while ($fila = mysqli_fetch_array($result)){
                            $maquina = $fila['descripcion'];
                            $idMaquina = $fila['idMaquina'];
                        }
                        ?>
                        <div class="row">
                            <div class="col-7">
                                <div class="row">
                                    <div class="col-4">
                                        <p><b>Máquina:</b></p>
                                    </div>
                                    <div class="col-8">
                                        <p><?php echo $maquina;?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="row">
                                    <div class="col-4">
                                        <p><b>Fecha Inicio:</b></p>
                                    </div>
                                    <div class="col-8">
                                        <p><?php echo $_POST['fechaInicio'];?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <p><b>Fecha Fin:</b></p>
                                    </div>
                                    <div class="col-8">
                                        <p><?php echo $_POST['fechaFin'];?></p>
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
                                    <?php
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
                                        echo "<tr>";
                                        echo "<td>{$fila['fecha']}</td>";
                                        echo "<td>{$nombre}</td>";
                                        echo "<td>{$fila['idLote']}</td>";
                                        echo "<td>{$producto}</td>";
                                        echo "<td>{$componente}</td>";
                                        echo "<td>{$procedimiento}</td>";
                                        echo "<td>{$fila['cantidad']}</td>";
                                        echo "</tr>";
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

                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="spacer20"></div>
                            <div class="col-12">
                                <h6 class="text-left"><b>Tiempo de Operación: </b><?php echo $tiempoOperacionHrs;?> Hrs.</h6>
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
                                    <?php
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
                                        echo "<tr>";
                                        echo "<td>{$fila['fecha']}</td>";
                                        echo "<td>{$nombre}</td>";
                                        echo "<td>{$actividadMuerta}</td>";
                                        echo "<td>{$fila['descripcion']}</td>";
                                        echo "<td>{$fila['tiempo']} Min</td>";
                                        echo "</tr>";

                                        $tiempoActividadMuerta = $tiempoActividadMuerta + $fila['tiempo'];
                                    }
                                    $HorasWakas = $tiempoActividadMuerta/60;
                                    $HorasWakas1 = round($HorasWakas,0,PHP_ROUND_HALF_DOWN);
                                    $HorasWakas2 = $tiempoActividadMuerta-($HorasWakas1*60);
                                    $HorasFinalE = $HorasWakas1.":".$HorasWakas2;
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="spacer20"></div>
                            <div class="col-12">
                                <h6 class="text-left"><b>Tiempo Muerto de Máquina: </b><?php echo $HorasFinalE;?> Hrs.</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <?php
                                $MinutosFinalTrabajo = explode(":",$tiempoOperacionHrs);
                                $MinutosFinalTrabajo = ($MinutosFinalTrabajo[0]*60) + $MinutosFinalTrabajo[1];

                                $MinutosFinalActividadMuerta = explode(":",$HorasFinalE);
                                $MinutosFinalActividadMuerta = ($MinutosFinalActividadMuerta[0]*60) + $MinutosFinalActividadMuerta[1];

                                $productividad =(($MinutosFinalTrabajo-$MinutosFinalActividadMuerta)/$MinutosFinalTrabajo)*100;
                                $productividad = round($productividad,2);
                                ?>
                                <h6 class="text-left"><b>% Referencial de Productividad de Máquina: </b><?php echo $productividad;?> %</h6>
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
