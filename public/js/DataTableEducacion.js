//Encargado de filtrar la tabla con el boton de buscar
jQuery.expr[":"].containsNoCase = function(el, i, m) {
    var search = m[3];
    if (!search)
        return false;
    return eval("/" + search + "/i").test($(el).text());
};
//Engargado de cargar losdatos de todos los proyectos cuando se carga la pagina
var allProyEducacion;
var dialogEdit;
var dialogVer;
var dialogDelete;
var ps;
jQuery().ready(function() {
    $("#resultados input").change(function() {
        Solo_Numerico(this.value);
    });
    $("#estado").change(function() {
        if (this.value == 3) {
            $("#resultados").show();
            validacionesResultados();
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
            "Guardar": editEducacion,
            Cancelar: function() {
                dialogEdit.dialog("close");
            }
        },
        close: function() {
            $('#formEducacion')[0].reset();
            $('#form-resultados')[0].reset();
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
function loadEducacionProy() {
    $.ajax({
        url: '/educacion/listadoEducacionJson',
        type: 'POST',
        beforeSend: function(xhr) {
            $('#titleTable').html('<img src="/img/loaderUser.gif">');
        },
        success: function(data, textStatus, jqXHR) {
            $('#titleTable').html('<p style="margin: 0px 18px 0px;">Lista de Proyectos </p>');
            var textTable = '';
            var editDelete = '';
            $('#listEducacionPro > tbody').html('');
            allProyEducacion = data;
            if (allProyEducacion.Records.length > 0) {
                $.each(data.Records, function(i, item) {
                    textTable = '<tr><td>' + item.vigencia
                            + '</td><td>' + item.numero
                            + '</td><td>' + item.nombre
                            + '</td><td>' + item.cupos
                            + '</td><td style="max-width: 150px;text-align: justify;">' + item.objetivo
                            + '</td><td>' + item.ejecutor + '</td>';
                    editDelete = '<td style="width: 2%;"><img id="' + item.id + '" style="cursor: pointer" title="Editar proyecto" class="icon-pencil"></i></td>\n\
                    <td style="width: 2%;"><img id="' + item.id + '" style="cursor: pointer" title="Borrar proyecto" class="icon-trash"></i></td>\n\
                    <td style="width: 2%;"><img id="' + item.idp + '" style="cursor: pointer" title="Ver Actividades" class="icon-calendar"></i></td>';
                    $('#listEducacionPro').append(textTable + '' + editDelete + '</tr>');
                    textTable = '';
                    editDelete = '';
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
                $('#listEducacionPro').append('<tr><td colspan="6" style="text-align:center">No existen proyectos</td></tr>');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Estamos presentando inconvenientes de conexion');
        }
    });
}
function loadEducacionPublic() {
    $.ajax({
        url: '/home/listadoEducacionJson',
        type: 'POST',
        beforeSend: function(xhr) {
            $('#titleTable').html('<img src="/img/loaderUser.gif">');
        },
        success: function(data, textStatus, jqXHR) {
            $('#titleTable').html('<p style="margin: 0px 18px 0px;">Lista de Proyectos </p>');
            var textTable = '';
            var ver = '';
            $('#listEducacionPro > tbody').html('');
            allProyEducacion = data;
            if (allProyEducacion.Records.length > 0) {
                $.each(data.Records, function(i, item) {
                    textTable = '<tr><td>' + item.vigencia
                            + '</td><td>' + item.numero
                            + '</td><td style="max-width: 150px;">' + item.nombre
                            + '</td><td>' + item.cupos
                            + '</td><td style="max-width: 150px;text-align: justify;">' + item.objetivo
                            + '</td><td>' + item.ejecutor + '</td>';
                    ver = '<td style="width: 2%;"><img id="' + item.id + '" style="cursor: pointer" class="icon-eye-open"></i></td>';
                    $('#listEducacionPro').append(textTable + '' + ver + '</tr>');
                    textTable = '';
                    ver = '';
                });
                $("td > img").click(function() {
                    if (this.getAttribute('class') === 'icon-eye-open') {
                        detalleProyecto(this.id);
                    }
                });
            } else {
                $('#listeducacionPro').append('<tr><td colspan="6" style="text-align:center">No existen proyectos</td></tr>');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Estamos presentando inconvenientes de conexion');
        }
    });
}

function editDialog(data) {
//  validaciones de formulario 
    jQuery('#formEducacion').validate({
        errorClass: 'text-error',
        rules: {
            vigencia: {required: true, maxlength: 4},
            numeroP: {required: true, maxlength: 10},
            valProj: {required: true, maxlength: 20},
            nombreP: {required: true, maxlength: 100},
            fechaIni: {required: true, maxlength: 10},
            cupos: {required: true, maxlength: 45},
            ejecutorP: {required: true, maxlength: 45},
            objetivo: {required: true, maxlength: 500},
            perfilBen: {required: true, maxlength: 500},
            plazoEjec: {required: true, maxlength: 10},
            estado: {required: true, maxlength: 20}
        },
        messages: {
            vigencia: {required: 'Seleccione la vigencia del proyecto', maxlength: 'admiten 4 caracteres'},
            numeroP: {required: 'Ingrese el numero del proyecto', maxlength: 'admiten 10 caracteres'},
            valProj: {required: 'Ingrese el vamlor del proyecto', maxlength: 'admiten 20 caracteres'},
            nombreP: {required: 'Ingrese el nombre del proyecto', maxlength: 'admiten 100 caracteres'},
            fechaIni: {required: 'seleccione la fecha de inicio del proyecto', maxlength: 'admiten 10 caracteres'},
            cupos: {required: 'Ingrese el numero de cupos', maxlength: 'admiten 10 caracteres'},
            ejecutorP: {required: 'Ingrese el ejecutor del proyecto', maxlength: 'admiten 500 caracteres'},
            objetivo: {required: 'Ingrese los objetivos del proyecto', maxlength: 'admiten 500 caracteres'},
            perfilBen: {required: 'Ingrese el perfil del beneficiario', maxlength: 'admiten 500 caracteres'},
            plazoEjec: {required: 'Ingrese el plazo de ejecucion del proyecto', maxlength: 'admiten 10 caracteres'},
            estado: {required: 'Ingrese el estado del proyecto', maxlength: 'admiten 20 caracteres'}}

    });
    var formD = $('#formEducacion')[0];
    $.each(allProyEducacion.Records, function(i, item) {
        if (item.id == data) {
            formD[0].value = item.id;
            formD[3].value = item.presupuesto;
            formD[4].value = item.nombre;
            formD[8].value = item.objetivo;
            formD[9].value = item.perfilBeneficiario;
            formD[5].value = item.fechaInicio;
            formD[10].value = item.plazoEjecucion;
            formD[7].value = item.cupos;
            formD[2].value = item.numero;
            formD[6].value = item.ejecutor;
            $.each(formD[1].options, function(i, itemVigencia) {
                if (itemVigencia.text == item.vigencia) {
                    formD[1].value = item.vigencia;
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
    dialogEdit.dialog('open');
}

function editEducacion() {
    if (jQuery("#formEducacion").valid()) {
        var editData = JSON.parse(JSON.stringify($('#formEducacion').serializeArray()));
        $.ajax({
            url: "/educacion/editarproyecto",
            type: 'POST',
            dataType: 'json',
            data: editData,
            success: function(data, textStatus, jqXHR) {
                if (jQuery('#estado').val() == 3) {
                    saveResults(jQuery('#Id').val());
                } else {
                    $('#formEducacion')[0].reset();
                    dialogEdit.dialog('close');
                    loadEducacionProy();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("no se ha enviado bien");
            }
        });
    }
}
function activities(id) {
    relocate('/educacion/actividades', {'id': id});
}
;
function detalleProyecto(id) {
    relocate('/home/proyecto-educacion', {'id': id});
}
;
function deletDialog(data) {
    $("#deleteDiv p").attr('id', data);
    dialogDelete.dialog('open');
}
function deleteSalud() {
    $.ajax({
        url: '/educacion/delete',
        type: 'POST',
        dataType: 'json',
        data: {'Id': $("#deleteDiv p").attr('id')},
        success: function(data, textStatus, jqXHR) {
            loadEducacionProy();
            $("#deleteDiv").dialog('close');
        },
        error: function(jqXHR, textStatus, errorThrown) {

        }
    });
}

function filterTable() {
    $('#serch').click(function() {
        var textSerch = $('#txtSerch').val();
        if (textSerch.length > 0) {
            $("#listVias tbody tr").hide();
            if ($("#listVias tr td:containsNoCase('" + textSerch + "')").parent().length > 0) {
                $("#listVias tr td:containsNoCase('" + textSerch + "')").parent().show();
            } else {
//mostrar no se encontraron resultados
            }
        } else {
            $("#listUser tbody tr").show();
        }
    });
    $("#txtSerch").keyup(function(e) {
        if (e.keyCode == 27) {
            this.value = '';
            $("#listUser tbody tr").show();
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
            total_p: {required: 'Debe ingresar el total de participantes', maxlength: 'se admiten 10 digitos'}}});
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
                url: "/educacion/saveResults",
                type: 'POST',
                dataType: 'json',
                data: {'id': id, 'resultados': json},
                success: function(data, textStatus, jqXHR) {
                    $('#formEducacion')[0].reset();
                    $('#form-resultados')[0].reset();
                    dialogEdit.dialog('close');
                    loadEducacionProy();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert("no se ha enviado bien");
                }
            });
        } else {
            alert('Datos inconsistentes')
        }
    }
}
function del(x) {
    var ax = x.substring(0, x.length - 1);
    return ax;
}

function cargarResultado() {
    var json;
    $.ajax({
        url: "/educacion/resultadoscons",
        type: 'POST',
        dataType: 'json',
        data: {'id': ps},
        success: function(data, textStatus, jqXHR) {
            json = JSON.parse(data.Records.proyectoResultados);
            jQuery.throughObject(json);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert("no se ha enviado bien");
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