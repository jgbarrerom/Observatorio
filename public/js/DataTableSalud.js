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
jQuery().ready(function() {
    $("#estado").change(function() {
        if (this.value == 3) {
            $("#resultados").css("display", "block");
        }else{
             $("#resultados").css("display", "none");
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
        width: 1300,
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
        beforeSend: function(xhr) {
            $('#titleTable').html('<img src="/img/loaderUser.gif">');
        },
        success: function(data, textStatus, jqXHR) {
            $('#titleTable').html('<p style="margin: 0px 18px 0px;">Lista de Proyectos </p>');
            var textTable = '';
            var editDelete = '';
            $('#listsaludPro > tbody').html('');
            allProySalud = data;
            if (allProySalud.Records.length > 0) {
                $.each(data.Records, function(i, item) {
                    textTable = '<tr><td>' + item.vigencia
                            + '</td><td>' + item.numero
                            + '</td><td>' + item.objetoContractual
                            + '</td><td>' + item.ejecutor + '</td>';
                    editDelete = '<td style="width: 2%;"><img id="' + item.id + '" style="cursor: pointer" title="Editar proyecto" class="icon-pencil"></i></td>\n\
                    <td style="width: 2%;"><img id="' + item.id + '" style="cursor: pointer" title="Borrar proyecto" class="icon-trash"></i></td>\n\
                    <td style="width: 2%;"><img id="' + item.id + '" style="cursor: pointer" title="Ver Actividades" class="icon-calendar"></i></td>';
                    $('#listsaludPro').append(textTable + '' + editDelete + '</tr>');
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
                $('#listsaludPro').append('<tr><td colspan="6" style="text-align:center">No existen proyectos</td></tr>');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Estamos presentando inconvenientes de conexion');
        }
    });
}

function editDialog(data) {


//  validaciones de formulario 
    jQuery('#listsaludPro').validate({
        errorClass: 'text-error',
        rules: {
            presupuesto: {required: true, maxlength: 20},
            estado: {required: true, maxlength: 20},
            vigencia: {required: true, maxlength: 20},
            objetivo: {required: true, maxlength: 20},
            objetoC: {required: true, maxlength: 20},
            fechaIni: {required: true, maxlength: 20},
            plazoEj: {required: true, maxlength: 20},
            numero: {required: true, maxlength: 20},
            ejecutor: {required: true, maxlength: 20},
            segmento: {required: true, maxlength: 20},
        },
        messages: {
            presupuesto: {required: 'La direccion del tramo es requerida', maxlength: 'admiten 20 caracteres'},
            estado: {required: 'La direccion de inicio es requerida', maxlength: 'admiten 20 caracteres'},
            vigencia: {required: 'La direccion final es requerida', maxlength: 'admiten 20 caracteres'},
            objetivo: {required: 'codigo CIV requerido', maxlength: 'admiten 20 caracteres'},
            objetoC: {required: 'presupuesto requerido', maxlength: 'admiten 20 caracteres'},
            fechaini: {required: 'Seleccione un tipo de obra', maxlength: 'admiten 20 caracteres'},
            plazoEj: {required: 'Seleccione un estado', maxlength: 'admiten 20 caracteres'},
            numero: {required: 'Seleccione un barrio', maxlength: 'admiten 20 caracteres'},
            ejecutor: {required: 'El largo del tramo es requerido', maxlength: 'admiten 20 caracteres'},
            segmento: {required: 'El ancho del tramo es requerido', maxlength: 'admiten 20 caracteres'},
        }
    });
    var formD = $('#formSalud')[0];
    $.each(allProySalud.Records, function(i, item) {
        if (item.id == data) {
            formD[0].value = item.id;
            formD[3].value = item.presupuesto;
            formD[4].value = item.nombre;
            //FALTA EL ESTADO A EDITAR
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
                if (itemEstado.text == item.segmento) {
                    itemEstado.selected = true;
                }
            });
        }
    });
    dialogEdit.dialog('open');
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
                $('#formSalud')[0].reset();
                dialogEdit.dialog('close');
                loadSaludPro();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("no se ha enviado bien");
            }
        });
    }
}
function activities(id) {
    relocate('/salud/actividades', {'id': id});
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