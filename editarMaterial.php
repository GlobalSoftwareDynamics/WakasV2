<?php
include('session.php');
include('declaracionFechas.php');
include('funciones.php');
if(isset($_SESSION['login'])){
    include('header.php');
    include('navbarAdmin.php');

    $result = mysqli_query($link,"SELECT * FROM Material WHERE idMaterial = '{$_POST['idMaterial']}'");
    while($row = mysqli_fetch_array($result)) {

        ?>

        <section class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-inverse card-info">
                            <div class="float-left">
                                <i class="fa fa-industry"></i>
                                Editar Material
                            </div>
                            <div class="float-right">
                                <div class="dropdown">
                                    <button form="form" name='volver' class='btn btn-light btn-sm'>Volver</button>
                                    <button form="form" name='editar' class='btn btn-light btn-sm'>Guardar</button>
                                </div>
                            </div>
                        </div>
                        <form method="post" action="gestionMateriales.php" id="form">
                            <input type="hidden" name="idMaterial" value="<?php echo $_POST['idMaterial'];?>">
                            <div class="card-block">
                                <div class="col-12">
                                    <div class="spacer15"></div>
                                    <div class="form-group row">
                                        <label for="nombreMaterial" class="col-2 col-form-label">Material:</label>
                                        <div class="col-10">
                                            <input class="form-control" type="text" id="nombreMaterial" name="nombreMaterial" value="<?php echo $row['material'];?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="siglas" class="col-2 col-form-label">Siglas:</label>
                                        <div class="col-10">
                                            <input class="form-control" type="text" id="siglas" name="siglas" value="<?php echo $row['siglas'];?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="unidadMedida" class="col-2 col-form-label">Unidad de Medida:</label>
                                        <div class="col-6">
                                            <select class="form-control" name="unidadMedida" id="unidadMedida">
                                                <option selected><?php echo $row['idUnidadMedida']?></option>
                                                <?php
                                                $result = mysqli_query($link, "SELECT * FROM UnidadMedida ORDER BY idUnidadMedida ASC");
                                                while ($fila = mysqli_fetch_array($result)){
                                                    echo "<option value='{$fila['idUnidadMedida']}'>{$fila['idUnidadMedida']}</option>";
                                                }
                                                ?>
                                            </select>
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
