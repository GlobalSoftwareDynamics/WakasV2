<?php
include('session.php');
if(isset($_SESSION['login'])){
	include('header.php');
	include('navbarAdmin.php');
	?>
	<section class="container">
		<table class='table table-hover'>
			<thead>
			<tr>
				<th class="text-center">idProducto</th>
				<th class="text-center">Tipo de Producto</th>
				<th class="text-center">Género</th>
				<th class="text-center">Acciones</th>
			</tr>
			</thead>
			<tbody>
			<?php
			$result = mysqli_query($link,"SELECT * FROM Producto WHERE idEstado = 1");
			while ($fila = mysqli_fetch_array($result)){
				echo "
                                <tr>
                                    <td class='text-center'>".$fila ['idProducto']."</td>";
				$result2 = mysqli_query($link,"SELECT * FROM TipoProducto WHERE idTipoProducto = '{$fila['idTipoProducto']}'");
				while ($fila2 = mysqli_fetch_array($result2)){
					echo "<td class='text-center'>".$fila2 ['descripcion']."</td>";
				}
				echo "<td class='text-center'>".$fila ['idgenero']."</td>";
				echo "<td class='text-center'>
                        <form method='post' action='#'>
                            <div>
                                <button class='btn btn-outline-secondary btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                Acciones</button>
                                <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                    <input name='subir' class='dropdown-item' type='submit' formaction='#' value='Añadir Producto Similar'>
                                    <input name='bajar' class='dropdown-item' type='submit' formaction='#' value='Editar Hoja de Especificaciones'>
                                    <input name='insertar' class='dropdown-item' type='submit' formaction='#' value='Crear Nueva Versión de HE'>
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
	</section>

	<?php
	include('footer.php');
}
?>