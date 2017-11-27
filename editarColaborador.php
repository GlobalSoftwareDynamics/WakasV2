<?php
include('session.php');
include('declaracionFechas.php');
include('funciones.php');
if(isset($_SESSION['login'])){
    include('header.php');
    include('navbarAdmin.php');

    $result = mysqli_query($link,"SELECT * FROM Empleado WHERE idEmpleado = '{$_POST['idEmpleado']}'");
    while($row = mysqli_fetch_array($result)) {
        $result1 = mysqli_query($link,"SELECT * FROM TipoUsuario WHERE idTipoUsuario = '{$row['idTipoUsuario']}'");
        while ($fila = mysqli_fetch_array($result1)){
            $tipoUsuario = $fila['descripcion'];
            $idTipoUsuario = $fila['idTipoUsuario'];
        }
        ?>

        <section class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-inverse card-info">
                            <div class="float-left">
                                <i class="fa fa-user"></i>
                                Editar Empleado>
                            </div>
                            <div class="float-right">
                                <div class="dropdown">
                                    <button form="form" name='volver' class='btn btn-light btn-sm'>Volver</button>
                                    <button form="form" name='editar' class='btn btn-light btn-sm'>Guardar</button>
                                </div>
                            </div>
                        </div>
                        <form method="post" action="gestionColaboradores.php" id="form">
                            <input type="hidden" name="idEmpleado" value="<?php echo $_POST['idEmpleado'];?>">
                            <div class="card-block">
                                <div class="col-12">
                                    <div class="spacer15"></div>
                                    <div class="form-group row">
                                        <label for="dni" class="col-2 col-form-label">Doc. de Identidad:</label>
                                        <div class="col-10">
                                            <input class="form-control" type="number" id="dni" name="dni" value="<?php echo $row['idEmpleado'];?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nombres" class="col-2 col-form-label">Nombres:</label>
                                        <div class="col-10">
                                            <input class="form-control" type="text" id="nombres" name="nombres" value="<?php echo $row['nombres'];?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="apellidos" class="col-2 col-form-label">Apellidos:</label>
                                        <div class="col-10">
                                            <input class="form-control" type="text" id="apellidos" name="apellidos" value="<?php echo $row['apellidos'];?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="usuario" class="col-2 col-form-label">Usuario:</label>
                                        <div class="col-10">
                                            <input class="form-control" type="text" id="usuario" name="usuario" value="<?php echo $row['usuario'];?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="contrasena" class="col-2 col-form-label">Contraseña:</label>
                                        <div class="col-10">
                                            <input class="form-control" type="text" id="contrasena" name="contrasena" value="<?php echo $row['contrasena'];?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="tipoUsuario" class="col-2 col-form-label">Tipo de Usuario:</label>
                                        <div class="col-6">
                                            <select class="form-control" name="tipoUsuario" id="tipoUsuario">
                                                <option selected value="<?php echo $idTipoUsuario;?>"><?php echo $tipoUsuario;?></option>
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
