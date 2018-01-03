<?php
include('session.php');
include('declaracionFechas.php');
include('funciones.php');
if(isset($_SESSION['login'])){
    include('header.php');
    include('navbarAdmin.php');

    if (isset($_POST['editar'])){

        $query = mysqli_query($link,"UPDATE Insumos SET descripcion = '{$_POST['nombreInsumo']}', tipoInsumo = '{$_POST['tipoInsumo']}', idUnidadMedida = '{$_POST['unidadMedida']}' WHERE idInsumo = '{$_POST['idInsumo']}'");

        $queryPerformed1 = "UPDATE Insumos SET descripcion = {$_POST['nombreInsumo']}, tipoInsumo = {$_POST['tipoInsumo']}, idUnidadMedida = {$_POST['unidadMedida']} WHERE idInsumo = {$_POST['idInsumo']}";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','UPDATE','Insumos','{$queryPerformed1}')");


    }

    if (isset($_POST['addInsumo'])){

        $query = mysqli_query($link, "INSERT INTO Insumos(idUnidadMedida, idEstado, descripcion, tipoInsumo)
                VALUES ('{$_POST['unidadMedida']}',1,'{$_POST['nombreInsumo']}','{$_POST['tipoInsumo']}')");

        $queryPerformed = "INSERT INTO Insumos(idUnidadMedida, idEstado, descripcion, tipoInsumo)
                VALUES ({$_POST['unidadMedida']},1,{$_POST['nombreInsumo']},{$_POST['tipoInsumo']})";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','Insumo','{$queryPerformed}')");

        if($_POST['tipoInsumo'] == 1){

            $query = mysqli_query($link, "INSERT INTO SubProceso(idProceso, idEstado, descripcion, tipo)
                VALUES (4,1,'Acondicionamiento - {$_POST['nombreInsumo']}',2)");

            $queryPerformed = "INSERT INTO SubProceso(idProceso, idEstado, descripcion, tipo)
                VALUES (4,1,Acondicionamiento - {$_POST['nombreInsumo']},2)";

            $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','SubProceso','{$queryPerformed}')");

        }

    }

    if (isset($_POST['desactivar'])){

        if ($_POST['estado']==1){

            $query = mysqli_query($link, "UPDATE Insumos SET idEstado = 2 WHERE idInsumo = '{$_POST['idInsumo']}'");

            $queryPerformed = "UPDATE Insumos SET idEstado = 2 WHERE idInsumo = '{$_POST['idInsumo']}'";

            $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','UPDATE','Desactivar Insumo','{$queryPerformed}')");


        }else{

            $query = mysqli_query($link, "UPDATE Insumos SET idEstado = 1 WHERE idInsumo = '{$_POST['idInsumo']}'");

            $queryPerformed = "UPDATE Insumos SET idEstado = 1 WHERE idInsumo = '{$_POST['idInsumo']}'";

            $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','UPDATE','Activar Insumo','{$queryPerformed}')");

        }

    }

    ?>

    <script>
        function myFunction() {
            // Declare variables
            var input, input2, input3, filter, filter2, filter3, table, tr, td, td2, td3, i;
            input = document.getElementById("material");
            input2 = document.getElementById("unidad");
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
                Listado de Insumos
                <div class="float-right">
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Acciones
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <form method="post">
                                <input class="dropdown-item" type="submit" name="nuevoInsumo" formaction="nuevoInsumo.php" value="Registrar Nuevo Insumo">
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
                                <label class="sr-only" for="material">Insumo</label>
                                <input type="text" class="form-control mt-2 mb-2 mr-2" id="material" placeholder="Insumo" onkeyup="myFunction()">
                                <label class="sr-only" for="unidad">Unidad</label>
                                <input type="text" class="form-control mt-2 mb-2 mr-2" id="unidad" placeholder="Unidad" onkeyup="myFunction()">
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
                                <th class="text-center">Insumo</th>
                                <th class="text-center">Unidad</th>
                                <th class="text-center">Uso</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $restult = mysqli_query($link, "SELECT * FROM Insumos ORDER BY idEstado ASC, descripcion ASC");
                            while ($fila = mysqli_fetch_array($restult)){
                                echo "<tr>";
                                echo "<td>{$fila['descripcion']}</td>";
                                echo "<td>{$fila['idUnidadMedida']}</td>";
                                switch ($fila['tipoInsumo']){
                                    case 0:
                                        $uso = "Lavado";
                                        break;
                                    case 1:
                                        $uso = "Acondicionamiento";
                                        break;
                                }
                                echo "<td>{$uso}</td>";
                                $restult1 = mysqli_query($link, "SELECT * FROM Estado WHERE idEstado = '{$fila['idEstado']}'");
                                while ($fila1 = mysqli_fetch_array($restult1)){
                                    $descripcion = $fila1['descripcion'];
                                    echo "<td>{$fila1['descripcion']}</td>";
                                }
                                echo "
                                    <td>
                                        <form method='post'>
                                        <input type='hidden' name='idInsumo' value=".$fila['idInsumo'].">
                                        <input type='hidden' name='estado' value=".$fila['idEstado'].">
                                            <div class='dropdown'>
                                                <button class='btn btn-outline-primary btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                Acciones
                                                </button>
                                                <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                                    <button name='verProveedor' class='dropdown-item' type='submit' formaction='detalleInsumo.php'>Ver Proveedores</button>
                                                    <button name='editar' class='dropdown-item' type='submit' formaction='editarInsumo.php'>Editar</button>
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
