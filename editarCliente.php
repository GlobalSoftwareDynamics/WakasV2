<?php
include('session.php');
include('declaracionFechas.php');
include('funciones.php');
if(isset($_SESSION['login'])){
    include('header.php');
    include('navbarAdmin.php');

    $result = mysqli_query($link,"SELECT * FROM Cliente WHERE idCliente = '{$_POST['idCliente']}'");
    while($row = mysqli_fetch_array($result)) {
        $result1 =  mysqli_query($link, "SELECT * FROM Contacto WHERE idContacto = '{$_POST['idCliente']}'");
        while($row1 = mysqli_fetch_array($result1)) {
            $idDireccion = $row1['idDireccion'];
            $direccion = $row1['direccion'];
            $result2 = mysqli_query($link,"SELECT * FROM Ciudad WHERE idCiudad = '{$row1['idCiudad']}'");
            while ($fila1 = mysqli_fetch_array($result2)){
                $ciudad = $fila1['nombre'];
                $idCiudad = $fila1['idCiudad'];
                $result3 = mysqli_query($link,"SELECT * FROM Pais WHERE idPais = '{$fila1['idPais']}'");
                while ($fila2 = mysqli_fetch_array($result3)){
                    $pais = $fila2['pais'];
                }
            }

            ?>

            <section class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header card-inverse card-info">
                                <div class="float-left">
                                    <i class="fa fa-user"></i>
                                    Editar Cliente
                                </div>
                                <div class="float-right">
                                    <div class="dropdown">
                                        <button form="form" name='volver' class='btn btn-light btn-sm'>Volver</button>
                                        <button form="form" name='editar' class='btn btn-light btn-sm'>Guardar</button>
                                    </div>
                                </div>
                            </div>
                            <form method="post" action="gestionClientes.php" id="form">
                                <input type="hidden" name="idCliente" value="<?php echo $_POST['idCliente']; ?>">
                                <div class="card-block">
                                    <div class="col-12">
                                        <div class="spacer15"></div>
                                        <div class="form-group row">
                                            <label for="nombre" class="col-2 col-form-label">Nombre:</label>
                                            <div class="col-10">
                                                <input class="form-control" type="text" id="nombre" name="nombre"
                                                       value="<?php echo $row['nombre']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="email" class="col-2 col-form-label">Correo Electrónico:</label>
                                            <div class="col-10">
                                                <input class="form-control" type="text" id="email" name="email"
                                                       value="<?php echo $row['email']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="direccion" class="col-2 col-form-label">Dirección:</label>
                                            <div class="col-10">
                                                <input class="form-control" type="text" id="direccion" name="direccion"
                                                       value="<?php echo $direccion; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="ciudad" class="col-2 col-form-label">Ciudad:</label>
                                            <div class="col-10">
                                                <select class="form-control" id="ciudad" name="ciudad">
                                                    <option selected
                                                            value="<?php echo $idCiudad ?>"><?php echo $ciudad ?></option>
                                                    <?php
                                                    $opcionesciudad = mysqli_query($link, "SELECT * FROM Ciudad ORDER BY nombre DESC");
                                                    while ($row1 = mysqli_fetch_array($opcionesciudad)) {
                                                        echo "<option value='{$row1['idCiudad']}'>{$row1['nombre']}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>

            <?php
        }
    }
    include('footer.php');
}
?>
