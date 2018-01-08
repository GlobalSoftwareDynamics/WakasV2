<?php
include('session.php');
include('declaracionFechas.php');
include('funciones.php');
if(isset($_SESSION['login'])){
    include('header.php');
    include('navbarAdmin.php');

    $result = mysqli_query($link,"SELECT * FROM Medida WHERE idMedida = '{$_POST['idMedida']}'");
    while($row = mysqli_fetch_array($result)) {

        ?>

        <section class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-inverse card-info">
                            <div class="float-left">
                                <i class="fa fa-wrench"></i>
                                Editar Medida
                            </div>
                            <div class="float-right">
                                <div class="dropdown">
                                    <button form="form" name='volver' class='btn btn-light btn-sm'>Volver</button>
                                    <button form="form" name='editar' class='btn btn-light btn-sm'>Guardar</button>
                                </div>
                            </div>
                        </div>
                        <form method="post" action="gestionMedidas.php" id="form">
                            <input type="hidden" name="idMedida" value="<?php echo $_POST['idMedida'];?>">
                            <div class="card-block">
                                <div class="col-12">
                                    <div class="spacer15"></div>
                                    <div class="form-group row">
                                        <label class="col-form-label" for="codigo">Código:</label>
                                        <input type="text" name="codigo" id="codigo" class="form-control" value="<?php echo $row['idMedida'];?>">
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label" for="descripcion">Medida:</label>
                                        <input type="text" name="descripcion" id="descripcion" class="form-control" value="<?php echo $row['descripcion'];?>">
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label" for="unidad">Unidad de Medida:</label>
                                        <select name="unidad" id="unidad" class="form-control">
                                            <option selected value="<?php echo $row['idUnidadMedida'];?>"><?php echo $row['idUnidadMedida'];?></option>
                                            <?php
                                            $result = mysqli_query($link,"SELECT * FROM UnidadMedida ORDER BY idUnidadMedida ASC");
                                            while ($fila = mysqli_fetch_array($result)){
                                                echo "<option value='{$fila['idUnidadMedida']}'>{$fila['idUnidadMedida']}</option>";
                                            }
                                            ?>
                                        </select>
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
