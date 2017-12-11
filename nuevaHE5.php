<?php
include('session.php');
if(isset($_SESSION['login'])){
	include('header.php');
	include('navbarAdmin.php');
	include('funciones.php');
	include('declaracionFechas.php');
	?>

	<section class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-inverse card-info">
                        <div class="float-left mt-1">
                            <i class="fa fa-pencil"></i>
                            &nbsp;&nbsp;Finalización de Producto
                        </div>
                        <div class="float-right">
                            <div class="dropdown">
                                <button name="volver" type="submit" class="btn btn-light btn-sm" form="formSiguiente" formaction="nuevaHE4.php">Volver</button>
                                <button name="siguiente" type="submit" class="btn btn-light btn-sm" form="formSiguiente">Finalizar</button>
                            </div>
                        </div>
                    </div>
                    <form id="formSiguiente" method="post" action="mainAdmin.php" enctype='multipart/form-data'>
                        <input type="hidden" name="idProductoCrear" value="<?php echo $_POST['idProductoCrear']?>">
                        <input type="hidden" name="volverHE5">
                    </form>
                    <div class="card-block">
                        <div class="col-12">
                            <div class="spacer20"></div>
	                        <?php
	                        $target_dir = "img/fotografias/";
	                        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	                        $uploadOk = 1;
	                        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

	                        if (file_exists($target_file)) {
		                        echo "<div class='alert alert-danger col-12'>Lo lamentamos, su fotografía ya ha sido agregada previamente.</div><br>";
		                        $uploadOk = 0;
	                        }

	                        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "PNG" && $imageFileType != "jpeg"
		                        && $imageFileType != "gif" ) {
		                        echo "<div class='alert alert-danger col-12'>Lo lamentamos, solo se permiten los formatos de imagen jpg, png, jpeg y gif.</div><br>";
		                        $uploadOk = 0;
	                        }

	                        if ($uploadOk == 0) {
		                        echo "<div class='alert alert-danger col-12'>Su fotografía no fue subida.</div><br>";

	                        } else {
		                        $i = 0;
		                        $aux=0;
		                        $dir = 'img/fotografias/';
		                        for($j=0;$j<3;$j++) {
			                        $file = null;
			                        $filenamejpg = 'img/fotografias/' . $_POST['idProductoCrear'] . $j . '.jpg';
			                        $filenamejpeg = 'img/fotografias/' . $_POST['idProductoCrear'] . $j . '.jpeg';
			                        $filenamegif = 'img/fotografias/' . $_POST['idProductoCrear'] . $j . '.gif';
			                        $filenamepng = 'img/fotografias/' . $_POST['idProductoCrear'] . $j . '.png';
			                        if (file_exists($filenamejpg)) {
				                        $file = $filenamejpg;
				                        $aux++;
			                        } elseif (file_exists($filenamejpeg)) {
				                        $file = $filenamejpeg;
				                        $aux++;
			                        } elseif (file_exists($filenamegif)) {
				                        $file = $filenamegif;
				                        $aux++;
			                        } elseif (file_exists($filenamepng)) {
				                        $file = $filenamepng;
				                        $aux++;
			                        }
		                        }
		                        $temp = explode(".", $_FILES["fileToUpload"]["name"]);
		                        $newfilename = $_POST['idProductoCrear'].'.' . end($temp);
		                        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir.$newfilename)) {
			                        echo "<div class='alert alert-success col-12'>Su producto ha sido registrado exitosamente</div><br>";
		                        } else {
			                        echo "<div class='alert alert-danger col-12'>Lo lamentamos, hubo un error subiendo su fotografía.</div><br>";
		                        }
	                        }
	                        ?>
                        </div>
                    </div>
                </div>
	</section>

	<?php
	include('footer.php');
}
?>