//Encargado de filtrar la tabla con el boton de buscar
jQuery.expr[":"].containsNoCase = function(el, i, m) {
    var search = m[3];
    if (!search)
        return false;
    return eval("/" + search + "/i").test($(el).text());
};
//Engargado de cargar losdatos de todos los proyectos cuando se carga la pagina
var allActivities;
var selectedProy;
var md;
jQuery().ready(function() {
    filterTable();

    $("#txtSerch").keyup(function(e) {
        if (e.keyCode == 27) {
            this.value = '';
            $("#listVias tbody tr").show();
        }
    });
    dialogCreateEdit = $('#formulario-actividades').dialog({
        autoOpen: false,
        width: 1300,
        resizable: false,
        modal: true,
        draggable: false,
        buttons: {
            "Guardar": saveActivity,
            Cancelar: function() {
                dialogCreateEdit.dialog("close");
            }
        },
        close: function() {
            $('#formEventoSalud')[0].reset();
        }
    });

    dialogVer = $('#dialog-ver').dialog({
        autoOpen: false,
        width: 1200,
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
                deleteActivity()();
                $("#deleteDiv").dialog('close');
            },
            "Cancelar": function() {
                dialogDelete.dialog("close");
            }
        }
    });
    $('#add-activity').click(function() {
        createEditDialog();
    });
});

function loadActividades(id, ub) {
    md = ub;
    $.ajax({
        url: '/' + md + '/listadoActividadesJson',
        type: 'POST',
        data: {'Id': id},
        beforeSend: function(xhr) {
            $('#titleTable').html('<img src="/img/loaderUser.gif">');
        },
        success: function(data, textStatus, jqXHR) {
            selectedProy = id;
            var textTable = '';
            var editActiv = '';
            var delActiv = '';
            $('#listaActividades > tbody').html('');
            allActivities = data;
            if (allActivities.Records.length > 0) {
                $.each(data.Records, function(i, item) {
                    textTable = '<tr><td>' + item.nombre
                            + '</td><td>' + item.fechaHora
                            + '</td><td>' + item.lugar
                            + '</td><td>' + item.objetivos + '</td>';
                    editActiv = (edit)? '<td style="width: 2%;"><img id="' + item.id + '" style="cursor: pointer" title="Editar actividad" class="icon-pencil"></i></td>':'';
                    delActiv = (borr)? '<td style="width: 2%;"><img id="' + item.id + '" style="cursor: pointer" title="Borrar actividad" class="icon-trash"></i></td>':'';
                    $('#listaActividades').append(textTable + '' + editActiv + '' + delActiv + '</tr>');
                    textTable = '';
                    editActiv = '';
                    delActiv = '';
                });
                $("td > img").click(function() {
                    if (this.getAttribute('class') === 'icon-pencil') {
                        createEditDialog(this.id);
                    }
                    if (this.getAttribute('class') === 'icon-trash') {
                        deletDialog(this.id);
                    }
                });
            } else {
                $('#listaActividades').append('<tr><td colspan="6" style="text-align:center">No existen Actividades</td></tr>');
            }
        }
    });
}

function createEditDialog(data) {
    if (data) {
        var formD = $('#formEventoSalud')[0];
        $.each(allActivities.Records, function(i, item) {
            if (item.id == data) {
                formD[0].value = item.id;
                formD[2].value = item.nombre;
                formD[4].value = item.fechaHora;
                formD[5].value = item.objetivos;
                formD[6].value = item.requisitos;

                $.each(formD[3].options, function(i, itemLugar) {
                    if (itemLugar.text == item.lugar) {
                        itemLugar.selected = true;
                    }
                });
            }
        });
    }
    dialogCreateEdit.dialog('open');
}

function saveActivity() {
    jQuery.validator.addMethod("formatoFecha", function(value, element) {
        return this.optional(element) || /^([0-2][0-9]|3[0-1])\/([0][0-9]|1[0-2])\/(20[0-9]{2})\s([0-1][0-9]|2[0-3]):([0-5][0-9])/i.test(value);
    }, "El formato de fecha y hora es incorrecto");

    jQuery('#formEventoSalud').validate({
        errorClass: 'text-error',
        rules: {
            nombreActividad: {required: true, maxlength: 20},
            lugarActividad: {required: true, maxlength: 20},
            fechaActividad: {required: true, maxlength: 20, formatoFecha: true},
            objetivoActividad: {required: true, maxlength: 200},
            requisitosActividad: {required: true, maxlength: 200}

        },
        messages: {
            nombreActividad: {required: 'Nombre de actividad es requerido', maxlength: 'admiten 20 caracteres'},
            lugarActividad: {required: 'Seleccione un lugar', maxlength: 'admiten 20 caracteres'},
            fechaActividad: {required: 'Ingrese la fecha y hora', maxlength: 'admiten 20 caracteres'},
            objetivoActividad: {required: 'Ingrese el objetivo de la actividad', maxlength: 'admiten 200 caracteres'},
            requisitosActividad: {required: 'Ingrese los requisitos de la actividad', maxlength: 'admiten 200 caracteres'},
        }
    });
    if (jQuery("#formEventoSalud").valid()) {
        $('#idProyecto').val(selectedProy);
        var createData = JSON.parse(JSON.stringify($('#formEventoSalud').serializeArray()));
        $.ajax({
            url: "/" + md + "/saveActivity",
            type: 'POST',
            dataType: 'json',
            data: createData,
            success: function(data, textStatus, jqXHR) {
                $('#formEventoSalud')[0].reset();
                dialogCreateEdit.dialog('close');
                loadActividades(selectedProy, md);
            }
        });
    }
}

function deletDialog(data) {
    $("#deleteDiv p").attr('id', data);
    dialogDelete.dialog('open');
}
function deleteActivity() {
    $.ajax({
        url: '/salud/deleteActivity',
        type: 'POST',
        dataType: 'json',
        data: {'Id': $("#deleteDiv p").attr('id')},
        success: function(data, textStatus, jqXHR) {
            loadActividades(selectedProy,md);
            $("#deleteDiv").dialog('close');
        }
    });
}

function filterTable() {
    $('#serch').click(function() {
        var textSerch = $('#txtSerch').val();
        if (textSerch.length > 0) {
            $("#listaActividades tbody tr").hide();
            if ($("#listaActividades tr td:containsNoCase('" + textSerch + "')").parent().length > 0) {
                $("#listaActividades tr td:containsNoCase('" + textSerch + "')").parent().show();
            } else {
                //mostrar no se encontraron resultados
            }
        } else {
            $("#listaActividades tbody tr").show();
        }
    });
    $("#txtSerch").keyup(function(e) {
        if (e.keyCode == 27) {
            this.value = '';
            $("#listaActividades tbody tr").show();
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
