<?php
include('session.php');
if(isset($_SESSION['login'])){
	include('header.php');
	include('navbarAdmin.php');
	include('funciones.php');
	include('declaracionFechas.php');
	$flag = true;

	if(isset($_POST['addTipoProducto'])){
		$insert = mysqli_query($link, "INSERT INTO TipoProducto(descripcion,tamanoLote,cantidadMaterial) VALUES ('{$_POST['descripcionTipoProducto']}','{$_POST['tamanoLote']}','{$_POST['cantidadMaterial']}')");

		$queryPerformed = "INSERT INTO TipoProducto VALUES ({$_POST['descripcionTipoProducto']},{$_POST['tamanoLote']},{$_POST['cantidadMaterial']})";

		$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT TIPO PRODUCTO','INSERT','{$queryPerformed}')");
	}

	if(isset($_POST['addCodificacion'])){
		$insert = mysqli_query($link, "INSERT INTO codificacionTalla(descripcion) VALUES ('{$_POST['codificacion']}')");

		$queryPerformed = "INSERT INTO codificacionTalla(descripcion) VALUES ({$_POST['codificacion']})";

		$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT CODIF. TALLA','INSERT','{$queryPerformed}')");
	}

	if(isset($_POST['addTalla'])){
		$insert = mysqli_query($link, "INSERT INTO Talla(descripcion,idcodificacionTalla) VALUES ('{$_POST['talla']}','{$_POST['codificacionTallaSelect']}')");

		$queryPerformed = "INSERT INTO Talla(descripcion,idcodificacionTalla) VALUES ({$_POST['talla']},{$_POST['codificacionTallaSelect']})";

		$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT TALLA','INSERT','{$queryPerformed}')");
	}

	if(isset($_POST['addCliente'])){
		$insert = mysqli_query($link, "INSERT INTO Cliente (idCliente,idEstado,nombre) VALUES ('{$_POST['ruc']}',1,'{$_POST['razonSocial']}')");

		$queryPerformed = "INSERT INTO Cliente (idCliente,idEstado,nombre) VALUES ({$_POST['ruc']},1,{$_POST['razonSocial']})";

		$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT CLIENTE','INSERT','{$queryPerformed}')");
	}

	if(isset($_POST['addProducto'])){
	    if(isset($_POST['idProductoSimilar'])){
		    if($_POST['idProductoCrear'] == ''){
			    $flag = false;
		    }

		    $search = mysqli_query($link,"SELECT * FROM Producto WHERE idProducto = '{$_POST['idProductoCrear']}'");
		    while($index = mysqli_fetch_array($search)){
			    $flag = false;
		    }
        }else{
		    if($_POST['idProductoCrear'] == ''){
			    $flag = false;
		    }

		    $search = mysqli_query($link,"SELECT * FROM Producto WHERE idProducto = '{$_POST['idProductoCrear']}'");
		    while($index = mysqli_fetch_array($search)){
			    $flag = false;
		    }

		    if(!isset($_POST['genero']) || $_POST['genero'] == ''){
			    $flag = false;
		    }

		    if(!isset($_POST['tipoProducto']) || $_POST['tipoProducto'] == ''){
			    $flag = false;
		    }

		    if(!isset($_POST['codificacionTalla']) || $_POST['codificacionTalla'] == ''){
			    $flag = false;
		    }

		    if(!isset($_POST['idCliente']) || $_POST['idCliente'] == ''){
			    $flag = false;
		    }
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

				if (isset($_POST['codificacionMaterial'])) {
					$codificacionMaterial = $_POST['codificacionMaterial'];
				} else {
					$codificacionMaterial = null;
				}

				if(isset($_POST['idProductoSimilar'])){
				    $query = mysqli_query($link,"SELECT * FROM Producto WHERE idProducto = '{$_POST['idProductoSimilar']}'");
				    while($row = mysqli_fetch_array($query)){
				        $tipoProducto = $row['idTipoProducto'];
				        $cliente = $row['idCliente'];
				        $genero = $row['idgenero'];
				        $codificacionTalla = $row['idcodificacionTalla'];
				        $observaciones = $row['observaciones'];
				        $descripcionGeneral = $row['descripcionGeneral'];
				        $codificacionMaterial = $row['codificacionMaterial'];
                    }

					$insert = mysqli_query($link, "INSERT INTO Producto VALUES ('{$_POST['idProductoCrear']}','{$tipoProducto}','{$cliente}',
												'{$_SESSION['user']}','{$genero}','{$codificacionTalla}',1,'{$idProvisional}','{$date}',
												'{$observaciones}','{$descripcionGeneral}','{$codificacionMaterial}')");

					$queryPerformed = "INSERT INTO Producto VALUES ({$_POST['idProductoCrear']},{$tipoProducto},{$cliente},
												{$_SESSION['user']},{$genero},{$codificacionTalla},1,{$idProvisional},{$date},
												{$observaciones},{$descripcionGeneral},{$codificacionMaterial})";

					$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT PRODUCTO SIMILAR','INSERT','{$queryPerformed}')");

					$query = mysqli_query($link,"SELECT * FROM ProductoMedida WHERE idProducto = '{$_POST['idProductoSimilar']}'");
					while($row = mysqli_fetch_array($query)){
						$insert = mysqli_query($link,"INSERT INTO ProductoMedida (idProducto, idMedida, tolerancia, observacion, indice) VALUES 
                                  ('{$_POST['idProductoCrear']}','{$row['idMedida']}','{$row['tolerancia']}','{$row['observacion']}','{$row['indice']}')");

						$queryPerformed = "INSERT INTO ProductoMedida (idProducto, idMedida, tolerancia, observacion, indice) VALUES 
                                  ({$_POST['idProductoCrear']},{$row['idMedida']},{$row['tolerancia']},{$row['observacion']},{$row['indice']})";

						$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT MEDIDAS PRODUCTO SIMILAR','INSERT','{$queryPerformed}')");
					}

					$query = mysqli_query($link,"SELECT * FROM TallaMedida WHERE idProducto = '{$_POST['idProductoSimilar']}'");
					while($row = mysqli_fetch_array($query)){
						$insert = mysqli_query($link,"INSERT INTO TallaMedida (idProducto, idTalla, idMedida, valor) VALUES 
                                  ('{$_POST['idProductoCrear']}','{$row['idTalla']}','{$row['idMedida']}','{$row['valor']}')");

						$queryPerformed = "INSERT INTO TallaMedida (idProducto, idTalla, idMedida, valor) VALUES 
                                  ({$_POST['idProductoCrear']},{$row['idTalla']},{$row['idMedida']},{$row['valor']})";

						$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT TALLAS PRODUCTO SIMILAR','INSERT','{$queryPerformed}')");
					}

					$query = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idProducto = '{$_POST['idProductoSimilar']}'");
					while($row = mysqli_fetch_array($query)){
						$insert = mysqli_query($link,"INSERT INTO ProductoComponentesPrenda(idProducto, idComponente, idMaterial, cantidadMaterial, codigoColor, numMetrico) VALUES 
                                  ('{$_POST['idProductoCrear']}','{$row['idComponente']}','{$row['idMaterial']}','{$row['cantidadMaterial']}','{$row['codigoColor']}','{$row['numMetrico']}')");

						if(!$insert){
							$insert = mysqli_query($link,"INSERT INTO ProductoComponentesPrenda(idProducto, idComponente, idMaterial, cantidadMaterial, codigoColor, numMetrico) VALUES 
                                  ('{$_POST['idProductoCrear']}','{$row['idComponente']}',null,null,null,null)");
                        }

						$queryPerformed = "INSERT INTO ProductoComponentesPrenda(idProducto, idComponente, idMaterial, cantidadMaterial, codigoColor, numMetrico) VALUES 
                                  ({$_POST['idProductoCrear']},{$row['idComponente']},{$row['idMaterial']},{$row['cantidadMaterial']},{$row['codigoColor']},{$row['numMetrico']})";

						$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT COMPONENTES PRODUCTO SIMILAR','INSERT','{$queryPerformed}')");
					}
				}else{
					$insert = mysqli_query($link, "INSERT INTO Producto VALUES ('{$_POST['idProductoCrear']}','{$_POST['tipoProducto']}','{$_POST['idCliente']}',
												'{$_SESSION['user']}','{$_POST['genero']}','{$_POST['codificacionTalla']}',1,'{$idProvisional}','{$date}',
												'{$observaciones}','{$descripcionGeneral}','{$codificacionMaterial}')");

					$queryPerformed = "INSERT INTO Producto VALUES ({$_POST['idProductoCrear']},{$_POST['tipoProducto']},{$_POST['idCliente']},
												{$_SESSION['user']},{$_POST['genero']},{$_POST['codificacionTalla']},1,{$idProvisional},{$date},
												{$observaciones},{$descripcionGeneral},{$codificacionMaterial})";

					$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT PRODUCTO','INSERT','{$queryPerformed}')");

					$insert = mysqli_query($link,"INSERT INTO ProductoComponentesPrenda(idProducto,idComponente,idMaterial,cantidadMaterial,codigoColor,numMetrico) VALUES 
                          ('{$_POST['idProductoCrear']}',1,NULL,NULL,NULL,NULL)");

					$queryPerformed = "INSERT INTO ProductoComponentesPrenda(idProducto,idComponente,idMaterial,cantidadMaterial,codigoColor,numMetrico) VALUES 
                          ({$_POST['idProductoCrear']},1,NULL,NULL,NULL,NULL)";

					$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT COMPONENTE PRENDA','INSERT','{$queryPerformed}')");
                }
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
	                $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','BAJAR PRODUCTOMEDIDA','UPDATE','{$queryPerformed}')");

	                $update = mysqli_query($link, "UPDATE ProductoMedida SET indice = '{$indice}' WHERE indice = '{$indiceSup}'");
	                $queryPerformed = "UPDATE ProductoMedida SET indice = {$indice} WHERE indice = {$indiceSup}";
	                $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','BAJAR PRODUCTOMEDIDA','UPDATE','{$queryPerformed}')");

	                $update = mysqli_query($link, "UPDATE ProductoMedida SET indice = '{$indiceSup}' WHERE indice = -1");
	                $queryPerformed = "UPDATE ProductoMedida SET indice = {$indiceSup} WHERE indice = -1";
	                $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','BAJAR PRODUCTOMEDIDA','UPDATE','{$queryPerformed}')");
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

			if(isset($_POST['addComponente'])){
				$insert = mysqli_query($link,"INSERT INTO ProductoComponentesPrenda(idProducto, idComponente, idMaterial, cantidadMaterial, codigoColor,numMetrico) VALUES ('{$_POST['idProductoCrear']}','{$_POST['selectComponente']}','{$_POST['selectMaterial']}','{$_POST['cantidad']}','{$_POST['color']}','{$_POST['numMetrico']}')");
				$queryPerformed = "INSERT INTO ProductoComponentesPrenda(idProducto, idComponente, idMaterial, cantidadMaterial, codigoColor) VALUES ({$_POST['idProductoCrear']},{$_POST['selectComponente']},{$_POST['selectMaterial']},{$_POST['cantidad']},{$_POST['color']},{$_POST['numMetrico']})";
				$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT COMPONENTE','INSERT','{$queryPerformed}')");
			}

			if(isset($_POST['addParte'])){
				$insert = mysqli_query($link,"INSERT INTO ProductoComponentesPrenda(idProducto, idComponente, idMaterial, cantidadMaterial, codigoColor,numMetrico) VALUES ('{$_POST['idProductoCrear']}','{$_POST['selectParte']}',null,null,null,null)");
				$queryPerformed = "INSERT INTO ProductoComponentesPrenda(idProducto, idComponente, idMaterial, cantidadMaterial, codigoColor) VALUES ({$_POST['idProductoCrear']},{$_POST['selectParte']},null,null,null)";
				$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT PARTE','INSERT','{$queryPerformed}')");
			}

			if(isset($_POST['eliminarComponente']) || isset($_POST['eliminarParte'])){
			    $delete = mysqli_query($link,"DELETE FROM ProductoComponentesPrenda WHERE idProducto = '{$_POST['idProductoCrear']}' AND idComponente = '{$_POST['componenteSelect']}'");
				$queryPerformed = "DELETE FROM ProductoComponentesPrenda WHERE idProducto = {$_POST['idProductoCrear']} AND idComponente = {$_POST['componenteSelect']}";
				$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','DELETE COMPONENTE/PARTE','DELETE','{$queryPerformed}')");
            }

			if(isset($_POST['actualizarProducto'])){
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

				if (isset($_POST['codificacionMaterial'])) {
					$codificacionMaterial = $_POST['codificacionMaterial'];
				} else {
					$codificacionMaterial = null;
				}

				$update = mysqli_query($link,"UPDATE Producto SET idProducto = '{$_POST['idProductoCrear']}' , idTipoProducto = '{$_POST['tipoProducto']}' , idCliente = '{$_POST['idCliente']}' ,
												creador = '{$_SESSION['user']}' , idgenero = '{$_POST['genero']}' , idcodificacionTalla = '{$_POST['codificacionTalla']}', idEstado = 1 , idProvisional = '{$idProvisional}' ,
												fechaCreacion = '{$date}' , observaciones = '{$observaciones}' , descripcionGeneral = '{$descripcionGeneral}' , codificacionMaterial = '{$codificacionMaterial}'
												WHERE idProducto = '{$_POST['idProductoCrear']}'");
				$queryPerformed = "UPDATE Producto SET idProducto = {$_POST['idProductoCrear']} , idTipoProducto = {$_POST['tipoProducto']} , idCliente = {$_POST['idCliente']} ,
												creador = {$_SESSION['user']} , idgenero = {$_POST['genero']} , idcodificacionTalla = {$_POST['codificacionTalla']}, idEstado = 1 , idProvisional = {$idProvisional} ,
												fechaCreacion = {$date} , observaciones = {$observaciones} , descripcionGeneral = {$descripcionGeneral} , codificacionMaterial = {$codificacionMaterial}
												WHERE idProducto = {$_POST['idProductoCrear']}";
				$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','UPDATE PRODUCTO','UPDATE','{$queryPerformed}')");
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
                                            <button name="actualizarProducto" type="submit" class="btn btn-light btn-sm" form="formSiguiente" formaction="#">Guardar</button>
                                            <button name="siguienteHE2" type="submit" class="btn btn-light btn-sm" form="formSiguiente">Siguiente</button>
										</div>
									</div>
								</div>
								<div class="card-block">
									<div class="col-12">
										<?php
										$activoGeneral = '';
										$activoMedidas = '';
										$activoComponentes = '';
										$activoPartes = '';
										if(isset($_POST['addTipoProducto']) || isset($_POST['addCodificacion']) || isset($_POST['addCliente']) || isset($_POST['addTalla']) || isset($_POST['editarProducto'])){
											$activoGeneral = 'active';
										}
										if(isset($_POST['addMedida']) || isset($_POST['medidaSelect']) || isset($_POST['addProducto']) || isset($_POST['actualizarProducto']) || isset($_POST['volver'])){
										    $activoMedidas = 'active';
                                        }
										if(isset($_POST['addComponente']) || isset($_POST['eliminarComponente'])){
											$activoComponentes = 'active';
										}
										if(isset($_POST['addParte']) || isset($_POST['eliminarParte'])){
											$activoPartes = 'active';
										}
										?>
										<div class="spacer20"></div>
										<ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link <?php echo $activoGeneral;?>" data-toggle="tab" href="#general" role="tab">Datos Generales</a>
                                            </li>
                                            <li class="nav-item">
												<a class="nav-link <?php echo $activoMedidas;?>" data-toggle="tab" href="#medidas" role="tab">Medidas y Tallas</a>
											</li>
											<li class="nav-item">
												<a class="nav-link <?php echo $activoComponentes;?>" data-toggle="tab" href="#componentes" role="tab">Componentes</a>
											</li>
                                            <li class="nav-item">
                                                <a class="nav-link <?php echo $activoPartes;?>" data-toggle="tab" href="#partes" role="tab">Partes</a>
                                            </li>
										</ul>
										<div class="tab-content">
                                            <div class="tab-pane <?php echo $activoGeneral;?>" id="general" role="tabpanel">
                                                <div class="spacer20"></div>
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
                                                <form action="nuevaHE3.php" method="post" id="formSiguiente">
                                                    <input type="hidden" name="idProductoCrear" value="<?php echo $_POST['idProductoCrear']?>">
                                                <div class="form-group row">
                                                    <label for="idProd" class="col-2 col-form-label">ID Producto:</label>
                                                    <div class="col-10">
                                                        <input class="form-control" type="text" id="idProd" name="idProd" value="<?php echo $_POST['idProductoCrear']?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="idProvisional" class="col-2 col-form-label">ID Provisional Cliente:</label>
                                                    <div class="col-10">
                                                        <input class="form-control" type="text" id="idProvisional" name="idProvisional" value="<?php echo $idProvisional;?>">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="genero" class="col-2 col-form-label">Género:</label>
                                                    <div class="col-6">
                                                        <select class="form-control" name="genero" id="genero">
				                                            <?php
				                                            $query = mysqli_query($link,"SELECT * FROM Genero WHERE idGenero = {$genero}");
				                                            while($row = mysqli_fetch_array($query)){
					                                            echo "<option selected value='{$row['idgenero']}'>{$row['descripcion']}</option>";
				                                            }
				                                            $query = mysqli_query($link,"SELECT * FROM Genero");
				                                            while($row = mysqli_fetch_array($query)){
					                                            if($row['idgenero'] == $genero){
					                                            }else{
						                                            echo "<option value='{$row['idgenero']}'>{$row['descripcion']}</option>";
					                                            }
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
				                                            $query = mysqli_query($link,"SELECT * FROM TipoProducto WHERE idTipoProducto = {$tipoProducto}");
				                                            while($row = mysqli_fetch_array($query)){
					                                            echo "<option selected value='{$row['idTipoProducto']}'>{$row['descripcion']}</option>";
				                                            }
				                                            $query = mysqli_query($link,"SELECT * FROM TipoProducto");
				                                            while($row = mysqli_fetch_array($query)){
					                                            if($row['idTipoProducto'] == $tipoProducto){
					                                            }else{
						                                            echo "<option value='{$row['idTipoProducto']}'>{$row['descripcion']}</option>";
					                                            }
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
				                                            $query = mysqli_query($link,"SELECT * FROM codificacionTalla WHERE idcodificacionTalla = {$idCodificacionTalla}");
				                                            while($row = mysqli_fetch_array($query)){
					                                            echo "<option selected value='{$row['idcodificacionTalla']}'>{$row['descripcion']}</option>";
				                                            }
				                                            $query = mysqli_query($link,"SELECT * FROM codificacionTalla");
				                                            while($row = mysqli_fetch_array($query)){
					                                            if($row['idcodificacionTalla'] == $idCodificacionTalla){
					                                            } else {
						                                            echo "<option value='{$row['idcodificacionTalla']}'>{$row['descripcion']}</option>";
					                                            }
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
				                                            $query = mysqli_query($link,"SELECT * FROM Cliente WHERE idCliente = {$cliente}");
				                                            while($row = mysqli_fetch_array($query)){
					                                            echo "<option selected value='{$row['idCliente']}'>{$row['nombre']}</option>";
				                                            }
				                                            $query = mysqli_query($link,"SELECT * FROM Cliente WHERE idEstado = 1");
				                                            while($row = mysqli_fetch_array($query)){
					                                            if($row['idCliente'] == $cliente){
					                                            } else {
						                                            echo "<option value='{$row['idCliente']}'>{$row['nombre']}</option>";
					                                            }
				                                            }
				                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-2">
                                                        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modalCliente">Agregar Cliente</button>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="descripcionGeneral" class="col-2 col-form-label">Descripción General:</label>
                                                    <div class="col-10">
                                                        <textarea class="form-control" name="descripcionGeneral" id="descripcionGeneral"><?php echo $descripcionGeneral;?></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="observaciones" class="col-2 col-form-label">Observaciones Generales:</label>
                                                    <div class="col-10">
                                                        <textarea class="form-control" name="observaciones" id="observaciones"><?php echo $observaciones;?></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="codificacionMaterial" class="col-2 col-form-label">Codificación de Material para CV:</label>
                                                    <div class="col-10">
                                                        <textarea class="form-control" name="codificacionMaterial" id="codificacionMaterial"><?php echo $codificacionMaterial;?></textarea>
                                                    </div>
                                                </div>
                                                </form>
                                            </div>
											<div class="tab-pane <?php echo $activoMedidas;?>" id="medidas" role="tabpanel">
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
	                                                        $search2 = mysqli_query($link,"SELECT * FROM Talla WHERE idcodificacionTalla = '{$index['idcodificacionTalla']}' ORDER BY indice ASC");
	                                                        while($index2 = mysqli_fetch_array($search2)){
	                                                            echo "<th class=\"text-center\" style='width:6.5%;'>{$index2['descripcion']}</th>";
                                                            }
                                                        }
                                                        ?>
                                                        <th class="text-center" style="width: 6%">T(+/-)</th>
                                                        <th class="text-center">Observación</th>
                                                        <th class="text-center">Acciones</th>
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
	                                                        echo "<td class='text-center'><input type='number' min='0' step='0.01' class='form-control' name='add{$index['idTalla']}'></td>";
                                                        }
                                                        ?>
                                                        <td class="text-center"><input type="number" min="0" step="0.01" class="form-control" name="tolerancia"></td>
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
											<div class="tab-pane <?php echo $activoComponentes;?>" id="componentes" role="tabpanel">
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
                                                            <th class="text-center">Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <form method="post" action="#">
		                                                        <?php
		                                                        echo "<td><select name='selectComponente' class='form-control' autofocus>
                                                                          <option selected disabled>Seleccionar</option>";
		                                                        $result2 = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE tipo = 1 ORDER BY descripcion ASC");
		                                                        while ($fila2 = mysqli_fetch_array($result2)){
			                                                        echo "<option value='".$fila2['idComponente']."'>".$fila2['descripcion']."</option>";
		                                                        }
		                                                        echo "</select></td>";
		                                                        echo "<td><select name='selectMaterial' class='form-control' onchange='getUnidadMedida(this.value)'>
                                                                          <option selected disabled>Seleccionar</option>";
		                                                        $result2 = mysqli_query($link,"SELECT * FROM Material ORDER BY material ASC");
		                                                        while ($fila2 = mysqli_fetch_array($result2)){
			                                                        echo "<option value='".$fila2['idMaterial']."'>".$fila2['material']."</option>";
		                                                        }
		                                                        echo "</select></td>";
		                                                        ?>
                                                                <td class="text-center" id="unidadMedida"></td>
                                                                <td class="text-center"><input type='text' class='form-control' name='numMetrico' placeholder='Número Métrico'></td>
                                                                <?php
	                                                            echo "<td><input type='text' class='form-control' name='color' placeholder='Código de Patrón'></td>";
	                                                            ?>
	                                                            <?php
	                                                            echo "<td><input type='number' class='form-control' name='cantidad' step='0.01' placeholder='Cantidad de Material'></td>";
	                                                            ?>
                                                                <td class="text-center"><input type="submit" name="addComponente" value="Agregar" class="btn btn-outline-primary"></td>
                                                                <input type="hidden" name="idProductoCrear" value="<?php echo $_POST['idProductoCrear']?>">
                                                            </form>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="7"></td>
                                                        </tr>
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
	                                                            echo "<td class='text-center'>
                                                                <form method='post' action='#'>
                                                                <div>
                                                                    <input type='hidden' name='idProductoCrear' value='{$_POST['idProductoCrear']}'>
                                                                    <input type='hidden' name='componenteSelect' value='{$row['idComponente']}'>
                                                                    <button class='btn btn-outline-secondary btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                                    Acciones</button>
                                                                    <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                                                        <input name='eliminarComponente' class='dropdown-item' type='submit' formaction='#' value='Eliminar'>
                                                                    </div>
                                                                </div>
                                                                </form>
                                                                </td>";
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
                                                        <th class="text-center">Acciones</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <form method="post" action="#">
															<?php
															echo "<td><select name='selectParte' class='form-control' autofocus>";
															$result2 = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE tipo = 2 ORDER BY descripcion ASC");
															while ($fila2 = mysqli_fetch_array($result2)){
																echo "<option value='".$fila2['idComponente']."'>".$fila2['descripcion']."</option>";
															}
															echo "</select></td>";
															?>
                                                            <td class="text-center"><input type="submit" name="addParte" value="Agregar" class="btn btn-outline-primary"></td>
                                                            <input type="hidden" name="idProductoCrear" value="<?php echo $_POST['idProductoCrear']?>">
                                                        </form>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2"></td>
                                                    </tr>
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
		                                                    echo "<td class='text-center'>
                                                                <form method='post' action='#'>
                                                                <div>
                                                                    <input type='hidden' name='idProductoCrear' value='{$_POST['idProductoCrear']}'>
                                                                    <input type='hidden' name='componenteSelect' value='{$row['idComponente']}'>
                                                                    <button class='btn btn-outline-secondary btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                                    Acciones</button>
                                                                    <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                                                        <input name='eliminarParte' class='dropdown-item' type='submit' formaction='#' value='Eliminar'>
                                                                    </div>
                                                                </div>
                                                                </form>
                                                                </td>";
		                                                    echo "</tr>";
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

            <form method="post" action="#" id="formProducto">
                <input type="hidden" name="idProductoCrear" value="<?php echo $_POST['idProductoCrear'];?>">
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
                                <div class="form-group row">
                                    <label class="col-form-label" for="cantidadMaterial">Cantidad de Material (Kg):</label>
                                    <input type="text" name="cantidadMaterial" id="cantidadMaterial" class="form-control">
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
                                    <label class="col-form-label" for="codificacionTallaSelect">Seleccionar Codificación:</label>
                                    <select name="codificacionTallaSelect" id="codificacionTallaSelect" class="form-control" onchange="getTablaTallas(this.value)">
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
                                <div id="tablaTallas"></div>
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