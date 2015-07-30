//Encargado de filtrar la tabla con el boton de buscar
jQuery.expr[":"].containsNoCase = function(el, i, m) {
    var search = m[3];
    if (!search)
        return false;
    return eval("/" + search + "/i").test($(el).text());
};
//Engargado de cargar losdatos de todos los proyectos cuando se carga la pagina
var allLugares;
var dialogEdit;
var dialogDelete;
jQuery().ready(function() {
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
            $('#formLugar')[0].reset();
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
function loadLugares() {
    $.ajax({
        url: '/admin/jsonlugares',
        type: 'POST',
        beforeSend: function(xhr) {
            $('#titleTable').html('<img src="/img/loaderUser.gif">');
        },
        success: function(data, textStatus, jqXHR) {
            $('#titleTable').html('<p style="margin: 0px 18px 0px;">Lista de Lugares </p>');
            var textTable = '';
            var editDelete = '';
            $('#listaLugares > tbody').html('');
            allLugares = data;
            if (allLugares.Records.length > 0) {
                $.each(data.Records, function(i, item) {
                    textTable = '<tr><td>' + item.nombre
                            + '</td><td>' + item.direccion
                            + '</td><td>' + item.telefono
                            + '</td><td>' + item.barrio + '</td>';
                    editDelete = '<td style="width: 2%;"><img id="' + item.id + '" style="cursor: pointer" title="Editar proyecto" class="icon-pencil"></i></td>\n\
                    <td style="width: 2%;"><img id="' + item.id + '" style="cursor: pointer" title="Borrar proyecto" class="icon-trash"></i></td>';
                    $('#listaLugares').append(textTable + '' + editDelete + '</tr>');
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
                });
            } else {
                $('#listaLugares').append('<tr><td colspan="6" style="text-align:center">No existen proyectos</td></tr>');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Estamos presentando inconvenientes de conexion');
        }
    });
}

function editDialog(data) {
//  validaciones de formulario 
    jQuery('#formLugar').validate({
        errorClass: 'text-error',
        rules: {
            nombre: {required: true, minlength: 2},
            direccion: {required: true, minlength: 2},
            barrio: {required: true}
        },
        messages: {
            nombre: {required: 'Por favor ingrese un nombre valido', minlength: 'Nombre demasiado corto'},
            direccion: {required: 'Por favor ingrese un direccion valido', minlength: 'Apellido demasiado corto'},
            barrio: {required: 'Seleccione un barrio valido'}
        }
    });
    var formD = $('#formLugar')[0];
    var c;
    $.each(allLugares.Records, function(i, item) {
        if (item.id == data) {
            formD[0].value = item.id;
            formD[1].value = item.nombre;
            formD[2].value = item.direccion;
            formD[3].value = item.coordenadas;
            formD[4].value = item.telefono;
            $.each(formD[5].options, function(i, itemTipo) {
                if (itemTipo.text == item.tipo) {
                    formD[5].value = item.tipo;
                }
            });
            $.each(formD[6].options, function(i, itemBarrio) {
                if (itemBarrio.text == item.segmento) {
                    itemBarrio.selected = true;
                }
            });
            c = item.coordenadas;
        }
    });

    dialogEdit.dialog('open');
    mapaEdicionLugar(c);
}

function editSalud() {
    if (jQuery("#formLugar").valid()) {
        var data = IO.IN(shapes, true);
        byId('coordenadas').value = JSON.stringify(data);
        if (shapes.length > 0) {
            var editData = JSON.parse(JSON.stringify($('#formLugar').serializeArray()));
            $.ajax({
                url: "/admin/editarlugar",
                type: 'POST',
                dataType: 'json',
                data: editData,
                success: function(data, textStatus, jqXHR) {
                    dialogEdit.dialog('close');
                    loadLugares();

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert("no se ha enviado bien");
                }
            });
        } else {
            alert('Debe Ingresar la ubicacion en el mapa');
        }

    }
}
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
        },
        error: function(jqXHR, textStatus, errorThrown) {

        }
    });
}

function filterTable() {
    $('#serch').click(function() {
        var textSerch = $('#txtSerch').val();
        if (textSerch.length > 0) {
            $("#listaLugares tbody tr").hide();
            if ($("#listaLugares tr td:containsNoCase('" + textSerch + "')").parent().length > 0) {
                $("#listVias tr td:containsNoCase('" + textSerch + "')").parent().show();
            } else {
//mostrar no se encontraron resultados
            }
        } else {
            $("#listaLugares tbody tr").show();
        }
    });
    $("#txtSerch").keyup(function(e) {
        if (e.keyCode == 27) {
            this.value = '';
            $("#listaLugares tbody tr").show();
        }
    });
}