;(function($, undefined)
{
    /**
     * Init table
     * @var array
     */
    $.fn.loadTableProducts = function(id,order,url)
    {
        var dt = $('#'+id).DataTable( {
            processing: true,
            serverSide: true,
            sPaginationType: "full_numbers",
            sScrollX: true,
            sScrollXInner: "100%",
            lengthChange: false,
            info: false,
            ajax: {
                url: url,
                type: "POST",
                dataType: "json",
                headers: {'X-CSRF-TOKEN': tableOrderProduct.token}
            },
            columns:[
                {data:null, className:'details-control', orderable:false, searchable:false, defaultContent: ''},
                {data: 'image'},
                {data: 'code'},
                {data: 'color'}
            ],
            order: [[2, 'desc']]
        } );

        // Array to track the ids of the details displayed rows
        var detailRows = [];

        $('#'+id+' tbody').on( 'click', 'tr td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = dt.row( tr );
            var idx = $.inArray( tr.attr('id'), detailRows );

            if ( row.child.isShown() ) {
                tr.removeClass( 'details' );
                row.child.hide();

                // Remove from the 'open' array
                detailRows.splice( idx, 1 );
            }
            else {
                tr.addClass( 'details' );
                row.child( htmlOrderItem( row.data() ) ).show();

                // Add to the 'open' array
                if ( idx === -1 ) {
                    detailRows.push( tr.attr('id') );
                }
            }
        } );

        // On each draw, loop over the `detailRows` array and show any child rows
        dt.on( 'draw', function () {
            $.each( detailRows, function ( i, id ) {
                $('#'+id+' td.details-control').trigger( 'click' );
            } );
        } );


        /**
         * Search
         */
        $(".dataTables_filter input")
            .unbind()
            .bind("input", function(e) {
                if(this.value.length >= 3 || e.keyCode == 13) {
                    dt.search(this.value).draw();
                }
                if(this.value == "") {
                    dt.search("").draw();
                }
                return;
            });

        /**
         *
         * @param idform
         * @param id
         */
        addOrderItem = function(idform, id){
            var form = $('#'+idform),
                url  = form.attr('action');
            $.ajax({
                type: 'POST',
                dataType: "json",
                url: url,
                data: form.serialize(),
                beforeSend: function() {
                    setBtn(4,tableOrderProduct.txtLoader,false,'loader','btn-modal-'+id,false,'silver');
                },
                success: function(data){
                    if(data.success == true){
                        reloadOrderItem(order,data.reload);
                        msgNotifica(true, data.message, true, false);
                        fechaModal();
                    } else {
                        msgNotifica(false, data.message, true, false);
                    }
                    setBtn(4,tableOrderProduct.txtSave,true,'icon-publish','btn-modal-'+id,false,'blue');
                },
                error: function(xhr){
                    setBtn(4,tableOrderProduct.txtSave,true,'icon-publish','btn-modal-'+id,false,'blue');
                    ajaxFormError(xhr);
                }
            });
        }






    }

    /**
     *
     * @param data
     * @returns {string}
     */
    htmlOrderItem = function ( data ) {

        var click = "addOrderItem('form-list-items-"+data.id+"','"+data.id+"')";

        var form =  '<form id="form-list-items-'+data.id+'" method="post" action="'+data.action+'" class="columns" onsubmit="return false">'+
            '<input type="hidden" name="_token" value="'+data.token+'">'+
            '<fieldset class="fieldset">'+
            '<legend class="legend">Selecione a Grade</legend>'+
            data.grids+
            '<div class="align-right">'+
            '<button id="btn-modal-'+data.id+'" onclick="'+click+'" class="button blue-gradient icon-publish" title="Salvar">Salvar</button>'+
            '</div>'+
            '</fieldset>'+
            '</form><br/>';

        return form;

    }


    /**
     *
     * @param idform
     * @param id
     * @param order
     * @param reload
     */
    updateOrderItem = function(idform, id, order, reload) {
        var form = $('#'+idform),
            url  = form.attr('action');
        $.ajax({
            type: 'POST',
            dataType: "json",
            url: url,
            data: form.serialize(),
            beforeSend: function() {
                setBtn(4,tableOrderProduct.txtLoader,false,'loader','btn-modal-'+id,false,'silver');
            },
            success: function(data){
                if(data.success == true){
                    reloadOrderItem(order,reload);
                    msgNotifica(true, data.message, true, false);
                    fechaModal();
                } else {
                    msgNotifica(false, data.message, true, false);
                }
                setBtn(4,tableOrderProduct.txtSave,true,'icon-publish','btn-modal-'+id,false,'blue');
            },
            error: function(xhr){
                setBtn(4,tableOrderProduct.txtSave,true,'icon-publish','btn-modal-'+id,false,'blue');
                ajaxFormError(xhr);
            }
        });
    }




    /**
     *
     * @param id
     * @param url
     */
    reloadOrderItem = function (id, url) {
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


    deleteOrderItem = function(div, url)
    {
        $.modal.confirm(tableOrderProduct.txtRemove+'?', function(){
            $.ajax({
                type: 'DELETE',
                dataType: "json",
                headers: {'X-CSRF-TOKEN':tableOrderProduct.token},
                url: url,
                success: function(data){
                    if(data.success == true){
                        $("#"+div).hide();
                        msgNotifica(true, data.message, true, false);
                    } else {
                        msgNotifica(false, data.message, true, false);
                    }
                },
                error: function(xhr){
                    ajaxFormError(xhr);
                }
            });
        }, function(){
            $.modal.alert(tableOrderProduct.txtCancel);
        });
    }




})(jQuery);