<?php
include('session.php');
if(isset($_SESSION['login'])){
	include('header.php');
	include('navbarAdmin.php');
	?>
    <script>
        function myFunction() {
            // Declare variables
            var input, input2, input3, filter, filter2, filter3, table, tr, td, td2, td3, i;
            input = document.getElementById("idProducto");
            input2 = document.getElementById("tipoProducto");
            input3 = document.getElementById("genero");
            filter = input.value.toUpperCase();
            filter2 = input2.value.toUpperCase();
            filter3 = input3.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                td2 = tr[i].getElementsByTagName("td")[1];
                td3 = tr[i].getElementsByTagName("td")[2];
                if ((td)&&(td2)&&(td3)) {
                    if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        if(td2.innerHTML.toUpperCase().indexOf(filter2) > -1){
                            if(td3.innerHTML.toUpperCase().indexOf(filter3) > -1) {
                                tr[i].style.display = "";
                            }else{
                                tr[i].style.display = "none";
                            }
                        }else{
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
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-inverse card-info">
                        <div class="float-left mt-1">
                            <i class="fa fa-list"></i>
                            &nbsp;&nbsp;Listado de Productos
                        </div>
                        <div class="float-right">
                            <div class="dropdown">
                                <button href="#collapsed" class="btn btn-light btn-sm" data-toggle="collapse">Mostrar Filtros</button>
                                <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Acciones
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <form method="post">
                                        <input class="dropdown-item" type="submit" name="nuevoMaterial" formaction="nuevaHE.php" value="Registrar Nuevo Producto">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-12">
                                <div id="collapsed" class="collapse">
                                    <div class="spacer20"></div>
                                    <form class="form-inline justify-content-center" method="post" action="#">
                                        <label class="sr-only" for="material">idProducto</label>
                                        <input type="text" class="form-control mt-2 mb-2 mr-2" id="idProducto" placeholder="ID Producto" onkeyup="myFunction()">
                                        <label class="sr-only" for="tipoProducto">Tipo de Producto</label>
                                        <input type="text" class="form-control mt-2 mb-2 mr-2" id="tipoProducto" placeholder="Tipo de Producto" onkeyup="myFunction()">
                                        <label class="sr-only" for="genero">Género</label>
                                        <input type="text" class="form-control mt-2 mb-2 mr-2" id="genero" placeholder="Género" onkeyup="myFunction()">
                                        <input type="submit" class="btn btn-primary" value="Limpiar" style="padding-left:28px; padding-right: 28px;">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="spacer20"></div>
                            <table class='table table-hover' id="myTable">
                                <thead>
                                <tr>
                                    <th class="text-center">ID Producto</th>
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
                            <input type='hidden' name='idProductoCrear' value='{$fila['idProducto']}'>
                            <div>
                                <button class='btn btn-outline-secondary btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                Acciones</button>
                                <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                    <input name='addProductoSimilar' class='dropdown-item' type='submit' formaction='nuevaHE.php' value='Añadir Producto Similar'>
                                    <input name='editarProducto' class='dropdown-item' type='submit' formaction='nuevaHE2.php' value='Editar Hoja de Especificaciones'>
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