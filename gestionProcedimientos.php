<?php
include('session.php');
include('declaracionFechas.php');
include('funciones.php');
if(isset($_SESSION['login'])){
    include('header.php');
    include('navbarAdmin.php');

    if (isset($_POST['editar'])){

        $query = mysqli_query($link,"UPDATE SubProceso SET descripcion = '{$_POST['subproceso']}', tipo = '{$_POST['tipo']}' WHERE idProcedimiento = '{$_POST['idProcedimiento']}'");

        $queryPerformed1 = "UPDATE SubProceso SET descripcion = {$_POST['subproceso']}, tipo = {$_POST['tipo']} WHERE idProcedimiento = {$_POST['idProcedimiento']}";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','UPDATE','SubProceso','{$queryPerformed1}')");

    }

    if (isset($_POST['addProcedimiento'])){

        $query = mysqli_query($link, "INSERT INTO SubProceso(idProceso, idEstado, descripcion, tipo) VALUES ('{$_POST['idProceso']}',1,'{$_POST['subproceso']}','{$_POST['tipo']}')");

        $queryPerformed = "INSERT INTO SubProceso(idProceso, idEstado, descripcion, tipo) VALUES ({$_POST['idProceso']},1,{$_POST['subproceso']},{$_POST['tipo']})";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','SubProceso','{$queryPerformed}')");

        $result = mysqli_query($link, "SELECT * FROM SubProceso WHERE descripcion = '{$_POST['subproceso']}'");
        while ($fila = mysqli_fetch_array($result)){

            $idProcedimiento = $fila['idProcedimiento'];

        }

        $query = mysqli_query($link,"INSERT INTO SubProcesoCaracteristica(idProcedimiento, idCaracteristica) VALUES ('{$idProcedimiento}',1)");

        $queryPerformed = "INSERT INTO SubProcesoCaracteristica(idProcedimiento, idCaracteristica) VALUES ({$idProcedimiento},1)";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','SubProcesoCaracteristica - Componente','{$queryPerformed}')");

        $query = mysqli_query($link,"INSERT INTO SubProcesoCaracteristica(idProcedimiento, idCaracteristica) VALUES ('{$idProcedimiento}',7)");

        $queryPerformed = "INSERT INTO SubProcesoCaracteristica(idProcedimiento, idCaracteristica) VALUES ({$idProcedimiento},7)";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','SubProcesoCaracteristica - Tiempo','{$queryPerformed}')");

    }

    if (isset($_POST['desactivar'])){

        if ($_POST['estado']==1){

            $query = mysqli_query($link, "UPDATE SubProceso SET idEstado = 2 WHERE idProcedimiento = '{$_POST['idProcedimiento']}'");

            $queryPerformed = "UPDATE SubProceso SET idEstado = 2 WHERE idProcedimiento = '{$_POST['idProcedimiento']}'";

            $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','UPDATE','Desactivar SubProceso','{$queryPerformed}')");

        }else{

            $query = mysqli_query($link, "UPDATE SubProceso SET idEstado = 1 WHERE idProcedimiento = '{$_POST['idProcedimiento']}'");

            $queryPerformed = "UPDATE SubProceso SET idEstado = 1 WHERE idProcedimiento = '{$_POST['idProcedimiento']}'";

            $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','UPDATE','Activar SubProceso','{$queryPerformed}')");

        }

    }

    $result = mysqli_query($link,"SELECT * FROM Proceso WHERE idProceso = '{$_POST['idProceso']}'");
    while ($fila = mysqli_fetch_array($result)){

        $nombreProceso = $fila['descripcion'];

    }

    ?>

    <script>
        function myFunction() {
            // Declare variables
            var input, input2, input3, filter, filter2, filter3, table, tr, td, td2, td3, i;
            input = document.getElementById("material");
            input2 = document.getElementById("estado");
            filter = input.value.toUpperCase();
            filter2 = input2.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                td2 = tr[i].getElementsByTagName("td")[2];
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
                Listado de Procedimientos de <?php echo $nombreProceso;?>
                <div class="float-right">
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Acciones
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <form method="post">
                                <a class="dropdown-item" data-toggle="modal" data-target="#modalProcedimiento" style="font-size: 14px;">Registrar Nuevo Procedimiento</a>
                                <a class="dropdown-item" href="gestionProcesos.php" style="font-size: 14px;">Regresar</a>
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
                                <label class="sr-only" for="material">Procedimiento</label>
                                <input type="text" class="form-control mt-2 mb-2 mr-2" id="material" placeholder="Proceso" onkeyup="myFunction()">
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
                                <th class="text-center">Procedimiento</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $restult = mysqli_query($link, "SELECT * FROM SubProceso WHERE idProceso = '{$_POST['idProceso']}' ORDER BY idEstado ASC");
                            while ($fila = mysqli_fetch_array($restult)){
                                echo "<tr>";
                                echo "<td>{$fila['descripcion']}</td>";
                                $restult1 = mysqli_query($link, "SELECT * FROM Estado WHERE idEstado = '{$fila['idEstado']}'");
                                while ($fila1 = mysqli_fetch_array($restult1)){
                                    $descripcion = $fila1['descripcion'];
                                    echo "<td>{$fila1['descripcion']}</td>";
                                }
                                echo "
                                    <td>
                                        <form method='post'>
                                        <input type='hidden' name='idProcedimiento' value=".$fila['idProcedimiento'].">
                                        <input type='hidden' name='idProceso' value=".$_POST['idProceso'].">
                                        <input type='hidden' name='estado' value=".$fila['idEstado'].">
                                            <div class='dropdown'>
                                                <button class='btn btn-outline-primary btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                Acciones
                                                </button>
                                                <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                                    <button name='editar' class='dropdown-item' type='submit' formaction='editarProcedimiento.php'>Editar</button>
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

    <div class="modal fade" id="modalProcedimiento" tabindex="-1" role="dialog" aria-labelledby="modalProcedimiento" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Procedimiento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form id="formProcedimiento" method="post" action="#">
                            <input type='hidden' name='idProceso' value="<?php echo $_POST['idProceso'];?>">
                            <div class="form-group row">
                                <label class="col-form-label" for="subproceso">Procedimiento:</label>
                                <input type="text" name="subproceso" id="subproceso" class="form-control">
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label" for="tipo">Tipo de Procedimiento:</label>
                                <select name="tipo" id="tipo" class="form-control">
                                    <option selected disabled>Seleccionar</option>
                                    <option value="1">Primario</option>
                                    <option value="2">Secundario</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" form="formProcedimiento" value="Submit" name="addProcedimiento">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <?php
    include('footer.php');
}
?>
