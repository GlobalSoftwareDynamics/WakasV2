<?php
include('session.php');
if(isset($_SESSION['login'])){
	include('header.php');
	include('navbarAdmin.php');
	include('funciones.php');
	include('declaracionFechas.php');
	?>

		<section class="container">
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header card-inverse card-info">
							<div class="float-left mt-1">
								<i class="fa fa-pencil"></i>
								&nbsp;&nbsp;Datos Generales
							</div>
							<div class="float-right">
								<div class="dropdown">
                                    <form method="post" id="formSiguiente" action="gestionProductos.php">
                                        <input type="hidden" value="<?php echo $_POST['idProductoCrear']?>" name="idProductoCrear">
                                        <button name="volver" type="submit" class="btn btn-light btn-sm" form="formSiguiente">Volver</button>
                                        <button name="pdf" type="submit" class="btn btn-light btn-sm" form="formSiguiente" formaction="verHEpdf.php">Descargar PDF</button>
                                    </form>
								</div>
							</div>
						</div>
						<div class="card-block">
							<div class="col-12">
								<div class="spacer20"></div>
								<ul class="nav nav-tabs" role="tablist">
									<li class="nav-item">
										<a class="crowded nav-link active" data-toggle="tab" href="#general" role="tab">Datos Generales</a>
									</li>
									<li class="nav-item">
										<a class="crowded nav-link" data-toggle="tab" href="#medidas" role="tab">Medidas y Tallas</a>
									</li>
									<li class="nav-item">
										<a class="crowded nav-link" data-toggle="tab" href="#componentes" role="tab">Componentes</a>
									</li>
									<li class="nav-item">
										<a class="crowded nav-link" data-toggle="tab" href="#partes" role="tab">Partes</a>
									</li>
									<li class="nav-item">
										<a class="crowded nav-link" data-toggle="tab" href="#tejido" role="tab">Tejido</a>
									</li>
									<li class="nav-item">
										<a class="crowded nav-link" data-toggle="tab" href="#lavado" role="tab">Lavado</a>
									</li>
									<li class="nav-item">
										<a class="crowded nav-link" data-toggle="tab" href="#secado" role="tab">Secado</a>
									</li>
									<li class="nav-item">
										<a class="crowded nav-link" data-toggle="tab" href="#confeccion" role="tab">Confección</a>
									</li>
									<li class="nav-item">
										<a class="crowded nav-link" data-toggle="tab" href="#acondicionamiento" role="tab">Acondicionamiento</a>
									</li>
									<li class="nav-item">
										<a class="crowded nav-link" data-toggle="tab" href="#otros" role="tab">Otros</a>
									</li>
									<li class="nav-item">
										<a class="crowded nav-link" data-toggle="tab" href="#secuencia" role="tab">Secuencia</a>
									</li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="general" role="tabpanel">
										<div class="spacer30"></div>
										<?php
										$query = mysqli_query($link,"SELECT * FROM Producto WHERE idProducto = '{$_POST['idProductoCrear']}'");
										while($row = mysqli_fetch_array($query)){
											$tipoProducto = $row['idTipoProducto'];
											$cliente = $row['idCliente'];
											$genero = $row['idgenero'];
											$idCodificacionTalla = $row['idcodificacionTalla'];
											$idProvisional = $row['idProvisional'];
											$observaciones = $row['observaciones'];
											$descripcionGeneral = $row['descripcionGeneral'];
											$codificacionMaterial = $row['codificacionMaterial'];
										}
										?>
                                        <div class="row">
                                            <div class="col-2">
                                                <p><strong>ID Producto:</strong></p>
                                                <p><strong>ID Provisional:</strong></p>
	                                            <?php
	                                            $query = mysqli_query($link,"SELECT * FROM Genero WHERE idGenero = {$genero}");
	                                            while($row = mysqli_fetch_array($query)){
		                                            echo "<p><strong>Género:</strong></p>";
	                                            }
	                                            $query = mysqli_query($link,"SELECT * FROM TipoProducto WHERE idTipoProducto = {$tipoProducto}");
	                                            while($row = mysqli_fetch_array($query)){
		                                            echo "<p><strong>Tipo de Producto:</strong></p>";
	                                            }
	                                            $query = mysqli_query($link,"SELECT * FROM codificacionTalla WHERE idcodificacionTalla = {$idCodificacionTalla}");
	                                            while($row = mysqli_fetch_array($query)){
		                                            echo "<p><strong>Codificación de Talla:</strong></p>";
	                                            }
	                                            $query = mysqli_query($link,"SELECT * FROM Cliente WHERE idCliente = {$cliente}");
	                                            while($row = mysqli_fetch_array($query)){
		                                            echo "<p><strong>Cliente:</strong></p>";
	                                            }
	                                            ?>
                                            </div>
                                            <div class="col-3">
                                                <p><?php echo $_POST['idProductoCrear'];?></p>
                                                <p><?php echo $idProvisional;?></p>
	                                            <?php
	                                            $query = mysqli_query($link,"SELECT * FROM Genero WHERE idGenero = {$genero}");
	                                            while($row = mysqli_fetch_array($query)){
		                                            echo "<p>{$row['descripcion']}</p>";
	                                            }
	                                            $query = mysqli_query($link,"SELECT * FROM TipoProducto WHERE idTipoProducto = {$tipoProducto}");
	                                            while($row = mysqli_fetch_array($query)){
		                                            echo "<p>{$row['descripcion']}</p>";
	                                            }
	                                            $query = mysqli_query($link,"SELECT * FROM codificacionTalla WHERE idcodificacionTalla = {$idCodificacionTalla}");
	                                            while($row = mysqli_fetch_array($query)){
		                                            echo "<p>{$row['descripcion']}</p>";
	                                            }
	                                            $query = mysqli_query($link,"SELECT * FROM Cliente WHERE idCliente = {$cliente}");
	                                            while($row = mysqli_fetch_array($query)){
		                                            echo "<p>{$row['nombre']}</p>";
	                                            }
	                                            ?>
                                            </div>
                                            <div class="col-4 offset-1">
                                                <img class="fotografiaProducto" src="img/fotografias/<?php echo $_POST['idProductoCrear'];?>/<?php echo $_POST['idProductoCrear'];?>.jpg">
                                            </div>
                                            <div class="spacer20"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-2 offset-1"><p><strong>Descripción General: </strong></p></div>
                                            <div class="col-8"><p class="text-justify"><?php echo $descripcionGeneral?></p></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-2 offset-1"><p><strong>Observaciones: </strong></p></div>
                                            <div class="col-8"><p class="text-justify"><?php echo $observaciones?></p></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-2 offset-1"><p><strong>Codificación de Material: </strong></p></div>
                                            <div class="col-8"><p class="text-justify"><?php echo $codificacionMaterial?></p></div>
                                        </div>
                                        <div class="row">
                                            <table class="table">
                                                <tr>
                                                    <th class="text-center">Fotografías Adicionales de Producto</th>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="row">
	                                        <?php
	                                        $i = 0;
	                                        $dir = "img/fotografias/".$_POST['idProductoCrear']."/";
	                                        if ($handle = opendir($dir)) {
		                                        while (($file = readdir($handle)) !== false){
			                                        if (!in_array($file, array('.', '..')) && !is_dir($dir.$file))
				                                        $i++;
		                                        }
	                                        }
	                                        for($j=0;$j<($i-1);$j++){
	                                            echo "<div class='col-4'>";
		                                        echo "<img src='img/fotografias/{$_POST['idProductoCrear']}/{$_POST['idProductoCrear']}{$j}.jpg' alt='Evidencia{$j}' style='width:304px;height:228px;margin-bottom:20px;margin-left: 10px;margin-right: 65px;'>";
		                                        echo "</div>";
	                                        }
	                                        ?>
                                        </div>
									</div>
									<div class="tab-pane" id="medidas" role="tabpanel">
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
											</tr>
											</thead>
											<tbody>
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
												echo "</tr>";
											}
											?>
											</tbody>
										</table>
										<div class="spacer20"></div>
									</div>
									<div class="tab-pane" id="componentes" role="tabpanel">
										<div class="spacer20"></div>
										<table class="table table-bordered">
											<thead>
											<tr>
												<th class="text-center">Componente</th>
												<th class="text-center">Material</th>
												<th class="text-center">U.Medida</th>
												<th class="text-center">Nro. Métrico</th>
												<th class="text-center">Color</th>
												<th class="text-center">Cantidad</th>
											</tr>
											</thead>
											<tbody>
											<?php
											$query = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idProducto = '{$_POST['idProductoCrear']}' ORDER BY idComponenteEspecifico ASC");
											while($row = mysqli_fetch_array($query)){
												$filter = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE idComponente = '{$row['idComponente']}' AND tipo = 1");
												while($index = mysqli_fetch_array($filter)){
													echo "<tr>";
													$query2 = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE idComponente = '{$row['idComponente']}'");
													while($row2 = mysqli_fetch_array($query2)){
														echo "<td class='text-center'>{$row2['descripcion']}</td>";
													}
													if($row['idMaterial'] == ''){
														echo "<td class='text-center'>-</td>";
														echo "<td class='text-center'>-</td>";
													}else{
														$query2 = mysqli_query($link,"SELECT * FROM Material WHERE idMaterial = '{$row['idMaterial']}'");
														while($row2 = mysqli_fetch_array($query2)){
															echo "<td class='text-center'>{$row2['material']}</td>";
															echo "<td class='text-center'>{$row2['idUnidadMedida']}</td>";
														}
													}
													if($row['numMetrico'] == ''){
														echo "<td class='text-center'>-</td>";
													}else{
														echo "<td class='text-center'>{$row['numMetrico']}</td>";
													}
													if($row['codigoColor'] == ''){
														echo "<td class='text-center'>-</td>";
													}else{
														echo "<td class='text-center'>{$row['codigoColor']}</td>";
													}
													if($row['cantidadMaterial'] == ''){
														echo "<td class='text-center'>-</td>";
													}else{
														echo "<td class='text-center'>{$row['cantidadMaterial']}</td>";
													}
													echo "</tr>";
												}
											}
											?>
											</tbody>
										</table>
									</div>
									<div class="tab-pane <?php echo $activoPartes;?>" id="partes" role="tabpanel">
										<div class="spacer20"></div>
										<table class="table table-bordered">
											<thead>
											<tr>
												<th class="text-center">Parte</th>
											</tr>
											</thead>
											<tbody>
											<?php
											$query = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idProducto = '{$_POST['idProductoCrear']}' ORDER BY idComponenteEspecifico ASC");
											while($row = mysqli_fetch_array($query)){
												$filter = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE idComponente = '{$row['idComponente']}' AND tipo = 2");
												while($index = mysqli_fetch_array($filter)){
													echo "<tr>";
													$query2 = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE idComponente = '{$row['idComponente']}'");
													while($row2 = mysqli_fetch_array($query2)){
														echo "<td class='text-center'>{$row2['descripcion']}</td>";
													}
													echo "</tr>";
												}
											}
											?>
											</tbody>
										</table>
									</div>
                                    <div class="tab-pane" id="tejido" role="tabpanel">
                                        <div class="spacer20"></div>
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
                                                </tr>
                                                </thead>
                                                <tbody>
		                                    <?php
		                                    $flag = true;
		                                    $indice = 0;
		                                    $query = mysqli_query($link,"SELECT * FROM PCPSPC WHERE idProducto = '{$_POST['idProductoCrear']}' AND idSubProcesoCaracteristica < 8 AND idSubProcesoCaracteristica > 2 ORDER BY indice ASC, idSubProcesoCaracteristica ASC");
		                                    while($row = mysqli_fetch_array($query)){
			                                    if($indice != $row['indice']){$flag = true;}
			                                    if($flag){
				                                    $flag = false;
				                                    $indice = $row['indice'];
				                                    echo "<tr>";
				                                    $query2 = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idComponenteEspecifico = '{$row['idComponenteEspecifico']}'");
				                                    while($row2 = mysqli_fetch_array($query2)){
					                                    $query3 = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE idComponente = '{$row2['idComponente']}'");
					                                    while($row3 = mysqli_fetch_array($query3)){
						                                    echo "<td class='text-center'>{$row3['descripcion']}</td>";
					                                    }
					                                    if($row2['idMaterial'] == null){
						                                    echo "<td class='text-center'>-</td>";
					                                    }else{
						                                    $query3 = mysqli_query($link,"SELECT * FROM Material WHERE idMaterial = '{$row2['idMaterial']}'");
						                                    while($row3 = mysqli_fetch_array($query3)){
							                                    echo "<td class='text-center'>{$row3['material']}</td>";
						                                    }
					                                    }
				                                    }
			                                    }
			                                    echo "<td class='text-center'>{$row['valor']}</td>";
			                                    if($row['idSubProcesoCaracteristica'] == 7){
				                                    echo "</tr>";
			                                    }
		                                    }
		                                    ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="lavado" role="tabpanel">
                                        <div class="spacer20"></div>
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="text-center">Componente</th>
                                                <th class="text-center">Tipo de Lavado</th>
                                                <th class="text-center">Programa</th>
                                                <th class="text-center">Observaciones</th>
                                                <th class="text-center">Tiempo</th>
                                            </tr>
                                            </thead>
                                            <tbody>
		                                    <?php
		                                    $flag = true;
		                                    $indice = 0;
		                                    $query = mysqli_query($link,"SELECT * FROM PCPSPC WHERE idProducto = '{$_POST['idProductoCrear']}' AND idSubProcesoCaracteristica < 13 AND idSubProcesoCaracteristica > 8 ORDER BY indice ASC, idSubProcesoCaracteristica ASC");
		                                    while($row = mysqli_fetch_array($query)){
			                                    if($indice != $row['indice']){$flag = true;}
			                                    if($flag){
				                                    $flag = false;
				                                    $indice = $row['indice'];
				                                    echo "<tr>";
				                                    $query2 = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idComponenteEspecifico = '{$row['idComponenteEspecifico']}'");
				                                    while($row2 = mysqli_fetch_array($query2)){
					                                    $query3 = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE idComponente = '{$row2['idComponente']}'");
					                                    while($row3 = mysqli_fetch_array($query3)){
						                                    echo "<td class='text-center'>{$row3['descripcion']}</td>";
					                                    }
				                                    }
			                                    }
			                                    echo "<td class='text-center'>{$row['valor']}</td>";
			                                    if($row['idSubProcesoCaracteristica'] == 12){
				                                    echo "</tr>";

				                                    $search = mysqli_query($link,"SELECT * FROM PCPSPCInsumos WHERE idPCPSPC = '{$row['idPCPSPC']}'");
				                                    while($index = mysqli_fetch_array($search)){
					                                    $search2 =  mysqli_query($link,"SELECT * FROM Insumos WHERE idInsumo = '{$index['idInsumo']}'");
					                                    while($index2 = mysqli_fetch_array($search2)){
						                                    $insumoElegido = $index2['descripcion'];
						                                    $unidadMedida = $index2['idUnidadMedida'];
					                                    }
					                                    echo "<tr>
                                                                    <td class='text-center' colspan='3'>{$insumoElegido}</td>
                                                                    <td class='text-center' colspan='3'>{$index['cantidad']} {$unidadMedida}</td>
                                                                  </tr>";
				                                    }
				                                    echo "<tr><td colspan='6'></td></tr>";
			                                    }
		                                    }
		                                    ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="secado" role="tabpanel">
                                        <div class="spacer20"></div>
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="text-center">Componente</th>
                                                <th class="text-center">Tipo de Secado</th>
                                                <th class="text-center">Programa</th>
                                                <th class="text-center">Rotación</th>
                                                <th class="text-center">Observaciones</th>
                                                <th class="text-center">Tiempo</th>
                                            </tr>
                                            </thead>
                                            <tbody>
		                                    <?php
		                                    $flag = true;
		                                    $indice = 0;
		                                    $query = mysqli_query($link,"SELECT * FROM PCPSPC WHERE idProducto = '{$_POST['idProductoCrear']}' AND idSubProcesoCaracteristica < 19 AND idSubProcesoCaracteristica > 13 ORDER BY indice ASC, idSubProcesoCaracteristica ASC");
		                                    while($row = mysqli_fetch_array($query)){
			                                    if($indice != $row['indice']){$flag = true;}
			                                    if($flag){
				                                    $flag = false;
				                                    $indice = $row['indice'];
				                                    echo "<tr>";
				                                    $query2 = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idComponenteEspecifico = '{$row['idComponenteEspecifico']}'");
				                                    while($row2 = mysqli_fetch_array($query2)){
					                                    $query3 = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE idComponente = '{$row2['idComponente']}'");
					                                    while($row3 = mysqli_fetch_array($query3)){
						                                    echo "<td class='text-center'>{$row3['descripcion']}</td>";
					                                    }
				                                    }
			                                    }
			                                    echo "<td class='text-center'>{$row['valor']}</td>";
			                                    if($row['idSubProcesoCaracteristica'] == 18){
				                                    echo "</tr>";
			                                    }
		                                    }
		                                    ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="confeccion" role="tabpanel">
                                        <div class="spacer20"></div>
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="text-center">Componente</th>
                                                <th class="text-center">Procedimiento</th>
                                                <th class="text-center">Indicaciones</th>
                                                <th class="text-center">Máquina</th>
                                                <th class="text-center">Observaciones</th>
                                                <th class="text-center">Tiempo</th>
                                            </tr>
                                            </thead>
                                            <tbody>
		                                    <?php
		                                    $flag = true;
		                                    $flag2 = true;
		                                    $indice = 0;
		                                    $query = mysqli_query($link,"SELECT * FROM PCPSPC WHERE idProducto = '{$_POST['idProductoCrear']}' AND idSubProcesoCaracteristica < 25 AND idSubProcesoCaracteristica > 19 ORDER BY indice ASC, idSubProcesoCaracteristica ASC");
		                                    while($row = mysqli_fetch_array($query)){
			                                    if($indice != $row['indice']){$flag = true;}
			                                    if($flag){
				                                    $flag = false;
				                                    $indice = $row['indice'];
				                                    echo "<tr>";
				                                    $query2 = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idComponenteEspecifico = '{$row['idComponenteEspecifico']}'");
				                                    while($row2 = mysqli_fetch_array($query2)){
					                                    $query3 = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE idComponente = '{$row2['idComponente']}'");
					                                    while($row3 = mysqli_fetch_array($query3)){
						                                    echo "<td class='text-center'>{$row3['descripcion']}</td>";
					                                    }
				                                    }
			                                    }
			                                    $arrayValido = [20,32];
			                                    foreach($arrayValido as $validez){
				                                    if($row['idSubProcesoCaracteristica'] == $validez){
					                                    $query3 = mysqli_query($link,"SELECT * FROM SubProceso WHERE idProcedimiento = '{$row['valor']}'");
					                                    while($row3 = mysqli_fetch_array($query3)){
						                                    echo "<td class='text-center'>{$row3['descripcion']}</td>";
						                                    $flag2 = false;
					                                    }
				                                    }
			                                    }
			                                    $arrayValido = [22,28,33];
			                                    foreach($arrayValido as $validez){
				                                    if($row['idSubProcesoCaracteristica'] == $validez){
					                                    $query2 = mysqli_query($link,"SELECT * FROM Maquina WHERE idMaquina = '{$row['valor']}'");
					                                    while($row2 = mysqli_fetch_array($query2)){
						                                    echo "<td class='text-center'>{$row2['descripcion']}</td>";
						                                    $flag2 = false;
					                                    }
				                                    }
			                                    }
			                                    if($flag2){
				                                    echo "<td class='text-center'>{$row['valor']}</td>";
			                                    }
			                                    $flag2 = true;
			                                    if($row['idSubProcesoCaracteristica'] == 24){
				                                    echo "</tr>";
			                                    }
		                                    }
		                                    ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="acondicionamiento" role="tabpanel">
                                        <div class="spacer20"></div>
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="text-center">Componente</th>
                                                <th class="text-center">Insumo</th>
                                                <th class="text-center">Cantidad</th>
                                                <th class="text-center">Máquina</th>
                                                <th class="text-center">Observaciones</th>
                                                <th class="text-center">Tiempo</th>
                                            </tr>
                                            </thead>
                                            <tbody>
		                                    <?php
		                                    $flag = true;
		                                    $flag2 = true;
		                                    $indice = 0;
		                                    $query = mysqli_query($link,"SELECT * FROM PCPSPC WHERE idProducto = '{$_POST['idProductoCrear']}' AND idSubProcesoCaracteristica < 31 AND idSubProcesoCaracteristica > 25 ORDER BY indice ASC, idSubProcesoCaracteristica ASC");
		                                    while($row = mysqli_fetch_array($query)){
			                                    if($indice != $row['indice']){$flag = true;}
			                                    if($flag){
				                                    $flag = false;
				                                    $indice = $row['indice'];
				                                    echo "<tr>";
				                                    $query2 = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idComponenteEspecifico = '{$row['idComponenteEspecifico']}'");
				                                    while($row2 = mysqli_fetch_array($query2)){
					                                    $query3 = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE idComponente = '{$row2['idComponente']}'");
					                                    while($row3 = mysqli_fetch_array($query3)){
						                                    echo "<td class='text-center'>{$row3['descripcion']}</td>";
					                                    }
				                                    }
			                                    }
			                                    $arrayValido = [26];
			                                    foreach($arrayValido as $validez){
				                                    if($row['idSubProcesoCaracteristica'] == $validez){
					                                    $query2 = mysqli_query($link,"SELECT * FROM Insumos WHERE idInsumo = '{$row['valor']}'");
					                                    while($row2 = mysqli_fetch_array($query2)){
						                                    echo "<td class='text-center'>{$row2['descripcion']}</td>";
						                                    $flag2 = false;
					                                    }
				                                    }
			                                    }
			                                    $arrayValido = [22,28,33];
			                                    foreach($arrayValido as $validez){
				                                    if($row['idSubProcesoCaracteristica'] == $validez){
					                                    $query2 = mysqli_query($link,"SELECT * FROM Maquina WHERE idMaquina = '{$row['valor']}'");
					                                    while($row2 = mysqli_fetch_array($query2)){
						                                    echo "<td class='text-center'>{$row2['descripcion']}</td>";
						                                    $flag2 = false;
					                                    }
				                                    }
			                                    }
			                                    if($flag2){
				                                    echo "<td class='text-center'>{$row['valor']}</td>";
			                                    }
			                                    $flag2 = true;
			                                    if($row['idSubProcesoCaracteristica'] == 30){
				                                    echo "</tr>";
			                                    }
		                                    }
		                                    ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="otros" role="tabpanel">
                                        <div class="spacer20"></div>
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="text-center">Componente</th>
                                                <th class="text-center">Procedimiento</th>
                                                <th class="text-center">Máquina</th>
                                                <th class="text-center">Observaciones</th>
                                                <th class="text-center">Tiempo</th>
                                            </tr>
                                            </thead>
                                            <tbody>
		                                    <?php
		                                    $flag = true;
		                                    $flag2 = true;
		                                    $indice = 0;
		                                    $query = mysqli_query($link,"SELECT * FROM PCPSPC WHERE idProducto = '{$_POST['idProductoCrear']}' AND idSubProcesoCaracteristica < 36 AND idSubProcesoCaracteristica > 31 ORDER BY indice ASC, idSubProcesoCaracteristica ASC");
		                                    while($row = mysqli_fetch_array($query)){
			                                    if($indice != $row['indice']){$flag = true;}
			                                    if($flag){
				                                    $flag = false;
				                                    $indice = $row['indice'];
				                                    echo "<tr>";
				                                    $query2 = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idComponenteEspecifico = '{$row['idComponenteEspecifico']}'");
				                                    while($row2 = mysqli_fetch_array($query2)){
					                                    $query3 = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE idComponente = '{$row2['idComponente']}'");
					                                    while($row3 = mysqli_fetch_array($query3)){
						                                    echo "<td class='text-center'>{$row3['descripcion']}</td>";
					                                    }
				                                    }
			                                    }
			                                    $arrayValido = [20,32];
			                                    foreach($arrayValido as $validez){
				                                    if($row['idSubProcesoCaracteristica'] == $validez){
					                                    $query3 = mysqli_query($link,"SELECT * FROM SubProceso WHERE idProcedimiento = '{$row['valor']}'");
					                                    while($row3 = mysqli_fetch_array($query3)){
						                                    echo "<td class='text-center'>{$row3['descripcion']}</td>";
						                                    $flag2 = false;
					                                    }
				                                    }
			                                    }
			                                    $arrayValido = [22,28,33];
			                                    foreach($arrayValido as $validez){
				                                    if($row['idSubProcesoCaracteristica'] == $validez){
					                                    $query2 = mysqli_query($link,"SELECT * FROM Maquina WHERE idMaquina = '{$row['valor']}'");
					                                    while($row2 = mysqli_fetch_array($query2)){
						                                    echo "<td class='text-center'>{$row2['descripcion']}</td>";
						                                    $flag2 = false;
					                                    }
				                                    }
			                                    }
			                                    if($flag2){
				                                    echo "<td class='text-center'>{$row['valor']}</td>";
			                                    }
			                                    $flag2 = true;
			                                    if($row['idSubProcesoCaracteristica'] == 35){
				                                    echo "</tr>";
			                                    }
		                                    }
		                                    ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="secuencia" role="tabpanel">
                                        <div class="spacer20"></div>
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="text-center">Subproceso</th>
                                                <th class="text-center">Componente</th>
                                                <th class="text-center">Observaciones</th>
                                                <th class="text-center">Tiempo</th>
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
							                                    echo "<td class='text-center'>{$row3['descripcion']}</td>";
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
			</div>
		</section>

	<?php
	include('footer.php');
}
?>