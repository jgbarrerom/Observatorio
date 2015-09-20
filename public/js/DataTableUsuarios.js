jQuery.expr[":"].containsNoCase = function(el, i, m) {
    var search = m[3];
    if (!search)
        return false;
    return eval("/" + search + "/i").test($(el).text());
};
var allUsers;
var dialogEdit;
var dialogDelete;
var formIsValid;

jQuery().ready(function() {
    $("input,select").popover({
        placement: 'right',
        container: 'body'
    });
    formAdminValidate();
    loadUsers();
    createDialogs();
    filterTable();

});

function loadUsers() {
    $.ajax({
        url: '/admin/listaUsuario',
        type: 'POST',
        success: function(data, textStatus, jqXHR) {
            $('#titleTable').html('<p style="margin: 0px 18px 0px;">Lista de Usuarios</p>');
            $('#listUser > tbody').html('');
            allUsers = data;
            if (allUsers.Records.length > 0) {
                jQuery('a#1').parent().addClass('active');
                tablaPag();
                crearPaginator(allUsers.Records.length, 'listUser');
                $("td > img").click(function() {
                    if (this.getAttribute('class') === 'icon-pencil') {
                        editDialog(this.id);
                    }
                    if (this.getAttribute('class') === 'icon-trash') {
                        deletDialog(this.id);
                    }
                });
            } else {
                $('#listUser').append('<tr><td colspan="6" style="text-align:center">No existen usuarios</td></tr>');
            }
        }
    });
}

function tablaPag() {
    $('#listUser > tbody').html('');
    var textTable = '';
    var permiso = '';
    var editCol = '';
    var borrarCol = '';
    $.each(allUsers.Records, function(i, item) {
       
            textTable = '<tr><td>' + item.Nombre + '</td><td>' + item.Apellido + '</td><td>' + item.Correo + '</td><td>' + item.perfil + '</td>';
            $.each(item.permisos, function(i, itemP) {
                permiso += itemP.permiso + ',';
            });
            permiso = permiso.slice(0, -1);
            editCol = '<td><img title="Modificar" id="' + item.Id + '" style="cursor: pointer" class="icon-pencil"></td>';
            borrarCol = '<td><img title="Eliminar" id="' + item.Id + '" style="cursor: pointer" class="icon-trash"></td>'
            $('#listUser').append(textTable + '<td>' + permiso + '</td>' + editCol + '' + borrarCol + '</tr>');
            textTable = '';
            permiso = '';
            editCol = '';
            borrarCol = '';
    });
}

function editDialog(data) {
    var formD = $('#formAdmin')[0];
    $.each(allUsers.Records, function(i, item) {
        if (item.Id == data) {
            formD[0].value = item.Id;
            formD[1].value = item.Nombre;
            formD[2].value = item.Apellido;
            formD[3].value = item.Correo;
            $.each(formD[4].options, function(i, itemPerf) {
                if (itemPerf.text == item.perfil) {
                    itemPerf.selected = true;
                    return true;
                }
            });
            $.each(item.permisos, function(i, itemPer) {
                for (var i = 4; i < 8; i++) {
                    if (itemPer.Id == formD[i].value) {
                        formD[i].checked = true;
                    }
                }
            });
            return true;
        }
    });
    dialogEdit.dialog('open');
}

function deletDialog(data) {
    $("#deleteDiv p").attr('id', data);
    dialogDelete.dialog('open');
}
function deletUser() {
    $.ajax({
        url: '/admin/delete',
        type: 'POST',
        dataType: 'json',
        data: {'Id': $("#deleteDiv p").attr('id')},
        success: function(data, textStatus, jqXHR) {
            loadUsers();
            $("#deleteDiv").dialog('close');
        }
    });
}
function editUser() {
    var editData = JSON.parse(JSON.stringify($('#formAdmin').serializeArray()));
    $.ajax({
        url: "/admin/edit",
        type: 'POST',
        dataType: 'json',
        data: editData,
        success: function(data, textStatus, jqXHR) {
            loadUsers();
            showTrPagination(0);
            $('#formAdmin')[0].reset();
            dialogEdit.dialog('close');
        }
    });
}

function formAdminValidate() {

    formIsValid = $("#formAdmin").validate({
        errorPlacement: function(errorMap, errorList) {
            $(errorList).attr('data-content', $(errorMap).text());
            $(errorList).popover({
                trigger: 'focus',
                delay: {show: 100, hide: 200},
                placement: 'right',
                container: 'body'
            });
        },
        rules: {
            nombre: {required: true},
            apellido: {required: true},
            correo: {required: true, email: true},
            perfil: {required: true},
            'permisos[]': {required: true, minlength: 1}
        },
        messages: {
            nombre: {required: 'El nombre no puede ser vacio'},
            apellido: {required: 'El apellido no puede ser vacio'},
            correo: {required: 'El correo no puede ser vacio', email: 'La direccion de correo no es valida'},
            perfil: {required: 'Debe seleccionar un perfil'},
            'permisos[]': {required: 'Debe seleccionar al menos un permiso', minlength: 'Debe seleccionar al menos un permiso'},
        }
    });
}

function createDialogs() {
    dialogEdit = $('#dialog-edit').dialog({
        autoOpen: false,
        width: 'auto',
        resizable: false,
        modal: true,
        draggable: false,
        buttons: {
            "Guardar": function() {
                $('input,select').attr('data-content', '');
                if ($("#formAdmin").valid()) {
                    editUser();
                } else {
                    $('input,select').popover('show');
                }
            },
            Cancelar: function() {
                $('input,select').attr('data-content', '');
                dialogEdit.dialog("close");
            }
        },
        close: function() {
            formIsValid.resetForm();
            $('input,select').popover('destroy');
            $('input,select').attr('data-content', '');
            $('#formAdmin')[0].reset();
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
                deletUser();
            },
            "Cancelar": function() {
                dialogDelete.dialog("close");
            }
        }
    });
}

function filterTable() {
    $('#serch').click(function() {
        var textSerch = $('#txtSerch').val();
        if (textSerch.length > 0) {
            $("#listUser tbody tr").hide();
            if ($("#listUser tr td:containsNoCase('" + textSerch + "')").parent().length > 0) {
                $("#listUser tr td:containsNoCase('" + textSerch + "')").parent().show();
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