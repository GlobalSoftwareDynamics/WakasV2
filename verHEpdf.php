<?php
include('session.php');
include('declaracionFechas.php');
include ('funciones.php');
require_once __DIR__ . '/lib/mpdf/mpdf.php';

	$html='
            <html lang="es">
                <head>
                    <meta charset="utf-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1">    
                    <title>Hoja de Especificaciones</title>
                    <link href="css/bootstrap.css" rel="stylesheet">
                    <link href="css/HE.css" rel="stylesheet">
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
                </head>
                <body>
                
                <section>
                	<div class="row">
                            <div class="col-12">';
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

											$query = mysqli_query($link,"SELECT * FROM Genero WHERE idGenero = {$genero}");
											while($row = mysqli_fetch_array($query)){
												$genero = $row['descripcion'];
											}
											$query = mysqli_query($link,"SELECT * FROM TipoProducto WHERE idTipoProducto = {$tipoProducto}");
											while($row = mysqli_fetch_array($query)){
												$tipoProducto = $row['descripcion'];
											}
											$query = mysqli_query($link,"SELECT * FROM codificacionTalla WHERE idcodificacionTalla = {$idCodificacionTalla}");
											while($row = mysqli_fetch_array($query)){
												$idCodificacionTalla = $row['descripcion'];
											}
											$query = mysqli_query($link,"SELECT * FROM Cliente WHERE idCliente = {$cliente}");
											while($row = mysqli_fetch_array($query)){
												$cliente = $row['nombre'];
											}

                                        $html.="
												<table class='table table-bordered'>
													<tbody>
															<tr>
																<th class='text-left' width='170px'>ID Producto:</th>
																<td class='text-left'>{$_POST['idProductoCrear']}</td>
																<td rowspan='6' width='300px'><img src='img/fotografias/{$_POST['idProductoCrear']}/{$_POST['idProductoCrear']}.jpg' class='fotografiaProducto'></td>
															</tr>
															<tr>
																<th class='text-left'>Género:</th>
																<td class='text-left'>{$genero}</td>
															</tr>
															<tr>
																<th class='text-left'>Tipo de Producto:</th>
																<td class='text-left'>{$tipoProducto}</td>
															</tr>
															<tr>
																<th class='text-left'>Codificación de Talla:</th>
																<td class='text-left'>{$idCodificacionTalla}</td>
															</tr>
															<tr>
																<th class='text-left'>Cliente:</th>
																<td class='text-left'>{$cliente}</td>
															</tr>
															<tr>
																<th class='text-left'>Codificación de Material:</th>
																<td class='text-left'>{$codificacionMaterial}</td>
															</tr>
															<tr>
																<th colspan='2'>Descripción General</th>
																<th>Observaciones</th>
															</tr>
															<tr>
																<td colspan='2' class='text-justify'>{$descripcionGeneral}</td>
																<td class='text-justify'>{$observaciones}</td>
															</tr>
													</tbody>
												</table>
												
												<table class='table table-bordered'>
													<thead>
														<tr>
															<th colspan='2'>Medida</th>";

												$search = mysqli_query($link,"SELECT * FROM Producto WHERE idProducto = '{$_POST['idProductoCrear']}'");
												while($index = mysqli_fetch_array($search)){
													$idCodificacionTalla = $index['idcodificacionTalla'];
													//$search2 = mysqli_query($link,"SELECT * FROM Talla WHERE idcodificacionTalla = '{$index['idcodificacionTalla']}' ORDER BY indice ASC");
													$search2 = mysqli_query($link,"SELECT * FROM Talla WHERE idcodificacionTalla = '{$index['idcodificacionTalla']}'");
													while($index2 = mysqli_fetch_array($search2)){
														$html.= "<th style='width:6.5%;'>{$index2['descripcion']}</th>";
													}
												}
												$html.="
															<th class='text-center' style='width: 6%'>T(+/-)</th>
															<th class='text-center'>Observación</th>
														</tr>
													</thead>
													<tbody>";

														$result = mysqli_query($link , "SELECT * FROM ProductoMedida WHERE idProducto = '{$_POST['idProductoCrear']}' ORDER BY indice ASC");
														while($row = mysqli_fetch_array($result)){
															$html.= "<tr>";
																$html.= "<td>{$row['idMedida']}</td>";
																$result2 = mysqli_query($link,"SELECT * FROM Medida WHERE idMedida = '{$row['idMedida']}'");
																while($row2 = mysqli_fetch_array($result2)){
																	$html.= "<td>{$row2['descripcion']}</td>";
																}
																$search = mysqli_query($link,"SELECT * FROM Talla WHERE idcodificacionTalla = '{$idCodificacionTalla}' ORDER BY indice ASC");
																while($index = mysqli_fetch_array($search)){
																	$search2 = mysqli_query($link,"SELECT * FROM TallaMedida WHERE idProducto = '{$_POST['idProductoCrear']}' AND idTalla = '{$index['idTalla']}' AND idMedida = '{$row['idMedida']}'");
																	while($index2 = mysqli_fetch_array($search2)){
																		$html.= "<td>{$index2['valor']}</td>";
																	}
																}
																$html.= "<td>{$row['tolerancia']}</td>";
																$html.= "<td>{$row['observacion']}</td>";
															$html.= "</tr>";
														}

												$html.= "
													</tbody>
												</table>
												
												<table class='table table-bordered'>
													<thead>
														<tr>
															<th>Componente</th>
															<th>Material</th>
															<th>U.Medida</th>
															<th>Nro. Métrico</th>
															<th>Color</th>
															<th>Cantidad</th>
														</tr>
													</thead>
													<tbody>";

												$query = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idProducto = '{$_POST['idProductoCrear']}' ORDER BY idComponenteEspecifico ASC");
												while($row = mysqli_fetch_array($query)){
													$filter = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE idComponente = '{$row['idComponente']}' AND tipo = 1");
													while($index = mysqli_fetch_array($filter)){
														$html.= "<tr>";
														$query2 = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE idComponente = '{$row['idComponente']}'");
														while($row2 = mysqli_fetch_array($query2)){
															$html.= "<td class='text-center'>{$row2['descripcion']}</td>";
														}
														if($row['idMaterial'] == ''){
															$html.= "<td class='text-center'>-</td>";
															$html.= "<td class='text-center'>-</td>";
														}else{
															$query2 = mysqli_query($link,"SELECT * FROM Material WHERE idMaterial = '{$row['idMaterial']}'");
															while($row2 = mysqli_fetch_array($query2)){
																$html.= "<td class='text-center'>{$row2['material']}</td>";
																$html.= "<td class='text-center'>{$row2['idUnidadMedida']}</td>";
															}
														}
														if($row['numMetrico'] == ''){
															$html.= "<td class='text-center'>-</td>";
														}else{
															$html.= "<td class='text-center'>{$row['numMetrico']}</td>";
														}
														if($row['codigoColor'] == ''){
															$html.= "<td class='text-center'>-</td>";
														}else{
															$html.= "<td class='text-center'>{$row['codigoColor']}</td>";
														}
														if($row['cantidadMaterial'] == ''){
															$html.= "<td class='text-center'>-</td>";
														}else{
															$html.= "<td class='text-center'>{$row['cantidadMaterial']}</td>";
														}
														$html.= "</tr>";
													}
												}

														$html.= "
														<tr>
															<th colspan='6'>Partes</th>
														</tr>";

														$query = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idProducto = '{$_POST['idProductoCrear']}' ORDER BY idComponenteEspecifico ASC");
														while($row = mysqli_fetch_array($query)){
															$filter = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE idComponente = '{$row['idComponente']}' AND tipo = 2");
															while($index = mysqli_fetch_array($filter)){
																$html.= "<tr>";
																$query2 = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE idComponente = '{$row['idComponente']}'");
																while($row2 = mysqli_fetch_array($query2)){
																	$html.= "<td colspan='6'>{$row2['descripcion']}</td>";
																}
																$html.= "</tr>";
															}
														}

												$html.="
													</tbody>
												</table>
												
												<pagebreak></pagebreak>
												
												<h5>Procesos de Producto</h5>
												<div class='spacer20'></div>
												
												<h6>Tejido</h6>
												<table class='table table-bordered'>
                                                <thead>
                                                <tr>
                                                    <th>Componente</th>
                                                    <th>Material</th>
                                                    <th>Tipo de Tejido</th>
                                                    <th>Galgas</th>
                                                    <th>Comprobación de Tejido</th>
                                                    <th>Observaciones</th>
                                                    <th>Tiempo</th>
                                                </tr>
                                                </thead>
                                                <tbody>";
													$flag = true;
													$indice = 0;
													$query = mysqli_query($link,"SELECT * FROM PCPSPC WHERE idProducto = '{$_POST['idProductoCrear']}' AND idSubProcesoCaracteristica < 8 AND idSubProcesoCaracteristica > 2 ORDER BY indice ASC, idSubProcesoCaracteristica ASC");
													while($row = mysqli_fetch_array($query)){
														if($indice != $row['indice']){$flag = true;}
														if($flag){
															$flag = false;
															$indice = $row['indice'];
															$html.= "<tr>";
															$query2 = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idComponenteEspecifico = '{$row['idComponenteEspecifico']}'");
															while($row2 = mysqli_fetch_array($query2)){
																$query3 = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE idComponente = '{$row2['idComponente']}'");
																while($row3 = mysqli_fetch_array($query3)){
																	$html.= "<td>{$row3['descripcion']}</td>";
																}
																if($row2['idMaterial'] == null){
																	$html.= "<td>-</td>";
																}else{
																	$query3 = mysqli_query($link,"SELECT * FROM Material WHERE idMaterial = '{$row2['idMaterial']}'");
																	while($row3 = mysqli_fetch_array($query3)){
																		$html.= "<td>{$row3['material']}</td>";
																	}
																}
															}
														}
														$html.= "<td>{$row['valor']}</td>";
														if($row['idSubProcesoCaracteristica'] == 7){
															$html.= "</tr>";
														}
													}
											$html.= "
                                                </tbody>
                                                </table>
                                                
											<h6>Lavado</h6>
											<table class='table table-bordered'>
                                                <thead>
                                                <tr>
                                                    <th>Componente</th>
	                                                <th>Tipo de Lavado</th>
	                                                <th>Programa</th>
	                                                <th>Observaciones</th>
	                                                <th>Tiempo</th>
                                                </tr>
                                                </thead>
                                                <tbody>";
														$flag = true;
														$indice = 0;
														$query = mysqli_query($link,"SELECT * FROM PCPSPC WHERE idProducto = '{$_POST['idProductoCrear']}' AND idSubProcesoCaracteristica < 13 AND idSubProcesoCaracteristica > 8 ORDER BY indice ASC, idSubProcesoCaracteristica ASC");
														while($row = mysqli_fetch_array($query)){
															if($indice != $row['indice']){$flag = true;}
															if($flag){
																$flag = false;
																$indice = $row['indice'];
																$html.= "<tr>";
																$query2 = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idComponenteEspecifico = '{$row['idComponenteEspecifico']}'");
																while($row2 = mysqli_fetch_array($query2)){
																	$query3 = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE idComponente = '{$row2['idComponente']}'");
																	while($row3 = mysqli_fetch_array($query3)){
																		$html.= "<td>{$row3['descripcion']}</td>";
																	}
																}
															}
															$html.= "<td>{$row['valor']}</td>";
															if($row['idSubProcesoCaracteristica'] == 12){
																$html.= "</tr>";

																$search = mysqli_query($link,"SELECT * FROM PCPSPCInsumos WHERE idPCPSPC = '{$row['idPCPSPC']}'");
																while($index = mysqli_fetch_array($search)){
																	$search2 =  mysqli_query($link,"SELECT * FROM Insumos WHERE idInsumo = '{$index['idInsumo']}'");
																	while($index2 = mysqli_fetch_array($search2)){
																		$insumoElegido = $index2['descripcion'];
																		$unidadMedida = $index2['idUnidadMedida'];
																	}
																	$html.= "<tr>
														                                                                    <td colspan='3'>{$insumoElegido}</td>
														                                                                    <td colspan='3'>{$index['cantidad']} {$unidadMedida}</td>
														                                                                  </tr>";
																}
																$html.= "<tr><td colspan='6'></td></tr>";
															}
														}
											$html.= "
                                                </tbody>
                                                </table>
                                                
                                                <h6>Secado</h6>
											<table class='table table-bordered'>
                                                <thead>
                                                <tr>
                                                    <th>Componente</th>
	                                                <th>Tipo de Secado</th>
	                                                <th>Programa</th>
	                                                <th>Rotación</th>
	                                                <th>Observaciones</th>
	                                                <th>Tiempo</th>
                                                </tr>
                                                </thead>
                                                <tbody>";
													$flag = true;
													$indice = 0;
													$query = mysqli_query($link,"SELECT * FROM PCPSPC WHERE idProducto = '{$_POST['idProductoCrear']}' AND idSubProcesoCaracteristica < 19 AND idSubProcesoCaracteristica > 13 ORDER BY indice ASC, idSubProcesoCaracteristica ASC");
													while($row = mysqli_fetch_array($query)){
														if($indice != $row['indice']){$flag = true;}
														if($flag){
															$flag = false;
															$indice = $row['indice'];
															$html.= "<tr>";
															$query2 = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idComponenteEspecifico = '{$row['idComponenteEspecifico']}'");
															while($row2 = mysqli_fetch_array($query2)){
																$query3 = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE idComponente = '{$row2['idComponente']}'");
																while($row3 = mysqli_fetch_array($query3)){
																	$html.= "<td>{$row3['descripcion']}</td>";
																}
															}
														}
														$html.= "<td>{$row['valor']}</td>";
														if($row['idSubProcesoCaracteristica'] == 18){
															$html.= "</tr>";
														}
													}
											$html.= "
                                                </tbody>
                                                </table>
                                                
                                                <h6>Confección</h6>
											<table class='table table-bordered'>
                                                <thead>
                                                <tr>
                                                    <th>Componente</th>
	                                                <th>Procedimiento</th>
	                                                <th>Indicaciones</th>
	                                                <th>Máquina</th>
	                                                <th>Observaciones</th>
	                                                <th>Tiempo</th>
                                                </tr>
                                                </thead>
                                                <tbody>";
													$flag = true;
													$flag2 = true;
													$indice = 0;
													$query = mysqli_query($link,"SELECT * FROM PCPSPC WHERE idProducto = '{$_POST['idProductoCrear']}' AND idSubProcesoCaracteristica < 25 AND idSubProcesoCaracteristica > 19 ORDER BY indice ASC, idSubProcesoCaracteristica ASC");
													while($row = mysqli_fetch_array($query)){
														if($indice != $row['indice']){$flag = true;}
														if($flag){
															$flag = false;
															$indice = $row['indice'];
															$html.= "<tr>";
															$query2 = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idComponenteEspecifico = '{$row['idComponenteEspecifico']}'");
															while($row2 = mysqli_fetch_array($query2)){
																$query3 = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE idComponente = '{$row2['idComponente']}'");
																while($row3 = mysqli_fetch_array($query3)){
																	$html.= "<td>{$row3['descripcion']}</td>";
																}
															}
														}
														$arrayValido = [20,32];
														foreach($arrayValido as $validez){
															if($row['idSubProcesoCaracteristica'] == $validez){
																$query3 = mysqli_query($link,"SELECT * FROM SubProceso WHERE idProcedimiento = '{$row['valor']}'");
																while($row3 = mysqli_fetch_array($query3)){
																	$html.= "<td>{$row3['descripcion']}</td>";
																	$flag2 = false;
																}
															}
														}
														$arrayValido = [22,28,33];
														foreach($arrayValido as $validez){
															if($row['idSubProcesoCaracteristica'] == $validez){
																$query2 = mysqli_query($link,"SELECT * FROM Maquina WHERE idMaquina = '{$row['valor']}'");
																while($row2 = mysqli_fetch_array($query2)){
																	$html.= "<td>{$row2['descripcion']}</td>";
																	$flag2 = false;
																}
															}
														}
														if($flag2){
															$html.= "<td>{$row['valor']}</td>";
														}
														$flag2 = true;
														if($row['idSubProcesoCaracteristica'] == 24){
															$html.= "</tr>";
														}
													}
											$html.= "
                                                </tbody>
                                                </table>
												
												<h6>Acondicionamiento</h6>
											<table class='table table-bordered'>
                                                <thead>
                                                <tr>
                                                    <th>Componente</th>
	                                                <th>Insumo</th>
	                                                <th>Cantidad</th>
	                                                <th>Máquina</th>
	                                                <th>Observaciones</th>
	                                                <th>Tiempo</th>
                                                </tr>
                                                </thead>
                                                <tbody>";
														$flag = true;
														$flag2 = true;
														$indice = 0;
														$query = mysqli_query($link,"SELECT * FROM PCPSPC WHERE idProducto = '{$_POST['idProductoCrear']}' AND idSubProcesoCaracteristica < 31 AND idSubProcesoCaracteristica > 25 ORDER BY indice ASC, idSubProcesoCaracteristica ASC");
														while($row = mysqli_fetch_array($query)){
															if($indice != $row['indice']){$flag = true;}
															if($flag){
																$flag = false;
																$indice = $row['indice'];
																$html.= "<tr>";
																$query2 = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idComponenteEspecifico = '{$row['idComponenteEspecifico']}'");
																while($row2 = mysqli_fetch_array($query2)){
																	$query3 = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE idComponente = '{$row2['idComponente']}'");
																	while($row3 = mysqli_fetch_array($query3)){
																		$html.= "<td>{$row3['descripcion']}</td>";
																	}
																}
															}
															$arrayValido = [26];
															foreach($arrayValido as $validez){
																if($row['idSubProcesoCaracteristica'] == $validez){
																	$query2 = mysqli_query($link,"SELECT * FROM Insumos WHERE idInsumo = '{$row['valor']}'");
																	while($row2 = mysqli_fetch_array($query2)){
																		$html.= "<td>{$row2['descripcion']}</td>";
																		$flag2 = false;
																	}
																}
															}
															$arrayValido = [22,28,33];
															foreach($arrayValido as $validez){
																if($row['idSubProcesoCaracteristica'] == $validez){
																	$query2 = mysqli_query($link,"SELECT * FROM Maquina WHERE idMaquina = '{$row['valor']}'");
																	while($row2 = mysqli_fetch_array($query2)){
																		$html.= "<td>{$row2['descripcion']}</td>";
																		$flag2 = false;
																	}
																}
															}
															if($flag2){
																$html.= "<td>{$row['valor']}</td>";
															}
															$flag2 = true;
															if($row['idSubProcesoCaracteristica'] == 30){
																$html.= "</tr>";
															}
														}
											$html.= "
                                                </tbody>
                                                </table>
												
												<h6>Otros</h6>
											<table class='table table-bordered'>
                                                <thead>
                                                <tr>
                                                    <th>Componente</th>
	                                                <th>Procedimiento</th>
	                                                <th>Máquina</th>
	                                                <th>Observaciones</th>
	                                                <th>Tiempo</th>
                                                </tr>
                                                </thead>
                                                <tbody>";
													$flag = true;
													$flag2 = true;
													$indice = 0;
													$query = mysqli_query($link,"SELECT * FROM PCPSPC WHERE idProducto = '{$_POST['idProductoCrear']}' AND idSubProcesoCaracteristica < 36 AND idSubProcesoCaracteristica > 31 ORDER BY indice ASC, idSubProcesoCaracteristica ASC");
													while($row = mysqli_fetch_array($query)){
														if($indice != $row['indice']){$flag = true;}
														if($flag){
															$flag = false;
															$indice = $row['indice'];
															$html.= "<tr>";
															$query2 = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idComponenteEspecifico = '{$row['idComponenteEspecifico']}'");
															while($row2 = mysqli_fetch_array($query2)){
																$query3 = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE idComponente = '{$row2['idComponente']}'");
																while($row3 = mysqli_fetch_array($query3)){
																	$html.= "<td>{$row3['descripcion']}</td>";
																}
															}
														}
														$arrayValido = [20,32];
														foreach($arrayValido as $validez){
															if($row['idSubProcesoCaracteristica'] == $validez){
																$query3 = mysqli_query($link,"SELECT * FROM SubProceso WHERE idProcedimiento = '{$row['valor']}'");
																while($row3 = mysqli_fetch_array($query3)){
																	$html.= "<td>{$row3['descripcion']}</td>";
																	$flag2 = false;
																}
															}
														}
														$arrayValido = [22,28,33];
														foreach($arrayValido as $validez){
															if($row['idSubProcesoCaracteristica'] == $validez){
																$query2 = mysqli_query($link,"SELECT * FROM Maquina WHERE idMaquina = '{$row['valor']}'");
																while($row2 = mysqli_fetch_array($query2)){
																	$html.= "<td>{$row2['descripcion']}</td>";
																	$flag2 = false;
																}
															}
														}
														if($flag2){
															$html.= "<td>{$row['valor']}</td>";
														}
														$flag2 = true;
														if($row['idSubProcesoCaracteristica'] == 35){
															$html.= "</tr>";
														}
													}
											$html.= "
                                                </tbody>
                                                </table>
                                                
                                                <pagebreak></pagebreak>
												
												<h6>Secuencia de Procesos</h6>
											<table class='table table-bordered'>
                                                <thead>
                                                <tr>
                                                    <th>Subproceso</th>
	                                                <th>Componente</th>
	                                                <th>Observaciones</th>
	                                                <th>Tiempo</th>
                                                </tr>
                                                </thead>
                                                <tbody>";
													$flag = true;
													$indice = 0;
													$query = mysqli_query($link,"SELECT * FROM PCPSPC WHERE idProducto = '{$_POST['idProductoCrear']}' ORDER BY indice ASC, idSubProcesoCaracteristica ASC");
													while($row = mysqli_fetch_array($query)){
														if($indice != $row['indice']){$flag = true;}
														if($flag){
															$flag = false;
															$indice = $row['indice'];
															$html.= "<tr>";
															$query2 = mysqli_query($link,"SELECT * FROM SubProcesoCaracteristica WHERE idSubProcesoCaracteristica = '{$row['idSubProcesoCaracteristica']}'");
															while($row2 = mysqli_fetch_array($query2)){
																$query3 = mysqli_query($link,"SELECT * FROM SubProceso WHERE idProcedimiento = '{$row2['idProcedimiento']}'");
																while($row3 = mysqli_fetch_array($query3)){
																	if($row3['idProcedimiento'] == 6 || $row3['idProcedimiento'] == 4){
																		$query4 = mysqli_query($link,"SELECT * FROM SubProceso WHERE idProcedimiento = '{$row['valor']}'");
																		while($row4 = mysqli_fetch_array($query4)){
																			$html.= "<td>{$row4['descripcion']}</td>";
																			$flag2 = false;
																		}
																	}else{
																		$html.= "<td>{$row3['descripcion']}</td>";
																	}
																}
															}
															$query2 = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idComponenteEspecifico = '{$row['idComponenteEspecifico']}'");
															while($row2 = mysqli_fetch_array($query2)){
																$query3 = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE idComponente = '{$row2['idComponente']}'");
																while($row3 = mysqli_fetch_array($query3)){
																	$html.= "<td>{$row3['descripcion']}</td>";
																}
															}
														}
														$arrayValido = [6,7,11,12,17,18,23,24,29,30,34,35];
														foreach($arrayValido as $validez){
															if($row['idSubProcesoCaracteristica'] == $validez){
																$html.= "<td>{$row['valor']}</td>";
															}
														}
														$query2 = mysqli_query($link,"SELECT * FROM SubProcesoCaracteristica WHERE idSubProcesoCaracteristica = '{$row['idSubProcesoCaracteristica']}'");
														while($row2 = mysqli_fetch_array($query2)){
															if($row2['idCaracteristica'] == 7){
																$html.= "</tr>";
															}
														}
													}
											$html.= "
                                                </tbody>
                                                </table>
												";


	                                            $html.= '
                            </div>
                        </div>
                </section>
    ';

	$html .='
        </body>
    </html>
    ';

	$htmlheader='
        <header>
            <div id="descripcionbrand">
                <img width="auto" height="60" src="img/WakasNavbar.png"/>
            </div>
            <div id="tituloreporte">
                <div class="titulo">
                    <h4>Hoja de Especificaciones</h4>
                    <span class="desctitulo">PROD '.$_POST['idProductoCrear'].'</span>
                </div>
            </div>
        </header>
    ';
	$htmlfooter='
          <div class="footer">
                <span style="font-size: 10px;">Waka-s Textiles Finos SAC. </span>
                                   
                                 
                              
                <span style="font-size: 10px">© 2017 by Global Software Dynamics.Visítanos en <a target="GSD" href="http://www.gsdynamics.com/">GSDynamics.com</a></span>
          </div>
    ';

	$nombrearchivo='HE - '.$_POST['idProductoCrear'].'.pdf';
	$mpdf = new mPDF('utf8','A4',0,'',15,15,35,35,6,6);
// Write some HTML code:
	$mpdf->SetHTMLHeader($htmlheader);
	$mpdf->SetHTMLFooter($htmlfooter);
	$mpdf->WriteHTML($html);
// Output a PDF file directly to the browser
	$mpdf->Output($nombrearchivo,'D');
	?>