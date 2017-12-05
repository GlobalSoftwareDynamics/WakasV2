<?php
require_once __DIR__ . '/lib/mpdf/mpdf.php';

include('session.php');
include('funciones.php');
if(isset($_SESSION['login'])){

    $html='
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/Formatospdf.css" rel="stylesheet">
    </head>
    <body class="portrait"></body>
    
    ';

    $htmlheader='
        <header>
            
        </header>

    ';
    $htmlfooter='
          <div class="footer">
                <span style="font-size: 10px;">GSD-Wakas</span>
                                   
                                 
                              
                <span style="font-size: 10px">© 2017 by Global Software Dynamics.Visítanos en <a target="GSD" href="http://www.gsdynamics.com/">GSDynamics.com</a></span>
          </div>
    ';
    $nombrearchivo='Reporte de Compras,Ventas,Préstamos del '.$_POST['fechaInicioReporte'].' al '.$_POST['fechaFinReporte'].'.pdf';
    $mpdf = new mPDF('','A4',0,'','5',5,45,15,6,6);

// Write some HTML code:
    $mpdf->SetHTMLHeader($htmlheader);
    $mpdf->SetHTMLFooter($htmlfooter);
    $mpdf->WriteHTML($html);

// Output a PDF file directly to the browser
    $mpdf->Output($nombrearchivo,'D');
}else{
    include('sessionError.php');
}
?>