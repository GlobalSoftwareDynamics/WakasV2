<?php
include('session.php');
include('declaracionFechas.php');
include('funciones.php');
if(isset($_SESSION['login'])){
    include('header.php');
    include('navbarAdmin.php');

    if (isset($_POST['editar'])){

        $query = mysqli_query($link,"UPDATE Repuestos SET descripcion = '{$_POST['repuesto']}', idUnidadMedida = '{$_POST['unidadMedida']}' WHERE idRepuestos = '{$_POST['idRepuestos']}'");

        $queryPerformed1 = "UPDATE Repuestos SET descripcion = {$_POST['repuesto']}, idUnidadMedida = {$_POST['unidadMedida']} WHERE idRepuestos = {$_POST['idRepuestos']}";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','UPDATE','Repuestos','{$queryPerformed1}')");


    }

    if (isset($_POST['addRepuesto'])){

        $query = mysqli_query($link, "INSERT INTO Repuestos(idUnidadMedida, idEstado, descripcion) VALUES ('{$_POST['unidadMedida']}', 1,'{$_POST['repuesto']}')");

        $queryPerformed = "INSERT INTO Repuestos(idUnidadMedida, idEstado, descripcion) VALUES ({$_POST['unidadMedida']}, 1,{$_POST['repuesto']})";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','Repuestos','{$queryPerformed}')");


    }

    if (isset($_POST['desactivar'])){

        if ($_POST['estado']==1){

            $query = mysqli_query($link, "UPDATE Repuestos SET idEstado = 2 WHERE idRepuestos = '{$_POST['idRepuestos']}'");

            $queryPerformed = "UPDATE Repuestos SET idEstado = 2 WHERE idRepuestos = '{$_POST['idRepuestos']}'";

            $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','UPDATE','Desactivar Repuesto','{$queryPerformed}')");


        }else{

            $query = mysqli_query($link, "UPDATE Repuestos SET idEstado = 1 WHERE idRepuestos = '{$_POST['idRepuestos']}'");

            $queryPerformed = "UPDATE Repuestos SET idEstado = 1 WHERE idRepuestos = '{$_POST['idRepuestos']}'";

            $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','UPDATE','Activar Repuesto','{$queryPerformed}')");

        }

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
                Listado de Repuestos
                <div class="float-right">
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Acciones
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <form method="post">
                                <a class="dropdown-item" data-toggle="modal" data-target="#modalRepuesto" style="font-size: 14px;">Registrar Nuevo Repuesto</a>
                                <a class="dropdown-item" href="gestionMaquinas.php" style="font-size: 14px;">Regresar</a>
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
                                <label class="sr-only" for="material">Repuesto</label>
                                <input type="text" class="form-control mt-2 mb-2 mr-2" id="material" placeholder="Repuesto" onkeyup="myFunction()">
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
                                <th class="text-center">Repuesto</th>
                                <th class="text-center">Medida</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $restult = mysqli_query($link, "SELECT * FROM Repuestos ORDER BY idEstado ASC");
                            while ($fila = mysqli_fetch_array($restult)){
                                echo "<tr>";
                                echo "<td>{$fila['descripcion']}</td>";
                                echo "<td>{$fila['idUnidadMedida']}</td>";
                                $restult1 = mysqli_query($link, "SELECT * FROM Estado WHERE idEstado = '{$fila['idEstado']}'");
                                while ($fila1 = mysqli_fetch_array($restult1)){
                                    $descripcion = $fila1['descripcion'];
                                    echo "<td>{$fila1['descripcion']}</td>";
                                }
                                echo "
                                    <td>
                                        <form method='post'>
                                        <input type='hidden' name='idRepuestos' value=".$fila['idRepuestos'].">
                                        <input type='hidden' name='estado' value=".$fila['idEstado'].">
                                            <div class='dropdown'>
                                                <button class='btn btn-outline-primary btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                Acciones
                                                </button>
                                                <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                                    <button name='editar' class='dropdown-item' type='submit' formaction='editarRepuesto.php'>Editar</button>
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

    <div class="modal fade" id="modalRepuesto" tabindex="-1" role="dialog" aria-labelledby="modalRepuesto" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Repuesto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form id="formRepuesto" method="post" action="#">
                            <div class="form-group row">
                                <label class="col-form-label" for="repuesto">Repuesto:</label>
                                <input type="text" name="repuesto" id="repuesto" class="form-control">
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label" for="unidadMedida">Medida:</label>
                                <select name="unidadMedida" id="unidadMedida" class="form-control">
                                    <option selected disabled>Seleccionar</option>
                                    <?php
                                    $result = mysqli_query($link, "SELECT * FROM UnidadMedida ORDER BY idUnidadMedida ASC");
                                    while ($fila = mysqli_fetch_array($result)){
                                        echo "<option value='{$fila['idUnidadMedida']}'>{$fila['idUnidadMedida']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" form="formRepuesto" value="Submit" name="addRepuesto">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <?php
    include('footer.php');
}
?>
