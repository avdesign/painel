 /**
 *     ___ _    __   ____            _
 *    /   | |  / /  / __ \___  _____(_)____ ____ 
 *   / /| | | / /  / / / / _ \/ ___/ / __ `/ __ \
 *  / ___ | |/ /  / /_/ /  __(__  ) / /_/ / / / /
 * /_/  |_|___/  /_____/\___/____/_/\__, /_/ /_/ 
 *                                 /____/        
 * ------------ By Anselmo Velame --------------- 
 *
 * Module Colors Grup
 *
 */

;(function($)
{   
    formColorGrup = function(ac, id, loader,txt)
    {
        var form  = $('#form-'+id),
        token = $('#_token'),
        url   = form.attr('action');
        $.ajax({
            type: 'POST',
            headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            url: url,
            data: form.serialize(),
            beforeSend: function() {
                setBtn(4,loader,false,'loader','btn-modal',false,'silver');
            },
            success: function(json){
                if(json.success == true){ 
                    if (ac == 'update') {
                        $("#color_"+json.data.id).css('background-color', json.data.code);
                    } else {
                        $("#colors").prepend('<li>'+
                            '<button id="color_'+json.data.id+'" class="color" style="width:40px;height:40px;background-color:'+json.data.code+'"></button>'+
                            '<span class="controls">'+
                                '<span class="button-group compact">'+
                                    "<a href=\"javascript:abreModal('Editar "+json.data.name+"', '"+json.edit+"', '"+id+"', 2, 'true', 400, 250)\" class=\"button icon-pencil\" title=\"Editar\"></a>"+
                                    "<a href=\"javascript:deleteColorGrup('"+json.data.id+"', '"+json.delete+"', '"+json.token+"')\" class=\"button icon-trash red-gradient confirm\" title=\"Excluir\"></a>"+
                                '</span>'+
                            '</span>'+
                        '</li>');
                    }
                    fechaModal();
                    msgNotifica(true, json.message, true, false);
                } else {
                    setBtn(4,txt,true,'icon-publish','btn-modal',false,'blue');
                    msgNotifica(false, json.message, true, false);
                }
            },
            error: function(xhr){
                setBtn(4,txt,true,'icon-publish','btn-modal',false,'blue');
                ajaxFormError(xhr);
            }          
        });
    };

    deleteColorGrup = function(id, url, token)
    {
        $.ajax({
            type: 'POST',
            dataType: "json",
            headers: {'X-CSRF-TOKEN': token},
            data: {_method: 'delete'}, 
            url: url,
            success: function(json){
                if(json.success == true){
                    $("#color_"+id).hide();
                    msgNotifica(true, json.message, true, false);
                } else {
                    msgNotifica(false, json.message, true, false);
                }
            },
            error: function(json){
                msgNotifica(false, json.message, true, false);
            }
        });
    };

})(jQuery);