<?php
include('session.php');
if(isset($_SESSION['login'])){
    include('header.php');
    include('navbarOperario.php');
    ?>
    <section class="container">
        <div class="row">
            <div class="col-12">
                <h3 class="text-center">Bienvenido al Portal Operativo</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h4 class="text-center">¿Qué deseas hacer?</h4>
            </div>
        </div>
    </section>

    <section class="container" style="padding-top: 15px; padding-bottom: 15px;">
        <div class="row">
            <div class="col-12">
                <form method="post">
                    <div class="form-group row">
                        <div class="col-12">
                            <input type="submit" formaction="registrarProceso_Datos.php" class="btn btn-primary col-12" value="Registrar Tarea Realizada" name="regTarea">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <input type="submit" formaction="registrarActividadMuerta.php" class="btn btn-primary col-12" value="Registrar Actividad Muerta" name="regActMuerta">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <?php
    include('footer.php');
}
?>