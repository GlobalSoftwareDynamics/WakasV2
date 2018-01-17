<?php
include('session.php');
include('declaracionFechas.php');
include('funciones.php');
if(isset($_SESSION['login'])){
    include('header.php');
    include('navbarAdmin.php');

    if (isset($_POST['addCiudad'])){

        $query = mysqli_query($link, "INSERT INTO Ciudad(idPais, nombre) VALUES ('{$_POST['idPais']}','{$_POST['nombreCiudad']}')");

        $queryPerformed = "INSERT INTO Ciudad(idPais, nombre) VALUES ({$_POST['idPais']},{$_POST['nombreCiudad']})";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','Ciudad','{$queryPerformed}')");

    }

    if (isset($_POST['deleteCiudad'])){

        $query = mysqli_query($link, "DELETE FROM Ciudad WHERE idCiudad = '{$_POST['idCiudad']}'");

        $queryPerformed = "DELETE FROM Ciudad WHERE idCiudad = {$_POST['idCiudad']}";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','DELETE','Ciudad','{$queryPerformed}')");

    }


    $result = mysqli_query($link,"SELECT * FROM Pais WHERE idPais = '{$_POST['idPais']}'");
    while($row = mysqli_fetch_array($result)) {

        ?>

        <section class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-inverse card-info">
                            <div class="float-left">
                                <i class="fa fa-building"></i>
                                Editar País
                            </div>
                            <div class="float-right">
                                <div class="dropdown">
                                    <button form="form" name='volver' class='btn btn-light btn-sm'>Volver</button>
                                    <button form="form" name='editar' class='btn btn-light btn-sm'>Guardar</button>
                                </div>
                            </div>
                        </div>
                        <form method="post" action="gestionPaises.php" id="form">
                            <input type="hidden" name="idPais" value="<?php echo $_POST['idPais'];?>">
                            <div class="card-block">
                                <div class="col-12">
                                    <div class="spacer15"></div>
                                    <div class="form-group row">
                                        <label for="nombre" class="col-2 col-form-label">País:</label>
                                        <div class="col-10">
                                            <input class="form-control" type="text" id="nombre" name="nombre" value="<?php echo $row['pais'];?>">
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
                                <i class="fa fa-home"></i>
                                Listado de Ciudades
                            </div>
                            <div class="float-right">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-light btn-sm" data-toggle="modal" data-target="#modalCiudad">Agregar Ciudad</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="col-12">
                                <table class="table text-center">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Ciudad</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $result=mysqli_query($link,"SELECT * FROM Ciudad WHERE idPais = '{$_POST['idPais']}'");
                                    while ($fila=mysqli_fetch_array($result)){
                                        echo "<tr>";
                                        echo "<td>{$fila['nombre']}</td>";
                                        echo "
                                              <td>
                                                  <form method='post' action='#'>
                                                        <div class='dropdown'>
                                                            <input type='hidden' name='idPais' value='{$_POST['idPais']}'>
                                                            <input type='hidden' name='idCiudad' value='{$fila['idCiudad']}'>
                                                            <input type='submit' class='btn btn-outline-primary' name='deleteCiudad' value='Eliminar'>
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
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="modal fade" id="modalCiudad" tabindex="-1" role="dialog" aria-labelledby="modalCiudad" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar Ciudad</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form id="formMaquina" method="post" action="#">
                                <input type="hidden" name="idPais" value="<?php echo $_POST['idPais'];?>">
                                <div class="form-group row">
                                    <label class="col-form-label" for="nombreCiudad">Ciudad:</label>
                                    <input type="text" name="nombreCiudad" id="nombreCiudad" class="form-control">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button form="formMaquina" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button class="btn btn-primary" form="formMaquina" value="Submit" name="addCiudad">Guardar</button>
                    </div>
                </div>
            </div>
        </div>


        <?php
    }
    include('footer.php');
}
?>
