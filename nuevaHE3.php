<?php
include('session.php');
if(isset($_SESSION['login'])){
	include('header.php');
	include('navbarAdmin.php');
	include('funciones.php');
	include('declaracionFechas.php');

		// Éxito en la creación del producto
    $selectTab = 0;

	if(isset($_POST['insertar'])){
        $indiceInsertar = $_POST['indice'];
		echo "<section class='container'>
                        <div class='alert alert-info' role='alert'>
                            Insertar activado.
                        </div>
                    </section>";
	}

    if(isset($_POST['addTejido'])){
        $aux = 1;
	    $query2 = mysqli_query($link,"SELECT DISTINCT indice FROM PCPSPC WHERE idProducto = '{$_POST['idProductoCrear']}'");
	    while($row2 = mysqli_fetch_array($query2)){
		    $aux++;
	    }

	    if(isset($_POST['insertFila']) && $_POST['insertFila']!='NA'){
		    $aux = $_POST['insertFila'];

		    $query = mysqli_query($link,"SELECT * FROM PCPSPC WHERE idProducto = '{$_POST['idProductoCrear']}' AND indice > '{$aux}' ORDER BY indice DESC");
		    while($row = mysqli_fetch_array($query)){
			    $indiceSup = $row['indice'] + 1;
			    $update = mysqli_query($link, "UPDATE PCPSPC SET indice = '{$indiceSup}' WHERE idProducto = '{$_POST['idProductoCrear']}' AND indice = '{$row['indice']}'");
			    $queryPerformed = "UPDATE PCPSPC SET indice = {$indiceSup} WHERE idProducto = {$_POST['idProductoCrear']} AND indice = {$row['indice']}";
			    $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','FIX INDEX AFTER INSERT PCPSPC','UPDATE','{$queryPerformed}')");
		    }

		    $aux++;
	    }

        $insert = mysqli_query($link,"INSERT INTO PCPSPC (idProducto, idComponenteEspecifico, idSubProcesoCaracteristica, valor, indice) VALUES 
                                            ('{$_POST['idProductoCrear']}','{$_POST['selectComponente']}','3','{$_POST['selectTipoTejido']}','{$aux}')");

        $galgas = '';
	    foreach ($_POST['galgas'] as $galga) {
		    $galgas .= $galga.", ";
	    }
	    $galgas = substr($galgas,0,(strlen($galgas)-2));
	    $insert = mysqli_query($link,"INSERT INTO PCPSPC (idProducto, idComponenteEspecifico, idSubProcesoCaracteristica, valor, indice) VALUES 
                                            ('{$_POST['idProductoCrear']}','{$_POST['selectComponente']}','4','{$galgas}','{$aux}')");

	    $insert = mysqli_query($link,"INSERT INTO PCPSPC (idProducto, idComponenteEspecifico, idSubProcesoCaracteristica, valor, indice) VALUES 
                                            ('{$_POST['idProductoCrear']}','{$_POST['selectComponente']}','5','{$_POST['comprobacionTejido']}','{$aux}')");

	    $insert = mysqli_query($link,"INSERT INTO PCPSPC (idProducto, idComponenteEspecifico, idSubProcesoCaracteristica, valor, indice) VALUES 
                                            ('{$_POST['idProductoCrear']}','{$_POST['selectComponente']}','6','{$_POST['observaciones']}','{$aux}')");

	    $insert = mysqli_query($link,"INSERT INTO PCPSPC (idProducto, idComponenteEspecifico, idSubProcesoCaracteristica, valor, indice) VALUES 
                                            ('{$_POST['idProductoCrear']}','{$_POST['selectComponente']}','7','{$_POST['tiempo']}','{$aux}')");
    }

	if(isset($_POST['addLavado'])){
		$aux = 1;
		$query2 = mysqli_query($link,"SELECT DISTINCT indice FROM PCPSPC WHERE idProducto = '{$_POST['idProductoCrear']}'");
		while($row2 = mysqli_fetch_array($query2)){
			$aux++;
		}

		if(isset($_POST['insertFila']) && $_POST['insertFila']!='NA'){
			$aux = $_POST['insertFila'];

			$query = mysqli_query($link,"SELECT * FROM PCPSPC WHERE idProducto = '{$_POST['idProductoCrear']}' AND indice > '{$aux}' ORDER BY indice DESC");
			while($row = mysqli_fetch_array($query)){
				$indiceSup = $row['indice'] + 1;
				$update = mysqli_query($link, "UPDATE PCPSPC SET indice = '{$indiceSup}' WHERE idProducto = '{$_POST['idProductoCrear']}' AND indice = '{$row['indice']}'");
				$queryPerformed = "UPDATE PCPSPC SET indice = {$indiceSup} WHERE idProducto = {$_POST['idProductoCrear']} AND indice = {$row['indice']}";
				$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','FIX INDEX AFTER INSERT PCPSPC','UPDATE','{$queryPerformed}')");
			}

			$aux++;
		}

		$insert = mysqli_query($link,"INSERT INTO PCPSPC (idProducto, idComponenteEspecifico, idSubProcesoCaracteristica, valor, indice) VALUES 
                                            ('{$_POST['idProductoCrear']}','{$_POST['selectComponente']}','9','{$_POST['selectTipoLavado']}','{$aux}')");

		$insert = mysqli_query($link,"INSERT INTO PCPSPC (idProducto, idComponenteEspecifico, idSubProcesoCaracteristica, valor, indice) VALUES 
                                            ('{$_POST['idProductoCrear']}','{$_POST['selectComponente']}','10','{$_POST['programa']}','{$aux}')");

		$insert = mysqli_query($link,"INSERT INTO PCPSPC (idProducto, idComponenteEspecifico, idSubProcesoCaracteristica, valor, indice) VALUES 
                                            ('{$_POST['idProductoCrear']}','{$_POST['selectComponente']}','11','{$_POST['observaciones']}','{$aux}')");

		$insert = mysqli_query($link,"INSERT INTO PCPSPC (idProducto, idComponenteEspecifico, idSubProcesoCaracteristica, valor, indice) VALUES 
                                            ('{$_POST['idProductoCrear']}','{$_POST['selectComponente']}','12','{$_POST['tiempo']}','{$aux}')");
	}

	if(isset($_POST['addSecado'])){
		$aux = 1;
		$query2 = mysqli_query($link,"SELECT DISTINCT indice FROM PCPSPC WHERE idProducto = '{$_POST['idProductoCrear']}'");
		while($row2 = mysqli_fetch_array($query2)){
			$aux++;
		}

		if(isset($_POST['insertFila']) && $_POST['insertFila']!='NA'){
			$aux = $_POST['insertFila'];

			$query = mysqli_query($link,"SELECT * FROM PCPSPC WHERE idProducto = '{$_POST['idProductoCrear']}' AND indice > '{$aux}' ORDER BY indice DESC");
			while($row = mysqli_fetch_array($query)){
				$indiceSup = $row['indice'] + 1;
				$update = mysqli_query($link, "UPDATE PCPSPC SET indice = '{$indiceSup}' WHERE idProducto = '{$_POST['idProductoCrear']}' AND indice = '{$row['indice']}'");
				$queryPerformed = "UPDATE PCPSPC SET indice = {$indiceSup} WHERE idProducto = {$_POST['idProductoCrear']} AND indice = {$row['indice']}";
				$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','FIX INDEX AFTER INSERT PCPSPC','UPDATE','{$queryPerformed}')");
			}

			$aux++;
		}

		$insert = mysqli_query($link,"INSERT INTO PCPSPC (idProducto, idComponenteEspecifico, idSubProcesoCaracteristica, valor, indice) VALUES 
                                            ('{$_POST['idProductoCrear']}','{$_POST['selectComponente']}','14','{$_POST['selectTipoSecado']}','{$aux}')");

		$insert = mysqli_query($link,"INSERT INTO PCPSPC (idProducto, idComponenteEspecifico, idSubProcesoCaracteristica, valor, indice) VALUES 
                                            ('{$_POST['idProductoCrear']}','{$_POST['selectComponente']}','15','{$_POST['programa']}','{$aux}')");

		$insert = mysqli_query($link,"INSERT INTO PCPSPC (idProducto, idComponenteEspecifico, idSubProcesoCaracteristica, valor, indice) VALUES 
                                            ('{$_POST['idProductoCrear']}','{$_POST['selectComponente']}','16','{$_POST['rotacion']}','{$aux}')");

		$insert = mysqli_query($link,"INSERT INTO PCPSPC (idProducto, idComponenteEspecifico, idSubProcesoCaracteristica, valor, indice) VALUES 
                                            ('{$_POST['idProductoCrear']}','{$_POST['selectComponente']}','17','{$_POST['observaciones']}','{$aux}')");

		$insert = mysqli_query($link,"INSERT INTO PCPSPC (idProducto, idComponenteEspecifico, idSubProcesoCaracteristica, valor, indice) VALUES 
                                            ('{$_POST['idProductoCrear']}','{$_POST['selectComponente']}','18','{$_POST['tiempo']}','{$aux}')");
	}

	if(isset($_POST['addConfeccion'])){
		$aux = 1;
		$query2 = mysqli_query($link,"SELECT DISTINCT indice FROM PCPSPC WHERE idProducto = '{$_POST['idProductoCrear']}'");
		while($row2 = mysqli_fetch_array($query2)){
			$aux++;
		}

		if(isset($_POST['insertFila']) && $_POST['insertFila']!='NA'){
			$aux = $_POST['insertFila'];

			$query = mysqli_query($link,"SELECT * FROM PCPSPC WHERE idProducto = '{$_POST['idProductoCrear']}' AND indice > '{$aux}' ORDER BY indice DESC");
			while($row = mysqli_fetch_array($query)){
				$indiceSup = $row['indice'] + 1;
				$update = mysqli_query($link, "UPDATE PCPSPC SET indice = '{$indiceSup}' WHERE idProducto = '{$_POST['idProductoCrear']}' AND indice = '{$row['indice']}'");
				$queryPerformed = "UPDATE PCPSPC SET indice = {$indiceSup} WHERE idProducto = {$_POST['idProductoCrear']} AND indice = {$row['indice']}";
				$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','FIX INDEX AFTER INSERT PCPSPC','UPDATE','{$queryPerformed}')");
			}

			$aux++;
		}

		$insert = mysqli_query($link,"INSERT INTO PCPSPC (idProducto, idComponenteEspecifico, idSubProcesoCaracteristica, valor, indice) VALUES 
                                            ('{$_POST['idProductoCrear']}','{$_POST['selectComponente']}','20','{$_POST['selectProcedimiento']}','{$aux}')");

		$insert = mysqli_query($link,"INSERT INTO PCPSPC (idProducto, idComponenteEspecifico, idSubProcesoCaracteristica, valor, indice) VALUES 
                                            ('{$_POST['idProductoCrear']}','{$_POST['selectComponente']}','21','{$_POST['indicaciones']}','{$aux}')");

		$insert = mysqli_query($link,"INSERT INTO PCPSPC (idProducto, idComponenteEspecifico, idSubProcesoCaracteristica, valor, indice) VALUES 
                                            ('{$_POST['idProductoCrear']}','{$_POST['selectComponente']}','22','{$_POST['selectMaquina']}','{$aux}')");

		$insert = mysqli_query($link,"INSERT INTO PCPSPC (idProducto, idComponenteEspecifico, idSubProcesoCaracteristica, valor, indice) VALUES 
                                            ('{$_POST['idProductoCrear']}','{$_POST['selectComponente']}','23','{$_POST['observaciones']}','{$aux}')");

		$insert = mysqli_query($link,"INSERT INTO PCPSPC (idProducto, idComponenteEspecifico, idSubProcesoCaracteristica, valor, indice) VALUES 
                                            ('{$_POST['idProductoCrear']}','{$_POST['selectComponente']}','24','{$_POST['tiempo']}','{$aux}')");
	}

	if(isset($_POST['addAcondicionamiento'])){
		$aux = 1;
		$query2 = mysqli_query($link,"SELECT DISTINCT indice FROM PCPSPC WHERE idProducto = '{$_POST['idProductoCrear']}'");
		while($row2 = mysqli_fetch_array($query2)){
			$aux++;
		}

		if(isset($_POST['insertFila']) && $_POST['insertFila']!='NA'){
			$aux = $_POST['insertFila'];

			$query = mysqli_query($link,"SELECT * FROM PCPSPC WHERE idProducto = '{$_POST['idProductoCrear']}' AND indice > '{$aux}' ORDER BY indice DESC");
			while($row = mysqli_fetch_array($query)){
				$indiceSup = $row['indice'] + 1;
				$update = mysqli_query($link, "UPDATE PCPSPC SET indice = '{$indiceSup}' WHERE idProducto = '{$_POST['idProductoCrear']}' AND indice = '{$row['indice']}'");
				$queryPerformed = "UPDATE PCPSPC SET indice = {$indiceSup} WHERE idProducto = {$_POST['idProductoCrear']} AND indice = {$row['indice']}";
				$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','FIX INDEX AFTER INSERT PCPSPC','UPDATE','{$queryPerformed}')");
			}

			$aux++;
		}

		$insert = mysqli_query($link,"INSERT INTO PCPSPC (idProducto, idComponenteEspecifico, idSubProcesoCaracteristica, valor, indice) VALUES 
                                            ('{$_POST['idProductoCrear']}','{$_POST['selectComponente']}','26','{$_POST['selectInsumo']}','{$aux}')");

		$insert = mysqli_query($link,"INSERT INTO PCPSPC (idProducto, idComponenteEspecifico, idSubProcesoCaracteristica, valor, indice) VALUES 
                                            ('{$_POST['idProductoCrear']}','{$_POST['selectComponente']}','27','{$_POST['cantidad']}','{$aux}')");

		$insert = mysqli_query($link,"INSERT INTO PCPSPC (idProducto, idComponenteEspecifico, idSubProcesoCaracteristica, valor, indice) VALUES 
                                            ('{$_POST['idProductoCrear']}','{$_POST['selectComponente']}','28','{$_POST['selectMaquina']}','{$aux}')");

		$insert = mysqli_query($link,"INSERT INTO PCPSPC (idProducto, idComponenteEspecifico, idSubProcesoCaracteristica, valor, indice) VALUES 
                                            ('{$_POST['idProductoCrear']}','{$_POST['selectComponente']}','29','{$_POST['observaciones']}','{$aux}')");

		$insert = mysqli_query($link,"INSERT INTO PCPSPC (idProducto, idComponenteEspecifico, idSubProcesoCaracteristica, valor, indice) VALUES 
                                            ('{$_POST['idProductoCrear']}','{$_POST['selectComponente']}','30','{$_POST['tiempo']}','{$aux}')");
	}

	if(isset($_POST['addOtros'])){
		$aux = 1;
		$query2 = mysqli_query($link,"SELECT DISTINCT indice FROM PCPSPC WHERE idProducto = '{$_POST['idProductoCrear']}'");
		while($row2 = mysqli_fetch_array($query2)){
			$aux++;
		}

		if(isset($_POST['insertFila']) && $_POST['insertFila']!='NA'){
			$aux = $_POST['insertFila'];

			$query = mysqli_query($link,"SELECT * FROM PCPSPC WHERE idProducto = '{$_POST['idProductoCrear']}' AND indice > '{$aux}' ORDER BY indice DESC");
			while($row = mysqli_fetch_array($query)){
				$indiceSup = $row['indice'] + 1;
				$update = mysqli_query($link, "UPDATE PCPSPC SET indice = '{$indiceSup}' WHERE idProducto = '{$_POST['idProductoCrear']}' AND indice = '{$row['indice']}'");
				$queryPerformed = "UPDATE PCPSPC SET indice = {$indiceSup} WHERE idProducto = {$_POST['idProductoCrear']} AND indice = {$row['indice']}";
				$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','FIX INDEX AFTER INSERT PCPSPC','UPDATE','{$queryPerformed}')");
			}

			$aux++;
		}

		$insert = mysqli_query($link,"INSERT INTO PCPSPC (idProducto, idComponenteEspecifico, idSubProcesoCaracteristica, valor, indice) VALUES 
                                            ('{$_POST['idProductoCrear']}','{$_POST['selectComponente']}','32','{$_POST['selectProcedimiento']}','{$aux}')");

		$insert = mysqli_query($link,"INSERT INTO PCPSPC (idProducto, idComponenteEspecifico, idSubProcesoCaracteristica, valor, indice) VALUES 
                                            ('{$_POST['idProductoCrear']}','{$_POST['selectComponente']}','33','{$_POST['selectMaquina']}','{$aux}')");

		$insert = mysqli_query($link,"INSERT INTO PCPSPC (idProducto, idComponenteEspecifico, idSubProcesoCaracteristica, valor, indice) VALUES 
                                            ('{$_POST['idProductoCrear']}','{$_POST['selectComponente']}','34','{$_POST['observaciones']}','{$aux}')");

		$insert = mysqli_query($link,"INSERT INTO PCPSPC (idProducto, idComponenteEspecifico, idSubProcesoCaracteristica, valor, indice) VALUES 
                                            ('{$_POST['idProductoCrear']}','{$_POST['selectComponente']}','35','{$_POST['tiempo']}','{$aux}')");
	}

	if(isset($_POST['bajar'])){
		$flag = false;

		$indiceSup = $_POST['indice']+1;

		$query = mysqli_query($link,"SELECT * FROM PCPSPC WHERE idProducto = '{$_POST['idProductoCrear']}' AND indice = '{$_POST['indice']}'");
		while ($row = mysqli_fetch_array($query)){
			switch ($row['idSubProcesoCaracteristica']){
				case (1<=$row['idSubProcesoCaracteristica'] && $row['idSubProcesoCaracteristica']<=7):
					$selectTab = 1;
					break;
				case (8<=$row['idSubProcesoCaracteristica'] && $row['idSubProcesoCaracteristica']<=12):
					$selectTab = 2;
					break;
				case (13<=$row['idSubProcesoCaracteristica'] && $row['idSubProcesoCaracteristica']<=18):
					$selectTab = 3;
					break;
				case (19<=$row['idSubProcesoCaracteristica'] && $row['idSubProcesoCaracteristica']<=24):
					$selectTab = 4;
					break;
				case (25<=$row['idSubProcesoCaracteristica'] && $row['idSubProcesoCaracteristica']<=30):
					$selectTab = 5;
					break;
				case (31<=$row['idSubProcesoCaracteristica'] && $row['idSubProcesoCaracteristica']<=35):
					$selectTab = 6;
					break;
			}
		}

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

		$query = mysqli_query($link,"SELECT * FROM PCPSPC WHERE idProducto = '{$_POST['idProductoCrear']}' AND indice = '{$_POST['indice']}'");
		while ($row = mysqli_fetch_array($query)){
			switch ($row['idSubProcesoCaracteristica']){
				case (1<=$row['idSubProcesoCaracteristica'] && $row['idSubProcesoCaracteristica']<=7):
					$selectTab = 1;
					break;
				case (8<=$row['idSubProcesoCaracteristica'] && $row['idSubProcesoCaracteristica']<=12):
					$selectTab = 2;
					break;
				case (13<=$row['idSubProcesoCaracteristica'] && $row['idSubProcesoCaracteristica']<=18):
					$selectTab = 3;
					break;
				case (19<=$row['idSubProcesoCaracteristica'] && $row['idSubProcesoCaracteristica']<=24):
					$selectTab = 4;
					break;
				case (25<=$row['idSubProcesoCaracteristica'] && $row['idSubProcesoCaracteristica']<=30):
					$selectTab = 5;
					break;
				case (31<=$row['idSubProcesoCaracteristica'] && $row['idSubProcesoCaracteristica']<=35):
					$selectTab = 6;
					break;
			}
		}

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
		$query = mysqli_query($link,"SELECT * FROM PCPSPC WHERE idProducto = '{$_POST['idProductoCrear']}' AND indice = '{$_POST['indice']}'");
		while ($row = mysqli_fetch_array($query)){
			switch ($row['idSubProcesoCaracteristica']){
				case (1<=$row['idSubProcesoCaracteristica'] && $row['idSubProcesoCaracteristica']<=7):
					$selectTab = 1;
					break;
				case (8<=$row['idSubProcesoCaracteristica'] && $row['idSubProcesoCaracteristica']<=12):
					$selectTab = 2;
					break;
				case (13<=$row['idSubProcesoCaracteristica'] && $row['idSubProcesoCaracteristica']<=18):
					$selectTab = 3;
					break;
				case (19<=$row['idSubProcesoCaracteristica'] && $row['idSubProcesoCaracteristica']<=24):
					$selectTab = 4;
					break;
				case (25<=$row['idSubProcesoCaracteristica'] && $row['idSubProcesoCaracteristica']<=30):
					$selectTab = 5;
					break;
				case (31<=$row['idSubProcesoCaracteristica'] && $row['idSubProcesoCaracteristica']<=35):
					$selectTab = 6;
					break;
			}
		}

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

	if(isset($_POST['insumoLavado'])){
	    ?>
        <section class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-inverse card-info">
                            <div class="float-left mt-1">
                                <i class="fa fa-pencil"></i>
                                &nbsp;&nbsp;Agregar Insumos de Lavado
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="col-12">
                                <div class="spacer20"></div>
                                <form method="post" action="#" id="formInsumoLavado">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="text-center">Componente</th>
                                            <th class="text-center">Insumo</th>
                                            <th class="text-center">Cantidad</th>
                                            <th class="text-center">Acción</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <input type="hidden" name="idProductoCrear" value="<?php echo $_POST['idProductoCrear']?>">
                                        <?php
                                        $query = mysqli_query($link,"SELECT * FROM PCPSPC WHERE idComponenteEspecifico = '{$_POST['compEspecifico']}' AND idProducto = '{$_POST['idProductoCrear']}' AND indice = '{$_POST['indice']}' AND idSubProcesoCaracteristica = 12");
                                        while($row = mysqli_fetch_array($query)){
                                            echo "<input type='hidden' name='idPCPSPC' value='{$row['idPCPSPC']}'>";
                                        }
                                        ?>
                                        <tr>
                                            <?php
                                            $query = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idComponenteEspecifico = '{$_POST['compEspecifico']}'");
                                            while($row = mysqli_fetch_array($query)){
                                                $query2 = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE idComponente = '{$row['idComponente']}'");
                                                while($row2 = mysqli_fetch_array($query2)){
                                                    $componente = $row2['descripcion'];
                                                }
                                            }
                                            ?>
                                            <td class="text-center"><input type="text" value="<?php echo $componente;?>" class="form-control" readonly></td>
                                            <td class="text-center"><select class="form-control" name="selectInsumo">
                                                    <option selected disabled>Seleccionar</option>
                                                    <?php
                                                    $query = mysqli_query($link,"SELECT * FROM Insumos");
                                                    while($row = mysqli_fetch_array($query)){
                                                        echo "<option value='{$row['idInsumo']}'>{$row['descripcion']}</option>";
                                                    }
                                                    ?>
                                                </select></td>
                                            <td class="text-center"><input type="number" name="cantidadInsumo" step="0.01" min="0" class="form-control"></td>
                                            <td class="text-center"><input type="submit" name="addInsumoLavado" value="Agregar" class="btn btn-outline-primary" form="formInsumoLavado"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="spacer30"></div>
        <?php
	}

	if(isset($_POST['addInsumoLavado'])){
		$insert = mysqli_query($link,"INSERT INTO PCPSPCInsumos VALUES ('{$_POST['idPCPSPC']}','{$_POST['selectInsumo']}','{$_POST['cantidadInsumo']}')");
		$queryPerformed = "INSERT INTO PCPSPCInsumos VALUES ({$_POST['idPCPSPC']},{$_POST['selectInsumo']},{$_POST['cantidadInsumo']})";
		$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT INSUMO LAVADO','INSERT','{$queryPerformed}')");
	}

    ?>

		<section class="container">
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header card-inverse card-info">
							<div class="float-left mt-1">
								<i class="fa fa-pencil"></i>
								&nbsp;&nbsp;Procesos y Subprocesos
							</div>
							<div class="float-right">
								<div class="dropdown">
                                    <button name="volver" type="submit" class="btn btn-light btn-sm" form="formSiguiente" formaction="nuevaHE2.php">Volver</button>
									<button name="siguiente" type="submit" class="btn btn-light btn-sm" form="formSiguiente">Siguiente</button>
								</div>
							</div>
						</div>
                        <form id="formSiguiente" method="post" action="nuevaHE4.php">
                            <input type="hidden" name="idProductoCrear" value="<?php echo $_POST['idProductoCrear']?>">
                        </form>
						<div class="card-block">
							<div class="col-12">
								<?php
								$activoTejido = '';
								$activoLavado = '';
								$activoSecado = '';
								$activoConfeccion = '';
								$activoAcondicionamiento = '';
								$activoOtros = '';
								if(isset($_POST['siguienteHE2']) || isset($_POST['volverHE4']) || isset($_POST['addTejido']) || $selectTab == 1){
									$activoTejido = 'active';
								}
								if(isset($_POST['addLavado']) || isset($_POST['addInsumoLavado']) || isset($_POST['insumoLavado']) || $selectTab == 2){
									$activoLavado = 'active';
								}
								if(isset($_POST['addSecado']) || $selectTab == 3){
									$activoSecado = 'active';
								}
								if(isset($_POST['addConfeccion']) || $selectTab == 4){
									$activoConfeccion = 'active';
								}
								if(isset($_POST['addAcondicionamiento']) || $selectTab == 5){
									$activoAcondicionamiento = 'active';
								}
								if(isset($_POST['addOtros']) || $selectTab == 6){
									$activoOtros = 'active';
								}
								?>
								<div class="spacer20"></div>
								<ul class="nav nav-tabs" role="tablist">
									<li class="nav-item">
										<a class="nav-link <?php echo $activoTejido;?>" data-toggle="tab" href="#tejido" role="tab">Tejido</a>
									</li>
									<li class="nav-item">
										<a class="nav-link <?php echo $activoLavado;?>" data-toggle="tab" href="#lavado" role="tab">Lavado</a>
									</li>
									<li class="nav-item">
										<a class="nav-link <?php echo $activoSecado;?>" data-toggle="tab" href="#secado" role="tab">Secado</a>
									</li>
									<li class="nav-item">
										<a class="nav-link <?php echo $activoConfeccion;?>" data-toggle="tab" href="#confeccion" role="tab">Confección</a>
									</li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php echo $activoAcondicionamiento;?>" data-toggle="tab" href="#acondicionamiento" role="tab">Acondicionamiento</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php echo $activoOtros;?>" data-toggle="tab" href="#otros" role="tab">Otros</a>
                                    </li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane <?php echo $activoTejido;?>" id="tejido" role="tabpanel">
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
                                                <th class="text-center">Acciones</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <form method="post" action="#" id="formTejido">
                                                <input type="hidden" name="idProductoCrear" value="<?php echo $_POST['idProductoCrear']?>" form="formTejido">
                                                <input type="hidden" name="insertFila" value="<?php if(isset($indiceInsertar)){echo $indiceInsertar;}else{echo 'NA';}?>">
                                            <tr>
                                                <td><select name="selectComponente" class="form-control" onchange="getMaterial(this.value)" form="formTejido">
                                                        <option selected disabled>Seleccionar</option>
                                                        <?php
                                                        $filter = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE tipo = 1");
                                                        while($filterIndex = mysqli_fetch_array($filter)){
	                                                        $query = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idProducto = '{$_POST['idProductoCrear']}' AND idComponente = '{$filterIndex['idComponente']}'");
	                                                        while($row = mysqli_fetch_array($query)){
	                                                            echo "<option value='{$row['idComponenteEspecifico']}'>{$filterIndex['descripcion']}</option>";
	                                                        }
                                                        }
                                                        ?>
                                                    </select></td>
                                                <td id="materialTejido"><input type="text" class="form-control" readonly></td>
                                                <td><select name="selectTipoTejido" class="form-control" form="formTejido">
                                                        <option selected disabled>Seleccionar</option>
                                                        <option value="Industrial">Tejido Industrial</option>
                                                        <option value="Semi-Industrial">Tejido Semi-Industrial</option>
                                                        <option value="Manual">Tejido Manual</option>
                                                    </select></td>
                                                <td style="width: 13%"><select class="js-example-basic-multiple form-control" name="galgas[]" multiple="multiple" form="formTejido">
                                                        <?php
                                                        $query = mysqli_query($link,"SELECT * FROM Galgas");
                                                        while($row = mysqli_fetch_array($query)){
                                                            echo "<option value='{$row['descripcion']}'>{$row['descripcion']}</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                                <td><input type="text" name="comprobacionTejido" class="form-control" form="formTejido"></td>
                                                <td><input type="text" name="observaciones" class="form-control" form="formTejido"></td>
                                                <td><input type="number" min="0" step="0.01" name="tiempo" class="form-control" form="formTejido"></td>
                                                <td class="text-center"><input type="submit" name="addTejido" value="Agregar" class="btn btn-outline-primary" form="formTejido"></td>
                                            </tr>
                                            </form>
                                            <tr>
                                                <td colspan="8"></td>
                                            </tr>
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
                                                                        <input name='insertar' class='dropdown-item' type='submit' formaction='#' value='Insertar' form='formMenu{$row['indice']}'>
                                                                        <input name='eliminar' class='dropdown-item' type='submit' formaction='#' value='Eliminar' form='formMenu{$row['indice']}'>
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
                                    <div class="tab-pane <?php echo $activoLavado;?>" id="lavado" role="tabpanel">
                                        <div class="spacer20"></div>
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">Componente</th>
                                                    <th class="text-center">Tipo de Lavado</th>
                                                    <th class="text-center">Programa</th>
                                                    <th class="text-center">Observaciones</th>
                                                    <th class="text-center">Tiempo</th>
                                                    <th class="text-center">Acciones</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <form method="post" action="#">
                                                    <input type="hidden" name="idProductoCrear" value="<?php echo $_POST['idProductoCrear']?>">
                                                    <input type="hidden" name="insertFila" value="<?php if(isset($indiceInsertar)){echo $indiceInsertar;}else{echo 'NA';}?>">
                                                <tr>
                                                    <td><select name="selectComponente" class="form-control" onchange="getMaterial(this.value)">
                                                            <option selected disabled>Seleccionar</option>
		                                                    <?php
		                                                    $filter = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE tipo = 1");
		                                                    while($filterIndex = mysqli_fetch_array($filter)){
			                                                    $query = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idProducto = '{$_POST['idProductoCrear']}' AND idComponente = '{$filterIndex['idComponente']}'");
			                                                    while($row = mysqli_fetch_array($query)){
				                                                    echo "<option value='{$row['idComponenteEspecifico']}'>{$filterIndex['descripcion']}</option>";
			                                                    }
		                                                    }
		                                                    ?>
                                                        </select></td>
                                                    <td><select name="selectTipoLavado" class="form-control">
                                                            <option selected disabled>Seleccionar</option>
                                                            <option value="Industrial">Lavado Industrial</option>
                                                            <option value="Semi-Industrial">Lavado Semi-Industrial</option>
                                                            <option value="Manual">Lavado Manual</option>
                                                        </select></td>
                                                    <td><input type="text" name="programa" class="form-control"></td>
                                                    <td><input type="text" name="observaciones" class="form-control"></td>
                                                    <td><input type="number" min="0" step="0.01" name="tiempo" class="form-control"></td>
                                                    <td class="text-center"><input type="submit" name="addLavado" value="Agregar" class="btn btn-outline-primary"></td>
                                                </tr>
                                                </form>
                                                <tr>
                                                    <td colspan="6"></td>
                                                </tr>
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
		                                                echo "<td class='text-center'>
                                                                <form method='post' action='#' id='formMenu{$row['indice']}'>
                                                                <div>
                                                                    <input type='hidden' name='idProductoCrear' value='{$_POST['idProductoCrear']}' form='formMenu{$row['indice']}'>
                                                                    <input type='hidden' name='indice' value='{$row['indice']}' form='formMenu{$row['indice']}'>
                                                                    <input type='hidden' name='compEspecifico' value='{$row['idComponenteEspecifico']}' form='formMenu{$row['indice']}'>
                                                                    <button class='btn btn-outline-secondary btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                                    Acciones</button>
                                                                    <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                                                        <input name='insumoLavado' class='dropdown-item' type='submit' formaction='#' value='Agregar Insumo de Lavado' form='formMenu{$row['indice']}'>
                                                                        <input name='subir' class='dropdown-item' type='submit' formaction='#' value='Subir' form='formMenu{$row['indice']}'>
                                                                        <input name='bajar' class='dropdown-item' type='submit' formaction='#' value='Bajar' form='formMenu{$row['indice']}'>
                                                                        <input name='insertar' class='dropdown-item' type='submit' formaction='#' value='Insertar' form='formMenu{$row['indice']}'>
                                                                        <input name='eliminar' class='dropdown-item' type='submit' formaction='#' value='Eliminar' form='formMenu{$row['indice']}'>
                                                                    </div>
                                                                </div>
                                                                </form>
                                                              </td>";
		                                                echo "</tr>";

		                                                /*echo "<tr>
                                                                <th colspan='3' class='text-center'>Insumo</th>
                                                                <th colspan='3' class='text-center'>Cantidad</th>
                                                              </tr>";*/
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
                                    <div class="tab-pane <?php echo $activoSecado;?>" id="secado" role="tabpanel">
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
                                                    <th class="text-center">Acciones</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <form method="post" action="#">
                                                    <input type="hidden" name="idProductoCrear" value="<?php echo $_POST['idProductoCrear']?>">
                                                    <input type="hidden" name="insertFila" value="<?php if(isset($indiceInsertar)){echo $indiceInsertar;}else{echo 'NA';}?>">
                                                <tr>
                                                    <td><select name="selectComponente" class="form-control" onchange="getMaterial(this.value)">
                                                            <option selected disabled>Seleccionar</option>
		                                                    <?php
		                                                    $filter = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE tipo = 1");
		                                                    while($filterIndex = mysqli_fetch_array($filter)){
			                                                    $query = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idProducto = '{$_POST['idProductoCrear']}' AND idComponente = '{$filterIndex['idComponente']}'");
			                                                    while($row = mysqli_fetch_array($query)){
				                                                    echo "<option value='{$row['idComponenteEspecifico']}'>{$filterIndex['descripcion']}</option>";
			                                                    }
		                                                    }
		                                                    ?>
                                                        </select></td>
                                                    <td><select name="selectTipoSecado" class="form-control">
                                                            <option selected disabled>Seleccionar</option>
                                                            <option value="Industrial">Secado Industrial</option>
                                                            <option value="Semi-Industrial">Secado Semi-Industrial</option>
                                                            <option value="Manual">Secado Manual</option>
                                                        </select></td>
                                                    <td><input type="text" name="programa" class="form-control"></td>
                                                    <td><input type="text" name="rotacion" class="form-control"></td>
                                                    <td><input type="text" name="observaciones" class="form-control"></td>
                                                    <td><input type="number" min="0" step="0.01" name="tiempo" class="form-control"></td>
                                                    <td class="text-center"><input type="submit" name="addSecado" value="Agregar" class="btn btn-outline-primary"></td>
                                                </tr>
                                                </form>
                                                <tr>
                                                    <td colspan="6"></td>
                                                </tr>
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
                                                                        <input name='insertar' class='dropdown-item' type='submit' formaction='#' value='Insertar' form='formMenu{$row['indice']}'>
                                                                        <input name='eliminar' class='dropdown-item' type='submit' formaction='#' value='Eliminar' form='formMenu{$row['indice']}'>
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
                                    <div class="tab-pane <?php echo $activoConfeccion;?>" id="confeccion" role="tabpanel">
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
                                                    <th class="text-center">Acciones</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <form method="post" action="#">
                                                    <input type="hidden" name="idProductoCrear" value="<?php echo $_POST['idProductoCrear']?>">
                                                    <input type="hidden" name="insertFila" value="<?php if(isset($indiceInsertar)){echo $indiceInsertar;}else{echo 'NA';}?>">
                                                <tr>
                                                    <td><select name="selectComponente" class="form-control" onchange="getMaterial(this.value)">
                                                            <option selected disabled>Seleccionar</option>
		                                                    <?php
		                                                    $filter = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE tipo = 2");
		                                                    while($filterIndex = mysqli_fetch_array($filter)){
			                                                    $query = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idProducto = '{$_POST['idProductoCrear']}' AND idComponente = '{$filterIndex['idComponente']}'");
			                                                    while($row = mysqli_fetch_array($query)){
				                                                    echo "<option value='{$row['idComponenteEspecifico']}'>{$filterIndex['descripcion']}</option>";
			                                                    }
		                                                    }
		                                                    ?>
                                                        </select></td>
                                                    <td><select name="selectProcedimiento" class="form-control">
                                                            <option selected disabled>Seleccionar</option>
		                                                    <?php
		                                                    $query = mysqli_query($link,"SELECT * FROM SubProceso WHERE tipo = 0 AND idEstado = 1");
		                                                    while($row = mysqli_fetch_array($query)){
			                                                    echo "<option value='{$row['idProcedimiento']}'>{$row['descripcion']}</option>";
		                                                    }
		                                                    ?>
                                                        </select></td>
                                                    <td><input type="text" name="indicaciones" class="form-control"></td>
                                                    <td><select name="selectMaquina" class="form-control">
                                                            <option selected disabled>Seleccionar</option>
		                                                    <?php
		                                                    $query = mysqli_query($link,"SELECT * FROM Maquina WHERE idEstado = 1");
		                                                    while($row = mysqli_fetch_array($query)){
			                                                    echo "<option value='{$row['idMaquina']}'>{$row['descripcion']}</option>";
		                                                    }
		                                                    ?>
                                                        </select></td>
                                                    <td><input type="text" name="observaciones" class="form-control"></td>
                                                    <td><input type="number" min="0" step="0.01" name="tiempo" class="form-control"></td>
                                                    <td class="text-center"><input type="submit" name="addConfeccion" value="Agregar" class="btn btn-outline-primary"></td>
                                                </tr>
                                                </form>
                                                <tr>
                                                    <td colspan="6"></td>
                                                </tr>
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
                                                                        <input name='insertar' class='dropdown-item' type='submit' formaction='#' value='Insertar' form='formMenu{$row['indice']}'>
                                                                        <input name='eliminar' class='dropdown-item' type='submit' formaction='#' value='Eliminar' form='formMenu{$row['indice']}'>
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
                                    <div class="tab-pane <?php echo $activoAcondicionamiento;?>" id="acondicionamiento" role="tabpanel">
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
                                                    <th class="text-center">Acciones</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <form method="post" action="#">
                                                    <input type="hidden" name="idProductoCrear" value="<?php echo $_POST['idProductoCrear']?>">
                                                    <input type="hidden" name="insertFila" value="<?php if(isset($indiceInsertar)){echo $indiceInsertar;}else{echo 'NA';}?>">
                                                <tr>
                                                    <td><select name="selectComponente" class="form-control" onchange="getMaterial(this.value)">
                                                            <option selected disabled>Seleccionar</option>
		                                                    <?php
		                                                    $filter = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE tipo = 1");
		                                                    while($filterIndex = mysqli_fetch_array($filter)){
			                                                    $query = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idProducto = '{$_POST['idProductoCrear']}' AND idComponente = '{$filterIndex['idComponente']}'");
			                                                    while($row = mysqli_fetch_array($query)){
				                                                    echo "<option value='{$row['idComponenteEspecifico']}'>{$filterIndex['descripcion']}</option>";
			                                                    }
		                                                    }
		                                                    ?>
                                                        </select></td>
                                                    <td><select name="selectInsumo" class="form-control">
                                                            <option selected disabled>Seleccionar</option>
		                                                    <?php
		                                                    $query = mysqli_query($link,"SELECT * FROM Insumos WHERE idEstado = 1 AND tipoInsumo = 1");
		                                                    while($row = mysqli_fetch_array($query)){
			                                                    echo "<option value='{$row['idInsumo']}'>{$row['descripcion']}</option>";
		                                                    }
		                                                    ?>
                                                        </select></td>
                                                    <td><input type="text" name="cantidad" class="form-control"></td>
                                                    <td><select name="selectMaquina" class="form-control">
                                                            <option selected disabled>Seleccionar</option>
		                                                    <?php
		                                                    $query = mysqli_query($link,"SELECT * FROM Maquina WHERE idEstado = 1");
		                                                    while($row = mysqli_fetch_array($query)){
			                                                    echo "<option value='{$row['idMaquina']}'>{$row['descripcion']}</option>";
		                                                    }
		                                                    ?>
                                                        </select></td>
                                                    <td><input type="text" name="observaciones" class="form-control"></td>
                                                    <td><input type="number" min="0" step="0.01" name="tiempo" class="form-control"></td>
                                                    <td class="text-center"><input type="submit" name="addAcondicionamiento" value="Agregar" class="btn btn-outline-primary"></td>
                                                </tr>
                                                </form>
                                                <tr>
                                                    <td colspan="6"></td>
                                                </tr>
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
                                                                        <input name='insertar' class='dropdown-item' type='submit' formaction='#' value='Insertar' form='formMenu{$row['indice']}'>
                                                                        <input name='eliminar' class='dropdown-item' type='submit' formaction='#' value='Eliminar' form='formMenu{$row['indice']}'>
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
                                    <div class="tab-pane <?php echo $activoOtros;?>" id="otros" role="tabpanel">
                                        <div class="spacer20"></div>
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">Componente</th>
                                                    <th class="text-center">Procedimiento</th>
                                                    <th class="text-center">Máquina</th>
                                                    <th class="text-center">Observaciones</th>
                                                    <th class="text-center">Tiempo</th>
                                                    <th class="text-center">Acciones</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <form method="post" action="#">
                                                    <input type="hidden" name="idProductoCrear" value="<?php echo $_POST['idProductoCrear']?>">
                                                    <input type="hidden" name="insertFila" value="<?php if(isset($indiceInsertar)){echo $indiceInsertar;}else{echo 'NA';}?>">
                                                <tr>
                                                    <td><select name="selectComponente" class="form-control" onchange="getMaterial(this.value)">
                                                            <option selected disabled>Seleccionar</option>
		                                                    <?php
		                                                    $filter = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE tipo = 1");
		                                                    while($filterIndex = mysqli_fetch_array($filter)){
			                                                    $query = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idProducto = '{$_POST['idProductoCrear']}' AND idComponente = '{$filterIndex['idComponente']}'");
			                                                    while($row = mysqli_fetch_array($query)){
				                                                    echo "<option value='{$row['idComponenteEspecifico']}'>{$filterIndex['descripcion']}</option>";
			                                                    }
		                                                    }
		                                                    ?>
                                                        </select></td>
                                                    <td><select name="selectProcedimiento" class="form-control">
                                                            <option selected disabled>Seleccionar</option>
                                                            <?php
                                                            $query = mysqli_query($link,"SELECT * FROM SubProceso WHERE tipo = 0 AND idEstado = 1");
                                                            while($row = mysqli_fetch_array($query)){
	                                                            echo "<option value='{$row['idProcedimiento']}'>{$row['descripcion']}</option>";
                                                            }
                                                            ?>
                                                        </select></td>
                                                    <td><select name="selectMaquina" class="form-control">
                                                            <option selected disabled>Seleccionar</option>
		                                                    <?php
		                                                    $query = mysqli_query($link,"SELECT * FROM Maquina WHERE idEstado = 1");
		                                                    while($row = mysqli_fetch_array($query)){
			                                                    echo "<option value='{$row['idMaquina']}'>{$row['descripcion']}</option>";
		                                                    }
		                                                    ?>
                                                        </select></td>
                                                    <td><input type="text" name="observaciones" class="form-control"></td>
                                                    <td><input type="number" min="0" step="0.01" name="tiempo" class="form-control"></td>
                                                    <td class="text-center"><input type="submit" name="addOtros" value="Agregar" class="btn btn-outline-primary"></td>
                                                </tr>
                                                </form>
                                                <tr>
                                                    <td colspan="6"></td>
                                                </tr>
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
                                                                        <input name='insertar' class='dropdown-item' type='submit' formaction='#' value='Insertar' form='formMenu{$row['indice']}'>
                                                                        <input name='eliminar' class='dropdown-item' type='submit' formaction='#' value='Eliminar' form='formMenu{$row['indice']}'>
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

	<?php
	include('footer.php');
}
?>