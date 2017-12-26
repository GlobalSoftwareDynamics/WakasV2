<?php
include('session.php');
if(isset($_SESSION['login'])){
    include('header.php');
    include('navbarOperario.php');
    include('funciones.php');
    include('declaracionFechas.php');

    if(isset($_POST['regActiviadadMuerta'])){

        if(empty($_POST['maquina'])){
            $tipo = 'General';
            $_POST['maquina'] = "NULL";
        }else{
            $tipo = 'Máquina';
            $_POST['maquina'] = "'".$_POST['maquina']."'";
        }

        $query = mysqli_query($link,"INSERT INTO EmpleadoActividadMuerta(idEmpleado,idActividadMuerta,idMaquina,tipo,descripcion,tiempo,fecha) VALUES ('{$_SESSION['user']}','{$_POST['categoriaAM']}',{$_POST['maquina']},'{$tipo}','{$_POST['descripcion']}','{$_POST['tiempoEmpleado']}','{$dateTime}')");

        $queryPerformed = "INSERT INTO EmpleadoActividadMuerta(idEmpleado,idActividadMuerta,idMaquina,tipo,descripcion,tiempo,fecha) VALUES ({$_SESSION['user']},{$_POST['categoriaAM']},{$_POST['maquina']},{$tipo},{$_POST['descripcion']},{$_POST['tiempoEmpleado']},{$dateTime})";

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
                            <p class="text-center">Felicitaciones la Actividad Muerta ha sido registrada exitosamente en el sistema.</p>
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