<?php
include('session.php');
if(isset($_SESSION['login'])){
    include('header.php');
    include('navbarOperario.php');
    include('funciones.php');
    include('declaracionFechas.php');

    ?>
    <form method="post" id="formRegistro">
    <section class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-inverse card-info">
                        <div class="float-left mt-1">
                            <i class="fa fa-cogs"></i>
                            &nbsp;&nbsp;Registro de Tarea
                        </div>
                        <div class="float-right">
                            <div class="dropdown">
                                <input name="regTareaRealizada" type="submit" form="formRegistro" class="btn btn-light btn-sm" formaction="registrarProceso_Revision.php" value="Guardar">
                            </div>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="col-12">
                            <div class="spacer20"></div>
                            <div class="form-group row">
                                <label for="idLote" class="col-12 col-form-label">Lote:</label>
                                <div class="col-12">
                                    <input class="form-control" type="text" id="idLote" name="idLote" onkeyup="getProductoLote(this.value);getComponentesProductoLote(this.value)" onchange="getProductoLote(this.value);getComponentesProductoLote(this.value)" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="idProducto" class="col-12 col-form-label">Producto:</label>
                                <div class="col-12" id="productoLote">
                                    <input class="form-control" type="text" id="idProducto" name="idProducto" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="componente" class="col-12 col-form-label">Componentes:</label>
                                <div class="col-12">
                                    <select class="form-control" name="componente" id="componente" onchange="getProcesosComponente(this.value)" required>
                                        <option disabled selected>Seleccionar</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="procedimiento" class="col-12 col-form-label">Procedimientos:</label>
                                <div class="col-12">
                                    <select class="form-control" name="procedimiento" id="procedimiento" onchange="getMaquinasProcedimiento(this.value);getCantidadRestanteLote(this.value)" required>
                                        <option disabled selected>Seleccionar</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="maquina" class="col-12 col-form-label">Máquinas:</label>
                                <div class="col-12">
                                    <select class="form-control" name="maquina" id="maquina" required>
                                        <option disabled selected>Seleccionar</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="cantidad" class="col-12 col-form-label">Cantidad de Producto Terminado:</label>
                                <div class="col-12" id="cantidadRestanteLote">
                                    <input class="form-control" type="number" id="cantidad" name="cantidad" min="0" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </form>

    <?php
    include('footer.php');
}
?>