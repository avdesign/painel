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
 * PagSeguro
 *
 */
;(function($, undefined)
{
    /**
     * Confirm Cancel
     * @param form id
     */
    confirmCancel = function(id){
        $.modal.confirm('Confirma o Cancelamento?', function()
        {
            cancelTransaction(id);

        }, function()
        {
            $.modal.alert('A ação foi cancelada.');
        });
    };

    /**
     * Cancel Transaction
     * @param form id
     */
    cancelTransaction = function(id)
    {
        var form  = $('#'+id),
            url   = form.attr('action');
        $.ajax({
            type: 'POST',
            dataType: "json",
            url: url,
            data: form.serialize(),
            beforeSend: function() {
                setBtn(2,'Aguarde',false,'loader','submit-'+id,'btn-'+id);
            },
            success: function(data){
                if(data.success == true){
                    $('#submit-'+id).hide();
                    $('#status-'+data.id).text('Cancelada');
                    msgNotifica(true, data.message, true, false);
                } else {
                    msgNotifica(false, data.message, true, false);
                }
            },
            error: function(xhr){
                setBtn(2,'Cancelar Transação',true,'icon-cross-round','submit-'+id,'btn-'+id);
                ajaxFormError(xhr);
            }
        });
    }



    /**
     * Confirme Reverse
     * @param form id
     */
    confirmReverse = function(id){
        $.modal.confirm('Confirma o Estorno?', function()
        {
            cancelTransaction(id);

        }, function()
        {
            $.modal.alert('A ação foi cancelada.');
        });
    };

    /**
     * Reversal Transaction
     * @param form id
     */
    reverseTransaction = function(id)
    {
        var form  = $('#'+id),
            url   = form.attr('action');
        $.ajax({
            type: 'POST',
            dataType: "json",
            url: url,
            data: form.serialize(),
            beforeSend: function() {
                setBtn(2,'Aguarde',false,'loader','submit-'+id,'btn-'+id);
            },
            success: function(data){
                if(data.success == true){
                    $('#reverse-transaction-'+id).hide();
                    $('#status-'+data.id).text('Estornado');
                    msgNotifica(true, data.message, true, false);
                } else {
                    msgNotifica(false, data.message, true, false);
                }
            },
            error: function(xhr){
                setBtn(2,'Cancelar Transação',true,'icon-cross-round','submit-'+id,'btn-'+id);
                ajaxFormError(xhr);
            }
        });
    }


})(jQuery);