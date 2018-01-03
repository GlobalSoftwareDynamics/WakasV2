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

	if(isset($_POST['submitFoto'])) {
	    $folder = "img/fotografias/{$_POST['idProductoCrear']}/";
		if (!file_exists($folder)) {
			mkdir("img/fotografias/{$_POST['idProductoCrear']}/", 0777, true);
        }
		$target_dir = "img/fotografias/{$_POST['idProductoCrear']}/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

		if ($uploadOk == 0) {
			echo "<div class='container'><span class='alert alert-danger col-md-8 col-md-offset-2'>Su fotografía no fue subida.</span></div><br>";
		} else {
			$i = 0;
			$dir = "img/fotografias/{$_POST['idProductoCrear']}/";
			if ($handle = opendir($dir)) {
				while (($file = readdir($handle)) !== false) {
					if (!in_array($file, array('.', '..')) && !is_dir($dir . $file))
						$i++;
				}
			}
			$temp = explode(".", $_FILES["fileToUpload"]["name"]);
			$newfilename = $_POST['idProductoCrear'].'.jpg';
			$destination = $target_dir . $newfilename;

			if ($uploadOk == 1) {
				if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $destination)) {
					echo "<section class='container'>";
					echo "<div class='alert alert-success col-12'>Sus fotografías han sido registradas exitosamente</div><br>";
					echo "</section>";
				} else {
					echo "<div class='container'><span class='alert alert-danger col-md-8 col-md-offset-2'>Lo lamentamos, hubo un error subiendo su fotografía.</span></div><br>";
				}
			} else {
				echo "<div class='container'><span class='alert alert-danger col-md-8 col-md-offset-2'>Reduzca la resolución de la imagen.</span></div><br>";
			}

			//show success message

		}
	}

	if(isset($_POST['submitMultiples'])){
		$folder = "img/fotografias/{$_POST['idProductoCrear']}/";
		if (!file_exists($folder)) {
			mkdir("img/fotografias/{$_POST['idProductoCrear']}/", 0777, true);
		}
	    $bandera = true;
		if(count($_FILES['upload']['name']) > 0){
			//Loop through each file
			for($i=0; $i<count($_FILES['upload']['name']); $i++) {
				//Get the temp file path
				$tmpFilePath = $_FILES['upload']['tmp_name'][$i];

				//Make sure we have a filepath
				if($tmpFilePath != ""){

					$temp[$i] = explode(".", $_FILES["upload"]["name"][$i]);
					$newfilename = $_POST['idProductoCrear'].$i.'.' . end($temp[$i]);

					//save the filename
					$shortname = $_FILES['upload']['name'][$i];

					//save the url and the file
					$filePath = "img/fotografias/".$_POST['idProductoCrear']."/";

					//Upload the file into the temp dir
					if(move_uploaded_file($tmpFilePath, $filePath.$newfilename)) {

						$files[] = $shortname;
						//insert into db
						//use $shortname for the filename
						//use $filePath for the relative url to the file
                        if($bandera){
                            $bandera = false;
	                        echo "<section class='container'>";
	                        echo "<div class='alert alert-success col-12'>Sus fotografías han sido registradas exitosamente</div><br>";
	                        echo "</section>";
                        }
					}else{
					    if($bandera){
					        $bandera = false;
						    echo "<section class='container'>";
						    echo "<div class='alert alert-danger col-12'>Sus fotografías no han sido registradas</div><br>";
						    echo "</section>";
                        }
                    }
				}
			}
		}

		//show success message

	}

	if(isset($_POST['deleteFoto'])){
		$file = $_POST['fotografiaEliminar'];
		unlink($file);
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
                    <form id="formSiguiente" method="post" action="gestionProductos.php" enctype='multipart/form-data'>
                        <input type="hidden" name="idProductoCrear" value="<?php echo $_POST['idProductoCrear']?>">
                        <input type="hidden" name="volverHE4">
                    </form>
                    <div class="card-block">
                        <div class="col-12">
							<?php
							$activoSecuencia = '';
							$activoFotografia = '';
							if(isset($_POST['siguiente']) || isset($_POST['subir']) || isset($_POST['bajar'])){
								$activoSecuencia = 'active';
							}
							if(isset($_POST['addFotografia']) || isset($_POST['volverHE5']) || isset($_POST['submitMultiples']) || isset($_POST['submitFoto']) || isset($_POST['deleteFoto'])){
								$activoFotografia = 'active';
							}
							?>
                            <div class="spacer20"></div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link <?php echo $activoSecuencia;?>" data-toggle="tab" href="#secuencia" role="tab">Secuencia de Procesos</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo $activoFotografia;?>" data-toggle="tab" href="#fotografias" role="tab">Fotografía</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane <?php echo $activoSecuencia;?>" id="secuencia" role="tabpanel">
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
														if($row3['idProcedimiento'] == 6 || $row3['idProcedimiento'] == 4){
															$query4 = mysqli_query($link,"SELECT * FROM SubProceso WHERE idProcedimiento = '{$row['valor']}'");
															while($row4 = mysqli_fetch_array($query4)){
																echo "<td class='text-center'>{$row4['descripcion']}</td>";
																$flag2 = false;
															}
														}else{
															if($row3['idProcedimiento'] == 5){
																echo "<td class='text-center'>{$row3['descripcion']} ";
																$arrayValido = [26];
																foreach($arrayValido as $validez){
																	if($row['idSubProcesoCaracteristica'] == $validez){
																		$name = mysqli_query($link,"SELECT * FROM Insumos WHERE idInsumo = '{$row['valor']}'");
																		while($searchName = mysqli_fetch_array($name)){
																			echo "- {$searchName['descripcion']}</td>";
																		}
																	}
																}
															}else{
																echo "<td class='text-center'>{$row3['descripcion']}</td>";
															}
														}
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
                                <div class="tab-pane <?php echo $activoFotografia;?>" id="fotografias" role="tabpanel">
                                    <div class="spacer20"></div>
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-6">
                                                <form action="#" enctype="multipart/form-data" method="post">
                                                    <div class="spacer30"></div>
                                                    <input type="hidden" name="idProductoCrear" value="<?php echo $_POST['idProductoCrear']?>">
                                                    <h5 class="text-center">Fotografía de Producto</h5>
                                                    <hr>
                                                    <div class="col-12 text-center">
                                                        <input type="file" name="fileToUpload" class="inputfile inputfile-1" id="file2"/>
                                                        <label for="file2"><i class="fa fa-photo"></i><span> Elegir la Fotografía</span></label>
                                                    </div>
                                                    <div class="col-12 text-center">
                                                        <input type="submit" name="submitFoto" value="Subir Fotografía" class="btn btn-outline-primary">
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-4 offset-1">
                                                <img class="fotografiaProducto" src="img/fotografias/<?php echo $_POST['idProductoCrear'];?>/<?php echo $_POST['idProductoCrear'];?>.jpg">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="spacer30"></div>
                                    <hr>
                                    <div class="spacer30"></div>
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-12">
                                                <form action="#" enctype="multipart/form-data" method="post">
                                                    <input type="hidden" name="idProductoCrear" value="<?php echo $_POST['idProductoCrear']?>">
                                                    <h5 class="text-center">Fotografías Adicionales</h5>
                                                    <div class="col-6 offset-4" style="padding-left: 70px">
                                                        <input type="file" name="upload[]" id="file" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple />
                                                        <label for="file"><i class="fa fa-photo"></i><span> Elegir las Fotografías</span></label>
                                                    </div>
                                                    <div class="col-6 offset-5">
                                                        <input type="submit" name="submitMultiples" value="Subir Fotografías" class="btn btn-outline-primary">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="spacer30"></div>
                                    <div class="container">
                                        <div class="row">
	                                            <?php
                                                $folder = "img/fotografias/{$_POST['idProductoCrear']}/";
                                                if (file_exists($folder)) {
	                                                $i = 0;
	                                                $dir = "img/fotografias/" . $_POST['idProductoCrear'] . "/";
	                                                if ($handle = opendir($dir)) {
		                                                while (($file = readdir($handle)) !== false) {
			                                                if (!in_array($file, array('.', '..')) && !is_dir($dir . $file))
				                                                $i++;
		                                                }
	                                                }
	                                                for ($j = 0; $j < ($i + 10); $j++) {
	                                                    $file = "img/fotografias/".$_POST['idProductoCrear']."/".$_POST['idProductoCrear'].$j.".jpg";
	                                                    if(file_exists($file)){
		                                                    echo "<div class='col-4 text-center'>";
		                                                    echo "<img src='img/fotografias/{$_POST['idProductoCrear']}/{$_POST['idProductoCrear']}{$j}.jpg' alt='Evidencia{$j}' style='width:304px;height:228px;margin-bottom:20px;margin-left: 10px;margin-right: 65px;'>";
		                                                    echo "<form method='post' action='#'>
                                                            <input type='hidden' value='img/fotografias/{$_POST['idProductoCrear']}/{$_POST['idProductoCrear']}{$j}.jpg' name='fotografiaEliminar'>
                                                            <input type='hidden' value='{$_POST['idProductoCrear']}' name='idProductoCrear'>
                                                            <input type='submit' class='btn btn-outline-primary' value='Eliminar' name='deleteFoto'>
                                                          </form>";
		                                                    echo "<br></div>";
                                                        }
	                                                }
                                                }
	                                            ?>
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
	include('footer.php');
}
?>