<?php
include('session.php');
include('declaracionFechas.php');
include ('funciones.php');
if(isset($_SESSION['login'])){

    if(isset($_POST['addCliente'])){

        if ($_POST['nombreNuevoCliente']!=""){

            $insert = mysqli_query($link,"INSERT INTO Cliente (idCliente, idEstado, nombre) VALUES ('{$_POST['ruc']}',1,'{$_POST['nombreNuevoCliente']}')");
            if($insert){
            }else{
                echo 'Error ingresando datos a la base de datos';
            }

            $queryPerformed = "INSERT INTO Cliente (idCliente, idEstado, nombre) VALUES ({$_POST['ruc']},1,{$_POST['nombreNuevoCliente']})";

            $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','NuevaCV-ConfirmacionVenta','{$queryPerformed}')");

        }else{
        }

    }

    include('header.php');
    include('navbarAdmin.php');

    ?>

    <section class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-inverse card-info">
                        <div class="float-left">
                            <i class="fa fa-shopping-cart"></i>
                            Nueva Confirmación de Venta
                        </div>
                        <div class="float-right">
                            <div class="dropdown">
                                <button form="formCV" name="addCV" class="btn btn-light btn-sm">Siguiente</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="col-12">
                            <div class="spacer15"></div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#general" role="tab">Información General</a>
                                </li>
                                <li>
                                    <a class="nav-link" data-toggle="tab" href="#envio" role="tab">Detalles de Envío</a>
                                </li>
                            </ul>
                            <form method="post" action="nuevaCV_Productos.php" id="formCV">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="general" role="tabpanel">
                                        <div class="spacer30"></div>
                                        <div class="form-group row">
                                            <label for="idConfirmacionVenta" class="col-2 col-form-label">Código de Contrato:</label>
                                            <div class="col-10">
                                                <input class="form-control" type="text" id="idConfirmacionVenta" name="idConfirmacionVenta" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="idReferencia" class="col-2 col-form-label">Código de Referencia:</label>
                                            <div class="col-10">
                                                <input class="form-control" type="text" id="idReferencia" name="idReferencia">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="cliente" class="col-2 col-form-label">Cliente:</label>
                                            <div class="col-8">
                                                <input type="text" name="cliente" id="cliente" class="form-control" onkeyup="getClienteCV(this.value)">
                                            </div>
                                            <div class="col-2">
                                                <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modalCliente">Agregar Cliente</button>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="fechaContrato" class="col-2 col-form-label">Fecha:</label>
                                            <div class="col-10">
                                                <input class="form-control" type="date" id="fechaContrato" name="fechaContrato" placeholder="<?php echo $date = date("Y-m-d")?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="metodoPago" class="col-2 col-form-label">Método de Pago:</label>
                                            <div class="col-10">
                                                <select class="form-control" id="metodoPago" name="metodoPago">
                                                    <option disabled selected>Seleccionar</option>
                                                    <?php
                                                    $restult = mysqli_query($link, "SELECT * FROM MetodoPago");
                                                    while ($fila = mysqli_fetch_array($restult)){
                                                        echo "<option value='{$fila['idMetodoPago']}'>{$fila['descripcion']}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="codifTalla" class="col-2 col-form-label">Codificación de Talla:</label>
                                            <div class="col-10">
                                                <select class="form-control" id="codifTalla" name="codifTalla">
                                                    <option disabled selected>Seleccionar</option>
                                                    <?php
                                                    $restult = mysqli_query($link, "SELECT * FROM codificacionTalla");
                                                    while ($fila = mysqli_fetch_array($restult)){
                                                        echo "<option value='{$fila['idcodificacionTalla']}'>{$fila['descripcion']}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="envio" role="tabpanel">
                                        <div class="spacer30"></div>
                                        <div id="datosCliente"></div>
                                        <div class="form-group row">
                                            <label for="incoterm" class="col-2 col-form-label">Incoterm:</label>
                                            <div class="col-10">
                                                <select class="form-control" id="incoterm" name="incoterm">
                                                    <option disabled selected>Seleccionar</option>
                                                    <?php
                                                    $restult = mysqli_query($link, "SELECT * FROM Incoterms");
                                                    while ($fila = mysqli_fetch_array($restult)){
                                                        echo "<option value='{$fila['idIncoterm']}'>{$fila['descripcion']}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="via" class="col-2 col-form-label">Vía:</label>
                                            <div class="col-10">
                                                <select class="form-control" id="via" name="via">
                                                    <option disabled selected>Seleccionar</option>
                                                    <?php
                                                    $restult = mysqli_query($link, "SELECT * FROM Via");
                                                    while ($fila = mysqli_fetch_array($restult)){
                                                        echo "<option value='{$fila['idVia']}'>{$fila['descripcion']}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="fechaEnvio" class="col-2 col-form-label">Fecha de Envío:</label>
                                            <div class="col-10">
                                                <input class="form-control" type="date" id="fechaEnvio" name="fechaEnvio" placeholder="<?php echo $date = date("Y-m-d")?>" required>
                                            </div>
                                        </div>
                                        <!--<div class="form-group row">
                                            <label for="costoEnvio" class="col-2 col-form-label">Costo de Envío (S/.):</label>
                                            <div class="col-10">
                                                <input class="form-control" type="text" id="costoEnvio" name="costoEnvio">
                                            </div>
                                        </div>-->
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="spacer35"></div>

    <div class="modal fade" id="modalCliente" tabindex="-1" role="dialog" aria-labelledby="modalCliente" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form id="formCliente" method="post" action="#">
                            <div class="form-group row">
                                <label class="col-form-label" for="ruc">DNI/RUC:</label>
                                <input type="text" name="ruc" id="ruc" class="form-control">
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label" for="nombreNuevoCliente">Nombre de Cliente:</label>
                                <input type="text" name="nombreNuevoCliente" id="nombreNuevoCliente" class="form-control">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" form="formCliente" value="Submit" name="addCliente">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <?php
    include('footer.php');
}
?>