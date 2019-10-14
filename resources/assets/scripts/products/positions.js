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
 * Images Positions
 *
 */
;(function($)
{
    /**
     * Update status posição.
     * @param int id
     * @param int url
     * @param int status
     * @param string token
     */
    statusPosition = function(id, url, sta, token)
    {
        var status;
        $.ajax({
            type: 'POST',
            headers: {'X-CSRF-TOKEN':token},
            dataType: "json",
            url: url,
            data: {_method:'put','active':sta},
            success: function(data){
                if(data.success == true){
                    $("#btns-"+id).html(data.html);
                    msgNotifica(true, data.message, true, false);
                } else {
                    msgNotifica(false, data.message, true, false);
                }
            },
            error: function(xhr){
                ajaxFormError(xhr);
            }
        });
    };


    /**
     * Remove image position.
     * @param int id
     * @param string url
     */

    deletePosition = function(id, url)
    {
        $.ajax({
            type: 'DELETE',
            dataType: "json",
            url: url,
            headers: {'X-CSRF-TOKEN':tableProduct.token},
            success: function(data){
                if(data.success == true){
                    $("#img-positions-"+id).hide();
                    msgNotifica(true, data.message, true, false);
                } else {
                    msgNotifica(false, data.message, true, false);
                }
            },
            error: function(xhr){
                ajaxFormError(xhr);
            }
        });
    };

    // Adiciona e alterar Posições
    $("body").on("click","#btn-position",function(e){
        $(this).parents("#form-positions").ajaxForm(opc_positions);
    });
    var opc_positions = {
        beforeSend: function() {
            setBtn(1,tableProduct.txtLoader,false,'loader','submit-position','btn-position');
        },
        success: function(data) {
            if (data.success == true) {
                if (data.ac == 'add') {
                    $("#gallery-positions-"+data.color_id).prepend(data.html);
                    fechaModal();
                }else if (data.ac == 'update') {
                    $("#img-positions-"+data.id).html(data.html);
                    fechaModal();
                } else {
                    setBtn(1,tableProduct.txtNext,true,'icon-forward','submit-position','btn-position');
                    var order = $('input[name="pos[order]"]').val(),
                        sum_order = parseFloat(order)+1;
                    $('input[name="pos[order]"]').val(sum_order);
                    $( "#upload_position" ).val('');
                }
                msgNotifica(true, data.message, true, false);
            };
        },
        complete: function(data) {
            setBtn(1,tableProduct.txtNext,true,'icon-forward','submit-position','btn-position');

        },
        error: function(xhr)
        {
            ajaxFormError(xhr);
            setBtn(1,tableProduct.txtNext,true,'icon-forward','submit-position','btn-position');
        }
    };

})(jQuery);