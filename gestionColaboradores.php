<?php
include('session.php');
include('declaracionFechas.php');
include('funciones.php');
if(isset($_SESSION['login'])){
    include('header.php');
    include('navbarAdmin.php');

    if (isset($_POST['editar'])){

        $query = mysqli_query($link,"UPDATE Empleado SET idEmpleado = '{$_POST['dni']}', idTipoUsuario = '{$_POST['tipoUsuario']}', nombres = '{$_POST['nombres']}', apellidos = '{$_POST['apellidos']}', usuario = '{$_POST['usuario']}', contrasena = '{$_POST['contrasena']}' WHERE idEmpleado = '{$_POST['idEmpleado']}'");

        $queryPerformed1 = "UPDATE Empleado SET idEmpleado = {$_POST['idEmpleado']}, idTipoUsuario = {$_POST['tipoUsuario']}, nombres = {$_POST['nombres']}, apellidos = {$_POST['apellidos']}, usuario = {$_POST['usuario']}, contrasena = {$_POST['contrasena']} WHERE idEmpleado = {$_POST['idEmpleado']}";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','UPDATE','Colaborador','{$queryPerformed1}')");


    }

    if (isset($_POST['addColaborador'])){

        $query = mysqli_query($link, "INSERT INTO Empleado(idEmpleado, idTipoUsuario, idEstado, nombres, apellidos, usuario, contrasena)
                VALUES ('{$_POST['dni']}','{$_POST['tipoUsuario']}',1,'{$_POST['nombres']}','{$_POST['apellidos']}','{$_POST['usuario']}','{$_POST['contrasena']}')");

        $queryPerformed = "INSERT INTO Empleado(idEmpleado, idTipoUsuario, idEstado, nombres, apellidos, usuario, contrasena)
                VALUES ({$_POST['dni']},{$_POST['tipoUsuario']},1,{$_POST['nombres']},{$_POST['apellidos']},{$_POST['usuario']},{$_POST['contrasena']})";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','Colaborador','{$queryPerformed}')");


    }

    if (isset($_POST['desactivar'])){

        if ($_POST['estado']==1){

            $query = mysqli_query($link, "UPDATE Empleado SET idEstado = 2 WHERE idEmpleado = '{$_POST['idEmpleado']}'");

            $queryPerformed = "UPDATE Empleado SET idEstado = 2 WHERE idEmpleado = '{$_POST['idEmpleado']}'";

            $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','UPDATE','Desactivar Empleado','{$queryPerformed}')");


        }else{

            $query = mysqli_query($link, "UPDATE Empleado SET idEstado = 1 WHERE idEmpleado = '{$_POST['idEmpleado']}'");

            $queryPerformed = "UPDATE Empleado SET idEstado = 1 WHERE idEmpleado = '{$_POST['idEmpleado']}'";

            $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','UPDATE','Activar Empleado','{$queryPerformed}')");

        }

    }

    ?>

    <script>
        function myFunction() {
            // Declare variables
            var input, input2, input3, filter, filter2, filter3, table, tr, td, td2, td3, i;
            input = document.getElementById("dni");
            input2 = document.getElementById("nombre");
            input3 = document.getElementById("estado");
            filter = input.value.toUpperCase();
            filter2 = input2.value.toUpperCase();
            filter3 = input3.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                td2 = tr[i].getElementsByTagName("td")[1];
                td3 = tr[i].getElementsByTagName("td")[5];
                if ((td)&&(td2)) {
                    if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        if(td2.innerHTML.toUpperCase().indexOf(filter2) > -1){
                            if(td3.innerHTML.toUpperCase().indexOf(filter3) > -1){
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
                Listado de Colaboradores
                <div class="float-right">
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Acciones
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <form method="post">
                                <input class="dropdown-item" type="submit" name="nuevoColaborador" formaction="nuevoColaborador.php" value="Registrar Nuevo Colaborador">
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
                                <label class="sr-only" for="dni">DNI</label>
                                <input type="number" class="form-control mt-2 mb-2 mr-2" id="dni" placeholder="dni" onkeyup="myFunction()">
                                <label class="sr-only" for="nombre">Nombre</label>
                                <input type="text" class="form-control mt-2 mb-2 mr-2" id="nombre" placeholder="nombre" onkeyup="myFunction()">
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
                                <th class="text-center">DNI</th>
                                <th class="text-center" style="width: 25%">Nombre</th>
                                <th class="text-center">Usuario</th>
                                <th class="text-center">Contraseña</th>
                                <th class="text-center">Tipo</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $restult = mysqli_query($link, "SELECT * FROM Empleado ORDER BY idEstado, apellidos ASC");
                            while ($fila = mysqli_fetch_array($restult)){
                                echo "<tr>";
                                echo "<td>{$fila['idEmpleado']}</td>";
                                echo "<td>{$fila['nombres']} {$fila['apellidos']}</td>";
                                echo "<td>{$fila['usuario']}</td>";
                                echo "<td>{$fila['contrasena']}</td>";
                                $restult1 = mysqli_query($link, "SELECT * FROM TipoUsuario WHERE idTipoUsuario = '{$fila['idTipoUsuario']}'");
                                while ($fila1 = mysqli_fetch_array($restult1)){
                                    echo "<td>{$fila1['descripcion']}</td>";
                                }
                                $restult1 = mysqli_query($link, "SELECT * FROM Estado WHERE idEstado = '{$fila['idEstado']}'");
                                while ($fila1 = mysqli_fetch_array($restult1)){
                                    $descripcion = $fila1['descripcion'];
                                    echo "<td>{$fila1['descripcion']}</td>";
                                }
                                echo "
                                    <td>
                                        <form method='post'>
                                        <input type='hidden' name='idEmpleado' value=".$fila['idEmpleado'].">
                                        <input type='hidden' name='estado' value=".$fila['idEstado'].">
                                            <div class='dropdown'>
                                                <button class='btn btn-outline-primary btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                Acciones
                                                </button>
                                                <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                                    <button name='editar' class='dropdown-item' type='submit' formaction='editarColaborador.php'>Editar</button>
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
