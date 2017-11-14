<?php
include('session.php');
if(isset($_SESSION['login'])){
	include('header.php');
	include('navbarAdmin.php');
	include('funciones.php');
	include('declaracionFechas.php');

	$idProd = idgen('P');

	if(isset($_POST['addTipoProducto'])){
		$insert = mysqli_query($link, "INSERT INTO TipoProducto(descripcion,tamanoLote) VALUES ('{$_POST['descripcionTipoProducto']}','{$_POST['tamanoLote']}')");

		$queryPerformed = "INSERT INTO TipoProducto VALUES ({$_POST['descripcionTipoProducto']},{$_POST['tamanoLote']})";

		$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$date}','INSERT TIPO PRODUCTO','INSERT','{$queryPerformed}')");
	}
	?>
    <form method="post" id="formProducto" action="#">
	<section class="container">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header card-inverse card-info">
						<div class="float-left">
							<i class="fa fa-shopping-bag"></i>
							&nbsp;&nbsp;Datos Generales
						</div>
						<div class="float-right">
							<div class="dropdown">
								<input name="addProducto" type="submit" form="formProducto" class="btn btn-light btn-sm" formaction="nuevaHE2.php" value="Guardar">
							</div>
						</div>
					</div>
					<div class="spacer10"></div>
					<div class="card-block">
						<div class="col-12">
							<ul class="nav nav-tabs" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" data-toggle="tab" href="#general" role="tab">General</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#medidas" role="tab">Medidas y Tallas</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#componentes" role="tab">Componentes, Partes y Materiales</a>
								</li>
							</ul>
								<input type="hidden" name="idProducto" value="<?php echo $idProd;?>">
								<div class="tab-content">
									<div class="tab-pane active" id="general" role="tabpanel">
										<div class="spacer20"></div>
										<div class="form-group row">
											<label for="idCorto" class="col-2 col-form-label">ID Producto:</label>
											<div class="col-10">
												<input class="form-control" type="text" id="idCorto" name="idCorto" value="<?php if(isset($_POST['idCorto'])){echo $_POST['idCorto'];}?>">
											</div>
										</div>
										<div class="form-group row">
											<label for="idProvisional" class="col-2 col-form-label">ID Provisional Cliente:</label>
											<div class="col-10">
												<input class="form-control" type="text" id="idProvisional" name="idProvisional" value="<?php if(isset($_POST['idProvisional'])){echo $_POST['idProvisional'];}?>">
											</div>
										</div>

										<div class="form-group row">
											<label for="genero" class="col-2 col-form-label">Género:</label>
											<div class="col-6">
												<select class="form-control" name="genero" id="genero">
                                                    <?php
                                                    if(isset($_POST['genero'])){
	                                                    $query = mysqli_query($link,"SELECT * FROM Genero WHERE idGenero = {$_POST['genero']}");
	                                                    while($row = mysqli_fetch_array($query)){
		                                                    echo "<option selected value='{$row['idgenero']}'>{$row['descripcion']}</option>";
	                                                    }
                                                    }else{
                                                        echo "<option disabled selected>Seleccionar</option>";
                                                    }

													$query = mysqli_query($link,"SELECT * FROM Genero");
													while($row = mysqli_fetch_array($query)){
														echo "<option value='{$row['idgenero']}'>{$row['descripcion']}</option>";
													}
													?>
												</select>
											</div>
										</div>
										<div class="form-group row">
											<label for="tipoProducto" class="col-2 col-form-label">Tipo de Producto:</label>
											<div class="col-6">
												<select class="form-control" name="tipoProducto" id="tipoProducto">
													<?php
													if(isset($_POST['tipoProducto'])){
														$query = mysqli_query($link,"SELECT * FROM TipoProducto WHERE idTipoProducto = {$_POST['tipoProducto']}");
														while($row = mysqli_fetch_array($query)){
															echo "<option selected value='{$row['idTipoProducto']}'>{$row['descripcion']}</option>";
														}
													}else{
														echo "<option disabled selected>Seleccionar</option>";
													}

													$query = mysqli_query($link,"SELECT * FROM TipoProducto");
													while($row = mysqli_fetch_array($query)){
														echo "<option value='{$row['idTipoProducto']}'>{$row['descripcion']}</option>";
													}
													?>
												</select>
											</div>
											<div class="col-2">
												<button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modalTipoProducto">Agregar Tipo de Producto</button>
											</div>
										</div>
										<div class="form-group row">
											<label for="codificacionTalla" class="col-2 col-form-label">Codificación de Talla:</label>
											<div class="col-6">
												<select class="form-control" name="codificacionTalla" id="codificacionTalla">
													<?php
													if(isset($_POST['codificacionTalla'])){
														$query = mysqli_query($link,"SELECT * FROM codificacionTalla WHERE idcodificacionTalla = {$_POST['codificacionTalla']}");
														while($row = mysqli_fetch_array($query)){
															echo "<option selected value='{$row['idcodificacionTalla']}'>{$row['descripcion']}</option>";
														}
													}else{
														echo "<option disabled selected>Seleccionar</option>";
													}

													$query = mysqli_query($link,"SELECT * FROM codificacionTalla");
													while($row = mysqli_fetch_array($query)){
														echo "<option value='{$row['idcodificacionTalla']}'>{$row['descripcion']}</option>";
													}
													?>
												</select>
											</div>
											<div class="col-2">
												<button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modalCodificacion">Agregar Codificación</button>
											</div>
                                            <div class="col-2">
                                                <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modalTalla">Agregar Tallas</button>
                                            </div>
										</div>
										<div class="form-group row">
											<label for="idCliente" class="col-2 col-form-label">Cliente:</label>
											<div class="col-6">
												<select class="form-control" name="idCliente" id="idCliente">
													<?php
													if(isset($_POST['idCliente'])){
														$query = mysqli_query($link,"SELECT * FROM Cliente WHERE idCliente = {$_POST['idCliente']}");
														while($row = mysqli_fetch_array($query)){
															echo "<option selected value='{$row['idCliente']}'>{$row['nombre']}</option>";
														}
													}else{
														echo "<option disabled selected>Seleccionar</option>";
													}

													$query = mysqli_query($link,"SELECT * FROM Cliente WHERE estado = 1");
													while($row = mysqli_fetch_array($query)){
														echo "<option value='{$row['idCliente']}'>{$row['nombre']}</option>";
													}
													?>
												</select>
											</div>
											<div class="col-2">
												<button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modalCliente">Agregar Cliente</button>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="medidas" role="tabpanel">
										<div class="spacer20"></div>

									</div>
									<div class="tab-pane" id="componentes" role="tabpanel">
										<div class="spacer20"></div>

									</div>
								</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

    <div class="modal fade" id="modalTipoProducto" tabindex="-1" role="dialog" aria-labelledby="modalTipoProducto" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Tipo de Producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                            <div class="form-group row">
                                <label class="col-form-label" for="descripcionTipoProducto">Nombre de Tipo de Producto:</label>
                                <input type="text" name="descripcionTipoProducto" id="descripcionTipoProducto" class="form-control">
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label" for="tamanoLote">Tamaño de Lote:</label>
                                <input type="text" name="tamanoLote" id="tamanoLote" class="form-control">
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="formProducto" value="Submit" name="addTipoProducto">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCodificacion" tabindex="-1" role="dialog" aria-labelledby="modalCodificacion" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Codificación de Talla</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                            <div class="form-group row">
                                <label class="col-form-label" for="codificacion">Nombre de Codificación:</label>
                                <input type="text" name="codificacion" id="codificacion" class="form-control">
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="formProducto" value="Submit" name="addCodificacion">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTalla" tabindex="-1" role="dialog" aria-labelledby="modalTalla" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Tallas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">

                            <div class="form-group row">
                                <label class="col-form-label" for="codificacion">Seleccionar Codificación:</label>
                                <select name="cofidicacion" id="codificacion" class="form-control">
                                    <option selected disabled>Seleccionar</option>
                                    <?php
                                    $search = mysqli_query($link, "SELECT * FROM codificacionTalla");
                                    while($index = mysqli_fetch_array($search)){
                                        echo "<option value='{$index['idcodificacionTalla']}'>{$index['descripcion']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label" for="talla">Sigla de Talla:</label>
                                <input type="text" name="talla" id="talla" class="form-control">
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="formProducto" value="Submit" name="addTalla">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>

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
                            <div class="form-group row">
                                <label class="col-form-label" for="ruc">RUC/DNI:</label>
                                <input type="text" name="ruc" id="ruc" class="form-control">
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label" for="razonSocial">Razón Social:</label>
                                <input type="text" name="razonSocial" id="razonSocial" class="form-control">
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="formProducto" value="Submit" name="addCliente">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>
    </form>

	<?php
	include('footer.php');
}
?>