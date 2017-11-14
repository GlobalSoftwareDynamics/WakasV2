<?php
include('session.php');
if(isset($_SESSION['login'])){
	include('header.php');
	include('navbarAdmin.php');
	?>

<section class="container" style="padding-top: 15px; padding-bottom: 15px;">
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-3 pl-0">
            <div class="card text-white bg-wakas o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fa fa-fw fa-shopping-cart"></i>
                    </div>
                    <div>26 Nuevas CV</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="#">
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
                        <i class="fa fa-fw fa-list"></i>
                    </div>
                    <div>11 Nuevas OP</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="#">
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
                        <i class="fa fa-fw fa-tags"></i>
                    </div>
                    <div>123 Productos Terminados</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="#">
                    <span class="float-left">Ver Detalles</span>
                    <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
                </a>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3 pr-0">
            <div class="card text-white bg-wakas o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fa fa-fw fa-cogs"></i>
                    </div>
                    <div>13 Productos en Proceso</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="#">
                    <span class="float-left">Ver Detalles</span>
                    <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card mb-3 col-12 pl-0 pr-0">
            <div class="card-header">
                <i class="fa fa-area-chart"></i> Ingresos Anuales</div>
            <div class="card-body">
                <canvas id="myAreaChart" width="100%" height="30"></canvas>
            </div>
            <div class="card-footer small text-muted">Actualizado el: <?php echo $date=date("Y-m-d")?></div>
        </div>
    </div>
    <div class="row">
        <div class="col-6 pl-0">
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
        <div class="col-6 pr-0">
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