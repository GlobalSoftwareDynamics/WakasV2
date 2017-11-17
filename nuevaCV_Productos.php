<?php
include('session.php');
include('declaracionFechas.php');
include ('funciones.php');
if(isset($_SESSION['login'])){

    if(isset($_POST['addCV'])){
        $flag = true;
        /*Verificacion de idContrato*/
        $search = mysqli_query($link,"SELECT * FROM ConfirmacionVenta WHERE idContrato = '{$_POST['idConfirmacionVenta']}'");
        while($index = mysqli_fetch_array($search)){
            $flag = false;
        }

        if ($flag) {
            /*Creacion de Nuevo Contacto*/
            if (isset($_POST['nombreContacto'])) {
                $contacto = $_POST['nombreContacto'];
            } elseif (isset($_POST['dni'])) {
                $contacto = $_POST['dni'];

                $cliente = mysqli_query($link, "SELECT * FROM Cliente WHERE nombre LIKE '%{$_POST['cliente']}%'");
                while ($fila = mysqli_fetch_array($cliente)) {
                    $idCliente = $fila['idCliente'];
                }
                /*Creacion de Direccion*/
                $query = mysqli_query($link, "INSERT INTO Direccion(idCiudad, direccion) VALUES ('{$_POST['ciudad']}','{$_POST['direccion']}')");

                $queryPerformed = "INSERT INTO Direccion(idCiudad, direccion) VALUES ({$_POST['ciudad']},{$_POST['direccion']})";

                $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','Direccion','{$queryPerformed}')");

                $direccion = mysqli_query($link, "SELECT * FROM Direccion WHERE direccion = '{$_POST['direccion']}'");
                while ($fila = mysqli_fetch_array($direccion)) {
                    $idDireccion = $fila['idDireccion'];
                }
                /*Creacion de Contacto*/
                $query = mysqli_query($link, "INSERT INTO Contacto(idContacto, idCliente, idDireccion, idEstado, nombreCompleto, email)
                VALUES ('{$_POST['dni']}','{$idCliente}','{$idDireccion}',1,'{$_POST['nombres']}','{$_POST['email']}')");

                $queryPerformed = "INSERT INTO Contacto(idContacto, idCliente, idDireccion, idEstado, nombreCompleto, email)
                VALUES ({$_POST['dni']},{$idCliente},{$idDireccion},1,{$_POST['nombres']},{$_POST['email']})";

                $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','Contacto','{$queryPerformed}')");
                /*Creacion de Telefono*/
                $query = mysqli_query($link,"INSERT INTO Telefono(numero) VALUES ('{$_POST['telefono']}')");

                $queryPerformed = "INSERT INTO Telefono(numero) VALUES ({$_POST['telefono']})";

                $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','Telefono','{$queryPerformed}')");

                $telefono = mysqli_query($link, "SELECT * FROM Telefono WHERE numero = '{$_POST['telefono']}'");
                while ($fila = mysqli_fetch_array($telefono)) {
                    $idTelefono = $fila['idTelefono'];
                }

                $query = mysqli_query($link,"INSERT INTO ContactoTelefono(idContacto, idTelefono) VALUES ('{$_POST['dni']}','{$idTelefono}')");

                $queryPerformed = "INSERT INTO ContactoTelefono(idContacto, idTelefono) VALUES ({$_POST['dni']},{$idTelefono})";

                $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','ContactoTelefono','{$queryPerformed}')");

            }

            $query = mysqli_query($link, "INSERT INTO ConfirmacionVenta(idContrato, idContacto, idIncoterm, idVia, idMetodoPago, idcodificacionTalla, idEstado, fecha, shipdate, reference)
            VALUES ('{$_POST['idConfirmacionVenta']}','{$contacto}','{$_POST['incoterm']}','{$_POST['via']}','{$_POST['metodoPago']}','{$_POST['codifTalla']}',3,'{$_POST['fechaContrato']}','{$_POST['fechaEnvio']}','{$_POST['idReferencia']}')");

            $queryPerformed = "INSERT INTO ConfirmacionVenta(idContrato, idContacto, idIncoterm, idVia, idMetodoPago, idcodificacionTalla, idEstado, fecha, shipdate, reference)
            VALUES ({$_POST['idConfirmacionVenta']},{$contacto},{$_POST['incoterm']},{$_POST['via']},{$_POST['metodoPago']},{$_POST['codifTalla']},3,{$_POST['fechaContrato']},{$_POST['fechaEnvio']},{$_POST['idReferencia']})";

            $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','Nueva ConfirmacionVenta','{$queryPerformed}')");

        }
    }

    include('header.php');
    include('navbarAdmin.php');

    if ($flag) {
        ?>

        <section class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-inverse card-info">
                            <div class="float-left mt-1">
                                <i class="fa fa-shopping-bag"></i>
                                &nbsp;&nbsp;Selección de Productos
                            </div>
                            <div class="float-right">
                                <div class="dropdown">
                                    <form method="post" action="">
                                        <input type="hidden" name="idConfirmacionVenta" value="<?php echo $_POST['idConfirmacionVenta']?>">
                                        <input name="siguiente" type="submit" class="btn btn-light btn-sm" value="Siguiente">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="col-12">
                                <div class="spacer20"></div>
                                <form method="post" action="#">
                                    <div class="form-group row">
                                        <label for="idProducto" class="col-2 col-form-label">Código de Producto:</label>
                                        <div class="col-10">
                                            <input class="form-control" type="text" id="idProducto" name="idProducto" onkeyup="getTallas(this.value,<?php echo $_POST['codifTalla']?>)" onchange="getTallas(this.value,<?php echo $_POST['codifTalla']?>)" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <table class="table text-center">
                                            <thead>
                                            <tr>
                                                <th style="width: 15%">Código Cliente</th>
                                                <th style="width: 20%">Material</th>
                                                <th style="width: 15%">Color</th>
                                                <?php
                                                $result = mysqli_query($link,"SELECT * FROM Talla WHERE idcodificacionTalla = '{$_POST['codifTalla']}'");
                                                while ($fila = mysqli_fetch_array($result)){
                                                    echo "<th>{$fila['descripcion']}</th>";
                                                }
                                                ?>
                                            </tr>
                                            </thead>
                                            <tbody id="row">
                                            <tr>
                                                <td>
                                                    <label for='code' class='sr-only'>Código del Cliente</label>
                                                    <input id="code" type="text" name="yourcode" class="form-control">
                                                </td>
                                                <td>

                                                </td>
                                                <td>

                                                </td>
                                                <?php
                                                $result = mysqli_query($link,"SELECT * FROM Talla WHERE idcodificacionTalla = '{$_POST['codifTalla']}'");
                                                while ($fila = mysqli_fetch_array($result)){
                                                    echo "
                                                        <td><input type='number' class='form-control' min='0'></td>
                                                    ";
                                                }
                                                ?>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php
    }else{
        ?>

        <form method="post" action="nuevaCV_DatosGenerales.php">
            <section class="container">
                <div class="row">
                    <div class="col-6 offset-3">
                        <div class="card">
                            <div class="card-header card-inverse card-info">
                                <div class="float-left mt-1">
                                    <i class="fa fa-warning"></i>
                                    &nbsp;&nbsp;Mensaje de Error
                                </div>
                                <div class="float-right">
                                    <div class="dropdown">
                                        <input name="volver" type="submit" class="btn btn-light btn-sm" formaction="nuevaCV_DatosGenerales.php" value="Volver">
                                    </div>
                                </div>
                            </div>
                            <div class="card-block">
                                <div class="col-12">
                                    <div class="spacer20"></div>
                                    <h6 class="text-center">Ha ocurrido un error en el ingreso de datos de la Confirmación de Venta debido a que el Código de Contrato ingresado se encuentra duplicado. Por favor revise la información nuevamente.</h6>
                                    <div class="spacer20"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </form>

        <?php
    }
    include('footer.php');
}
?>