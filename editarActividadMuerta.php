<?php
include('session.php');
include('declaracionFechas.php');
include('funciones.php');
if(isset($_SESSION['login'])){
    include('header.php');
    include('navbarAdmin.php');

    $result = mysqli_query($link,"SELECT * FROM ActividadMuerta WHERE idActividadMuerta = '{$_POST['idActividadMuerta']}'");
    while($row = mysqli_fetch_array($result)) {

        ?>

        <section class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-inverse card-info">
                            <div class="float-left">
                                <i class="fa fa-wrench"></i>
                                Editar Actividad Muerta
                            </div>
                            <div class="float-right">
                                <div class="dropdown">
                                    <button form="form" name='volver' class='btn btn-light btn-sm'>Volver</button>
                                    <button form="form" name='editar' class='btn btn-light btn-sm'>Guardar</button>
                                </div>
                            </div>
                        </div>
                        <form method="post" action="gestionActividadMuerta.php" id="form">
                            <input type="hidden" name="idActividadMuerta" value="<?php echo $_POST['idActividadMuerta'];?>">
                            <div class="card-block">
                                <div class="col-12">
                                    <div class="spacer15"></div>
                                    <div class="form-group row">
                                        <label class="col-form-label" for="descripcion">Descripcion:</label>
                                        <input type="text" name="descripcion" id="descripcion" class="form-control" value="<?php echo $row['descripcion'];?>">
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label" for="tiempo">Tiempo Estándar:</label>
                                        <input type="number" min="0" name="tiempo" id="tiempo" class="form-control" value="<?php echo $row['tiempoEstandar'];?>">
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
