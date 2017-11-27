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

		$search = mysqli_query($link,"SELECT * FROM Producto WHERE idProducto = '{$_POST['idCorto']}'");
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

				$insert = mysqli_query($link, "INSERT INTO Producto VALUES ('{$_POST['idProductoCrear']}','{$_POST['tipoProducto']}','{$_POST['idCliente']}',
												'{$_SESSION['user']}','{$_POST['genero']}','{$_POST['codificacionTalla']}',1,'{$idProvisional}','{$date}',
												'{$observaciones}','{$descripcionGeneral}')");

				$queryPerformed = "INSERT INTO Producto VALUES ({$_POST['idProductoCrear']},{$_POST['tipoProducto']},{$_POST['idCliente']},
												{$_SESSION['user']},{$_POST['genero']},{$_POST['codificacionTalla']},1,{$idProvisional},{$date},
												{$observaciones},{$descripcionGeneral})";

				$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT PRODUCTO','INSERT','{$queryPerformed}')");
			}

			if(isset($_POST['insertar'])){
				$query = mysqli_query($link,"SELECT * FROM ProductoMedida WHERE idProducto = '{$_POST['idProductoCrear']}' AND idMedida = '{$_POST['medidaSelect']}'");
				while($row = mysqli_fetch_array($query)){
				    $indiceInsertar = $row['indice'];
				}
				echo "<section class='container'>
                        <div class='alert alert-info' role='alert'>
                            Insertar en la fila ".($indiceInsertar+1)." activado.
                        </div>
                    </section>";
			}

			if(isset($_POST['addMedida'])){
			    $aux = 0;

				$query2 = mysqli_query($link,"SELECT DISTINCT idMedida FROM TallaMedida WHERE idProducto = '{$_POST['idProductoCrear']}'");
				while($row2 = mysqli_fetch_row($query2)){
					$aux++;
				}

				if(isset($_POST['insertFila']) && $_POST['insertFila'] != 'NA'){
				    $aux = $_POST['insertFila'];

					$query = mysqli_query($link,"SELECT * FROM ProductoMedida WHERE idProducto = '{$_POST['idProductoCrear']}' AND indice > '{$aux}' ORDER BY indice DESC");
					while($row = mysqli_fetch_array($query)){
						$indiceSup = $row['indice'] + 1;
						$update = mysqli_query($link, "UPDATE ProductoMedida SET indice = '{$indiceSup}' WHERE idProducto = '{$_POST['idProductoCrear']}' AND indice = '{$row['indice']}'");
						$queryPerformed = "UPDATE ProductoMedida SET indice = {$indiceSup} WHERE idProducto = {$_POST['idProductoCrear']} AND indice = {$row['indice']}";
						$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','FIX INDEX AFTER INSERT PRODUCTOMEDIDA','UPDATE','{$queryPerformed}')");
					}

					$aux++;
                }

			    $insert = mysqli_query($link,"INSERT INTO ProductoMedida VALUES ('{$_POST['idProductoCrear']}','{$_POST['selectMedida']}','{$_POST['tolerancia']}','{$_POST['observacion']}','{$aux}')");

			    $queryPerformed = "INSERT INTO ProductoMedida VALUES ({$_POST['idProductoCrear']},{$_POST['selectMedida']},{$_POST['tolerancia']},{$_POST['observacion']},{$aux})";

				$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT PRODUCTOMEDIDA','INSERT','{$queryPerformed}')");

				$query = mysqli_query($link,"SELECT * FROM Talla WHERE idcodificacionTalla = '{$_POST['idCodificacionTalla']}'");
				while($row = mysqli_fetch_array($query)){
				    $addVar = "add".$row['idTalla'];
				    if(isset($_POST[$addVar])){
				        $insert = mysqli_query($link, "INSERT INTO TallaMedida VALUES ('{$_POST['idProductoCrear']}','{$row['idTalla']}','{$_POST['selectMedida']}','{$_POST[$addVar]}')");

				        $queryPerformed = "INSERT INTO TallaMedida VALUES ({$_POST['idProductoCrear']},{$row['idTalla']},{$_POST['selectMedida']},{$_POST[$addVar]})";

					    $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT TALLAMEDIDA','INSERT','{$queryPerformed}')");
                    }
                }
            }

            if(isset($_POST['bajar'])){
			    $flag = false;

	            $query = mysqli_query($link,"SELECT * FROM ProductoMedida WHERE idProducto = '{$_POST['idProductoCrear']}' AND idMedida = '{$_POST['medidaSelect']}'");
			    while ($row = mysqli_fetch_array($query)){
			        $indice = $row['indice'];
                }

                $indiceSup = $indice+1;

			    $query = mysqli_query($link,"SELECT * FROM ProductoMedida WHERE idProducto = '{$_POST['idProductoCrear']}' AND indice = '{$indiceSup}'");
			    while ($row = mysqli_fetch_array($query)){
			        $flag = true;
                }

                if($flag){
	                $update = mysqli_query($link, "UPDATE ProductoMedida SET indice = -1 WHERE indice = '{$indice}'");
	                $queryPerformed = "UPDATE ProductoMedida SET indice = -1 WHERE indice = {$indice}";
	                $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','SUBIR PRODUCTOMEDIDA','UPDATE','{$queryPerformed}')");

	                $update = mysqli_query($link, "UPDATE ProductoMedida SET indice = '{$indice}' WHERE indice = '{$indiceSup}'");
	                $queryPerformed = "UPDATE ProductoMedida SET indice = {$indice} WHERE indice = {$indiceSup}";
	                $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','SUBIR PRODUCTOMEDIDA','UPDATE','{$queryPerformed}')");

	                $update = mysqli_query($link, "UPDATE ProductoMedida SET indice = '{$indiceSup}' WHERE indice = -1");
	                $queryPerformed = "UPDATE ProductoMedida SET indice = {$indiceSup} WHERE indice = -1";
	                $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','SUBIR PRODUCTOMEDIDA','UPDATE','{$queryPerformed}')");
                }
            }

			if(isset($_POST['subir'])){
				$flag = false;

				$query = mysqli_query($link,"SELECT * FROM ProductoMedida WHERE idProducto = '{$_POST['idProductoCrear']}' AND idMedida = '{$_POST['medidaSelect']}'");
				while ($row = mysqli_fetch_array($query)){
					$indice = $row['indice'];
				}

				$indiceSup = $indice-1;

				$query = mysqli_query($link,"SELECT * FROM ProductoMedida WHERE idProducto = '{$_POST['idProductoCrear']}' AND indice = '{$indiceSup}'");
				while ($row = mysqli_fetch_array($query)){
					$flag = true;
				}

				if($flag){
					$update = mysqli_query($link, "UPDATE ProductoMedida SET indice = -1 WHERE indice = '{$indice}'");
					$queryPerformed = "UPDATE ProductoMedida SET indice = -1 WHERE indice = {$indice}";
					$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','SUBIR PRODUCTOMEDIDA','UPDATE','{$queryPerformed}')");

					$update = mysqli_query($link, "UPDATE ProductoMedida SET indice = '{$indice}' WHERE indice = '{$indiceSup}'");
					$queryPerformed = "UPDATE ProductoMedida SET indice = {$indice} WHERE indice = {$indiceSup}";
					$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','SUBIR PRODUCTOMEDIDA','UPDATE','{$queryPerformed}')");

					$update = mysqli_query($link, "UPDATE ProductoMedida SET indice = '{$indiceSup}' WHERE indice = -1");
					$queryPerformed = "UPDATE ProductoMedida SET indice = {$indiceSup} WHERE indice = -1";
					$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','SUBIR PRODUCTOMEDIDA','UPDATE','{$queryPerformed}')");
				}
			}

			if(isset($_POST['eliminar'])){
				$query = mysqli_query($link,"SELECT * FROM ProductoMedida WHERE idProducto = '{$_POST['idProductoCrear']}' AND idMedida = '{$_POST['medidaSelect']}'");
				while($row = mysqli_fetch_array($query)){
				    $indice = $row['indice'];
                }

                $delete = mysqli_query($link,"DELETE FROM ProductoMedida WHERE idProducto = '{$_POST['idProductoCrear']}' AND idMedida = '{$_POST['medidaSelect']}'");
				$queryPerformed = "DELETE FROM ProductoMedida WHERE idProducto = {$_POST['idProductoCrear']} AND idMedida = {$_POST['medidaSelect']}";
				$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','DELETE PRODUCTOMEDIDA','DELETE','{$queryPerformed}')");

				$delete = mysqli_query($link,"DELETE FROM TallaMedida WHERE idProducto = '{$_POST['idProductoCrear']}' AND idMedida = '{$_POST['medidaSelect']}'");
				$queryPerformed = "DELETE FROM TallaMedida WHERE idProducto = {$_POST['idProductoCrear']} AND idMedida = {$_POST['medidaSelect']}";
				$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','DELETE TALLAMEDIDA','DELETE','{$queryPerformed}')");

				$query = mysqli_query($link,"SELECT * FROM ProductoMedida WHERE idProducto = '{$_POST['idProductoCrear']}' AND indice > '{$indice}' ORDER BY indice ASC");
				while($row = mysqli_fetch_array($query)){
				    $indiceSup = $row['indice'] - 1;
				    $update = mysqli_query($link, "UPDATE ProductoMedida SET indice = '{$indiceSup}' WHERE idProducto = '{$_POST['idProductoCrear']}' AND indice = '{$row['indice']}'");
					$queryPerformed = "UPDATE ProductoMedida SET indice = {$indiceSup} WHERE idProducto = {$_POST['idProductoCrear']} AND indice = {$row['indice']}";
					$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','FIX INDEX AFTER DELETE PRODUCTOMEDIDA','UPDATE','{$queryPerformed}')");
                }
			}
			?>


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
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th class="text-center" colspan="2">Medida</th>
                                                        <?php
                                                        $search = mysqli_query($link,"SELECT * FROM Producto WHERE idProducto = '{$_POST['idProductoCrear']}'");
                                                        while($index = mysqli_fetch_array($search)){
                                                            $idCodificacionTalla = $index['idcodificacionTalla'];
	                                                        //$search2 = mysqli_query($link,"SELECT * FROM Talla WHERE idcodificacionTalla = '{$index['idcodificacionTalla']}' ORDER BY indice ASC");
	                                                        $search2 = mysqli_query($link,"SELECT * FROM Talla WHERE idcodificacionTalla = '{$index['idcodificacionTalla']}'");
	                                                        while($index2 = mysqli_fetch_array($search2)){
	                                                            echo "<th class=\"text-center\" style='width:6.5%;'>{$index2['descripcion']}</th>";
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
                                                        <form method="post" action="#">
                                                        <?php
                                                        echo "<td colspan='2'><select name='selectMedida' class='form-control' autofocus>";
                                                        $result2 = mysqli_query($link,"SELECT * FROM Medida ORDER BY descripcion ASC");
                                                        while ($fila2 = mysqli_fetch_array($result2)){
	                                                        echo "<option value='".$fila2['idMedida']."'>".$fila2['descripcion']."</option>";
                                                        }
                                                        echo "</select></td>";
                                                        $search = mysqli_query($link,"SELECT * FROM Talla WHERE idcodificacionTalla = '{$idCodificacionTalla}'");
                                                        while($index = mysqli_fetch_array($search)){
	                                                        echo "<td class='text-center'><input type='number' min='0' class='form-control' name='add{$index['idTalla']}'></td>";
                                                        }
                                                        ?>
                                                        <td class="text-center"><input type="number" min="0" class="form-control" name="tolerancia"></td>
                                                        <td class="text-center"><input type="text" class="form-control" name="observacion"></td>
                                                        <td class="text-center"><input type="submit" name="addMedida" value="Agregar" class="btn btn-outline-primary"></td>
                                                        <input type="hidden" name="idCodificacionTalla" value="<?php echo $idCodificacionTalla;?>">
                                                        <input type="hidden" name="insertFila" value="<?php if(isset($indiceInsertar)){echo $indiceInsertar;}else{echo 'NA';}?>">
                                                        <input type="hidden" name="idProductoCrear" value="<?php echo $_POST['idProductoCrear']?>">
                                                        </form>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="13"></td>
                                                    </tr>
                                                    <?php
                                                    $result = mysqli_query($link , "SELECT * FROM ProductoMedida WHERE idProducto = '{$_POST['idProductoCrear']}' ORDER BY indice ASC");
                                                    while($row = mysqli_fetch_array($result)){
                                                        echo "<tr class='textoRed'>";
	                                                    echo "<td class='text-center'>{$row['idMedida']}</td>";
	                                                    $result2 = mysqli_query($link,"SELECT * FROM Medida WHERE idMedida = '{$row['idMedida']}'");
	                                                    while($row2 = mysqli_fetch_array($result2)){
	                                                        echo "<td class='text-center'>{$row2['descripcion']}</td>";
                                                        }
	                                                    $search = mysqli_query($link,"SELECT * FROM Talla WHERE idcodificacionTalla = '{$idCodificacionTalla}' ORDER BY indice ASC");
	                                                    while($index = mysqli_fetch_array($search)){
		                                                    $search2 = mysqli_query($link,"SELECT * FROM TallaMedida WHERE idProducto = '{$_POST['idProductoCrear']}' AND idTalla = '{$index['idTalla']}' AND idMedida = '{$row['idMedida']}'");
		                                                    while($index2 = mysqli_fetch_array($search2)){
		                                                        echo "<td class='text-center'>{$index2['valor']}</td>";
		                                                    }
	                                                    }
	                                                    echo "<td class='text-center'>{$row['tolerancia']}</td>";
	                                                    echo "<td class='text-center'>{$row['observacion']}</td>";
	                                                    echo "<td class='text-center'>
                                                                <form method='post' action='#'>
                                                                <div>
                                                                    <input type='hidden' name='idProductoCrear' value='{$_POST['idProductoCrear']}'>
                                                                    <input type='hidden' name='medidaSelect' value='{$row['idMedida']}'>
                                                                    <button class='btn btn-outline-secondary btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                                    Acciones</button>
                                                                    <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                                                        <input name='subir' class='dropdown-item' type='submit' formaction='#' value='Subir'>
                                                                        <input name='bajar' class='dropdown-item' type='submit' formaction='#' value='Bajar'>
                                                                        <input name='insertar' class='dropdown-item' type='submit' formaction='#' value='Insertar'>
                                                                        <input name='eliminar' class='dropdown-item' type='submit' formaction='#' value='Eliminar'>
                                                                    </div>
                                                                </div>
                                                                </form>
                                                              </td>";
	                                                    echo "</tr>";
                                                    }
                                                    ?>
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