<?php
include('session.php');
if(isset($_SESSION['login'])){
	include('header.php');
	include('navbarAdmin.php');
	include('funciones.php');
	include('declaracionFechas.php');
	$flag = true;

	if(isset($_POST['addProducto'])){
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
	}


		if($flag){

			// Éxito en la creación del producto

			if(isset($_POST['addProducto'])) {
				if (isset($_POST['idProvisional'])) {
					$idProvisional = $_POST['idProvisional'];
				} else {
					$idProvisional = null;
				}

				if (isset($_POST['observaciones'])) {
					$observaciones = $_POST['observaciones'];
				} else {
					$observaciones = null;
				}

				if (isset($_POST['descripcionGeneral'])) {
					$descripcionGeneral = $_POST['descripcionGeneral'];
				} else {
					$descripcionGeneral = null;
				}

				$insert = mysqli_query($link, "INSERT INTO Producto VALUES ('{$_POST['idProductoCrear']}','{$_POST['idCorto']}','{$_POST['tipoProducto']}','{$_POST['idCliente']}',
												'{$_SESSION['user']}','{$_POST['genero']}','{$_POST['codificacionTalla']}','{$idProvisional}','{$date}',
												'{$observaciones}','{$descripcionGeneral}',1)");

				$queryPerformed = "INSERT INTO Producto VALUES ({$_POST['idProductoCrear']},{$_POST['idCorto']},{$_POST['tipoProducto']},{$_POST['idCliente']},
							   {$_SESSION['user']},{$_POST['genero']},{$_POST['codificacionTalla']},{$idProvisional},{$date},
							   {$observaciones},{$descripcionGeneral},1)";

				$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT PRODUCTO','INSERT','{$queryPerformed}')");
			}
			?>

			<form method="post" action="nuevaHE2.php">
				<section class="container">
					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-header card-inverse card-info">
									<div class="float-left mt-1">
										<i class="fa fa-pencil"></i>
										&nbsp;&nbsp;Especificaciones
									</div>
									<div class="float-right">
										<div class="dropdown">
											<input name="addProductoMedidasComp" type="submit" class="btn btn-light btn-sm" formaction="nuevaHE3.php" value="Guardar">
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
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th class="text-center">Medida</th>
                                                        <?php
                                                        $search = mysqli_query($link,"SELECT * FROM Producto WHERE idProducto = '{$_POST['idProductoCrear']}'");
                                                        while($index = mysqli_fetch_array($search)){
                                                            $idCodificacionTalla = $index['idcodificacionTalla'];
	                                                        //$search2 = mysqli_query($link,"SELECT * FROM Talla WHERE idcodificacionTalla = '{$index['idcodificacionTalla']}' ORDER BY indice ASC");
	                                                        $search2 = mysqli_query($link,"SELECT * FROM Talla WHERE idcodificacionTalla = '{$index['idcodificacionTalla']}'");
	                                                        while($index2 = mysqli_fetch_array($search2)){
	                                                            echo "<th class=\"text-center\" style='width:6%;'>{$index2['descripcion']}</th>";
                                                            }
                                                        }
                                                        ?>
                                                        <th class="text-center" style="width: 6%">T(+/-)</th>
                                                        <th class="text-center">Observación</th>
                                                        <th class="text-center"></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <?php
                                                        echo "<td><select name='selectMedida' class='form-control' autofocus>";
                                                        $result2 = mysqli_query($link,"SELECT * FROM Medida");
                                                        while ($fila2 = mysqli_fetch_array($result2)){
	                                                        echo "<option value='".$fila2['idMedida']."'>".$fila2['descripcion']."</option>";
                                                        }
                                                        echo "</select></td>";
                                                        $search = mysqli_query($link,"SELECT * FROM Talla WHERE idcodificacionTalla = '{$idCodificacionTalla}'");
                                                        while($index = mysqli_fetch_array($search)){
	                                                        echo "<td class='text-center'><input type='text' class='form-control' name='{$index['idTalla']}'></td>";
                                                        }
                                                        ?>
                                                        <td class="text-center"><input type="text" class="form-control" name="tolerancia"></td>
                                                        <td class="text-center"><input type="text" class="form-control" name="observacion"></td>
                                                        <td class="text-center"><input type="submit" name="Agregar" value="Agregar" class="btn btn-outline-primary"></td>
                                                        <input type="hidden" name="idProductoCrear" value="<?php echo $_POST['idProductoCrear']?>">
                                                    </tr>
                                                    <?php
                                                    //Llenar tabla
                                                    ?>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">Profundidad de Escote Delantero</td>
                                                        <td class="text-center">7</td>
                                                        <td class="text-center">10</td>
                                                        <td class="text-center">13</td>
                                                        <td class="text-center">16</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">22</td>
                                                        <td class="text-center">25</td>
                                                        <td class="text-center">-</td>
                                                        <td class="text-center">1</td>
                                                        <td class="text-center">Esta es una observación de prueba</td>
                                                        <td>
                                                                <div class=\"dropdown\">
                                                                    <input type='hidden' name='idProducto' value='".$row['idProducto']."'>
                                                                    <input type='hidden' name='volver' value='gestionProductos.php'>
                                                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    Acciones
                                                                    </button>
                                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                        <button name='nuevoProducto' class="dropdown-item" type="submit" formaction='nuevoProductoPlantilla.php'>Subir</button>
                                                                        <button name='verProducto' class="dropdown-item" type="submit" formaction='detalleProducto.php'>Bajar</button>
                                                                        <button name='verProducto' class="dropdown-item" type="submit" formaction='detalleProducto.php'>Eliminar</button>
                                                                    </div>
                                                                </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">Profundidad de Escote Delantero</td>
                                                        <td class="text-center">7</td>
                                                        <td class="text-center">10</td>
                                                        <td class="text-center">13</td>
                                                        <td class="text-center">16</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">22</td>
                                                        <td class="text-center">25</td>
                                                        <td class="text-center">-</td>
                                                        <td class="text-center">1</td>
                                                        <td class="text-center">Esta es una observación de prueba</td>
                                                        <td>
                                                            <div class=\"dropdown\">
                                                                <input type='hidden' name='idProducto' value='".$row['idProducto']."'>
                                                                <input type='hidden' name='volver' value='gestionProductos.php'>
                                                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    Acciones
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                    <button name='nuevoProducto' class="dropdown-item" type="submit" formaction='nuevoProductoPlantilla.php'>Subir</button>
                                                                    <button name='verProducto' class="dropdown-item" type="submit" formaction='detalleProducto.php'>Bajar</button>
                                                                    <button name='verProducto' class="dropdown-item" type="submit" formaction='detalleProducto.php'>Eliminar</button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">Profundidad de Escote Delantero</td>
                                                        <td class="text-center">7</td>
                                                        <td class="text-center">10</td>
                                                        <td class="text-center">13</td>
                                                        <td class="text-center">16</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">22</td>
                                                        <td class="text-center">25</td>
                                                        <td class="text-center">-</td>
                                                        <td class="text-center">1</td>
                                                        <td class="text-center">Esta es una observación de prueba</td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <input type='hidden' name='idProducto' value='<?php echo $row['idProducto'];?>'>
                                                                <input type='hidden' name='volver' value='gestionProductos.php'>
                                                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    Acciones
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                    <button name='nuevoProducto' class="dropdown-item" type="submit" formaction='nuevoProductoPlantilla.php'>Subir</button>
                                                                    <button name='verProducto' class="dropdown-item" type="submit" formaction='detalleProducto.php'>Bajar</button>
                                                                    <button name='verProducto' class="dropdown-item" type="submit" formaction='detalleProducto.php'>Eliminar</button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <div class="spacer20"></div>
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

	?>

	<?php
	include('footer.php');
}
?>