<?php
include('session.php');
if(isset($_SESSION['login'])){
    include('header.php');
    include('navbarAdmin.php');
    include('funciones.php');
    include('declaracionFechas.php');

    ?>
    <form method="post" id="formProveedor">
    <section class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-inverse card-info">
                        <div class="float-left mt-1">
                            <i class="fa fa-truck"></i>
                            &nbsp;&nbsp;Nuevo Proveedor
                        </div>
                        <div class="float-right">
                            <div class="dropdown">
                                <input name="addProveedor" type="submit" form="formProveedor" class="btn btn-light btn-sm" formaction="gestionProveedores.php" value="Guardar">
                                <input name="regresar" type="submit" form="formProveedor" class="btn btn-light btn-sm" formaction="gestionProveedores.php" value="Regresar">
                            </div>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="col-12">
                            <div class="spacer20"></div>
                            <div class="form-group row">
                                <label for="nombreProveedor" class="col-2 col-form-label">Nombre:</label>
                                <div class="col-10">
                                    <input class="form-control" type="text" id="nombreProveedor" name="nombreProveedor">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="direccion" class="col-2 col-form-label">Dirección:</label>
                                <div class="col-10">
                                    <input class="form-control" type="text" id="direccion" name="direccion">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="ciudad" class="col-2 col-form-label">Ciudad:</label>
                                <div class="col-6">
                                    <select class="form-control" name="ciudad" id="ciudad">
                                        <?php
                                        $result = mysqli_query($link, "SELECT * FROM Ciudad ORDER BY nombre ASC");
                                        while ($fila = mysqli_fetch_array($result)){
                                            echo "<option value='{$fila['idCiudad']}'>{$fila['nombre']}</option>";
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