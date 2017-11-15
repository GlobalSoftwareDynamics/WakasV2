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
            $ciudad=mysqli_query($link,"SELECT * FROM Ciudad");
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
    echo $_POST["productoCV"];
    echo $_POST["idcodificacionTallaCV"];
    echo "
    <tr>
    <td>
        <label for='code' class='sr-only'>Código del Cliente</label>
        <input id='code' type='text' name='yourcode' class='form-control'>
    </td>
    <td>
       
    </td>
    <td>
        
    </td>
    ";
    $tallas1=array();
    $tallas2=array();
    $indice1=0;
    $indice2=0;
    $result = mysqli_query($link,"SELECT * FROM Talla WHERE idcodificacionTalla = '{$_POST['idcodificacionTallaCV']}'");
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
                echo "<td><input type='text' class='form-control' name='{$value2}'></td>";
            }
        }
        if ($encontrado == false){
            echo "<td><input type='text' class='form-control' readonly></td>";
        }
    }
    echo "
    </tr>
    ";
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