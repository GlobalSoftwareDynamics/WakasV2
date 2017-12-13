<?php
include('session.php');
include('declaracionFechas.php');
include('funciones.php');
if(isset($_SESSION['login'])){
    include('header.php');
    include('navbarAdmin.php');

    ?>

    <section class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-inverse card-info">
                        <div class="float-left">
                            <i class="fa fa-cogs"></i>
                            Nueva Orden de Producción
                        </div>
                        <div class="float-right">
                            <div class="dropdown">
                                <button form="form" name='nuevaOPparcial' class='btn btn-light btn-sm'>Crear Orden</button>
                            </div>
                        </div>
                    </div>
                    <form method="post" action="detalleOP.php" id="form">
                        <div class="card-block">
                            <div class="col-12">
                                <div class="spacer15"></div>
                                <div class="form-group row">
                                    <label for="fechaContrato" class="col-2 col-form-label">Fecha:</label>
                                    <div class="col-4">
                                        <input class="form-control" type="date" id="fechaContrato" name="fechaContrato" placeholder="<?php echo $date = date("Y-m-d")?>" onchange="getContrato(this.value)">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="idConfirmacionVenta" class="col-2 col-form-label">Confirmación de Venta:</label>
                                    <div class="col-10">
                                        <select class="form-control" id="idConfirmacionVenta" name="idConfirmacionVenta" onchange="getProductosContrato(this.value)" required>
                                            <option disabled selected>Seleccionar</option>
                                            <?php
                                            $result = mysqli_query($link,"SELECT * FROM ConfirmacionVenta ORDER BY fecha DESC");
                                            while($fila = mysqli_fetch_array($result)){
                                                echo "<option value='{$fila['idContrato']}'>{$fila['idContrato']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <table class="table text-center">
                                        <thead>
                                        <tr>
                                            <th class="text-center">idProducto</th>
                                            <th class="text-center">Talla</th>
                                            <th class="text-center">Colores</th>
                                            <th class="text-center">Cantidad</th>
                                            <th class="text-center">Cantidad Deseada</th>
                                            <th class="text-center">Marcación</th>
                                        </tr>
                                        </thead>
                                        <tbody id="formMarcacion">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php

    include('footer.php');
}
?>
