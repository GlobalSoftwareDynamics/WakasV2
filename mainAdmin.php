<?php
include('session.php');
if(isset($_SESSION['login'])){
	include('header.php');
	include('navbarAdmin.php');
	?>

<section class="container" style="padding-top: 15px; padding-bottom: 15px;">
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-wakas o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fa fa-fw fa-shopping-cart"></i>
                    </div>
                    <?php
                    $result = mysqli_query($link,"SELECT COUNT(*) AS cvAbierta FROM ConfirmacionVenta WHERE idEstado = 3");
                    while ($fila = mysqli_fetch_array($result)){
                    $cantidadCVAbiertas = $fila['cvAbierta'];
                    }
                    ?>
                    <div><?php echo $cantidadCVAbiertas;?> CV Abiertas</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="gestionCV.php">
                    <span class="float-left">Ver Listado</span>
                    <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
                </a>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-wakas o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fa fa-fw fa-shopping-bag"></i>
                    </div>
                    <?php
                    $result = mysqli_query($link,"SELECT COUNT(*) AS cvEmitida FROM ConfirmacionVenta WHERE idEstado = 4");
                    while ($fila = mysqli_fetch_array($result)){
                        $cantidadCVEmitidas = $fila['cvEmitida'];
                    }
                    ?>
                    <div><?php echo $cantidadCVEmitidas;?> CV Emitidas</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="gestionCV.php">
                    <span class="float-left">Ver Listado</span>
                    <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
                </a>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-wakas o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fa fa-fw fa-cog"></i>
                    </div>
                    <?php
                    $result = mysqli_query($link,"SELECT idContrato FROM ConfirmacionVenta WHERE idEstado = 4");
                    while ($fila = mysqli_fetch_array($result)){
                        $result1 = mysqli_query($link,"SELECT * FROM OrdenProduccion WHERE idContrato = '{$fila['idContrato']}' AND idOrdenProduccion IN (SELECT idOrdenProduccion FROM Lote WHERE idEstado = 6)");
                        $numRow = mysqli_num_rows($result1);
                    }
                    ?>
                    <div><?php echo $numRow;?> OP en Proceso</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="reporteProduccion.php">
                    <span class="float-left">Ver Detalles</span>
                    <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
                </a>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-wakas o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fa fa-fw fa-cogs"></i>
                    </div>
                    <?php
                    $result = mysqli_query($link,"SELECT COUNT(*) AS loteEnProceso FROM Lote WHERE idEstado = 6");
                    while ($fila = mysqli_fetch_array($result)){
                        $cantidadLotes = $fila['loteEnProceso'];
                    }
                    ?>
                    <div><?php echo $cantidadLotes;?> Lotes en Proceso</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="reporteProduccion.php">
                    <span class="float-left">Ver Detalles</span>
                    <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fa fa-area-chart"></i> Ingresos Anuales</div>
                <div class="card-body">
                    <canvas id="myAreaChart" width="100%" height="30"></canvas>
                </div>
                <div class="card-footer small text-muted">Actualizado el: <?php echo $date=date("Y-m-d")?></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6 col-sm-12 col-xs-12">
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fa fa-table"></i> Colaboradores del Mes</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Rendimiento</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-sm-12 col-xs-12">
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fa fa-table"></i> Productos en Proceso Tercerizado</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>OP</th>
                                <th>Proveedor</th>
                                <th>Entrega</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
    include('footer.php');
}
?>