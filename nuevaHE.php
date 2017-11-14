<?php
include('session.php');
if(isset($_SESSION['login'])){
	include('header.php');
	include('navbarAdmin.php');
	include('funciones.php');

	$idProd = idgen('P');
	?>

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
								<button name="addProducto" type="submit" form="formProducto" class="btn btn-light btn-sm" formaction="nuevaHE2.php">Guardar</button>
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
							<form method="post" id="formProducto">
								<input type="hidden" name="idProducto" value="<?php echo $idProd;?>">
								<div class="tab-content">
									<div class="tab-pane active" id="general" role="tabpanel">
										<div class="spacer20"></div>
										<div class="form-group row">
											<label for="idCorto" class="col-2 col-form-label">ID Producto:</label>
											<div class="col-10">
												<input class="form-control" type="text" id="idCorto" name="idCorto" required>
											</div>
										</div>
										<div class="form-group row">
											<label for="idProvisional" class="col-2 col-form-label">ID Provisional Cliente:</label>
											<div class="col-10">
												<input class="form-control" type="text" id="idProvisional" name="idProvisional">
											</div>
										</div>

										<div class="form-group row">
											<label for="genero" class="col-2 col-form-label">Género:</label>
											<div class="col-6">
												<select class="form-control" name="genero" id="genero">
													<option disabled selected>Seleccionar</option>
													<?php
													$query = mysqli_query($link,"SELECT * FROM Genero");
													while($row = mysqli_fetch_array($query)){
														echo "<option value='{$row['idTipoProducto']}'>{$row['descripcion']}</option>";
													}
													?>
												</select>
											</div>
										</div>
										<div class="form-group row">
											<label for="tipoProducto" class="col-2 col-form-label">Tipo de Producto:</label>
											<div class="col-6">
												<select class="form-control" name="tipoProducto" id="tipoProducto">
													<option disabled selected>Seleccionar</option>
													<?php
													$query = mysqli_query($link,"SELECT * FROM TipoProducto");
													while($row = mysqli_fetch_array($query)){
														echo "<option value='{$row['idTipoProducto']}'>{$row['descripcion']}</option>";
													}
													?>
												</select>
											</div>
											<div class="col-2">
												<button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modalCategoria">Agregar Tipo de Producto</button>
											</div>
										</div>
										<div class="form-group row">
											<label for="codificacionTalla" class="col-2 col-form-label">Codificación de Talla:</label>
											<div class="col-6">
												<select class="form-control" name="codificacionTalla" id="codificacionTalla">
													<option disabled selected>Seleccionar</option>
													<?php
													$query = mysqli_query($link,"SELECT * FROM codificacionTalla");
													while($row = mysqli_fetch_array($query)){
														echo "<option value='{$row['idcodificacionTalla']}'>{$row['descripcion']}</option>";
													}
													?>
												</select>
											</div>
											<div class="col-2">
												<button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modalCategoria">Agregar Codificación de Talla</button>
											</div>
										</div>
										<div class="form-group row">
											<label for="idCliente" class="col-2 col-form-label">Cliente:</label>
											<div class="col-6">
												<select class="form-control" name="idCliente" id="idCliente">
													<option disabled selected>Seleccionar</option>
													<?php
													$query = mysqli_query($link,"SELECT * FROM Cliente WHERE estado = 1");
													while($row = mysqli_fetch_array($query)){
														echo "<option value='{$row['idCliente']}'>{$row['nombre']}</option>";
													}
													?>
												</select>
											</div>
											<div class="col-2">
												<button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modalSubcategoria">Agregar Cliente</button>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="medidas" role="tabpanel">
										<div class="spacer20"></div>
										<div class="form-group row">
											<label for="stockReposicion" class="col-2 col-form-label">Stock de Reposición:</label>
											<div class="col-10">
												<input class="form-control" type="text" id="stockReposicion" name="stockReposicion">
											</div>
										</div>
									</div>
									<div class="tab-pane" id="componentes" role="tabpanel">
										<div class="spacer20"></div>
										<div class="form-group row">
											<label for="unidadMedida" class="col-2 col-form-label">Unidad de Medida:</label>
											<div class="col-10">
												<select class="form-control" name="unidadMedida" id="unidadMedida">
													<option disabled selected>Seleccionar</option>
													<?php
													$query = mysqli_query($link,"SELECT * FROM UnidadMedida");
													while($row = mysqli_fetch_array($query)){
														echo "<option value='{$row['idUnidadMedida']}'>{$row['descripcion']}</option>";
													}
													?>
												</select>
											</div>
										</div>
										<div class="form-group row">
											<label for="color" class="col-2 col-form-label">Atributo:</label>
											<div class="col-10">
												<input class="form-control" type="text" id="color" name="color">
											</div>
										</div>
										<div class="form-group row">
											<label for="tamano" class="col-2 col-form-label">Tamaño:</label>
											<div class="col-6">
												<select class="form-control" name="tamano" id="tamano">
													<option disabled selected>Seleccionar</option>
													<?php
													$query = mysqli_query($link,"SELECT * FROM Tamaño");
													while($row = mysqli_fetch_array($query)){
														echo "<option value='{$row['idTamaño']}'>{$row['nombre']}</option>";
													}
													?>
												</select>
											</div>
										</div>
										<div class="form-group row">
											<label for="genero" class="col-2 col-form-label">Género:</label>
											<div class="col-6">
												<select class="form-control" name="genero" id="genero">
													<option disabled selected>Seleccionar</option>
													<?php
													$query = mysqli_query($link,"SELECT * FROM Genero");
													while($row = mysqli_fetch_array($query)){
														echo "<option value='{$row['idGenero']}'>{$row['descripcion']}</option>";
													}
													?>
												</select>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="url" role="tabpanel">
										<div class="spacer20"></div>
										<div class="form-group row">
											<label for="urlImagen" class="col-2 col-form-label">URL Imágen:</label>
											<div class="col-10">
												<input class="form-control" type="text" id="urlImagen" name="urlImagen">
											</div>
										</div>
										<div class="form-group row">
											<label for="urlProducto" class="col-2 col-form-label">URL Producto:</label>
											<div class="col-10">
												<input class="form-control" type="text" id="urlProducto" name="urlProducto">
											</div>
										</div>
									</div>
								</div>
							</form>
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