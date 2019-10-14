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
 * Wishlists
 *
 */
;(function($, undefined)
{
    /**
     * Init table
     * @var array
     */
    $.fn.loadTableWishlist = function()
    {  
        var painel = Handlebars.compile($("#painel-"+tableWishlist.id).html()),
        table = $("#"+tableWishlist.id).DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: tableWishlist.url,
                type: "POST",
                dataType: "json",
                headers: {'X-CSRF-TOKEN': tableWishlist.token}
            },
            sScrollX: true,
            sScrollXInner: "100%",
            buttons: ['reset'],
            sPaginationType: "full_numbers",
            iDisplayLength: tableWishlist.limit,
            sDom: 'CB<"clear"><"dataTables_header"lfr>t<"dataTables_footer"ip>',
            fnDrawCallback: function( oSettings ){
                if (!tableWishlist.tableStyled){
                    $("#"+tableWishlist.id).closest(".dataTables_wrapper").find(".dataTables_length select").addClass("select "+tableWishlist.color+" glossy").styleSelect();
                    $("#btn-reset").addClass(tableWishlist.color+" glossy");
                    tableWishlist.tableStyled = true;
                }
            },
            columns:[
                {data: 'total', className:'align-center'},
                {data: 'first_name'},
                {data: 'admin'},
                {data:null, className:'details-control', orderable:false, searchable:false, defaultContent: ''}
            ],
            order: [[0, 'desc']]

        });
        $('#'+tableWishlist.id).on('click', tableWishlist.openDetails, function() {
            if (event.target !== this){
                return;
            }
            var tr = $(this).closest('tr'),
            row = table.row(tr);
            if (row.child.isShown()) {
                // Esta row já está aberta - fechá-la
                row.child.hide();
                tr.removeClass('shown');
                tr.children().removeClass(tableWishlist.colorSel);
            } else {
                // Abrir esta row
                row.child(painel(row.data())).show();
                tr.addClass('shown');
                tr.children().addClass(tableWishlist.colorSel);
            }
        });

        /**
         *
         * @param id
         * @param url
         */
        reloadWishlist = function (id, url) {

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

        /**
         *
         * @param idform
         */
        formEditWishlist = function (idform) {

            var form = $('#'+idform),
                url  = form.attr('action');
            $.ajax({
                type: 'PUT',
                dataType: "json",
                url: url,
                data: form.serialize(),
                beforeSend: function() {
                    setBtn(4,tableWishlist.txtLoader,false,'loader','btn-modal',false,'silver');
                },
                success: function(data){
                    if(data.success == true){

                        msgNotifica(true, data.message, true, false);
                        fechaModal();
                        table.ajax.reload();

                    } else {
                        msgNotifica(false, data.message, true, false);
                    }
                    setBtn(4,tableWishlist.txtSave,true,'icon-publish','btn-modal',false,'blue');
                },
                error: function(xhr){
                    setBtn(4,tableWishlist.txtSave,true,'icon-publish','btn-modal',false,'blue');
                    ajaxFormError(xhr);
                }
            });
        }







        deleteWiswlistProduct = function(li, url)
        {
            $.modal.confirm(tableWishlist.txtConfirm+'?', function(){
                $.ajax({
                    type: 'DELETE',
                    dataType: "json",
                    headers: {'X-CSRF-TOKEN':tableWishlist.token},
                    url: url,
                    success: function(data){
                        if(data.success == true){
                            $("#"+li).hide();
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
                $.modal.alert(tableWishlist.txtCancel);
            });
        }


        /**
         *
         * @param url
         * @param id
         */
        deleteWishlistAll = function (url, id) {
            $.modal.confirm(tableWishlist.txtConfirmAll+'?', function(){
                $.ajax({
                    type: 'DELETE',
                    dataType: "json",
                    headers: {'X-CSRF-TOKEN':tableWishlist.token},
                    url: url,
                    success: function(data){
                        if(data.success == true){
                            table.ajax.reload();
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
                $.modal.alert(tableWishlist.txtCancel);
            });
        }


        /**
         *
         * @param id
         * @param url
         */
        saveWishlist = function (id, url) {
            $.modal.confirm(tableWishlist.txtConfirmOrder, function(){
                $.ajax({
                    type: 'GET',
                    dataType: "json",
                    url: url,
                    success: function(data){
                        if(data.success == true){
                            table.ajax.reload();
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
                //$.modal.alert(tableWishlist.txtCancel);
            });
        }



    }

})(jQuery);


;(function($, undefined)
{
    /**
     * Init table
     * @var array
     */
    $.fn.loadTableProducts = function(id,user,url,token)
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
             headers: {'X-CSRF-TOKEN': token}
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
             row.child( htmlWiswlist( row.data() ) ).show();

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
         *
         * @param data
         * @returns {string}
         */
        htmlWiswlist = function ( data ) {

         var click = "addWiswlist('form-add-wishlist-"+data.id+"','"+data.id+"')";

         var form =  '<form id="form-add-wishlist-'+data.id+'" method="post" action="'+data.action+'" class="columns" onsubmit="return false">'+
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
         */
        addWiswlist = function(idform, id){
            var form = $('#'+idform),
                url  = form.attr('action');
            $.ajax({
                type: 'POST',
                dataType: "json",
                url: url,
                data: form.serialize(),
                beforeSend: function() {
                    setBtn(4,tableWishlist.txtLoader,false,'loader','btn-modal-'+id,false,'silver');
                },
                success: function(data){
                    if(data.success == true){
                        reloadWishlist(user,data.reload);
                        msgNotifica(true, data.message, true, false);
                        fechaModal();
                    } else {
                        msgNotifica(false, data.message, true, false);
                    }
                    setBtn(4,tableWishlist.txtSave,true,'icon-publish','btn-modal-'+id,false,'blue');
                },
                error: function(xhr){
                    setBtn(4,tableWishlist.txtSave,true,'icon-publish','btn-modal-'+id,false,'blue');
                    ajaxFormError(xhr);
                }
            });
        }









    }

})(jQuery);

