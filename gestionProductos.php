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
			$result = mysqli_query($link,"SELECT * FROM Producto WHERE estado = 1");
			while ($fila = mysqli_fetch_array($result)){
				echo "
                                <tr>
                                    <td class='text-center'>".$fila ['idProducto']."</td>";
				$result2 = mysqli_query($link,"SELECT * FROM TipoProducto WHERE idTipoProducto = '{$fila['idTipoProducto']}'");
				while ($fila2 = mysqli_fetch_array($result2)){
					echo "<td class='text-center'>".$fila2 ['descripcion']."</td>";
				}
				echo "<td class='text-center'>".$fila ['idgenero']."</td>
                                    <td class=\"text-center\">
                                            <form method='post'>
                                                <div class=\"dropdown\">
                                                    <input type='hidden' name='idProducto' value='".$fila['idProducto']."'>
                                                    <button class=\"btn btn-secondary btn-sm dropdown-toggle\" type=\"button\" id=\"dropdownMenuButton\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                                                    Acciones
                                                    </button>
                                                    <div class=\"dropdown-menu\" aria-labelledby=\"dropdownMenuButton\">
                                                        <button name='nuevoProducto' class=\"dropdown-item\" type=\"submit\" formaction=''>Agregar Producto Similar</button>
                                                        <button name='versionProducto' class=\"dropdown-item\" type=\"submit\" formaction=''>Nueva Versión de Producto</button>
                                                        <button name='verProducto' class=\"dropdown-item\" type=\"submit\" formaction=''>Ver</button>
                                                        <button name='editarProducto' class=\"dropdown-item\" type=\"submit\" formaction=''>Editar</button>
                                                        <button name='eliminarProducto' class=\"dropdown-item\" type=\"submit\" formaction='#'>Eliminar</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                </tr>";
			}
			?>
			</tbody>
		</table>
	</section>

	<?php
	include('footer.php');
}
?>