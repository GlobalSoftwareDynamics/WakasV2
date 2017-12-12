<?php
include('session.php');
include('declaracionFechas.php');
if(isset($_SESSION['login'])){
    include('header.php');
    include('navbarAdmin.php');

    if (isset($_POST['emitir'])){

        $query = mysqli_query($link, "UPDATE ConfirmacionVenta SET idEstado = 4 WHERE idContrato = '{$_POST['idConfirmacionVenta']}'");

        $queryPerformed = "UPDATE ConfirmacionVenta SET idEstado = 4 WHERE idContrato = '{$_POST['idConfirmacionVenta']}'";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','UPDATE','Emitir CV','{$queryPerformed}')");

    }

    if (isset($_POST['eliminar'])){

        $delete = mysqli_query($link, "DELETE FROM ConfirmacionVentaProducto WHERE idContrato = '{$_POST['idConfirmacionVenta']}'");
        $delete = mysqli_query($link, "DELETE FROM Precio WHERE idContrato = '{$_POST['idConfirmacionVenta']}'");
        $delete = mysqli_query($link, "DELETE FROM ConfirmacionVenta WHERE idContrato = '{$_POST['idConfirmacionVenta']}'");

        $queryPerformed = "DELETE FROM ConfirmacionVentaProducto WHERE idContrato = {$_POST['idConfirmacionVenta']}";
        $queryPerformed2 = "DELETE FROM Precio WHERE idContrato = {$_POST['idConfirmacionVenta']}";
        $queryPerformed3 = "DELETE FROM ConfirmacionVenta WHERE idContrato = {$_POST['idConfirmacionVenta']}";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idColaborador,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','DELETE','ConfirmacionVentaProducto','{$queryPerformed}')");
        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idColaborador,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','DELETE','Precio','{$queryPerformed2}')");
        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idColaborador,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','DELETE','ConfirmacionVenta','{$queryPerformed3}')");

    }

    ?>

    <script>
        function myFunction() {
            // Declare variables
            var input, input2, input3, input4, filter, filter2, filter3, filter4, table, tr, td, td2, td3, td4, i;
            input = document.getElementById("idTransaccion");
            input2 = document.getElementById("fechaCreacion");
            input3 = document.getElementById("cliente");
            input4 = document.getElementById("estado");
            filter = input.value.toUpperCase();
            filter2 = input2.value.toUpperCase();
            filter3 = input3.value.toUpperCase();
            filter4 = input4.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                td2 = tr[i].getElementsByTagName("td")[1];
                td3 = tr[i].getElementsByTagName("td")[2];
                td4 = tr[i].getElementsByTagName("td")[3];
                if ((td)&&(td2)) {
                    if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        if(td2.innerHTML.toUpperCase().indexOf(filter2) > -1){
                            if(td3.innerHTML.toUpperCase().indexOf(filter3) > -1){
                                if(td4.innerHTML.toUpperCase().indexOf(filter4) > -1){
                                    tr[i].style.display = "";
                                }else{
                                    tr[i].style.display = "none";
                                }
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
                Listado de Confirmaciones de Venta
                <div class="float-right">
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Acciones
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="nuevaCV_DatosGenerales.php">Registrar Nueva Confirmación de Venta</a>
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
                                <label class="sr-only" for="idTransaccion">Orden #</label>
                                <input type="text" class="form-control mt-2 mb-2 mr-2" id="idTransaccion" placeholder="Orden #" onkeyup="myFunction()">
                                <label class="sr-only" for="fechaCreacion">Fecha de Creación</label>
                                <input type="text" class="form-control mt-2 mb-2 mr-2" id="fechaCreacion" placeholder="Fecha de Creación" onkeyup="myFunction()">
                                <label class="sr-only" for="cliente">Cliente</label>
                                <input type="text" class="search-key form-control mt-2 mb-2 mr-2" id="cliente" placeholder="Cliente" onkeyup="myFunction()">
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
                                <th class="text-center">Orden #</th>
                                <th class="text-center">Fecha</th>
                                <th class="text-center">Cliente</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $restult = mysqli_query($link, "SELECT * FROM ConfirmacionVenta ORDER BY fecha DESC");
                            while ($fila = mysqli_fetch_array($restult)){
                                echo "<tr>";
                                echo "<td>{$fila['idContrato']}</td>";
                                echo "<td>{$fila['fecha']}</td>";
                                $restult1 = mysqli_query($link, "SELECT * FROM Cliente WHERE idCliente IN (SELECT idCliente FROM Contacto WHERE idContacto = '{$fila['idContacto']}')");
                                while ($fila1 = mysqli_fetch_array($restult1)){
                                    echo "<td>{$fila1['nombre']}</td>";
                                }
                                $restult1 = mysqli_query($link, "SELECT * FROM Estado WHERE idEstado = '{$fila['idEstado']}'");
                                while ($fila1 = mysqli_fetch_array($restult1)){
                                    $descripcion = $fila1['descripcion'];
                                    echo "<td>{$fila1['descripcion']}</td>";
                                }
                                echo "
                                    <td>
                                        <form method='post'>
                                        <input type='hidden' name='idConfirmacionVenta' value=".$fila['idContrato'].">
                                        <input type='hidden' name='codifTalla' value=".$fila['idcodificacionTalla'].">
                                            <div class='dropdown'>
                                                <button class='btn btn-outline-primary btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                Acciones
                                                </button>
                                                <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                                    <button name='verCV' class='dropdown-item' type='submit' formaction='detalleCV.php'>Ver Detalle</button>
                                                    <button name='pdf' class='dropdown-item' type='submit' formaction='detalleCVpdf.php'>Descargar PDF</button>
                                ";
                                                if($descripcion == "Abierta"){
                                                    echo "
                                                    <button name='emitir' class='dropdown-item' type='submit' formaction='#'>Emitir</button>
                                                    <button name='eliminar' class='dropdown-item' type='submit' formaction='#'>Eliminar</button>
                                                    ";
                                                }
                                echo "
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
