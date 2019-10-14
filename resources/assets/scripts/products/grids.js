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
 * Grids Products
 *
 */
;(function($)
{
    /**
     * Date 06/13/2019
     *
     * @param id
     * @param ac
     * @param loading
     * @param btn
     */
    formGridProduct = function(id, ac, loading, btn)
    {
        var form = $('#form-'+id),
            url  = form.attr('action');
        $.ajax({
            type: 'POST',
            dataType: "json",
            url: url,
            data: form.serialize(),
            beforeSend: function() {
                setBtn(4,loading,false,'loader','btn-modal',false,'silver');
            },
            success: function(data){
                if(data.success == true){
                    if (data.load == true) {
                        if (ac == 'update') {
                            $("#grid-"+data.id).html(data.html);
                        }
                        if (ac == 'create') {
                            $("#grids-"+data.id).prepend(data.html);
                        }
                    }
                    msgNotifica(true, data.message, true, false);
                    fechaModal();
                } else {
                    setBtn(4,btn,true,'icon-redo','btn-modal',false,'blue');
                    msgNotifica(false, data.message, true, false);
                }
            },
            error: function(xhr){
                setBtn(4,btn,true,'icon-redo','btn-modal',false,'blue');
                ajaxFormError(xhr);
            }
        });
    }


    deleleGridProduct = function(id, url, token) {
        $.ajax({
            type: 'POST',
            dataType: "json",
            url: url,
            data: { _method: "DELETE", _token: token },
            success: function(data){
                if(data.success == true){
                    $("#grid-"+id).fadeAndRemove();
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






})(jQuery);