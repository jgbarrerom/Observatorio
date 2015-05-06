var allVias;
    var dialogEdit;
    var dialogDelete;
    jQuery().ready(function(){
        loadUsers();
    });
    
    function loadUsers(){
        $.ajax({
            url:'/vias/listadoViasJson',
            type:'POST',
            beforeSend: function (xhr) {
                            $('#titleTable').html('<img src="/img/loaderUser.gif">');
                        },
            success: function (data, textStatus, jqXHR) {
                            $('#titleTable').html('<p style="margin: 0px 18px 0px;">Lista de Vias</p>');
                            var textTable = '';
                            var editDelete = '';
                            $('#listVias > tbody').html('');
                            allVias = data;
                            if(allVias.Records.length > 0){
                                $.each(data.Records,function (i,item){
                                    textTable = '<tr><td>'+item.proyectoviasCiv
                                            +'</td><td>'+item.proyectoviasTramo
                                            +'</td><td>'+item.proyectoviasDirinicio
                                            +'</td><td>'+item.proyectoviasDirfinal+'</td>';
                                    editDelete = '<td style="width: 2%;"><img id="'+item.Id+'" style="cursor: pointer" class="icon-pencil"></i></td><td style="width: 2%;"><img id="'+item.Id+'" style="cursor: pointer" class="icon-trash"></i></td>';
                                    $('#listVias').append(textTable+''+editDelete+'</tr>');
                                    textTable = '';
                                    editDelete = '';
                                });
                                $("td > img").click(function (){
                                    if(this.getAttribute('class') === 'icon-pencil'){
                                        editDialog(this.id);
                                    }
                                    if(this.getAttribute('class') === 'icon-trash'){
                                        deletDialog(this.id);
                                    }
                                });
                            }else{
                                $('#listVias').append('<tr><td colspan="6" style="text-align:center">No existen usuarios</td></tr>');
                            }
                        },
            error: function (jqXHR, textStatus, errorThrown) {
                            alert('Estamos presentando inconvenientes de conexion');
                        }
        });
    }
    
    function editDialog(data){
       
    }
    
   