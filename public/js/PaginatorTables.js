var _idTabla;
var ini = 0;
var fin = 2;
var trPerPg = 2;
var paginas = 0;

/**
 * Crea el paginador
 * @param {int} size Tamaño de JSON
 * @param {String} idTabla Id de la tabla
 * @returns {null}
 */
function crearPaginator(size,idTabla) {
    _idTabla = idTabla;
    paginas = Math.round((size) / trPerPg);
    var objDiv = jQuery('.pagination');
    var strPg = '<ul><li class="disabled"><a href="#" id="left">&Lt;</a></li>';
    for (var i = 1; i <= paginas; i++) {
        if(i === 1){
            strPg += '<li class="active"><a href="#" id="' + i + '">' + i + '</a></li>';
        }else{
            strPg += '<li><a href="#" id="' + i + '">' + i + '</a></li>';
        }
    }
    strPg += '<li><a href="#" id="rigth">&Gt;</a></li></ul>';
    objDiv.append(strPg);
    clickPg();
    if(ini === 0){
        showTrPagination(1);
    }
}

/**
 * Evento click para el paginador
 * @returns {null}
 */
function clickPg() {
    jQuery('.pagination ul > li > a').click(function() {
        var index = 0;
        if ((this.id != 1) || (this.id != paginas)) {
            jQuery('.pagination ul li').first().removeClass('disabled');
            jQuery('.pagination ul li').last().removeClass('disabled');
            index = this.id;
        }
        if(this.id == 1){
            jQuery('.pagination ul li').first().addClass('disabled');
            index = this.id;
        }
        if(this.id == 'left'){
            index = (fin/trPerPg) - 1;
        }
        if(this.id == 'rigth'){
            index = (fin/trPerPg) + 1;
        }
        if(this.id == paginas){
            jQuery('.pagination ul li').last().addClass('disabled');
        }
        jQuery('.pagination ul > li').removeClass('active');
        jQuery(this).parent().addClass('active');
        showTrPagination(index);
    });
}

/**
 * Muestra x filas de la tabla
 * @param {int} index
 * @returns {null}
 */
function showTrPagination(index) {
    fin = (index > 0) ? (index * trPerPg) : trPerPg;
    ini = fin - trPerPg;
    jQuery('#' + _idTabla + ' tbody tr').hide();
    jQuery.each(jQuery('#' + _idTabla + ' tbody tr'), function(i, item) {
        if (i >= ini && i < fin) {
            $(item).show();
        }
    });
}