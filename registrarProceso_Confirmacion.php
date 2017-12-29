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

        if (empty($_POST['maquina'])||$_POST['maquina']=="Seleccionar"){
            $_POST['maquina'] = "NULL";
        }else{
            $_POST['maquina'] = "'".$_POST['maquina']."'";
        }

        $_POST['idLote'] = strtoupper($_POST['idLote']);
        $query = mysqli_query($link,"INSERT INTO EmpleadoLote(idLote,idEmpleado,idProducto,idComponenteEspecifico,idMaquina,idProcedimiento,cantidad,fecha) VALUES 
        ('{$_POST['idLote']}','{$_SESSION['user']}','{$_POST['idProducto']}','{$idComponenteEspecifico}',{$_POST['maquina']},'{$_POST['procedimiento']}','{$_POST['cantidad']}','{$dateTime}')");

        $queryPerformed = "INSERT INTO EmpleadoLote(idLote,idEmpleado,idProducto,idComponenteEspecifico,idMaquina,idProcedimiento,cantidad,fecha) VALUES 
        ({$_POST['idLote']},{$_SESSION['user']},{$_POST['idProducto']},{$idComponenteEspecifico},{$_POST['maquina']},{$_POST['procedimiento']},{$_POST['cantidad']},{$dateTime})";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','DELETE','ConfirmacionVentaProducto','{$queryPerformed}')");

        $result = mysqli_query($link,"SELECT * FROM Lote WHERE idLote = '{$_POST['idLote']}'");
        while ($fila = mysqli_fetch_array($result)){
            $result1 = mysqli_query($link,"SELECT * FROM ConfirmacionVentaProducto WHERE idConfirmacionVentaProducto = '{$fila['idConfirmacionVentaProducto']}'");
            while ($fila1 = mysqli_fetch_array($result1)){
                $result2 = mysqli_query($link,"SELECT idProducto, COUNT(DISTINCT indice) AS nroProcesos FROM PCPSPC WHERE idProducto = '{$fila1['idProducto']}'");
                while ($fila2 = mysqli_fetch_array($result2)){
                    $cantidadTotal = $fila2['nroProcesos'] * $fila['cantidad'];
                }
            }
            $result1 = mysqli_query($link,"SELECT idLote, SUM(cantidad) AS cantidadRealizada FROM EmpleadoLote WHERE idLote = '{$_POST['idLote']}'");
            while ($fila1 = mysqli_fetch_array($result1)){
                $cantidadRealizada = $fila1['cantidadRealizada'];
            }
            if ($cantidadTotal == $cantidadRealizada){

                $query = mysqli_query($link,"UPDATE Lote SET idEstado = 5 WHERE idLote = '{$_POST['idLote']}'");

                $queryPerformed = "UPDATE Lote SET idEstado = 5 WHERE idLote = {$_POST['idLote']}";

                $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','UPDATE','Lote','{$queryPerformed}')");

            }
        }

        $result = mysqli_query($link,"SELECT idContrato FROM ConfirmacionVenta WHERE idEstado = 4");
        while ($fila = mysqli_fetch_array($result)){
            $result1 = mysqli_query($link,"SELECT * FROM OrdenProduccion WHERE idContrato = '{$fila['idContrato']}' AND idOrdenProduccion IN (SELECT idOrdenProduccion FROM Lote WHERE idEstado = 6)");
            $numRow = mysqli_num_rows($result1);
            if ($numRow > 0){

            }else{

                $query = mysqli_query($link,"UPDATE ConfirmacionVenta SET idEstado = 5 WHERE idContrato = '{$fila['idContrato']}'");

                $queryPerformed = "UPDATE ConfirmacionVenta SET idEstado = 5 WHERE idContrato = {$fila['idContrato']}";

                $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','UPDATE','ConfirmacionVenta','{$queryPerformed}')");

            }
        }
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