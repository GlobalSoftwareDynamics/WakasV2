<?php
include('session.php');
if(isset($_SESSION['login'])){
    include('header.php');
    include('navbarOperario.php');
    include('funciones.php');
    include('declaracionFechas.php');

    if(isset($_POST['regTareaRealizada'])){

        $result = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idProducto = '{$_POST['idProducto']}' AND idComponente = '{$_POST['componente']}'");
        while ($fila = mysqli_fetch_array($result)){
            $idComponenteEspecifico = $fila['idComponenteEspecifico'];
        }

        $_POST['idLote'] = strtoupper($_POST['idLote']);
        $query = mysqli_query($link,"INSERT INTO EmpleadoLote(idLote,idEmpleado,idProducto,idComponenteEspecifico,idMaquina,idProcedimiento,cantidad,fecha) VALUES 
        ('{$_POST['idLote']}','{$_SESSION['user']}','{$_POST['idProducto']}','{$idComponenteEspecifico}','{$_POST['maquina']}','{$_POST['procedimiento']}','{$_POST['cantidad']}','{$dateTime}')");

        $queryPerformed = "INSERT INTO EmpleadoLote(idLote,idEmpleado,idProducto,idComponenteEspecifico,idMaquina,idProcedimiento,cantidad,fecha) VALUES 
        ({$_POST['idLote']},{$_SESSION['user']},{$_POST['idProducto']},{$idComponenteEspecifico},{$_POST['maquina']},{$_POST['procedimiento']},{$_POST['cantidad']},{$dateTime})";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','DELETE','ConfirmacionVentaProducto','{$queryPerformed}')");

    }

    ?>
    <section class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-inverse card-info">
                        <div class="float-left mt-1">
                            <i class="fa fa-cogs"></i>
                            &nbsp;&nbsp;Registro de Tarea
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="col-12">
                            <div class="spacer20"></div>
                            <p class="text-center">Felicitaciones la Tarea ha sido registrada exitosamente en el sistema.</p>
                            <div class="row">
                                <div class="col-12">
                                    <a href="mainOperario.php" class="btn btn-primary col-12">Finalizar</a>
                                </div>
                            </div>
                            <div class="spacer20"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
    include('footer.php');
}
?>