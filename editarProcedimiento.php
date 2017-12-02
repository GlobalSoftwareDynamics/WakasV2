<?php
include('session.php');
include('declaracionFechas.php');
include('funciones.php');
if(isset($_SESSION['login'])){
    include('header.php');
    include('navbarAdmin.php');

    $result = mysqli_query($link,"SELECT * FROM SubProceso WHERE idProcedimiento = '{$_POST['idProcedimiento']}'");
    while($row = mysqli_fetch_array($result)) {
        $Tipo = $row['tipo'];
        switch ($row['tipo']) {
            case 1:
                $desTipo = "Primario";
                break;
            case 2:
                $desTipo = "Secundario";
                break;
        }

        ?>

        <section class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-inverse card-info">
                            <div class="float-left">
                                <i class="fa fa-cogs"></i>
                                Editar Procedimiento
                            </div>
                            <div class="float-right">
                                <div class="dropdown">
                                    <button form="form" name='volver' class='btn btn-light btn-sm'>Volver</button>
                                    <button form="form" name='editar' class='btn btn-light btn-sm'>Guardar</button>
                                </div>
                            </div>
                        </div>
                        <form method="post" action="gestionProcedimientos.php" id="form">
                            <input type="hidden" name="idProceso" value="<?php echo $_POST['idProceso'];?>">
                            <input type="hidden" name="idProcedimiento" value="<?php echo $_POST['idProcedimiento'];?>">
                            <div class="card-block">
                                <div class="col-12">
                                    <div class="spacer15"></div>
                                    <div class="form-group row">
                                        <label for="subproceso" class="col-2 col-form-label">Procedimiento:</label>
                                        <div class="col-10">
                                            <input class="form-control" type="text" id="subproceso" name="subproceso" value="<?php echo $row['descripcion'];?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <?php
    }
    include('footer.php');
}
?>
