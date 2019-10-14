/**
 *     ___ _    __   ____            _
 *    /   | |  / /  / __ \___  _____(_)____ ____
 *   / /| | | / /  / / / / _ \/ ___/ / __ `/ __ \
 *  / ___ | |/ /  / /_/ /  __(__  ) / /_/ / / / /
 * /_/  |_|___/  /_____/\___/____/_/\__, /_/ /_/
 *                                 /____/
 * ------------ By Anselmo Velame ---------------
 *
 * Sistma Administrativo
 * Templates
 *
 */
;(function($, undefined)
{

    formTemplate = function(ac, id, load)
    {
        var form = $('#form-'+id),
            url  = form.attr('action'),
            txt;
        (ac == 'create' ? txt = 'Salvar' : txt = 'Alterar');
        $.ajax({
            type: 'POST',
            dataType: "json",
            url: url,
            data: form.serialize(),
            beforeSend: function() {
                setBtn(4,'Aguarde',false,'loader','btn-modal',false,'silver');
            },
            success: function(data){
                if(data.success == true){
                    $( "#load-template" ).load( load, function() {
                        fechaModal();
                        msgNotifica(true, data.message, true, false);
                    });
                } else {
                    setBtn(4,txt,true,'icon-outbox','btn-modal',false,'blue');
                    msgNotifica(false, data.message, true, false);
                }
            },
            error: function(xhr){
                setBtn(4,txt,true,'icon-outbox','btn-modal',false,'blue');
                ajaxFormError(xhr);
            }
        });
    }


    /**
     * @param url
     */
    getModel = function(url)
    {
    }

    /**
     * Delete a page
     * @param id
     * @param url
     * @param token
     */
    deleteModule = function(id, url, token)
    {
        $.ajax({
            type: 'post',
            dataType: "json",
            data: {_method:'delete', _token:token },
            url: url,
            success: function(data){
                if(data.success == true){
                    fechaModal();
                    $("#btn-mod-"+id).hide();
                    msgNotifica(true, data.message, true, false);
                } else {
                    msgNotifica(false, data.message, true, false);
                }
            },
            error: function(data){
                msgNotifica(false, 'Houve um error no servidor!', true, false);
            }
        });

    }


    deletePage = function(id, url, token)
    {
        $.ajax({
            type: 'post',
            dataType: "json",
            data: {_method:'delete', _token:token },
            url: url,
            success: function(data){
                if(data.success == true){
                    $("#content-"+id).hide();
                    msgNotifica(true, data.message, true, false);
                } else {
                    msgNotifica(false, data.message, true, false);
                }
            },
            error: function(data){
                msgNotifica(false, 'Houve um error no servidor!', true, false);
            }
        });

    }



})(jQuery);
