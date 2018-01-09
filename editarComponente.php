<?php
include('session.php');
include('declaracionFechas.php');
include('funciones.php');
if(isset($_SESSION['login'])){
    include('header.php');
    include('navbarAdmin.php');

    $result = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE idComponente = '{$_POST['idComponente']}'");
    while($row = mysqli_fetch_array($result)) {

        ?>

        <section class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-inverse card-info">
                            <div class="float-left">
                                <i class="fa fa-wrench"></i>
                                Editar Componentes y Partes
                            </div>
                            <div class="float-right">
                                <div class="dropdown">
                                    <button form="form" name='volver' class='btn btn-light btn-sm'>Volver</button>
                                    <button form="form" name='editar' class='btn btn-light btn-sm'>Guardar</button>
                                </div>
                            </div>
                        </div>
                        <form method="post" action="gestionComponentesPartes.php" id="form">
                            <input type="hidden" name="idComponente" value="<?php echo $_POST['idComponente'];?>">
                            <div class="card-block">
                                <div class="col-12">
                                    <div class="spacer15"></div>
                                    <div class="form-group row">
                                        <label class="col-form-label" for="descripcion">Descripción:</label>
                                        <input type="text" name="descripcion" id="descripcion" class="form-control" value="<?php echo $row['descripcion'];?>">
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label" for="tipo">Tipo:</label>
                                        <select name="tipo" id="tipo" class="form-control">
                                            <?php
                                            switch ($row['tipo']){
                                                case 1:
                                                    $tipo = "Componente";
                                                    break;
                                                case 2:
                                                    $tipo = "Parte";
                                                    break;
                                            }
                                            ?>
                                            <option value="<?php echo $row['tipo']?>"><?php echo $tipo?></option>
                                            <option value="1">Componente</option>
                                            <option value="2">Parte</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <?php
    }
    include('footer.php');
}
?>
