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
 * Orders
 *
 */
;(function($, undefined)
{
    /**
     * Init table
     * @var array
     */
    $.fn.loadTableOrders = function()
    {  
        var painel = Handlebars.compile($("#painel-"+tableOrders.id).html()),
        table = $("#"+tableOrders.id).DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: tableOrders.url,
                type: "POST",
                dataType: "json",
                headers: {'X-CSRF-TOKEN': tableOrders.token}
            },
            sScrollX: true,
            sScrollXInner: "100%",
            buttons: ['reset'],
            sPaginationType: "full_numbers",
            iDisplayLength: tableOrders.limit,
            sDom: 'CB<"clear"><"dataTables_header"lfr>t<"dataTables_footer"ip>',
            fnDrawCallback: function( oSettings ){
                if (!tableOrders.tableStyled){
                    $("#"+tableOrders.id).closest(".dataTables_wrapper").find(".dataTables_length select").addClass("select "+tableOrders.color+" glossy").styleSelect();
                    $("#btn-reset").addClass(tableOrders.color+" glossy");
                    tableOrders.tableStyled = true;
                }
            },
            columns:[
                {data: 'id', className:'align-center', orderable:false, searchable:false},
                {data: 'state', className:'align-center', orderable:false, searchable:false},
                {data: 'name', orderable:false, searchable:false},
                {data: 'profile', orderable:false, searchable:false},
                {data: 'payment', orderable:false, searchable:false},
                {data: 'subtotal', orderable:false, searchable:false},
                {data: 'status_label', orderable:false, searchable:false},
                {data: 'created_at', className:'align-center', orderable:false, searchable:false},
                {data:null, className:'details-control', orderable:false, searchable:false, defaultContent: ''}
            ]

        });
        $('#'+tableOrders.id).on('click', tableOrders.openDetails, function() {
            if (event.target !== this){
                return;
            }
            var tr = $(this).closest('tr'),
            row = table.row(tr);
            if (row.child.isShown()) {
                // Esta row já está aberta - fechá-la
                row.child.hide();
                tr.removeClass('shown');
                tr.children().removeClass(tableOrders.colorSel);
            } else {
                // Abrir esta row
                row.child(painel(row.data())).show();
                tr.addClass('shown');
                tr.children().addClass(tableOrders.colorSel);
            }
        });

        /**
         * Search
         */
        $(".dataTables_filter input")
            .unbind()
            .bind("input", function(e) {
                if(this.value.length >= 3 || e.keyCode == 13) {
                    table.search(this.value).draw();
                }
                if(this.value == "") {
                    table.search("").draw();
                }
                return;
            });


        /**
         *
         * @param idform
         */
        formOrders = function (ac, id) {

            var form = $('#form-'+id),
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
                        msgNotifica(true, data.message, true, false);
                        fechaModal();
                        table.ajax.reload();
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
         * @param url
         */
        deleteOrder = function(url)
        {
            $.modal.confirm(tableOrders.txtConfirm+'?', function(){
                $.ajax({
                    type: 'DELETE',
                    dataType: "json",
                    headers: {'X-CSRF-TOKEN':tableOrders.token},
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
                $.modal.alert(tableOrders.txtCancel);
            });
        }


        printerPdf = function (url) {
            $.ajax({
                type: 'GET',
                dataType: "json",
                url: url,
                success: function(data){
                    if(data.success == true){
                        window.open(data.pdf,'_blank');
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
         *
         * @param idform
         */
        formEditWishlist = function (idform) {

            var form = $('#' + idform),
                url = form.attr('action');
            $.ajax({
                type: 'PUT',
                dataType: "json",
                url: url,
                data: form.serialize(),
                beforeSend: function () {
                    setBtn(4, tableOrders.txtLoader, false, 'loader', 'btn-modal', false, 'silver');
                },
                success: function (data) {
                    if (data.success == true) {

                        msgNotifica(true, data.message, true, false);
                        fechaModal();
                        //table.ajax.reload();

                    } else {
                        msgNotifica(false, data.message, true, false);
                    }
                    setBtn(4, tableOrders.txtSave, true, 'icon-publish', 'btn-modal', false, 'blue');
                },
                error: function (xhr) {
                    setBtn(4, tableOrders.txtSave, true, 'icon-publish', 'btn-modal', false, 'blue');
                    ajaxFormError(xhr);
                }
            });
        }

    }

})(jQuery);