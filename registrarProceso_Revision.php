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
                                &nbsp;&nbsp;Registro de Tarea (Revisión)
                            </div>
                            <div class="float-right">
                                <div class="dropdown">
                                    <input name="regTareaRealizada" type="submit" form="formRegistro" class="btn btn-light btn-sm" formaction="registrarProceso_Confirmacion.php" value="Guardar">
                                </div>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="col-12">
                                <div class="spacer20"></div>
                                <div class="form-group row">
                                    <label for="idLote" class="col-12 col-form-label">Lote:</label>
                                    <div class="col-12">
                                        <input required class="form-control" type="text" id="idLote" name="idLote" onkeyup="getProductoLote(this.value);getComponentesProductoLote(this.value)" onchange="getProductoLote(this.value);getComponentesProductoLote(this.value)" value="<?php echo $_POST['idLote']?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="idProducto" class="col-12 col-form-label">Producto:</label>
                                    <div class="col-12" id="productoLote">
                                        <input required class="form-control" type="text" id="idProducto" name="idProducto" value="<?php echo $_POST['idProducto']?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="componente" class="col-12 col-form-label">Componentes:</label>
                                    <div class="col-12">
                                        <select required class="form-control" name="componente" id="componente" onchange="getProcesosComponente(this.value)">
                                            <?php
                                            $result5 = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE idComponente = '{$_POST['componente']}'");
                                            while ($fila5 = mysqli_fetch_array($result5)){
                                                echo "<option value='{$fila5['idComponente']}' selected>{$fila5['descripcion']}</option>";
                                            }
                                            $result = mysqli_query($link,"SELECT * FROM Lote WHERE idLote = '{$_POST['idLote']}'");
                                            while ($fila = mysqli_fetch_array($result)){
                                                $result1 = mysqli_query($link,"SELECT * FROM ConfirmacionVentaProducto WHERE idConfirmacionVentaProducto = '{$fila['idConfirmacionVentaProducto']}'");
                                                while ($fila1 = mysqli_fetch_array($result1)){
                                                    $result2 = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idProducto = '{$fila1['idProducto']}'");
                                                    while ($fila2 = mysqli_fetch_array($result2)){
                                                        $result3 = mysqli_query($link,"SELECT idProducto, idComponenteEspecifico, COUNT(*) AS cantidadProcesos FROM PCPSPC WHERE idProducto = '{$fila1['idProducto']}' AND idComponenteEspecifico = '{$fila2['idComponenteEspecifico']}' AND idSubProcesoCaracteristica IN (SELECT idSubProcesoCaracteristica FROM SubProcesoCaracteristica WHERE idCaracteristica = 7)");
                                                        while ($fila3 = mysqli_fetch_array($result3)){
                                                            $cantidadTotal = $fila3['cantidadProcesos']*$fila['cantidad'];
                                                        }
                                                        $result4 = mysqli_query($link,"SELECT idComponenteEspecifico, SUM(cantidad) AS cantidadRealizada FROM EmpleadoLote WHERE idLote = '{$_POST['idLote']}' AND idComponenteEspecifico = '{$fila2['idComponenteEspecifico']}'");
                                                        $filasArray = mysqli_num_rows($result4);
                                                        while ($fila4 = mysqli_fetch_array($result4)){
                                                            if($fila4['idComponenteEspecifico']==null){
                                                                $cantidadRealizada = 0;
                                                            }else{
                                                                $cantidadRealizada = $fila4['cantidadRealizada'];
                                                            }
                                                        }
                                                        if($cantidadTotal == $cantidadRealizada){
                                                        }else{
                                                            $result5 = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE idComponente IN (SELECT idComponente FROM ProductoComponentesPrenda WHERE idComponenteEspecifico = '{$fila2['idComponenteEspecifico']}')");
                                                            while ($fila5 = mysqli_fetch_array($result5)){
                                                                echo "<option value='{$fila2['idComponente']}'>{$fila5['descripcion']}</option>";
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="procedimiento" class="col-12 col-form-label">Procedimientos:</label>
                                    <div class="col-12">
                                        <select required class="form-control" name="procedimiento" id="procedimiento" onchange="getMaquinasProcedimiento(this.value);getCantidadRestanteLote(this.value)">
                                            <?php
                                            $result5 = mysqli_query($link,"SELECT * FROM SubProceso WHERE idProcedimiento = '{$_POST['procedimiento']}'");
                                            while ($fila5 = mysqli_fetch_array($result5)){
                                                echo "<option value='{$fila5['idProcedimiento']}' selected>{$fila5['descripcion']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="maquina" class="col-12 col-form-label">Máquinas:</label>
                                    <div class="col-12">
                                        <select required class="form-control" name="maquina" id="maquina">
                                            <?php
                                            $result5 = mysqli_query($link,"SELECT * FROM Maquina WHERE idMaquina = '{$_POST['maquina']}'");
                                            while ($fila5 = mysqli_fetch_array($result5)){
                                                echo "<option value='{$fila5['idMaquina']}' selected>{$fila5['descripcion']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="cantidad" class="col-12 col-form-label">Cantidad de Producto Terminado:</label>
                                    <div class="col-12" id="cantidadRestanteLote">
                                        <input required class="form-control" type="number" id="cantidad" name="cantidad" min="0" value="<?php echo $_POST['cantidad']?>">
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