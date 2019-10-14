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
 * Contents
 *
 */
;(function($, undefined)
{

    formContents = function(ac, id, load)
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
                    $( "#list-contents" ).load( load, function() {
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
     *  Alterar ordem
     * @param id
     * @param url
     * @param token
     */
    updateOrder = function(id, url, token)
    {
        var order = $("#input-order-"+id).val();
        if (order.length == 1) {
            order = '0'+order;
        }
        $.ajax({
            type: 'POST',
            dataType: "json",
            headers: {'X-CSRF-TOKEN':token},
            url: url,
            data: {_method:'PUT', id:id, order:order},
            success: function(data){
                if(data.success == true){
                    $("#number-"+id).text(order);
                    $("#order-"+id).removeTooltip();
                    msgNotifica(true, data.message, true, false);
                } else {
                    msgNotifica(false, data.message, true, false);
                }
            },
            error: function(xhr){
                ajaxFormError(xhr);
            }
        });
    }


    /**
     * Status Content
     * @param int id
     * @param string url
     * @param string token
     */
    statusContent = function(id, url, token)
    {
        $.ajax({
            type: 'POST',
            dataType: "json",
            headers: {'X-CSRF-TOKEN':token},
            url: url,
            data: {_method:'put'},
            beforeSend: function() {
                $("#status-"+id).attr('class', 'button disabled');
            },
            success: function(data){
                if(data.success == true){
                    $("#status-"+id).attr('class', data.class);
                    $("#status-"+id).text(data.text);
                    msgNotifica(true, data.message, true, false);
                } else {
                    msgNotifica(false, data.message, true, false);
                }
            },
            error: function(xhr){
                ajaxFormError(xhr);
            }
        });
    }



    deleteContent = function(id, url, token)
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
