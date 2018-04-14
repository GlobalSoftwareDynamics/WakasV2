<?php
include('session.php');
include('declaracionFechas.php');
include('funciones.php');
if(isset($_SESSION['login'])){
    include('header.php');
    include('navbarAdmin.php');

    if (isset($_POST['desactivar'])){

        if ($_POST['estado']==1){

            $query = mysqli_query($link, "UPDATE Cliente SET idEstado = 2 WHERE idCliente = '{$_POST['idCliente']}'");

            $queryPerformed = "UPDATE Cliente SET idEstado = 2 WHERE idCliente = '{$_POST['idCliente']}'";

            $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','UPDATE','Desactivar Cliente','{$queryPerformed}')");


        }else{

            $query = mysqli_query($link, "UPDATE Cliente SET idEstado = 1 WHERE idCliente = '{$_POST['idCliente']}'");

            $queryPerformed = "UPDATE Cliente SET idEstado = 1 WHERE idCliente = '{$_POST['idCliente']}'";

            $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','UPDATE','Activar Cliente','{$queryPerformed}')");

        }

    }

    if(isset($_POST['addCliente'])){

        if ($_POST['nombreNuevoCliente']!=""){

            $insert = mysqli_query($link,"INSERT INTO Cliente (idCliente, idEstado, nombre) VALUES ('{$_POST['ruc']}',1,'{$_POST['nombreNuevoCliente']}')");
            if($insert){
            }else{
                echo 'Error ingresando datos a la base de datos';
            }

            $queryPerformed = "INSERT INTO Cliente (idCliente, idEstado, nombre) VALUES ({{$_POST['ruc']}},1,{$_POST['nombreNuevoCliente']})";

            $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','NuevaCV-ConfirmacionVenta','{$queryPerformed}')");

            /*Creacion de Direccion*/
            $query = mysqli_query($link, "INSERT INTO Direccion(idCiudad, direccion) VALUES ('{$_POST['ciudad']}','{$_POST['direccion']}')");

            $queryPerformed = "INSERT INTO Direccion(idCiudad, direccion) VALUES ({$_POST['ciudad']},{$_POST['direccion']})";

            $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','Direccion','{$queryPerformed}')");

            $direccion = mysqli_query($link, "SELECT * FROM Direccion WHERE direccion = '{$_POST['direccion']}'");
            while ($fila = mysqli_fetch_array($direccion)) {
                $idDireccion = $fila['idDireccion'];
            }

            /*Creacion de Contacto*/
            $query = mysqli_query($link, "INSERT INTO Contacto(idContacto, idCliente, idDireccion, idEstado, nombreCompleto, email, tipo)
                VALUES ('{$_POST['ruc']}','{$_POST['ruc']}','{$idDireccion}',1,'{$_POST['nombreNuevoCliente']}','{$_POST['email']}',1)");

            $queryPerformed = "INSERT INTO Contacto(idContacto, idCliente, idDireccion, idEstado, nombreCompleto, email, tipo)
                VALUES ('{$_POST['ruc']}',{$_POST['ruc']},{$idDireccion},1,{$_POST['nombreNuevoCliente']},{$_POST['email']},1)";

            $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','Contacto','{$queryPerformed}')");

            /*Creacion de Telefono*/
            if($_POST['telefono'] !== null || $_POST['telefono'] !== ""){

                $query = mysqli_query($link,"INSERT INTO Telefono(numero) VALUES ('{$_POST['telefono']}')");

                $queryPerformed = "INSERT INTO Telefono(numero) VALUES ({$_POST['telefono']})";

                $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','Telefono','{$queryPerformed}')");

                $telefono = mysqli_query($link, "SELECT * FROM Telefono WHERE numero = '{$_POST['telefono']}'");
                while ($fila = mysqli_fetch_array($telefono)) {
                    $idTelefono = $fila['idTelefono'];
                }

                $query = mysqli_query($link,"INSERT INTO ContactoTelefono(idContacto, idTelefono) VALUES ('{$_POST['ruc']}','{$idTelefono}')");

                $queryPerformed = "INSERT INTO ContactoTelefono(idContacto, idTelefono) VALUES ({$_POST['ruc']},{$idTelefono})";

                $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','ContactoTelefono','{$queryPerformed}')");

            }

        }else{
        }

    }

    if (isset($_POST['editar'])){

        $query = mysqli_query($link,"UPDATE Cliente SET nombre = '{$_POST['nombre']}' WHERE idCliente = '{$_POST['idCliente']}'");

        $queryPerformed = "UPDATE Cliente SET nombre = {$_POST['nombre']} WHERE idCliente = {$_POST['idCliente']}";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','UPDATE','Cliente','{$queryPerformed}')");

        $query = mysqli_query($link,"UPDATE Contacto SET nombreCompleto = '{$_POST['nombre']}', email = '{$_POST['email']}' WHERE idContacto = '{$_POST['idCliente']}'");
        $query = mysqli_query($link,"UPDATE Direccion SET direccion = '{$_POST['direccion']}', idCiudad = '{$_POST['ciudad']}' WHERE idDireccion = '{$_POST['idCliente']}'");

        $queryPerformed1 = "UPDATE Contacto SET nombreCompleto = {$_POST['nombre']}, email = {$_POST['email']} WHERE idContacto = {$_POST['idCliente']}";
        $queryPerformed2 = "UPDATE Direccion SET direccion = {$_POST['direccion']}, idCiudad = {$_POST['ciudad']} WHERE idDireccion = {$_POST['idCliente']}";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','UPDATE','Contacto','{$queryPerformed1}')");
        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','UPDATE','Direccion','{$queryPerformed2}')");

    }

    ?>

    <script>
        function myFunction() {
            // Declare variables
            var input, input2, filter, filter2, table, tr, td, td2, i;
            input = document.getElementById("nombre");
            input2 = document.getElementById("estado");
            filter = input.value.toUpperCase();
            filter2 = input2.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                td2 = tr[i].getElementsByTagName("td")[1];
                if ((td)&&(td2)) {
                    if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        if(td2.innerHTML.toUpperCase().indexOf(filter2) > -1){
                            tr[i].style.display = "";
                        }else{
                            tr[i].style.display = "none";
                        }
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>

    <section class="container">
        <div class="card">
            <div class="card-header card-inverse card-info">
                <i class="fa fa-list"></i>
                Listado de Clientes
                <div class="float-right">
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Acciones
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" data-toggle="modal" data-target="#modalCliente" style="font-size: 14px;">Registrar Nuevo Cliente</a>
                            <a class="dropdown-item" href="gestionPaises.php" style="font-size: 14px;">Gestionar Paises y Ciudades</a>
                        </div>
                    </div>
                </div>
                <span class="float-right">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                <span class="float-right">
                    <button href="#collapsed" class="btn btn-light btn-sm" data-toggle="collapse">Mostrar Filtros</button>
                </span>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="col-12">
                        <div id="collapsed" class="collapse">
                            <form class="form-inline justify-content-center" method="post" action="#">
                                <label class="sr-only" for="nombre">Nombre</label>
                                <input type="text" class="form-control mt-2 mb-2 mr-2" id="nombre" placeholder="Nombre" onkeyup="myFunction()">
                                <label class="sr-only" for="estado">Estado</label>
                                <input type="text" class="form-control mt-2 mb-2 mr-2" id="estado" placeholder="Estado" onkeyup="myFunction()">
                                <input type="submit" class="btn btn-primary" value="Limpiar" style="padding-left:28px; padding-right: 28px;">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="spacer10"></div>
                <div class="row">
                    <div class="col-12">
                        <table class="table table-bordered text-center" id="myTable">
                            <thead class="thead-default">
                            <tr>
                                <th class="text-center" style="width: 40%">Nombre</th>
                                <th class="text-center" style="width: 40%">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $restult = mysqli_query($link, "SELECT * FROM Cliente ORDER BY idEstado ASC, nombre ASC");
                            while ($fila = mysqli_fetch_array($restult)){
                                echo "<tr>";
                                echo "<td>{$fila['nombre']}</td>";
                                $restult1 = mysqli_query($link, "SELECT * FROM Estado WHERE idEstado = '{$fila['idEstado']}'");
                                while ($fila1 = mysqli_fetch_array($restult1)){
                                    $descripcion = $fila1['descripcion'];
                                    echo "<td>{$fila1['descripcion']}</td>";
                                }
                                echo "
                                    <td>
                                        <form method='post'>
                                        <input type='hidden' name='idCliente' value=".$fila['idCliente'].">
                                        <input type='hidden' name='estado' value=".$fila['idEstado'].">
                                            <div class='dropdown'>
                                                <button class='btn btn-outline-primary btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                Acciones
                                                </button>
                                                <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                                    <button name='verCliente' class='dropdown-item' type='submit' formaction='detalleCliente.php'>Ver Ficha de Cliente</button>
                                                    <button name='contactos' class='dropdown-item' type='submit' formaction='gestionContactos.php'>Gestionar Contactos</button>
                                                    <button name='editar' class='dropdown-item' type='submit' formaction='editarCliente.php'>Editar</button>
                                                    <button name='desactivar' class='dropdown-item' type='submit' formaction='#'>Desactivar/Activar</button>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                ";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="modalCliente" tabindex="-1" role="dialog" aria-labelledby="modalCliente" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form id="formCliente" method="post" action="#">
                            <div class="form-group row">
                                <label class="col-form-label" for="ruc">DNI/RUC:</label>
                                <input type="text" name="ruc" id="ruc" class="form-control">
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label" for="nombreNuevoCliente">Nombre de Cliente:</label>
                                <input type="text" name="nombreNuevoCliente" id="nombreNuevoCliente" class="form-control">
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
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" form="formCliente" value="Submit" name="addCliente">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <?php
    include('footer.php');
}
?>
