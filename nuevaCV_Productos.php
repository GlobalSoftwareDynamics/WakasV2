<?php
include('session.php');
include('declaracionFechas.php');
include ('funciones.php');
if(isset($_SESSION['login'])){

    $flag = true;

    if(isset($_POST['addCV'])){

        /*Verificacion de idContrato*/
        $search = mysqli_query($link,"SELECT * FROM ConfirmacionVenta WHERE idContrato = '{$_POST['idConfirmacionVenta']}'");
        while($index = mysqli_fetch_array($search)){
            $flag = false;
        }

        if ($flag) {
            /*Creacion de Nuevo Contacto*/
            if (isset($_POST['nombreContacto'])) {
                $contacto = $_POST['nombreContacto'];
            } elseif (isset($_POST['dni'])) {
                $contacto = $_POST['dni'];

                $cliente = mysqli_query($link, "SELECT * FROM Cliente WHERE nombre LIKE '%{$_POST['cliente']}%'");
                while ($fila = mysqli_fetch_array($cliente)) {
                    $idCliente = $fila['idCliente'];
                }
                /*Creacion de Direccion*/
                $query = mysqli_query($link, "INSERT INTO Direccion(idCiudad, direccion) VALUES ('{$_POST['ciudad']}','{$_POST['direccion']}')");

                $queryPerformed = "INSERT INTO Direccion(idCiudad, direccion) VALUES ({$_POST['ciudad']},{$_POST['direccion']})";

                $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','Direccion','{$queryPerformed}')");

                $direccion = mysqli_query($link, "SELECT * FROM Direccion WHERE direccion = '{$_POST['direccion']}'");
                while ($fila = mysqli_fetch_array($direccion)) {
                    $idDireccion = $fila['idDireccion'];
                }
                /*Creacion de Contacto*/
                $query = mysqli_query($link, "INSERT INTO Contacto(idContacto, idCliente, idDireccion, idEstado, nombreCompleto, email)
                VALUES ('{$_POST['dni']}','{$idCliente}','{$idDireccion}',1,'{$_POST['nombres']}','{$_POST['email']}')");

                $queryPerformed = "INSERT INTO Contacto(idContacto, idCliente, idDireccion, idEstado, nombreCompleto, email)
                VALUES ({$_POST['dni']},{$idCliente},{$idDireccion},1,{$_POST['nombres']},{$_POST['email']})";

                $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','Contacto','{$queryPerformed}')");
                /*Creacion de Telefono*/
                $query = mysqli_query($link,"INSERT INTO Telefono(numero) VALUES ('{$_POST['telefono']}')");

                $queryPerformed = "INSERT INTO Telefono(numero) VALUES ({$_POST['telefono']})";

                $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','Telefono','{$queryPerformed}')");

                $telefono = mysqli_query($link, "SELECT * FROM Telefono WHERE numero = '{$_POST['telefono']}'");
                while ($fila = mysqli_fetch_array($telefono)) {
                    $idTelefono = $fila['idTelefono'];
                }

                $query = mysqli_query($link,"INSERT INTO ContactoTelefono(idContacto, idTelefono) VALUES ('{$_POST['dni']}','{$idTelefono}')");

                $queryPerformed = "INSERT INTO ContactoTelefono(idContacto, idTelefono) VALUES ({$_POST['dni']},{$idTelefono})";

                $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','ContactoTelefono','{$queryPerformed}')");

            }

            $query = mysqli_query($link, "INSERT INTO ConfirmacionVenta(idContrato, idContacto, idIncoterm, idVia, idMetodoPago, idcodificacionTalla, idEstado, fecha, shipdate, reference, moneda)
            VALUES ('{$_POST['idConfirmacionVenta']}','{$contacto}','{$_POST['incoterm']}','{$_POST['via']}','{$_POST['metodoPago']}','{$_POST['codifTalla']}',3,'{$_POST['fechaContrato']}','{$_POST['fechaEnvio']}','{$_POST['idReferencia']}','{$_POST['moneda']}')");

            $queryPerformed = "INSERT INTO ConfirmacionVenta(idContrato, idContacto, idIncoterm, idVia, idMetodoPago, idcodificacionTalla, idEstado, fecha, shipdate, reference)
            VALUES ({$_POST['idConfirmacionVenta']},{$contacto},{$_POST['incoterm']},{$_POST['via']},{$_POST['metodoPago']},{$_POST['codifTalla']},3,{$_POST['fechaContrato']},{$_POST['fechaEnvio']},{$_POST['idReferencia']},{$_POST['moneda']})";

            $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','Nueva ConfirmacionVenta','{$queryPerformed}')");

        }
    }

    if(isset($_POST['addCombinacion'])){

        $query = mysqli_query($link,"SELECT * FROM CombinacionesColor");
        $numrows = mysqli_num_rows($query);

        $numrows++;

        $nombreCombinacion = "";
        $result = mysqli_query($link,"SELECT DISTINCT codigoColor FROM ProductoComponentesPrenda WHERE idProducto = '{$_POST['idProducto']}' AND codigoColor IS NOT NULL ORDER BY codigoColor ASC");
        while ($fila = mysqli_fetch_array($result)){

            $color = "colorCombinacion".$fila['codigoColor'];

            $query = mysqli_query($link,"INSERT INTO CombinacionesColorColores(idCombinacionesColor, idColor, codigoColor) VALUES ('{$numrows}','{$_POST[$color]}','{$fila['codigoColor']}')");

            $queryPerformed = "INSERT INTO CombinacionesColorColores(idCombinacionesColor, idColor, codigoColor) VALUES ({$numrows},{$_POST[$color]},{$fila['codigoColor']})";

            $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','CombinacionesColorColores','{$queryPerformed}')");

            $nombreCombinacion .= $fila['codigoColor'].": ".$_POST[$color].";<br>";

        }

        $query = mysqli_query($link,"SELECT * FROM CombinacionesColor WHERE descripcion = '{$nombreCombinacion}'");
        $numrow = mysqli_num_rows($query);

        if($numrow == 0){

            $query = mysqli_query($link,"INSERT INTO CombinacionesColor(idCombinacionesColor, descripcion) VALUES ('{$numrows}','Nombre')");

            $queryPerformed = "INSERT INTO CombinacionesColor(idCombinacionesColor, descripcion) VALUES ({$numrows},Nombre)";

            $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','Nueva CombinacionColor','{$queryPerformed}')");

        }else{}

        $query = mysqli_query($link,"UPDATE CombinacionesColor SET descripcion = '{$nombreCombinacion}' WHERE idCombinacionesColor = '{$numrows}'");

        $queryPerformed = "UPDATE CombinacionesColor SET descripcion = {$nombreCombinacion} WHERE idCombinacionesColor = {$numrows}";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','UPDATE','CombinacionesColor','{$queryPerformed}')");

        $query = mysqli_query($link,"INSERT INTO CombinacionesColorProducto(idCombinacionesColor, idProducto) VALUES ('{$numrows}','{$_POST['idProducto']}')");

        $queryPerformed = "INSERT INTO CombinacionesColorProducto(idCombinacionesColor, idProducto) VALUES ({$numrows},{$_POST['idProducto']})";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','CombinacionesColorProducto','{$queryPerformed}')");

    }

    if(isset($_POST['addProductoCV'])){

        $result = mysqli_query($link,"SELECT * FROM Talla WHERE idCodificacionTalla = '{$_POST['codifTalla']}' ORDER BY indice ASC");
        while ($fila = mysqli_fetch_array($result)){
            if(isset($_POST[$fila['idTalla']])&&$_POST[$fila['idTalla']]){

                $query = mysqli_query($link,"INSERT INTO ConfirmacionVentaProducto(idProducto, idTalla, idCombinacionesColor, idContrato, idEstado, cantidad, cantidadop, codigoCliente, precio) VALUES ('{$_POST['idProducto']}','{$fila['idTalla']}','{$_POST['idCombinacionColores']}','{$_POST['idConfirmacionVenta']}',1,'{$_POST[$fila['idTalla']]}',0,'{$_POST['yourcode']}','{$_POST['precio']}')");

                $queryPerformed = "INSERT INTO ConfirmacionVentaProducto(idProducto, idTalla, idCombinacionesColor, idContrato, idEstado, cantidad, cantidadop, codigoCliente, precio) VALUES ({$_POST['idProducto']},{$fila['idTalla']},{$_POST['idCombinacionColores']},{$_POST['idConfirmacionVenta']},1,{$_POST[$fila['idTalla']]},0,{$_POST['yourcode']},{$_POST['precio']})";

                $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','INSERT','ConfirmacionVentaProducto','{$queryPerformed}')");

            }
        }

    }

    if(isset($_POST['eliminar'])){

        $query = mysqli_query($link,"DELETE FROM ConfirmacionVentaProducto WHERE idConfirmacionVentaProducto = '{$_POST['idConfirmacionVentaProducto']}'");

        $queryPerformed = "DELETE FROM ConfirmacionVentaProducto WHERE idConfirmacionVentaProducto = {$_POST['idConfirmacionVentaProducto']}";

        $databaseLog = mysqli_query($link, "INSERT INTO DatabaseLog (idEmpleado,fechaHora,evento,tipo,consulta) VALUES ('{$_SESSION['user']}','{$dateTime}','DELETE','ConfirmacionVentaProducto','{$queryPerformed}')");

    }

    include('header.php');
    include('navbarAdmin.php');

    if ($flag) {
        if(isset($_POST['addCombinacion'])){
            ?>

            <section class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header card-inverse card-info">
                                <div class="float-left mt-1">
                                    <i class="fa fa-shopping-bag"></i>
                                    &nbsp;&nbsp;Selección de Productos
                                </div>
                                <div class="float-right">
                                    <div class="dropdown">
                                        <form method="post" action="detalleCV.php">
                                            <input type="hidden" name="idConfirmacionVenta" value="<?php echo $_POST['idConfirmacionVenta']?>">
                                            <input type="hidden" name="codifTalla" value="<?php echo $_POST['codifTalla']?>">
                                            <input name="siguiente" type="submit" class="btn btn-light btn-sm" value="Finalizar">
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="card-block">
                                <div class="col-12">
                                    <div class="spacer20"></div>
                                    <form method="post" action="#">
                                        <input type="hidden" name="idConfirmacionVenta" value="<?php echo $_POST['idConfirmacionVenta']?>">
                                        <input type="hidden" name="codifTalla" value="<?php echo $_POST['codifTalla']?>">
                                        <div class="form-group row">
                                            <label for="idProducto" class="col-2 col-form-label">Código de Producto:</label>
                                            <div class="col-10">
                                                <input class="form-control" type="text" id="idProducto" value="<?php echo $_POST['idProducto']?>" name="idProducto" onchange="getTallas(this.value,<?php echo $_POST['codifTalla']?>);getCombinacionColores(this.value);getModalCombinacionColores(this.value,<?php echo $_POST['idConfirmacionVenta']?>,<?php echo $_POST['codifTalla']?>)" required>
                                            </div>
                                        </div>
                                        <div class="form-group row" id="rowColor">
                                            <label for='idCombinacionColores' class='col-2 col-form-label'>Combinación de Colores:</label>
                                            <div class='col-7'>
                                                <select class='form-control' id='idCombinacionColores' name='idCombinacionColores'>
                                                    <option disabled selected>Seleccionar</option>
                                                    <?php
                                                    $result = mysqli_query($link,"SELECT * FROM CombinacionesColorProducto WHERE idProducto = '{$_POST['idProducto']}'");
                                                    while ($fila = mysqli_fetch_array($result)){
                                                        $result1 = mysqli_query($link,"SELECT * FROM CombinacionesColor WHERE idCombinacionesColor = '{$fila['idCombinacionesColor']}'");
                                                        while ($fila1 = mysqli_fetch_array($result1)){
                                                            echo "<option value='{$fila['idCombinacionesColor']}'>{$fila1['descripcion']}</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class='col-2'>
                                                <button type='button' class='btn btn-outline-primary' data-toggle='modal' data-target='#modalNuevaCombinacion'>Agregar Combinación</button>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <table class="table text-center">
                                                <thead>
                                                <tr>
                                                    <th style="width: 15%">Código Cliente</th>
                                                    <th style="width: 10%">Material</th>
                                                    <th style="width: 10%">Precio</th>
                                                    <?php
                                                    $result = mysqli_query($link,"SELECT * FROM Talla WHERE idcodificacionTalla = '{$_POST['codifTalla']}'");
                                                    while ($fila = mysqli_fetch_array($result)){
                                                        echo "<th>{$fila['descripcion']}</th>";
                                                    }
                                                    ?>
                                                    <th>Acciones</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr id="row">
                                                    <?php
                                                    $result = mysqli_query($link,"SELECT * FROM Producto WHERE idProducto = '{$_POST["idProducto"]}'");
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
                                                    $result = mysqli_query($link,"SELECT * FROM Talla WHERE idcodificacionTalla = '{$_POST['codifTalla']}' ORDER BY indice ASC");
                                                    while ($fila = mysqli_fetch_array($result)) {
                                                        $tallas1[$indice1] = $fila['idTalla'];
                                                        $indice1++;
                                                    }
                                                    $talla = mysqli_query($link,"SELECT DISTINCT idTalla FROM TallaMedida WHERE idProducto = '{$_POST["idProducto"]}' AND valor>0");
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
                                                    ?>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header card-inverse card-info">
                                <div class="float-left mt-1">
                                    <i class="fa fa-shopping-bag"></i>
                                    &nbsp;&nbsp;Productos Seleccionados
                                </div>
                                <div class="float-right">
                                </div>
                            </div>
                            <div class="card-block">
                                <div class="col-12">
                                    <div class="spacer20"></div>
                                    <table class="table text-center">
                                        <thead>
                                        <tr>
                                            <th class="text-center">Código Cliente</th>
                                            <th class="text-center">Material</th>
                                            <th class="text-center">Colores</th>
                                            <th class="text-center">Precio</th>
                                            <th class="text-center">Talla</th>
                                            <th class="text-center">Cantidad</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $resultX = mysqli_query($link,"SELECT * FROM ConfirmacionVenta WHERE idContrato = '{$_POST['idConfirmacionVenta']}'");
                                        while ($filaX = mysqli_fetch_array($resultX)){
                                            switch($filaX['moneda']){
                                                case 1:
                                                    $simbolo = "S/.";
                                                    break;
                                                case 2:
                                                    $simbolo = "$";
                                                    break;
                                                case 3:
                                                    $simbolo = "€";
                                                    break;
                                            }
                                        }
                                        $result = mysqli_query($link,"SELECT * FROM ConfirmacionVentaProducto WHERE idContrato = '{$_POST['idConfirmacionVenta']}'");
                                        while ($fila = mysqli_fetch_array($result)){
                                            echo "<tr>";
                                            echo "<td>{$fila['codigoCliente']}</td>";
                                            $result1 = mysqli_query($link,"SELECT * FROM Producto WHERE idProducto = '{$fila["idProducto"]}'");
                                            while ($fila1 = mysqli_fetch_array($result1)){
                                                $material = $fila1['codificacionMaterial'];
                                            }
                                            $result1 = mysqli_query($link,"SELECT * FROM CombinacionesColor WHERE idCombinacionesColor = '{$fila['idCombinacionesColor']}'");
                                            while ($fila1 = mysqli_fetch_array($result1)){
                                                $combinacioncolor = $fila1['descripcion'];
                                            }
                                            $result1 = mysqli_query($link,"SELECT * FROM Talla WHERE idTalla = '{$fila['idTalla']}'");
                                            while ($fila1 = mysqli_fetch_array($result1)){
                                                $talla = $fila1['descripcion'];
                                            }
                                            echo "<td>{$material}</td>";
                                            echo "<td>{$combinacioncolor}</td>";
                                            echo "<td>{$simbolo} {$fila['precio']}</td>";
                                            echo "<td>{$talla}</td>";
                                            echo "<td>{$fila['cantidad']}</td>";
                                            echo "
                                                <td>
                                                    <form method='post' action='#'>
                                                        <input type='hidden' value='{$_POST['idConfirmacionVenta']}' name='idConfirmacionVenta'>
                                                        <input type='hidden' value='{$_POST['codifTalla']}' name='codifTalla'>
                                                        <input type='hidden' value='{$fila['idConfirmacionVentaProducto']}' name='idConfirmacionVentaProducto'>
                                                        <input type='submit' value='Eliminar' name='eliminar' class='btn btn-primary'>
                                                    </form>
                                                </td>
                                            ";
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

            <div id="modalColores">
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
                                        <input type="hidden" name="idProducto" value="<?php echo $_POST['idProducto']?>">
                                        <input type="hidden" name="codifTalla" value="<?php echo $_POST['codifTalla']?>">
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
                                                $result = mysqli_query($link,"SELECT DISTINCT codigoColor FROM ProductoComponentesPrenda WHERE idProducto = '{$_POST['idProducto']}' AND codigoColor IS NOT NULL ORDER BY codigoColor ASC");
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
            </div>

            <?php
        }else {
            ?>

            <section class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header card-inverse card-info">
                                <div class="float-left mt-1">
                                    <i class="fa fa-shopping-bag"></i>
                                    &nbsp;&nbsp;Selección de Productos
                                </div>
                                <div class="float-right">
                                    <div class="dropdown">
                                        <form method="post" action="detalleCV.php">
                                            <input type="hidden" name="idConfirmacionVenta" value="<?php echo $_POST['idConfirmacionVenta'] ?>">
                                            <input type="hidden" name="codifTalla" value="<?php echo $_POST['codifTalla'] ?>">
                                            <input name="siguiente" type="submit" class="btn btn-light btn-sm" value="Finalizar">
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="card-block">
                                <div class="col-12">
                                    <div class="spacer20"></div>
                                    <form method="post" action="#">
                                        <input type="hidden" name="idConfirmacionVenta" value="<?php echo $_POST['idConfirmacionVenta'] ?>">
                                        <input type="hidden" name="codifTalla" value="<?php echo $_POST['codifTalla'] ?>">
                                        <div class="form-group row">
                                            <label for="idProducto" class="col-2 col-form-label">Código de Producto:</label>
                                            <div class="col-10">
                                                <input class="form-control" type="text" id="idProducto" name="idProducto" onchange="getTallas(this.value,<?php echo $_POST['codifTalla'] ?>);getCombinacionColores(this.value);getModalCombinacionColores(this.value,<?php echo $_POST['idConfirmacionVenta'] ?>,<?php echo $_POST['codifTalla'] ?>)" required>
                                            </div>
                                        </div>
                                        <div class="form-group row" id="rowColor">
                                        </div>
                                        <div class="form-group row">
                                            <table class="table text-center">
                                                <thead>
                                                <tr>
                                                    <th style="width: 15%">Código Cliente</th>
                                                    <th style="width: 10%">Material</th>
                                                    <th style="width: 10%">Precio</th>
                                                    <?php
                                                    $result = mysqli_query($link, "SELECT * FROM Talla WHERE idcodificacionTalla = '{$_POST['codifTalla']}'");
                                                    while ($fila = mysqli_fetch_array($result)) {
                                                        echo "<th>{$fila['descripcion']}</th>";
                                                    }
                                                    ?>
                                                    <th>Acciones</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr id="row">
                                                    <td>
                                                        <label for='code' class='sr-only'>Código del Cliente</label>
                                                        <input id="code" type="text" name="yourcode" class="form-control" disabled>
                                                    </td>
                                                    <td>

                                                    </td>
                                                    <td>
                                                        <label for='precio' class='sr-only'>Precio</label>
                                                        <input id='precio' type='text' name='precio' class='form-control' disabled>
                                                    </td>
                                                    <?php
                                                    $result = mysqli_query($link, "SELECT * FROM Talla WHERE idcodificacionTalla = '{$_POST['codifTalla']}'");
                                                    while ($fila = mysqli_fetch_array($result)) {
                                                        echo "
                                                        <td><input type='number' class='form-control' min='0'></td>
                                                    ";
                                                    }
                                                    ?>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header card-inverse card-info">
                                <div class="float-left mt-1">
                                    <i class="fa fa-shopping-bag"></i>
                                    &nbsp;&nbsp;Productos Seleccionados
                                </div>
                                <div class="float-right">
                                </div>
                            </div>
                            <div class="card-block">
                                <div class="col-12">
                                    <div class="spacer20"></div>
                                    <table class="table text-center">
                                        <thead>
                                        <tr>
                                            <th class="text-center">Código Cliente</th>
                                            <th class="text-center">Material</th>
                                            <th class="text-center">Colores</th>
                                            <th class="text-center">Precio</th>
                                            <th class="text-center">Talla</th>
                                            <th class="text-center">Cantidad</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $resultX = mysqli_query($link, "SELECT * FROM ConfirmacionVenta WHERE idContrato = '{$_POST['idConfirmacionVenta']}'");
                                        while ($filaX = mysqli_fetch_array($resultX)) {
                                            switch ($filaX['moneda']) {
                                                case 1:
                                                    $simbolo = "S/.";
                                                    break;
                                                case 2:
                                                    $simbolo = "$";
                                                    break;
                                                case 3:
                                                    $simbolo = "€";
                                                    break;
                                            }
                                        }
                                        $result = mysqli_query($link, "SELECT * FROM ConfirmacionVentaProducto WHERE idContrato = '{$_POST['idConfirmacionVenta']}'");
                                        while ($fila = mysqli_fetch_array($result)) {
                                            echo "<tr>";
                                            echo "<td>{$fila['codigoCliente']}</td>";
                                            $result1 = mysqli_query($link, "SELECT * FROM Producto WHERE idProducto = '{$fila["idProducto"]}'");
                                            while ($fila1 = mysqli_fetch_array($result1)) {
                                                $material = $fila1['codificacionMaterial'];
                                            }
                                            $result1 = mysqli_query($link, "SELECT * FROM CombinacionesColor WHERE idCombinacionesColor = '{$fila['idCombinacionesColor']}'");
                                            while ($fila1 = mysqli_fetch_array($result1)) {
                                                $combinacioncolor = $fila1['descripcion'];
                                            }
                                            $result1 = mysqli_query($link, "SELECT * FROM Talla WHERE idTalla = '{$fila['idTalla']}'");
                                            while ($fila1 = mysqli_fetch_array($result1)) {
                                                $talla = $fila1['descripcion'];
                                            }
                                            echo "<td>{$material}</td>";
                                            echo "<td>{$combinacioncolor}</td>";
                                            echo "<td>{$simbolo} {$fila['precio']}</td>";
                                            echo "<td>{$talla}</td>";
                                            echo "<td>{$fila['cantidad']}</td>";
                                            echo "
                                                <td>
                                                    <form method='post' action='#'>
                                                        <input type='hidden' value='{$_POST['idConfirmacionVenta']}' name='idConfirmacionVenta'>
                                                        <input type='hidden' value='{$_POST['codifTalla']}' name='codifTalla'>
                                                        <input type='hidden' value='{$fila['idConfirmacionVentaProducto']}' name='idConfirmacionVentaProducto'>
                                                        <input type='submit' value='Eliminar' name='eliminar' class='btn btn-primary'>
                                                    </form>
                                                </td>
                                            ";
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

            <div id="modalColores"></div>

            <?php
        }
    }else{
        ?>

        <form method="post" action="nuevaCV_DatosGenerales.php">
            <section class="container">
                <div class="row">
                    <div class="col-6 offset-3">
                        <div class="card">
                            <div class="card-header card-inverse card-info">
                                <div class="float-left mt-1">
                                    <i class="fa fa-warning"></i>
                                    &nbsp;&nbsp;Mensaje de Error
                                </div>
                                <div class="float-right">
                                    <div class="dropdown">
                                        <input name="volver" type="submit" class="btn btn-light btn-sm" formaction="nuevaCV_DatosGenerales.php" value="Volver">
                                    </div>
                                </div>
                            </div>
                            <div class="card-block">
                                <div class="col-12">
                                    <div class="spacer20"></div>
                                    <h6 class="text-center">Ha ocurrido un error en el ingreso de datos de la Confirmación de Venta debido a que el Código de Contrato ingresado se encuentra duplicado. Por favor revise la información nuevamente.</h6>
                                    <div class="spacer20"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </form>

        <?php
    }

    include('footer.php');
}
?>