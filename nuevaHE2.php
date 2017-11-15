<?php
include('session.php');
if(isset($_SESSION['login'])){
	include('header.php');
	include('navbarAdmin.php');
	include('funciones.php');
	include('declaracionFechas.php');

	if(isset($_POST['addProducto'])){
		$flag = true;

		if($_POST['idCorto'] == ''){
			$flag = false;
		}

		$search = mysqli_query($link,"SELECT * FROM Producto WHERE idCorto = '{$_POST['idCorto']}'");
		while($index = mysqli_fetch_array($search)){
			$flag = false;
		}

		if(!isset($_POST['genero'])){
			$flag = false;
		}

		if(!isset($_POST['tipoProducto'])){
			$flag = false;
		}

		if(!isset($_POST['codificacionTalla'])){
			$flag = false;
		}

		if(!isset($_POST['idCliente'])){
			$flag = false;
		}

		if($flag){

			// Éxito en la creación del producto

			if(isset($_POST['idProvisional'])){
				$idProvisional = $_POST['idProvisional'];
			}else{
				$idProvisional = null;
			}

			if(isset($_POST['observaciones'])){
				$observaciones = $_POST['observaciones'];
			}else{
				$observaciones = null;
			}

			if(isset($_POST['descripcionGeneral'])){
				$descripcionGeneral = $_POST['descripcionGeneral'];
			}else{
				$descripcionGeneral = null;
			}

			$insert = mysqli_query($link,"INSERT INTO Producto VALUES ('{$_POST['idProductoCrear']}','{$_POST['idCorto']}','{$_POST['tipoProducto']}','{$_POST['idCliente']}',
												'{$_SESSION['user']}','{$_POST['genero']}','{$_POST['codificacionTalla']}','{$idProvisional}','{$date}',
												'{$observaciones}','{$descripcionGeneral}',1)");

			$queryPerformed = "INSERT INTO Producto VALUES ({$_POST['idProductoCrear']},{$_POST['idCorto']},{$_POST['tipoProducto']},{$_POST['idCliente']},
							   {$_SESSION['user']},{$_POST['genero']},{$_POST['codificacionTalla']},{$idProvisional},{$date},
							   {$observaciones},{$descripcionGeneral},1)";

			$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT PRODUCTO','INSERT','{$queryPerformed}')");
			?>

			<form method="post" action="nuevaHE.php">
				<section class="container">
					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-header card-inverse card-info">
									<div class="float-left mt-1">
										<i class="fa fa-warning"></i>
										&nbsp;&nbsp;Especificaciones
									</div>
									<div class="float-right">
										<div class="dropdown">
											<input name="volver" type="submit" class="btn btn-light btn-sm" formaction="nuevaHE.php" value="Volver">
										</div>
									</div>
								</div>
								<div class="card-block">
									<div class="col-12">
										<div class="spacer20"></div>
										<ul class="nav nav-tabs" role="tablist">
											<li class="nav-item">
												<a class="nav-link active" data-toggle="tab" href="#medidas" role="tab">Medidas y Tallas</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" data-toggle="tab" href="#componentes" role="tab">Componentes y Partes</a>
											</li>
										</ul>
										<div class="tab-content">
											<div class="tab-pane active" id="medidas" role="tabpanel">
												<div class="spacer20"></div>
												<div class="form-group row">
													<label for="nombreCorto" class="col-2 col-form-label">Nombre Corto:</label>
													<div class="col-10">
														<input class="form-control" type="text" id="nombreCorto" name="nombreCorto">
													</div>
												</div>
											</div>
											<div class="tab-pane" id="componentes" role="tabpanel">
												<div class="spacer20"></div>
												<div class="form-group row">
													<label for="stockReposicion" class="col-2 col-form-label">Stock de Reposición:</label>
													<div class="col-10">
														<input class="form-control" type="text" id="stockReposicion" name="stockReposicion">
													</div>
												</div>
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
		}else{

			//  Error en la creación del producto
			?>

			<form method="post" action="nuevaHE.php">
			<section class="container">
				<div class="row">
					<div class="col-6 offset-3">
						<div class="card">
							<div class="card-header card-inverse card-info">
								<div class="float-left mt-1">
									<i class="fa fa-warning"></i>
									&nbsp;&nbsp;Mensaje de Error
								</div>
								<div class="float-right">
									<div class="dropdown">
										<input name="volver" type="submit" class="btn btn-light btn-sm" formaction="nuevaHE.php" value="Volver">
									</div>
								</div>
							</div>
							<div class="card-block">
								<div class="col-12">
									<div class="spacer20"></div>
									<h6 class="text-center">Ha ocurrido un error en el ingreso de datos del producto. Por favor revise que toda la información haya sido ingresada correctamente
									y que el ID del producto sea único y vuelva a intentarlo nuevamente.</h6>
									<div class="spacer20"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			</form>

			<?php
		}
	}

	?>

		<!--CONTENIDO-->

	<?php
	include('footer.php');
}
?>