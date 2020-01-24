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
 * Stock
 *
 */
;(function($)
{
    /**
     * Init table
     * @var array 
     */
    $.fn.loadTableStock = function()
    {  
        var table = $("#"+tableStock.id).DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: tableStock.url,
                type: "POST",
                dataType: "json",
                headers: {'X-CSRF-TOKEN': tableStock.token}
            },
            sScrollX: true,
            sScrollXInner: "100%",
            buttons: ['reset'],
            sPaginationType: "full_numbers",
            iDisplayLength: tableStock.limit,
            sDom: 'CB<"clear"><"dataTables_header"lfr>t<"dataTables_footer"ip>',
            fnDrawCallback: function( oSettings ){
                if (!tableStock.tableStyled){
                    $("#"+tableStock.id).closest(".dataTables_wrapper").find(".dataTables_length select").addClass("select "+tableStock.color+" glossy").styleSelect();
                    $("#btn-reset").addClass(tableStock.color+" glossy");
                    tableStock.tableStyled = true;
                }
            },
            columns:[
                { data: null, searchable:false, render: function ( data, type, row ) 
                    {
                        return data.image;
                    } 
                },
                {data: 'description'},
                {data: 'reference'},
                {data: 'grid'},
                {data: 'stock'},
                {data: 'quantity'},
                {
                    data: 'actions', 
                    className: 'align-right',
                    orderable: false,
                    searchable: false,
                    defaultContent: ''
                }
            ],
            order: [[0, 'desc']]

        });


        formStock = function(ac, id)
        {
            var form = $('#form-stock-'+id),
                url  = form.attr('action');
            $.ajax({
                type: 'POST',
                dataType: "json",
                url: url,
                data: form.serialize(),
                beforeSend: function() {
                    setBtn(4,tableStock.txtLoad,false,'loader','btn-modal',false,'silver');
                },
                success: function(data){
                    if(data.success == true){
                        $("#entry-"+id).text(data.entry);
                        $("#exit-"+id).text(data.exit);
                        $("#total-"+id).text(data.total);
                        fechaModal();
                        msgNotifica(true, data.message, true, false);
                    } else {
                        setBtn(4,tableStock.txtUpdate,true,'icon-outbox','btn-modal',false,'blue');
                        msgNotifica(false, data.message, true, false);
                    }
                },
                error: function(xhr){
                    setBtn(4,tableStock.txtUpdate,true,'icon-outbox','btn-modal',false,'blue');
                    ajaxFormError(xhr);
                }
            });
        }



        /**
         * Update Status Color.
         *
         * @param int id
         * @param string url
         * @param int sta
         * @param int cover
         * @param string token
         */
        statusCatalog = function(id, url, status, token)
        {
            $.ajax({
                type: 'POST',
                headers: {'X-CSRF-TOKEN':token},
                dataType: "json",
                url: url,
                data: {_method:'put', 'active':status},
                success: function(data){
                    if(data.success == true){
                        if ( typeof data.alert !== "undefined" && data.alert ) {
                            $.modal.alert(data.alert);
                        };


                        $("#status-"+id).html(data.html);
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


    }

})(jQuery);