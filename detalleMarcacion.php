<?php
include('session.php');
include('declaracionFechas.php');
include('funciones.php');
if(isset($_SESSION['login'])){
	include('header.php');
	include('navbarAdmin.php');
	?>

	<script>
        function myFunction() {
            // Declare variables
            var input, input1, filter, filter1, table, tr, td, td1, i;
            input = document.getElementById("id");
            input1 = document.getElementById("fecha");
            filter = input.value.toUpperCase();
            filter1 = input1.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                td1 = tr[i].getElementsByTagName("td")[1];
                if (td && td1) {
                    if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        if(td1.innerHTML.toUpperCase().indexOf(filter1) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
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
				Hoja de Marcaciones <?php echo $_GET['fecha']?>
				<div class="float-right">
					<div class="dropdown">
						<form method="post">
							<input type="submit" class="btn btn-light btn-sm" formaction="marcaciones.php" value="Volver">
						</form>
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
								<label class="sr-only" for="id">ID</label>
								<input type="text" class="form-control mt-2 mb-2 mr-2" id="id" placeholder="ID Empleado" onkeyup="myFunction()">
								<label class="sr-only" for="fecha">Fecha</label>
								<input type="text" class="form-control mt-2 mb-2 mr-2" id="fecha" placeholder="Fecha" onkeyup="myFunction()">
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
								<th class="text-center">ID</th>
								<th class="text-center">Fecha</th>
								<th class="text-center">Hora Ingreso</th>
								<th class="text-center">Hora Salida</th>
							</tr>
							</thead>
							<tbody>
							<?php
							$query = mysqli_query($link,"SELECT * FROM RegistroIngresoSalida WHERE fecha LIKE '{$_GET['fecha']}%'");
							while($row = mysqli_fetch_array($query)){
								echo "<tr>";
									echo "<td>{$row['idEmpleado']}</td>";
									echo "<td>{$row['fecha']}</td>";
									echo "<td>{$row['horaIngreso']}</td>";
									echo "<td>{$row['horaSalida']}</td>";
								echo "</tr>";
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
