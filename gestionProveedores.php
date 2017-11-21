<?php
include('session.php');
include('declaracionFechas.php');
include('funciones.php');
if(isset($_SESSION['login'])){
    include('header.php');
    include('navbarAdmin.php');

    if (isset($_POST['editar'])){

        $query = mysqli_query($link,"UPDATE Proveedor SET nombre = '{$_POST['nombreProveedor']}' WHERE idProveedor = '{$_POST['idProveedor']}'");
        $query = mysqli_query($link,"UPDATE Direccion SET direccion = '{$_POST['direccion']}', idCiudad = '{$_POST['ciudad']}' WHERE idDireccion = '{$_POST['idDireccion']}'");

        $queryPerformed1 = "UPDATE Proveedor SET nombre = {$_POST['nombreProveedor']} WHERE idProveedor = {$_POST['idProveedor']}";
        $queryPerformed2 = "UPDATE Direccion SET direccion = {$_POST['direccion']}, idCiudad = {$_POST['ciudad']} WHERE idDireccion = {$_POST['idDireccion']}";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','UPDATE','Proveedor','{$queryPerformed1}')");
        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','UPDATE','Direccion','{$queryPerformed2}')");


    }

    if (isset($_POST['addProveedor'])){

        $idProveedor = idgen("P");

        /*Creacion de Direccion*/
        $query = mysqli_query($link, "INSERT INTO Direccion(idCiudad, direccion) VALUES ('{$_POST['ciudad']}','{$_POST['direccion']}')");

        $queryPerformed = "INSERT INTO Direccion(idCiudad, direccion) VALUES ({$_POST['ciudad']},{$_POST['direccion']})";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','Direccion','{$queryPerformed}')");

        $direccion = mysqli_query($link, "SELECT * FROM Direccion WHERE direccion = '{$_POST['direccion']}'");
        while ($fila = mysqli_fetch_array($direccion)) {
            $idDireccion = $fila['idDireccion'];
        }

        /*Creacion de Proveedor*/
        $query = mysqli_query($link, "INSERT INTO Proveedor(idProveedor, idDireccion, idEstado, nombre)
                VALUES ('{$idProveedor}','{$idDireccion}',1,'{$_POST['nombreProveedor']}')");

        $queryPerformed = "INSERT INTO Proveedor(idProveedor, idDireccion, idEstado, nombre)
                VALUES ({$idProveedor},{$idDireccion},1,{$_POST['nombreProveedor']})";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','Proveedor','{$queryPerformed}')");


    }

    if (isset($_POST['desactivar'])){

        if ($_POST['estado']==1){

            $query = mysqli_query($link, "UPDATE Proveedor SET idEstado = 2 WHERE idProveedor = '{$_POST['idProveedor']}'");

            $queryPerformed = "UPDATE Cliente SET idEstado = 2 WHERE idProveedor = '{$_POST['idProveedor']}'";

            $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','UPDATE','Desactivar Proveedor','{$queryPerformed}')");


        }else{

            $query = mysqli_query($link, "UPDATE Proveedor SET idEstado = 1 WHERE idProveedor = '{$_POST['idProveedor']}'");

            $queryPerformed = "UPDATE Proveedor SET idEstado = 1 WHERE idProveedor = '{$_POST['idProveedor']}'";

            $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','UPDATE','Activar Proveedor','{$queryPerformed}')");

        }

    }

    ?>

    <script>
        function myFunction() {
            // Declare variables
            var input, input2, input3, filter, filter2, filter3, table, tr, td, td2, td3, i;
            input = document.getElementById("nombre");
            input2 = document.getElementById("ciudad");
            input3 = document.getElementById("estado");
            filter = input.value.toUpperCase();
            filter2 = input2.value.toUpperCase();
            filter3 = input3.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                td2 = tr[i].getElementsByTagName("td")[2];
                td3 = tr[i].getElementsByTagName("td")[3];
                if ((td)&&(td2)) {
                    if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        if(td2.innerHTML.toUpperCase().indexOf(filter2) > -1){
                            if(td3.innerHTML.toUpperCase().indexOf(filter3) > -1) {
                                tr[i].style.display = "";
                            }else{
                                tr[i].style.display = "none";
                            }
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
                Listado de Proveedores
                <div class="float-right">
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Acciones
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <form method="post">
                                <input class="dropdown-item" type="submit" name="nuevoProveedor" formaction="nuevoProveedor.php" value="Registrar Nuevo Proveedor">
                            </form>
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
                                <input type="hidden" name="idCliente" value="<?php echo $_POST['idCliente'];?>">
                                <label class="sr-only" for="nombre">Nombre</label>
                                <input type="text" class="form-control mt-2 mb-2 mr-2" id="nombre" placeholder="Nombre" onkeyup="myFunction()">
                                <label class="sr-only" for="ciudad">Ciudad</label>
                                <select class="form-control mt-2 mb-2 mr-2" id="ciudad" onchange="myFunction()">
                                    <option disabled selected value="a">Ciudad</option>
                                    <?php
                                    $query = mysqli_query($link, "SELECT * FROM Ciudad ORDER BY nombre ASC");
                                    while($row = mysqli_fetch_array($query)){
                                        echo "<option value='{$row['nombre']}'>{$row['nombre']}</option>";
                                    }
                                    ?>
                                </select>
                                <label class="sr-only" for="estado">Estado</label>
                                <select class="form-control mt-2 mb-2 mr-2" id="estado" onchange="myFunction()">
                                    <option disabled selected value="a">Estado</option>
                                    <?php
                                    $query = mysqli_query($link, "SELECT * FROM Estado");
                                    while($row = mysqli_fetch_array($query)){
                                        echo "<option value='{$row['descripcion']}'>{$row['descripcion']}</option>";
                                    }
                                    ?>
                                </select>
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
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Dirección</th>
                                <th class="text-center">Ciudad</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $restult = mysqli_query($link, "SELECT * FROM Proveedor ORDER BY idEstado ASC");
                            while ($fila = mysqli_fetch_array($restult)){
                                echo "<tr>";
                                echo "<td>{$fila['nombre']}</td>";
                                $restult1 = mysqli_query($link, "SELECT * FROM Direccion WHERE idDireccion = '{$fila['idDireccion']}'");
                                while ($fila1 = mysqli_fetch_array($restult1)){
                                    echo "<td>{$fila1['direccion']}</td>";
                                    $restult2 = mysqli_query($link, "SELECT * FROM Ciudad WHERE idCiudad = '{$fila1['idCiudad']}'");
                                    while ($fila2 = mysqli_fetch_array($restult2)){
                                        echo "<td>{$fila2['nombre']}</td>";
                                    }
                                }
                                $restult1 = mysqli_query($link, "SELECT * FROM Estado WHERE idEstado = '{$fila['idEstado']}'");
                                while ($fila1 = mysqli_fetch_array($restult1)){
                                    $descripcion = $fila1['descripcion'];
                                    echo "<td>{$fila1['descripcion']}</td>";
                                }
                                echo "
                                    <td>
                                        <form method='post'>
                                        <input type='hidden' name='idProveedor' value=".$fila['idProveedor'].">
                                        <input type='hidden' name='estado' value=".$fila['idEstado'].">
                                            <div class='dropdown'>
                                                <button class='btn btn-outline-primary btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                Acciones
                                                </button>
                                                <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                                    <button name='verProveedor' class='dropdown-item' type='submit' formaction='detalleProveedor.php'>Ver Ficha de Proveedor</button>
                                                    <button name='editar' class='dropdown-item' type='submit' formaction='editarProveedor.php'>Editar</button>
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

    <?php
    include('footer.php');
}
?>
