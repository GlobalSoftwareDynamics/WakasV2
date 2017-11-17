<?php
include('session.php');
include('declaracionFechas.php');
include('funciones.php');
if(isset($_SESSION['login'])){
    include('header.php');
    include('navbarAdmin.php');

    if(isset($_POST['addTelefono'])){

        $telefono=mysqli_query($link,"INSERT INTO Telefono(numero) VALUES ('{$_POST['telefono']}')");
        $queryPerformed = "INSERT INTO Telefono(numero) VALUES ('{$_POST['telefono']}')";
        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idColaborador,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','Telefono','{$queryPerformed}')");

        $aux1=0;
        $numrowtelefono=mysqli_query($link,"SELECT * FROM Telefono WHERE numero = '{$_POST['telefono']}'");
        while ($row=mysqli_fetch_array($numrowtelefono)){
            $idTelefono = $row['idTelefono'];
        }

        $telefono=mysqli_query($link,"INSERT INTO ContactoTelefono VALUES ('{$_POST['idContacto']}','{$idTelefono}')");
        $queryPerformed = "INSERT INTO ContactoTelefono VALUES ({$_POST['idContacto']},{$idTelefono})";
        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idColaborador,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','ProveedorTelefono','{$queryPerformed}')");

    }

    if(isset($_POST['deleteTelefono'])){

        $query=mysqli_query($link,"DELETE FROM ContactoTelefono WHERE idContacto = '{$_POST['idContacto']}' AND idTelefono = '{$_POST['telefono']}'");
        $queryPerformed = "DELETE FROM ContactoTelefono WHERE idContacto = {$_POST['idContacto']} AND idTelefono = {$_POST['telefono']}";
        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idColaborador,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','DELETE','ProveedorTelefono','{$queryPerformed}')");

    }

    $result = mysqli_query($link,"SELECT * FROM Contacto WHERE idContacto = '{$_POST['idContacto']}'");
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
                                <i class="fa fa-user"></i>
                                Editar Contacto
                            </div>
                            <div class="float-right">
                                <div class="dropdown">
                                    <button form="form" name='volver' class='btn btn-light btn-sm'>Volver</button>
                                    <button form="form" name='editar' class='btn btn-light btn-sm'>Guardar</button>
                                </div>
                            </div>
                        </div>
                        <form method="post" action="gestionContactos.php" id="form">
                            <input type="hidden" name="idCliente" value="<?php echo $_POST['idCliente'];?>">
                            <input type="hidden" name="idContacto" value="<?php echo $_POST['idContacto'];?>">
                            <input type="hidden" name="idDireccion" value="<?php echo $idDireccion;?>">
                            <div class="card-block">
                                <div class="col-12">
                                    <div class="spacer15"></div>
                                    <div class="form-group row">
                                        <label for="nombre" class="col-2 col-form-label">Nombre:</label>
                                        <div class="col-10">
                                            <input class="form-control" type="text" id="nombre" name="nombre" value="<?php echo $row['nombreCompleto'];?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="email" class="col-2 col-form-label">Correo Electrónico:</label>
                                        <div class="col-10">
                                            <input class="form-control" type="text" id="email" name="email" value="<?php echo $row['email'];?>">
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
                                <i class="fa fa-phone"></i>
                                Agenda Telefónica
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="col-12">
                                <table class="table text-center">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Teléfono</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $result=mysqli_query($link,"SELECT * FROM ContactoTelefono WHERE idContacto = '{$_POST['idContacto']}'");
                                    while ($fila=mysqli_fetch_array($result)){
                                        echo "<tr>";
                                        $result1=mysqli_query($link,"SELECT * FROM Telefono WHERE idTelefono = '{$fila['idTelefono']}'");
                                        while ($fila1=mysqli_fetch_array($result1)){
                                            echo "<td>{$fila1['numero']}</td>";
                                            echo "
                                                <td class='text-center'>
                                                    <form method='post'>
                                                        <div class='dropdown'>
                                                            <input type='hidden' name='idContacto' value='{$_POST['idContacto']}'>
                                                            <input type='hidden' name='idCliente' value='{$_POST['idCliente']}'>
                                                            <input type='hidden' name='telefono' value='{$fila['idTelefono']}'>
                                                            <input type='submit' class='btn btn-outline-primary' name='deleteTelefono' value='Eliminar'>
                                                        </div>
                                                    </form>
                                                </td>
                                            ";
                                        }
                                        echo "</tr>";
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-12">
                                <button type="button" class="btn btn-outline-primary col-4 offset-4 mb-3" data-toggle="modal" data-target="#modalTelefono">Agregar Teléfono</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="modal fade" id="modalTelefono" tabindex="-1" role="dialog" aria-labelledby="modalTelefono" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar Teléfono</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form id="formTelefono" method="post" action="#">
                                <input type="hidden" value="<?php echo $_POST['idContacto']?>" name="idContacto">
                                <input type="hidden" name="idCliente" value="<?php echo $_POST['idCliente']?>">
                                <div class="form-group row">
                                    <label class="col-form-label" for="telefono">Número de Teléfono:</label>
                                    <input type="text" name="telefono" id="telefono" class="form-control">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" form="formTelefono" value="Submit" name="addTelefono">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }
    include('footer.php');
}
?>
