//Encargado de filtrar la tabla con el boton de buscar
jQuery.expr[":"].containsNoCase = function(el, i, m) {
    var search = m[3];
    if (!search)
        return false;
    return eval("/" + search + "/i").test($(el).text());
};
//Engargado de cargar losdatos de todos los proyectos cuando se carga la pagina
var allProySalud;
var dialogEdit;
var dialogVer;
var dialogDelete;
var ps;
jQuery().ready(function() {
    $("#resultados input").change(function() {
        $('#' + this.id).val(numero(this.value));
    });
    $("#estado").change(function() {
        if (this.value == 3) {
            $("#resultados").show();
        } else {
            $("#resultados").hide();
        }
    });
    $("#fechaIni").datepicker({
        dateFormat: 'dd/mm/yy',
        showButtonPanel: true
    });
    filterTable();
    $("#txtSerch").keyup(function(e) {
        if (e.keyCode == 27) {
            this.value = '';
            $("#listVias tbody tr").show();
        }
    });
    dialogEdit = $('#dialog-edit').dialog({
        autoOpen: false,
        width: 1100,
        resizable: false,
        modal: true,
        draggable: false,
        buttons: {
            "Guardar": editSalud,
            Cancelar: function() {
                dialogEdit.dialog("close");
            }
        },
        close: function() {
            $('#formSalud')[0].reset();
            $('#lista-fotos-gd').html('');
        }
    });
    dialogVer = $('#dialog-ver').dialog({
        autoOpen: false,
        width: 1100,
        resizable: false,
        modal: true,
        draggable: false,
        buttons: {
            Cerrar: function() {
                dialogVer.dialog("close");
            }
        },
        close: function() {
        }
    });
    dialogDelete = $("#deleteDiv").dialog({
        autoOpen: false,
        resizable: false,
        modal: true,
        draggable: false,
        closeText: "Cerrar",
        buttons: {
            "Eliminar": function() {
                deleteSalud();
                $("#deleteDiv").dialog('close');
            },
            "Cancelar": function() {
                dialogDelete.dialog("close");
            }
        }
    });
});
function loadSaludPro() {
    $.ajax({
        url: '/salud/listadoSaludJson',
        type: 'POST',
        success: function(data, textStatus, jqXHR) {
            $('#titleTable').html('<p style="margin: 0px 18px 0px;">Lista de Proyectos </p>');
            var textTable = '';
            var editTable=''
            var deleteTable = '';
            var editActiv = '';
            $('#listsaludPro > tbody').html('');
            allProySalud = data;
            if (allProySalud.Records.length > 0) {
                $.each(data.Records, function(i, item) {
                    textTable = '<tr><td>' + item.vigencia
                            + '</td><td>' + item.numero
                            + '</td><td style="max-width: 150px;text-align: justify;">' + item.objetoContractual
                            + '</td><td>' + item.ejecutor + '</td>';
                    editTable = (edit)? '<td style="width: 2%;"><img id="' + item.id + '" style="cursor: pointer" title="Editar proyecto" class="icon-pencil"></i></td>':'';
                    editActiv = (edit)? '<td style="width: 2%;"><img id="' + item.idp + '" style="cursor: pointer" title="Ver Actividades" class="icon-calendar"></i></td>':'';
                    deleteTable = (borr)? '<td style="width: 2%;"><img id="' + item.id + '" style="cursor: pointer" title="Borrar proyecto" class="icon-trash"></i></td>':'';
                    $('#listsaludPro').append(textTable + '' + editTable + '' + deleteTable + '' + editActiv + '</tr>');
                    textTable = '';
                    editTable='';
                    deleteTable = '';
                    editActiv = '';
                });
                $("td > img").click(function() {
                    if (this.getAttribute('class') === 'icon-pencil') {
                        editDialog(this.id);
                    }
                    if (this.getAttribute('class') === 'icon-trash') {
                        deletDialog(this.id);
                    }
                    if (this.getAttribute('class') === 'icon-calendar') {
                        activities(this.id);
                    }
                });
            } else {
                $('#listsaludPro').append('<tr><td colspan="6" style="text-align:center">No existen proyectos</td></tr>');
            }
        }
    });
}
function loadSaludPublic() {
    $.ajax({
        url: '/home/listadoSaludJson',
        type: 'POST',
        success: function(data, textStatus, jqXHR) {
            $('#titleTable').html('<p style="margin: 0px 18px 0px;">Lista de Proyectos </p>');
            var textTable = '';
            var ver = '';
            $('#listsaludPro > tbody').html('');
            allProySalud = data;
            if (allProySalud.Records.length > 0) {
                $.each(data.Records, function(i, item) {
                    textTable = '<tr><td>' + item.vigencia
                            + '</td><td>' + item.numero
                            + '</td><td style="max-width: 150px;">' + item.nombre
                            + '</td><td style="max-width: 150px;text-align: justify;">' + item.objetoContractual
                            + '</td><td>' + item.ejecutor + '</td>';
                    ver = '<td style="width: 2%;"><img id="' + item.id + '" style="cursor: pointer" class="icon-eye-open"></i></td>';
                    $('#listsaludPro').append(textTable + '' + ver + '</tr>');
                    textTable = '';
                    ver = '';
                });
                $("td > img").click(function() {
                    if (this.getAttribute('class') === 'icon-eye-open') {
                        detalleProyecto(this.id);
                    }
                });
            } else {
                $('#listsaludPro').append('<tr><td colspan="6" style="text-align:center">No existen proyectos</td></tr>');
            }
        }
    });
}

function editDialog(data) {
//  validaciones de formulario 
    jQuery('#formSalud').validate({
        errorClass: 'text-error',
        rules: {
            vigencia: {required: true, maxlength: 4},
            numeroP: {required: true, maxlength: 10},
            valProj: {required: true, maxlength: 20,number:true},
            nombreP: {required: true, maxlength: 100},
            fechaIni: {required: true, maxlength: 10},
            segmento: {required: true, maxlength: 45},
            ejecutorP: {required: true, maxlength: 45},
            objetivo: {required: true, maxlength: 500},
            objetoC: {required: true, maxlength: 500},
            plazoEjec: {required: true, maxlength: 10,number:true},
            estado: {required: true, maxlength: 20}
        },
        messages: {
            vigencia: {required: 'Seleccione la vigencia del proyecto', maxlength: 'admiten 4 caracteres'},
            numeroP: {required: 'Ingrese el numero del proyecto', maxlength: 'admiten 10 caracteres'},
            valProj: {required: 'Ingrese el vamlor del proyecto', maxlength: 'admiten 20 caracteres',number:'El valor debe ser numerico'},
            nombreP: {required: 'Ingrese el nombre del proyecto', maxlength: 'admiten 100 caracteres'},
            fechaIni: {required: 'seleccione la fecha de inicio del proyecto', maxlength: 'admiten 10 caracteres'},
            segmento: {required: 'Seleccione el segmento de población', maxlength: 'admiten 45 caracteres'},
            ejecutorP: {required: 'Ingrese el ejecutor del proyecto', maxlength: 'admiten 500 caracteres'},
            objetivo: {required: 'Ingrese los objetivos del proyecto', maxlength: 'admiten 500 caracteres'},
            objetoC: {required: 'Ingrese el objeto contractual del proyecto', maxlength: 'admiten 10 caracteres'},
            plazoEjec: {required: 'Ingrese el plazo de ejecucion del proyecto', maxlength: 'admiten 10 caracteres',number:'El valor debe ser numerico'},
            estado: {required: 'Ingrese el estado del proyecto', maxlength: 'admiten 20 caracteres'}}

    });
    var formD = $('#formSalud')[0];
    $.each(allProySalud.Records, function(i, item) {
        if (item.id == data) {
            formD[0].value = item.id;
            formD[3].value = item.presupuesto;
            formD[4].value = item.nombre;
            formD[8].value = item.objetivo;
            formD[9].value = item.objetoContractual;
            formD[5].value = item.fechaInicio;
            formD[10].value = item.plazoEjecucion;
            formD[2].value = item.numero;
            formD[7].value = item.ejecutor;
            $.each(formD[1].options, function(i, itemVigencia) {
                if (itemVigencia.text == item.vigencia) {
                    formD[1].value = item.vigencia;
                }
            });
            $.each(formD[6].options, function(i, itemSegmento) {
                if (itemSegmento.text == item.segmento) {
                    itemSegmento.selected = true;
                }
            });
            $.each(formD[11].options, function(i, itemEstado) {
                if (itemEstado.text == item.estado) {
                    itemEstado.selected = true;
                }
            });
            ps = item.idp;
        }
    });
    if ($("#estado").val() == 3) {
        $("#resultados").show();
        cargarResultado(ps);
    } else {
        $("#resultados").hide();
    }
    cargarFotografias(ps);
    subirFotografias();
    dialogEdit.dialog('open');
    $("#btn-subirFotos").on("click", function() {
        $('#dir-photos').val(ps);
        var formData = new FormData($("#formulario-fotos")[0]);
        $.ajax({
            url: '/salud/saveeditphotos',
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(datos)
            {
                $('#formulario-fotos')[0].reset();
                $('#lista-fotos').html('');
                $('#lista-fotos-gd').html('');
                cargarFotografias(ps);
            }
        });
    });
}

function editSalud() {
    if (jQuery("#formSalud").valid()) {
        var editData = JSON.parse(JSON.stringify($('#formSalud').serializeArray()));
        $.ajax({
            url: "/salud/editarproyecto",
            type: 'POST',
            dataType: 'json',
            data: editData,
            success: function(data, textStatus, jqXHR) {
                if (jQuery('#estado').val() == 3) {
                    saveResults(jQuery('#Id').val());
                } else {
                    $('#formSalud')[0].reset();
                    dialogEdit.dialog('close');
                    loadSaludPro();
                }
            }
        });
    }
}
function activities(id) {
    relocate('/salud/actividades', {'id': id});
}
;
function detalleProyecto(id) {
    relocate('/home/proyecto-salud', {'id': id});
}
;
function deletDialog(data) {
    $("#deleteDiv p").attr('id', data);
    dialogDelete.dialog('open');
}
function deleteSalud() {
    $.ajax({
        url: '/salud/delete',
        type: 'POST',
        dataType: 'json',
        data: {'Id': $("#deleteDiv p").attr('id')},
        success: function(data, textStatus, jqXHR) {
            loadSaludPro();
            $("#deleteDiv").dialog('close');
        }
    });
}

function filterTable() {
    $('#serch').click(function() {
        var textSerch = $('#txtSerch').val();
        if (textSerch.length > 0) {
            $("#listsaludPro tbody tr").hide();
            if ($("#listsaludPro tr td:containsNoCase('" + textSerch + "')").parent().length > 0) {
                $("#listsaludPro tr td:containsNoCase('" + textSerch + "')").parent().show();
            } else {
//mostrar no se encontraron resultados
            }
        } else {
            $("#listsaludPro tbody tr").show();
        }
    });
    $("#txtSerch").keyup(function(e) {
        if (e.keyCode == 27) {
            this.value = '';
            $("#listsaludPro tbody tr").show();
        }
    });
}
function galeria_animacion() {
    $("area[rel^='prettyPhoto']").prettyPhoto();
    $(".gallery:first a[rel^='imagenes']").prettyPhoto({animation_speed: 'normal', theme: 'light_square', slideshow: 3000, autoplay_slideshow: false, social_tools: false});
    $(".gallery:gt(0) a[rel^='imagenes']").prettyPhoto({animation_speed: 'slow', slideshow: 10000, hideflash: true});
    $("#custom_content a[rel^='prettyPhoto']:first").prettyPhoto({
        custom_markup: '<div id="map_canvas" style="width:260px; height:265px"></div>',
        changepicturecallback: function() {
            initialize();
        }
    });
    $("#custom_content a[rel^='prettyPhoto']:last").prettyPhoto({
        custom_markup: '<div id="bsap_1259344" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div><div id="bsap_1237859" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6" style="height:260px"></div><div id="bsap_1251710" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div>',
        changepicturecallback: function() {
            _bsap.exec();
        }
    });
}

function relocate(page, params)
{
    var body = document.body;
    form = document.createElement('form');
    form.method = 'POST';
    form.action = page;
    form.name = 'jsform';
    for (index in params)
    {
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = index;
        input.id = index;
        input.value = params[index];
        form.appendChild(input);
    }
    body.appendChild(form);
    form.submit();
}



function saveResults(id) {
    jQuery('#form-resultados').validate({
        errorClass: 'text-error',
        rules: {
            total_p: {required: true, maxlength: 10}
        },
        messages: {
            total_p: {required: 'Debe ingresar el total de participantes', maxlength: 'se admiten 10 digitos'}}
    });
    if (jQuery("#form-resultados").valid()) {
        var valid = true;
        var acum = 0;
        var total = $('#total_p').val();
        var json = '{"total_p":' + total + ',';
        $("#resultados table").each(function() {
            var datos = "";
            $(this).find("input").each(function() {
                var n = (this.value == "") ? 0 : parseInt(this.value);
                acum = acum + n;
                datos += '"' + this.id + '":' + n + ",";
            });
            if (acum != 0) {
                if (acum != total) {
                    valid = false;
                    $("#" + this.id + " input:last-child").css({color: "red"})
                } else {
                    $("#" + this.id + " input:last-child").css({color: "black"})

                }
                datos = del(datos);
                json += '"' + this.id + '":{' + datos + '},';
            }
            acum = 0;
        });
        json = del(json) + '}';
        if (valid == true) {
            $.ajax({
                url: "/salud/saveResults",
                type: 'POST',
                dataType: 'json',
                data: {'id': id, 'resultados': json},
                success: function(data, textStatus, jqXHR) {
                    $('#formSalud')[0].reset();
                    $('#form-resultados')[0].reset();
                    dialogEdit.dialog('close');
                    loadSaludPro();
                }
            });
        } else {
            alert('Datos inconsistentes')
        }
    }
}

function validResults() {

}

function del(x) {
    var ax = x.substring(0, x.length - 1);
    return ax;
}

function cargarResultado() {
    var json;
    $.ajax({
        url: "/salud/resultadoscons",
        type: 'POST',
        dataType: 'json',
        data: {'id': ps},
        success: function(data, textStatus, jqXHR) {
            json = JSON.parse(data.Records.proyectoResultados);
            jQuery.throughObject(json);
        }
    });
}

jQuery.throughObject = function(obj) {
    for (var attr in obj) {
        $('#' + attr).val(obj[attr]);
        //  console.log(attr + 'XX : yy' + obj[attr]);
        if (typeof obj[attr] === 'object') {
            jQuery.throughObject(obj[attr]);
        }
    }
}

function numero(variable) {
    Numer = parseInt(variable);
    if (isNaN(Numer)) {
        return "";
    }
    return Numer;
}
function cargarFotografias(ps) {
    $.ajax({
        url: "/salud/fotografias",
        type: 'POST',
        dataType: 'json',
        data: {'id': ps},
        success: function(data, textStatus, jqXHR) {
            $.each(data.Records, function(i, item) {
                var span = document.createElement('div');
                span.innerHTML = ['<img class="foto-min" src="', item.fotografia,
                    '" title="Fotografia evidencia"><div class="btn-del-ftg">Eliminar<input type="hidden" value="' + item.fotografia + '"></div'].join('');
                span.style.float = "left";
                document.getElementById('lista-fotos-gd').insertBefore(span, null);
            });
            $(".btn-del-ftg").click(function() {
                var foto = $(this).children(":first").val();
                $.ajax({
                    url: "/salud/deleteImage",
                    type: 'POST',
                    dataType: 'json',
                    data: {'imagen': foto},
                    success: function(data, textStatus, jqXHR) {
                        $('#lista-fotos-gd').html('');
                        cargarFotografias(ps);
                    }
                });
            });
        }        
    });
}