    jQuery.expr[":"].containsNoCase = function(el, i, m) {
        var search = m[3];
        if (!search) return false;
        return eval("/" + search + "/i").test($(el).text());
    };
    var allUsers;
    var dialogEdit;
    var dialogDelete;
    var formIsValid;
    jQuery().ready(function(){
        loadUsers();
        $.ajax({
            url:'/admin/serchPerfil',
            type:'POST',
            success: function (data, textStatus, jqXHR) {
                        var options = '';
                        $.each(data.Options,function(i,item){
                            options += '<option value="'+item.Value+'">'+item.DisplayText+'</option>';
                        });
                        $('#profiles').append(options);
            }
        });
        dialogEdit = $('#dialog-edit').dialog({
            autoOpen:false,
            width: 298,
            resizable:false,
            modal:true,
            draggable:false,
            buttons:{
                "Guardar":function(){
                    console.log(formIsValid.valid());
                },
                Cancelar:function(){
                    dialogEdit.dialog("close");
                }
            },
            close: function() {
                $('#formAdmin')[0].reset();
            }
        });
        dialogDelete = $("#deleteDiv").dialog({
            autoOpen:false,
            resizable:false,
            modal:true,
            draggable:false,
            closeText: "Cerrar",
            buttons:{
                "Eliminar":function(){deletUser();},
                "Cancelar":function(){dialogDelete.dialog("close");}
            }
        });
        $('#serch').click(function(){
            var textSerch = $('#txtSerch').val();
            if(textSerch.length > 0){
                $("#listUser tbody tr").hide();
                if($("#listUser tr td:containsNoCase('"+textSerch+"')").parent().length > 0){
                        $("#listUser tr td:containsNoCase('"+textSerch+"')").parent().show();
                }else{
                    //mostrar no se encontraron resultados
                }
            }else{
                $("#listUser tbody tr").show();
            }
        });
        $("#txtSerch").keyup(function(e){
            if(e.keyCode == 27){
                this.value = '';
                $("#listUser tbody tr").show();
            }
        });
    });
    
    function loadUsers(){
        $.ajax({
            url:'/admin/listaUsuario',
            type:'POST',
            beforeSend: function (xhr) {
                            $('#titleTable').html('<img src="/img/loaderUser.gif">');
            },
            success: function (data, textStatus, jqXHR) {
                            $('#titleTable').html('<p style="margin: 0px 18px 0px;">Lista de Usuarios</p>');
                            var textTable = '';
                            var permiso = '';
                            var editCol = '';
                            var borrarCol = '';
                            $('#listUser > tbody').html('');
                            allUsers = data;
                            if(allUsers.Records.length > 0){
                                $.each(data.Records,function (i,item){
                                    textTable = '<tr><td>'+item.Nombre+'</td><td>'+item.Apellido+'</td><td>'+item.Correo+'</td><td>'+item.perfil+'</td>';
                                    $.each(item.permisos,function(i,itemP){
                                        permiso += itemP.permiso+',';
                                    });
                                    permiso=permiso.slice(0,-1);
                                    //if(data.permisos.editar){
                                        editCol = '<td><img id="'+item.Id+'" style="cursor: pointer" class="icon-pencil"></td>';
                                    //if(data.permisos.borrar)    
                                        borrarCol = '<td><img id="'+item.Id+'" style="cursor: pointer" class="icon-trash"></td>'
                                    //}
                                    $('#listUser').append(textTable+'<td>'+permiso+'</td>'+editCol+''+borrarCol+'</tr>');
                                    textTable = '';
                                    permiso = '';
                                    editCol = '';
                                    borrarCol = '';
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
                                $('#listUser').append('<tr><td colspan="6" style="text-align:center">No existen usuarios</td></tr>');
                            }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                            alert('Estamos presentando inconvenientes de conexion');
            }
        });
    }
    
    function editDialog(data){
        formIsValid = $("#formAdmin").validate({
                            errorClass:'text-error',
                            rules:{
                                nombre:{required:true},
                                apellido:{required:true},
                                correo:{required:true},
                                perfil:{required:true}
                            },
                            messages:{
                                nombre:{required:'noooo'},
                                apellido:{required:'noooo'},
                                correo:{required:'noooo'},
                                perfil:{required:'noooo'}
                            }
                        });
        var formD = $('#formAdmin')[0];
        $.each(allUsers.Records,function(i,item){
            if(item.Id == data){
                formD[0].value = item.Id;
                formD[1].value = item.Nombre;
                formD[2].value = item.Apellido;
                formD[3].value = item.Correo;
                $.each(formD[4].options,function(i,itemPerf){
                    if(itemPerf.text == item.perfil){
                        formD[4].value = i+1;
                    }
                });
                $.each(item.permisos,function(i,itemPer){
                    for(var i=4;i<9;i++){
                        if(itemPer.Id == formD[i].value){
                            formD[i].checked = true;
                        }
                    }
                });
            }
        });
        dialogEdit.dialog('open');
    }
    
    function deletDialog(data){
        $("#deleteDiv p").attr('id',data);
        dialogDelete.dialog('open');
    }
    function deletUser(){
        $.ajax({
            url:'/admin/delete',
            type:'POST',
            dataType:'json',
            data:{'Id':$("#deleteDiv p").attr('id')},
            success: function (data, textStatus, jqXHR) {
                        loadUsers();
                        $("#deleteDiv").dialog('close');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                        
            }
        });
    }
    function editUser(){
        var editData = JSON.parse(JSON.stringify($('#formAdmin').serializeArray()));
        $.ajax({
            url: "/admin/edit",
            type: 'POST',
            dataType: 'json',
            data: editData,
            success: function (data, textStatus, jqXHR) {
                        loadUsers();
                        $('#formAdmin')[0].reset();
                        dialogEdit.dialog('close');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                        alert("no se ha enviado bien");
            }
        });
    }