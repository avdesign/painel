    /**
     * Form adicionar e alterar
     * @param ac 
    */
    function formPayments(ac, id, load)
    {
        var form = $('#form-'+id),
            url  = form.attr('action'),
            txt;
        (ac == 'create' ? txt = tableFormPayments.txtSave : txt = tableFormPayments.txtUpdate);

        $.ajax({
            type: 'POST',
            dataType: "json",
            url: url,
            data: form.serialize(),
            beforeSend: function() {
                setBtn(4,tableFormPayments.txtLoader,false,'loader','btn-modal',false,'silver');
            },
            success: function(data){
                if(data.success == true){
                    $( "#payments" ).load( load, function() {
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

    function deleteFormPayments(id, url, token)
    {
        $.ajax({
            type: 'DELETE',
            dataType: "json",
            headers: {'X-CSRF-TOKEN':token},
            url: url,
            beforeSend: function() {
                setBtn(4,tableFormPayments.txtLoader,false,'loader','btn-modal',false,'silver');
            },

            success: function(data){
                if(data.success == true){
                    $("#"+id).hide();
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

    function formPaymentsExcluded(url) {

        $.ajax({
            dataType: "html",
            url: url,
            beforeSend: function() {
                setBtn(4,tableFormPayments.txtLoader,false,'loader','btn-excluded',false,'silver');
            },

            success: function(data){
                $("#load-payments-excluded").html(data);
                setBtn(4,tableFormPayments.txtExcluded,true,'icon-trash','btn-excluded',false,'red');

            },
            error: function(data){
                msgNotifica(false, 'Houve um error no servidor!', true, false);
                setBtn(4,tableFormPayments.txtExcluded,true,'icon-trash','btn-excluded',false,'red');

            }
        });

    }

    function formPaymentsReactivate(id, url)
    {
        $.ajax({
            dataType: "json",
            url: url,
            beforeSend: function() {
                setBtn(4,tableFormPayments.txtLoader,false,'loader','btn-reactivate-'+id,false,'silver');
            },
            success: function(data){
                if(data.success == true){
                    $("#payment-"+id).hide();
                    msgNotifica(true, data.message, true, false);
                } else {
                    msgNotifica(false, data.message, true, false);
                }

            },
            error: function(data){
                msgNotifica(false, 'Houve um error no servidor!', true, false);
                setBtn(4,tableFormPayments.txtExcluded,true,'icon-trash','btn-excluded',false,'red');

            }
        });
    }
