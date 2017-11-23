<?php
include('session.php');
if(isset($_SESSION['login'])){
    include('header.php');
    include('navbarAdmin.php');
    include('funciones.php');
    include('declaracionFechas.php');

    ?>
    <form method="post" id="formColaborador">
    <section class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-inverse card-info">
                        <div class="float-left mt-1">
                            <i class="fa fa-users"></i>
                            &nbsp;&nbsp;Nuevo Colaborador
                        </div>
                        <div class="float-right">
                            <div class="dropdown">
                                <input name="addColaborador" type="submit" form="formColaborador" class="btn btn-light btn-sm" formaction="gestionColaboradores.php" value="Guardar">
                                <input name="regresar" type="submit" form="formColaborador" class="btn btn-light btn-sm" formaction="gestionColaboradores.php" value="Regresar">
                            </div>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="col-12">
                            <div class="spacer20"></div>
                            <div class="form-group row">
                                <label for="dni" class="col-2 col-form-label">Doc. de Identidad:</label>
                                <div class="col-10">
                                    <input class="form-control" type="number" id="dni" name="dni">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nombres" class="col-2 col-form-label">Nombres:</label>
                                <div class="col-10">
                                    <input class="form-control" type="text" id="nombres" name="nombres">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="apellidos" class="col-2 col-form-label">Apellidos:</label>
                                <div class="col-10">
                                    <input class="form-control" type="text" id="apellidos" name="apellidos">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="usuario" class="col-2 col-form-label">Usuario:</label>
                                <div class="col-10">
                                    <input class="form-control" type="text" id="usuario" name="usuario">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="contrasena" class="col-2 col-form-label">Contraseña:</label>
                                <div class="col-10">
                                    <input class="form-control" type="text" id="contrasena" name="contrasena">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tipoUsuario" class="col-2 col-form-label">Tipo de Usuario:</label>
                                <div class="col-6">
                                    <select class="form-control" name="tipoUsuario" id="tipoUsuario">
                                        <option selected disabled>Seleccionar</option>
                                        <?php
                                        $result = mysqli_query($link, "SELECT * FROM TipoUsuario ORDER BY descripcion ASC");
                                        while ($fila = mysqli_fetch_array($result)){
                                            echo "<option value='{$fila['idTipoUsuario']}'>{$fila['descripcion']}</option>";
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