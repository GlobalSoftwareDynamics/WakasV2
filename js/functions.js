function getClienteCV(val) {
    $.ajax({
        type: "POST",
        url: "getAjax.php",
        data:{'nombreCliente':val},
        success: function(data){
            $("#datosCliente").html(data);
        }
    });
}

function getTablaTallas(val) {
    $.ajax({
        type: "POST",
        url: "getAjax.php",
        data:{'idCodificacionTalla':val},
        success: function(data){
            $("#tablaTallas").html(data);
        }
    });
}

function getTallas(producto,codificacion) {
    $.ajax({
        type: "POST",
        url: "getAjax.php",
        data:{'productoCV':producto, 'idcodificacionTallaCV':codificacion},
        success: function(data){
            $("#row").html(data);
        }
    });
}