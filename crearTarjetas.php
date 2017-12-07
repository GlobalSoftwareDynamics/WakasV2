<?php
include('session.php');
include('declaracionFechas.php');
include ('funciones.php');
if(isset($_SESSION['login'])){

    include('header.php');
    include('navbarAdmin.php');
    ?>

    <section class="container">
        <div class="card">
            <div class="card-header card-inverse card-info">
                <i class="fa fa-cog"></i>
                Códigos de Barras para Tarjetas
                <div class="float-right">
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Acciones
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <form method="post" id="formularioTarjetas">
                                <input type="hidden" name="idOrdenProduccion" value="<?php echo $_POST['idOrdenProduccion'];?>" readonly>
                                <input type="button" onclick="uploadEx()" value="Descargar Códigos" class="dropdown-item">
                                <input type="submit" class="dropdown-item" name="tarjetas" value="Descargar Tarjetas" formaction="detalleTarjetasPDF.php">
                                <input type="submit" formaction="gestionOP.php" value="Listado de OP" class="dropdown-item">
                            </form>
                        </div>
                    </div>
                </div>
                <span class="float-right">&nbsp;&nbsp;&nbsp;&nbsp;</span>
            </div>
            <div class="card-block">
                <div class="spacer20"></div>
                <div class="row">
                    <div class="col-12">
                        <table class="table table-bordered text-center">
                            <thead>
                            <tr>
                                <th>idLote</th>
                                <th>Código</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $indice=0;
                            $result = mysqli_query($link,"SELECT * FROM Lote WHERE idOrdenProduccion ='{$_POST['idOrdenProduccion']}' ORDER BY posicion");
                            while ($fila = mysqli_fetch_array($result)){
                                $bar=$fila['idLote'];
                                echo "<tr>";
                                echo "<td>".$bar."</td>";
                                echo "<td><canvas id='".$indice."'></canvas></td>";
                                ?>
                                <script>
                                    $(document).ready(function () {
                                        $("#<?php echo $indice;?>").JsBarcode("<?php echo $bar;?>",{displayValue: false});
                                    });
                                </script>
                                <?php
                                $indice++;
                                echo "</tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="spacer15"></div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group row">
                            <label for="obs" class="col-3 col-form-label text-right">Observación para Tarjetas:</label>
                            <div class="col-7">
                                <textarea id="obs" form="formularioTarjetas" rows="3" name="observacion" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <form method="post" accept-charset="utf-8" name="form1">
        <input name="hidden_data" id='hidden_data' type="hidden"/>
        <input name="name" id='name' type="hidden"/>
        <input name="idOrdenProduccion" id='op' type="hidden" value="<?php echo $_POST['idOrdenProduccion'];?>"/>
    </form>

    <script>
        function uploadEx() {
            for ($i=0; $i<<?php echo $indice+1?>; $i++) {

                var canvas = document.getElementById($i);
                var dataURL = canvas.toDataURL("image/png");
                document.getElementById('hidden_data').value = dataURL;
                document.getElementById('name').value = $i+1;
                var fd = new FormData(document.forms["form1"]);

                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'upload_data.php', true);

                xhr.upload.onprogress = function (e) {
                    if (e.lengthComputable) {
                        var percentComplete = (e.loaded / e.total) * 100;
                        console.log(percentComplete + '% uploaded');

                    }
                };

                xhr.onload = function () {

                };
                xhr.send(fd);
            }
        }
    </script>

    <?php

    include('footer.php');
}
?>