<?php
include('session.php');
include('declaracionFechas.php');
include('funciones.php');
if(isset($_SESSION['login'])){
    include('header.php');
    include('navbarAdmin.php');

    if(isset($_POST['addColor'])){

        $query = mysqli_query($link, "INSERT INTO Color(idColor, descripcion) VALUES ('{$_POST['codificacion']}','{$_POST['color']}')");

        $queryPerformed = "INSERT INTO Color(idColor, descripcion) VALUES ({$_POST['codificacion']},{$_POST['color']})";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','Color','{$queryPerformed}')");
    }

    if(isset($_POST['editar'])){

        $query = mysqli_query($link, "UPDATE Color SET idColor = '{$_POST['codificacion']}', descripcion = '{$_POST['color']}' WHERE idColor = '{$_POST['idColor']}'");

        $queryPerformed = "UPDATE Color SET idColor = {$_POST['codificacion']}, descripcion = {$_POST['color']} WHERE idColor = {$_POST['idColor']}";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','UPDATE','Color','{$queryPerformed}')");
    }

    ?>

    <script>
        function myFunction() {
            // Declare variables
            var input, input2, input3, filter, filter2, filter3, table, tr, td, td2, td3, i;
            input = document.getElementById("codificacion");
            input2 = document.getElementById("color");
            filter = input.value.toUpperCase();
            filter2 = input2.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                td2 = tr[i].getElementsByTagName("td")[1];
                if ((td)) {
                    if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        if (td2.innerHTML.toUpperCase().indexOf(filter2) > -1) {
                            tr[i].style.display = "";
                        }else {
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
                Listado de Colores
                <div class="float-right">
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Acciones
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <button type="button" class="dropdown-item" data-toggle="modal" data-target="#modalColor">Agregar Color</button>
                            <button type="submit" class="dropdown-item" form="formColor" formaction="gestionProductos.php">Regresar</button>
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
                            <form class="form-inline justify-content-center" method="post" action="#" id="formColor">
                                <label class="sr-only" for="codificacion">Código</label>
                                <input type="text" class="form-control mt-2 mb-2 mr-2" id="codificacion" placeholder="Código de Color" onkeyup="myFunction()">
                                <label class="sr-only" for="color">Color</label>
                                <input type="text" class="form-control mt-2 mb-2 mr-2" id="color" placeholder="Color" onkeyup="myFunction()">
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
                                <th class="text-center">Código de Color</th>
                                <th class="text-center">Nombre de Color</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $restult = mysqli_query($link, "SELECT * FROM Color ORDER BY descripcion ASC");
                            while ($fila = mysqli_fetch_array($restult)){
                                echo "<tr>";
                                echo "<td>{$fila['idColor']}</td>";
                                echo "<td>{$fila['descripcion']}</td>";
                                echo "
                                    <td>
                                        <form method='post'>
                                        	<input type='hidden' name='idColor' value=".$fila['idColor'].">
                                        	<input type='submit' formaction='editarColor.php' value='Ver detalle' class='btn btn-sm btn-primary'>
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

    <form method="post" action="#" id="formCodificacion">
        <div class="modal fade" id="modalColor" tabindex="-1" role="dialog" aria-labelledby="modalColor" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar Color</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="form-group row">
                                <label class="col-form-label" for="codificacion">Código de Color:</label>
                                <input type="text" name="codificacion" id="codificacion" class="form-control">
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label" for="color">Nombre de Color:</label>
                                <input type="text" name="color" id="color" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" form="formCodificacion" value="Submit" name="addColor">Guardar Cambios</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" id="formTalla">
        <div class="modal fade" id="modalTalla" tabindex="-1" role="dialog" aria-labelledby="modalTalla" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar Tallas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="form-group row">
                                <label class="col-form-label" for="codificacionTallaSelect">Seleccionar Codificación:</label>
                                <select name="codificacionTallaSelect" id="codificacionTallaSelect" class="form-control" onchange="getTablaTallas(this.value)">
                                    <option selected disabled>Seleccionar</option>
                                    <?php
                                    $search = mysqli_query($link, "SELECT * FROM codificacionTalla");
                                    while($index = mysqli_fetch_array($search)){
                                        echo "<option value='{$index['idcodificacionTalla']}'>{$index['descripcion']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label" for="talla">Sigla de Talla:</label>
                                <input type="text" name="talla" id="talla" class="form-control">
                            </div>
                            <div id="tablaTallas"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" form="formTalla" value="Submit" name="addTalla">Guardar Cambios</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php
    include('footer.php');
}
?>
