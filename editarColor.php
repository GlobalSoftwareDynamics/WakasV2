<?php
include('session.php');
include('declaracionFechas.php');
include('funciones.php');
if(isset($_SESSION['login'])){
    include('header.php');
    include('navbarAdmin.php');

    $result = mysqli_query($link,"SELECT * FROM Color WHERE idColor = '{$_POST['idColor']}'");
    while($row = mysqli_fetch_array($result)) {

        ?>

        <section class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-inverse card-info">
                            <div class="float-left">
                                <i class="fa fa-wrench"></i>
                                Editar Color
                            </div>
                            <div class="float-right">
                                <div class="dropdown">
                                    <button form="form" name='volver' class='btn btn-light btn-sm'>Volver</button>
                                    <button form="form" name='editar' class='btn btn-light btn-sm'>Guardar</button>
                                </div>
                            </div>
                        </div>
                        <form method="post" action="gestionColores.php" id="form">
                            <input type="hidden" name="idColor" value="<?php echo $_POST['idColor'];?>">
                            <div class="card-block">
                                <div class="col-12">
                                    <div class="spacer15"></div>
                                    <div class="form-group row">
                                        <label for="codificacion" class="col-2 col-form-label">Código de Color:</label>
                                        <div class="col-10">
                                            <input class="form-control" type="text" id="codificacion" name="codificacion" value="<?php echo $row['idColor'];?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="color" class="col-2 col-form-label">Nombre de Color:</label>
                                        <div class="col-10">
                                            <input class="form-control" type="text" id="color" name="color" value="<?php echo $row['descripcion'];?>">
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
