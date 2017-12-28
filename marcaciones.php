<?php
include('session.php');
include('declaracionFechas.php');
include('funciones.php');
if(isset($_SESSION['login'])){
	include('header.php');
	include('navbarAdmin.php');

	if(isset($_FILES['documento']['name'])){
		$valid_file = false;
		if($_FILES['documento']['name']) {
			$valid_file = true;
			//if no errors...
			if(!$_FILES['documento']['error'])
			{
				//now is the time to modify the future file name and validate the file
				$new_file_name = 'Marcacion.xls'; //rename file
				if($_FILES['documento']['size'] > (3072000)) //can't be larger than 1 MB
				{
					$valid_file = false;
					$message = 'El archivo seleccionado es demasiado grande!.';
				}

				//if the file has passed the test
				if($valid_file)
				{
					//move it to where we want it to be
					move_uploaded_file($_FILES['documento']['tmp_name'], 'uploads/'.$new_file_name);
					$message = 'Archivo subido correctamente';
				}
			}
			//if there is an error...
			else
			{
				$valid_file = false;
				//set that to be the returned message
				$message = 'La subida del archivo devolvió el siguiente error:  '.$_FILES['documento']['error'];
			}
		}

		if($valid_file){
			require_once 'excel_reader2.php';
			$path = "uploads/Marcacion.xls";
			$data = new Spreadsheet_Excel_Reader($path,false);

			$codigo = '';
			$fechaNueva = '';
			$fecha = '';
			$row = 5;
			$arrayFecha = array();
			$arrayFechaNueva = array();
			$flag = false;

			while($row < 1500){
			    $flag = false;
				$row++;

				$horaIngreso = '';
				$horaSalida = '';

				if($data -> val($row,'A') == ''){
				    if($data -> val($row,'B') == ''){
				        if($data -> val($row,'E') == ''){
				            $codigo = '';
				            $row++;
                        }
                    }else{
				        $fechaNueva = $data -> val($row,'B');
				        if($fechaNueva != '              '){
					        $fecha = substr($data -> val($row,'B'),4,10);
                        }
                    }
				}else{
				    $flag = true;
					$codigo = substr($data -> val($row,'A'),0,6);
				}

				$horaIngreso = substr($data -> val($row,'E'),0,5);
				$horaSalida = substr($data -> val($row,'F'),0,5);

				if(!$flag){
					$query = mysqli_query($link,"SELECT * FROM Empleado WHERE idEmpleado = '{$codigo}'");
					while($fila = mysqli_fetch_array($query)){
					    $fechaInsert = explode('/',$fecha);
					    $fechaIngreso = $fechaInsert[2]."-".$fechaInsert[1]."-".$fechaInsert[0];
						$insert = mysqli_query($link,"INSERT INTO RegistroIngresoSalida (idEmpleado, horaIngreso, horaSalida, fecha, estado) VALUES ('{$codigo}','{$horaIngreso}','{$horaSalida}','{$fechaIngreso}','1')");
						$queryPerformed = "INSERT INTO RegistroIngresoSalida (idEmpleado, horaIngreso, horaSalida, fecha, estado) VALUES ({$codigo},{$horaIngreso},{$horaSalida},{$fecha},1)";
						$databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','RegistroIngresoSalida (EXCEL)','{$queryPerformed}')");
					}
                }
			}
		}else{
			echo $message;
		}
	}

	?>

	<script>
        function myFunction() {
            // Declare variables
            var input, filter, table, tr, td, i;
            input = document.getElementById("mes");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
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
				Listado de Hojas de Marcaciones
				<div class="float-right">
					<div class="dropdown">
						<button type="button" class="btn btn-light btn-sm" data-toggle="modal" data-target="#modalFile">Agregar Hoja de Marcación</button>
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
								<label class="sr-only" for="mes">Mes</label>
								<input type="text" class="form-control mt-2 mb-2 mr-2" id="mes" placeholder="Mes" onkeyup="myFunction()">
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
								<th class="text-center">Mes</th>
								<th class="text-center">Acciones</th>
							</tr>
							</thead>
							<tbody>
                            <?php
                            $fechaComparacion = 0;
                            $empleado = null;
                            $arrayRow = array();
                            $count = 1;
                            $query = mysqli_query($link,"SELECT * FROM RegistroIngresoSalida ORDER BY fecha ASC");
                            while($row = mysqli_fetch_array($query)){
                                $arrayRow = explode("-",$row['fecha']);
                                $rowComparacion = $arrayRow[0]."-".$arrayRow[1];
	                            if($fechaComparacion != $rowComparacion){
		                            echo "<tr>";
		                            switch ($arrayRow[1]){
			                            case '01':
				                            echo "<td>Enero {$arrayRow[0]}</td>";
				                            break;
			                            case '02':
				                            echo "<td>Febrero {$arrayRow[0]}</td>";
				                            break;
			                            case '03':
				                            echo "<td>Marzo {$arrayRow[0]}</td>";
				                            break;
			                            case '04':
				                            echo "<td>Abril {$arrayRow[0]}</td>";
				                            break;
			                            case '05':
				                            echo "<td>Mayo {$arrayRow[0]}</td>";
				                            break;
			                            case '06':
				                            echo "<td>Junio {$arrayRow[0]}</td>";
				                            break;
			                            case '07':
				                            echo "<td>Julio {$arrayRow[0]}</td>";
				                            break;
			                            case '08':
				                            echo "<td>Agosto {$arrayRow[0]}</td>";
				                            break;
			                            case '09':
				                            echo "<td>Setiembre {$arrayRow[0]}</td>";
				                            break;
			                            case '10':
				                            echo "<td>Octubre {$arrayRow[0]}</td>";
				                            break;
			                            case '11':
				                            echo "<td>Noviembre {$arrayRow[0]}</td>";
				                            break;
			                            case '12':
				                            echo "<td>Diciembre {$arrayRow[0]}</td>";
				                            break;
		                            }
		                            $fechaComparacion = $rowComparacion;
		                            echo "<td><a class='btn btn-sm btn-primary' href='detalleMarcacion.php?fecha={$rowComparacion}'>Ver Detalle</a></td>";
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
	</section>

	<div class="modal fade" id="modalFile" tabindex="-1" role="dialog" aria-labelledby="modalFile" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Subir documento Excel</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						<form id="formExcel" method="post" action="#" enctype="multipart/form-data">
							<div class="form-group row">
								<label class="col-form-label" for="documento">Archivo:</label>
								<input type="file" name="documento" id="documento" class="form-control"/>
							</div>
						</form>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" form="formExcel" value="Submit" name="addProductos">Aceptar</button>
				</div>
			</div>
		</div>
	</div>

	<?php
	include('footer.php');
}
?>
