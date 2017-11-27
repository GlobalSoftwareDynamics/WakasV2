<?php
include('session.php');
include('declaracionFechas.php');
include('funciones.php');
if(isset($_SESSION['login'])){
    include('header.php');
    include('navbarAdmin.php');

    if (isset($_POST['addMaquinaProcedimiento'])){

        $query = mysqli_query($link, "INSERT INTO MaquinaSubProceso(idMaquina, idProcedimiento) VALUES ('{$_POST['idMaquina']}','{$_POST['procedimiento']}')");

        $queryPerformed = "INSERT INTO MaquinaSubProceso(idMaquina, idProcedimiento) VALUES ({$_POST['idMaquina']},{$_POST['procedimiento']})";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','MaquinaSubProceso','{$queryPerformed}')");

    }

    if (isset($_POST['deleteMaquina'])){

        $query = mysqli_query($link, "DELETE FROM MaquinaSubProceso WHERE idMaquina = '{$_POST['idMaquina']}' AND idProcedimiento = '{$_POST['idProcedimiento']}'");

        $queryPerformed = "DELETE FROM MaquinaSubProceso WHERE idMaquina = {$_POST['idMaquina']} AND idProcedimiento = {$_POST['idProcedimiento']}";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','DELETE','MaquinaSubProceso','{$queryPerformed}')");

    }

    if (isset($_POST['addMaquinaRepuesto'])){

        $query = mysqli_query($link, "INSERT INTO RepuestosMaquina(idRepuestos, idMaquina) VALUES ('{$_POST['idRepuestos']}', '{$_POST['idMaquina']}')");

        $queryPerformed = "INSERT INTO RepuestosMaquina(idRepuestos, idMaquina) VALUES ({$_POST['idRepuestos']}, {$_POST['idMaquina']})";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','RepuestosMaquina','{$queryPerformed}')");

    }

    if (isset($_POST['deleteRepuesto'])){

        $query = mysqli_query($link, "DELETE FROM RepuestosMaquina WHERE idMaquina = '{$_POST['idMaquina']}' AND idRepuestos = '{$_POST['idRepuestos']}'");

        $queryPerformed = "DELETE FROM RepuestosMaquina WHERE idMaquina = {$_POST['idMaquina']} AND idRepuestos = {$_POST['idRepuestos']}";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','DELETE','RepuestosMaquina','{$queryPerformed}')");

    }

    $result = mysqli_query($link,"SELECT * FROM Maquina WHERE idMaquina = '{$_POST['idMaquina']}'");
    while($row = mysqli_fetch_array($result)) {

        ?>

        <section class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-inverse card-info">
                            <div class="float-left">
                                <i class="fa fa-cogs"></i>
                                Editar Maquina
                            </div>
                            <div class="float-right">
                                <div class="dropdown">
                                    <button form="form" name='volver' class='btn btn-light btn-sm'>Volver</button>
                                    <button form="form" name='editar' class='btn btn-light btn-sm'>Guardar</button>
                                </div>
                            </div>
                        </div>
                        <form method="post" action="gestionMaquinas.php" id="form">
                            <input type="hidden" name="idMaquina" value="<?php echo $_POST['idMaquina'];?>">
                            <div class="card-block">
                                <div class="col-12">
                                    <div class="spacer15"></div>
                                    <div class="form-group row">
                                        <label for="maquina" class="col-2 col-form-label">Máquina:</label>
                                        <div class="col-10">
                                            <input class="form-control" type="text" id="maquina" name="maquina" value="<?php echo $row['descripcion'];?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <div class="spacer15"></div>
        <section class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-inverse card-info">
                            <div class="float-left">
                                <i class="fa fa-cog"></i>
                                Procedimientos en los que Interviene
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="col-12">
                                <table class="table text-center">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Procedimiento</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $result=mysqli_query($link,"SELECT * FROM MaquinaSubProceso WHERE idMaquina = '{$_POST['idMaquina']}'");
                                    while ($fila=mysqli_fetch_array($result)){
                                        echo "<tr>";
                                        $result1=mysqli_query($link,"SELECT * FROM SubProceso WHERE idProcedimiento = '{$fila['idProcedimiento']}'");
                                        while ($fila1=mysqli_fetch_array($result1)){
                                            echo "<td>{$fila1['descripcion']}</td>";
                                        }
                                        echo "
                                              <td>
                                                  <form method='post' action='#'>
                                                        <div class='dropdown'>
                                                            <input type='hidden' name='idMaquina' value='{$_POST['idMaquina']}'>
                                                            <input type='hidden' name='idProcedimiento' value='{$fila['idProcedimiento']}'>
                                                            <input type='submit' class='btn btn-outline-primary' name='deleteMaquina' value='Eliminar'>
                                                        </div>
                                                    </form>
                                              </td>
                                        ";
                                        echo "</tr>";
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-12">
                                <button type="button" class="btn btn-outline-primary col-4 offset-4 mb-3" data-toggle="modal" data-target="#modalMaquina">Asignar Procedimiento</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="spacer15"></div>
        <section class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-inverse card-info">
                            <div class="float-left">
                                <i class="fa fa-wrench"></i>
                                Repuestos
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="col-12">
                                <table class="table text-center">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Repuesto</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $result=mysqli_query($link,"SELECT * FROM RepuestosMaquina WHERE idMaquina = '{$_POST['idMaquina']}'");
                                    while ($fila=mysqli_fetch_array($result)){
                                        echo "<tr>";
                                        $result1=mysqli_query($link,"SELECT * FROM Repuestos WHERE idRepuestos = '{$fila['idRepuestos']}'");
                                        while ($fila1=mysqli_fetch_array($result1)){
                                            echo "<td>{$fila1['descripcion']}</td>";
                                        }
                                        echo "
                                              <td>
                                                  <form method='post' action='#'>
                                                        <div class='dropdown'>
                                                            <input type='hidden' name='idMaquina' value='{$_POST['idMaquina']}'>
                                                            <input type='hidden' name='idRepuestos' value='{$fila['idRepuestos']}'>
                                                            <input type='submit' class='btn btn-outline-primary' name='deleteRepuesto' value='Eliminar'>
                                                        </div>
                                                    </form>
                                              </td>
                                        ";
                                        echo "</tr>";
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-12">
                                <button type="button" class="btn btn-outline-primary col-4 offset-4 mb-3" data-toggle="modal" data-target="#modalRepuestos">Asignar Repuestos</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="modal fade" id="modalMaquina" tabindex="-1" role="dialog" aria-labelledby="modalMaquina" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Asignar Procedimiento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form id="formMaquina" method="post" action="#">
                                <input type="hidden" name="idMaquina" value="<?php echo $_POST['idMaquina'];?>">
                                <div class="form-group row">
                                    <label class="col-form-label" for="procedimiento">Procedimiento:</label>
                                    <select name="procedimiento" id="procedimiento" class="form-control">
                                        <option disabled selected>Seleccionar</option>
                                        <?php
                                        $query = mysqli_query($link, "SELECT * FROM SubProceso WHERE idEstado = 1 ORDER BY descripcion ASC");
                                        while($row = mysqli_fetch_array($query)){
                                            echo "<option value='{$row['idProcedimiento']}'>{$row['descripcion']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button form="formMaquina" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button class="btn btn-primary" form="formMaquina" value="Submit" name="addMaquinaProcedimiento">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalRepuestos" tabindex="-1" role="dialog" aria-labelledby="modalRepuestos" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Asignar Repuestos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form id="formRepuesto" method="post" action="#">
                                <input type="hidden" name="idMaquina" value="<?php echo $_POST['idMaquina'];?>">
                                <div class="form-group row">
                                    <label class="col-form-label" for="idRepuestos">Procedimiento:</label>
                                    <select name="idRepuestos" id="idRepuestos" class="form-control">
                                        <option disabled selected>Seleccionar</option>
                                        <?php
                                        $query = mysqli_query($link, "SELECT * FROM Repuestos WHERE idEstado = 1 ORDER BY descripcion ASC");
                                        while($row = mysqli_fetch_array($query)){
                                            echo "<option value='{$row['idRepuestos']}'>{$row['descripcion']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button form="formRepuesto" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button class="btn btn-primary" form="formRepuesto" value="Submit" name="addMaquinaRepuesto">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }
    include('footer.php');
}
?>
