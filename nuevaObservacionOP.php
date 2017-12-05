<?php
include('session.php');
include('declaracionFechas.php');
include('funciones.php');
if(isset($_SESSION['login'])){
    include('header.php');
    include('navbarAdmin.php');

    ?>

    <section class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-inverse card-info">
                        <div class="float-left">
                            <i class="fa fa-cogs"></i>
                            Agregar Observación a OP
                        </div>
                        <div class="float-right">
                            <div class="dropdown">
                                <button form="form" name='volver' class='btn btn-light btn-sm'>Volver</button>
                                <button form="form" name='nuevaObs' class='btn btn-light btn-sm'>Guardar</button>
                            </div>
                        </div>
                    </div>
                    <form method="post" action="gestionOP.php" id="form">
                        <input type="hidden" name="idOrdenProduccion" value="<?php echo $_POST['idOrdenProduccion'];?>">
                        <div class="card-block">
                            <div class="col-12">
                                <div class="spacer15"></div>
                                <div class="form-group row">
                                    <label for="observacion" class="col-2 col-form-label">Observación:</label>
                                    <div class="col-10">
                                        <textarea id="observacion" rows="3" name="observacion" class="form-control"></textarea>
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

    include('footer.php');
}
?>
