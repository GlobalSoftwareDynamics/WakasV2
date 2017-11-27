<?php
include('session.php');
include('declaracionFechas.php');
include('funciones.php');
if(isset($_SESSION['login'])){
    include('header.php');
    include('navbarAdmin.php');

    $result = mysqli_query($link,"SELECT * FROM Galgas WHERE idGalgas = '{$_POST['idGalgas']}'");
    while($row = mysqli_fetch_array($result)) {

        ?>

        <section class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-inverse card-info">
                            <div class="float-left">
                                <i class="fa fa-wrench"></i>
                                Editar Galga
                            </div>
                            <div class="float-right">
                                <div class="dropdown">
                                    <button form="form" name='volver' class='btn btn-light btn-sm'>Volver</button>
                                    <button form="form" name='editar' class='btn btn-light btn-sm'>Guardar</button>
                                </div>
                            </div>
                        </div>
                        <form method="post" action="gestionGalgas.php" id="form">
                            <input type="hidden" name="idGalgas" value="<?php echo $_POST['idGalgas'];?>">
                            <div class="card-block">
                                <div class="col-12">
                                    <div class="spacer15"></div>
                                    <div class="form-group row">
                                        <label for="galga" class="col-2 col-form-label">Galga:</label>
                                        <div class="col-10">
                                            <input class="form-control" type="text" id="galga" name="galga" value="<?php echo $row['descripcion'];?>">
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
