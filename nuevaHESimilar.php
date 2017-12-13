<?php
include('session.php');
if(isset($_SESSION['login'])){
	include('header.php');
	include('navbarAdmin.php');
	include('funciones.php');
	include('declaracionFechas.php');
	?>

	<form method="post" id="formProducto" action="#">
		<?php
		if(isset($_POST['addProductoSimilar'])){
			echo "<input type='hidden' name='idProductoSimilar' value='{$_POST['idProductoCrear']}'>";
		}
		?>
		<section class="container">
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header card-inverse card-info">
							<div class="float-left mt-1">
								<i class="fa fa-shopping-bag"></i>
								&nbsp;&nbsp;Datos Generales
							</div>
							<div class="float-right">
								<div class="dropdown">
									<input name="addProducto" type="submit" form="formProducto" class="btn btn-light btn-sm" formaction="nuevaHE2.php" value="Guardar">
								</div>
							</div>
						</div>
						<div class="card-block">
							<div class="col-12">
								<div class="spacer20"></div>
								<div class="form-group row">
									<label for="idProductoCrear" class="col-2 col-form-label">ID Producto:</label>
									<div class="col-10">
										<input class="form-control" type="text" id="idProductoCrear" name="idProductoCrear" value="<?php if(isset($_POST['idProductoCrear'])){echo $_POST['idProductoCrear'];}?>">
									</div>
								</div>
								<div class="form-group row">
									<label for="idProvisional" class="col-2 col-form-label">ID Provisional Cliente:</label>
									<div class="col-10">
										<input class="form-control" type="text" id="idProvisional" name="idProvisional" value="<?php if(isset($_POST['idProvisional'])){echo $_POST['idProvisional'];}?>">
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