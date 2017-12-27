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
                                <label class="sr-only" for="idEmpleado">DNI</label>
                                <div id="Empleado">
                                    <input type="number" class="form-control mt-2 mb-2 mr-2" id="idEmpleado" name="idEmpleado" placeholder="DNI" onchange="getNombreEmpleado(this.value)">
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
                                    $result = mysqli_query($link,"SELECT * FROM RegistroIngresoSalida WHERE idEmpleado = '{$_POST['idEmpleado']}'");
                                    while ($fila = mysqli_fetch_array($result)){
                                        echo "<tr>";
                                        echo "<td>{$fila['fecha']}</td>";
                                        echo "<td>{$fila['horaIngreso']}</td>";
                                        echo "<td>{$fila['horaSalida']}</td>";
                                        echo "<td></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                    </tbody>
                                </table>
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
