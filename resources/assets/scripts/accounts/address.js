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
 * Address
 *
 */
;(function($, undefined)
{
    /**
     *
     * @param ac
     * @param refresh
     */
    formAddress = function(ac, url_load)
    {
        var form = $('#form-'+tableAddress.id),
            url  = form.attr('action'),
            txt;
        (ac == 'create' ? txt = tableAddress.txtSave : txt = tableAddress.txtUpdate);
        $.ajax({
            type: 'POST',
            dataType: "json",
            url: url,
            data: form.serialize(),
            beforeSend: function() {
                setBtn(4,tableAddress.txtLoad,false,'loader','btn-modal',false,'silver');
            },
            success: function(data){
                if(data.success == true){
                    setBtn(4,txt,true,'icon-publish','btn-modal',false,'blue');
                    msgNotifica(true, data.message, true, false);
                    fechaModal();
                    refreshAddress(url_load);
                } else {
                    setBtn(4,txt,true,'icon-publish','btn-modal',false,'blue');
                    msgNotifica(false, data.message, true, false);
                }
            },
            error: function(xhr){
                setBtn(4,txt,true,'icon-publish','btn-modal',false,'blue');
                ajaxFormError(xhr);
            }
        });
    };

    /**
     *
     * @param url
     */
    refreshAddress = function (url) {
        $.ajax({
            url: url,
            success: function (response) {
                $("#refresh-"+tableAddress.id+'-'+tableAddress.user_id).html(response);
            },
            error: function (xhr) {
                ajaxFormError(xhr);
            }
        });
    }
})(jQuery);


