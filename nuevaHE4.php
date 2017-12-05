<?php
include('session.php');
if(isset($_SESSION['login'])){
	include('header.php');
	include('navbarAdmin.php');
	include('funciones.php');
	include('declaracionFechas.php');

	if(isset($_POST['bajar'])){
		$flag = false;

		$indiceSup = $_POST['indice']+1;

		$query = mysqli_query($link,"SELECT * FROM PCPSPC WHERE idProducto = '{$_POST['idProductoCrear']}' AND indice = '{$indiceSup}'");
		while ($row = mysqli_fetch_array($query)){
			$flag = true;
		}
		$queryPerformed = "SELECT * FROM PCPSPC WHERE idProducto = {$_POST['idProductoCrear']} AND indice = {$indiceSup}";
		$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','BUSCAR INDICE SUPERIOR PCPSPC','SELECT','{$queryPerformed}')");

		if($flag){
			$update = mysqli_query($link, "UPDATE PCPSPC SET indice = -1 WHERE idProducto = '{$_POST['idProductoCrear']}' AND indice = '{$_POST['indice']}'");
			$queryPerformed = "UPDATE PCPSPC SET indice = -1 WHERE idProducto = {$_POST['idProductoCrear']} AND indice = {$_POST['indice']}";
			$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','BAJAR PCPSPC','UPDATE','{$queryPerformed}')");

			$update = mysqli_query($link, "UPDATE PCPSPC SET indice = '{$_POST['indice']}' WHERE idProducto = '{$_POST['idProductoCrear']}' AND indice = '{$indiceSup}'");
			$queryPerformed = "UPDATE PCPSPC SET indice = {$_POST['indice']} WHERE idProducto = {$_POST['idProductoCrear']} AND indice = {$indiceSup}";
			$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','BAJAR PCPSPC','UPDATE','{$queryPerformed}')");

			$update = mysqli_query($link, "UPDATE PCPSPC SET indice = '{$indiceSup}' WHERE idProducto = '{$_POST['idProductoCrear']}' AND indice = -1");
			$queryPerformed = "UPDATE PCPSPC SET indice = {$indiceSup} WHERE idProducto = {$_POST['idProductoCrear']} AND indice = -1";
			$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','BAJAR PCPSPC','UPDATE','{$queryPerformed}')");
		}
	}

	if(isset($_POST['subir'])){
		$flag = false;

		$indiceSup = $_POST['indice']-1;

		$query = mysqli_query($link,"SELECT * FROM PCPSPC WHERE idProducto = '{$_POST['idProductoCrear']}' AND indice = '{$indiceSup}'");
		while ($row = mysqli_fetch_array($query)){
			$flag = true;
		}

		if($flag){
			$update = mysqli_query($link, "UPDATE PCPSPC SET indice = -1 WHERE idProducto = '{$_POST['idProductoCrear']}' AND indice = '{$_POST['indice']}'");
			$queryPerformed = "UPDATE PCPSPC SET indice = -1 WHERE idProducto = {$_POST['idProductoCrear']} AND indice = {$_POST['indice']}";
			$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','SUBIR PCPSPC','UPDATE','{$queryPerformed}')");

			$update = mysqli_query($link, "UPDATE PCPSPC SET indice = '{$_POST['indice']}' WHERE idProducto = '{$_POST['idProductoCrear']}' AND indice = '{$indiceSup}'");
			$queryPerformed = "UPDATE PCPSPC SET indice = {$_POST['indice']} WHERE idProducto = {$_POST['idProductoCrear']} AND indice = {$indiceSup}";
			$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','SUBIR PCPSPC','UPDATE','{$queryPerformed}')");

			$update = mysqli_query($link, "UPDATE PCPSPC SET indice = '{$indiceSup}' WHERE idProducto = '{$_POST['idProductoCrear']}' AND indice = -1");
			$queryPerformed = "UPDATE PCPSPC SET indice = {$indiceSup} WHERE idProducto = {$_POST['idProductoCrear']} AND indice = -1";
			$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','SUBIR PCPSPC','UPDATE','{$queryPerformed}')");
		}
	}

	if(isset($_POST['eliminar'])){
		$delete = mysqli_query($link,"DELETE FROM PCPSPC WHERE idProducto = '{$_POST['idProductoCrear']}' AND indice = '{$_POST['indice']}'");
		$queryPerformed = "DELETE FROM PCPSPC WHERE idProducto = {$_POST['idProductoCrear']} AND indice = {$_POST['indice']}";
		$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','DELETE PCPSPC','DELETE','{$queryPerformed}')");

		$query = mysqli_query($link,"SELECT * FROM PCPSPC WHERE idProducto = '{$_POST['idProductoCrear']}' AND indice > '{$_POST['indice']}' ORDER BY indice ASC");
		while($row = mysqli_fetch_array($query)){
			$indiceSup = $row['indice'] - 1;
			$update = mysqli_query($link, "UPDATE PCPSPC SET indice = '{$indiceSup}' WHERE idProducto = '{$_POST['idProductoCrear']}' AND indice = '{$row['indice']}'");
			$queryPerformed = "UPDATE PCPSPC SET indice = {$indiceSup} WHERE idProducto = {$_POST['idProductoCrear']} AND indice = {$row['indice']}";
			$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','FIX INDEX AFTER DELETE PCPSPC','UPDATE','{$queryPerformed}')");
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
							&nbsp;&nbsp;Revisión de Secuencia de Procesos/Subprocesos
						</div>
						<div class="float-right">
							<div class="dropdown">
								<button name="volver" type="submit" class="btn btn-light btn-sm" form="formSiguiente" formaction="nuevaHE3.php">Volver</button>
								<button name="siguiente" type="submit" class="btn btn-light btn-sm" form="formSiguiente">Finalizar</button>
							</div>
						</div>
					</div>
					<form id="formSiguiente" method="post" action="mainAdmin.php">
						<input type="hidden" name="idProductoCrear" value="<?php echo $_POST['idProductoCrear']?>">
						<input type="hidden" name="volverHE4">
					</form>
					<div class="card-block">
						<div class="col-12">
							<div class="spacer20"></div>
									<table class="table table-bordered">
										<thead>
										<tr>
											<th class="text-center">Subproceso</th>
											<th class="text-center">Componente</th>
											<th class="text-center">Observaciones</th>
											<th class="text-center">Tiempo</th>
											<th class="text-center">Acciones</th>
										</tr>
										</thead>
										<tbody>
										<?php
										$flag = true;
										$indice = 0;
										$query = mysqli_query($link,"SELECT * FROM PCPSPC WHERE idProducto = '{$_POST['idProductoCrear']}' ORDER BY indice ASC, idSubProcesoCaracteristica ASC");
										while($row = mysqli_fetch_array($query)){
											if($indice != $row['indice']){$flag = true;}
											if($flag){
												$flag = false;
												$indice = $row['indice'];
												echo "<tr>";
												$query2 = mysqli_query($link,"SELECT * FROM SubProcesoCaracteristica WHERE idSubProcesoCaracteristica = '{$row['idSubProcesoCaracteristica']}'");
												while($row2 = mysqli_fetch_array($query2)){
													$query3 = mysqli_query($link,"SELECT * FROM SubProceso WHERE idProcedimiento = '{$row2['idProcedimiento']}'");
													while($row3 = mysqli_fetch_array($query3)){
														echo "<td class='text-center'>{$row3['descripcion']}</td>";
													}
												}
												$query2 = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idComponenteEspecifico = '{$row['idComponenteEspecifico']}'");
												while($row2 = mysqli_fetch_array($query2)){
													$query3 = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE idComponente = '{$row2['idComponente']}'");
													while($row3 = mysqli_fetch_array($query3)){
														echo "<td class='text-center'>{$row3['descripcion']}</td>";
													}
												}
											}
											$arrayValido = [6,7,11,12,17,18,23,24,29,30,34,35];
											foreach($arrayValido as $validez){
												if($row['idSubProcesoCaracteristica'] == $validez){
													echo "<td class='text-center'>{$row['valor']}</td>";
												}
											}
											$query2 = mysqli_query($link,"SELECT * FROM SubProcesoCaracteristica WHERE idSubProcesoCaracteristica = '{$row['idSubProcesoCaracteristica']}'");
											while($row2 = mysqli_fetch_array($query2)){
												if($row2['idCaracteristica'] == 7){
													echo "<td class='text-center'>
                                                                <form method='post' action='#' id='formMenu{$row['indice']}'>
                                                                <div>
                                                                    <input type='hidden' name='idProductoCrear' value='{$_POST['idProductoCrear']}' form='formMenu{$row['indice']}'>
                                                                    <input type='hidden' name='indice' value='{$row['indice']}' form='formMenu{$row['indice']}'>
                                                                    <button class='btn btn-outline-secondary btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                                    Acciones</button>
                                                                    <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                                                        <input name='subir' class='dropdown-item' type='submit' formaction='#' value='Subir' form='formMenu{$row['indice']}'>
                                                                        <input name='bajar' class='dropdown-item' type='submit' formaction='#' value='Bajar' form='formMenu{$row['indice']}'>
                                                                        <input name='eliminar' class='dropdown-item' type='submit' formaction='#' value='Eliminar' form='formMenu{$row['indice']}'>
                                                                    </div>
                                                                </div>
                                                                </form>
                                                              </td>";
													echo "</tr>";
												}
											}
										}
										?>
										</tbody>
									</table>
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