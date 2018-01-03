<?php
include('session.php');
include('declaracionFechas.php');
include('funciones.php');
if(isset($_SESSION['login'])){
	include('header.php');
	include('navbarAdmin.php');

	if(isset($_POST['subir'])){
	    $flag = false;
		$indice = 0;
		$query = mysqli_query($link,"SELECT * FROM Talla WHERE idTalla = '{$_POST['idTalla']}'");
		while($row = mysqli_fetch_array($query)){
			$indice = $row['indice'];
		}
		$indiceSup = $indice - 1;
		$query = mysqli_query($link,"SELECT * FROM Talla WHERE idcodificacionTalla = '{$_POST['idCodificacionTalla']}' AND indice = {$indiceSup}");
		while($row = mysqli_fetch_array($query)){
			$flag = true;
		}
		if($flag){
			$update = mysqli_query($link,"UPDATE Talla SET indice = -1 WHERE indice = {$indice}");
			$queryPerformed = "UPDATE Talla SET indice = -1 WHERE indice = {$indice}";
			$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','SUBIR TALLA','UPDATE','{$queryPerformed}')");

			$update = mysqli_query($link,"UPDATE TALLA SET indice = {$indice} WHERE indice = {$indiceSup}");
			$queryPerformed = "UPDATE TALLA SET indice = {$indice} WHERE indice = {$indiceSup}";
			$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','SUBIR TALLA','UPDATE','{$queryPerformed}')");

			$update = mysqli_query($link,"UPDATE TALLA SET indice = {$indiceSup} WHERE indice = -1");
			$queryPerformed = "UPDATE TALLA SET indice = {$indiceSup} WHERE indice = -1";
			$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','SUBIR TALLA','UPDATE','{$queryPerformed}')");
		}
    }

    if(isset($_POST['bajar'])){
	    $flag = false;
	    $indice = 0;
	    $query = mysqli_query($link,"SELECT * FROM Talla WHERE idTalla = '{$_POST['idTalla']}'");
	    while($row = mysqli_fetch_array($query)){
		    $indice = $row['indice'];
	    }
	    $indiceSup = $indice + 1;
	    $query = mysqli_query($link,"SELECT * FROM Talla WHERE idcodificacionTalla = '{$_POST['idCodificacionTalla']}' AND indice = {$indiceSup}");
	    while($row = mysqli_fetch_array($query)){
		    $flag = true;
	    }
	    if($flag){
		    $update = mysqli_query($link,"UPDATE Talla SET indice = -1 WHERE indice = {$indice}");
		    $queryPerformed = "UPDATE Talla SET indice = -1 WHERE indice = {$indice}";
		    $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','SUBIR TALLA','UPDATE','{$queryPerformed}')");

		    $update = mysqli_query($link,"UPDATE TALLA SET indice = {$indice} WHERE indice = {$indiceSup}");
		    $queryPerformed = "UPDATE TALLA SET indice = {$indice} WHERE indice = {$indiceSup}";
		    $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','SUBIR TALLA','UPDATE','{$queryPerformed}')");

		    $update = mysqli_query($link,"UPDATE TALLA SET indice = {$indiceSup} WHERE indice = -1");
		    $queryPerformed = "UPDATE TALLA SET indice = {$indiceSup} WHERE indice = -1";
		    $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','SUBIR TALLA','UPDATE','{$queryPerformed}')");
	    }
    }
	?>

	<section class="container">
		<div class="card">
			<div class="card-header card-inverse card-info">
				<i class="fa fa-list"></i>
				Listado de Tallas
                <div class="float-right">
                    <form>
                        <input type="submit" name="back" value="Volver" formaction="gestionTallas.php" class="btn btn-sm btn-light">
                    </form>
                </div>
			</div>
			<div class="card-block">
				<div class="spacer10"></div>
				<div class="row">
					<div class="col-12">
						<table class="table table-bordered text-center" id="myTable">
							<thead class="thead-default">
							<tr>
								<th class="text-center">Índice</th>
								<th class="text-center">Talla</th>
								<th class="text-center">Acciones</th>
							</tr>
							</thead>
							<tbody>
							<?php
							$restult = mysqli_query($link, "SELECT * FROM Talla WHERE idcodificacionTalla = '{$_POST['idCodificacionTalla']}' ORDER BY indice ASC");
							while ($fila = mysqli_fetch_array($restult)){
								echo "<tr>";
								echo "<td>{$fila['indice']}</td>";
								echo "<td>{$fila['descripcion']}</td>";
								echo "
                                    <td>
                                        <form method='post'>
                                        	<input type='hidden' name='idCodificacionTalla' value=".$_POST['idCodificacionTalla'].">
                                        	<input type='hidden' name='idTalla' value=".$fila['idTalla'].">
                                        	<input type='submit' name='subir' formaction='editarTalla.php' value='Subir' class='btn btn-sm btn-primary'>
                                        	<input type='submit' name='bajar' formaction='editarTalla.php' value='Bajar' class='btn btn-sm btn-primary'>
                                        </form>
                                    </td>
                                ";
							}
							?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php
	include('footer.php');
}
?>
