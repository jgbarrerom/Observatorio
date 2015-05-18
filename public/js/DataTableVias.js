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
            $('#form-viaEdit')[0].reset();
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
                    textTable = '<tr><td>' + item.proyectoviasCiv
                            + '</td><td>' + item.proyectoviasTramo
                            + '</td><td>' + item.proyectoviasDirinicio
                            + '</td><td>' + item.proyectoviasDirfinal + '</td>';
                    editDelete = '<td style="width: 2%;"><img id="' + item.Id + '" style="cursor: pointer" class="icon-pencil"></i></td><td style="width: 2%;"><img id="' + item.Id + '" style="cursor: pointer" class="icon-trash"></i></td>';
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

  function editDialog(data){
        var formD = $('#form-dialog')[0];
        dialogEdit.dialog('open');
    }
    
    function editVia(){
        
    }

   