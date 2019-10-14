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
    $.fn.loadTableOrdersExcludeds = function()
    {
        var painel = Handlebars.compile($("#painel-"+tableOrderExcluded.id).html()),
            table = $("#"+tableOrderExcluded.id).DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: tableOrderExcluded.url,
                    type: "POST",
                    dataType: "json",
                    headers: {'X-CSRF-TOKEN': tableOrderExcluded.token}
                },
                sScrollX: true,
                sScrollXInner: "100%",
                buttons: ['reset'],
                sPaginationType: "full_numbers",
                iDisplayLength: tableOrderExcluded.limit,
                sDom: 'CB<"clear"><"dataTables_header"lfr>t<"dataTables_footer"ip>',
                fnDrawCallback: function( oSettings ){
                    if (!tableOrderExcluded.tableStyled){
                        $("#"+tableOrderExcluded.id).closest(".dataTables_wrapper").find(".dataTables_length select").addClass("select "+tableOrderExcluded.color+" glossy").styleSelect();
                        $("#btn-reset").addClass(tableOrderExcluded.color+" glossy");
                        tableOrderExcluded.tableStyled = true;
                    }
                },
                columns:[
                    {data: 'id', className:'align-center'},
                    {data: 'state', className:'align-center'},
                    {data: 'user_id'},
                    {data: 'profile'},
                    {data: 'config_form_payment_id'},
                    {data: 'price_card'},
                    {data: 'config_status_payment_id'},
                    {data: 'created_at', className:'align-center'},
                    {data:null, className:'details-control', orderable:false, searchable:false, defaultContent: ''}
                ],
                order: [[0, 'desc']]

            });
        $('#'+tableOrderExcluded.id).on('click', tableOrderExcluded.openDetails, function() {
            if (event.target !== this){
                return;
            }
            var tr = $(this).closest('tr'),
                row = table.row(tr);
            if (row.child.isShown()) {
                // Esta row já está aberta - fechá-la
                row.child.hide();
                tr.removeClass('shown');
                tr.children().removeClass(tableOrderExcluded.colorSel);
            } else {
                // Abrir esta row
                row.child(painel(row.data())).show();
                tr.addClass('shown');
                tr.children().addClass(tableOrderExcluded.colorSel);
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
         *  Delete Account
         * @param url
         * @param name
         */
        reactivateOrder = function(id,url)
        {
            $.modal.confirm(tableOrderExcluded.txtReactivate+' '+id+'?', function(){
                $.ajax({
                    type: 'POST',
                    dataType: "json",
                    headers: {'X-CSRF-TOKEN':tableOrderExcluded.token},
                    data: {'id':id},
                    url: url,
                    success: function(data){
                        if(data.success == true){
                            table.ajax.reload();
                            msgNotifica(true, data.message, true, false);
                        } else {
                            msgNotifica(false, data.message, true, false);
                        }
                    },
                    error: function(data){
                        msgNotifica(false, tableOrderExcluded.txtError, true, false);
                    }
                });

            }, function(){
                $.modal.alert(tableOrderExcluded.txtCancelReactivate);
            });
        };

    }

})(jQuery);
