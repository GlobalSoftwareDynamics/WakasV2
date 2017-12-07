<?php
$op = $_POST['idOrdenProduccion'];
mkdir("barcodes/".$op."",0700);
$upload_dir = "barcodes/".$_POST['idOrdenProduccion']."/";
$img = $_POST['hidden_data'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$file = $upload_dir .$_POST['idOrdenProduccion'] ."LT".$_POST['name'] . ".png";
$success = file_put_contents($file, $data);
?>