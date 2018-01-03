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
                Reporte de Personal
                <div class="float-right">
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Acciones
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <form method="post">
                                <?php
                                if(isset($_POST['generarReporte'])){
                                    echo "<input type='hidden' name='idEmpleado' value='{$_POST['idEmpleado']}'>";
                                    echo "<input type='hidden' name='fechaInicio' value='{$_POST['fechaInicio']}'>";
                                    echo "<input type='hidden' name='fechaFin' value='{$_POST['fechaFin']}'>";
                                }
                                ?>
                                <input class="dropdown-item" type="submit" name="pdf" formaction="reportePersonalPDF.php" value="Descargar PDF">
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
                                <label class="sr-only" for="idEmpleado">DNI</label>
                                <div id="Empleado">
                                    <input type="number" class="form-control mt-2 mb-2 mr-2" id="idEmpleado" name="idEmpleado" placeholder="DNI" onchange="getNombreEmpleado(this.value)" required>
                                </div>
                                <label class="sr-only" for="nombreEmpleado">Nombre</label>
                                <input type="text" class="form-control mt-2 mb-2 mr-2" id="nombreEmpleado" name="nombreEmpleado" placeholder="Nombre" onchange="getDniEmpleado(this.value)">
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
                    if (isset($_POST['generarReporte'])&&isset($_POST['idEmpleado'])){
                        $result = mysqli_query($link,"SELECT * FROM Empleado WHERE idEmpleado = '{$_POST['idEmpleado']}'");
                        while ($fila = mysqli_fetch_array($result)){
                            $nombreCompleto = $fila['nombres']." ".$fila['apellidos'];
                        }
                        ?>
                        <div class="row">
                            <div class="col-7">
                                <div class="row">
                                    <div class="col-4">
                                        <p><b>DNI:</b></p>
                                    </div>
                                    <div class="col-8">
                                        <p><?php echo $_POST['idEmpleado'];?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <p><b>Nombre Completo:</b></p>
                                    </div>
                                    <div class="col-8">
                                        <p><?php echo $nombreCompleto;?></p>
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
                                <h6 class="text-left"><b>Registro de Ingresos y Salidas:</b></h6>
                            </div>
                            <div class="spacer10"></div>
                            <div class="col-12">
                                <table class="table text-center">
                                    <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Ingreso</th>
                                        <th>Salida</th>
                                        <th>Tiempo de Trabajo</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $tiempoTotalIntervalo = 0;
                                    $result = mysqli_query($link,"SELECT * FROM RegistroIngresoSalida WHERE idEmpleado = '{$_POST['idEmpleado']}' AND fecha >= '{$_POST['fechaInicio']}' AND fecha <= '{$_POST['fechaFin']}'");
                                    while ($fila = mysqli_fetch_array($result)){
                                        $a = new DateTime($fila['horaSalida']);
                                        $b = new DateTime($fila['horaIngreso']);
                                        $interval = $a->diff($b);

                                        $tiempoTotal = $interval->format("%H:%I");

                                        echo "<tr>";
                                        echo "<td>{$fila['fecha']}</td>";
                                        echo "<td>{$fila['horaIngreso']}</td>";
                                        echo "<td>{$fila['horaSalida']}</td>";
                                        echo "<td>{$tiempoTotal}</td>";
                                        echo "</tr>";

                                        $tiempoExplode = explode(":",$tiempoTotal);
                                        $MinutosWakas = ($tiempoExplode[0]*60)+$tiempoExplode[1];

                                        $tiempoTotalIntervalo = $tiempoTotalIntervalo + $MinutosWakas;
                                    }
                                    $HorasWakas = $tiempoTotalIntervalo/60;
                                    $HorasWakas1 = floor($HorasWakas);
                                    $HorasWakas2 = $tiempoTotalIntervalo-($HorasWakas1*60);
                                    $HorasFinalE = $HorasWakas1.":".$HorasWakas2;
                                    ?>
                                    <tr>
                                        <th>Total Horas Trabajadas</th>
                                        <td></td>
                                        <td></td>
                                        <td><?php echo $HorasFinalE;?> Hrs.</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="spacer10"></div>
                        <div class="row">
                            <div class="col-12">
                                <h6 class="text-left"><b>Registro de Actividades Realizadas:</b></h6>
                            </div>
                            <div class="spacer10"></div>
                            <div class="col-12" style="height: 400px; overflow-y: auto">
                                <table class="table text-center">
                                    <thead>
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
                                    <?php
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
                                            $result1 = mysqli_query($link,"SELECT * FROM PCPSPC WHERE idComponenteEspecifico = '{$fila['idComponenteEspecifico']}' AND idSubProcesoCaracteristica IN (SELECT idSubProcesoCaracteristica FROM SubProcesoCaracteristica WHERE idCaracteristica = '11')");
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

                                        echo "<tr>";
                                        echo "<td>{$fila['fecha']}</td>";
                                        echo "<td>{$fila['idLote']}</td>";
                                        echo "<td>{$componente}</td>";
                                        echo "<td>{$procedimiento}</td>";
                                        echo "<td>{$fila['cantidad']}</td>";
                                        echo "<td>{$tiempo} min</td>";
                                        echo "</tr>";

                                        $tiempoComponente = $fila['cantidad'] * $tiempo;
                                        $tiempoTotalTrabajado = $tiempoTotalTrabajado + $tiempoComponente;
                                    }
                                    $HorasWakas3 = $tiempoTotalTrabajado/60;
                                    $HorasWakas4 = floor($HorasWakas3);
                                    $HorasWakas5 = $tiempoTotalTrabajado-($HorasWakas4*60);
                                    $HorasFinalT = $HorasWakas4.":".$HorasWakas5;
                                    ?>
                                    <tr>
                                        <th>Total</th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><?php echo $HorasFinalT?> Hrs.</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="spacer20"></div>
                        <div class="row">
                            <div class="col-12">
                                <h6 class="text-left"><b>Registro de Tiempo Muerto:</b></h6>
                            </div>
                            <div class="spacer10"></div>
                            <div class="col-12" style="height: 350px; overflow: auto">
                                <table class="table text-center">
                                    <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Actividad Muerta</th>
                                        <th>Descripción</th>
                                        <th>Tiempo</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $tiempoTotalActividadMuerta = 0;
                                    $result = mysqli_query($link,"SELECT * FROM EmpleadoActividadMuerta WHERE idEmpleado = '{$_POST['idEmpleado']}' AND fecha >= '{$_POST['fechaInicio']}' AND fecha <= '{$_POST['fechaFin']}'");
                                    while ($fila = mysqli_fetch_array($result)){
                                        $result1 = mysqli_query($link,"SELECT * FROM ActividadMuerta WHERE idActividadMuerta = '{$fila['idActividadMuerta']}'");
                                        while ($fila1 = mysqli_fetch_array($result1)){
                                            $actvidadMuerta = $fila1['descripcion'];
                                        }
                                        echo "<tr>";
                                        echo "<td>{$fila['fecha']}</td>";
                                        echo "<td>{$actvidadMuerta}</td>";
                                        echo "<td>{$fila['descripcion']}</td>";
                                        echo "<td>{$fila['tiempo']}</td>";
                                        echo "</tr>";

                                        $tiempoTotalActividadMuerta = $tiempoTotalActividadMuerta + $fila['tiempo'];
                                    }
                                    $HorasWakas6 = $tiempoTotalActividadMuerta/60;
                                    $HorasWakas7 = floor($HorasWakas6);
                                    $HorasWakas8 = $tiempoTotalActividadMuerta-($HorasWakas7*60);
                                    $HorasFinalAM = $HorasWakas7.":".$HorasWakas8;
                                    ?>
                                    <tr>
                                        <th>Total Horas Muertas</th>
                                        <td></td>
                                        <td></td>
                                        <td><?php echo $HorasFinalAM;?> Hrs.</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="spacer10"></div>
                        <div class="row">
                            <div class="col-12">
                                <?php
                                $MinutosFinalEstancia = explode(":",$HorasFinalE);
                                $MinutosFinalEstancia = ($MinutosFinalEstancia[0]*60) + $MinutosFinalEstancia[1];

                                $MinutosFinalTrabajo = explode(":",$HorasFinalT);
                                $MinutosFinalTrabajo = ($MinutosFinalTrabajo[0]*60) + $MinutosFinalTrabajo[1];

                                $MinutosFinalActividadMuerta = explode(":",$HorasFinalAM);
                                $MinutosFinalActividadMuerta = ($MinutosFinalActividadMuerta[0]*60) + $MinutosFinalActividadMuerta[1];

                                $productividad =(($MinutosFinalTrabajo-$MinutosFinalActividadMuerta)/$MinutosFinalEstancia)*100;
                                $productividad = round($productividad,2);
                                ?>
                                <h6 class="text-left"><b>% Referencial de Productividad de Trabajador: </b><?php echo $productividad;?> %</h6>
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
