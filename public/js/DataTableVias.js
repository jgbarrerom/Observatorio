//Encargado de filtrar la tabla con el boton de buscar
jQuery.expr[":"].containsNoCase = function(el, i, m) {
    var search = m[3];
    if (!search)
        return false;
    return eval("/" + search + "/i").test($(el).text());
};
//Engargado de cargar losdatos de todos los proyectos cuando se carga la pagina
var allVias;
var dialogEdit;
var dialogDelete;
jQuery().ready(function() {
    loadUsers();
    $('#search').click(function() {
        var textSerch = $('#txtSerch').val();
        if (textSerch.length > 0) {
            $("#listVias tbody tr").hide();
            if ($("#listVias tr td:containsNoCase('" + textSerch + "')").parent().length > 0) {
                $("#listVias tr td:containsNoCase('" + textSerch + "')").parent().show();
            } else {
                //mostrar no se encontraron resultados
            }
        } else {
            $("#listVias tbody tr").show();
        }
    });
    $("#txtSerch").keyup(function(e) {
        if (e.keyCode == 27) {
            this.value = '';
            $("#listVias tbody tr").show();
        }
    });
    dialogEdit = $('#dialog-edit').dialog({
        autoOpen: false,
        width: 1200,
        resizable: false,
        modal: true,
        draggable: false,
        buttons: {
            "Guardar": editVia,
            Cancelar: function() {
                dialogEdit.dialog("close");
            }
        },
        close: function() {
            $('#FormGuardarVia')[0].reset();
            $( "#googleMapSalida" ).html(" ");
        }
    });
});

function loadUsers() {
    $.ajax({
        url: '/vias/listadoViasJson',
        type: 'POST',
        beforeSend: function(xhr) {
            $('#titleTable').html('<img src="/img/loaderUser.gif">');
        },
        success: function(data, textStatus, jqXHR) {
            $('#titleTable').html('<p style="margin: 0px 18px 0px;">Lista de Vias</p>');
            var textTable = '';
            var editDelete = '';
            $('#listVias > tbody').html('');
            allVias = data;
            if (allVias.Records.length > 0) {
                $.each(data.Records, function(i, item) {
                    textTable = '<tr><td>' + item.civ
                            + '</td><td>' + item.dirInicio
                            + '</td><td>' + item.dirFinal
                            + '</td><td>' + item.tramo + '</td>';
                    editDelete = '<td style="width: 2%;"><img id="' + item.id + '" style="cursor: pointer" class="icon-pencil"></i></td><td style="width: 2%;"><img id="' + item.id + '" style="cursor: pointer" class="icon-trash"></i></td>';
                    $('#listVias').append(textTable + '' + editDelete + '</tr>');
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
                $('#listVias').append('<tr><td colspan="6" style="text-align:center">No existen proyectos</td></tr>');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Estamos presentando inconvenientes de conexion');
        }
    });
}

function editDialog(data) {
    var formD = $('#FormGuardarVia')[0];
    $.each(allVias.Records, function(i, item) {
        if (item.id == data) {
            formD[1].value = item.tramo;
            formD[2].value = item.dirInicio;
            formD[3].value = item.dirFinal;
            formD[4].value = item.civ;
            formD[5].value = item.presupuesto;
            formD[6].value = item.largo;
            formD[7].value = item.ancho;
            formD[12].value = item.interventor;
            formD[14].value = item.coordenadas;

            $.each(formD[0].options, function(i, itemAnio) {
                if (itemAnio.text == item.anio) {
                    formD[0].value = item.anio;
                }
            });
            $.each(formD[8].options, function(i, itemTipo) {
                if (itemTipo.text == item.tipo) {
                    itemTipo.selected = true;
                }
            });
            $.each(formD[9].options, function(i, itemEstado) {
                if (itemEstado.text == item.estado) {
                    itemEstado.selected = true;
                }
            });
            $.each(formD[10].options, function(i, itemBarrio) {
                if (itemBarrio.text == item.barrio) {
                    itemBarrio.selected = true;
                }
            });
            $.each(formD[11].options, function(i, itemEjecutor) {
                if (itemEjecutor.text == item.ejecutor) {
                    itemEjecutor.selected = true;
                }
            });
        }
    });
    
    dialogEdit.dialog('open');
    mapaEdicion();

}

function editVia() {

}

   