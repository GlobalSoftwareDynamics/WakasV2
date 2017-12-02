<?php
include('session.php');
if(isset($_SESSION['login'])){
	include('header.php');
	include('navbarAdmin.php');
	include('funciones.php');
	include('declaracionFechas.php');

		// Éxito en la creación del producto

    if(isset($_POST['addTejido'])){
        $aux = 1;
        $query = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idProducto = '{$_POST['idProductoCrear']}'");
        while($row = mysqli_fetch_array($query)){
            $query2 = mysqli_query($link,"SELECT DISTINCT indice FROM PCPSPC WHERE idComponenteEspecifico = '{$row['idComponenteEspecifico']}'");
            while($row2 = mysqli_fetch_array($query2)){
                $aux++;
            }
        }

        $insert = mysqli_query($link,"INSERT INTO PCPSPC (idComponenteEspecifico, idSubProcesoCaracteristica, valor, indice) VALUES 
                                            ('{$_POST['selectComponente']}','3','{$_POST['selectTipoTejido']}','{$aux}')");

        $galgas = '';
	    foreach ($_POST['galgas'] as $galga) {
		    $galgas .= $galga.",";
	    }
	    $galgas = substr($galgas,0,(strlen($galgas)-1));
	    $insert = mysqli_query($link,"INSERT INTO PCPSPC (idComponenteEspecifico, idSubProcesoCaracteristica, valor, indice) VALUES 
                                            ('{$_POST['selectComponente']}','4','{$galgas}','{$aux}')");

	    $insert = mysqli_query($link,"INSERT INTO PCPSPC (idComponenteEspecifico, idSubProcesoCaracteristica, valor, indice) VALUES 
                                            ('{$_POST['selectComponente']}','5','{$_POST['comprobacionTejido']}','{$aux}')");

	    $insert = mysqli_query($link,"INSERT INTO PCPSPC (idComponenteEspecifico, idSubProcesoCaracteristica, valor, indice) VALUES 
                                            ('{$_POST['selectComponente']}','6','{$_POST['observaciones']}','{$aux}')");

	    $insert = mysqli_query($link,"INSERT INTO PCPSPC (idComponenteEspecifico, idSubProcesoCaracteristica, valor, indice) VALUES 
                                            ('{$_POST['selectComponente']}','7','{$_POST['tiempo']}','{$aux}')");
    }

    ?>

		<section class="container">
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header card-inverse card-info">
							<div class="float-left mt-1">
								<i class="fa fa-pencil"></i>
								&nbsp;&nbsp;Procesos y Subprocesos
							</div>
							<div class="float-right">
								<div class="dropdown">
                                    <button name="volver" type="submit" class="btn btn-light btn-sm" form="formSiguiente" formaction="nuevaHE2.php">Volver</button>
									<button name="siguiente" type="submit" class="btn btn-light btn-sm" form="formSiguiente">Guardar</button>
								</div>
							</div>
						</div>
                        <form id="formSiguiente" method="post" action="nuevaHE4.php">
                            <input type="hidden" name="idProductoCrear" value="<?php echo $_POST['idProductoCrear']?>">
                        </form>
						<div class="card-block">
							<div class="col-12">
								<?php
								$activoTejido = '';
								$activoLavado = '';
								$activoSecado = '';
								$activoConfeccion = '';
								$activoAcondicionamiento = '';
								$activoOtros = '';
								if(isset($_POST['siguienteHE2']) || isset($_POST['addTejido'])){
									$activoTejido = 'active';
								}
								if(isset($_POST['addLavado'])){
									$activoLavado = 'active';
								}
								if(isset($_POST['addSecado'])){
									$activoSecado = 'active';
								}
								if(isset($_POST['addConfeccion'])){
									$activoConfeccion = 'active';
								}
								if(isset($_POST['addAcondicionamiento'])){
									$activoAcondicionamiento = 'active';
								}
								if(isset($_POST['addOtros'])){
									$activoOtros = 'active';
								}
								?>
								<div class="spacer20"></div>
								<ul class="nav nav-tabs" role="tablist">
									<li class="nav-item">
										<a class="nav-link <?php echo $activoTejido;?>" data-toggle="tab" href="#tejido" role="tab">Tejido</a>
									</li>
									<li class="nav-item">
										<a class="nav-link <?php echo $activoLavado;?>" data-toggle="tab" href="#lavado" role="tab">Lavado</a>
									</li>
									<li class="nav-item">
										<a class="nav-link <?php echo $activoSecado;?>" data-toggle="tab" href="#secado" role="tab">Secado</a>
									</li>
									<li class="nav-item">
										<a class="nav-link <?php echo $activoConfeccion;?>" data-toggle="tab" href="#confeccion" role="tab">Confección</a>
									</li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php echo $activoAcondicionamiento;?>" data-toggle="tab" href="#acondicionamiento" role="tab">Acondicionamiento</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php echo $activoOtros;?>" data-toggle="tab" href="#otros" role="tab">Otros</a>
                                    </li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane <?php echo $activoTejido;?>" id="tejido" role="tabpanel">
										<div class="spacer20"></div>
                                        <form method="post" action="#">
                                            <input type="hidden" name="idProductoCrear" value="<?php echo $_POST['idProductoCrear']?>">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="text-center">Componente</th>
                                                <th class="text-center">Material</th>
                                                <th class="text-center">Tipo de Tejido</th>
                                                <th class="text-center">Galgas</th>
                                                <th class="text-center">Comprobación de Tejido</th>
                                                <th class="text-center">Observaciones</th>
                                                <th class="text-center">Tiempo</th>
                                                <th class="text-center">Acciones</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td><select name="selectComponente" class="form-control" onchange="getMaterial(this.value)">
                                                        <option selected disabled>Seleccionar</option>
                                                        <?php
                                                        $filter = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE tipo = 1");
                                                        while($filterIndex = mysqli_fetch_array($filter)){
	                                                        $query = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idProducto = '{$_POST['idProductoCrear']}' AND idComponente = '{$filterIndex['idComponente']}'");
	                                                        while($row = mysqli_fetch_array($query)){
	                                                            echo "<option value='{$row['idComponenteEspecifico']}'>{$filterIndex['descripcion']}</option>";
	                                                        }
                                                        }
                                                        ?>
                                                    </select></td>
                                                <td id="materialTejido"><input type="text" class="form-control" readonly></td>
                                                <td><select name="selectTipoTejido" class="form-control">
                                                        <option selected disabled>Seleccionar</option>
                                                        <option value="Industrial">Tejido Industrial</option>
                                                        <option value="Semi-Industrial">Tejido Semi-Industrial</option>
                                                        <option value="Manual">Tejido Manual</option>
                                                    </select></td>
                                                <td style="width: 13%"><select class="js-example-basic-multiple form-control" name="galgas[]" multiple="multiple">
                                                        <?php
                                                        $query = mysqli_query($link,"SELECT * FROM Galgas");
                                                        while($row = mysqli_fetch_array($query)){
                                                            echo "<option value='{$row['descripcion']}'>{$row['descripcion']}</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                                <td><input type="text" name="comprobacionTejido" class="form-control"></td>
                                                <td><input type="text" name="observaciones" class="form-control"></td>
                                                <td><input type="number" min="0" step="0.01" name="tiempo" class="form-control"></td>
                                                <td class="text-center"><input type="submit" name="addTejido" value="Agregar" class="btn btn-outline-primary"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="8"></td>
                                            </tr>
                                            <?php
                                            $query = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idProducto = '{$_POST['idProductoCrear']}'");
                                            while($row = mysqli_fetch_array($query)){
                                                $query2 = mysqli_query($link,"SELECT * FROM PCPSPC WHERE idComponenteEspecifico = '{$row['idComponenteEspecifico']}' AND idSubProcesoCaracteristica < 8 AND idSubProcesoCaracteristica > 2");
                                                while($row2 = mysqli_fetch_array($query2)){
                                                    
                                                }
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                        </form>
									</div>
                                    <div class="tab-pane <?php echo $activoLavado;?>" id="lavado" role="tabpanel">
                                        <div class="spacer20"></div>
                                        <form method="post" action="#">
                                            <input type="hidden" name="idProductoCrear" value="<?php echo $_POST['idProductoCrear']?>">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">Componente</th>
                                                    <th class="text-center">Tipo de Lavado</th>
                                                    <th class="text-center">Programa</th>
                                                    <th class="text-center">Observaciones</th>
                                                    <th class="text-center">Tiempo</th>
                                                    <th class="text-center">Acciones</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td><select name="selectComponente" class="form-control" onchange="getMaterial(this.value)">
                                                            <option selected disabled>Seleccionar</option>
						                                    <?php
						                                    $query = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idProducto = '{$_POST['idProductoCrear']}'");
						                                    while($row = mysqli_fetch_array($query)){
							                                    $query2 = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE idComponente = '{$row['idComponente']}'");
							                                    while($row2 = mysqli_fetch_array($query2)){
								                                    echo "<option value='{$row['idComponenteEspecifico']}'>{$row2['descripcion']}</option>";
							                                    }
						                                    }
						                                    ?>
                                                        </select></td>
                                                    <td><select name="selectTipoLavado" class="form-control">
                                                            <option selected disabled>Seleccionar</option>
                                                            <option value="Industrial">Lavado Industrial</option>
                                                            <option value="Semi-Industrial">Lavado Semi-Industrial</option>
                                                            <option value="Manual">Lavado Manual</option>
                                                        </select></td>
                                                    <td><input type="text" name="programa" class="form-control"></td>
                                                    <td><input type="text" name="observaciones" class="form-control"></td>
                                                    <td><input type="number" min="0" step="0.01" name="tiempo" class="form-control"></td>
                                                    <td class="text-center"><input type="submit" name="addLavado" value="Agregar" class="btn btn-outline-primary"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                </tr>
			                                    <?php
			                                    //Mostrar datos de Lavado
			                                    ?>
                                                </tbody>
                                            </table>
                                        </form>
                                    </div>
                                    <div class="tab-pane <?php echo $activoSecado;?>" id="secado" role="tabpanel">
                                        <div class="spacer20"></div>
                                        <form method="post" action="#">
                                            <input type="hidden" name="idProductoCrear" value="<?php echo $_POST['idProductoCrear']?>">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">Componente</th>
                                                    <th class="text-center">Tipo de Secado</th>
                                                    <th class="text-center">Programa</th>
                                                    <th class="text-center">Rotación</th>
                                                    <th class="text-center">Observaciones</th>
                                                    <th class="text-center">Tiempo</th>
                                                    <th class="text-center">Acciones</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td><select name="selectComponente" class="form-control" onchange="getMaterial(this.value)">
                                                            <option selected disabled>Seleccionar</option>
						                                    <?php
						                                    $query = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idProducto = '{$_POST['idProductoCrear']}'");
						                                    while($row = mysqli_fetch_array($query)){
							                                    $query2 = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE idComponente = '{$row['idComponente']}'");
							                                    while($row2 = mysqli_fetch_array($query2)){
								                                    echo "<option value='{$row['idComponenteEspecifico']}'>{$row2['descripcion']}</option>";
							                                    }
						                                    }
						                                    ?>
                                                        </select></td>
                                                    <td><select name="selectTipoSecado" class="form-control">
                                                            <option selected disabled>Seleccionar</option>
                                                            <option value="Industrial">Secado Industrial</option>
                                                            <option value="Semi-Industrial">Secado Semi-Industrial</option>
                                                            <option value="Manual">Secado Manual</option>
                                                        </select></td>
                                                    <td><input type="text" name="programa" class="form-control"></td>
                                                    <td><input type="text" name="rotacion" class="form-control"></td>
                                                    <td><input type="text" name="observaciones" class="form-control"></td>
                                                    <td><input type="number" min="0" step="0.01" name="tiempo" class="form-control"></td>
                                                    <td class="text-center"><input type="submit" name="addSecado" value="Agregar" class="btn btn-outline-primary"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                </tr>
			                                    <?php
			                                    //Mostrar datos de Secado
			                                    ?>
                                                </tbody>
                                            </table>
                                        </form>
                                    </div>
                                    <div class="tab-pane <?php echo $activoConfeccion;?>" id="confeccion" role="tabpanel">
                                        <div class="spacer20"></div>
                                        <form method="post" action="#">
                                            <input type="hidden" name="idProductoCrear" value="<?php echo $_POST['idProductoCrear']?>">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">Componente</th>
                                                    <th class="text-center">Procedimiento</th>
                                                    <th class="text-center">Indicaciones</th>
                                                    <th class="text-center">Máquina</th>
                                                    <th class="text-center">Observaciones</th>
                                                    <th class="text-center">Tiempo</th>
                                                    <th class="text-center">Acciones</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td><select name="selectComponente" class="form-control" onchange="getMaterial(this.value)">
                                                            <option selected disabled>Seleccionar</option>
						                                    <?php
						                                    $query = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idProducto = '{$_POST['idProductoCrear']}'");
						                                    while($row = mysqli_fetch_array($query)){
							                                    $query2 = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE idComponente = '{$row['idComponente']}'");
							                                    while($row2 = mysqli_fetch_array($query2)){
								                                    echo "<option value='{$row['idComponenteEspecifico']}'>{$row2['descripcion']}</option>";
							                                    }
						                                    }
						                                    ?>
                                                        </select></td>
                                                    <td><select name="selectProcedimiento" class="form-control">
                                                            <option selected disabled>Seleccionar</option>

                                                        </select></td>
                                                    <td><input type="text" name="indicaciones" class="form-control"></td>
                                                    <td><select name="selectMaquina" class="form-control">
                                                            <option selected disabled>Seleccionar</option>

                                                        </select></td>
                                                    <td><input type="text" name="observaciones" class="form-control"></td>
                                                    <td><input type="number" min="0" step="0.01" name="tiempo" class="form-control"></td>
                                                    <td class="text-center"><input type="submit" name="addConfeccion" value="Agregar" class="btn btn-outline-primary"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                </tr>
			                                    <?php
			                                    //Mostrar datos de Confeccion
			                                    ?>
                                                </tbody>
                                            </table>
                                        </form>
                                    </div>
                                    <div class="tab-pane <?php echo $activoAcondicionamiento;?>" id="acondicionamiento" role="tabpanel">
                                        <div class="spacer20"></div>
                                        <form method="post" action="#">
                                            <input type="hidden" name="idProductoCrear" value="<?php echo $_POST['idProductoCrear']?>">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">Componente</th>
                                                    <th class="text-center">Insumo</th>
                                                    <th class="text-center">Cantidad</th>
                                                    <th class="text-center">Máquina</th>
                                                    <th class="text-center">Observaciones</th>
                                                    <th class="text-center">Tiempo</th>
                                                    <th class="text-center">Acciones</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td><select name="selectComponente" class="form-control" onchange="getMaterial(this.value)">
                                                            <option selected disabled>Seleccionar</option>
						                                    <?php
						                                    $query = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idProducto = '{$_POST['idProductoCrear']}'");
						                                    while($row = mysqli_fetch_array($query)){
							                                    $query2 = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE idComponente = '{$row['idComponente']}'");
							                                    while($row2 = mysqli_fetch_array($query2)){
								                                    echo "<option value='{$row['idComponenteEspecifico']}'>{$row2['descripcion']}</option>";
							                                    }
						                                    }
						                                    ?>
                                                        </select></td>
                                                    <td><select name="selectInsumo" class="form-control">
                                                            <option selected disabled>Seleccionar</option>

                                                        </select></td>
                                                    <td><input type="text" name="cantidad" class="form-control"></td>
                                                    <td><select name="selectMaquina" class="form-control">
                                                            <option selected disabled>Seleccionar</option>

                                                        </select></td>
                                                    <td><input type="text" name="observaciones" class="form-control"></td>
                                                    <td><input type="number" min="0" step="0.01" name="tiempo" class="form-control"></td>
                                                    <td class="text-center"><input type="submit" name="addAcondicionamiento" value="Agregar" class="btn btn-outline-primary"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                </tr>
			                                    <?php
			                                    //Mostrar datos de Acondicionamiento
			                                    ?>
                                                </tbody>
                                            </table>
                                        </form>
                                    </div>
                                    <div class="tab-pane <?php echo $activoOtros;?>" id="otros" role="tabpanel">
                                        <div class="spacer20"></div>
                                        <form method="post" action="#">
                                            <input type="hidden" name="idProductoCrear" value="<?php echo $_POST['idProductoCrear']?>">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">Componente</th>
                                                    <th class="text-center">Procedimiento</th>
                                                    <th class="text-center">Máquina</th>
                                                    <th class="text-center">Observaciones</th>
                                                    <th class="text-center">Tiempo</th>
                                                    <th class="text-center">Acciones</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td><select name="selectComponente" class="form-control" onchange="getMaterial(this.value)">
                                                            <option selected disabled>Seleccionar</option>
						                                    <?php
						                                    $query = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idProducto = '{$_POST['idProductoCrear']}'");
						                                    while($row = mysqli_fetch_array($query)){
							                                    $query2 = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE idComponente = '{$row['idComponente']}'");
							                                    while($row2 = mysqli_fetch_array($query2)){
								                                    echo "<option value='{$row['idComponenteEspecifico']}'>{$row2['descripcion']}</option>";
							                                    }
						                                    }
						                                    ?>
                                                        </select></td>
                                                    <td><select name="selectProcedimiento" class="form-control">
                                                            <option selected disabled>Seleccionar</option>

                                                        </select></td>
                                                    <td><select name="selectMaquina" class="form-control">
                                                            <option selected disabled>Seleccionar</option>

                                                        </select></td>
                                                    <td><input type="text" name="observaciones" class="form-control"></td>
                                                    <td><input type="number" min="0" step="0.01" name="tiempo" class="form-control"></td>
                                                    <td class="text-center"><input type="submit" name="addOtros" value="Agregar" class="btn btn-outline-primary"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                </tr>
			                                    <?php
			                                    //Mostrar datos de Otros
			                                    ?>
                                                </tbody>
                                            </table>
                                        </form>
                                    </div>
								</div>
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