<?php
include('session.php');
include('declaracionFechas.php');
include('funciones.php');
if(isset($_SESSION['login'])){
    include('header.php');
    include('navbarAdmin.php');

    $result = mysqli_query($link,"SELECT * FROM Cliente WHERE idCliente = '{$_POST['idCliente']}'");
    while($row = mysqli_fetch_array($result)) {

        ?>

        <section class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-inverse card-info">
                            <form method="post" action="gestionClientes.php" id="form">
                                <div class="float-left">
                                    <i class="fa fa-user"></i>
                                    Tarjeta de Cliente
                                </div>
                                <div class="float-right">
                                    <div class="dropdown">
                                        <input type='submit' value='Volver' name='volver' class='btn btn-light btn-sm'>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-block">
                            <div class="col-12">
                                <div class="spacer15"></div>
                                <div class="row">
                                    <div class="col-2"><p><b>Nombre:</b></p></div>
                                    <div class="col-10"><p><?php echo $row['nombre']; ?></p></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="spacer15"></div>
        <section class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-inverse card-info">
                            <div class="float-left">
                                <i class="fa fa-users"></i>
                                Listado de Contactos
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="col-12">
                                <table class="table table-bordered text-center">
                                    <thead class="thead-default">
                                    <tr>
                                        <th class="text-center">Nombre</th>
                                        <th class="text-center">Dirección</th>
                                        <th class="text-center">Ciudad</th>
                                        <th class="text-center">Estado</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $restult = mysqli_query($link, "SELECT * FROM Contacto WHERE idCliente = '{$_POST['idCliente']}' ORDER BY idEstado ASC");
                                    while ($fila = mysqli_fetch_array($restult)){
                                        echo "<tr>";
                                        echo "<td>{$fila['nombreCompleto']}</td>";
                                        $restult1 = mysqli_query($link, "SELECT * FROM Direccion WHERE idDireccion = '{$fila['idDireccion']}'");
                                        while ($fila1 = mysqli_fetch_array($restult1)){
                                            echo "<td>{$fila1['direccion']}</td>";
                                            $restult2 = mysqli_query($link, "SELECT * FROM Ciudad WHERE idCiudad = '{$fila1['idCiudad']}'");
                                            while ($fila2 = mysqli_fetch_array($restult2)){
                                                echo "<td>{$fila2['nombre']}</td>";
                                            }
                                        }
                                        $restult1 = mysqli_query($link, "SELECT * FROM Estado WHERE idEstado = '{$fila['idEstado']}'");
                                        while ($fila1 = mysqli_fetch_array($restult1)){
                                            $descripcion = $fila1['descripcion'];
                                            echo "<td>{$fila1['descripcion']}</td>";
                                        }
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
    }
    include('footer.php');
}
?>
