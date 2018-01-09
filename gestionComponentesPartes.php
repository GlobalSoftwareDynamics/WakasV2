<?php
include('session.php');
include('declaracionFechas.php');
include('funciones.php');
if(isset($_SESSION['login'])){
    include('header.php');
    include('navbarAdmin.php');

    if(isset($_POST['addComponenteParte'])){

        $query = mysqli_query($link, "INSERT INTO ComponentesPrenda(descripcion, tipo) VALUES ('{$_POST['descripcion']}','{$_POST['tipo']}')");

        $queryPerformed = "INSERT INTO ComponentesPrenda(descripcion, tipo) VALUES ({$_POST['descripcion']},{$_POST['tipo']})";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','ComponentesPrenda','{$queryPerformed}')");
    }

    if(isset($_POST['editar'])){

        $query = mysqli_query($link, "UPDATE ComponentesPrenda SET descripcion = '{$_POST['descripcion']}', tipo = '{$_POST['tipo']}' WHERE idComponente = '{$_POST['idComponente']}'");

        $queryPerformed = "UPDATE ComponentesPrenda SET descripcion = {$_POST['descripcion']}, tipo = {$_POST['tipo']} WHERE idComponente = {$_POST['idComponente']}";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','UPDATE','ComponentesPrenda','{$queryPerformed}')");
    }

    ?>

    <script>
        function myFunction() {
            // Declare variables
            var input, input2, input3, filter, filter2, filter3, table, tr, td, td2, td3, i;
            input = document.getElementById("componente");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if ((td)) {
                    if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
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
                Listado de Componentes y Partes
                <div class="float-right">
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Acciones
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <button type="button" class="dropdown-item" data-toggle="modal" data-target="#modalComponentes">Agregar Componente o Parte</button>
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
                                <label class="sr-only" for="componente">Componente</label>
                                <input type="text" class="form-control mt-2 mb-2 mr-2" id="componente" placeholder="Componente o Parte" onkeyup="myFunction()">
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
                                <th class="text-center">Descripcion</th>
                                <th class="text-center">Tipo</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $restult = mysqli_query($link, "SELECT * FROM ComponentesPrenda ORDER BY descripcion ASC");
                            while ($fila = mysqli_fetch_array($restult)){
                                switch ($fila['tipo']){
                                    case 1:
                                        $tipo = "Componente";
                                        break;
                                    case 2:
                                        $tipo = "Parte";
                                        break;
                                }
                                echo "<tr>";
                                echo "<td>{$fila['descripcion']}</td>";
                                echo "<td>{$tipo}</td>";
                                echo "
                                    <td>
                                        <form method='post'>
                                        	<input type='hidden' name='idComponente' value=".$fila['idComponente'].">
                                        	<input type='submit' formaction='editarComponente.php' value='Ver detalle' class='btn btn-sm btn-primary'>
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
        <div class="modal fade" id="modalComponentes" tabindex="-1" role="dialog" aria-labelledby="modalComponentes" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar Componente</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="form-group row">
                                <label class="col-form-label" for="descripcion">Descripción:</label>
                                <input type="text" name="descripcion" id="descripcion" class="form-control">
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label" for="tipo">Tipo:</label>
                                <select name="tipo" id="tipo" class="form-control">
                                    <option selected disabled>Seleccionar</option>
                                    <option value="1">Componente</option>
                                    <option value="2">Parte</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" form="formCodificacion" value="Submit" name="addComponenteParte">Guardar Cambios</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php
    include('footer.php');
}
?>
