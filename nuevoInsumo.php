<?php
include('session.php');
if(isset($_SESSION['login'])){
    include('header.php');
    include('navbarAdmin.php');
    include('funciones.php');
    include('declaracionFechas.php');

    ?>
    <form method="post" id="formInsumo">
    <section class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-inverse card-info">
                        <div class="float-left mt-1">
                            <i class="fa fa-industry"></i>
                            &nbsp;&nbsp;Nuevo Insumo
                        </div>
                        <div class="float-right">
                            <div class="dropdown">
                                <input name="addInsumo" type="submit" form="formInsumo" class="btn btn-light btn-sm" formaction="gestionInsumos.php" value="Guardar">
                                <input name="regresar" type="submit" form="formInsumo" class="btn btn-light btn-sm" formaction="gestionInsumos.php" value="Regresar">
                            </div>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="col-12">
                            <div class="spacer20"></div>
                            <div class="form-group row">
                                <label for="nombreInsumo" class="col-2 col-form-label">Insumo:</label>
                                <div class="col-10">
                                    <input class="form-control" type="text" id="nombreInsumo" name="nombreInsumo">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tipoInsumo" class="col-2 col-form-label">Uso de Insumo:</label>
                                <div class="col-6">
                                    <select class="form-control" name="tipoInsumo" id="tipoInsumo">
                                        <option disabled selected>Seleccionar</option>
                                        <option value="1">Tejido</option>
                                        <option value="2">Lavado</option>
                                        <option value="3">Acondicionamiento</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="unidadMedida" class="col-2 col-form-label">Unidad de Medida:</label>
                                <div class="col-6">
                                    <select class="form-control" name="unidadMedida" id="unidadMedida">
                                        <option disabled selected>Seleccionar</option>
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
                </div>
            </div>
        </div>
    </section>

    <?php
    include('footer.php');
}
?>