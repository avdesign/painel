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
     * @param ac
     * @param refresh
     */
    formNotes = function(ac, url_load)
    {
        var form = $('#form-'+tableNotes.id),
            url  = form.attr('action'),
            txt;
        (ac == 'create' ? txt = tableNotes.txtSave : txt = tableNotes.txtUpdate);
        $.ajax({
            type: 'POST',
            dataType: "json",
            url: url,
            data: form.serialize(),
            beforeSend: function() {
                setBtn(4,tableNotes.txtLoad,false,'loader','btn-modal',false,'silver');
            },
            success: function(data){
                if(data.success == true){
                    setBtn(4,txt,true,'icon-publish','btn-modal',false,'blue');
                    msgNotifica(true, data.message, true, false);
                    fechaModal();
                    refreshNotes(url_load);
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
    refreshNotes = function (url) {
        $.ajax({
            url: url,
            success: function (response) {
                $("#refresh-"+tableNotes.id+'-'+tableNotes.user_id).html(response);
            },
            error: function (xhr) {
                ajaxFormError(xhr);
            }
        });
    }


    /**
     *  Delete Account
     * @param url
     * @param name
     */
    deleteNote = function(id,url)
    {
        $.modal.confirm(tableNotes.txtConfirm, function(){
            $.ajax({
                type: 'DELETE',
                dataType: "json",
                headers: {'X-CSRF-TOKEN':tableNotes.token},
                url: url,
                success: function(data){
                    if(data.success == true){
                        $("#note-"+id).hide();
                        msgNotifica(true, data.message, true, false);
                    } else {
                        msgNotifica(false, data.message, true, false);
                    }
                },
                error: function(data){
                    msgNotifica(false, tableAccount.txtError, true, false);
                }
            });

        }, function(){
            $.modal.alert(tableAccount.txtCancel);
        });
    };

})(jQuery);


