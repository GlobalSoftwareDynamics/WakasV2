<?php
include('session.php');
if(isset($_SESSION['login'])){
    include('header.php');
    include('navbarOperario.php');
    include('funciones.php');
    include('declaracionFechas.php');

    ?>
    <form method="post" id="formRegistro">
        <section class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-inverse card-info">
                            <div class="float-left mt-1">
                                <i class="fa fa-cogs"></i>
                                &nbsp;&nbsp;Registro de Actividad Muerta (Revisión)
                            </div>
                            <div class="float-right">
                                <div class="dropdown">
                                    <input name="regActiviadadMuerta" type="submit" form="formRegistro" class="btn btn-light btn-sm" formaction="registrarActividadMuerta_Confirmacion.php" value="Guardar">
                                </div>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="col-12">
                                <div class="spacer20"></div>
                                <div class="form-group row">
                                    <label for="categoriaAM" class="col-12 col-form-label">Categoria de Actividad Muerta:</label>
                                    <div class="col-12">
                                        <select class="form-control" name="categoriaAM" id="categoriaAM">
                                            <?php
                                            $result = mysqli_query($link,"SELECT * FROM ActividadMuerta WHERE idActividadMuerta = '{$_POST['categoriaAM']}'");
                                            while ($fila = mysqli_fetch_array($result)){
                                                echo "<option value='{$fila['idActividadMuerta']}' selected>{$fila['descripcion']}</option>";
                                            }
                                            $result = mysqli_query($link,"SELECT * FROM ActividadMuerta");
                                            while ($fila = mysqli_fetch_array($result)){
                                                echo "<option value='{$fila['idActividadMuerta']}'>{$fila['descripcion']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="descripcion" class="col-12 col-form-label">Descripción:</label>
                                    <div class="col-12" id="productoLote">
                                        <textarea class="form-control" rows="2" id="descripcion" name="descripcion"><?php echo $_POST['descripcion']?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tiempoEmpleado" class="col-12 col-form-label">Tiempo Empleado (Min):</label>
                                    <div class="col-12">
                                        <input type="number" min="0" name="tiempoEmpleado" id="tiempoEmpleado" class="form-control" value="<?php echo $_POST['tiempoEmpleado']?>" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="maquina" class="col-12 col-form-label">Máquina (Opcional):</label>
                                    <div class="col-12">
                                        <select class="form-control" name="maquina" id="maquina">
                                            <?php
                                            if($_POST['maquina'] == ""){
                                                echo "<option selected disabled>Seleccionar</option>";
                                            }else{
                                                $result = mysqli_query($link,"SELECT * FROM Maquina WHERE idMaquina = '{$_POST['maquina']}'");
                                                while ($fila = mysqli_fetch_array($result)){
                                                    echo "<option value='{$fila['idMaquina']}' selected>{$fila['descripcion']}</option>";
                                                }
                                            }
                                            $result = mysqli_query($link,"SELECT * FROM Maquina");
                                            while ($fila = mysqli_fetch_array($result)){
                                                echo "<option value='{$fila['idMaquina']}'>{$fila['descripcion']}</option>";
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
    </form>

    <?php
    include('footer.php');
}
?>