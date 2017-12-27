<?php
include('session.php');
if (!empty($_POST['nombreCliente'])) {
    $query = mysqli_query($link, "SELECT * FROM Cliente WHERE nombre LIKE '%{$_POST['nombreCliente']}%'");
    while ($row = mysqli_fetch_array($query)) {
        $query1 = mysqli_query($link,"SELECT * FROM Contacto WHERE idCliente = '{$row['idCliente']}'");
        $numrows = mysqli_num_rows($query1);
        if ($numrows>0){
            echo "
                <div class='form-group row'>
                    <label for='contactoCliente' class='col-2 col-form-label'>Nombre de Contacto:</label>
                    <div class='col-10'>
                        <select class='form-control' id='nombreContacto' name='nombreContacto' >
                            <option disabled selected>Seleccionar</option>";
            while ($fila1=mysqli_fetch_array($query1)){
                echo "
                                    <option value='{$fila1['idContacto']}'>{$fila1['nombreCompleto']}</option>
                                ";
            }
            echo "
                        </select>
                    </div>
                </div>
            ";
        }else{
            echo "
                <div class='form-group row'>
                    <label class='col-2 col-form-label'>Datos:</label>
                    <div class='col-10'>
                        <label for='dni' class='sr-only'>Documento de Identidad</label>
                        <input type='text' id='dni' name='dni' class='form-control col-4 mb-2 mr-2' placeholder='Documento de Identidad' required>
                        <label for='nombres' class='sr-only'>Nombre Completo</label>
                        <input type='text' id='nombres' name='nombres' class='form-control col-7 mb-2' placeholder='Nombre Completo' required>
                        <label for='mail' class='sr-only'>Email</label>
                        <input type='email' id='mail' name='email' class='form-control col-5 mb-2 mt-2' placeholder='Email'>
                        <label for='telf' class='sr-only'>Teléfono</label>
                        <input type='text' id='telf' name='telefono' class='form-control col-5 mb-2 mt-2' placeholder='Teléfono' required> 
                        <label for='direccion' class='sr-only'>Direccion</label>
                        <input type='text' id='direccion' name='direccion' class='form-control col-8 mt-2' placeholder='Dirección' required>
                        <label for='ciudad' class='sr-only'>Ciudad</label>
                        <select class='form-control col-5 mt-2' id='ciudad' name='ciudad' required>
                            <option>Ciudad</option>";
            $ciudad=mysqli_query($link,"SELECT * FROM Ciudad ORDER BY nombre ASC");
            while ($fila=mysqli_fetch_array($ciudad)){
                echo "
                                    <option value='{$fila['idCiudad']}'>{$fila['nombre']}</option>
                                ";
            }
            echo "
                        </select>
                    </div>
                </div>
            ";
        }
    }
}

if(!empty($_POST["productoCV"])) {

    $result = mysqli_query($link,"SELECT * FROM Producto WHERE idProducto = '{$_POST["productoCV"]}'");
    while ($fila = mysqli_fetch_array($result)){
        $material = $fila['codificacionMaterial'];
    }

    echo "
    <td>
        <label for='code' class='sr-only'>Código del Cliente</label>
        <input id='code' type='text' name='yourcode' class='form-control'>
    </td>
    <td>{$material}</td>
    <td>
        <label for='precio' class='sr-only'>Precio</label>
        <input id='precio' type='text' name='precio' class='form-control'>
    </td>
    ";
    $tallas1=array();
    $tallas2=array();
    $indice1=0;
    $indice2=0;
    $result = mysqli_query($link,"SELECT * FROM Talla WHERE idcodificacionTalla = '{$_POST['idcodificacionTallaCV']}' ORDER BY indice ASC");
    while ($fila = mysqli_fetch_array($result)) {
        $tallas1[$indice1] = $fila['idTalla'];
        $indice1++;
    }
    $talla = mysqli_query($link,"SELECT DISTINCT idTalla FROM TallaMedida WHERE idProducto = '{$_POST["productoCV"]}' AND valor>0");
    while ($fila1 = mysqli_fetch_array($talla)){
        $tallas2[$indice2]=$fila1['idTalla'];
        $indice2++;
    }
    foreach ($tallas1 as $value1) {
        $encontrado=false;
        foreach ($tallas2 as $value2) {
            if ($value1 == $value2){
                $encontrado=true;
                echo "<td><input type='number' class='form-control' name='{$value2}' min='0'></td>";
            }
        }
        if ($encontrado == false){
            echo "<td><input type='number' class='form-control' min='0' readonly></td>";
        }
    }
    echo "
        <td><input type='submit' value='Agregar' name='addProductoCV' class='btn btn-primary'></td>
    ";
}

if(!empty($_POST['productoCVColores'])){
    echo "
            <label for='idCombinacionColores' class='col-2 col-form-label'>Combinación de Colores:</label>
            <div class='col-7'>
                 <select class='form-control' id='idCombinacionColores' name='idCombinacionColores'>
                     <option disabled selected>Seleccionar</option>";
    $result = mysqli_query($link,"SELECT * FROM CombinacionesColorProducto WHERE idProducto = '{$_POST['productoCVColores']}'");
    while ($fila = mysqli_fetch_array($result)){
        $result1 = mysqli_query($link,"SELECT * FROM CombinacionesColor WHERE idCombinacionesColor = '{$fila['idCombinacionesColor']}'");
        while ($fila1 = mysqli_fetch_array($result1)){
            echo "<option value='{$fila['idCombinacionesColor']}'>{$fila1['descripcion']}</option>";
        }
    }
    echo "
                 </select>
            </div>
            <div class='col-2'>
                 <button type='button' class='btn btn-outline-primary' data-toggle='modal' data-target='#modalNuevaCombinacion'>Agregar Combinación</button>
            </div>
    ";
}

if(!empty($_POST['productoCVModalColores'])){
    ?>
    <div class="modal fade" id="modalNuevaCombinacion" tabindex="-1" role="dialog" aria-labelledby="modalNuevaCombinacion" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Combinación de Colores</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form id="formCombinacion" method="post" action="#">
                            <input type="hidden" name="idConfirmacionVenta" value="<?php echo $_POST['idConfirmacionVenta']?>">
                            <input type="hidden" name="idProducto" value="<?php echo $_POST['productoCVModalColores']?>">
                            <input type="hidden" name="codifTalla" value="<?php echo $_POST['codificacionTalla']?>">
                            <div class="form-group row">
                                <table class="table text-center">
                                    <thead>
                                        <tr>
                                            <th>Nro. Color</th>
                                            <th>Color</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $result = mysqli_query($link,"SELECT DISTINCT codigoColor FROM ProductoComponentesPrenda WHERE idProducto = '{$_POST['productoCVModalColores']}' AND codigoColor IS NOT NULL ORDER BY codigoColor ASC");
                                    while ($fila = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>{$fila['codigoColor']}</td>";
                                        echo "
                                        <td>
                                            <label for='colorCombinacion{$fila['codigoColor']}' class='sr-only'>Color</label>
                                            <select id='colorCombinacion{$fila['codigoColor']}' name='colorCombinacion{$fila['codigoColor']}' class='form-control'>
                                                <option selected disabled>Seleccionar</option>";
                                                $result1 = mysqli_query($link,"SELECT * FROM Color");
                                                while ($fila1 = mysqli_fetch_array($result1)){
                                                echo "<option value='{$fila1['idColor']}'>{$fila1['idColor']}-{$fila1['descripcion']}</option>";
                                                }
                                                echo "
                                            </select>
                                        </td>
                                        ";
                                        echo "</tr>";
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" form="formCombinacion" value="Submit" name="addCombinacion">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <?php
}

if(!empty($_POST['idCodificacionTalla'])){
    echo "
							<table class='table'>
                                <thead>
                                <tr>
                                    <th class='text-center' style='width: 50%'>Codificación</th>
                                    <th class='text-center' style='width: 50%'>Talla</th>
                                </tr>
                                </thead>
                                <tbody>";
    $search = mysqli_query($link,"SELECT * FROM Talla WHERE idcodificacionTalla = '{$_POST['idCodificacionTalla']}'");
    while($index = mysqli_fetch_array($search)){
        $search2 = mysqli_query($link, "SELECT * FROM codificacionTalla WHERE idcodificacionTalla = '{$_POST['idCodificacionTalla']}'");
        while($index2 = mysqli_fetch_array($search2)){
            echo "<tr>
												<td class='text-center'>{$index2['descripcion']}</td>
												<td class='text-center'>{$index['descripcion']}</td>
											  </tr>";
        }
    }
    echo "
                                </tbody>
                            </table>";
}

if(!empty($_POST['idMaterialUM'])){
	$query = mysqli_query($link,"SELECT * FROM Material WHERE idMaterial = '{$_POST['idMaterialUM']}'");
	while($row = mysqli_fetch_array($query)){
		echo "<input type='text' class='form-control' name='idUnidadMedida' value='{$row['idUnidadMedida']}' readonly>";
	}
}

if(!empty($_POST['idComponenteEspecifico'])){
	$flag = true;
	$query = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idComponenteEspecifico = '{$_POST['idComponenteEspecifico']}'");
	while($row = mysqli_fetch_array($query)){
		$query2 = mysqli_query($link,"SELECT * FROM Material WHERE idMaterial = '{$row['idMaterial']}'");
		while($row2 = mysqli_fetch_array($query2)){
			echo "<input type='text' class='form-control' name='material' value='{$row2['material']}' readonly>";
			$flag = false;
		}
	}
	if($flag){
		echo "<input type='text' class='form-control' readonly>";
	}

}

if(!empty($_POST['fechaContrato'])){

    echo "<option disabled selected>Seleccionar</option>";
    $result = mysqli_query($link,"SELECT * FROM ConfirmacionVenta WHERE fecha = '{$_POST['fechaContrato']}'");
    while ($fila = mysqli_fetch_array($result)){
        echo "<option value='{$fila['idContrato']}'>{$fila['idContrato']}</option>";
    }

}

if(!empty($_POST['fechaContratoReporte'])){

    echo "<option disabled selected>Confirmación de Venta</option>";
    $result = mysqli_query($link,"SELECT * FROM ConfirmacionVenta WHERE fecha = '{$_POST['fechaContratoReporte']}'");
    while ($fila = mysqli_fetch_array($result)){
        echo "<option value='{$fila['idContrato']}'>{$fila['idContrato']} - {$fila['fecha']}</option>";
    }

}

if(!empty($_POST['idConfirmacionVentaReporte'])){

    echo "<option disabled selected>Orden de Producción</option>";
    $result = mysqli_query($link,"SELECT * FROM OrdenProduccion WHERE idContrato = '{$_POST['idConfirmacionVentaReporte']}'");
    while ($fila = mysqli_fetch_array($result)){
        echo "<option value='{$fila['idOrdenProduccion']}'>{$fila['idOrdenProduccion']} - {$fila['fechaCreacion']}</option>";
    }

}

if(!empty($_POST['idLoteReporte'])){
    echo "<select name='idLote' id='idLote' class='form-control mt-2 mb-2 mr-2'>";
    echo "<option disabled selected>Lote</option>";
    $result = mysqli_query($link,"SELECT * FROM Lote WHERE idOrdenProduccion = '{$_POST['idLoteReporte']}'");
    while ($fila = mysqli_fetch_array($result)){
        echo "<option value='{$fila['idLote']}'>{$fila['idLote']}</option>";
    }
    echo "</select>";

}

if(!empty($_POST['idConfirmacionVenta'])){

    $result = mysqli_query($link,"SELECT * FROM ConfirmacionVentaProducto WHERE idContrato = '{$_POST['idConfirmacionVenta']}' AND cantidad <> cantidadop ORDER BY idTalla ASC");
    while ($fila = mysqli_fetch_array($result)){
        $result1 = mysqli_query($link,"SELECT * FROM Talla WHERE idTalla = '{$fila['idTalla']}'");
        while ($fila1 = mysqli_fetch_array($result1)){
            $talla = $fila1['descripcion'];
        }
        $result1 = mysqli_query($link,"SELECT * FROM CombinacionesColor WHERE idCombinacionesColor = '{$fila['idCombinacionesColor']}'");
        while ($fila1 = mysqli_fetch_array($result1)){
            $combinacion = $fila1['descripcion'];
        }
        $cantidadRestante = $fila['cantidad'] - $fila['cantidadop'];
        echo "<tr>";
        echo "<input type='hidden' name='{$fila['idConfirmacionVentaProducto']}' value='{$fila['idConfirmacionVentaProducto']}'>";
        echo "<td>{$fila['idProducto']}</td>";
        echo "<td>{$talla}</td>";
        echo "<td>{$combinacion}</td>";
        echo "<td>{$fila['cantidad']}</td>";
        echo "<td><input type='number' value='{$cantidadRestante}' min='0' max='{$cantidadRestante}' name='cantidad{$fila['idConfirmacionVentaProducto']}' class='form-control'></td>";
        echo "<td><input type='checkbox' class='form-check-input' name='marcacion{$fila['idConfirmacionVentaProducto']}'>Marcar</td>";
        echo "</tr>";
    }

}

if(!empty($_POST['idLoteA'])){

    $result = mysqli_query($link,"SELECT * FROM Lote WHERE idLote = '{$_POST['idLoteA']}'");
    while ($fila = mysqli_fetch_array($result)){
        $result1 = mysqli_query($link,"SELECT * FROM ConfirmacionVentaProducto WHERE idConfirmacionVentaProducto = '{$fila['idConfirmacionVentaProducto']}'");
        while ($fila1 = mysqli_fetch_array($result1)){
            echo "<input type='text' name='idProducto' value='{$fila1['idProducto']}' class='form-control'>";
        }
    }
}

if(!empty($_POST['idLoteB'])){

    echo "<option>Seleccionar</option>";
    $result = mysqli_query($link,"SELECT * FROM Lote WHERE idLote = '{$_POST['idLoteB']}'");
    while ($fila = mysqli_fetch_array($result)){
        $result1 = mysqli_query($link,"SELECT * FROM ConfirmacionVentaProducto WHERE idConfirmacionVentaProducto = '{$fila['idConfirmacionVentaProducto']}'");
        while ($fila1 = mysqli_fetch_array($result1)){
            $result2 = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idProducto = '{$fila1['idProducto']}'");
            while ($fila2 = mysqli_fetch_array($result2)){
                $result3 = mysqli_query($link,"SELECT idProducto, idComponenteEspecifico, COUNT(*) AS cantidadProcesos FROM PCPSPC WHERE idProducto = '{$fila1['idProducto']}' AND idComponenteEspecifico = '{$fila2['idComponenteEspecifico']}' AND idSubProcesoCaracteristica IN (SELECT idSubProcesoCaracteristica FROM SubProcesoCaracteristica WHERE idCaracteristica = 7)");
                while ($fila3 = mysqli_fetch_array($result3)){
                    $cantidadTotal = $fila3['cantidadProcesos']*$fila['cantidad'];
                }
                $result4 = mysqli_query($link,"SELECT idComponenteEspecifico, SUM(cantidad) AS cantidadRealizada FROM EmpleadoLote WHERE idLote = '{$_POST['idLoteB']}' AND idComponenteEspecifico = '{$fila2['idComponenteEspecifico']}'");
                $filasArray = mysqli_num_rows($result4);
                while ($fila4 = mysqli_fetch_array($result4)){
                    if($fila4['idComponenteEspecifico']==null){
                        $cantidadRealizada = 0;
                    }else{
                        $cantidadRealizada = $fila4['cantidadRealizada'];
                    }
                }
                if($cantidadTotal == $cantidadRealizada){
                }else{
                    $result5 = mysqli_query($link,"SELECT * FROM ComponentesPrenda WHERE idComponente IN (SELECT idComponente FROM ProductoComponentesPrenda WHERE idComponenteEspecifico = '{$fila2['idComponenteEspecifico']}')");
                    while ($fila5 = mysqli_fetch_array($result5)){
                        echo "<option value='{$fila2['idComponente']}'>{$fila5['descripcion']}</option>";
                    }
                }
            }
        }
    }
}

if(!empty($_POST['idComponenteEspecificoC'])){

    echo "<option>Seleccionar</option>";
    $result = mysqli_query($link,"SELECT * FROM Lote WHERE idLote = '{$_POST['idLoteC']}'");
    while ($fila = mysqli_fetch_array($result)){
        $result1 = mysqli_query($link,"SELECT * FROM ConfirmacionVentaProducto WHERE idConfirmacionVentaProducto = '{$fila['idConfirmacionVentaProducto']}'");
        while ($fila1 = mysqli_fetch_array($result1)){
            $result2 = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idProducto = '{$fila1['idProducto']}' AND idComponente = '{$_POST['idComponenteEspecificoC']}'");
            while ($fila2 = mysqli_fetch_array($result2)){
                $result3 = mysqli_query($link,"SELECT * FROM PCPSPC WHERE idProducto = '{$fila1['idProducto']}' AND idComponenteEspecifico = '{$fila2['idComponenteEspecifico']}' AND idSubProcesoCaracteristica IN (SELECT idSubProcesoCaracteristica FROM SubProcesoCaracteristica WHERE idCaracteristica = 7 AND idProcedimiento <> 4 AND idProcedimiento <> 6)");
                while ($fila3 = mysqli_fetch_array($result3)){
                    $result4 = mysqli_query($link,"SELECT idComponenteEspecifico, SUM(cantidad) AS cantidadRealizada FROM EmpleadoLote WHERE idLote = '{$_POST['idLoteC']}' AND idComponenteEspecifico = '{$fila2['idComponenteEspecifico']}' AND idProcedimiento IN (SELECT idProcedimiento FROM SubProcesoCaracteristica WHERE idSubProcesoCaracteristica = '{$fila3['idSubProcesoCaracteristica']}')");
                    $filasArray = mysqli_num_rows($result4);
                    while ($fila4 = mysqli_fetch_array($result4)){
                        if($fila4['idComponenteEspecifico']==null){
                            $cantidadRealizada = 0;
                        }else{
                            $cantidadRealizada = $fila4['cantidadRealizada'];
                        }
                    }
                    if($fila['cantidad'] === $cantidadRealizada){
                    }else{
                        $result5 = mysqli_query($link,"SELECT * FROM SubProceso WHERE idProcedimiento IN (SELECT idProcedimiento FROM SubProcesoCaracteristica WHERE idSubProcesoCaracteristica = '{$fila3['idSubProcesoCaracteristica']}')");
                        while ($fila5 = mysqli_fetch_array($result5)){
                            echo "<option value='{$fila5['idProcedimiento']}'>{$fila5['descripcion']}</option>";
                        }
                    }
                }
                $result3 = mysqli_query($link,"SELECT * FROM PCPSPC WHERE idProducto = '{$fila1['idProducto']}' AND idComponenteEspecifico = '{$fila2['idComponenteEspecifico']}' AND idSubProcesoCaracteristica IN (SELECT idSubProcesoCaracteristica FROM SubProcesoCaracteristica WHERE idCaracteristica = 11)");
                while ($fila3 = mysqli_fetch_array($result3)){
                    $result4 = mysqli_query($link,"SELECT idComponenteEspecifico, SUM(cantidad) AS cantidadRealizada FROM EmpleadoLote WHERE idLote = '{$_POST['idLoteC']}' AND idComponenteEspecifico = '{$fila2['idComponenteEspecifico']}' AND idProcedimiento = '{$fila3['valor']}'");
                    $filasArray = mysqli_num_rows($result4);
                    while ($fila4 = mysqli_fetch_array($result4)){
                        if($fila4['idComponenteEspecifico']==null){
                            $cantidadRealizada = 0;
                        }else{
                            $cantidadRealizada = $fila4['cantidadRealizada'];
                        }
                    }
                    if($fila['cantidad'] === $cantidadRealizada){
                    }else{
                        $result5 = mysqli_query($link,"SELECT * FROM SubProceso WHERE idProcedimiento = '{$fila3['valor']}'");
                        while ($fila5 = mysqli_fetch_array($result5)){
                            echo "<option value='{$fila5['idProcedimiento']}'>{$fila5['descripcion']}</option>";
                        }
                    }
                }
            }
        }
    }
}

if(!empty($_POST['idMaquinaProcedimiento'])){

    echo "<option>Seleccionar</option>";
    $result = mysqli_query($link,"SELECT * FROM Maquina WHERE idMaquina IN (SELECT idMaquina FROM MaquinaSubproceso WHERE idProcedimiento = '{$_POST['idMaquinaProcedimiento']}')");
    while ($fila = mysqli_fetch_array($result)){
        echo "<option value='{$fila['idMaquina']}'>{$fila['descripcion']}</option>";
    }
}

if(!empty($_POST['idProcedimientoSeleccionado'])){

    $result = mysqli_query($link,"SELECT * FROM Lote WHERE idLote = '{$_POST['idLoteD']}'");
    while ($fila = mysqli_fetch_array($result)){
        $cantidadLote = $fila['cantidad'];
        $result1 = mysqli_query($link,"SELECT * FROM ConfirmacionVentaProducto WHERE idConfirmacionVentaProducto = '{$fila['idConfirmacionVentaProducto']}'");
        while ($fila1 = mysqli_fetch_array($result1)){
            $producto = $fila1['idProducto'];
        }
    }

    $result = mysqli_query($link,"SELECT * FROM ProductoComponentesPrenda WHERE idProducto = '{$producto}' AND idComponente = '{$_POST['idComponenteSeleccionado']}'");
    while ($fila = mysqli_fetch_array($result)){
        $idComponenteEspecifico = $fila['idComponenteEspecifico'];
    }

    $result4 = mysqli_query($link,"SELECT idComponenteEspecifico, idProcedimiento, SUM(cantidad) AS cantidadRealizada FROM EmpleadoLote WHERE idLote = '{$_POST['idLoteD']}' AND idComponenteEspecifico = '{$idComponenteEspecifico}' AND idProcedimiento = '{$_POST['idProcedimientoSeleccionado']}'");
    $filasArray = mysqli_num_rows($result4);
    while ($fila4 = mysqli_fetch_array($result4)){
        if($fila4['idComponenteEspecifico']==null){
            $cantidadRealizada = 0;
        }else{
            $cantidadRealizada = $fila4['cantidadRealizada'];
        }
    }

    $cantidadSinFabricar = $cantidadLote - $cantidadRealizada;

    echo "<input type='number' name='cantidad' id='cantidad' value='{$cantidadSinFabricar}' max='{$cantidadSinFabricar}' min='0' class='form-control'>";

}

if(!empty($_POST['getNombreEmpleado'])){

    $result = mysqli_query($link,"SELECT * FROM Empleado WHERE idEmpleado = '{$_POST['getNombreEmpleado']}'");
    while ($fila = mysqli_fetch_array($result)){
        $nombreCompleto = $fila['nombres']."_".$fila['apellidos'];
    }
    echo $nombreCompleto;
}

if(!empty($_POST['getDniEmpleado'])){

    $nombreApellidos = explode("_",$_POST['getDniEmpleado']);
    $result = mysqli_query($link,"SELECT * FROM Empleado WHERE nombres = '{$nombreApellidos[0]}' AND apellidos = '{$nombreApellidos[1]}'");
    $numrows = mysqli_num_rows($result);
    if($numrows == 0){
        echo "<input type='number' class='form-control mt-2 mb-2 mr-2' id='idEmpleado' name='idEmpleado' placeholder='DNI' onchange='getNombreEmpleado(this.value)'>";
    }else{
        if ($numrows>1){
            echo "
                <select name='idEmpleado' id='idEmpleado' class='form-control mt-2 mb-2 mr-2'>
                    <option selected disabled>Seleccionar</option>";
                    while ($fila = mysqli_fetch_array($result)){
                        echo "<option value='{$fila['idEmpleado']}'>{$fila['idEmpleado']}</option>";
                    }
            echo "
                </select>
                ";
        }else{
            while ($fila = mysqli_fetch_array($result)){
                echo "<input type='number' class='form-control mt-2 mb-2 mr-2' id='idEmpleado' name='idEmpleado' value='{$fila['idEmpleado']}'>";
            }
        }
    }
}