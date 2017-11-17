<?php
include('session.php');
if(isset($_SESSION['login'])){
    include('header.php');
    include('navbarAdmin.php');
    include('funciones.php');
    include('declaracionFechas.php');

    ?>
    <form method="post" id="formContacto">
        <section class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-inverse card-info">
                            <div class="float-left mt-1">
                                <i class="fa fa-users"></i>
                                &nbsp;&nbsp;Datos de Contacto
                            </div>
                            <div class="float-right">
                                <div class="dropdown">
                                    <input name="addContacto" type="submit" form="formContacto" class="btn btn-light btn-sm" formaction="gestionContactos.php" value="Guardar">
                                    <input name="regresar" type="submit" form="formContacto" class="btn btn-light btn-sm" formaction="gestionContactos.php" value="Regresar">
                                </div>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="col-12">
                                <div class="spacer20"></div>
                                <input type="hidden" name="idCliente" value="<?php echo $_POST['idCliente'];?>">
                                <div class="form-group row">
                                    <label for="dni" class="col-2 col-form-label">Doc. de Identidad:</label>
                                    <div class="col-10">
                                        <input class="form-control" type="number" id="dni" name="dni">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nombreContacto" class="col-2 col-form-label">Nombre:</label>
                                    <div class="col-10">
                                        <input class="form-control" type="text" id="nombreContacto" name="nombreContacto">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-2 col-form-label">Email:</label>
                                    <div class="col-10">
                                        <input class="form-control" type="text" id="email" name="email">
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
                                <div class="form-group row">
                                    <label for="telefono" class="col-2 col-form-label">Teléfono:</label>
                                    <div class="col-10">
                                        <input class="form-control" type="text" id="telefono" name="telefono">
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