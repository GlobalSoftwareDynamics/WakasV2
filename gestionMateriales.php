<?php
include('session.php');
include('declaracionFechas.php');
include('funciones.php');
if(isset($_SESSION['login'])){
    include('header.php');
    include('navbarAdmin.php');

    if (isset($_POST['editar'])){

        $query = mysqli_query($link,"UPDATE Material SET material = '{$_POST['nombreMaterial']}', siglas = '{$_POST['siglas']}', idUnidadMedida = '{$_POST['unidadMedida']}' WHERE idMaterial = '{$_POST['idMaterial']}'");

        $queryPerformed1 = "UPDATE Material SET material = {$_POST['nombreMaterial']}, siglas = {$_POST['siglas']}, idUnidadMedida = {$_POST['unidadMedida']} WHERE idMaterial = {$_POST['idMaterial']}";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','UPDATE','Material','{$queryPerformed1}')");


    }

    if (isset($_POST['addMaterial'])){

        $query = mysqli_query($link, "INSERT INTO Material(idUnidadMedida, idEstado, material, siglas)
                VALUES ('{$_POST['unidadMedida']}',1,'{$_POST['nombreMaterial']}','{$_POST['siglas']}')");

        $queryPerformed = "INSERT INTO Material(idUnidadMedida, idEstado, material, siglas)
                VALUES ({$_POST['unidadMedida']},1,{$_POST['nombreMaterial']},{$_POST['siglas']})";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','Material','{$queryPerformed}')");


    }

    if (isset($_POST['desactivar'])){

        if ($_POST['estado']==1){

            $query = mysqli_query($link, "UPDATE Material SET idEstado = 2 WHERE idMaterial = '{$_POST['idMaterial']}'");

            $queryPerformed = "UPDATE Material SET idEstado = 2 WHERE idMaterial = '{$_POST['idMaterial']}'";

            $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','UPDATE','Desactivar Material','{$queryPerformed}')");


        }else{

            $query = mysqli_query($link, "UPDATE Material SET idEstado = 1 WHERE idMaterial = '{$_POST['idMaterial']}'");

            $queryPerformed = "UPDATE Material SET idEstado = 1 WHERE idMaterial = '{$_POST['idMaterial']}'";

            $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','UPDATE','Activar Material','{$queryPerformed}')");

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
                Listado de Materiales
                <div class="float-right">
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Acciones
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <form method="post">
                                <input class="dropdown-item" type="submit" name="nuevoMaterial" formaction="nuevoMaterial.php" value="Registrar Nuevo Material">
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
                                <label class="sr-only" for="material">Material</label>
                                <input type="text" class="form-control mt-2 mb-2 mr-2" id="material" placeholder="Material" onkeyup="myFunction()">
                                <label class="sr-only" for="unidad">Unidad</label>
                                <select class="form-control mt-2 mb-2 mr-2" id="unidad" onchange="myFunction()">
                                    <option disabled selected value="a">Unidad</option>
                                    <?php
                                    $query = mysqli_query($link, "SELECT * FROM UnidadMedida ORDER BY idUnidadMedida ASC");
                                    while($row = mysqli_fetch_array($query)){
                                        echo "<option value='{$row['idUnidadMedida']}'>{$row['idUnidadMedida']}</option>";
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
                                <th class="text-center">Material</th>
                                <th class="text-center">Unidad</th>
                                <th class="text-center">Siglas</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $restult = mysqli_query($link, "SELECT * FROM Material ORDER BY idEstado ASC");
                            while ($fila = mysqli_fetch_array($restult)){
                                echo "<tr>";
                                echo "<td>{$fila['material']}</td>";
                                echo "<td>{$fila['idUnidadMedida']}</td>";
                                echo "<td>{$fila['siglas']}</td>";
                                $restult1 = mysqli_query($link, "SELECT * FROM Estado WHERE idEstado = '{$fila['idEstado']}'");
                                while ($fila1 = mysqli_fetch_array($restult1)){
                                    $descripcion = $fila1['descripcion'];
                                    echo "<td>{$fila1['descripcion']}</td>";
                                }
                                echo "
                                    <td>
                                        <form method='post'>
                                        <input type='hidden' name='idMaterial' value=".$fila['idMaterial'].">
                                        <input type='hidden' name='estado' value=".$fila['idEstado'].">
                                            <div class='dropdown'>
                                                <button class='btn btn-outline-primary btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                Acciones
                                                </button>
                                                <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                                    <button name='verProveedor' class='dropdown-item' type='submit' formaction='detalleMaterial.php'>Ver Proveedores</button>
                                                    <button name='editar' class='dropdown-item' type='submit' formaction='editarMaterial.php'>Editar</button>
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
