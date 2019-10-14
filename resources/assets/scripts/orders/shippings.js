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
 * Notes
 *
 */
;(function($, undefined)
{
    /**
     *
     * @param idform
     * @param order
     * @param reload
     */
    formOrderShipping = function(idform, order, reload) {
        var form = $('#form-'+idform),
            url  = form.attr('action');
        $.ajax({
            type: 'POST',
            dataType: "json",
            url: url,
            data: form.serialize(),
            beforeSend: function() {
                setBtn(4,tableOrders.txtLoader,false,'loader','btn-modal',false,'silver');
            },
            success: function(data){
                if(data.success == true){
                    reloadOrderShipping(idform,reload);
                    msgNotifica(true, data.message, true, false);
                    fechaModal();
                } else {
                    msgNotifica(false, data.message, true, false);
                }
                setBtn(4,tableOrders.txtSave,true,'icon-publish','btn-modal',false,'blue');
            },
            error: function(xhr){
                setBtn(4,tableOrders.txtSave,true,'icon-publish','btn-modal',false,'blue');
                ajaxFormError(xhr);
            }
        });
    }


    /**
     *
     * @param id
     * @param url
     */
    reloadOrderShipping = function (id, url) {
        $.ajax({
            url: url,
            success: function(response){
                $("#list-"+id).html(response);
            },
            error: function(response){
                msgNotifica(false, 'Houve um erro no servidor', true, false);
            }
        });
    }


})(jQuery);