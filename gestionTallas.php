<?php
include('session.php');
include('declaracionFechas.php');
include('funciones.php');
if(isset($_SESSION['login'])){
	include('header.php');
	include('navbarAdmin.php');

	if(isset($_POST['addCodificacion'])){
		$insert = mysqli_query($link, "INSERT INTO codificacionTalla(descripcion) VALUES ('{$_POST['codificacion']}')");

		$queryPerformed = "INSERT INTO codificacionTalla(descripcion) VALUES ({$_POST['codificacion']})";

		$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT CODIF. TALLA','INSERT','{$queryPerformed}')");
	}

	if(isset($_POST['addTalla'])){
		$contador = 1;
		$query = mysqli_query($link,"SELECT * FROM Talla WHERE idcodificacionTalla = '{$_POST['codificacionTallaSelect']}'");
		while($row = mysqli_fetch_array($query)){
			$contador++;
		}

		$insert = mysqli_query($link, "INSERT INTO Talla(descripcion,idcodificacionTalla,indice) VALUES ('{$_POST['talla']}','{$_POST['codificacionTallaSelect']}','{$contador}')");

		$queryPerformed = "INSERT INTO Talla(descripcion,idcodificacionTalla) VALUES ({$_POST['talla']},{$_POST['codificacionTallaSelect']},{$contador})";

		$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT TALLA','INSERT','{$queryPerformed}')");
	}

	?>

	<script>
        function myFunction() {
            // Declare variables
            var input, input2, input3, filter, filter2, filter3, table, tr, td, td2, td3, i;
            input = document.getElementById("material");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if ((td)) {
                    if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
	                    tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
	</script>

	<section class="container">
		<div class="card">
			<div class="card-header card-inverse card-info">
				<i class="fa fa-list"></i>
				Listado de Codificación de Tallas
				<div class="float-right">
					<div class="dropdown">
						<button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Acciones
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <button type="button" class="dropdown-item" data-toggle="modal" data-target="#modalCodificacion">Agregar Codificación</button>
                            <button type="button" class="dropdown-item" data-toggle="modal" data-target="#modalTalla">Agregar Talla</button>
						</div>
					</div>
				</div>
				<span class="float-right">&nbsp;&nbsp;&nbsp;&nbsp;</span>
				<span class="float-right">
                    <button href="#collapsed" class="btn btn-light btn-sm" data-toggle="collapse">Mostrar Filtros</button>
                </span>
			</div>
			<div class="card-block">
				<div class="row">
					<div class="col-12">
						<div id="collapsed" class="collapse">
							<form class="form-inline justify-content-center" method="post" action="#">
								<label class="sr-only" for="codificacion">Codificación de Talla</label>
								<input type="text" class="form-control mt-2 mb-2 mr-2" id="material" placeholder="Codificación de Talla" onkeyup="myFunction()">
								<input type="submit" class="btn btn-primary" value="Limpiar" style="padding-left:28px; padding-right: 28px;">
							</form>
						</div>
					</div>
				</div>
				<div class="spacer10"></div>
				<div class="row">
					<div class="col-12">
						<table class="table table-bordered text-center" id="myTable">
							<thead class="thead-default">
							<tr>
								<th class="text-center">Codificación de Talla</th>
								<th class="text-center">Acciones</th>
							</tr>
							</thead>
							<tbody>
							<?php
							$restult = mysqli_query($link, "SELECT * FROM CodificacionTalla ORDER BY descripcion ASC");
							while ($fila = mysqli_fetch_array($restult)){
								echo "<tr>";
								echo "<td>{$fila['descripcion']}</td>";
								echo "
                                    <td>
                                        <form method='post'>
                                        	<input type='hidden' name='idCodificacionTalla' value=".$fila['idcodificacionTalla'].">
                                        	<input type='submit' formaction='editarTalla.php' value='Ver detalle' class='btn btn-sm btn-primary'>
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

    <form method="post" action="#" id="formCodificacion">
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
                    <button type="submit" class="btn btn-primary" form="formCodificacion" value="Submit" name="addCodificacion">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>
    </form>

    <form method="post" id="formTalla">
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" form="formTalla" value="Submit" name="addTalla">Guardar Cambios</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

	<?php
	include('footer.php');
}
?>
