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

function getContrato(val) {
    $.ajax({
        type: "POST",
        url: "getAjax.php",
        data:{'fechaContrato':val},
        success: function(data){
            $("#idConfirmacionVenta").html(data);
        }
    });
}

function getProductosContrato(val) {
    $.ajax({
        type: "POST",
        url: "getAjax.php",
        data:{'idConfirmacionVenta':val},
        success: function(data){
            $("#formMarcacion").html(data);
        }
    });
}

function getProductoLote(val) {
    $.ajax({
        type: "POST",
        url: "getAjax.php",
        data:{'idLoteA':val},
        success: function(data){
            $("#productoLote").html(data);
        }
    });
}

function getComponentesProductoLote(val) {
    $.ajax({
        type: "POST",
        url: "getAjax.php",
        data:{'idLoteB':val},
        success: function(data){
            $("#componente").html(data);
        }
    });
}

function getProcesosComponente(val) {

    var componenteEspecifico = document.getElementById("idLote").value;

    $.ajax({
        type: "POST",
        url: "getAjax.php",
        data:{'idComponenteEspecificoC':val, 'idLoteC': componenteEspecifico},
        success: function(data){
            $("#procedimiento").html(data);
        }
    });
}

function getMaquinasProcedimiento(val) {
    $.ajax({
        type: "POST",
        url: "getAjax.php",
        data:{'idMaquinaProcedimiento':val},
        success: function(data){
            $("#maquina").html(data);
        }
    });
}

function getCantidadRestanteLote(val) {

    var lote = document.getElementById("idLote").value;
    var componente = document.getElementById("componente").value;

    $.ajax({
        type: "POST",
        url: "getAjax.php",
        data:{'idProcedimientoSeleccionado':val, 'idLoteD': lote, 'idComponenteSeleccionado': componente},
        success: function(data){
            $("#cantidadRestanteLote").html(data);
        }
    });
}