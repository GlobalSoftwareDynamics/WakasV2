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

function getModalColores(producto, contrato, codificacionTalla) {
    $.ajax({
        type: "POST",
        url: "getAjax.php",
        data:{'productoCVModalColoresB':producto, 'idConfirmacionVenta': contrato, 'codificacionTalla': codificacionTalla},
        success: function(data){
            $("#modalColoresB").html(data);
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

function getContratoReporte(val) {
    $.ajax({
        type: "POST",
        url: "getAjax.php",
        data:{'fechaContratoReporte':val},
        success: function(data){
            $("#idConfirmacionVenta").html(data);
        }
    });
}

function getOrdenProduccionReporte(val) {
    $.ajax({
        type: "POST",
        url: "getAjax.php",
        data:{'idConfirmacionVentaReporte':val},
        success: function(data){
            $("#idOrdenProduccion").html(data);
        }
    });
}

function getLoteReporte(val) {
    $.ajax({
        type: "POST",
        url: "getAjax.php",
        data:{'idLoteReporte':val},
        success: function(data){
            $("#loteOrden").html(data);
        }
    });
}

function getNombreEmpleado(val) {
    $.ajax({
        type: "POST",
        url: "getAjax.php",
        data:{'getNombreEmpleado':val},
        success: function(data){
            $("#nombreEmpleado").attr("value",data);
        }
    });
}

function getDniEmpleado(val) {
    $.ajax({
        type: "POST",
        url: "getAjax.php",
        data:{'getDniEmpleado':val},
        success: function(data){
            $("#Empleado").html(data);
        }
    });
}

function getProductosContrato(val) {
    $.ajax({
        type: "POST",
        url: "getAjax.php",
        data:{'idConfirmacionVentaContrato':val},
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