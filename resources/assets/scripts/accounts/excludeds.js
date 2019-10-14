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
 * Accounts
 *
 */
;(function($, undefined)
{
    /**
     * Init table
     * @var array
     */
    $.fn.loadTableAccountsExcludeds = function() {
        var painel = Handlebars.compile($("#painel-" + tableAccountExcluded.id).html()),
            table = $("#" + tableAccountExcluded.id).DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: tableAccountExcluded.url_excludeds,
                    type: "POST",
                    dataType: "json",
                    headers: {'X-CSRF-TOKEN': tableAccountExcluded.token}
                },
                sScrollX: true,
                sScrollXInner: "100%",
                buttons: ['reset'],
                sPaginationType: "full_numbers",
                iDisplayLength: tableAccountExcluded.limit,
                sDom: 'CB<"clear"><"dataTables_header"lfr>t<"dataTables_footer"ip>',
                fnDrawCallback: function (oSettings) {
                    if (!tableAccountExcluded.tableStyled) {
                        $("#" + tableAccountExcluded.id).closest(".dataTables_wrapper").find(".dataTables_length select").addClass("select " + tableAccountExcluded.color + " glossy").styleSelect();
                        $("#btn-reset").addClass(tableAccountExcluded.color + " glossy");
                        tableAccountExcluded.tableStyled = true;
                    }
                },
                columns:[
                    {data: 'id', className:'align-center'},
                    {data: 'profile_id'},
                    {data: 'first_name'},
                    {data: 'visits', className:'align-center'},
                    {data: 'admin'},
                    {data: 'active', className:'align-center'},
                    {data:null, className:'details-control', orderable:false, searchable:false, defaultContent: ''}
                ],
                order: [[0, 'desc']]

            });
        $('#' + tableAccountExcluded.id).on('click', tableAccountExcluded.openDetails, function () {
            if (event.target !== this) {
                return;
            }
            var tr = $(this).closest('tr'),
                row = table.row(tr);
            if (row.child.isShown()) {
                // Esta row já está aberta - fechá-la
                row.child.hide();
                tr.removeClass('shown');
                tr.children().removeClass(tableAccountExcluded.colorSel);
            } else {
                // Abrir esta row
                row.child(painel(row.data())).show();
                tr.addClass('shown');
                tr.children().addClass(tableAccountExcluded.colorSel);
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
        reactivateAccount = function(id,url, name)
        {
            $.modal.confirm(tableAccountExcluded.txtReactivate+' '+name+'?', function(){
                $.ajax({
                    type: 'POST',
                    dataType: "json",
                    headers: {'X-CSRF-TOKEN':tableAccountExcluded.token},
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
                        msgNotifica(false, tableAccountExcluded.txtError, true, false);
                    }
                });

            }, function(){
                $.modal.alert(tableAccountExcluded.txtCancelReactivate);
            });
        };


    }
})(jQuery);


