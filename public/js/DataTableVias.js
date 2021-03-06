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
var dialogVer;
var dialogDelete;
var ps;
jQuery().ready(function() {
    //loadVias();
    filterTable();

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
            $('#lista-fotos-gd').html('');
            $("#googleMapSalida").html(" ");
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
            $("#googleMapSalida").html(" ");
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
                deletVia();
            },
            "Cancelar": function() {
                dialogDelete.dialog("close");
            }
        }
    });

});

function loadVias() {
    $.ajax({
        url: '/vias/listadoViasJson',
        type: 'POST',
        success: function(data, textStatus, jqXHR) {
            $('#titleTable').html('<p style="margin: 0px 18px 0px;">Lista de Vias</p>');
            var textTable = '';
            var deleteVia = '';
            var editarVia = '';
            $('#listVias > tbody').html('');
            allVias = data;
            if (allVias.Records.length > 0) {
                $.each(data.Records, function(i, item) {
                    textTable = '<tr><td>' + item.anio
                            + '</td><td>' + item.barrio
                            + '</td><td>' + item.civ
                            + '</td><td>' + item.dirInicio
                            + '</td><td>' + item.dirFinal
                            + '</td><td>' + item.tramo + '</td>';
                    editarVia = (edit)? '<td style="width: 2%;"><img id="' + item.id + '" style="cursor: pointer" class="icon-pencil"></td>':'';
                    deleteVia = (borr)? '<td style="width: 2%;"><img id="' + item.id + '" style="cursor: pointer" class="icon-trash"></td>':'';
                    $('#listVias').append(textTable + '' + editarVia + '' + deleteVia + '</tr>');
                    textTable = '';
                    editarVia = '';
                    deleteVia = '';
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
        }
    });
}
function loadViasPublic() {
    $.ajax({
        url: '/home/listadoViasJson',
        type: 'POST',
        success: function(data, textStatus, jqXHR) {
            $('#titleTable').html('<p style="margin: 0px 18px 0px;">Lista de Vias</p>');
            var textTable = '';
            var editDelete = '';
            $('#listVias > tbody').html('');
            allVias = data;
            if (allVias.Records.length > 0) {
                $.each(data.Records, function(i, item) {
                    textTable = '<tr><td>' + item.anio
                            + '</td><td>' + item.barrio
                            + '</td><td>' + item.civ
                            + '</td><td>' + item.dirInicio
                            + '</td><td>' + item.dirFinal
                            + '</td><td>' + item.tramo + '</td>';
                    ver = '<td style="width: 2%;"><img id="' + item.id + '" style="cursor: pointer" class="icon-plus" title="Ver Mas Información"></td>';
                    $('#listVias').append(textTable + '' + ver + '</tr>');
                    textTable = '';
                    ver = '';
                });
                $("td > img").click(function() {
                    if (this.getAttribute('class') === 'icon-plus') {
                        verDialog(this.id);
                    }
                });
            } else {
                $('#listVias').append('<tr><td colspan="6" style="text-align:center">No existen proyectos</td></tr>');
            }
        }
    });
}

function editDialog(data) {
    //  validaciones de formulario 
    jQuery('#FormGuardarVia').validate({
        errorClass: 'text-error',
        rules: {
            tramo: {required: true, maxlength: 20},
            dirInicio: {required: true, maxlength: 20},
            dirFinal: {required: true, maxlength: 20},
            civ: {required: true, maxlength: 20},
            presupuesto: {required: true, maxlength: 20, number: true},
            tipoObra: {required: true, maxlength: 20},
            estado: {required: true, maxlength: 20},
            barrio: {required: true, maxlength: 20},
            largo: {required: true, maxlength: 20, number: true},
            ancho: {required: true, maxlength: 20, number: true},
            interventor: {required: true, maxlength: 20}
        },
        messages: {
            tramo: {required: 'La direccion del tramo es requerida', maxlength: 'admiten 20 caracteres'},
            dirInicio: {required: 'La direccion de inicio es requerida', maxlength: 'admiten 20 caracteres'},
            dirFinal: {required: 'La direccion final es requerida', maxlength: 'admiten 20 caracteres'},
            civ: {required: 'codigo CIV requerido', maxlength: 'admiten 20 caracteres'},
            presupuesto: {required: 'presupuesto requerido', number: 'el valor debe ser numerico', maxlength: 'admiten 20 caracteres'},
            tipoObra: {required: 'Seleccione un tipo de obra', maxlength: 'admiten 20 caracteres'},
            estado: {required: 'Seleccione un estado', maxlength: 'admiten 20 caracteres'},
            barrio: {required: 'Seleccione un barrio', maxlength: 'admiten 20 caracteres'},
            largo: {required: 'El largo del tramo es requerido', number: 'el valor debe ser numerico', maxlength: 'admiten 20 caracteres'},
            ancho: {required: 'El ancho del tramo es requerido', number: 'el valor debe ser numerico', maxlength: 'admiten 20 caracteres'},
            interventor: {required: 'El interventor de la obra es requerido', maxlength: 'admiten 20 caracteres'}
        }
    });
    var formD = $('#FormGuardarVia')[0];
    $.each(allVias.Records, function(i, item) {
        if (item.id == data) {
            formD[0].value = item.id;
            formD[2].value = item.tramo;
            formD[3].value = item.dirInicio;
            formD[4].value = item.dirFinal;
            formD[5].value = item.civ;
            formD[6].value = item.presupuesto;
            formD[7].value = item.largo;
            formD[8].value = item.ancho;
            formD[13].value = item.interventor;
            formD[14].value = item.coordenadas;

            $.each(formD[1].options, function(i, itemAnio) {
                if (itemAnio.text == item.anio) {
                    formD[1].value = item.anio;
                }
            });
            $.each(formD[9].options, function(i, itemTipo) {
                if (itemTipo.text == item.tipo) {
                    itemTipo.selected = true;
                }
            });
            $.each(formD[10].options, function(i, itemEstado) {
                if (itemEstado.text == item.estado) {
                    itemEstado.selected = true;
                }
            });
            $.each(formD[11].options, function(i, itemBarrio) {
                if (itemBarrio.text == item.barrio) {
                    itemBarrio.selected = true;
                }
            });
            $.each(formD[12].options, function(i, itemEjecutor) {
                if (itemEjecutor.text == item.ejecutor) {
                    itemEjecutor.selected = true;
                }
            });
            ps = item.idp;

        }
    });
    cargarFotografias(ps);
    subirFotografias();
    $("#btn-subirFotos").on("click", function() {
        $('#dir-photos').val(ps);
        var formData = new FormData($("#formulario-fotos")[0]);
        $.ajax({
            url: '/vias/saveeditphotos',
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
    dialogEdit.dialog('open');
    mapaEdicion();

}

function editVia() {
    if (jQuery("#FormGuardarVia").valid()) {
        establecerCoordenadas();
        if (shapes.length > 0) {
            var editData = JSON.parse(JSON.stringify($('#FormGuardarVia').serializeArray()));
            $.ajax({
                url: "/vias/editarproyecto",
                type: 'POST',
                dataType: 'json',
                data: editData,
                success: function(data, textStatus, jqXHR) {
                    loadVias();
                    $('#FormGuardarVia')[0].reset();
                    dialogEdit.dialog('close');
                }
            });
            clearSelection();
            clearShapes();
        } else {
            alert('Debe Ingresar las coordenadas en el mapa');
        }
        //alert($('#coordenadas').val());
    }
}
function verDialog(data) {
    $.each(allVias.Records, function(i, item) {
        if (item.id == data) {
            $('span[id=anio]').text(item.anio);
            $('span[id=civ]').text(item.civ);
            $('span[id=tramo]').text(item.tramo);
            $('span[id=dirInicio]').text(item.dirInicio);
            $('span[id=dirFinal]').text(item.dirFinal);
            $('span[id=estado]').text(item.estado);
            $('span[id=presupuesto]').text(item.presupuesto);
            $('span[id=ancho]').text(item.ancho);
            $('span[id=largo]').text(item.largo);
            $('span[id=civ]').text(item.civ);
            $('span[id=barrio]').text(item.barrio);
            $('span[id=barrio]').text(item.upz);
            $('span[id=ejecutor]').text(item.ejecutor);
            $('span[id=interventor]').text(item.interventor);
            $('input[id=coordenadas]').val(item.coordenadas);
            if (item.imagenes != "") {
                var imagenes = item.imagenes.split(",");
                var lista = "";
                $.each(imagenes, function(index, value) {
                    lista = lista + '<li style="display: inline;border:2px;margin:3px"><a href="' + value + '" rel="imagenes[gallery1]"><img src="' + value + '" style="width: 60px;height: 60px" /></a></li>';
                });
                $('ul[id=gallery]').html(lista);
            }
        }
    });

    dialogVer.dialog('open');
    $(document).ready(dibujarMapaSalida(true));
    galeria_animacion();
}

function editVia() {
    if (jQuery("#FormGuardarVia").valid()) {
        establecerCoordenadas();
        if (shapes.length > 0) {
            var editData = JSON.parse(JSON.stringify($('#FormGuardarVia').serializeArray()));
            $.ajax({
                url: "/vias/editarproyecto",
                type: 'POST',
                dataType: 'json',
                data: editData,
                success: function(data, textStatus, jqXHR) {
                    loadVias();
                    $('#FormGuardarVia')[0].reset();
                    dialogEdit.dialog('close');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert("no se ha enviado bien");
                }
            });
            clearSelection();
            clearShapes();
        } else {
            alert('Debe Ingresar las coordenadas en el mapa');
        }
        //alert($('#coordenadas').val());
    }
}

function deletDialog(data) {
    $("#deleteDiv p").attr('id', data);
    dialogDelete.dialog('open');
}
function deletVia() {
    $.ajax({
        url: '/vias/delete',
        type: 'POST',
        dataType: 'json',
        data: {'Id': $("#deleteDiv p").attr('id')},
        success: function(data, textStatus, jqXHR) {
            loadVias();
            $("#deleteDiv").dialog('close');
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
            $("#listVias tbody tr").show();
        }
    });
    $("#txtSerch").keyup(function(e) {
        if (e.keyCode == 27) {
            this.value = '';
            $("#listVias tbody tr").show();
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
function cargarFotografias(ps) {
    $.ajax({
        url: "/vias/fotografias",
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
                    url: "/vias/deleteImage",
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
