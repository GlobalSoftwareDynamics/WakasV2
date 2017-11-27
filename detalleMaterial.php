<?php
include('session.php');
include('declaracionFechas.php');
include('funciones.php');
if(isset($_SESSION['login'])){
    include('header.php');
    include('navbarAdmin.php');

    $result = mysqli_query($link,"SELECT * FROM Material WHERE idMaterial = '{$_POST['idMaterial']}'");
    while($row = mysqli_fetch_array($result)) {
        ?>

        <section class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-inverse card-info">
                            <form method="post" action="gestionMateriales.php" id="form">
                                <div class="float-left">
                                    <i class="fa fa-industry"></i>
                                    Tarjeta de Material
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
                                    <div class="col-3"><p><b>Material:</b></p></div>
                                    <div class="col-9"><p><?php echo $row['material']; ?></p></div>
                                </div>
                                <div class="row">
                                    <div class="col-3"><p><b>Unidad de Medida:</b></p></div>
                                    <div class="col-9"><p><?php echo $row['idUnidadMedida'];; ?></p></div>
                                </div>
                                <div class="row">
                                    <div class="col-3"><p><b>Siglas:</b></p></div>
                                    <div class="col-9"><p><?php echo $row['siglas']; ?></p></div>
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
                                <i class="fa fa-dropbox"></i>
                                Proveedores
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="col-12">
                                <table class="table text-center">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Nombre</th>
                                        <th class="text-center">Costo</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $result=mysqli_query($link,"SELECT * FROM MaterialProveedor WHERE idMaterial = '{$_POST['idMaterial']}'");
                                    while ($fila=mysqli_fetch_array($result)){
                                        echo "<tr>";
                                        $result1=mysqli_query($link,"SELECT * FROM Proveedor WHERE idProveedor = '{$fila['idProveedor']}'");
                                        while ($fila1=mysqli_fetch_array($result1)){
                                            echo "<td>{$fila1['nombre']}</td>";
                                        }
                                        echo "<td>{$fila['costo']}</td>";
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
