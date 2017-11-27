<?php
include('session.php');
if(isset($_SESSION['login'])){
    include('header.php');
    include('navbarAdmin.php');
    include('funciones.php');
    include('declaracionFechas.php');

    if (isset($_POST['addMaterial'])){

        $query = mysqli_query($link, "INSERT INTO MaterialProveedor(idMaterial, idProveedor, costo) VALUES ('{$_POST['material']}','{$_POST['idProveedor']}','{$_POST['costo']}')");

        $queryPerformed = "INSERT INTO MaterialProveedor(idMaterial, idProveedor, costo) VALUES ({$_POST['material']},{$_POST['idProveedor']},{$_POST['costo']})";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','MaterialProveedor','{$queryPerformed}')");

    }

    if (isset($_POST['addInsumo'])){

        $query = mysqli_query($link, "INSERT INTO ProveedorInsumos(idProveedor, idInsumo, costo) VALUES ('{$_POST['idProveedor']}','{$_POST['insumo']}','{$_POST['costo']}')");

        $queryPerformed = "INSERT INTO ProveedorInsumos(idProveedor, idInsumo, costo) VALUES ({$_POST['idProveedor']},{$_POST['insumo']},{$_POST['costo']})";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','ProveedorInsumos','{$queryPerformed}')");

    }

    if (isset($_POST['addSubProceso'])){

        $query = mysqli_query($link, "INSERT INTO ProveedorSubProceso(idProcedimiento, idProveedor, costo) VALUES ('{$_POST['subproceso']}','{$_POST['idProveedor']}','{$_POST['costo']}')");

        $queryPerformed = "INSERT INTO ProveedorSubProceso(idProcedimiento, idProveedor, costo) VALUES ({$_POST['subproceso']},{$_POST['idProveedor']},{$_POST['costo']})";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','ProveedorSubProceso','{$queryPerformed}')");

    }

    if (isset($_POST['deleteMaterial'])){

        $query = mysqli_query($link, "DELETE FROM MaterialProveedor WHERE idProveedor = '{$_POST['idProveedor']}' AND idMaterial = '{$_POST['idMaterial']}'");

        $queryPerformed = "DELETE FROM MaterialProveedor WHERE idProveedor = {$_POST['idProveedor']} AND idMaterial = {$_POST['idMaterial']}";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','DELETE','MaterialProveedor','{$queryPerformed}')");

    }

    if (isset($_POST['deleteInsumo'])){

        $query = mysqli_query($link, "DELETE FROM ProveedorInsumos WHERE idProveedor = '{$_POST['idProveedor']}' AND idInsumo = '{$_POST['idInsumo']}'");

        $queryPerformed = "DELETE FROM ProveedorInsumos WHERE idProveedor = {$_POST['idProveedor']} AND idInsumo = {$_POST['idInsumo']}";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','DELETE','ProveedorInsumos','{$queryPerformed}')");

    }

    if (isset($_POST['deleteProcedimiento'])){

        $query = mysqli_query($link, "DELETE FROM ProveedorSubProceso WHERE idProveedor = '{$_POST['idProveedor']}' AND idProcedimiento = '{$_POST['idProcedimiento']}'");

        $queryPerformed = "DELETE FROM ProveedorSubProceso WHERE idProveedor = {$_POST['idProveedor']} AND idProcedimiento = {$_POST['idProcedimiento']}";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','DELETE','ProveedorSubProceso','{$queryPerformed}')");

    }

    $result = mysqli_query($link,"SELECT * FROM Proveedor WHERE idProveedor = '{$_POST['idProveedor']}'");
    while($row = mysqli_fetch_array($result)) {
        $result1 = mysqli_query($link,"SELECT * FROM Direccion WHERE idDireccion = '{$row['idDireccion']}'");
        while ($fila = mysqli_fetch_array($result1)){
            $idDireccion = $fila['idDireccion'];
            $direccion = $fila['direccion'];
            $result2 = mysqli_query($link,"SELECT * FROM Ciudad WHERE idCiudad = '{$fila['idCiudad']}'");
            while ($fila1 = mysqli_fetch_array($result2)){
                $ciudad = $fila1['nombre'];
                $idCiudad = $fila1['idCiudad'];
                $result3 = mysqli_query($link,"SELECT * FROM Pais WHERE idPais = '{$fila1['idPais']}'");
                while ($fila2 = mysqli_fetch_array($result3)){
                    $pais = $fila2['pais'];
                }
            }
        }
        ?>

        <section class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-inverse card-info">
                            <div class="float-left">
                                <i class="fa fa-truck"></i>
                                Editar Proveedor
                            </div>
                            <div class="float-right">
                                <div class="dropdown">
                                    <button form="form" name='volver' class='btn btn-light btn-sm'>Volver</button>
                                    <button form="form" name='editar' class='btn btn-light btn-sm'>Guardar</button>
                                </div>
                            </div>
                        </div>
                        <form method="post" action="gestionProveedores.php" id="form">
                            <input type="hidden" name="idProveedor" value="<?php echo $_POST['idProveedor'];?>">
                            <input type="hidden" name="idDireccion" value="<?php echo $idDireccion;?>">
                            <div class="card-block">
                                <div class="col-12">
                                    <div class="spacer15"></div>
                                    <div class="form-group row">
                                        <label for="nombreProveedor" class="col-2 col-form-label">Nombre:</label>
                                        <div class="col-10">
                                            <input class="form-control" type="text" id="nombreProveedor" name="nombreProveedor" value="<?php echo $row['nombre'];?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="direccion" class="col-2 col-form-label">Dirección:</label>
                                        <div class="col-10">
                                            <input class="form-control" type="text" id="direccion" name="direccion" value="<?php echo $direccion;?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="ciudad" class="col-2 col-form-label">Ciudad:</label>
                                        <div class="col-10">
                                            <select class="form-control" id="ciudad" name="ciudad">
                                                <option selected value="<?php echo $idCiudad?>"><?php echo $ciudad?></option>
                                                <?php
                                                $opcionesciudad = mysqli_query($link,"SELECT * FROM Ciudad ORDER BY nombre DESC");
                                                while ($row1 = mysqli_fetch_array($opcionesciudad)){
                                                    echo "<option value='{$row1['idCiudad']}'>{$row1['nombre']}</option>";
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

        <div class="spacer15"></div>
        <section class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-inverse card-info">
                            <div class="float-left">
                                <i class="fa fa-dropbox"></i>
                                Materiales que Provee
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="col-12">
                                <table class="table text-center">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Material</th>
                                        <th class="text-center">Costo</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $result=mysqli_query($link,"SELECT * FROM MaterialProveedor WHERE idProveedor = '{$_POST['idProveedor']}'");
                                    while ($fila=mysqli_fetch_array($result)){
                                        echo "<tr>";
                                        $result1=mysqli_query($link,"SELECT * FROM Material WHERE idMaterial = '{$fila['idMaterial']}'");
                                        while ($fila1=mysqli_fetch_array($result1)){
                                            echo "<td>{$fila1['material']}</td>";
                                        }
                                        echo "<td>{$fila['costo']}</td>";
                                        echo "
                                              <td>
                                                  <form method='post' action='#'>
                                                        <div class='dropdown'>
                                                            <input type='hidden' name='idProveedor' value='{$_POST['idProveedor']}'>
                                                            <input type='hidden' name='idMaterial' value='{$fila['idMaterial']}'>
                                                            <input type='submit' class='btn btn-outline-primary' name='deleteMaterial' value='Eliminar'>
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
                                <button type="button" class="btn btn-outline-primary col-4 offset-4 mb-3" data-toggle="modal" data-target="#modalMaterial">Agregar Material</button>
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
                                <i class="fa fa-dropbox"></i>
                                Insumos que Provee
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="col-12">
                                <table class="table text-center">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Insumo</th>
                                        <th class="text-center">Costo</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $result=mysqli_query($link,"SELECT * FROM ProveedorInsumos WHERE idProveedor = '{$_POST['idProveedor']}'");
                                    while ($fila=mysqli_fetch_array($result)){
                                        echo "<tr>";
                                        $result1=mysqli_query($link,"SELECT * FROM Insumos WHERE idInsumo = '{$fila['idInsumo']}'");
                                        while ($fila1=mysqli_fetch_array($result1)){
                                            echo "<td>{$fila1['descripcion']}</td>";
                                        }
                                        echo "<td>{$fila['costo']}</td>";
                                        echo "
                                              <td>
                                                  <form method='post' action='#'>
                                                        <div class='dropdown'>
                                                            <input type='hidden' name='idProveedor' value='{$_POST['idProveedor']}'>
                                                            <input type='hidden' name='idInsumo' value='{$fila['idInsumo']}'>
                                                            <input type='submit' class='btn btn-outline-primary' name='deleteInsumo' value='Eliminar'>
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
                                <button type="button" class="btn btn-outline-primary col-4 offset-4 mb-3" data-toggle="modal" data-target="#modalInsumo">Agregar Insumo</button>
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
                                <i class="fa fa-gears"></i>
                                Sub Procesos que Provee
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="col-12">
                                <table class="table text-center">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Sub Proceso</th>
                                        <th class="text-center">Costo</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $result=mysqli_query($link,"SELECT * FROM ProveedorSubProceso WHERE idProveedor = '{$_POST['idProveedor']}'");
                                    while ($fila=mysqli_fetch_array($result)){
                                        echo "<tr>";
                                        $result1=mysqli_query($link,"SELECT * FROM SubProceso WHERE idProcedimiento = '{$fila['idProcedimiento']}'");
                                        while ($fila1=mysqli_fetch_array($result1)){
                                            echo "<td>{$fila1['descripcion']}</td>";
                                        }
                                        echo "<td>{$fila['costo']}</td>";
                                        echo "
                                              <td>
                                                  <form method='post' action='#'>
                                                        <div class='dropdown'>
                                                            <input type='hidden' name='idProveedor' value='{$_POST['idProveedor']}'>
                                                            <input type='hidden' name='idProcedimiento' value='{$fila['idProcedimiento']}'>
                                                            <input type='submit' class='btn btn-outline-primary' name='deleteProcedimiento' value='Eliminar'>
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
                                <button type="button" class="btn btn-outline-primary col-4 offset-4 mb-3" data-toggle="modal" data-target="#modalSubProceso">Agregar Sub Proceso</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="modal fade" id="modalMaterial" tabindex="-1" role="dialog" aria-labelledby="modalMaterial" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar Material que Provee</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form id="formMaterial" method="post" action="#">
                                <input type="hidden" name="idProveedor" value="<?php echo $_POST['idProveedor'];?>">
                                <div class="form-group row">
                                    <label class="col-form-label" for="material">Material:</label>
                                    <select name="material" id="material" class="form-control">
                                        <option disabled selected>Seleccionar</option>
                                        <?php
                                        $query = mysqli_query($link, "SELECT * FROM Material WHERE idEstado = 1 ORDER BY material ASC");
                                        while($row = mysqli_fetch_array($query)){
                                            echo "<option value='{$row['idMaterial']}'>{$row['material']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label" for="costo">Costo:</label>
                                    <input type="number" name="costo" id="costo" class="form-control">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button form="formMaterial" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button class="btn btn-primary" form="formMaterial" value="Submit" name="addMaterial">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalInsumo" tabindex="-1" role="dialog" aria-labelledby="modalInsumo" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar Insumo que Provee</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form id="formInsumo" method="post" action="#">
                                <input type="hidden" name="idProveedor" value="<?php echo $_POST['idProveedor'];?>">
                                <div class="form-group row">
                                    <label class="col-form-label" for="insumo">Insumo:</label>
                                    <select name="insumo" id="insumo" class="form-control">
                                        <option disabled selected>Seleccionar</option>
                                        <?php
                                        $query = mysqli_query($link, "SELECT * FROM Insumos WHERE idEstado = 1 ORDER BY descripcion ASC");
                                        while($row = mysqli_fetch_array($query)){
                                            echo "<option value='{$row['idInsumo']}'>{$row['descripcion']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label" for="costo">Costo:</label>
                                    <input type="number" name="costo" id="costo" class="form-control">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button form="formInsumo" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button class="btn btn-primary" form="formInsumo" value="Submit" name="addInsumo">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalSubProceso" tabindex="-1" role="dialog" aria-labelledby="modalSubProceso" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar SubProceso que Provee</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form id="formSubProceso" method="post" action="#">
                                <input type="hidden" name="idProveedor" value="<?php echo $_POST['idProveedor'];?>">
                                <div class="form-group row">
                                    <label class="col-form-label" for="subproceso">SubProceso:</label>
                                    <select name="subproceso" id="subproceso" class="form-control">
                                        <option disabled selected>Seleccionar</option>
                                        <?php
                                        $query = mysqli_query($link, "SELECT * FROM SubProceso WHERE idEstado = 1 ORDER BY descripcion ASC");
                                        while($row = mysqli_fetch_array($query)){
                                            echo "<option value='{$row['idProcedimiento']}'>{$row['descripcion']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label" for="costo">Costo:</label>
                                    <input type="number" name="costo" id="costo" class="form-control">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button form="formSubProceso" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button class="btn btn-primary" form="formSubProceso" value="Submit" name="addSubProceso">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }
    include('footer.php');
}
?>