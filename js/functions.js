$(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});

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

function getCombinacionColores(producto) {
    $.ajax({
        type: "POST",
        url: "getAjax.php",
        data:{'productoCVColores':producto},
        success: function(data){
            $("#rowColor").html(data);
        }
    });
}

function getModalCombinacionColores(producto, contrato, codificacionTalla) {
    $.ajax({
        type: "POST",
        url: "getAjax.php",
        data:{'productoCVModalColores':producto, 'idConfirmacionVenta': contrato, 'codificacionTalla': codificacionTalla},
        success: function(data){
            $("#modalColores").html(data);
        }
    });
}

function getUnidadMedida(val) {
    $.ajax({
        type: "POST",
        url: "getAjax.php",
        data:{'idMaterialUM':val},
        success: function(data){
            $("#unidadMedida").html(data);
        }
    });
}

function getMaterial(val) {
    $.ajax({
        type: "POST",
        url: "getAjax.php",
        data:{'idComponenteEspecifico':val},
        success: function(data){
            $("#materialTejido").html(data);
        }
    });
}